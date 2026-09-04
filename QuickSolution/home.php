<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional laptop repair services in Hatfield, Pretoria. Screen replacement, SSD upgrades, RAM installation, Windows setup, and more.">
    <meta name="keywords" content="laptop repair, Hatfield, Pretoria, screen replacement, SSD upgrade, computer repair">
    <meta name="author" content="Quickfix Tech Solutions">
    <meta property="og:title" content="Quickfix Tech Solutions">
    <meta property="og:description" content="Expert laptop repairs in Hatfield, Pretoria">
    <meta property="og:type" content="website">
    <title>Quickfix Tech Solutions | Professional Laptop Repairs Hatfield Pretoria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        :root {
            --primary: #8b5cf6;
            --secondary: #22c1dc;
            --accent: #7c3aed;
            --dark: #0a0a0f;
            --darker: #050508;
            --card: #12121a;
            --card-hover: #1a1a25;
            --text-gray: #8892b0;
            --text-light: #e6f1ff;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --neon-glow: 0 0 20px rgba(139, 92, 246, 0.5);
            --glass: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            background: var(--dark);
            color: var(--text-light);
            line-height: 1.6;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--darker);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        header.scrolled {
            background: rgba(10, 10, 15, 0.9);
            backdrop-filter: blur(20px);
            padding: 15px 40px;
            border-bottom: 1px solid rgba(139, 92, 246, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .logo-text span {
            color: var(--secondary);
        }

        nav {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        nav a {
            text-decoration: none;
            color: var(--text-gray);
            font-weight: 500;
            position: relative;
            transition: color 0.3s;
            font-size: 0.95rem;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: width 0.3s;
        }

        nav a:hover {
            color: var(--text-light);
        }

        nav a:hover::after {
            width: 100%;
        }

        .nav-cta {
            background: var(--gradient-1);
            padding: 10px 24px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: var(--neon-glow);
        }

        .nav-cta::after {
            display: none;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        .mobile-toggle span {
            width: 25px;
            height: 2px;
            background: white;
            transition: all 0.3s;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 120px 40px 80px;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at top, var(--primary) 0%, transparent 50%), radial-gradient(ellipse at bottom, var(--secondary) 0%, transparent 50%);
            opacity: 0.1;
            animation: bg-shift 20s ease-in-out infinite;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        @keyframes bg-shift {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, -20px); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--glass);
            border: 1px solid rgba(139, 92, 246, 0.3);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            color: var(--secondary);
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .hero-badge i {
            animation: spin 4s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .hero h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #fff 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.4rem);
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary);
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--gradient-1);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-secondary:hover {
            border-color: var(--secondary);
            background: rgba(34, 193, 220, 0.1);
        }

        .floating-elements {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .float-item {
            position: absolute;
            background: var(--glass);
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: 16px;
            padding: 20px;
            backdrop-filter: blur(10px);
            animation: float 6s ease-in-out infinite;
        }

        .float-item:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .float-item:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .float-item:nth-child(3) {
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        section {
            padding: 100px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-header h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #fff 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-header p {
            color: var(--text-gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: var(--card);
            border: 1px solid rgba(139, 92, 246, 0.1);
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .service-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-1);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 0;
        }

        .service-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 30px 60px rgba(139, 92, 246, 0.2);
        }

        .service-card:hover::before {
            opacity: 0.05;
        }

        .service-icon {
            position: relative;
            z-index: 1;
            width: 70px;
            height: 70px;
            background: var(--gradient-1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 24px;
            transition: transform 0.3s;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .service-card h3 {
            position: relative;
            z-index: 1;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: white;
        }

        .service-card p {
            position: relative;
            z-index: 1;
            color: var(--text-gray);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .service-features {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 15px;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--text-gray);
            flex-wrap: wrap;
        }

        .service-features span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pricing-section {
            background: linear-gradient(to bottom, var(--dark), var(--darker));
            position: relative;
        }

        .pricing-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .pricing-tabs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 50px;
            background: var(--card);
            padding: 8px;
            border-radius: 50px;
            max-width: 400px;
            margin: 0 auto 50px;
        }

        .tab-btn {
            padding: 12px 24px;
            border-radius: 25px;
            border: none;
            background: transparent;
            color: var(--text-gray);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .tab-btn.active {
            background: var(--gradient-1);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .pricing-card {
            background: var(--card);
            border: 1px solid rgba(139, 92, 246, 0.1);
            border-radius: 24px;
            padding: 35px;
            position: relative;
            transition: all 0.4s;
        }

        .pricing-card.featured {
            border-color: var(--primary);
            transform: scale(1.05);
            box-shadow: 0 20px 60px rgba(139, 92, 246, 0.3);
        }

        .pricing-card.featured::before {
            content: 'POPULAR';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gradient-1);
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .pricing-header {
            margin-bottom: 25px;
        }

        .pricing-name {
            font-size: 1.1rem;
            color: var(--text-gray);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pricing-price {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: white;
        }

        .pricing-price span {
            font-size: 1rem;
            color: var(--text-gray);
            font-weight: 400;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 30px;
        }

        .pricing-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.95rem;
            color: var(--text-gray);
        }

        .pricing-features li i {
            color: var(--secondary);
            font-size: 0.9rem;
        }

        .pricing-btn {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 2px solid var(--primary);
            background: transparent;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .pricing-btn:hover {
            background: var(--primary);
        }

        .pricing-card.featured .pricing-btn {
            background: var(--gradient-1);
            border: none;
        }

        .why-us {
            background: var(--darker);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .feature-item {
            text-align: center;
            padding: 30px;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--glass);
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--secondary);
            transition: all 0.3s;
        }

        .feature-item:hover .feature-icon {
            background: var(--primary);
            transform: translateY(-10px);
        }

        .feature-item h4 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: white;
        }

        .feature-item p {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .process-section {
            position: relative;
        }

        .process-line {
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0.3;
            transform: translateY(-50%);
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .process-step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--card);
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin: 0 auto 20px;
            position: relative;
            z-index: 2;
        }

        .process-step h4 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: white;
        }

        .process-step p {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .testimonials {
            background: var(--card);
        }

        .testimonial-slider {
            position: relative;
            overflow: hidden;
        }

        .testimonial-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 30px;
        }

        .testimonial-card {
            min-width: calc(33.333% - 20px);
            background: var(--dark);
            border: 1px solid rgba(139, 92, 246, 0.1);
            border-radius: 20px;
            padding: 35px;
            transition: all 0.3s;
        }

        .testimonial-card:hover {
            border-color: var(--primary);
        }

        .testimonial-stars {
            color: #ffd700;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .testimonial-text {
            font-size: 1rem;
            line-height: 1.8;
            color: var(--text-gray);
            margin-bottom: 25px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            background: var(--gradient-1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
        }

        .author-info h5 {
            color: white;
            font-size: 1rem;
        }

        .author-info span {
            color: var(--text-gray);
            font-size: 0.85rem;
        }

        .testimonial-nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
        }

        .testimonial-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid rgba(139, 92, 246, 0.3);
            background: transparent;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .testimonial-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .offer-section {
            padding: 0 40px;
            margin: 80px auto;
            max-width: 1200px;
        }

        .offer-card {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            border-radius: 30px;
            padding: 60px;
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 30px 60px rgba(124, 58, 237, 0.4);
        }

        .offer-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .offer-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        .offer-card h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .offer-price {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        .offer-timer {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .timer-item {
            background: rgba(255, 255, 255, 0.15);
            padding: 15px 25px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            min-width: 80px;
        }

        .timer-item span {
            display: block;
            font-size: 2rem;
            font-weight: 700;
        }

        .timer-item label {
            font-size: 0.75rem;
            text-transform: uppercase;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        .contact-section {
            position: relative;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .contact-info h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 25px;
            background: var(--card);
            border-radius: 16px;
            border: 1px solid rgba(139, 92, 246, 0.1);
            transition: all 0.3s;
        }

        .contact-item:hover {
            border-color: var(--primary);
            transform: translateX(10px);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-content h4 {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: white;
        }

        .contact-content p,
        .contact-content a {
            color: var(--text-gray);
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .contact-content a:hover {
            color: var(--secondary);
        }

        .hours-display {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(34, 193, 220, 0.1);
            border: 1px solid var(--secondary);
            padding: 8px 16px;
            border-radius: 20px;
            margin-top: 10px;
            font-size: 0.9rem;
            color: var(--secondary);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: status-pulse 2s infinite;
        }

        @keyframes status-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .map-wrapper {
            background: var(--card);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(139, 92, 246, 0.1);
        }

        .map-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .map-header i {
            font-size: 1.5rem;
            color: var(--secondary);
        }

        .map-header h4 {
            font-size: 1.3rem;
        }

        .map-container {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            height: 350px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
        }

        .map-link {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
            text-decoration: none;
        }

        .map-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(10, 10, 15, 0.8);
            transition: all 0.3s;
        }

        .map-link:hover .map-overlay {
            background: rgba(10, 10, 15, 0.6);
        }

        .map-overlay i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 15px;
            transition: transform 0.3s;
        }

        .map-link:hover .map-overlay i {
            transform: scale(1.2);
        }

        .map-overlay span {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
        }

        .map-info {
            margin-top: 20px;
            padding: 20px;
            background: var(--dark);
            border-radius: 12px;
            border-left: 4px solid var(--secondary);
        }

        .map-info h5 {
            font-size: 1rem;
            margin-bottom: 8px;
            color: white;
        }

        .map-info p {
            font-size: 0.9rem;
            color: var(--text-gray);
            line-height: 1.6;
        }

        .social-section {
            text-align: center;
            padding: 80px 40px;
            background: linear-gradient(to top, var(--darker), var(--dark));
        }

        .social-grid {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .social-card {
            width: 140px;
            height: 140px;
            background: var(--card);
            border: 2px solid rgba(139, 92, 246, 0.1);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            text-decoration: none;
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .social-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-1);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .social-card:hover::before {
            opacity: 1;
        }

        .social-card i {
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
            transition: transform 0.3s;
        }

        .social-card.tiktok i {
            color: #ff0050;
        }

        .social-card.facebook i {
            color: #1877f2;
        }

        .social-card.instagram i {
            color: #e4405f;
        }

        .social-card:hover i {
            color: white;
            transform: scale(1.2) rotate(5deg);
        }

        .social-card span {
            position: relative;
            z-index: 1;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .social-card:hover {
            border-color: transparent;
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.3);
        }

        .faq-section {
            background: var(--card);
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background: var(--dark);
            border-radius: 16px;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(139, 92, 246, 0.1);
            transition: all 0.3s;
        }

        .faq-item:hover {
            border-color: var(--primary);
        }

        .faq-question {
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
        }

        .faq-question i {
            transition: transform 0.3s;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 30px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-gray);
            line-height: 1.7;
        }

        .faq-item.active .faq-answer {
            padding: 0 30px 25px;
            max-height: 300px;
        }

        footer {
            background: var(--darker);
            padding: 60px 40px 40px;
            border-top: 1px solid rgba(139, 92, 246, 0.1);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto 50px;
        }

        .footer-col h4 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: white;
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
            background: var(--primary);
            border-radius: 2px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            color: var(--text-gray);
            text-decoration: none;
            transition: color 0.3s;
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: var(--secondary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            max-width: 1400px;
            margin: 0 auto;
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .copyright {
            margin-bottom: 15px;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .footer-social a {
            color: var(--text-gray);
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .footer-social a:hover {
            color: var(--secondary);
        }

        .footer-credits a {
            color: var(--secondary);
            text-decoration: none;
        }

        /* Responsive Styles */
        @media (max-width: 1100px) {
            .features-grid,
            .process-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .process-line {
                display: none;
            }
            
            .testimonial-card {
                min-width: calc(50% - 20px);
            }
        }

        @media (max-width: 900px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .floating-elements {
                display: none;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 20px 30px;
            }
            
            nav {
                position: fixed;
                top: 0;
                right: -300px;
                width: 280px;
                height: 100vh;
                background: var(--darker);
                flex-direction: column;
                padding: 100px 30px 40px;
                transition: right 0.4s;
                box-shadow: -10px 0 30px rgba(0, 0, 0, 0.3);
            }
            
            nav.active {
                right: 0;
            }
            
            .mobile-toggle {
                display: flex;
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
            
            section {
                padding: 80px 30px;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .hero-buttons .btn {
                width: 100%;
                justify-content: center;
            }
            
            .offer-card {
                padding: 40px 30px;
            }
            
            .offer-timer {
                flex-wrap: wrap;
            }
            
            .features-grid,
            .process-grid {
                grid-template-columns: 1fr;
            }
            
            .testimonial-card {
                min-width: 100%;
            }
            
            .social-card {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 15px 20px;
            }
            
            section {
                padding: 70px 20px;
            }
            
            .hero {
                padding: 120px 20px 60px;
            }
            
            .hero-stats {
                gap: 30px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .offer-card {
                padding: 30px 20px;
            }
            
            .offer-price {
                font-size: 3rem;
            }
            
            .pricing-tabs {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <a href="#" class="logo">
            <div class="logo-icon">
                <i class="fas fa-laptop-medical"></i>
            </div>
            <div class="logo-text">Quickfix <span>Tech</span> <span>Solutions</span></div>
        </a>
        
        <nav id="nav">
            <a href="#services">Services</a>
            <a href="Prices.php#Pricing">Pricing</a>
            <a href="#why-us">Why Us</a>
            <a href="#contact">Contact</a>
            <a href="Bookings.php" class="nav-cta">Book Repair</a>
            <a href="track-repair.php" class="nav-cta">Track Repair</a>
        </nav>
        
        <div class="mobile-toggle" id="mobile-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        
        <div class="floating-elements">
            <div class="float-item">
                <i class="fas fa-laptop-code fa-2x"></i>
            </div>
            <div class="float-item">
                <i class="fas fa-microchip fa-2x"></i>
            </div>
            <div class="float-item">
                <i class="fas fa-tools fa-2x"></i>
            </div>
        </div>
        
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i>
                <span>Trusted by 1500+ clients in Hatfield</span>
            </div>
            
            <h1>Expert Laptop Repairs in Pretoria</h1>
            <p class="hero-subtitle">Fast, reliable laptop repair services with lifetime warranty on parts. Screen replacements, hardware upgrades, software fixes, and more.</p>
            
            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number">97%</span>
                    <span class="stat-label">Success Rate</span>
                </div>
                <div class="stat">
                    <span class="stat-number">45 min</span>
                    <span class="stat-label">Average Repair</span>
                </div>
                <div class="stat">
                    <span class="stat-number">1500+</span>
                    <span class="stat-label">Satisfied Clients</span>
                </div>
            </div>
            
            <div class="hero-buttons">
                <a href="#services" class="btn btn-primary"
                    <i class="fas fa-tools"></i>
                    Explore Services
                </a>
                <a href="#contact" class="btn btn-secondary">
                    <i class="fas fa-phone-alt"></i>
                    Call Now: 062 161 4699
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="section-header">
            <h2>Our Repair Services</h2>
            <p>Comprehensive laptop repair solutions for all brands and models. Fast turnaround times and premium parts.</p>
        </div>
        
        <div class="services-grid">
            <div class="service-card" data-aos="fade-up">
                <div class="service-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <h3>Screen Replacement</h3>
                <p>Cracked or damaged screen? We offer same-day screen replacements with OEM-quality LCD/LED panels.</p>
                <div class="service-features">
                    <span><i class="fas fa-check-circle"></i> Same-day service</span>
                    <span><i class="fas fa-check-circle"></i> All brands</span>
                    <span><i class="fas fa-check-circle"></i> Touchscreen options</span>
                </div>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <h3>Hardware Upgrades</h3>
                <p>Boost your laptop's performance with SSD upgrades, RAM installation, and battery replacements.</p>
                <div class="service-features">
                    <span><i class="fas fa-check-circle"></i> Performance boost</span>
                    <span><i class="fas fa-check-circle"></i> Extended battery life</span>
                    <span><i class="fas fa-check-circle"></i> Expert installation</span>
                </div>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-plug"></i>
                </div>
                <h3>Power & Charging</h3>
                <p>Fix charging issues, replace power jacks, and install new batteries to keep your laptop powered.</p>
                <div class="service-features">
                    <span><i class="fas fa-check-circle"></i> Charging port repair</span>
                    <span><i class="fas fa-check-circle"></i> Battery diagnostics</span>
                    <span><i class="fas fa-check-circle"></i> Fast turnaround</span>
                </div>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-keyboard"></i>
                </div>
                <h3>Keyboard Replacement</h3>
                <p>Fix sticky keys, liquid damage, or unresponsive keyboards with our professional replacement service.</p>
                <div class="service-features">
                    <span><i class="fas fa-check-circle"></i> Original parts</span>
                    <span><i class="fas fa-check-circle"></i> Backlit options</span>
                    <span><i class="fas fa-check-circle"></i> All languages</span>
                </div>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-window-restore"></i>
                </div>
                <h3>Software Solutions</h3>
                <p>Virus removal, OS installation/reinstallation, driver updates, and optimization for peak performance.</p>
                <div class="service-features">
                    <span><i class="fas fa-check-circle"></i> Virus removal</span>
                    <span><i class="fas fa-check-circle"></i> OS installation</span>
                    <span><i class="fas fa-check-circle"></i> Data backup</span>
                </div>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                <div class="service-icon">
                    <i class="fas fa-fan"></i>
                </div>
                <h3>Overheating Solutions</h3>
                <p>Diagnose and fix overheating issues with professional cleaning, thermal paste replacement, and fan repair.</p>
                <div class="service-features">
                    <span><i class="fas fa-check-circle"></i> Deep cleaning</span>
                    <span><i class="fas fa-check-circle"></i> Thermal paste</span>
                    <span><i class="fas fa-check-circle"></i> Fan replacement</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing-section">
        <div class="section-header">
            <h2>Transparent Pricing</h2>
            <p>No hidden fees. We offer competitive pricing with premium parts and lifetime warranty.</p>
        </div>
        
        <div class="pricing-tabs">
            <button class="tab-btn active" data-tab="repairs">Repairs</button>
            <button class="tab-btn" data-tab="upgrades">Upgrades</button>
            <button class="tab-btn" data-tab="software">Software</button>
        </div>
        
        <div class="tab-content active" id="repairs-tab">
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <div class="pricing-name">Screen Replacement</div>
                        <div class="pricing-price">R850<span> From</span></div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Premium LCD/LED panels</li>
                        <li><i class="fas fa-check"></i> Professional installation</li>
                        <li><i class="fas fa-check"></i> Lifetime warranty</li>
                        <li><i class="fas fa-check"></i> Same-day service</li>
                    </ul>
                  <button class="pricing-btn" onclick="location.href='https://wa.me/27621614699'">
  Book Service
</button>
                </div>
                
                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <div class="pricing-name">Keyboard Replacement</div>
                        <div class="pricing-price">R450<span> From </span></div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Original manufacturer parts</li>
                        <li><i class="fas fa-check"></i> Professional installation</li>
                        <li><i class="fas fa-check"></i> Lifetime warranty</li>
                        <li><i class="fas fa-check"></i> Backlit options available</li>
                    </ul>
                   <button class="pricing-btn" onclick="location.href='https://wa.me/27621614699'">
  Book Service
</button>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <div class="pricing-name">Power Jack Repair</div>
                        <div class="pricing-price">R600<span> from</span></div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Premium replacement parts</li>
                        <li><i class="fas fa-check"></i> Professional soldering</li>
                        <li><i class="fas fa-check"></i> Lifetime warranty</li>
                        <li><i class="fas fa-check"></i> Same-day service</li>
                    </ul>
                  <button class="pricing-btn" onclick="location.href='https://wa.me/27621614699'">
  Book Service
</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us Section -->
    <section id="why-us" class="why-us">
        <div class="section-header">
            <h2>Why Choose QuickFix?</h2>
            <p>We're not just technicians - we're laptop enthusiasts committed to providing exceptional service.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-item" data-aos="fade-up">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Fast Turnaround</h4>
                <p>Most repairs completed within 1-2 hours while you wait.</p>
            </div>
            
            <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Lifetime Warranty</h4>
                <p>All parts come with a lifetime warranty for peace of mind.</p>
            </div>
            
            <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h4>Expert Technicians</h4>
                <p>Certified technicians with 10+ years of experience.</p>
            </div>
            
            <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h4>Data Security</h4>
                <p>Your data is safe with us - encrypted backups available.</p>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section">
        <div class="section-header">
            <h2>Our Repair Process</h2>
            <p>Simple, transparent steps to get your laptop back in perfect condition.</p>
        </div>
        
        <div class="process-line"></div>
        
        <div class="process-grid">
            <div class="process-step" data-aos="fade-up">
                <div class="step-number">1</div>
                <h4>Diagnosis</h4>
                <p>Free diagnostics to identify the exact issue with your device.</p>
            </div>
            
            <div class="process-step" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">2</div>
                <h4>Quote</h4>
                <p>Transparent pricing with no hidden fees or surprises.</p>
            </div>
            
            <div class="process-step" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">3</div>
                <h4>Repair</h4>
                <p>Expert repair using premium parts by certified technicians.</p>
            </div>
            
            <div class="process-step" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">4</div>
                <h4>Testing</h4>
                <p>Rigorous testing to ensure your laptop is working perfectly.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="section-header">
            <h2>Client Testimonials</h2>
            <p>Hear from satisfied customers who've experienced our exceptional service.</p>
        </div>
        
        <div class="testimonial-slider">
            <div class="testimonial-track">
                <div class="testimonial-card" data-aos="fade-right">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"My laptop screen cracked just before exams. QuickFix replaced it within an hour at a fair price. Their service saved my semester!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">T</div>
                        <div class="author-info">
                            <h5>Thabo Molefe</h5>
                            <span>University of Pretoria</span>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card" data-aos="fade-right" data-aos-delay="100">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The SSD upgrade transformed my 5-year-old laptop. It's faster than when I bought it! Professional service and reasonable pricing."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">S</div>
                        <div class="author-info">
                            <h5>Sarah Johnson</h5>
                            <span>Hatfield Resident</span>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card" data-aos="fade-right" data-aos-delay="200">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Fixed my charging port issue same day when other shops said it couldn't be repaired. These guys are miracle workers!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">D</div>
                        <div class="author-info">
                            <h5>David Peterson</h5>
                            <span>Small Business Owner</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-nav">
                <button class="testimonial-btn" id="testimonial-prev">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button class="testimonial-btn" id="testimonial-next">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Special Offer Section -->
    <div class="offer-section">
        <div class="offer-card">
            <span class="offer-badge">Limited Time Offer</span>
            <div class="offer-price">PRIZE GIVE AWAY</div>
            <p>All laptop repairs done from the </p>
            
            <div class="offer-timer">
                <div class="timer-item">
                    <span id="days">05</span>
                    <label>Days</label>
                </div>
                <div class="timer-item">
                    <span id="hours">18</span>
                    <label>Hours</label>
                </div>
                <div class="timer-item">
                    <span id="minutes">32</span>
                    <label>Minutes</label>
                </div>
                <div class="timer-item">
                    <span id="seconds">45</span>
                    <label>Seconds</label>
                </div>
            </div>
            
            <a href="#contact" class="btn btn-secondary" style="margin-top: 40px;">
                <i class="fas fa-graduation-cap"></i>
                Claim Student Discount
            </a>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="section-header">
            <h2>Contact Us</h2>
            <p>Visit our Hatfield shop or book an appointment for fast, professional service.</p>
        </div>
        
        <div class="contact-grid">
            <div class="contact-info">
                <h3>Get In Touch</h3>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Our Location</h4>
                            <p>464 Festival Street , Hatfield<br>Pretoria, 0002</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Call Us</h4>
                            <p>Phone: <a href="tel:+27732418258">073 241 8258 </a><br>WhatsApp: <a href="https://wa.me/27621614699">061 161 4699</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Email Us</h4>
                            <p><a href="mailto:info@quickfix.co.za">info@quickfix.co.za</a><br><a href="mailto:support@quickfix.co.za">support@quickfix.co.za</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Working Hours</h4>
                            <p>Monday - Friday: 8:30 AM - 6:00 PM<br>Saturday: 9:00 AM - 2:00 PM<br>Sunday: Closed</p>
                            <div class="hours-display">
                                <div class="status-dot"></div>
                                <span>Open now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="map-wrapper">
                <div class="map-header">
                    <i class="fas fa-map-marked-alt"></i>
                    <h4>Find Our Shop</h4>
                </div>
                
                <div class="map-container">
                    <a href="https://maps.app.goo.gl/R28P88Aqg8nArWjm6" target="_blank" class="map-link">
                        <div class="map-overlay">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>View on Google Maps</span>
                        </div>
                    </a>
                </div>
                
                <div class="map-info">
                    <h5>Parking Information</h5>
                    <p>Free parking available behind our building. Enter from Tech Street and look for QuickFix signage.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Section -->
    <section class="social-section">
        <div class="section-header">
            <h2>Connect With Us</h2>
            <p>Follow us for repair tips, special offers, and tech news.</p>
        </div>
        
        <div class="social-grid">
            <a href="https://www.facebook.com/share/14WnL7Z911w/" class="social-card facebook">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
            
            <a href="https://www.instagram.com/quickfixlaptopsolutions?igsh=NDl2Y2ZneGFndzhj" class="social-card instagram">
                <i class="fab fa-instagram"></i>
                <span>Instagram</span>
            </a>
            
            <a href="https://wa.me/27621614699" class="social-card">
                <i class="fab fa-whatsapp"></i>
                <span>WhatsApp</span>
            </a>
            
            <a href="https://www.tiktok.com/@quickfixlaptopsolutions?_r=1&_t=ZS-94f5EF4DVVU.  " class="social-card tiktok">
                <i class="fab fa-tiktok"></i>
                <span>TikTok</span>
            </a>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions about our services.</p>
        </div>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <span>How long does a typical repair take?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Most common repairs like screen replacements or SSD upgrades take 1-2 hours. More complex motherboard repairs may take 1-2 days. We offer same-day service for most issues.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer warranty on repairs?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! All repairs come with a lifetime warranty on parts and a 90-day warranty on labor. If you experience any issues related to our repair, we'll fix it at no additional cost.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can you recover data from a damaged laptop?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>In most cases, yes! We have specialized tools to recover data from laptops that won't boot, have liquid damage, or damaged storage drives. We offer free diagnostics for data recovery.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you repair all laptop brands?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We repair all major brands including Dell, HP, Lenovo, Asus, Acer, Apple, and Microsoft Surface. Our technicians are certified on all popular models.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I wait while my laptop is being repaired?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Absolutely! We have a comfortable waiting area with free WiFi and coffee. Most common repairs take 1-2 hours, so you can relax while we fix your device.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
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
                    <a href="#services">Screen Replacement</a>
                    <a href="#services">Hardware Upgrades</a>
                    <a href="#services">Keyboard Repair</a>
                    <a href="#services">Power & Charging</a>
                    <a href="#services">Software Solutions</a>
                    <a href="#services">Data Recovery</a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Quick Links</h4>
                <div class="footer-links">
                    <a href="#services">Services</a>
                    <a href="#pricing">Pricing</a>
                    <a href="#why-us">Why Choose Us</a>
                    <a href="#contact">Contact</a>
                    <a href="#">Blog</a>
                    <a href="#">FAQ</a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Contact Info</h4>
                <div class="footer-links">
                    <a href="#"><i class="fas fa-map-marker-alt"></i> 464 Festival Street(NB:Near UP)</a>
                    <a href="tel:063 241 8258"><i class="fas fa-phone-alt"></i> 062 161 4699</a>
                    <a href="mailto:info@quickfix.co.za"><i class="fas fa-envelope"></i> info@quickfix.co.za</a>
                    <a href="#"><i class="fas fa-clock"></i> Mon-Fri: 7:30 AM - 6:00 PM</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">© 2023 Quickfix Tech Solutions. All rights reserved.</div>
            <div class="footer-credits">Designed and developed with <i class="fas fa-heart" style="color: var(--secondary);"></i> in Pretoria</div>
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
        
        // FAQ accordion
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });
        
        // Testimonial slider
        const testimonialTrack = document.querySelector('.testimonial-track');
        const prevButton = document.getElementById('testimonial-prev');
        const nextButton = document.getElementById('testimonial-next');
        let currentPosition = 0;
        
        nextButton.addEventListener('click', () => {
            const testimonialCards = document.querySelectorAll('.testimonial-card');
            const cardWidth = testimonialCards[0].offsetWidth + 30; // Width + gap
            
            if (currentPosition > -(cardWidth * (testimonialCards.length - 3))) {
                currentPosition -= cardWidth;
                testimonialTrack.style.transform = `translateX(${currentPosition}px)`;
            }
        });
        
        prevButton.addEventListener('click', () => {
            const testimonialCards = document.querySelectorAll('.testimonial-card');
            const cardWidth = testimonialCards[0].offsetWidth + 30; // Width + gap
            
            if (currentPosition < 0) {
                currentPosition += cardWidth;
                testimonialTrack.style.transform = `translateX(${currentPosition}px)`;
            }
        });
        
        // Countdown timer
        function updateCountdown() {
            const daysElement = document.getElementById('days');
            const hoursElement = document.getElementById('hours');
            const minutesElement = document.getElementById('minutes');
            const secondsElement = document.getElementById('seconds');
            
            // Set the countdown to 5 days from now
            const countdownDate = new Date();
            countdownDate.setDate(countdownDate.getDate() + 5);
            
            const now = new Date().getTime();
            const distance = countdownDate - now;
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            daysElement.textContent = days.toString().padStart(2, '0');
            hoursElement.textContent = hours.toString().padStart(2, '0');
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
        
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                button.classList.add('active');
                
                // You would add logic here to show the corresponding tab content
            });
        });
    </script>
</body>
</html>