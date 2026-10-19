<?php
/**
 * QuickFix REST API - shared bootstrap.
 *
 * Loaded by every endpoint. Provides JSON responses, database access,
 * server-side validation and Firebase ID-token verification.
 *
 * Module: XISD6329 - Task 2
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');

// --- configuration ---------------------------------------------------------
// Values come from the environment or a .env file that is NOT committed.
function env(string $key, ?string $default = null): ?string
{
    static $loaded = null;
    if ($loaded === null) {
        $loaded = [];
        $path = __DIR__ . '/../../.env';
        if (is_readable($path)) {
            foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
                    continue;
                }
                [$k, $v] = explode('=', $line, 2);
                $loaded[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
            }
        }
    }
    return $_ENV[$key] ?? getenv($key) ?: ($loaded[$key] ?? $default);
}

// --- responses -------------------------------------------------------------
function respond(array $payload, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function ok(mixed $data, ?string $message = null): never
{
    respond(['success' => true, 'data' => $data, 'message' => $message]);
}

function fail(string $message, int $status = 400, array $errors = []): never
{
    respond(['success' => false, 'message' => $message, 'errors' => (object) $errors], $status);
}

function requireMethod(string ...$methods): void
{
    if (!in_array($_SERVER['REQUEST_METHOD'] ?? '', $methods, true)) {
        fail('Method not allowed.', 405);
    }
}

function jsonBody(): array
{
    $raw = file_get_contents('php://input') ?: '';
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

// --- database --------------------------------------------------------------
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        env('DB_HOST', '127.0.0.1'),
        env('DB_PORT', '3306'),
        env('DB_NAME', 'quickfix_db')
    );
    try {
        $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        error_log('QuickFix DB connection failed: ' . $e->getMessage());
        fail('The service is temporarily unavailable. Please try again shortly.', 503);
    }
    return $pdo;
}

// --- authentication --------------------------------------------------------
/**
 * Verifies the Firebase ID token supplied in the Authorization header against
 * Google's Identity Toolkit and returns the matching app_user row.
 *
 * The app never sends a user id of its own: identity is proven by the token.
 */
function requireUser(): array
{
    $header = $_SERVER['HTTP_AUTHORIZATION']
        ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
        ?? '';
    if (!preg_match('/^Bearer\s+(.+)$/i', trim($header), $m)) {
        fail('Authentication required.', 401);
    }
    $claims = verifyFirebaseToken($m[1]);

    $stmt = db()->prepare('SELECT * FROM app_user WHERE firebase_uid = :uid LIMIT 1');
    $stmt->execute([':uid' => $claims['localId']]);
    $user = $stmt->fetch();

    if (!$user) {
        // First call after sign-up: create the mirror row.
        $insert = db()->prepare(
            'INSERT INTO app_user (firebase_uid, full_name, email, auth_provider, email_verified)
             VALUES (:uid, :name, :email, :provider, :verified)'
        );
        $insert->execute([
            ':uid'      => $claims['localId'],
            ':name'     => $claims['displayName'] ?? 'QuickFix customer',
            ':email'    => $claims['email'] ?? '',
            ':provider' => $claims['provider'] ?? 'password',
            ':verified' => !empty($claims['emailVerified']) ? 1 : 0,
        ]);
        $stmt->execute([':uid' => $claims['localId']]);
        $user = $stmt->fetch();
    }

    db()->prepare('UPDATE app_user SET last_login = NOW() WHERE user_id = :id')
        ->execute([':id' => $user['user_id']]);

    return $user;
}

function verifyFirebaseToken(string $idToken): array
{
    $apiKey = env('FIREBASE_WEB_API_KEY');
    if (!$apiKey) {
        error_log('FIREBASE_WEB_API_KEY is not configured.');
        fail('Authentication is not configured on the server.', 500);
    }

    $ch = curl_init('https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . urlencode($apiKey));
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode(['idToken' => $idToken]),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
    ]);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status !== 200 || !$response) {
        fail('Your session has expired. Please sign in again.', 401);
    }

    $payload = json_decode($response, true);
    $account = $payload['users'][0] ?? null;
    if (!$account || empty($account['localId'])) {
        fail('Your session has expired. Please sign in again.', 401);
    }

    return [
        'localId'       => $account['localId'],
        'email'         => $account['email'] ?? null,
        'displayName'   => $account['displayName'] ?? null,
        'emailVerified' => $account['emailVerified'] ?? false,
        'provider'      => $account['providerUserInfo'][0]['providerId'] ?? 'password',
    ];
}

// --- server-side validation ------------------------------------------------
/**
 * Mirrors Validator.kt in the Android app. Client-side checks are for
 * usability; these checks are the ones that protect the database.
 */
final class Validate
{
    public static function normalisePhone(string $value): string
    {
        $v = preg_replace('/[^0-9+]/', '', $value) ?? '';
        if (str_starts_with($v, '+27')) {
            $v = '0' . substr($v, 3);
        } elseif (str_starts_with($v, '27') && strlen($v) === 11) {
            $v = '0' . substr($v, 2);
        }
        return preg_replace('/\D/', '', $v) ?? '';
    }

    /** @param array<string,mixed> $data */
    public static function check(array $data, array $rules): array
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            $value = trim((string) ($data[$field] ?? ''));
            foreach (explode('|', $rule) as $single) {
                [$name, $arg] = array_pad(explode(':', $single, 2), 2, null);
                $message = match ($name) {
                    'required' => $value === '' ? 'This field is required.' : null,
                    'email'    => !filter_var($value, FILTER_VALIDATE_EMAIL)
                        ? 'Please enter a valid email address.' : null,
                    'phone'    => !preg_match('/^0\d{9}$/', self::normalisePhone($value))
                        ? 'Please enter a valid 10-digit South African number.' : null,
                    'min'      => mb_strlen($value) < (int) $arg
                        ? "Please use at least {$arg} characters." : null,
                    'max'      => mb_strlen($value) > (int) $arg
                        ? "Please use no more than {$arg} characters." : null,
                    'in'       => !in_array($value, explode(',', (string) $arg), true)
                        ? 'Please choose one of the available options.' : null,
                    'positive' => !is_numeric(str_replace([' ', ',', 'R'], '', $value))
                        || (float) str_replace([' ', ',', 'R'], '', $value) <= 0
                        ? 'Please enter an amount greater than zero.' : null,
                    default    => null,
                };
                if ($message !== null) {
                    $errors[$field] = $message;
                    break;
                }
            }
        }
        return $errors;
    }
}

/** Logs an outbound notification so the admin panel can audit delivery. */
function logNotification(string $type, int $id, string $recipient, string $emailType, bool $sent, ?string $error = null): void
{
    db()->prepare(
        'INSERT INTO notification_log
            (submission_type, submission_id, recipient_email, email_type, status, error_message)
         VALUES (:type, :id, :recipient, :emailType, :status, :error)'
    )->execute([
        ':type'      => $type,
        ':id'        => $id,
        ':recipient' => $recipient,
        ':emailType' => $emailType,
        ':status'    => $sent ? 'Sent' : 'Failed',
        ':error'     => $error,
    ]);
}
