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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,900;1,9..144,700&display=swap" rel="stylesheet">

    {{-- Bootstrap + Icons --}}
    <link href="{{ asset('arsha/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           DESIGN TOKENS — satu sumber kebenaran
           Digunakan di welcome.blade.php DAN login.blade.php
        ══════════════════════════════════════ */
        :root {
            /* Brand */
            --clr-primary:        #EA580C; /* orange-600 */
            --clr-primary-hover:  #C2410C; /* orange-700 */
            --clr-primary-light:  rgba(234,88,12,0.08);
            --clr-primary-border: rgba(234,88,12,0.2);
            --clr-accent:         #D97706; /* amber-600 — gradient pair */

            /* Surfaces */
            --clr-bg-page:        #F8F7F4; /* warm stone */
            --clr-bg-hero:        #FEFCF8; /* cream warm */
            --clr-bg-section-alt: #F3F1EC; /* slightly deeper stone */
            --clr-bg-card:        #FFFFFF;
            --clr-bg-dark:        #1C1917; /* stone-900 — footer, stats */
            --clr-bg-dark2:       #292524; /* stone-800 */

            /* Text */
            --clr-text-primary:   #1C1917; /* stone-900 */
            --clr-text-secondary: #44403C; /* stone-700 */
            --clr-text-muted:     #78716C; /* stone-500 */
            --clr-text-faint:     #A8A29E; /* stone-400 */
            --clr-text-on-dark:   #F5F5F4; /* stone-100 */
            --clr-text-muted-dark:#A8A29E; /* stone-400 — on dark bg */

            /* Borders */
            --clr-border:         #E8E4DC; /* warm border */
            --clr-border-hover:   #D6CFC4;

            /* Shadow */
            --shadow-card:        0 4px 24px rgba(28,25,23,0.07);
            --shadow-card-hover:  0 16px 48px rgba(28,25,23,0.11);
            --shadow-cta:         0 8px 28px rgba(234,88,12,0.3);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--clr-bg-page);
            color: var(--clr-text-primary);
            overflow-x: hidden;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--clr-bg-section-alt); }
        ::-webkit-scrollbar-thumb { background: var(--clr-primary); border-radius: 3px; }

        /* ══════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════ */
        #header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 999;
            padding: 18px 0;
            transition: all .35s ease;
        }

        #header.scrolled {
            background: rgba(254,252,248,0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 1px 0 var(--clr-border), 0 4px 20px rgba(28,25,23,0.06);
            padding: 12px 0;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-wrapper img {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            object-fit: cover;
        }

        .logo-wrapper .logo-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 19px;
            color: var(--clr-text-primary);
            letter-spacing: -0.5px;
        }

        .logo-wrapper .logo-sub {
            font-size: 10px;
            color: var(--clr-text-muted);
            display: block;
            line-height: 1;
            margin-top: 1px;
            font-weight: 400;
        }

        nav ul {
            list-style: none;
            margin: 0; padding: 0;
            display: flex;
            gap: 4px;
        }

        nav ul a {
            text-decoration: none;
            color: var(--clr-text-secondary);
            font-size: 14px;
            font-weight: 500;
            padding: 7px 15px;
            border-radius: 8px;
            transition: all .2s;
        }

        nav ul a:hover, nav ul a.active {
            color: var(--clr-primary);
            background: var(--clr-primary-light);
        }

        .btn-login {
            background: var(--clr-primary);
            color: white !important;
            font-size: 14px;
            font-weight: 700;
            padding: 9px 22px;
            border-radius: 9px;
            text-decoration: none;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-login:hover {
            background: var(--clr-primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-cta);
            color: white;
        }

        /* ══════════════════════════════════════
           HERO
        ══════════════════════════════════════ */
        #hero {
            min-height: 100vh;
            background: var(--clr-bg-hero);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            border-bottom: 1px solid var(--clr-border);
        }

        /* Subtle warm radial — tidak terasa "gaming" */
        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 80% at 85% 30%, rgba(234,88,12,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 5%  85%, rgba(217,119,6,0.05) 0%, transparent 55%);
            pointer-events: none;
        }

        /* Dot grid — sangat subtle */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(28,25,23,0.06) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--clr-primary-light);
            border: 1px solid var(--clr-primary-border);
            color: var(--clr-primary-hover);
            font-size: 12px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 22px;
            letter-spacing: 0.2px;
        }

        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--clr-primary);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.75); }
        }

        .hero h1 {
            font-family: 'Fraunces', serif;
            font-size: clamp(2.4rem, 4.5vw, 3.6rem);
            font-weight: 900;
            color: var(--clr-text-primary);
            line-height: 1.08;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }

        .hero h1 .highlight {
            color: var(--clr-primary);
        }

        .hero p.lead {
            font-size: 16px;
            color: var(--clr-text-muted);
            line-height: 1.8;
            max-width: 500px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: var(--clr-primary);
            color: white;
            font-size: 14px;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 10px;
            text-decoration: none;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(234,88,12,0.28);
        }

        .btn-hero-primary:hover {
            background: var(--clr-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(234,88,12,0.35);
            color: white;
        }

        .btn-hero-secondary {
            background: var(--clr-bg-card);
            border: 1.5px solid var(--clr-border);
            color: var(--clr-text-secondary);
            font-size: 14px;
            font-weight: 600;
            padding: 13px 28px;
            border-radius: 10px;
            text-decoration: none;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-secondary:hover {
            border-color: var(--clr-primary-border);
            color: var(--clr-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-card);
        }

        /* Hero stats bar */
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid var(--clr-border);
            flex-wrap: wrap;
        }

        .hero-stat-item .num {
            font-family: 'Fraunces', serif;
            font-size: 30px;
            font-weight: 900;
            color: var(--clr-primary);
            line-height: 1;
            letter-spacing: -1px;
        }

        .hero-stat-item .label {
            font-size: 12px;
            color: var(--clr-text-faint);
            margin-top: 3px;
            font-weight: 500;
        }

        /* Hero card — cluster preview */
        .hero-card {
            background: var(--clr-bg-card);
            border: 1px solid var(--clr-border);
            border-radius: 20px;
            padding: 28px;
            box-shadow: var(--shadow-card);
        }

        .hero-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
        }

        .hero-card-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
        }

        .cluster-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 10px;
            border: 1px solid transparent;
            transition: border-color .2s;
        }

        .cluster-item:hover {
            border-color: currentColor;
        }

        .cluster-bar-bg {
            flex: 1;
            height: 5px;
            background: rgba(28,25,23,0.08);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 6px;
        }

        .cluster-bar {
            height: 100%;
            border-radius: 3px;
        }

        /* ══════════════════════════════════════
           SECTION COMMON
        ══════════════════════════════════════ */
        section { padding: 90px 0; }

        .section-title {
            text-align: center;
            margin-bottom: 56px;
        }

        .section-title .badge-label {
            display: inline-block;
            background: var(--clr-primary-light);
            border: 1px solid var(--clr-primary-border);
            color: var(--clr-primary-hover);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 14px;
        }

        .section-title h2 {
            font-family: 'Fraunces', serif;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 900;
            color: var(--clr-text-primary);
            letter-spacing: -1px;
            margin-bottom: 14px;
            line-height: 1.1;
        }

        .section-title p {
            color: var(--clr-text-muted);
            font-size: 15px;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ══════════════════════════════════════
           ABOUT
        ══════════════════════════════════════ */
        #about {
            background: var(--clr-bg-section-alt);
        }

        .about-img-wrapper {
            position: relative;
        }

        .about-img-wrapper img {
            border-radius: 20px;
            width: 100%;
            object-fit: cover;
            box-shadow: var(--shadow-card);
        }

        .about-badge-float {
            position: absolute;
            bottom: -20px;
            right: -16px;
            background: white;
            border: 1px solid var(--clr-border);
            border-radius: 16px;
            padding: 18px 22px;
            box-shadow: var(--shadow-card-hover);
            text-align: center;
        }

        .about-badge-float .big-num {
            font-family: 'Fraunces', serif;
            font-size: 34px;
            font-weight: 900;
            color: var(--clr-primary);
            line-height: 1;
        }

        .about-check-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .about-check-icon {
            width: 26px; height: 26px;
            border-radius: 8px;
            background: var(--clr-primary-light);
            border: 1px solid var(--clr-primary-border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .about-check-icon i {
            font-size: 12px;
            color: var(--clr-primary);
        }

        /* ══════════════════════════════════════
           FEATURES
        ══════════════════════════════════════ */
        #features {
            background: var(--clr-bg-hero);
        }

        .feature-card {
            background: var(--clr-bg-card);
            border: 1px solid var(--clr-border);
            border-radius: 18px;
            padding: 28px 24px;
            height: 100%;
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--clr-primary), var(--clr-accent));
            opacity: 0;
            transition: opacity .3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
            border-color: var(--clr-primary-border);
        }

        .feature-card:hover::after { opacity: 1; }

        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 22px;
        }

        .feature-card h4 {
            font-weight: 700;
            font-size: 16px;
            color: var(--clr-text-primary);
            margin-bottom: 9px;
        }

        .feature-card p {
            font-size: 13.5px;
            color: var(--clr-text-muted);
            line-height: 1.75;
            margin: 0;
        }

        /* ══════════════════════════════════════
           HOW IT WORKS
        ══════════════════════════════════════ */
        #how-it-works {
            background: var(--clr-bg-section-alt);
        }

        .step-card {
            text-align: center;
            padding: 36px 20px;
            position: relative;
        }

        .step-number {
            width: 60px; height: 60px;
            border-radius: 16px;
            background: var(--clr-primary);
            color: white;
            font-family: 'Fraunces', serif;
            font-size: 22px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 6px 20px rgba(234,88,12,0.28);
        }

        .step-connector {
            position: absolute;
            top: 68px;
            right: -18px;
            width: 36px;
            height: 2px;
            background: var(--clr-primary);
            opacity: 0.2;
        }

        .step-card h4 {
            font-weight: 700;
            font-size: 15px;
            color: var(--clr-text-primary);
            margin-bottom: 9px;
        }

        .step-card p {
            font-size: 13px;
            color: var(--clr-text-muted);
            line-height: 1.7;
            margin: 0;
        }

        /* ══════════════════════════════════════
           ROLES
        ══════════════════════════════════════ */
        #roles {
            background: var(--clr-bg-hero);
        }

        .role-card {
            border-radius: 18px;
            padding: 32px 24px;
            height: 100%;
            transition: all .3s;
            border: 1px solid transparent;
        }

        .role-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card-hover);
        }

        .role-card h4 {
            font-weight: 700;
            font-size: 17px;
            color: var(--clr-text-primary);
            margin-bottom: 10px;
        }

        .role-card p {
            font-size: 13.5px;
            color: var(--clr-text-muted);
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .role-feature-list {
            list-style: none;
            padding: 0; margin: 0;
        }

        .role-feature-list li {
            font-size: 13px;
            color: var(--clr-text-secondary);
            padding: 7px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid rgba(28,25,23,0.06);
        }

        .role-feature-list li:last-child { border-bottom: none; }

        /* ══════════════════════════════════════
           STATS — satu-satunya seksi dark
        ══════════════════════════════════════ */
        #stats {
            background: var(--clr-bg-dark);
            position: relative;
            overflow: hidden;
        }

        #stats::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 70% at 50% 50%, rgba(234,88,12,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .stat-item {
            text-align: center;
            padding: 48px 20px;
        }

        .stat-item .num {
            font-family: 'Fraunces', serif;
            font-size: 52px;
            font-weight: 900;
            color: var(--clr-primary);
            line-height: 1;
            margin-bottom: 12px;
            letter-spacing: -2px;
        }

        .stat-item .label {
            font-size: 14px;
            color: var(--clr-text-muted-dark);
            font-weight: 500;
        }

        /* ══════════════════════════════════════
           CTA
        ══════════════════════════════════════ */
        #cta {
            background: var(--clr-bg-section-alt);
            border-top: 1px solid var(--clr-border);
        }

        .cta-inner {
            background: var(--clr-primary);
            border-radius: 24px;
            padding: 68px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-inner::before {
            content: '';
            position: absolute;
            top: -40%; right: -15%;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            pointer-events: none;
        }

        .cta-inner::after {
            content: '';
            position: absolute;
            bottom: -30%; left: -8%;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .cta-inner h2 {
            font-family: 'Fraunces', serif;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 900;
            color: white;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .cta-inner p {
            color: rgba(255,255,255,0.82);
            font-size: 15px;
            margin-bottom: 32px;
            position: relative;
            z-index: 1;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
        }

        .btn-cta {
            background: white;
            color: var(--clr-primary-hover);
            font-weight: 700;
            font-size: 14px;
            padding: 13px 32px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s;
            position: relative;
            z-index: 1;
            box-shadow: 0 6px 24px rgba(28,25,23,0.18);
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(28,25,23,0.22);
            color: var(--clr-primary);
        }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        footer {
            background: var(--clr-bg-dark);
            border-top: 1px solid rgba(255,255,255,0.06);
            color: var(--clr-text-muted-dark);
            padding: 60px 0 24px;
        }

        footer .footer-logo-text {
            font-weight: 800;
            font-size: 20px;
            color: var(--clr-text-on-dark);
            letter-spacing: -0.5px;
        }

        footer p {
            font-size: 13.5px;
            line-height: 1.75;
            color: #6B7280;
        }

        footer h6 {
            font-weight: 700;
            color: var(--clr-text-on-dark);
            margin-bottom: 14px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        footer ul {
            list-style: none;
            padding: 0; margin: 0;
        }

        footer ul li a {
            color: #6B7280;
            text-decoration: none;
            font-size: 13.5px;
            transition: color .2s;
            display: block;
            padding: 4px 0;
        }

        footer ul li a:hover { color: var(--clr-primary); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 22px;
            margin-top: 40px;
            text-align: center;
            font-size: 12.5px;
            color: #4B5563;
        }

        /* ══════════════════════════════════════
           MOBILE MENU
        ══════════════════════════════════════ */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--clr-text-secondary);
            cursor: pointer;
        }

        @media (max-width: 991px) {
            .mobile-nav-toggle { display: block; }
            nav { display: none; }
            nav.open {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(254,252,248,0.98);
                backdrop-filter: blur(20px);
                z-index: 9998;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            nav.open ul {
                flex-direction: column;
                text-align: center;
                gap: 6px;
            }
            nav.open ul a { font-size: 18px; padding: 12px 24px; }
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
                    <li><a href="#hero"         class="active">Beranda</a></li>
                    <li><a href="#about"                      >Tentang</a></li>
                    <li><a href="#features"                   >Fitur</a></li>
                    <li><a href="#how-it-works"               >Alur</a></li>
                    <li><a href="#roles"                      >Pengguna</a></li>
                </ul>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('login') }}" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
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
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="700">
                    <div class="hero-badge">
                        <span class="hero-badge-dot"></span>
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
                            Mulai Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#about" class="btn-hero-secondary">
                            <i class="bi bi-play-circle"></i> Pelajari Lebih Lanjut
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

                {{-- Right — Cluster card --}}
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="700" data-aos-delay="150">
                    <div class="hero-card">
                        <div class="hero-card-header">
                            <div class="hero-card-dot" style="background:#EF4444"></div>
                            <div class="hero-card-dot" style="background:#F59E0B"></div>
                            <div class="hero-card-dot" style="background:#22C55E"></div>
                            <span style="color:var(--clr-text-faint); font-size:12px; margin-left:8px; font-weight:500;">
                                Hasil Clustering K-Means
                            </span>
                        </div>

                        @foreach([
                            ['label'=>'Cluster A — Sangat Baik',     'pct'=>35, 'color'=>'#16A34A', 'bg'=>'rgba(22,163,74,0.07)',  'bar'=>'#22C55E'],
                            ['label'=>'Cluster B — Baik',            'pct'=>40, 'color'=>'#1D4ED8', 'bg'=>'rgba(29,78,216,0.07)',  'bar'=>'#3B82F6'],
                            ['label'=>'Cluster C — Cukup',           'pct'=>18, 'color'=>'#B45309', 'bg'=>'rgba(217,119,6,0.07)',  'bar'=>'#F59E0B'],
                            ['label'=>'Cluster D — Perlu Pembinaan', 'pct'=>7,  'color'=>'#B91C1C', 'bg'=>'rgba(239,68,68,0.07)',  'bar'=>'#EF4444'],
                        ] as $c)
                            <div class="cluster-item" style="background:{{ $c['bg'] }};">
                                <div style="flex:1">
                                    <div style="font-size:13px; font-weight:600; color:{{ $c['color'] }};">{{ $c['label'] }}</div>
                                    <div class="cluster-bar-bg">
                                        <div class="cluster-bar" style="width:{{ $c['pct'] }}%; background:{{ $c['bar'] }};"></div>
                                    </div>
                                </div>
                                <div style="font-size:17px; font-weight:800; color:{{ $c['color'] }}; margin-left:16px;">
                                    {{ $c['pct'] }}%
                                </div>
                            </div>
                        @endforeach

                        <div style="margin-top:18px; padding-top:14px; border-top:1px solid var(--clr-border); display:flex; align-items:center; gap:8px;">
                            <div style="width:7px;height:7px;border-radius:50%;background:#22C55E;"></div>
                            <span style="font-size:12px; color:var(--clr-text-faint); font-weight:500;">Clustering diperbarui hari ini</span>
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
                        <img src="{{ asset('arsha/assets/img/why-us.png') }}" alt="Tentang STQM">
                        <div class="about-badge-float">
                            <div class="big-num">4</div>
                            <div style="font-size:12px; color:var(--clr-text-muted); font-weight:600; margin-top:2px;">Kompetensi Guru</div>
                            <div style="font-size:10px; color:var(--clr-text-faint);">Permendiknas No.16/2007</div>
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
                    @foreach([
                        ['Kuesioner Multi-Penilai',        'Evaluasi dari perspektif siswa, sesama guru, dan penilaian diri sendiri untuk hasil yang menyeluruh.'],
                        ['Absensi RFID Terintegrasi',      'Data kehadiran otomatis dari sistem RFID sebagai indikator kedisiplinan guru.'],
                        ['Analisis K-Means Clustering',    'Algoritma machine learning mengelompokkan guru ke 4 cluster berdasarkan profil kompetensi mereka.'],
                        ['Dashboard & Laporan Real-time',  'Kepala sekolah dapat memantau performa dan distribusi kualitas guru secara langsung.'],
                    ] as $item)
                        <div class="about-check-item">
                            <div class="about-check-icon">
                                <i class="bi bi-check2"></i>
                            </div>
                            <div>
                                <strong style="font-size:14.5px; color:var(--clr-text-primary);">{{ $item[0] }}</strong>
                                <p style="font-size:13.5px; color:var(--clr-text-muted); margin:4px 0 0; line-height:1.7;">{{ $item[1] }}</p>
                            </div>
                        </div>
                    @endforeach
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
                    ['bi-journal-check',        'rgba(234,88,12,0.09)',  '#EA580C', 'Sistem Kuesioner',      'Kuesioner digital berbasis indikator kompetensi Permendiknas No.16/2007 dengan skala Likert 1-5. Diisi oleh siswa dan sesama guru.'],
                    ['bi-credit-card-2-front',  'rgba(29,78,216,0.09)',  '#2563EB', 'Absensi RFID',          'Sistem scan kartu otomatis untuk mencatat kehadiran guru setiap hari. Data kedisiplinan tercatat akurat dan real-time.'],
                    ['bi-trophy',               'rgba(180,83,9,0.09)',   '#B45309', 'Data Prestasi Guru',    'Upload dan kelola sertifikat, penghargaan, dan portofolio profesional guru dengan sistem validasi oleh admin.'],
                    ['bi-cpu',                  'rgba(109,40,217,0.09)', '#7C3AED', 'K-Means Clustering',    'Algoritma machine learning mengelompokkan guru ke 4 cluster (A/B/C/D) berdasarkan 4 dimensi kompetensi secara otomatis.'],
                    ['bi-bar-chart-line',       'rgba(5,150,105,0.09)',  '#059669', 'Dashboard Analisis',    'Visualisasi distribusi cluster, grafik kompetensi, dan statistik performa guru yang interaktif untuk pengambilan keputusan.'],
                    ['bi-file-earmark-text',    'rgba(220,38,38,0.09)',  '#DC2626', 'Laporan Evaluasi',      'Generate laporan lengkap per guru beserta rekomendasi tindak lanjut berdasarkan hasil clustering. Dapat diexport ke Excel.'],
                ] as $f)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 70 }}">
                        <div class="feature-card">
                            <div class="feature-icon" style="background:{{ $f[1] }};">
                                <i class="bi {{ $f[0] }}" style="color:{{ $f[2] }};"></i>
                            </div>
                            <h4>{{ $f[3] }}</h4>
                            <p>{{ $f[4] }}</p>
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
                    ['1', 'Pengisian Kuesioner', 'Siswa dan sesama guru mengisi kuesioner kompetensi secara digital melalui sistem.'],
                    ['2', 'Absensi & Prestasi',  'Guru melakukan absensi via RFID dan upload sertifikat/prestasi ke sistem.'],
                    ['3', 'Pengolahan Data',     'Sistem mengagregasi semua data dan menghitung rata-rata nilai per kompetensi.'],
                    ['4', 'Analisis K-Means',    'Algoritma K-Means mengelompokkan guru ke cluster A, B, C, atau D secara otomatis.'],
                    ['5', 'Dashboard & Laporan', 'Kepala sekolah melihat hasil, distribusi cluster, dan rekomendasi tindak lanjut.'],
                ] as $s)
                    <div class="col position-relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 90 }}">
                        <div class="step-card">
                            <div class="step-number">{{ $s[0] }}</div>
                            @if(!$loop->last)
                                <div class="step-connector"></div>
                            @endif
                            <h4>{{ $s[1] }}</h4>
                            <p>{{ $s[2] }}</p>
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
                    ['👨‍🎓', 'rgba(29,78,216,0.07)',  'rgba(29,78,216,0.15)',  '#2563EB', 'Siswa',           'Memberikan penilaian objektif terhadap guru yang mengajar di kelasnya.',
                     ['Mengisi kuesioner evaluasi guru', 'Skala Likert 1-5 per indikator', 'Satu penilaian per guru per semester']],
                    ['👨‍🏫', 'rgba(234,88,12,0.07)',   'rgba(234,88,12,0.15)',   '#EA580C', 'Guru',            'Menilai rekan sejawat, mencatat kehadiran, dan mengelola portofolio profesional.',
                     ['Menilai sesama guru (peer assessment)', 'Absensi RFID harian', 'Upload prestasi & sertifikasi']],
                    ['👨‍💼', 'rgba(5,150,105,0.07)',   'rgba(5,150,105,0.15)',   '#059669', 'Kepala Sekolah',  'Memantau dashboard analitik dan menggunakan hasil clustering untuk pengambilan keputusan.',
                     ['Melihat dashboard distribusi cluster', 'Laporan evaluasi per guru', 'Rekomendasi tindak lanjut']],
                    ['👨‍💻', 'rgba(109,40,217,0.07)', 'rgba(109,40,217,0.15)', '#7C3AED', 'Administrator',   'Mengelola seluruh data sistem, validasi prestasi, dan menjalankan proses clustering.',
                     ['Manajemen pengguna & akses', 'Validasi prestasi guru', 'Jalankan K-Means Clustering']],
                ] as $r)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 90 }}">
                        <div class="role-card" style="background:{{ $r[1] }}; border-color:{{ $r[2] }};">
                            <div style="font-size:32px; margin-bottom:16px;">{{ $r[0] }}</div>
                            <h4>{{ $r[4] }}</h4>
                            <p>{{ $r[5] }}</p>
                            <ul class="role-feature-list">
                                @foreach($r[6] as $item)
                                    <li>
                                        <i class="bi bi-check-circle-fill" style="color:{{ $r[3] }}; font-size:13px;"></i>
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
                    ['4',   '',  'Kompetensi yang Dinilai'],
                    ['25',  '+', 'Butir Pertanyaan Kuesioner'],
                    ['4',   '',  'Cluster Kualitas Guru'],
                    ['100', '%', 'Berbasis Data & AI'],
                ] as $stat)
                    <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="stat-item">
                            <div class="num">{{ $stat[0] }}<span style="font-size:30px">{{ $stat[1] }}</span></div>
                            <div class="label">{{ $stat[2] }}</div>
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
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:34px;height:34px;border-radius:9px;object-fit:cover;">
                        <span class="footer-logo-text">STQM</span>
                    </div>
                    <p>
                        Smart Teacher Quality Mapping — Sistem pemetaan kualitas guru berbasis data dan kecerdasan buatan untuk mendukung peningkatan mutu pendidikan.
                    </p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Navigasi</h6>
                    <ul>
                        @foreach(['Beranda'=>'#hero','Tentang'=>'#about','Fitur'=>'#features','Alur Sistem'=>'#how-it-works','Pengguna'=>'#roles'] as $label => $href)
                            <li><a href="{{ $href }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Fitur</h6>
                    <ul>
                        @foreach(['Kuesioner Evaluasi','Absensi RFID','Data Prestasi','K-Means Clustering','Dashboard Analitik'] as $f)
                            <li><a href="#">{{ $f }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6>Kompetensi yang Dinilai</h6>
                    <ul>
                        @foreach(['Kompetensi Pedagogik','Kompetensi Kepribadian','Kompetensi Sosial','Kompetensi Profesional'] as $k)
                            <li>
                                <a href="#" style="display:flex;align-items:center;gap:8px;">
                                    <i class="bi bi-check2-circle" style="color:var(--clr-primary);font-size:13px;"></i>
                                    {{ $k }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                © {{ date('Y') }} <strong style="color:var(--clr-primary)">STQM</strong> — Smart Teacher Quality Mapping.
                Designed with <i class="bi bi-heart-fill" style="color:#EF4444;font-size:10px;"></i> for Education.
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('arsha/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <script>
        AOS.init({ duration: 650, easing: 'ease-out', once: true });

        // Navbar scroll
        window.addEventListener('scroll', () => {
            document.getElementById('header').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Active nav on scroll
        const sections = document.querySelectorAll('section[id]');
        window.addEventListener('scroll', () => {
            let cur = '';
            sections.forEach(s => { if (window.scrollY >= s.offsetTop - 110) cur = s.id; });
            document.querySelectorAll('nav ul a').forEach(a => {
                a.classList.toggle('active', a.getAttribute('href') === '#' + cur);
            });
        });

        // Mobile nav
        function toggleMobileNav() {
            const nav  = document.getElementById('navbar');
            const icon = document.getElementById('nav-icon');
            nav.classList.toggle('open');
            icon.className = nav.classList.contains('open') ? 'bi bi-x' : 'bi bi-list';
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                    document.getElementById('navbar').classList.remove('open');
                    document.getElementById('nav-icon').className = 'bi bi-list';
                }
            });
        });
    </script>

</body>
</html>
