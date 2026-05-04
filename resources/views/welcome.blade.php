<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>STQM — Smart Teacher Quality Mapping</title>
    <meta name="description" content="Sistem pemetaan kualitas guru berbasis data kuesioner, absensi RFID, dan analisis K-Means Clustering.">

    <link href="{{ asset('images/logo.png') }}" rel="icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">

    <link href="{{ asset('arsha/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           DESIGN TOKENS — Blue Professional
           Sinkron dengan login.blade.php & app.blade.php (light mode)
        ══════════════════════════════════════ */
        :root {
            /* Brand blue */
            --blue-600:   #2563EB;
            --blue-700:   #1D4ED8;
            --blue-800:   #1E40AF;
            --blue-900:   #1E3A8A;
            --blue-soft:  rgba(29,78,216,0.08);
            --blue-ring:  rgba(29,78,216,0.18);
            --blue-border:rgba(29,78,216,0.14);

            /* Surfaces */
            --bg-page:    #F0F5FF;   /* biru-slate muda */
            --bg-hero:    #F8FAFF;   /* nyaris putih dengan hint biru */
            --bg-card:    #FFFFFF;
            --bg-alt:     #EBF2FF;   /* section alt */

            /* Text */
            --txt-main:   #0F172A;   /* slate-900 */
            --txt-sub:    #334155;   /* slate-700 */
            --txt-muted:  #64748B;   /* slate-500 */
            --txt-faint:  #94A3B8;   /* slate-400 */
            --txt-ondark: #F1F5F9;   /* slate-100 */

            /* Border */
            --border:     #E2E8F0;   /* slate-200 */
            --border-b:   rgba(29,78,216,0.1);

            /* Dark section (stats & footer) */
            --bg-dark:    #0F172A;   /* slate-900 */
            --bg-dark2:   #1E293B;   /* slate-800 */

            /* Shadows */
            --shadow-sm:  0 2px 8px rgba(15,23,42,0.06);
            --shadow-md:  0 4px 20px rgba(15,23,42,0.08);
            --shadow-lg:  0 16px 48px rgba(15,23,42,0.10);
            --shadow-btn: 0 4px 16px rgba(29,78,216,0.28);

            /* Cluster colors */
            --c-a: #16A34A; --c-a-bg: rgba(22,163,74,0.08);
            --c-b: #2563EB; --c-b-bg: rgba(37,99,235,0.08);
            --c-c: #D97706; --c-c-bg: rgba(217,119,6,0.08);
            --c-d: #DC2626; --c-d-bg: rgba(220,38,38,0.08);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            color: var(--txt-main);
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-alt); }
        ::-webkit-scrollbar-thumb { background: var(--blue-700); border-radius: 3px; }

        /* ══════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════ */
        #header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 999;
            padding: 18px 0;
            transition: all .3s ease;
        }

        #header.scrolled {
            background: rgba(248,250,255,0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 1px 0 var(--border-b), var(--shadow-sm);
            padding: 11px 0;
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-wrap img {
            width: 34px; height: 34px;
            border-radius: 9px;
            object-fit: cover;
            box-shadow: 0 3px 10px rgba(29,78,216,0.2);
        }

        .logo-name {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 18px;
            color: var(--txt-main);
            letter-spacing: -0.4px;
        }

        .logo-sub {
            font-size: 10px;
            color: var(--txt-faint);
            display: block;
            font-weight: 400;
            margin-top: 1px;
        }

        nav ul { list-style: none; margin: 0; padding: 0; display: flex; gap: 2px; }

        nav ul a {
            text-decoration: none;
            color: var(--txt-sub);
            font-size: 13.5px;
            font-weight: 500;
            padding: 7px 14px;
            border-radius: 8px;
            transition: all .2s;
        }

        nav ul a:hover, nav ul a.active {
            color: var(--blue-700);
            background: var(--blue-soft);
        }

        .btn-nav-login {
            background: var(--blue-700);
            color: #fff !important;
            font-size: 13.5px;
            font-weight: 700;
            padding: 9px 22px;
            border-radius: 9px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .25s;
            box-shadow: var(--shadow-btn);
        }

        .btn-nav-login:hover {
            background: var(--blue-800);
            transform: translateY(-1px);
            color: #fff;
        }

        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--txt-sub);
            cursor: pointer;
        }

        /* ══════════════════════════════════════
           HERO
        ══════════════════════════════════════ */
        #hero {
            min-height: 100vh;
            background: var(--bg-hero);
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid var(--border-b);
        }

        .hero-deco-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(29,78,216,0.07) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .hero-glow-1 {
            position: absolute;
            width: 500px; height: 500px;
            top: -100px; right: -80px;
            background: radial-gradient(circle, rgba(37,99,235,0.09) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-glow-2 {
            position: absolute;
            width: 350px; height: 350px;
            bottom: -60px; left: 5%;
            background: radial-gradient(circle, rgba(29,78,216,0.06) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--blue-soft);
            border: 1px solid var(--blue-border);
            color: var(--blue-800);
            font-size: 11.5px;
            font-weight: 700;
            padding: 6px 15px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .badge-pulse {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--blue-600);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.4; transform:scale(.7); }
        }

        .hero h1 {
            font-family: 'Nunito', sans-serif;
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 900;
            color: var(--txt-main);
            line-height: 1.1;
            letter-spacing: -1.2px;
            margin-bottom: 18px;
        }

        .hero h1 .hi { color: var(--blue-700); }

        .hero .lead {
            font-size: 15.5px;
            color: var(--txt-muted);
            line-height: 1.8;
            max-width: 500px;
            margin-bottom: 32px;
        }

        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }

        .btn-hero-primary {
            background: var(--blue-700);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s;
            box-shadow: var(--shadow-btn);
        }

        .btn-hero-primary:hover {
            background: var(--blue-800);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(29,78,216,0.34);
            color: #fff;
        }

        .btn-hero-secondary {
            background: var(--bg-card);
            border: 1.5px solid var(--border);
            color: var(--txt-sub);
            font-size: 14px;
            font-weight: 600;
            padding: 13px 28px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s;
        }

        .btn-hero-secondary:hover {
            border-color: var(--blue-border);
            color: var(--blue-700);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Hero stats */
        .hero-stats {
            display: flex;
            gap: 28px;
            margin-top: 36px;
            padding-top: 28px;
            border-top: 1px solid var(--border-b);
            flex-wrap: wrap;
        }

        .hero-stat .num {
            font-family: 'Nunito', sans-serif;
            font-size: 28px;
            font-weight: 900;
            color: var(--blue-700);
            line-height: 1;
            letter-spacing: -1px;
        }

        .hero-stat .lbl {
            font-size: 11.5px;
            color: var(--txt-faint);
            font-weight: 500;
            margin-top: 3px;
        }

        /* ── Feature highlight cards (hero right column) ── */
        .feat-highlight-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .feat-hl-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: transform .25s, box-shadow .25s, border-color .25s;
        }

        .feat-hl-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--blue-border);
        }

        .feat-hl-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .feat-hl-title {
            font-weight: 700;
            font-size: 14px;
            color: var(--txt-main);
            margin-bottom: 5px;
        }

        .feat-hl-desc {
            font-size: 12.5px;
            color: var(--txt-muted);
            line-height: 1.65;
        }

        /* ══════════════════════════════════════
           SECTION SHARED
        ══════════════════════════════════════ */
        section { padding: 88px 0; }

        .section-head {
            text-align: center;
            margin-bottom: 56px;
        }

        .sec-badge {
            display: inline-block;
            background: var(--blue-soft);
            border: 1px solid var(--blue-border);
            color: var(--blue-800);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 14px;
        }

        .section-head h2 {
            font-family: 'Nunito', sans-serif;
            font-size: clamp(1.7rem, 2.8vw, 2.3rem);
            font-weight: 900;
            color: var(--txt-main);
            letter-spacing: -0.8px;
            margin-bottom: 12px;
            line-height: 1.15;
        }

        .section-head p {
            color: var(--txt-muted);
            font-size: 15px;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ══════════════════════════════════════
           ABOUT
        ══════════════════════════════════════ */
        #about { background: var(--bg-alt); }

        .about-img-wrap { position: relative; }

        .about-img-wrap img {
            border-radius: 20px;
            width: 100%;
            object-fit: cover;
            box-shadow: var(--shadow-lg);
        }

        .about-float {
            position: absolute;
            bottom: -18px; right: -14px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .about-float .big { font-family:'Nunito',sans-serif; font-size:32px; font-weight:900; color:var(--blue-700); line-height:1; }
        .about-float .sm  { font-size:11px; color:var(--txt-muted); font-weight:600; margin-top:2px; }
        .about-float .xs  { font-size:9.5px; color:var(--txt-faint); }

        .check-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .check-icon {
            width: 26px; height: 26px;
            border-radius: 8px;
            background: var(--blue-soft);
            border: 1px solid var(--blue-border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .check-icon i { font-size: 12px; color: var(--blue-700); }

        /* ══════════════════════════════════════
           FEATURES
        ══════════════════════════════════════ */
        #features { background: var(--bg-hero); }

        .feat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 28px 22px;
            height: 100%;
            transition: all .3s;
            position: relative;
            overflow: hidden;
        }

        .feat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue-700), var(--blue-600));
            opacity: 0;
            transition: opacity .3s;
        }

        .feat-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: var(--blue-border); }
        .feat-card:hover::after { opacity: 1; }

        .feat-icon {
            width: 50px; height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 21px;
        }

        .feat-card h4 { font-weight: 700; font-size: 15.5px; color: var(--txt-main); margin-bottom: 9px; }
        .feat-card p  { font-size: 13.5px; color: var(--txt-muted); line-height: 1.75; margin: 0; }

        /* ══════════════════════════════════════
           HOW IT WORKS
        ══════════════════════════════════════ */
        #how-it-works { background: var(--bg-alt); }

        .step-card { text-align: center; padding: 32px 16px; position: relative; }

        .step-num {
            width: 56px; height: 56px;
            border-radius: 16px;
            background: var(--blue-700);
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 6px 18px rgba(29,78,216,0.28);
        }

        .step-arrow {
            position: absolute;
            top: 60px; right: -14px;
            width: 28px; height: 2px;
            background: var(--blue-700);
            opacity: 0.2;
        }

        .step-card h4 { font-weight: 700; font-size: 14.5px; color: var(--txt-main); margin-bottom: 8px; }
        .step-card p  { font-size: 13px; color: var(--txt-muted); line-height: 1.7; margin: 0; }

        /* ══════════════════════════════════════
           ROLES
        ══════════════════════════════════════ */
        #roles { background: var(--bg-hero); }

        .role-card {
            border-radius: 18px;
            padding: 28px 22px;
            height: 100%;
            border: 1px solid transparent;
            transition: all .3s;
        }

        .role-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }

        .role-card h4 { font-weight: 700; font-size: 16px; color: var(--txt-main); margin-bottom: 9px; }
        .role-card p  { font-size: 13.5px; color: var(--txt-muted); line-height: 1.7; margin-bottom: 16px; }

        .role-list { list-style:none; padding:0; margin:0; }

        .role-list li {
            font-size: 13px;
            color: var(--txt-sub);
            padding: 7px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid rgba(15,23,42,0.05);
        }

        .role-list li:last-child { border-bottom: none; }

        /* ══════════════════════════════════════
           STATS — satu-satunya dark section
        ══════════════════════════════════════ */
        #stats {
            background: var(--bg-dark);
            position: relative;
            overflow: hidden;
        }

        #stats::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 70% at 50% 50%, rgba(37,99,235,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .stat-box { text-align: center; padding: 48px 20px; }

        .stat-box .n {
            font-family: 'Nunito', sans-serif;
            font-size: 52px;
            font-weight: 900;
            color: var(--blue-600);
            line-height: 1;
            margin-bottom: 10px;
            letter-spacing: -2px;
        }

        .stat-box .l { font-size: 14px; color: #64748B; font-weight: 500; }

        /* ══════════════════════════════════════
           CTA
        ══════════════════════════════════════ */
        #cta { background: var(--bg-alt); border-top: 1px solid var(--border-b); }

        .cta-box {
            background: var(--blue-700);
            border-radius: 24px;
            padding: 68px 56px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%; right: -10%;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }

        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -40%; left: -5%;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .cta-box h2 {
            font-family: 'Nunito', sans-serif;
            font-size: clamp(1.7rem, 2.8vw, 2.3rem);
            font-weight: 900;
            color: #fff;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
            letter-spacing: -0.8px;
        }

        .cta-box p {
            color: rgba(255,255,255,0.8);
            font-size: 15px;
            margin-bottom: 32px;
            position: relative;
            z-index: 1;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
        }

        .btn-cta {
            background: #fff;
            color: var(--blue-800);
            font-weight: 700;
            font-size: 14px;
            padding: 13px 32px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
            transition: all .25s;
            box-shadow: 0 6px 24px rgba(15,23,42,0.2);
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(15,23,42,0.26);
            color: var(--blue-700);
        }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        footer {
            background: var(--bg-dark);
            border-top: 1px solid rgba(255,255,255,0.05);
            color: #64748B;
            padding: 60px 0 24px;
        }

        .footer-logo-name { font-family:'Nunito',sans-serif; font-weight:900; font-size:19px; color:var(--txt-ondark); letter-spacing:-0.4px; }

        footer p { font-size:13.5px; line-height:1.75; color:#4B5563; }

        footer h6 {
            font-weight: 700;
            color: var(--txt-ondark);
            margin-bottom: 14px;
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        footer ul { list-style:none; padding:0; margin:0; }

        footer ul li a {
            color: #4B5563;
            text-decoration: none;
            font-size: 13.5px;
            transition: color .2s;
            display: block;
            padding: 4px 0;
        }

        footer ul li a:hover { color: var(--blue-600); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            font-size: 12.5px;
            color: #374151;
        }

        /* ══════════════════════════════════════
           MOBILE
        ══════════════════════════════════════ */
        @media (max-width: 991px) {
            .mobile-nav-toggle { display: block; }
            nav { display: none; }
            nav.open {
                display: flex;
                position: fixed;
                inset: 0;
                background: rgba(248,250,255,0.98);
                backdrop-filter: blur(20px);
                z-index: 9998;
                align-items: center;
                justify-content: center;
            }
            nav.open ul { flex-direction: column; text-align: center; gap: 4px; }
            nav.open ul a { font-size: 18px; padding: 12px 28px; }
            .step-arrow { display: none; }
            .about-float { right: 0; }
            .cta-box { padding: 48px 24px; }
        }
    </style>
</head>

<body>

    {{-- ══════ NAVBAR ══════ --}}
    <header id="header">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="#hero" class="logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="STQM">
                <div>
                    <span class="logo-name">STQM</span>
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
                <a href="{{ route('login') }}" class="btn-nav-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </a>
                <button class="mobile-nav-toggle" onclick="toggleNav()">
                    <i class="bi bi-list" id="nav-icon"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- ══════ HERO ══════ --}}
    <section id="hero">
        <div class="hero-deco-grid"></div>
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <div class="container position-relative" style="z-index:1">
            <div class="row align-items-center g-5">

                {{-- Left --}}
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="650">
                    <div class="hero-badge">
                        <span class="badge-pulse"></span>
                        AI-Powered · K-Means Clustering
                    </div>
                    <h1>
                        Petakan Kualitas Guru dengan
                        <span class="hi">Data & Kecerdasan Buatan</span>
                    </h1>
                    <p class="lead">
                        STQM mengintegrasikan data kuesioner, absensi RFID, dan prestasi guru
                        untuk menghasilkan pemetaan kompetensi yang objektif dan akurat.
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
                        <div class="hero-stat"><div class="num">4</div><div class="lbl">Indikator Kompetensi</div></div>
                        <div class="hero-stat"><div class="num">4</div><div class="lbl">Cluster Kualitas</div></div>
                        <div class="hero-stat"><div class="num">25+</div><div class="lbl">Butir Pertanyaan</div></div>
                    </div>
                </div>

                {{-- Right — 4 feature highlight cards --}}
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="650" data-aos-delay="120">
                    <div class="feat-highlight-grid">
                        @foreach([
                            [
                                'bi-journal-check',
                                'rgba(29,78,216,0.09)', '#2563EB',
                                'Kuesioner Evaluasi',
                                'Penilaian multi-penilai berbasis indikator kompetensi guru dengan skala Likert.'
                            ],
                            [
                                'bi-credit-card-2-front',
                                'rgba(5,150,105,0.09)', '#059669',
                                'Absensi RFID',
                                'Rekam kehadiran guru secara otomatis dan real-time tanpa input manual.'
                            ],
                            [
                                'bi-cpu',
                                'rgba(109,40,217,0.09)', '#7C3AED',
                                'K-Means Clustering',
                                'Algoritma AI mengelompokkan guru ke 4 cluster kualitas secara otomatis.'
                            ],
                            [
                                'bi-bar-chart-line',
                                'rgba(29,78,216,0.09)', '#2563EB',
                                'Dashboard & Laporan',
                                'Pantau performa guru dan unduh laporan evaluasi kapan saja.'
                            ],
                        ] as [$icon, $bg, $color, $title, $desc])
                            <div class="feat-hl-card">
                                <div class="feat-hl-icon" style="background:{{ $bg }}">
                                    <i class="bi {{ $icon }}" style="color:{{ $color }}"></i>
                                </div>
                                <div>
                                    <div class="feat-hl-title">{{ $title }}</div>
                                    <div class="feat-hl-desc">{{ $desc }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════ ABOUT ══════ --}}
    <section id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="about-img-wrap">
                        <img src="{{ asset('arsha/assets/img/why-us.png') }}" alt="Tentang STQM">
                        <div class="about-float">
                            <div class="big">4</div>
                            <div class="sm">Kompetensi Guru</div>
                            <div class="xs">Permendiknas No.16/2007</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="section-head text-start mb-4">
                        <span class="sec-badge">Tentang Sistem</span>
                        <h2>Evaluasi Guru yang Objektif & Berbasis Data</h2>
                        <p class="text-start">
                            STQM hadir sebagai solusi evaluasi guru yang komprehensif, menggantikan metode
                            konvensional yang subjektif dengan sistem analisis berbasis kecerdasan buatan.
                        </p>
                    </div>
                    @foreach([
                        ['Kuesioner Multi-Penilai',       'Evaluasi dari perspektif siswa, sesama guru, dan penilaian diri untuk hasil yang menyeluruh.'],
                        ['Absensi RFID Terintegrasi',     'Data kehadiran otomatis dari sistem RFID sebagai indikator kedisiplinan guru.'],
                        ['Analisis K-Means Clustering',   'Algoritma ML mengelompokkan guru ke 4 cluster berdasarkan profil kompetensi secara otomatis.'],
                        ['Dashboard & Laporan Real-time', 'Kepala sekolah memantau performa dan distribusi kualitas guru secara langsung.'],
                    ] as [$title, $desc])
                        <div class="check-item">
                            <div class="check-icon"><i class="bi bi-check2"></i></div>
                            <div>
                                <strong style="font-size:14.5px;color:var(--txt-main);">{{ $title }}</strong>
                                <p style="font-size:13.5px;color:var(--txt-muted);margin:4px 0 0;line-height:1.7;">{{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ══════ FEATURES ══════ --}}
    <section id="features">
        <div class="container">
            <div class="section-head" data-aos="fade-up">
                <span class="sec-badge">Fitur Unggulan</span>
                <h2>Semua yang Dibutuhkan dalam Satu Sistem</h2>
                <p>Dirancang khusus untuk kebutuhan evaluasi guru di sekolah modern.</p>
            </div>
            <div class="row g-4">
                @foreach([
                    ['bi-journal-check',       'rgba(29,78,216,0.09)',  '#2563EB', 'Sistem Kuesioner',      'Kuesioner digital berbasis indikator kompetensi Permendiknas No.16/2007 dengan skala Likert 1-5, diisi siswa dan sesama guru.'],
                    ['bi-credit-card-2-front', 'rgba(5,150,105,0.09)',  '#059669', 'Absensi RFID',          'Sistem scan kartu otomatis untuk mencatat kehadiran guru tiap hari. Akurat dan real-time tanpa input manual.'],
                    ['bi-trophy',              'rgba(217,119,6,0.09)',  '#B45309', 'Data Prestasi Guru',    'Upload sertifikat, penghargaan, dan portofolio profesional guru dengan sistem validasi oleh admin.'],
                    ['bi-cpu',                 'rgba(109,40,217,0.09)', '#7C3AED', 'K-Means Clustering',    'Algoritma ML mengelompokkan guru ke 4 cluster (A/B/C/D) berdasarkan 4 dimensi kompetensi secara otomatis.'],
                    ['bi-bar-chart-line',      'rgba(29,78,216,0.09)',  '#2563EB', 'Dashboard Analisis',    'Visualisasi distribusi cluster, grafik kompetensi, dan statistik performa guru yang interaktif.'],
                    ['bi-file-earmark-text',   'rgba(220,38,38,0.09)',  '#DC2626', 'Laporan Evaluasi',      'Generate laporan per guru + rekomendasi tindak lanjut berdasarkan clustering. Export ke Excel tersedia.'],
                ] as [$icon, $bg, $color, $title, $desc])
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                        <div class="feat-card">
                            <div class="feat-icon" style="background:{{ $bg }}">
                                <i class="bi {{ $icon }}" style="color:{{ $color }}"></i>
                            </div>
                            <h4>{{ $title }}</h4>
                            <p>{{ $desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════ HOW IT WORKS ══════ --}}
    <section id="how-it-works">
        <div class="container">
            <div class="section-head" data-aos="fade-up">
                <span class="sec-badge">Alur Sistem</span>
                <h2>Bagaimana STQM Bekerja?</h2>
                <p>Proses sistematis dari pengumpulan data hingga insight strategis.</p>
            </div>
            <div class="row g-0">
                @foreach([
                    ['1','Pengisian Kuesioner','Siswa dan sesama guru mengisi kuesioner kompetensi secara digital.'],
                    ['2','Absensi & Prestasi', 'Guru absensi via RFID dan upload sertifikat/prestasi ke sistem.'],
                    ['3','Pengolahan Data',    'Sistem agregasi data dan hitung rata-rata nilai per kompetensi.'],
                    ['4','Analisis K-Means',   'Algoritma K-Means kelompokkan guru ke cluster A, B, C, atau D.'],
                    ['5','Dashboard & Laporan','Kepala sekolah lihat hasil dan rekomendasi tindak lanjut.'],
                ] as [$num, $title, $desc])
                    <div class="col position-relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="step-card">
                            <div class="step-num">{{ $num }}</div>
                            @if(!$loop->last)
                                <div class="step-arrow"></div>
                            @endif
                            <h4>{{ $title }}</h4>
                            <p>{{ $desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════ ROLES ══════ --}}
    <section id="roles">
        <div class="container">
            <div class="section-head" data-aos="fade-up">
                <span class="sec-badge">Pengguna Sistem</span>
                <h2>Dirancang untuk Semua Pemangku Kepentingan</h2>
                <p>Setiap role memiliki akses yang disesuaikan dengan kebutuhan masing-masing.</p>
            </div>
            <div class="row g-4">
                @foreach([
                    ['👨‍🎓','Siswa',          'rgba(29,78,216,0.07)', 'rgba(29,78,216,0.14)', '#2563EB', 'Memberikan penilaian objektif terhadap guru yang mengajar.',
                     ['Isi kuesioner evaluasi guru','Skala Likert 1-5 per indikator','Satu penilaian per guru per semester']],
                    ['👨‍🏫','Guru',           'rgba(5,150,105,0.07)', 'rgba(5,150,105,0.14)', '#059669', 'Menilai rekan sejawat, absensi RFID, dan kelola portofolio.',
                     ['Peer assessment sesama guru','Absensi RFID harian','Upload sertifikat & prestasi']],
                    ['👨‍💼','Kepala Sekolah', 'rgba(217,119,6,0.07)',  'rgba(217,119,6,0.14)',  '#D97706', 'Pantau dashboard analitik dan gunakan hasil clustering.',
                     ['Dashboard distribusi cluster','Laporan evaluasi per guru','Rekomendasi tindak lanjut']],
                    ['👨‍💻','Administrator',  'rgba(109,40,217,0.07)','rgba(109,40,217,0.14)','#7C3AED', 'Kelola seluruh data, validasi prestasi, dan jalankan clustering.',
                     ['Manajemen pengguna & akses','Validasi prestasi guru','Jalankan K-Means Clustering']],
                ] as [$emoji, $name, $bg, $bdr, $color, $desc, $items])
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="role-card" style="background:{{ $bg }};border-color:{{ $bdr }}">
                            <div style="font-size:30px;margin-bottom:14px;">{{ $emoji }}</div>
                            <h4>{{ $name }}</h4>
                            <p>{{ $desc }}</p>
                            <ul class="role-list">
                                @foreach($items as $item)
                                    <li>
                                        <i class="bi bi-check-circle-fill" style="color:{{ $color }};font-size:12px;flex-shrink:0;"></i>
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

    {{-- ══════ STATS ══════ --}}
    <section id="stats">
        <div class="container position-relative" style="z-index:1">
            <div class="row g-0 text-center">
                @foreach([
                    ['4','','Kompetensi yang Dinilai'],
                    ['25','+','Butir Pertanyaan Kuesioner'],
                    ['4','','Cluster Kualitas Guru'],
                    ['100','%','Berbasis Data & AI'],
                ] as [$n, $suf, $lbl])
                    <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 70 }}">
                        <div class="stat-box">
                            <div class="n">{{ $n }}<span style="font-size:28px">{{ $suf }}</span></div>
                            <div class="l">{{ $lbl }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════ CTA ══════ --}}
    <section id="cta">
        <div class="container" data-aos="zoom-in">
            <div class="cta-box">
                <h2>Siap Meningkatkan Kualitas Pendidikan?</h2>
                <p>Mulai gunakan STQM dan dapatkan gambaran objektif kualitas guru berbasis data dan kecerdasan buatan.</p>
                <a href="{{ route('login') }}" class="btn-cta">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                </a>
            </div>
        </div>
    </section>

    {{-- ══════ FOOTER ══════ --}}
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:32px;height:32px;border-radius:9px;object-fit:cover;">
                        <span class="footer-logo-name">STQM</span>
                    </div>
                    <p>Smart Teacher Quality Mapping — sistem pemetaan kualitas guru berbasis data dan AI untuk mendukung peningkatan mutu pendidikan.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Navigasi</h6>
                    <ul>
                        @foreach(['Beranda'=>'#hero','Tentang'=>'#about','Fitur'=>'#features','Alur Sistem'=>'#how-it-works','Pengguna'=>'#roles'] as $lbl => $href)
                            <li><a href="{{ $href }}">{{ $lbl }}</a></li>
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
                                    <i class="bi bi-check2-circle" style="color:var(--blue-600);font-size:13px;"></i>
                                    {{ $k }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                © {{ date('Y') }} <strong style="color:var(--blue-600)">STQM</strong> — Smart Teacher Quality Mapping.
                Politeknik Negeri Jember.
            </div>
        </div>
    </footer>

    <script src="{{ asset('arsha/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('arsha/assets/vendor/aos/aos.js') }}"></script>

    <script>
        AOS.init({ duration: 600, easing: 'ease-out', once: true });

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
        function toggleNav() {
            const nav  = document.getElementById('navbar');
            const icon = document.getElementById('nav-icon');
            nav.classList.toggle('open');
            icon.className = nav.classList.contains('open') ? 'bi bi-x' : 'bi bi-list';
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const el = document.querySelector(a.getAttribute('href'));
                if (el) {
                    e.preventDefault();
                    el.scrollIntoView({ behavior: 'smooth' });
                    document.getElementById('navbar').classList.remove('open');
                    document.getElementById('nav-icon').className = 'bi bi-list';
                }
            });
        });
    </script>

</body>
</html>
