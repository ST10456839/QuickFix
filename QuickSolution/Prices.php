<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price List - Quickfix Tech Solutions</title>
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background-color: var(--darker);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Header Styles */
        header {
            background-color: rgba(15, 23, 42, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        header.scrolled {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
        }
        
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
        
        .logo span {
            color: var(--secondary);
        }
        
        .logo i {
            font-size: 28px;
        }
        
        nav {
            display: flex;
            gap: 30px;
        }
        
        nav a {
            font-weight: 500;
            position: relative;
            padding: 5px 0;
            transition: color 0.3s ease;
        }
        
        nav a:hover {
            color: var(--primary);
        }
        
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        .nav-cta {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.5);
        }
        
        .nav-cta::after {
            display: none;
        }
        
        .mobile-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
        }
        
        .mobile-toggle span {
            height: 3px;
            width: 100%;
            background-color: var(--text);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        /* Hero Section */
        .hero {
            padding: 180px 0 100px;
            position: relative;
            background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.2) 0%, transparent 40%), 
                        radial-gradient(circle at bottom left, rgba(139, 92, 246, 0.2) 0%, transparent 40%),
                        var(--darker);
            overflow: hidden;
            border-bottom: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 650px;
            text-align: center;
            margin: 0 auto;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(79, 70, 229, 0.2);
            color: var(--primary);
            padding: 8px 15px;
            border-radius: 20px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(79, 70, 229, 0.3);
        }
        
        .hero-badge i {
            color: var(--warning);
        }
        
        h1 {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--text);
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba(79, 70, 229, 0.2);
        }
        
        .hero-subtitle {
            font-size: 18px;
            color: var(--text-gray);
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-stats {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            justify-content: center;
        }
        
        .stat {
            text-align: center;
            background: rgba(30, 41, 59, 0.7);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid rgba(79, 70, 229, 0.2);
            min-width: 140px;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--text-gray);
        }
        
        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.6);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: var(--text);
            border: 2px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Price List Section */
        .price-list-section {
            padding: 100px 0;
            background: var(--dark);
            position: relative;
        }
        
        .price-list-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--primary), transparent);
        }
        
        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
        }
        
        h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text);
            position: relative;
            display: inline-block;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .section-header p {
            color: var(--text-gray);
            font-size: 18px;
            margin-top: 25px;
        }
        
        .price-table-container {
            overflow-x: auto;
            margin: 40px 0;
            border-radius: 10px;
            background: var(--card-bg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .price-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        .price-table th {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            text-align: left;
            padding: 18px 20px;
            font-weight: 600;
            font-size: 18px;
        }
        
        .price-table th:first-child {
            border-top-left-radius: 8px;
        }
        
        .price-table th:last-child {
            border-top-right-radius: 8px;
        }
        
        .price-table td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(79, 70, 229, 0.1);
            font-size: 16px;
        }
        
        .price-table tr:nth-child(even) {
            background-color: rgba(30, 41, 59, 0.5);
        }
        
        .price-table tr:last-child td {
            border-bottom: none;
        }
        
        .price-table tr:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }
        
        .price-highlight {
            color: var(--primary);
            font-weight: 600;
            font-size: 18px;
        }
        
        .price-note {
            background-color: var(--card-bg);
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .price-note h4 {
            font-size: 20px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .price-note h4 i {
            color: var(--warning);
        }
        
        .price-note p {
            color: var(--text-gray);
        }
        
        .price-cta {
            text-align: center;
            margin-top: 50px;
        }
        
        .price-cta .btn {
            padding: 16px 40px;
            font-size: 18px;
        }
        
        /* Categories */
        .categories {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 40px;
        }
        
        .category-btn {
            padding: 12px 25px;
            background-color: var(--card-bg);
            color: var(--text-gray);
            border: 1px solid rgba(79, 70, 229, 0.2);
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .category-btn.active,
        .category-btn:hover {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border-color: transparent;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 80px 0 30px;
            position: relative;
            border-top: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--primary), transparent);
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .footer-col h4 {
            font-size: 20px;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .footer-links a {
            color: var(--text-gray);
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(30, 41, 59, 0.7);
            transition: all 0.3s ease;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .footer-social a:hover {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transform: translateY(-3px);
            border-color: transparent;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(79, 70, 229, 0.2);
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
            color: var(--text-gray);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .footer-credits i {
            color: var(--secondary);
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            h1 {
                font-size: 40px;
            }
            
            .hero-stats {
                gap: 20px;
            }
            
            .stat-number {
                font-size: 28px;
            }
        }
        
        @media (max-width: 768px) {
            nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: rgba(15, 23, 42, 0.95);
                flex-direction: column;
                gap: 0;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
                padding: 20px 0;
                backdrop-filter: blur(10px);
            }
            
            nav.active {
                display: flex;
            }
            
            nav a {
                padding: 12px 30px;
                border-bottom: 1px solid rgba(79, 70, 229, 0.1);
            }
            
            nav a:last-child {
                border-bottom: none;
            }
            
            .mobile-toggle {
                display: flex;
            }
            
            h1 {
                font-size: 32px;
            }
            
            .hero-subtitle {
                font-size: 16px;
            }
            
            .hero-stats {
                flex-wrap: wrap;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
            
            .price-table th,
            .price-table td {
                padding: 12px 15px;
                font-size: 14px;
            }
            
            .stat {
                min-width: 120px;
            }
        }
        
        @media (max-width: 576px) {
            .hero {
                padding: 150px 0 80px;
            }
            
            .hero-badge {
                font-size: 13px;
                padding: 6px 12px;
            }
            
            .section-header p {
                font-size: 16px;
            }
            
            .footer-grid {
                gap: 30px;
            }
            
            .hero-stats {
                gap: 10px;
            }
            
            .stat {
                min-width: calc(50% - 10px);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container header-container">
            <a href="index.php" class="logo">
                <i class="fas fa-laptop-medical"></i>
                Quick<span>Fix</span>
            </a>
            
            <nav id="nav">
                <a href="home.php">Home</a>
                <a href="home.php#services">Services</a>
                <a href="home.php#why-us">Why Us</a>
                <a href="home.php#contact">Contact</a>
                <a href="bookings.php" class="nav-cta">Book Repair</a>
                <a href="track-repair.php" class="nav-cta">Track Repair</a>
            </nav>
            
            <div class="mobile-toggle" id="mobile-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-star"></i>
                    <span>Transparent Pricing - No Hidden Fees</span>
                </div>
                
                <h1>Our Complete Price List</h1>
                <p class="hero-subtitle">All prices include VAT and labor. We offer premium parts with lifetime warranty and same-day service for most repairs.</p>
                
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">1500+</span>
                        <span class="stat-label">Happy Clients</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">97%</span>
                        <span class="stat-label">Success Rate</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">45 min</span>
                        <span class="stat-label">Avg. Repair Time</span>
                    </div>
                </div>
                
                <div class="hero-buttons">
                    <a href="Bookings.php" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i>
                        Book Appointment
                    </a>
                    <a href="tel:0123456789" class="btn btn-secondary">
                        <i class="fas fa-phone-alt"></i>
                        Call Now: 012 345 6789
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Price List Section -->
    <section class="price-list-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Price List</h2>
                <p>Competitive pricing with premium parts and lifetime warranty</p>
            </div>
            
            <div class="categories">
                <button class="category-btn" data-category="storage">Storage</button>
                <button class="category-btn" data-category="memory">Memory</button>
                <button class="category-btn" data-category="screen">Screen</button>
                <button class="category-btn" data-category="other">Other Services</button>
            </div>
            
            <div class="price-table-container" data-aos="fade-up">
                <table class="price-table">
                    <tr>
                        <th>Service</th>
                        <th>Price</th>
                    </tr>
                    <tr data-category="storage">
                        <td>SSD 128GB (Windows Included)</td>
                        <td class="price-highlight">R600</td>
                    </tr>
                    <tr data-category="storage">
                        <td>SSD 256GB (Windows Included)</td>
                        <td class="price-highlight">R850</td>
                    </tr>
                    <tr data-category="storage">
                        <td>SSD 500GB (Windows Included)</td>
                        <td class="price-highlight">R1300</td>
                    </tr>
                    <tr data-category="storage">
                        <td>HDD 500GB</td>
                        <td class="price-highlight">R400</td>
                    </tr>
                    <tr data-category="storage">
                        <td>HDD 1TB</td>
                        <td class="price-highlight">R600</td>
                    </tr>
                    <tr data-category="memory">
                        <td>DDR3 4GB</td>
                        <td class="price-highlight">R300</td>
                    </tr>
                    <tr data-category="memory">
                        <td>DDR3 8GB</td>
                        <td class="price-highlight">R500</td>
                    </tr>
                    <tr data-category="memory">
                        <td>DDR4 4GB</td>
                        <td class="price-highlight">R450</td>
                    </tr>
                    <tr data-category="memory">
                        <td>DDR4 8GB</td>
                        <td class="price-highlight">R750</td>
                    </tr>
                    <tr data-category="memory">
                        <td>DDR4 16GB</td>
                        <td class="price-highlight">R1500</td>
                    </tr>
                    <tr data-category="screen">
                        <td>Screen 10-14" Border</td>
                        <td class="price-highlight">R1100</td>
                    </tr>
                    <tr data-category="screen">
                        <td>Screen 10-14" Borderless</td>
                        <td class="price-highlight">R1500</td>
                    </tr>
                    <tr data-category="screen">
                        <td>Screen 15-17" Border</td>
                        <td class="price-highlight">R1000</td>
                    </tr>
                    <tr data-category="screen">
                        <td>Screen 15-17" Borderless</td>
                        <td class="price-highlight">R1750</td>
                    </tr>
                    <tr data-category="other">
                        <td>Laptop Cleaning</td>
                        <td class="price-highlight">R250</td>
                    </tr>
                    <tr data-category="other">
                        <td>Normal Diagnosis</td>
                        <td class="price-highlight">R150</td>
                    </tr>
                    <tr data-category="other">
                        <td>Water Damage Diagnosis</td>
                        <td class="price-highlight">R250</td>
                    </tr>
                    <tr data-category="other">
                        <td>Windows 10 Installation</td>
                        <td class="price-highlight">R350</td>
                    </tr>
                    <tr data-category="other">
                        <td>Windows 11 Installation</td>
                        <td class="price-highlight">R400</td>
                    </tr>
                    <tr data-category="other">
                        <td>Office 365 Installation</td>
                        <td class="price-highlight">R500</td>
                    </tr>
                </table>
            </div>
            
            <div class="price-note" data-aos="fade-up">
                <h4><i class="fas fa-info-circle"></i> Important Note</h4>
                <p>Prices are subject to change based on market conditions and laptop model. For the most accurate quote, please bring your laptop to our shop for a free diagnostic.</p>
                <p>All prices include VAT and labor. Parts come with a lifetime warranty. Student discounts available!</p>
            </div>
            
            <div class="price-cta" data-aos="fade-up">
                <a href="index.html#contact" class="btn btn-primary">
                    <i class="fas fa-calendar-alt"></i>
                    Schedule Your Repair Today
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Quickfix Tech Solutions</h4>
                    <p style="color: var(--text-gray); margin-bottom: 20px;">Professional laptop repair services in Hatfield, Pretoria. Fast, reliable repairs with lifetime warranty.</p>
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
                        <a href="#services"><i class="fas fa-desktop"></i> Screen Replacement</a>
                        <a href="#services"><i class="fas fa-microchip"></i> Hardware Upgrades</a>
                        <a href="#services"><i class="fas fa-keyboard"></i> Keyboard Repair</a>
                        <a href="#services"><i class="fas fa-plug"></i> Power & Charging</a>
                        <a href="#services"><i class="fas fa-window-restore"></i> Software Solutions</a>
                        <a href="#services"><i class="fas fa-database"></i> Data Recovery</a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <div class="footer-links">
                        <a href="home.php"><i class="fas fa-home"></i> Home</a>
                        <a href="home.php#services"><i class="fas fa-tools"></i> Services</a>
                        <a href="prices.php"><i class="fas fa-tags"></i> Prices</a>
                        <a href="home.php#why-us"><i class="fas fa-star"></i> Why Choose Us</a>
                        <a href="home.php#contact"><i class="fas fa-envelope"></i> Contact</a>
                        <a href="#"><i class="fas fa-question-circle"></i> FAQ</a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Contact Info</h4>
                    <div class="footer-links">
                        <a href="#"><i class="fas fa-map-marker-alt"></i> 123 Tech Street, Hatfield</a>
                        <a href="tel:+27123456789"><i class="fas fa-phone-alt"></i> 012 345 6789</a>
                        <a href="mailto:info@quickfix.co.za"><i class="fas fa-envelope"></i> info@quickfix.co.za</a>
                        <a href="#"><i class="fas fa-clock"></i> Mon-Fri: 8:30 AM - 6:00 PM</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">© 2023 Quickfix Tech Solutions. All rights reserved.</div>
                <div class="footer-credits">Designed and developed with <i class="fas fa-heart"></i> in Pretoria</div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobile-toggle');
        const nav = document.getElementById('nav');
        
        mobileToggle.addEventListener('click', function() {
            mobileToggle.classList.toggle('active');
            nav.classList.toggle('active');
        });
        
        // Category filtering
        const categoryButtons = document.querySelectorAll('.category-btn');
        const priceRows = document.querySelectorAll('.price-table tr');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                button.classList.add('active');
                
                const category = button.getAttribute('data-category');
                
                // Show/hide rows based on category
                priceRows.forEach(row => {
                    if (row.getAttribute('data-category')) {
                        if (category === 'all' || row.getAttribute('data-category') === category) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (nav.classList.contains('active')) {
                        mobileToggle.classList.remove('active');
                        nav.classList.remove('active');
                    }
                }
            });
        });
    </script>
</body>
</html>