<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — STQM</title>

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ══════════════════════════════════════
           DESIGN TOKENS — sinkron dengan welcome.blade.php
           dan [data-theme="light"] di app.blade.php
        ══════════════════════════════════════ */
        :root {
            --blue-600: #2563EB;
            --blue-700: #1D4ED8;
            --blue-800: #1E40AF;
            --blue-soft: rgba(29, 78, 216, 0.08);
            --blue-ring: rgba(29, 78, 216, 0.18);
            --blue-border: rgba(29, 78, 216, 0.14);

            --bg-page: #EFF6FF;
            /* blue-50 — halaman */
            --bg-card: #FFFFFF;
            --bg-input: #F8FAFF;

            --txt-main: #0F172A;
            --txt-muted: #475569;
            --txt-faint: #94A3B8;

            --border: #DBEAFE;
            /* blue-100 */
            --shadow-card: 0 8px 32px rgba(29, 78, 216, 0.1), 0 2px 8px rgba(15, 23, 42, 0.06);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow: hidden;
        }

        /* ── Dot grid background — biru muda ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(29, 78, 216, 0.1) 1.2px, transparent 1.2px);
            background-size: 24px 24px;
            pointer-events: none;
            z-index: 0;
        }

        /* ── Soft radial glows ── */
        .bg-glow {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .bg-glow-1 {
            width: 450px;
            height: 450px;
            top: -120px;
            right: -100px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.12) 0%, transparent 65%);
        }

        .bg-glow-2 {
            width: 380px;
            height: 380px;
            bottom: -100px;
            left: -80px;
            background: radial-gradient(circle, rgba(29, 78, 216, 0.09) 0%, transparent 65%);
        }

        .bg-glow-3 {
            width: 220px;
            height: 220px;
            top: 45%;
            left: 60%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.06) 0%, transparent 65%);
        }

        /* ── Wave SVG decoration ── */
        .bg-wave {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            pointer-events: none;
            z-index: 0;
            opacity: 0.3;
        }

        /* ══════════════════════════════════════
           CARD
        ══════════════════════════════════════ */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: var(--bg-card);
            border-radius: 22px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            padding: 40px 36px 32px;
            animation: card-in .45s cubic-bezier(.22, .68, 0, 1.2) both;
        }

        @keyframes card-in {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── Brand header ── */
        .card-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 26px;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(29, 78, 216, 0.25);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .brand-name {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 17px;
            color: var(--txt-main);
            display: block;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .brand-sub {
            font-size: 10.5px;
            color: var(--txt-faint);
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }

        .card-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 26px;
        }

        /* ── Greeting ── */
        .card-greeting {
            margin-bottom: 24px;
        }

        .card-greeting h1 {
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            font-weight: 900;
            color: var(--txt-main);
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 5px;
        }

        .card-greeting p {
            font-size: 13.5px;
            color: var(--txt-muted);
            line-height: 1.5;
        }

        /* ── Error alert ── */
        .alert-error {
            background: rgba(220, 38, 38, 0.06);
            border: 1px solid rgba(220, 38, 38, 0.18);
            border-left: 3px solid #DC2626;
            color: #991B1B;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Fields ── */
        .field {
            margin-bottom: 16px;
        }

        .field-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--txt-main);
            margin-bottom: 6px;
            letter-spacing: 0.1px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--txt-faint);
            pointer-events: none;
            transition: color .2s;
        }

        .field-input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            background: var(--bg-input);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            font-size: 13.5px;
            color: var(--txt-main);
            font-family: inherit;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            -webkit-appearance: none;
        }

        .field-input::placeholder {
            color: var(--txt-faint);
        }

        .field-input:focus {
            border-color: var(--blue-600);
            box-shadow: 0 0 0 3px var(--blue-ring);
            background: #fff;
        }

        .field-wrap:focus-within .field-icon {
            color: var(--blue-700);
        }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--txt-faint);
            font-size: 16px;
            padding: 2px;
            transition: color .2s;
            outline: none;
        }

        .pw-toggle:hover {
            color: var(--txt-muted);
        }

        /* ── Remember ── */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            margin-top: 4px;
        }

        .remember-row input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--blue-700);
            cursor: pointer;
            flex-shrink: 0;
        }

        .remember-row label {
            font-size: 13px;
            color: var(--txt-muted);
            cursor: pointer;
            user-select: none;
        }

        /* ── Submit ── */
        .btn-submit {
            width: 100%;
            background: var(--blue-700);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            letter-spacing: 0.1px;
            padding: 13px;
            border-radius: 11px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 16px rgba(29, 78, 216, 0.3);
        }

        .btn-submit:hover {
            background: var(--blue-800);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(29, 78, 216, 0.36);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* ── Footer ── */
        .card-footer-note {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            font-size: 11.5px;
            color: var(--txt-faint);
            text-align: center;
            line-height: 1.6;
        }

        .card-chips {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .card-chip {
            background: var(--blue-soft);
            border: 1px solid var(--blue-border);
            color: var(--blue-800);
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px 26px;
            }
        }
    </style>
</head>

<body>

    {{-- Background decorations --}}
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>
    <div class="bg-glow bg-glow-3"></div>

    {{-- Wave SVG --}}
    <svg class="bg-wave" viewBox="0 0 1440 160" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,80 C180,20 320,140 480,80 C640,20 780,130 960,70 C1080,30 1200,110 1440,60 L1440,160 L0,160 Z"
            fill="#1D4ED8" opacity=".2" />
        <path d="M0,110 C200,55 360,160 560,100 C720,50 900,150 1100,90 C1240,55 1360,120 1440,85 L1440,160 L0,160 Z"
            fill="#2563EB" opacity=".13" />
    </svg>

    <div class="login-card">

        {{-- Brand --}}
        <div class="card-brand">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="STQM Logo">
            </div>
            <div>
                <span class="brand-name">STQM</span>
                <span class="brand-sub">Smart Teacher Quality Mapping</span>
            </div>
        </div>

        <div class="card-divider"></div>

        {{-- Greeting --}}
        <div class="card-greeting">
            <h1>Halo, selamat datang! 👋</h1>
            <p>Masuk untuk melanjutkan ke sistem evaluasi guru.</p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label class="field-label" for="email">Email</label>
                <div class="field-wrap">
                    <i class="bi bi-envelope field-icon"></i>
                    <input class="field-input" type="email" id="email" name="email" value="{{ old('email') }}" required
                        autofocus autocomplete="email" placeholder="nama@sekolah.sch.id">
                </div>
            </div>

            <div class="field">
                <label class="field-label" for="password">Password</label>
                <div class="field-wrap">
                    <i class="bi bi-lock field-icon"></i>
                    <input class="field-input" type="password" id="password" name="password" required
                        autocomplete="current-password" placeholder="Masukkan password" style="padding-right: 42px;">
                    <button type="button" class="pw-toggle" id="pw-toggle" aria-label="Tampilkan password">
                        <i class="bi bi-eye" id="pw-icon"></i>
                    </button>
                </div>
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn-submit">
                Masuk ke Sistem
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        {{-- Footer --}}
        <div class="card-footer-note">
            © {{ date('Y') }} STQM — Politeknik Negeri Jember
            <div class="card-chips">
                <span class="card-chip"><i class="bi bi-credit-card-2-front"></i> RFID</span>
                <span class="card-chip"><i class="bi bi-cpu"></i> K-Means AI</span>
                <span class="card-chip"><i class="bi bi-shield-check"></i> Multi-Role</span>
            </div>
        </div>

    </div>

    <script>
        const toggle = document.getElementById('pw-toggle');
        const input = document.getElementById('password');
        const icon = document.getElementById('pw-icon');

        toggle.addEventListener('click', () => {
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            icon.className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
    </script>

</body>

</html>
