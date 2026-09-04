<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Repair - Quickfix Tech Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #8b5cf6;
            --dark: #0f172a;
            --darker: #020617;
            --light: #f8fafc;
            --text: #e2e8f0;
            --text-gray: #94a3b8;
            --accent: #f97316;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: #1e293b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background-color: var(--darker);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ── Header ── */
        header {
            background-color: rgba(15, 23, 42, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        header.scrolled { box-shadow: 0 5px 20px rgba(0,0,0,0.4); }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span { color: var(--secondary); }
        .logo i { font-size: 28px; }

        nav { display: flex; gap: 30px; }

        nav a {
            font-weight: 500;
            position: relative;
            padding: 5px 0;
            transition: color 0.3s ease;
        }

        nav a:hover { color: var(--primary); }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0; height: 2px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        nav a:hover::after { width: 100%; }

        .nav-cta {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79,70,229,0.5);
        }

        .nav-cta::after { display: none; }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px; height: 21px;
            cursor: pointer;
        }

        .mobile-toggle span {
            height: 3px; width: 100%;
            background-color: var(--text);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .mobile-toggle.active span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
        .mobile-toggle.active span:nth-child(2) { opacity: 0; }
        .mobile-toggle.active span:nth-child(3) { transform: rotate(-45deg) translate(7px,-6px); }

        /* ── Hero ── */
        .hero {
            padding: 160px 0 80px;
            background:
                radial-gradient(circle at top right, rgba(79,70,229,0.2) 0%, transparent 40%),
                radial-gradient(circle at bottom left, rgba(139,92,246,0.2) 0%, transparent 40%),
                var(--darker);
            border-bottom: 1px solid rgba(79,70,229,0.2);
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(79,70,229,0.2);
            color: var(--primary);
            padding: 8px 15px;
            border-radius: 20px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(79,70,229,0.3);
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }

        .hero p {
            color: var(--text-gray);
            font-size: 18px;
            max-width: 550px;
            margin: 0 auto;
        }

        /* ── Booking Section ── */
        .booking-section {
            padding: 80px 0 100px;
            background: var(--dark);
            position: relative;
        }

        .booking-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--primary), transparent);
        }

        .booking-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
            align-items: start;
        }

        /* ── Form Card ── */
        .form-card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid rgba(79,70,229,0.2);
            padding: 36px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            width: 34px; height: 34px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: white;
            flex-shrink: 0;
        }

        .form-divider {
            border: none;
            border-top: 1px solid rgba(79,70,229,0.15);
            margin: 32px 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-gray);
            margin-bottom: 8px;
        }

        .form-group label span.required {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            background: rgba(15,23,42,0.6);
            border: 1px solid rgba(79,70,229,0.25);
            border-radius: 10px;
            padding: 13px 16px;
            color: var(--text);
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            outline: none;
        }

        .form-control::placeholder { color: rgba(148,163,184,0.5); }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 110px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            cursor: pointer;
        }

        select.form-control option { background: var(--card-bg); color: var(--text); }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ── Service Option Toggle ── */
        .service-option-group {
            display: flex;
            gap: 12px;
        }

        .service-option-btn {
            flex: 1;
            background: rgba(15,23,42,0.6);
            border: 1px solid rgba(79,70,229,0.25);
            border-radius: 10px;
            padding: 14px 20px;
            color: var(--text-gray);
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .service-option-btn:hover {
            border-color: var(--primary);
            color: var(--text);
        }

        .service-option-btn.active {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }

        /* ── Photo Upload ── */
        .photo-upload-area {
            border: 2px dashed rgba(79,70,229,0.35);
            border-radius: 10px;
            padding: 28px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(15,23,42,0.4);
        }

        .photo-upload-area:hover {
            border-color: var(--primary);
            background: rgba(79,70,229,0.07);
        }

        .photo-upload-area i {
            font-size: 28px;
            color: var(--primary);
            display: block;
            margin-bottom: 8px;
        }

        .photo-upload-area p {
            color: var(--text-gray);
            font-size: 14px;
        }

        .photo-upload-area p span {
            color: var(--primary);
            font-weight: 600;
        }

        #photo-input { display: none; }

        .photo-previews {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }

        .photo-preview-thumb {
            width: 72px; height: 72px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid rgba(79,70,229,0.3);
        }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(79,70,229,0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,70,229,0.6);
        }

        /* ── Sidebar ── */
        .sidebar { display: flex; flex-direction: column; gap: 24px; }

        .sidebar-card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid rgba(79,70,229,0.2);
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .sidebar-card h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-card h3 i { color: var(--primary); }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .info-item:last-child { margin-bottom: 0; }

        .info-item i {
            color: var(--primary);
            margin-top: 2px;
            width: 16px;
            flex-shrink: 0;
        }

        .info-item div p {
            font-size: 13px;
            color: var(--text-gray);
        }

        .info-item div strong {
            font-size: 14px;
            color: var(--text);
            display: block;
        }

        .steps-list { list-style: none; counter-reset: steps; }

        .steps-list li {
            counter-increment: steps;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 14px;
            color: var(--text-gray);
        }

        .steps-list li::before {
            content: counter(steps);
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            width: 24px; height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .badge-success {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16,185,129,0.15);
            color: var(--success);
            border: 1px solid rgba(16,185,129,0.3);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        /* ── Success Modal ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(2,6,23,0.85);
            backdrop-filter: blur(6px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            background: var(--card-bg);
            border: 1px solid rgba(79,70,229,0.3);
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            max-width: 440px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.show .modal-box { transform: scale(1); }

        .modal-icon {
            width: 72px; height: 72px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            color: white;
        }

        .modal-box h2 {
            font-size: 24px;
            margin-bottom: 12px;
            color: var(--text);
        }

        .modal-box p { color: var(--text-gray); margin-bottom: 28px; }

        .modal-ref {
            background: rgba(79,70,229,0.1);
            border: 1px solid rgba(79,70,229,0.25);
            border-radius: 10px;
            padding: 14px 20px;
            margin-bottom: 28px;
            font-size: 13px;
            color: var(--text-gray);
        }

        .modal-ref strong { color: var(--primary); font-size: 18px; display: block; margin-top: 4px; }

        .btn-modal-close {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 36px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-modal-close:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,70,229,0.5); }
        .modal-receipt-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 14px;
            padding: 12px 20px;
            border: 1px solid rgba(79,70,229,0.35);
            border-radius: 10px;
            color: var(--text);
            background: rgba(79,70,229,0.12);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }
        .modal-receipt-link:hover { background: rgba(79,70,229,0.22); }

        /* ── Footer ── */
        footer {
            background: var(--darker);
            border-top: 1px solid rgba(79,70,229,0.15);
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .footer-links { display: flex; flex-direction: column; gap: 12px; }

        .footer-links a {
            color: var(--text-gray);
            transition: color 0.3s ease;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover { color: var(--primary); }

        .footer-social { display: flex; gap: 12px; margin-top: 20px; }

        .footer-social a {
            width: 38px; height: 38px;
            background: rgba(79,70,229,0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-gray);
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 30px;
            border-top: 1px solid rgba(79,70,229,0.1);
            color: var(--text-gray);
            font-size: 14px;
        }

        .footer-credits i { color: var(--danger); }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .booking-grid { grid-template-columns: 1fr; }
            .sidebar { flex-direction: row; flex-wrap: wrap; }
            .sidebar-card { flex: 1; min-width: 260px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            nav { display: none; position: absolute; top: 70px; left: 0; right: 0; background: rgba(15,23,42,0.98); flex-direction: column; padding: 20px; gap: 15px; }
            nav.active { display: flex; }
            .mobile-toggle { display: flex; }
            .hero h1 { font-size: 32px; }
            .form-row { grid-template-columns: 1fr; }
            .sidebar { flex-direction: column; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
        }
    </style>
</head>
<body>

    <!-- ── Header ── -->
    <header id="header">
        <div class="container">
            <div class="header-container">
                <a href="home.php" class="logo">
                    <i class="fas fa-laptop-medical"></i>
                    Quickfix<span> Tech Solutions</span>
                </a>
                <nav id="nav">
                    <a href="home.php">Home</a>
                    <a href="home.php#services">Services</a>
                    <a href="prices.php">Pricing</a>
                    <a href="bookings.php">Book Repair</a>
                    <a href="track-repair.php" class="nav-cta">Track Repair</a>
                    <a href="home.php#contact">Contact</a>
                </nav>
                <div class="mobile-toggle" id="mobile-toggle">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- ── Hero ── -->
    <section class="hero">
        <div class="container">
            <div class="hero-badge">
                <i class="fas fa-calendar-check"></i> Online Booking
            </div>
            <h1>Book Your Repair</h1>
            <p>Fill in the form below and we'll confirm your booking via WhatsApp within 30 minutes.</p>
        </div>
    </section>

    <!-- ── Booking Section ── -->
    <section class="booking-section">
        <div class="container">
            <div class="booking-grid">

                <!-- Form -->
                <div class="form-card" data-aos="fade-up">
                    <form id="booking-form" action="process-form.php" method="post" enctype="multipart/form-data" novalidate>

                        <!-- Your Information -->
                        <div class="form-section-title">
                            <i class="fas fa-user"></i>
                            Your Information
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name <span class="required">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter your full name" id="fullName" name="full_name" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" placeholder="e.g. 082 123 4567" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address <span class="required">*</span></label>
                            <input type="email" class="form-control" placeholder="you@email.com" id="email" name="email" required>
                        </div>

                        <hr class="form-divider">

                        <!-- Device Information -->
                        <div class="form-section-title">
                            <i class="fas fa-laptop"></i>
                            Device Information
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Laptop Brand <span class="required">*</span></label>
                                <input type="text" class="form-control" placeholder="e.g. Dell, HP, Lenovo" id="brand" name="laptop_brand" required>
                            </div>
                            <div class="form-group">
                                <label>Laptop Model</label>
                                <input type="text" class="form-control" placeholder="e.g. Inspiron 15 3000" id="model" name="laptop_model">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Serial Number <span style="font-size:12px;color:var(--text-gray)">(optional)</span></label>
                                <input type="text" class="form-control" placeholder="Found on sticker under laptop" id="serial" name="serial_number">
                            </div>
                            <div class="form-group">
                                <label>Device Age</label>
                                <input type="text" class="form-control" placeholder="e.g. 2 years, 6 months" id="deviceAge" name="device_age">
                            </div>
                        </div>

                        <hr class="form-divider">

                        <!-- Repair Details -->
                        <div class="form-section-title">
                            <i class="fas fa-tools"></i>
                            Repair Details
                        </div>

                        <div class="form-group">
                            <label>Repair Category <span class="required">*</span></label>
                            <select class="form-control" id="repairCategory" name="repair_category" required>
                                <option value="" disabled selected>Select a category...</option>
                                <option value="screen">Screen Replacement</option>
                                <option value="battery">Battery Replacement</option>
                                <option value="keyboard">Keyboard Repair</option>
                                <option value="charging">Charging Port / Power Issue</option>
                                <option value="storage">Storage Upgrade (SSD/HDD)</option>
                                <option value="memory">RAM / Memory Upgrade</option>
                                <option value="software">Software / OS Installation</option>
                                <option value="virus">Virus & Malware Removal</option>
                                <option value="data">Data Recovery</option>
                                <option value="cleaning">Laptop Cleaning</option>
                                <option value="diagnosis">Diagnosis Only</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Issue Description</label>
                            <textarea class="form-control" placeholder="Describe the problem in as much detail as possible..." id="issueDesc" name="issue_description"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Preferred Repair Date <span class="required">*</span></label>
                                <input type="date" class="form-control" id="repairDate" name="repair_date" required>
                            </div>
                            <div class="form-group">
                                <label>Preferred Time Slot</label>
                                <select class="form-control" id="timeSlot" name="time_slot">
                                    <option value="" disabled selected>Select a time...</option>
                                    <option>08:30 – 10:00</option>
                                    <option>10:00 – 12:00</option>
                                    <option>12:00 – 14:00</option>
                                    <option>14:00 – 16:00</option>
                                    <option>16:00 – 18:00</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Additional Notes</label>
                            <textarea class="form-control" placeholder="Any extra details, accessories included, urgency, etc..." id="notes" name="additional_notes" style="min-height:80px;"></textarea>
                        </div>

                        <hr class="form-divider">

                        <!-- Device Images -->
                        <div class="form-section-title">
                            <i class="fas fa-camera"></i>
                            Device Images <span style="font-size:13px;font-weight:400;color:var(--text-gray)">(optional)</span>
                        </div>

                        <div class="form-group">
                            <div class="photo-upload-area" id="upload-area">
                                <i class="fas fa-camera-retro"></i>
                                <p><span>Click to add photos</span> of your device</p>
                                <p style="margin-top:4px;font-size:12px;">JPG, PNG · Max 5 images</p>
                                <input type="file" id="photo-input" name="device_images[]" accept="image/*" multiple>
                            </div>
                            <div class="photo-previews" id="photo-previews"></div>
                        </div>

                        <hr class="form-divider">

                        <!-- Service Option -->
                        <div class="form-section-title">
                            <i class="fas fa-truck"></i>
                            Service Option
                        </div>

                        <div class="form-group">
                            <label>How will you get your laptop to us? <span class="required">*</span></label>
                            <div class="service-option-group">
                                <button type="button" class="service-option-btn active" data-value="dropoff" id="opt-dropoff">
                                    <i class="fas fa-store"></i> Drop-off
                                </button>
                                <button type="button" class="service-option-btn" data-value="collection" id="opt-collection">
                                    <i class="fas fa-car"></i> Collection
                                </button>
                            </div>
                            <input type="hidden" id="serviceOption" name="service_option" value="dropoff">
                        </div>

                        <div id="collection-address-wrap" style="display:none;" class="form-group">
                            <label>Collection Address <span class="required">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter your full address for pickup" id="collectionAddress" name="collection_address">
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Submit Repair Request
                        </button>

                    </form>
                </div>

                <!-- Sidebar -->
                <div class="sidebar" data-aos="fade-up" data-aos-delay="150">

                    <div class="sidebar-card">
                        <h3><i class="fas fa-info-circle"></i> What Happens Next</h3>
                        <ul class="steps-list">
                            <li>Submit your booking request using this form.</li>
                            <li>We'll confirm via WhatsApp within 30 minutes.</li>
                            <li>Drop off or arrange collection of your device.</li>
                            <li>We diagnose and repair — you get updates by SMS.</li>
                            <li>Collect your repaired laptop and pay on pickup.</li>
                        </ul>
                    </div>

                    <div class="sidebar-card">
                        <h3><i class="fas fa-map-marker-alt"></i> Our Location</h3>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>123 Tech Street, Hatfield</strong>
                                <p>Pretoria, 0083</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Mon – Fri: 8:30 AM – 6:00 PM</strong>
                                <p>Sat: 9:00 AM – 2:00 PM</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <strong>012 345 6789</strong>
                                <p>Call or WhatsApp</p>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <h3><i class="fas fa-shield-alt"></i> Our Promise</h3>
                        <div class="badge-success"><i class="fas fa-check-circle"></i> Lifetime Parts Warranty</div>
                        <div class="info-item" style="margin-top:10px;">
                            <i class="fas fa-bolt"></i>
                            <div>
                                <strong>Same-day repairs</strong>
                                <p>Most repairs done within 24 hrs</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <div>
                                <strong>Student Discounts</strong>
                                <p>Show your student card at drop-off</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-lock"></i>
                            <div>
                                <strong>No Fix, No Fee</strong>
                                <p>Only pay if we fix your device</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ── Footer ── -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Quickfix Tech Solutions</h4>
                    <p style="color:var(--text-gray);margin-bottom:20px;">Professional laptop repair services in Hatfield, Pretoria. Fast, reliable repairs with lifetime warranty.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Services</h4>
                    <div class="footer-links">
                        <a href="home.php#services"><i class="fas fa-desktop"></i> Screen Replacement</a>
                        <a href="home.php#services"><i class="fas fa-microchip"></i> Hardware Upgrades</a>
                        <a href="home.php#services"><i class="fas fa-keyboard"></i> Keyboard Repair</a>
                        <a href="home.php#services"><i class="fas fa-plug"></i> Power & Charging</a>
                        <a href="home.php#services"><i class="fas fa-window-restore"></i> Software Solutions</a>
                        <a href="home.php#services"><i class="fas fa-database"></i> Data Recovery</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <div class="footer-links">
                        <a href="home.php"><i class="fas fa-home"></i> Home</a>
                        <a href="home.php#services"><i class="fas fa-tools"></i> Services</a>
                        <a href="prices.html"><i class="fas fa-tags"></i> Prices</a>
                        <a href="bookings.html"><i class="fas fa-calendar-check"></i> Book Repair</a>
                        <a href="home.php#contact"><i class="fas fa-envelope"></i> Contact</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Contact Info</h4>
                    <div class="footer-links">
                        <a href="#"><i class="fas fa-map-marker-alt"></i> 123 Tech Street, Hatfield</a>
                        <a href="tel:+27123456789"><i class="fas fa-phone-alt"></i> 012 345 6789</a>
                        <a href="mailto:info@quickfix.co.za"><i class="fas fa-envelope"></i> info@quickfix.co.za</a>
                        <a href="#"><i class="fas fa-clock"></i> Mon–Fri: 8:30 AM – 6:00 PM</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">© 2025 Quickfix Tech Solutions. All rights reserved.</div>
                <div class="footer-credits">Designed and developed with <i class="fas fa-heart"></i> in Pretoria</div>
            </div>
        </div>
    </footer>

    <!-- ── Success Modal ── -->
    <div class="modal-overlay" id="success-modal">
        <div class="modal-box">
            <div class="modal-icon"><i class="fas fa-check"></i></div>
            <h2>Booking Submitted!</h2>
            <p>Thanks, <strong id="modal-name"></strong>! We've received your repair request and will confirm within 30 minutes via WhatsApp.</p>
            <div class="modal-ref">
                Your Reference Number
                <strong id="ref-number">QF-000000</strong>
            </div>
            <a id="modal-receipt-link" class="modal-receipt-link" href="#" target="_blank" rel="noopener">
                <i class="fas fa-file-pdf"></i> Download / Print PDF Receipt
            </a><br>
            <button class="btn-modal-close" onclick="closeModal()">Back to Home</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Header scroll
        window.addEventListener('scroll', () => {
            document.getElementById('header').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Mobile nav
        const mobileToggle = document.getElementById('mobile-toggle');
        const nav = document.getElementById('nav');
        mobileToggle.addEventListener('click', () => {
            mobileToggle.classList.toggle('active');
            nav.classList.toggle('active');
        });

        // Set min date to today
        const dateInput = document.getElementById('repairDate');
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;
        dateInput.value = today;

        // Service option toggle
        const optDropoff = document.getElementById('opt-dropoff');
        const optCollection = document.getElementById('opt-collection');
        const serviceInput = document.getElementById('serviceOption');
        const collectionWrap = document.getElementById('collection-address-wrap');

        [optDropoff, optCollection].forEach(btn => {
            btn.addEventListener('click', () => {
                optDropoff.classList.remove('active');
                optCollection.classList.remove('active');
                btn.classList.add('active');
                serviceInput.value = btn.dataset.value;
                collectionWrap.style.display = btn.dataset.value === 'collection' ? 'block' : 'none';
            });
        });

        // Photo upload
        const uploadArea = document.getElementById('upload-area');
        const photoInput = document.getElementById('photo-input');
        const photoPreviewsEl = document.getElementById('photo-previews');
        let selectedFiles = [];

        uploadArea.addEventListener('click', () => photoInput.click());

        photoInput.addEventListener('change', () => {
            const files = Array.from(photoInput.files).slice(0, 5 - selectedFiles.length);
            files.forEach(file => {
                if (selectedFiles.length >= 5) return;
                selectedFiles.push(file);
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'photo-preview-thumb';
                    photoPreviewsEl.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
            photoInput.value = '';
        });

        uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.style.borderColor = 'var(--primary)'; });
        uploadArea.addEventListener('dragleave', () => { uploadArea.style.borderColor = ''; });
        uploadArea.addEventListener('drop', e => {
            e.preventDefault();
            uploadArea.style.borderColor = '';
            photoInput.files = e.dataTransfer.files;
            photoInput.dispatchEvent(new Event('change'));
        });

        // ── Form submit → POST to submit_booking.php ──────────────────────
        document.getElementById('booking-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            // --- Client-side validation ---
            const requiredFields = [
                { id: 'fullName',        label: 'Full Name' },
                { id: 'phone',           label: 'Phone Number' },
                { id: 'email',           label: 'Email Address' },
                { id: 'brand',           label: 'Laptop Brand' },
                { id: 'repairCategory',  label: 'Repair Category' },
                { id: 'issueDesc',       label: 'Issue Description' },
                { id: 'repairDate',      label: 'Repair Date' }
            ];

            let valid = true;

            requiredFields.forEach(({ id }) => {
                const el = document.getElementById(id);
                if (!el.value.trim()) {
                    markError(el);
                    valid = false;
                }
            });

            if (serviceInput.value === 'collection') {
                const addr = document.getElementById('collectionAddress');
                if (!addr.value.trim()) { markError(addr); valid = false; }
            }

            if (!valid) {
                document.querySelector('.form-control[style*="danger"]')
                    ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            // --- Build FormData to POST ---
            const formData = new FormData();
            formData.append('full_name',          document.getElementById('fullName').value.trim());
            formData.append('phone',              document.getElementById('phone').value.trim());
            formData.append('email',              document.getElementById('email').value.trim());
            formData.append('laptop_brand',       document.getElementById('brand').value.trim());
            formData.append('laptop_model',       document.getElementById('model').value.trim());
            formData.append('serial_number',      document.getElementById('serial').value.trim());
            formData.append('device_age',         document.getElementById('deviceAge').value.trim());
            formData.append('repair_category',    document.getElementById('repairCategory').value);
            formData.append('issue_description',  document.getElementById('issueDesc').value.trim());
            formData.append('repair_date',        document.getElementById('repairDate').value);
            formData.append('time_slot',          document.getElementById('timeSlot').value);
            formData.append('additional_notes',   document.getElementById('notes').value.trim());
            formData.append('service_option',     serviceInput.value);
            formData.append('collection_address', document.getElementById('collectionAddress').value.trim());

            // --- Loading state on button ---
            const submitBtn = document.querySelector('.btn-submit');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

            // --- Send to PHP ---
            try {
                const response = await fetch('submit_booking.php', {
                    method: 'POST',
                    body: formData
                });

                const responseText = await response.text();
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (parseError) {
                    throw new Error(responseText || `Server returned HTTP ${response.status}.`);
                }

                if (!response.ok) {
                    throw new Error(result.message || `Server returned HTTP ${response.status}.`);
                }

                if (result.success) {
                    // Show success modal with real ref number from server
                    document.getElementById('ref-number').textContent = result.reference;
                    document.getElementById('modal-name').textContent = result.name;
                    document.getElementById('modal-receipt-link').href = 'repair-receipt.php?ref=' + encodeURIComponent(result.reference);
                    document.getElementById('success-modal').classList.add('show');
                    document.getElementById('booking-form').reset();
                    photoPreviewsEl.innerHTML = '';
                    selectedFiles = [];
                } else {
                    showFormError(result.message || 'Something went wrong. Please try again.');
                }

            } catch (err) {
                showFormError(err.message || 'Could not reach the server. Please check that Apache is running and try again.');
                console.error(err);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
            }
        });

        // Mark a field as invalid
        function markError(el) {
            el.style.borderColor = 'var(--danger)';
            el.style.boxShadow   = '0 0 0 3px rgba(239,68,68,0.15)';
            el.addEventListener('input', () => {
                el.style.borderColor = '';
                el.style.boxShadow   = '';
            }, { once: true });
        }

        // Show a dismissable error banner above the submit button
        function showFormError(msg) {
            let banner = document.getElementById('form-error-banner');
            if (!banner) {
                banner = document.createElement('div');
                banner.id = 'form-error-banner';
                banner.style.cssText = `
                    background: rgba(239,68,68,0.12);
                    border: 1px solid rgba(239,68,68,0.4);
                    color: #fca5a5;
                    padding: 14px 18px;
                    border-radius: 10px;
                    margin-bottom: 16px;
                    font-size: 14px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                `;
                document.querySelector('.btn-submit').insertAdjacentElement('beforebegin', banner);
            }
            banner.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${msg}`;
            banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => { if (banner) banner.remove(); }, 6000);
        }

        function closeModal() {
            document.getElementById('success-modal').classList.remove('show');
            window.location.href = 'home.php';
        }

        // Close modal on overlay click
        document.getElementById('success-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>