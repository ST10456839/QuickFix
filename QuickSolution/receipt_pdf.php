<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function loadEnv($file) {
    if (!file_exists($file)) return;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

loadEnv(__DIR__ . '/.env');
require_once __DIR__ . '/vendor/autoload.php';

function buildReceiptPdf(array $booking): string {
    $lines = [
        'Laptop repair booking receipt',
        '',
        'Reference: ' . $booking['reference_number'],
        'Status: ' . $booking['status'],
        '',
        'CUSTOMER',
        'Name: ' . $booking['full_name'],
        'Phone: ' . $booking['phone'],
        'Email: ' . $booking['email'],
        'Submitted: ' . date('d M Y, H:i', strtotime($booking['created_at'] ?? 'now')),
        '',
        'REPAIR DETAILS',
        'Device: ' . $booking['laptop_brand'] . ($booking['laptop_model'] ? ' ' . $booking['laptop_model'] : ''),
        'Repair type: ' . ucfirst($booking['repair_category']),
        'Preferred date: ' . date('d M Y', strtotime($booking['repair_date'])),
        'Service: ' . ucfirst($booking['service_option']),
        'Time slot: ' . ($booking['time_slot'] ?: 'Not specified'),
        '',
        'Issue reported:',
        $booking['issue_description'] ?: 'Not provided',
    ];
    if (!empty($booking['collection_address'])) $lines[] = 'Collection address: ' . $booking['collection_address'];
    if (!empty($booking['staff_note'])) $lines[] = 'Technician note: ' . $booking['staff_note'];
    $lines[] = '';
    $lines[] = 'Keep this receipt as proof of your repair booking.';

    $escape = static function (string $value): string {
        $value = preg_replace('/[^\x20-\x7E]/', '?', $value);
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $value);
    };
    $content = "BT\n/F1 16 Tf\n50 760 Td\n(" . $escape('Quickfix Tech Solutions') . ") Tj\n/F2 12 Tf\n0 -24 Td\n";
    foreach ($lines as $index => $line) {
        if ($index > 0) $content .= "0 -18 Td\n";
        $content .= '(' . $escape($line) . ") Tj\n";
    }
    $content .= "ET\n";

    $objects = [
        '<< /Type /Catalog /Pages 2 0 R >>',
        '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
        '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R /F2 6 0 R >> >> /Contents 5 0 R >>',
        '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>',
        '<< /Length ' . strlen($content) . " >>\nstream\n" . $content . "endstream",
        '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
    ];
    $pdf = "%PDF-1.4\n";
    $offsets = [0];
    foreach ($objects as $number => $object) {
        $offsets[] = strlen($pdf);
        $pdf .= ($number + 1) . " 0 obj\n" . $object . "\nendobj\n";
    }
    $xref = strlen($pdf);
    $pdf .= "xref\n0 7\n0000000000 65535 f \n";
    for ($number = 1; $number <= 6; $number++) $pdf .= sprintf("%010d 00000 n \n", $offsets[$number]);
    return $pdf . "trailer\n<< /Size 7 /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";
}

function sendReceiptEmail(string $toEmail, string $customerName, array $booking, string $trackingPage): bool {
    $reference = $booking['reference_number'];

    $message = "Hello {$customerName},\n\n";
    $message .= "Your booking has been received successfully.\n\n";
    $message .= "Tracking reference: {$reference}\n";
    $message .= "Track your repair status here: {$trackingPage}\n\n";
    $message .= "Thank you for choosing Quickfix Tech Solutions.\n";

    // Build PDF content
    $pdfContent = buildReceiptPdf($booking);
    $pdfFilename = "repair-receipt-{$reference}.pdf";

    $fromEmail = $_ENV['SMTP_USER'] ?? ($_ENV['MAIL_FROM'] ?? ('noreply@' . ($_SERVER['SERVER_NAME'] ?? 'quickfix.local')));
    $fromName = $_ENV['SMTP_FROM_NAME'] ?? ($_ENV['MAIL_FROM_NAME'] ?? 'Quickfix Tech Solutions');
    $subject = "Booking Confirmation - {$reference}";

    // Attempt SMTP send using credentials from .env
    $smtpHost = $_ENV['SMTP_HOST'] ?? null;
    $smtpPort = (int)($_ENV['SMTP_PORT'] ?? 587);
    $smtpUser = $_ENV['SMTP_USER'] ?? null;
    $smtpPass = $_ENV['SMTP_PASSWORD'] ?? null;

    $sent = false;
    if ($smtpHost && $smtpUser && $smtpPass) {
        $sent = smtpSendMail(
            $smtpHost,
            $smtpPort,
            $smtpUser,
            $smtpPass,
            $fromEmail,
            $fromName,
            $toEmail,
            $subject,
            $message,
            $pdfFilename,
            $pdfContent
        );
    }

    // Log outcome
    $logEntry = "=== EMAIL SEND ATTEMPT === " . date('Y-m-d H:i:s') . "\n";
    $logEntry .= "To: {$toEmail}\n";
    $logEntry .= "From: {$fromName} <{$fromEmail}>\n";
    $logEntry .= "Subject: {$subject}\n";
    $logEntry .= "Sent via SMTP: " . ($sent ? 'yes' : 'no') . "\n";
    $logEntry .= "Attachment: {$pdfFilename} (size=" . strlen($pdfContent) . ")\n";
    $logEntry .= str_repeat('-', 60) . "\n";

    $logPaths = [
        __DIR__ . '/email_log.txt',
        (isset($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/email_log.txt' : null),
        sys_get_temp_dir() . '/quicksolution_email_log.txt'
    ];
    foreach ($logPaths as $logFile) {
        if (!$logFile) continue;
        $dir = dirname($logFile);
        if (!is_dir($dir)) @mkdir($dir, 0777, true);
        @file_put_contents($logFile, $logEntry, FILE_APPEND);
    }

    return $sent;
}

/**
 * Send email via SMTP with STARTTLS and AUTH LOGIN.
 * Returns true on success, false on failure.
 */
function smtpSendMail(string $host, int $port, string $user, string $pass, string $fromEmail, string $fromName, string $toEmail, string $subject, string $bodyPlain, string $attachmentName, string $attachmentContent): bool {
    $eol = "\r\n";
    $timeout = 30;
    $protocol = ($port === 465) ? 'ssl' : 'tcp';
    $remote = sprintf('%s://%s:%d', $protocol, $host, $port);

    $contextOpts = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];
    $context = stream_context_create($contextOpts);

    $socket = @stream_socket_client($remote, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);
    if (!$socket) {
        error_log("SMTP connect failed: {$errno} - {$errstr}");
        return false;
    }
    stream_set_timeout($socket, $timeout);

    $read = function() use ($socket) {
        $data = '';
        while (($line = fgets($socket, 515)) !== false) {
            $data .= $line;
            if (isset($line[3]) && $line[3] === ' ') break;
        }
        return $data;
    };
    $write = function($cmd) use ($socket, $eol) {
        fwrite($socket, $cmd . $eol);
    };

    // Read greeting
    $greeting = $read();

    // EHLO/HELO
    $write('EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
    $resp = $read();
    if (strpos($resp, '250') === false) {
        $write('HELO ' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        $resp = $read();
        if (strpos($resp, '250') === false) {
            error_log('SMTP HELO/EHLO failed: ' . $resp);
            fclose($socket);
            return false;
        }
    }

    // STARTTLS for non-SSL connections
    if ($protocol === 'tcp') {
        $write('STARTTLS');
        $resp = $read();
        if (strpos($resp, '220') !== false) {
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                error_log('Failed to enable TLS for SMTP connection');
                fclose($socket);
                return false;
            }
            // EHLO again after TLS
            $write('EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
            $resp = $read();
            if (strpos($resp, '250') === false) {
                error_log('SMTP EHLO failed after STARTTLS: ' . $resp);
                fclose($socket);
                return false;
            }
        }
    }

    // AUTH LOGIN
    $write('AUTH LOGIN');
    $resp = $read();
    if (strpos($resp, '334') === false) {
        error_log('SMTP AUTH not accepted: ' . $resp);
        fclose($socket);
        return false;
    }
    $write(base64_encode($user));
    $resp = $read();
    if (strpos($resp, '334') === false) {
        error_log('SMTP username not accepted: ' . $resp);
        fclose($socket);
        return false;
    }
    $write(base64_encode($pass));
    $resp = $read();
    if (strpos($resp, '235') === false) {
        error_log('SMTP authentication failed: ' . $resp);
        fclose($socket);
        return false;
    }

    // MAIL FROM / RCPT TO
    $write('MAIL FROM: <' . $fromEmail . '>');
    $resp = $read();
    if (strpos($resp, '250') === false) {
        error_log('MAIL FROM rejected: ' . $resp);
        fclose($socket);
        return false;
    }

    $write('RCPT TO: <' . $toEmail . '>');
    $resp = $read();
    if (strpos($resp, '250') === false && strpos($resp, '251') === false) {
        error_log('RCPT TO rejected: ' . $resp);
        fclose($socket);
        return false;
    }

    $write('DATA');
    $resp = $read();
    if (strpos($resp, '354') === false) {
        error_log('DATA command not accepted: ' . $resp);
        fclose($socket);
        return false;
    }

    // Build message with boundary
    $boundary = 'b_' . md5(uniqid((string)microtime(true), true));
    $headers = [];
    $headers[] = 'From: ' . $fromName . ' <' . $fromEmail . '>';
    $headers[] = 'To: ' . $toEmail;
    $headers[] = 'Subject: ' . $subject;
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';

    $message = implode($eol, $headers) . $eol . $eol;
    $message .= '--' . $boundary . $eol;
    $message .= 'Content-Type: text/plain; charset=UTF-8' . $eol;
    $message .= 'Content-Transfer-Encoding: 7bit' . $eol . $eol;
    $message .= $bodyPlain . $eol . $eol;

    $message .= '--' . $boundary . $eol;
    $message .= 'Content-Type: application/pdf; name="' . $attachmentName . '"' . $eol;
    $message .= 'Content-Transfer-Encoding: base64' . $eol;
    $message .= 'Content-Disposition: attachment; filename="' . $attachmentName . '"' . $eol . $eol;
    $message .= chunk_split(base64_encode($attachmentContent)) . $eol . $eol;
    $message .= '--' . $boundary . '--' . $eol . $eol;

    // Dot-stuff lines that begin with a dot
    $message = preg_replace('/^\./m', '..', $message);

    // Terminate DATA with CRLF.CRLF
    $message .= '.' . $eol;

    fwrite($socket, $message);
    $resp = $read();
    if (strpos($resp, '250') === false) {
        error_log('Message not accepted: ' . $resp);
        fclose($socket);
        return false;
    }

    $write('QUIT');
    $read();
    fclose($socket);
    return true;
}
?>
