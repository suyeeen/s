<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>STQM — Smart Teacher Quality Mapping</title>
    <meta name="description" content="Sistem pemetaan kualitas guru berbasis data kuesioner, absensi RFID, dan analisis K-Means Clustering.">

    {{-- Favicon --}}
    <link href="{{ asset('images/logo.png') }}" rel="icon">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap + Icons --}}
    <link href="{{ asset('arsha/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary:     #f97316;
            --primary-dark:#ea6c0a;
            --secondary:   #eab308;
            --dark:        #0a0a14;
            --dark2:       #0e0e1a;
            --dark3:       #13131f;
            --text-muted:  #9ca3af;
            --border:      rgba(255,255,255,0.07);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

        /* ══════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════ */
        #header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 999;
            padding: 16px 0;
            transition: all .4s ease;
        }

        #header.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.08);
            padding: 10px 0;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-wrapper img {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            object-fit: cover;
        }

        .logo-wrapper .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .logo-wrapper .logo-sub {
            font-size: 10px;
            color: #64748b;
            display: block;
            line-height: 1;
            margin-top: 1px;
        }

        nav ul {
            list-style: none;
            margin: 0; padding: 0;
            display: flex;
            gap: 8px;
        }

        nav ul a {
            text-decoration: none;
            color: #334155;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 50px;
            transition: all .2s;
        }

        nav ul a:hover, nav ul a.active {
            color: var(--primary);
            background: rgba(249,115,22,0.08);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white !important;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            transition: all .3s;
            box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(249,115,22,0.4);
            color: white;
        }

        /* ══════════════════════════════════════
           HERO
        ══════════════════════════════════════ */
        #hero {
            min-height: 100vh;
            background: var(--dark);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% 50%, rgba(249,115,22,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 10% 80%, rgba(139,92,246,0.08) 0%, transparent 50%);
        }

        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(249,115,22,0.12);
            border: 1px solid rgba(249,115,22,0.25);
            color: #fb923c;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 50px;
            margin-bottom: 24px;
        }

        .hero-badge span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--primary);
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p.lead {
            font-size: 17px;
            color: #94a3b8;
            line-height: 1.8;
            max-width: 520px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            transition: all .3s;
            box-shadow: 0 8px 30px rgba(249,115,22,0.35);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(249,115,22,0.45);
            color: white;
        }

        .btn-hero-secondary {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: #e2e8f0;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            transition: all .3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateY(-3px);
        }

        /* Hero stats */
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-wrap: wrap;
        }

        .hero-stat-item .num {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-stat-item .label {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Hero visual */
        .hero-visual {
            position: relative;
        }

        .hero-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 28px;
            backdrop-filter: blur(10px);
        }

        .hero-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .hero-card-dot {
            width: 12px; height: 12px;
            border-radius: 50%;
        }

        .cluster-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            border-radius: 16px;
            margin-bottom: 10px;
            border: 1px solid rgba(255,255,255,0.06);
        }

        .cluster-bar {
            height: 6px;
            border-radius: 3px;
            margin-top: 6px;
        }

        /* ══════════════════════════════════════
           SECTION COMMON
        ══════════════════════════════════════ */
        section { padding: 90px 0; }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title .badge-label {
            display: inline-block;
            background: rgba(249,115,22,0.1);
            border: 1px solid rgba(249,115,22,0.2);
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 16px;
        }

        .section-title h2 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        .section-title p {
            color: #64748b;
            font-size: 16px;
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ══════════════════════════════════════
           ABOUT
        ══════════════════════════════════════ */
        #about {
            background: #f8fafc;
        }

        .about-img-wrapper {
            position: relative;
        }

        .about-img-wrapper img {
            border-radius: 24px;
            width: 100%;
            object-fit: cover;
        }

        .about-badge-float {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: white;
            border-radius: 20px;
            padding: 20px 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            text-align: center;
        }

        .about-badge-float .big-num {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .about-check-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .about-check-item .icon {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: rgba(249,115,22,0.1);
            border: 1px solid rgba(249,115,22,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .about-check-item .icon i {
            font-size: 12px;
            color: var(--primary);
        }

        /* ══════════════════════════════════════
           FEATURES
        ══════════════════════════════════════ */
        #features {
            background: white;
        }

        .feature-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 32px 28px;
            height: 100%;
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity .3s;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px rgba(0,0,0,0.08);
            border-color: rgba(249,115,22,0.2);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .feature-card h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.7;
            margin: 0;
        }

        /* ══════════════════════════════════════
           HOW IT WORKS
        ══════════════════════════════════════ */
        #how-it-works {
            background: #f8fafc;
        }

        .step-card {
            text-align: center;
            padding: 40px 24px;
            position: relative;
        }

        .step-number {
            width: 64px; height: 64px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(249,115,22,0.3);
        }

        .step-connector {
            position: absolute;
            top: 72px;
            right: -20px;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0.3;
        }

        .step-card h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .step-card p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.7;
            margin: 0;
        }

        /* ══════════════════════════════════════
           ROLES
        ══════════════════════════════════════ */
        #roles {
            background: white;
        }

        .role-card {
            border-radius: 24px;
            padding: 36px 28px;
            height: 100%;
            transition: all .3s;
            border: 1px solid #e2e8f0;
        }

        .role-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        }

        .role-icon {
            width: 64px; height: 64px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .role-card h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }

        .role-card p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .role-feature-list {
            list-style: none;
            padding: 0; margin: 0;
        }

        .role-feature-list li {
            font-size: 13px;
            color: #475569;
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .role-feature-list li:last-child {
            border-bottom: none;
        }

        .role-feature-list li i {
            color: var(--primary);
            font-size: 12px;
        }

        /* ══════════════════════════════════════
           STATS
        ══════════════════════════════════════ */
        #stats {
            background: var(--dark);
            position: relative;
            overflow: hidden;
        }

        #stats::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(249,115,22,0.08) 0%, transparent 70%);
        }

        .stat-item {
            text-align: center;
            padding: 40px 20px;
        }

        .stat-item .num {
            font-family: 'Poppins', sans-serif;
            font-size: 48px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 12px;
        }

        .stat-item .label {
            font-size: 15px;
            color: #94a3b8;
            font-weight: 500;
        }

        .stat-divider {
            width: 1px;
            background: rgba(255,255,255,0.06);
            align-self: stretch;
        }

        /* ══════════════════════════════════════
           CTA
        ══════════════════════════════════════ */
        #cta {
            background: linear-gradient(135deg, #fff7ed, #fffbeb);
            border-top: 1px solid #fed7aa;
            border-bottom: 1px solid #fed7aa;
        }

        .cta-inner {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 32px;
            padding: 70px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-inner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }

        .cta-inner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .cta-inner h2 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            color: white;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .cta-inner p {
            color: rgba(255,255,255,0.85);
            font-size: 16px;
            margin-bottom: 36px;
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-cta {
            background: white;
            color: var(--primary);
            font-weight: 700;
            font-size: 15px;
            padding: 14px 36px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .3s;
            position: relative;
            z-index: 1;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.2);
            color: var(--primary-dark);
        }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 60px 0 24px;
        }

        footer .footer-brand .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: white;
        }

        footer p {
            font-size: 14px;
            line-height: 1.7;
            color: #64748b;
        }

        footer h6 {
            font-weight: 700;
            color: white;
            margin-bottom: 16px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        footer ul {
            list-style: none;
            padding: 0; margin: 0;
        }

        footer ul li a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            transition: color .2s;
            display: block;
            padding: 4px 0;
        }

        footer ul li a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 24px;
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #475569;
        }

        /* ══════════════════════════════════════
           MOBILE MENU
        ══════════════════════════════════════ */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #334155;
            cursor: pointer;
        }

        @media (max-width: 991px) {
            .mobile-nav-toggle { display: block; }
            nav { display: none; }
            nav.open {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(255,255,255,0.98);
                backdrop-filter: blur(20px);
                z-index: 9998;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            nav.open ul {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }
            nav.open ul a {
                font-size: 18px;
                padding: 12px 24px;
            }
            .step-connector { display: none; }
            .about-badge-float { right: 0; }
            .cta-inner { padding: 48px 24px; }
        }
    </style>
</head>

<body>

    {{-- ══════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════ --}}
    <header id="header">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="#hero" class="logo-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="STQM Logo">
                <div>
                    <span class="logo-text">STQM</span>
                    <span class="logo-sub">Teacher Quality Mapping</span>
                </div>
            </a>

            <nav id="navbar">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#how-it-works">Alur</a></li>
                    <li><a href="#roles">Pengguna</a></li>
                </ul>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('login') }}" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </a>
                <button class="mobile-nav-toggle" onclick="toggleMobileNav()">
                    <i class="bi bi-list" id="nav-icon"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- ══════════════════════════════════════
         HERO
    ══════════════════════════════════════ --}}
    <section id="hero">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>

        <div class="container position-relative" style="z-index:1">
            <div class="row align-items-center g-5">

                {{-- Left --}}
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                    <div class="hero-badge">
                        <span></span>
                        Sistem Pemetaan Kualitas Guru Berbasis AI
                    </div>
                    <h1>
                        Petakan Kualitas Guru dengan
                        <span class="highlight">Data & Kecerdasan Buatan</span>
                    </h1>
                    <p class="lead">
                        STQM mengintegrasikan data kuesioner, absensi RFID, dan prestasi guru
                        untuk menghasilkan pemetaan kompetensi yang objektif dan akurat menggunakan K-Means Clustering.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn-hero-primary">
                            Mulai Sekarang
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#about" class="btn-hero-secondary">
                            <i class="bi bi-play-circle"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="num">4</div>
                            <div class="label">Indikator Kompetensi</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="num">4</div>
                            <div class="label">Cluster Kualitas</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="num">25+</div>
                            <div class="label">Butir Pertanyaan</div>
                        </div>
                    </div>
                </div>

                {{-- Right — Dashboard mockup --}}
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    <div class="hero-card">
                        <div class="hero-card-header">
                            <div class="hero-card-dot" style="background:#ef4444"></div>
                            <div class="hero-card-dot" style="background:#f59e0b"></div>
                            <div class="hero-card-dot" style="background:#10b981"></div>
                            <span style="color:#64748b; font-size:13px; margin-left:8px;">Hasil Clustering K-Means</span>
                        </div>

                        @foreach([
                            ['label' => 'Cluster A — Sangat Baik',     'pct' => 35, 'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.1)',  'border' => 'rgba(16,185,129,0.15)'],
                            ['label' => 'Cluster B — Baik',            'pct' => 40, 'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.1)',  'border' => 'rgba(59,130,246,0.15)'],
                            ['label' => 'Cluster C — Cukup',           'pct' => 18, 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)',  'border' => 'rgba(245,158,11,0.15)'],
                            ['label' => 'Cluster D — Perlu Pembinaan', 'pct' => 7,  'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)',   'border' => 'rgba(239,68,68,0.15)'],
                        ] as $c)
                            <div class="cluster-item" style="background: {{ $c['bg'] }}; border-color: {{ $c['border'] }};">
                                <div style="flex:1">
                                    <div style="font-size:13px; font-weight:600; color:{{ $c['color'] }};">{{ $c['label'] }}</div>
                                    <div class="cluster-bar" style="width:{{ $c['pct'] }}%; background:{{ $c['color'] }};"></div>
                                </div>
                                <div style="font-size:18px; font-weight:800; color:{{ $c['color'] }}; margin-left:16px;">{{ $c['pct'] }}%</div>
                            </div>
                        @endforeach

                        <div style="margin-top:20px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.06); display:flex; align-items:center; gap:10px;">
                            <div style="width:8px;height:8px;border-radius:50%;background:#10b981;animation: pulse 2s infinite;"></div>
                            <span style="font-size:12px; color:#64748b;">Clustering diperbarui hari ini</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         ABOUT
    ══════════════════════════════════════ --}}
    <section id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="about-img-wrapper">
                        <img src="{{ asset('arsha/assets/img/why-us.png') }}" alt="Tentang STQM"
                             style="border-radius:24px; box-shadow: 0 24px 60px rgba(0,0,0,0.1);">
                        <div class="about-badge-float">
                            <div class="big-num">4</div>
                            <div style="font-size:12px; color:#64748b; font-weight:600;">Kompetensi Guru</div>
                            <div style="font-size:11px; color:#94a3b8;">Permendiknas No.16/2007</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="section-title text-start mb-4">
                        <span class="badge-label">Tentang Sistem</span>
                        <h2>Evaluasi Guru yang Objektif & Berbasis Data</h2>
                        <p class="text-start">
                            STQM hadir sebagai solusi evaluasi guru yang komprehensif, menggantikan metode konvensional
                            yang subjektif dengan sistem analisis berbasis kecerdasan buatan.
                        </p>
                    </div>
                    <div class="about-check-item">
                        <div class="icon"><i class="bi bi-check2"></i></div>
                        <div>
                            <strong style="font-size:15px; color:#0f172a;">Kuesioner Multi-Penilai</strong>
                            <p style="font-size:14px; color:#64748b; margin:4px 0 0;">Evaluasi dari perspektif siswa, sesama guru, dan penilaian diri sendiri untuk hasil yang menyeluruh.</p>
                        </div>
                    </div>
                    <div class="about-check-item">
                        <div class="icon"><i class="bi bi-check2"></i></div>
                        <div>
                            <strong style="font-size:15px; color:#0f172a;">Absensi RFID Terintegrasi</strong>
                            <p style="font-size:14px; color:#64748b; margin:4px 0 0;">Data kehadiran otomatis dari sistem RFID sebagai indikator kedisiplinan guru.</p>
                        </div>
                    </div>
                    <div class="about-check-item">
                        <div class="icon"><i class="bi bi-check2"></i></div>
                        <div>
                            <strong style="font-size:15px; color:#0f172a;">Analisis K-Means Clustering</strong>
                            <p style="font-size:14px; color:#64748b; margin:4px 0 0;">Algoritma machine learning mengelompokkan guru ke 4 cluster berdasarkan profil kompetensi mereka.</p>
                        </div>
                    </div>
                    <div class="about-check-item">
                        <div class="icon"><i class="bi bi-check2"></i></div>
                        <div>
                            <strong style="font-size:15px; color:#0f172a;">Dashboard & Laporan Real-time</strong>
                            <p style="font-size:14px; color:#64748b; margin:4px 0 0;">Kepala sekolah dapat memantau performa dan distribusi kualitas guru secara langsung.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FEATURES
    ══════════════════════════════════════ --}}
    <section id="features">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="badge-label">Fitur Unggulan</span>
                <h2>Semua yang Dibutuhkan dalam Satu Sistem</h2>
                <p>Dirancang khusus untuk memenuhi kebutuhan evaluasi guru di lingkungan sekolah modern.</p>
            </div>
            <div class="row g-4">
                @foreach([
                    ['icon' => 'bi-journal-check', 'bg' => 'rgba(249,115,22,0.1)', 'color' => '#f97316',
                     'title' => 'Sistem Kuesioner',
                     'desc'  => 'Kuesioner digital berbasis indikator kompetensi Permendiknas No.16/2007 dengan skala Likert 1-5. Diisi oleh siswa dan sesama guru.'],
                    ['icon' => 'bi-credit-card-2-front', 'bg' => 'rgba(59,130,246,0.1)', 'color' => '#3b82f6',
                     'title' => 'Absensi RFID',
                     'desc'  => 'Sistem scan kartu otomatis untuk mencatat kehadiran guru setiap hari. Data kedisiplinan tercatat akurat dan real-time.'],
                    ['icon' => 'bi-trophy', 'bg' => 'rgba(234,179,8,0.1)', 'color' => '#eab308',
                     'title' => 'Data Prestasi Guru',
                     'desc'  => 'Upload dan kelola sertifikat, penghargaan, dan portofolio profesional guru dengan sistem validasi oleh admin.'],
                    ['icon' => 'bi-cpu', 'bg' => 'rgba(139,92,246,0.1)', 'color' => '#8b5cf6',
                     'title' => 'K-Means Clustering',
                     'desc'  => 'Algoritma machine learning mengelompokkan guru ke 4 cluster (A/B/C/D) berdasarkan 4 dimensi kompetensi secara otomatis.'],
                    ['icon' => 'bi-bar-chart-line', 'bg' => 'rgba(16,185,129,0.1)', 'color' => '#10b981',
                     'title' => 'Dashboard Analisis',
                     'desc'  => 'Visualisasi distribusi cluster, grafik kompetensi, dan statistik performa guru yang interaktif untuk pengambilan keputusan.'],
                    ['icon' => 'bi-file-earmark-text', 'bg' => 'rgba(239,68,68,0.1)', 'color' => '#ef4444',
                     'title' => 'Laporan Evaluasi',
                     'desc'  => 'Generate laporan lengkap per guru beserta rekomendasi tindak lanjut berdasarkan hasil clustering. Dapat diexport ke Excel.'],
                ] as $f)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="feature-card">
                            <div class="feature-icon" style="background: {{ $f['bg'] }};">
                                <i class="bi {{ $f['icon'] }}" style="color: {{ $f['color'] }};"></i>
                            </div>
                            <h4>{{ $f['title'] }}</h4>
                            <p>{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         HOW IT WORKS
    ══════════════════════════════════════ --}}
    <section id="how-it-works">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="badge-label">Alur Sistem</span>
                <h2>Bagaimana STQM Bekerja?</h2>
                <p>Proses evaluasi yang sistematis dari pengumpulan data hingga menghasilkan insight strategis.</p>
            </div>
            <div class="row g-0">
                @foreach([
                    ['num' => '1', 'title' => 'Pengisian Kuesioner',  'desc' => 'Siswa dan sesama guru mengisi kuesioner kompetensi secara digital melalui sistem.'],
                    ['num' => '2', 'title' => 'Absensi & Prestasi',   'desc' => 'Guru melakukan absensi via RFID dan upload sertifikat/prestasi ke sistem.'],
                    ['num' => '3', 'title' => 'Pengolahan Data',      'desc' => 'Sistem mengagregasi semua data dan menghitung rata-rata nilai per kompetensi.'],
                    ['num' => '4', 'title' => 'Analisis K-Means',     'desc' => 'Algoritma K-Means mengelompokkan guru ke cluster A, B, C, atau D secara otomatis.'],
                    ['num' => '5', 'title' => 'Dashboard & Laporan',  'desc' => 'Kepala sekolah melihat hasil, distribusi cluster, dan rekomendasi tindak lanjut.'],
                ] as $s)
                    <div class="col position-relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="step-card">
                            <div class="step-number">{{ $s['num'] }}</div>
                            @if(!$loop->last)
                                <div class="step-connector"></div>
                            @endif
                            <h4>{{ $s['title'] }}</h4>
                            <p>{{ $s['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         ROLES
    ══════════════════════════════════════ --}}
    <section id="roles">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="badge-label">Pengguna Sistem</span>
                <h2>Dirancang untuk Semua Pemangku Kepentingan</h2>
                <p>Setiap role memiliki akses dan fitur yang disesuaikan dengan kebutuhan masing-masing.</p>
            </div>
            <div class="row g-4">
                @foreach([
                    ['icon' => '👨‍🎓', 'bg' => 'rgba(59,130,246,0.08)',  'border' => 'rgba(59,130,246,0.15)', 'color' => '#3b82f6',
                     'role' => 'Siswa', 'desc' => 'Memberikan penilaian objektif terhadap guru yang mengajar di kelasnya.',
                     'list' => ['Mengisi kuesioner evaluasi guru', 'Skala Likert 1-5 per indikator', 'Satu penilaian per guru per semester']],
                    ['icon' => '👨‍🏫', 'bg' => 'rgba(249,115,22,0.08)',  'border' => 'rgba(249,115,22,0.15)', 'color' => '#f97316',
                     'role' => 'Guru', 'desc' => 'Menilai rekan sejawat, mencatat kehadiran, dan mengelola portofolio profesional.',
                     'list' => ['Menilai sesama guru (peer assessment)', 'Absensi RFID harian', 'Upload prestasi & sertifikasi']],
                    ['icon' => '👨‍💼', 'bg' => 'rgba(16,185,129,0.08)',  'border' => 'rgba(16,185,129,0.15)', 'color' => '#10b981',
                     'role' => 'Kepala Sekolah', 'desc' => 'Memantau dashboard analitik dan menggunakan hasil clustering untuk pengambilan keputusan.',
                     'list' => ['Melihat dashboard distribusi cluster', 'Laporan evaluasi per guru', 'Rekomendasi tindak lanjut']],
                    ['icon' => '👨‍💻', 'bg' => 'rgba(139,92,246,0.08)', 'border' => 'rgba(139,92,246,0.15)', 'color' => '#8b5cf6',
                     'role' => 'Administrator', 'desc' => 'Mengelola seluruh data sistem, validasi prestasi, dan menjalankan proses clustering.',
                     'list' => ['Manajemen pengguna & akses', 'Validasi prestasi guru', 'Jalankan K-Means Clustering']],
                ] as $r)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="role-card" style="background: {{ $r['bg'] }}; border-color: {{ $r['border'] }};">
                            <div class="role-icon" style="background: {{ $r['bg'] }}; font-size:32px;">
                                {{ $r['icon'] }}
                            </div>
                            <h4>{{ $r['role'] }}</h4>
                            <p>{{ $r['desc'] }}</p>
                            <ul class="role-feature-list">
                                @foreach($r['list'] as $item)
                                    <li>
                                        <i class="bi bi-check-circle-fill" style="color: {{ $r['color'] }};"></i>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         STATS
    ══════════════════════════════════════ --}}
    <section id="stats">
        <div class="container position-relative" style="z-index:1">
            <div class="row g-0 text-center">
                @foreach([
                    ['num' => '4',   'suffix' => '', 'label' => 'Kompetensi yang Dinilai'],
                    ['num' => '25',  'suffix' => '+','label' => 'Butir Pertanyaan Kuesioner'],
                    ['num' => '4',   'suffix' => '', 'label' => 'Cluster Kualitas Guru'],
                    ['num' => '100', 'suffix' => '%','label' => 'Berbasis Data & AI'],
                ] as $stat)
                    <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="stat-item">
                            <div class="num">{{ $stat['num'] }}<span style="font-size:32px">{{ $stat['suffix'] }}</span></div>
                            <div class="label">{{ $stat['label'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CTA
    ══════════════════════════════════════ --}}
    <section id="cta">
        <div class="container" data-aos="zoom-in">
            <div class="cta-inner">
                <h2>Siap Meningkatkan Kualitas Pendidikan?</h2>
                <p>Mulai gunakan STQM sekarang dan dapatkan gambaran objektif kualitas guru di sekolah Anda berbasis data dan kecerdasan buatan.</p>
                <a href="{{ route('login') }}" class="btn-cta">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk ke Sistem
                </a>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FOOTER
    ══════════════════════════════════════ --}}
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand d-flex align-items-center gap-2 mb-16">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:36px;height:36px;border-radius:10px;object-fit:cover;">
                        <span class="logo-text">STQM</span>
                    </div>
                    <p style="margin-top:12px;">
                        Smart Teacher Quality Mapping — Sistem pemetaan kualitas guru berbasis data dan kecerdasan buatan untuk mendukung peningkatan mutu pendidikan.
                    </p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Navigasi</h6>
                    <ul>
                        <li><a href="#hero">Beranda</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#how-it-works">Alur Sistem</a></li>
                        <li><a href="#roles">Pengguna</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Fitur</h6>
                    <ul>
                        <li><a href="#">Kuesioner Evaluasi</a></li>
                        <li><a href="#">Absensi RFID</a></li>
                        <li><a href="#">Data Prestasi</a></li>
                        <li><a href="#">K-Means Clustering</a></li>
                        <li><a href="#">Dashboard Analitik</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6>Kompetensi yang Dinilai</h6>
                    <ul>
                        @foreach(['Kompetensi Pedagogik', 'Kompetensi Kepribadian', 'Kompetensi Sosial', 'Kompetensi Profesional'] as $k)
                            <li>
                                <a href="#" style="display:flex; align-items:center; gap:8px;">
                                    <i class="bi bi-check2-circle" style="color:var(--primary)"></i>
                                    {{ $k }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p style="margin:0;">
                    © {{ date('Y') }} <strong style="color:var(--primary)">STQM</strong> — Smart Teacher Quality Mapping.
                    Designed with <i class="bi bi-heart-fill" style="color:#ef4444; font-size:11px;"></i> for Education.
                    <br>
                    <span style="font-size:12px; color:#334155;">
                        Template based on <a href="https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/" style="color:var(--primary);">Arsha by BootstrapMade</a>
                    </span>
                </p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('arsha/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <script>
        // ── AOS Init ──
        AOS.init({ duration: 700, easing: 'ease-in-out', once: true, mirror: false });

        // ── Navbar scroll effect ──
        window.addEventListener('scroll', function () {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // ── Active nav link on scroll ──
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(s => {
                if (window.scrollY >= s.offsetTop - 100) current = s.getAttribute('id');
            });
            document.querySelectorAll('nav ul a').forEach(a => {
                a.classList.remove('active');
                if (a.getAttribute('href') === '#' + current) a.classList.add('active');
            });
        });

        // ── Mobile nav ──
        function toggleMobileNav() {
            const nav  = document.getElementById('navbar');
            const icon = document.getElementById('nav-icon');
            nav.classList.toggle('open');
            icon.className = nav.classList.contains('open') ? 'bi bi-x' : 'bi bi-list';
        }

        // ── Smooth scroll ──
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                    // Close mobile nav if open
                    document.getElementById('navbar').classList.remove('open');
                    document.getElementById('nav-icon').className = 'bi bi-list';
                }
            });
        });
    </script>

</body>
</html>
