@extends('layouts.app')

@section('title', 'Penilaian Guru — Kuesioner Siswa')

@push('styles')
    <style>
        /* ═══════════════════════════════════════════════════
               SISWA KUESIONER — Multi-guru, Step-based flow
               Enhanced with animated background
            ═══════════════════════════════════════════════════ */
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap');

        :root {
            --sk-primary: #4F63FF;
            --sk-primary-dark: #3A4FE8;
            --sk-primary-glow: rgba(79, 99, 255, 0.16);
            --sk-primary-soft: rgba(79, 99, 255, 0.08);
            --sk-green: #10B981;
            --sk-green-soft: rgba(16, 185, 129, 0.1);
            --sk-orange: #F97316;
            --sk-orange-soft: rgba(249, 115, 22, 0.1);
            --sk-amber: #F59E0B;
            --sk-surface: rgba(255, 255, 255, 0.95);
            --sk-border: rgba(79, 99, 255, 0.15);
            --sk-text: #1A1D3A;
            --sk-muted: #5A6070;
            --sk-faint: #9AA0B5;
            --sk-radius: 20px;
            --sk-shadow: 0 8px 40px rgba(79, 99, 255, 0.14), 0 2px 8px rgba(0,0,0,0.06);
        }

        /* ── Background animasi HANYA di dalam sk-page-outer — sidebar tidak tersentuh ── */

        .app-content:has(.sk-page-outer) {
            padding: 0 !important;
            min-height: 100%;
        }

        .sk-page-outer {
            position: relative;   /* stacking context — semua child absolute terkurung di sini */
            padding: 32px 16px 60px;
            min-height: 100%;
            overflow: hidden;     /* clip semua animasi agar tidak keluar ke sidebar */
            background: linear-gradient(160deg, #0d1240 0%, #151060 35%, #0e1848 65%, #0a0e30 100%);
        }

        /* Layer 1 – gradient mesh bergerak */
        .sk-page-outer::before {
            content: '';
            position: absolute;
            inset: -50%;          /* lebih besar dari container agar gerakan tidak terlihat terpotong */
            pointer-events: none;
            z-index: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(79,99,255,0.55)   0%, transparent 55%),
                radial-gradient(ellipse 55% 55% at 80% 80%, rgba(139,92,246,0.40)  0%, transparent 55%),
                radial-gradient(ellipse 45% 40% at 75% 15%, rgba(79,99,255,0.20)   0%, transparent 50%),
                radial-gradient(ellipse 40% 45% at 15% 75%, rgba(249,115,22,0.15)  0%, transparent 50%);
            animation: meshMove 20s ease-in-out infinite alternate;
        }

        @keyframes meshMove {
            0%   { transform: translate(0%, 0%) scale(1); }
            33%  { transform: translate(3%, -4%) scale(1.04); }
            66%  { transform: translate(-4%, 3%) scale(0.97); }
            100% { transform: translate(2%, 5%) scale(1.02); }
        }

        /* Layer 2 – orb besar mengambang */
        .sk-page-outer::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image:
                radial-gradient(circle 200px at 12% 20%, rgba(99,132,255,0.28)  0%, transparent 65%),
                radial-gradient(circle 160px at 88% 12%, rgba(167,139,250,0.22) 0%, transparent 65%),
                radial-gradient(circle 180px at 70% 75%, rgba(52,211,153,0.15)  0%, transparent 65%),
                radial-gradient(circle 120px at 25% 82%, rgba(249,115,22,0.18)  0%, transparent 65%),
                radial-gradient(circle 140px at 92% 55%, rgba(99,132,255,0.14)  0%, transparent 65%);
            animation: orbDrift 14s ease-in-out infinite alternate;
        }

        @keyframes orbDrift {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-18px); }
            100% { transform: translateY(8px); }
        }

        /* Layer 3 – titik bintang */
        .sk-bg-stars {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image:
                radial-gradient(1.5px 1.5px at 8%  12%, rgba(255,255,255,0.55) 0%, transparent 100%),
                radial-gradient(1px   1px   at 23% 38%, rgba(255,255,255,0.38) 0%, transparent 100%),
                radial-gradient(2px   2px   at 38%  5%, rgba(255,255,255,0.42) 0%, transparent 100%),
                radial-gradient(1px   1px   at 54% 28%, rgba(255,255,255,0.32) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 68% 18%, rgba(255,255,255,0.48) 0%, transparent 100%),
                radial-gradient(1px   1px   at 83% 48%, rgba(255,255,255,0.32) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at  6% 62%, rgba(255,255,255,0.42) 0%, transparent 100%),
                radial-gradient(1px   1px   at 19% 78%, rgba(255,255,255,0.28) 0%, transparent 100%),
                radial-gradient(2px   2px   at 34% 88%, rgba(255,255,255,0.38) 0%, transparent 100%),
                radial-gradient(1px   1px   at 58% 72%, rgba(255,255,255,0.32) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 76% 85%, rgba(255,255,255,0.42) 0%, transparent 100%),
                radial-gradient(1px   1px   at 91%  8%, rgba(255,255,255,0.38) 0%, transparent 100%),
                radial-gradient(1px   1px   at 46% 52%, rgba(255,255,255,0.28) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 61% 42%, rgba(255,255,255,0.32) 0%, transparent 100%),
                radial-gradient(1px   1px   at 95% 68%, rgba(255,255,255,0.38) 0%, transparent 100%);
            animation: starTwinkle 7s ease-in-out infinite alternate;
        }

        @keyframes starTwinkle {
            0%   { opacity: 0.55; }
            50%  { opacity: 1; }
            100% { opacity: 0.65; }
        }

        /* Layer 4 – bentuk geometris mengambang */
        .sk-bg-shapes {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .sk-shape {
            position: absolute;
            border-radius: 50%;
            animation: shapeFloat linear infinite;
        }

        .sk-shape-1 {
            width: 320px; height: 320px;
            background: linear-gradient(135deg, rgba(79,99,255,0.12), rgba(139,92,246,0.10));
            top: -100px; left: -100px;
            animation-duration: 22s;
        }

        .sk-shape-2 {
            width: 220px; height: 220px;
            background: linear-gradient(135deg, rgba(16,185,129,0.10), rgba(59,130,246,0.08));
            bottom: 5%; right: -70px;
            animation-duration: 18s;
            animation-direction: reverse;
        }

        .sk-shape-3 {
            width: 160px; height: 160px;
            border-radius: 35%;
            background: linear-gradient(135deg, rgba(249,115,22,0.10), rgba(245,158,11,0.08));
            top: 42%; left: 1%;
            animation-duration: 26s;
        }

        .sk-shape-4 {
            width: 110px; height: 110px;
            border-radius: 25%;
            background: linear-gradient(135deg, rgba(236,72,153,0.08), rgba(139,92,246,0.08));
            top: 18%; right: 1%;
            animation-duration: 20s;
        }

        @keyframes shapeFloat {
            0%   { transform: translateY(0px) rotate(0deg); }
            50%  { transform: translateY(-28px) rotate(180deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }

        /* ══════════════════════════════════════════════════════
           LIGHT MODE — animasi background berubah jadi cerah & hangat
           Palet: putih bersih + aksen orange/amber/biru lembut
        ══════════════════════════════════════════════════════ */
        [data-theme="light"] .sk-page-outer {
            background: linear-gradient(160deg, #e8f0ff 0%, #f0eaff 30%, #fff5ea 65%, #e8f5ff 100%);
            transition: background 0.5s ease;
        }

        /* Layer 1 – gradient mesh light: biru & ungu pastel */
        [data-theme="light"] .sk-page-outer::before {
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(79,99,255,0.18)   0%, transparent 55%),
                radial-gradient(ellipse 55% 55% at 80% 80%, rgba(139,92,246,0.14)  0%, transparent 55%),
                radial-gradient(ellipse 45% 40% at 75% 15%, rgba(232,86,10,0.10)   0%, transparent 50%),
                radial-gradient(ellipse 40% 45% at 15% 75%, rgba(249,115,22,0.12)  0%, transparent 50%);
        }

        /* Layer 2 – orb besar light: lebih transparan & warna hangat */
        [data-theme="light"] .sk-page-outer::after {
            background-image:
                radial-gradient(circle 200px at 12% 20%, rgba(79,99,255,0.12)   0%, transparent 65%),
                radial-gradient(circle 160px at 88% 12%, rgba(167,139,250,0.10) 0%, transparent 65%),
                radial-gradient(circle 180px at 70% 75%, rgba(232,86,10,0.08)   0%, transparent 65%),
                radial-gradient(circle 120px at 25% 82%, rgba(249,115,22,0.10)  0%, transparent 65%),
                radial-gradient(circle 140px at 92% 55%, rgba(79,99,255,0.08)   0%, transparent 65%);
        }

        /* Layer 3 – bintang light: titik-titik warna pastel */
        [data-theme="light"] .sk-bg-stars {
            background-image:
                radial-gradient(1.5px 1.5px at 8%  12%, rgba(79,99,255,0.35)  0%, transparent 100%),
                radial-gradient(1px   1px   at 23% 38%, rgba(139,92,246,0.25) 0%, transparent 100%),
                radial-gradient(2px   2px   at 38%  5%, rgba(232,86,10,0.22)  0%, transparent 100%),
                radial-gradient(1px   1px   at 54% 28%, rgba(79,99,255,0.20)  0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 68% 18%, rgba(249,115,22,0.28) 0%, transparent 100%),
                radial-gradient(1px   1px   at 83% 48%, rgba(139,92,246,0.20) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at  6% 62%, rgba(79,99,255,0.25)  0%, transparent 100%),
                radial-gradient(1px   1px   at 19% 78%, rgba(232,86,10,0.18)  0%, transparent 100%),
                radial-gradient(2px   2px   at 34% 88%, rgba(139,92,246,0.22) 0%, transparent 100%),
                radial-gradient(1px   1px   at 58% 72%, rgba(79,99,255,0.18)  0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 76% 85%, rgba(249,115,22,0.25) 0%, transparent 100%),
                radial-gradient(1px   1px   at 91%  8%, rgba(79,99,255,0.22)  0%, transparent 100%),
                radial-gradient(1px   1px   at 46% 52%, rgba(139,92,246,0.18) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 61% 42%, rgba(232,86,10,0.20)  0%, transparent 100%),
                radial-gradient(1px   1px   at 95% 68%, rgba(79,99,255,0.20)  0%, transparent 100%);
        }

        /* Layer 4 – shapes light: warna cerah tapi transparan agar tidak berat */
        [data-theme="light"] .sk-shape-1 {
            background: linear-gradient(135deg, rgba(79,99,255,0.10), rgba(139,92,246,0.08));
        }
        [data-theme="light"] .sk-shape-2 {
            background: linear-gradient(135deg, rgba(232,86,10,0.10), rgba(249,115,22,0.08));
        }
        [data-theme="light"] .sk-shape-3 {
            background: linear-gradient(135deg, rgba(139,92,246,0.08), rgba(79,99,255,0.06));
        }
        [data-theme="light"] .sk-shape-4 {
            background: linear-gradient(135deg, rgba(249,115,22,0.08), rgba(232,86,10,0.06));
        }

        /* ── Page title: dark → putih, light → warna gelap ── */
        [data-theme="light"] .sk-page-title h1 {
            color: #1A1D3A !important;
            text-shadow: 0 2px 12px rgba(79, 99, 255, 0.15) !important;
        }
        [data-theme="light"] .sk-page-title p {
            color: #5A6070 !important;
        }

        /* ── Stepper: dark → putih transparan, light → normal ── */
        [data-theme="light"] .sk-stepper::before {
            background: rgba(79,99,255,0.18) !important;
        }
        [data-theme="light"] .sk-step-dot {
            background: rgba(255,255,255,0.90) !important;
            border-color: rgba(79,99,255,0.25) !important;
            color: #9AA0B5 !important;
        }
        [data-theme="light"] .sk-step-label {
            color: #9AA0B5 !important;
        }

        /* ── Top badge light ── */
        [data-theme="light"] .sk-top-badge {
            background: rgba(79,99,255,0.08);
            border-color: rgba(79,99,255,0.18);
            color: #3A4FE8;
        }

        /* Transisi smooth semua elemen animasi saat ganti mode */
        .sk-page-outer,
        .sk-page-outer::before,
        .sk-page-outer::after,
        .sk-bg-stars,
        .sk-shape-1,
        .sk-shape-2,
        .sk-shape-3,
        .sk-shape-4 {
            transition: background 0.6s ease, background-image 0.6s ease, background-color 0.6s ease;
        }

        /* Semua konten di atas layer background */
        .sk-wrap {
            max-width: 720px;
            margin: 0 auto;
            padding: 0 0 48px;
            position: relative;
            z-index: 1;
        }

        /* ── Page title: dark mode putih, light mode handled di atas ── */
        [data-theme="dark"] .sk-page-title h1 {
            color: #ffffff !important;
            text-shadow: 0 2px 20px rgba(79, 99, 255, 0.5);
        }

        [data-theme="dark"] .sk-page-title p {
            color: rgba(255, 255, 255, 0.65) !important;
        }

        /* ── Stepper override for dark bg ── */
        [data-theme="dark"] .sk-stepper::before {
            background: rgba(255,255,255,0.15) !important;
        }

        [data-theme="dark"] .sk-step-dot {
            background: rgba(255,255,255,0.1) !important;
            border-color: rgba(255,255,255,0.2) !important;
            color: rgba(255,255,255,0.5) !important;
        }

        .sk-step.active .sk-step-dot {
            background: var(--sk-primary) !important;
            border-color: var(--sk-primary) !important;
            color: white !important;
            box-shadow: 0 4px 20px rgba(79, 99, 255, 0.5) !important;
        }

        .sk-step.done .sk-step-dot {
            background: var(--sk-green) !important;
            border-color: var(--sk-green) !important;
        }

        [data-theme="dark"] .sk-step-label {
            color: rgba(255,255,255,0.5) !important;
        }

        [data-theme="dark"] .sk-step.active .sk-step-label {
            color: rgba(255,255,255,0.95) !important;
        }

        .sk-step.done .sk-step-label {
            color: var(--sk-green) !important;
        }

        /* ── Card: sedikit berbeda di light mode (shadow lebih ringan) ── */
        [data-theme="dark"] .sk-card {
            background: rgba(255, 255, 255, 0.97) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            box-shadow:
                0 8px 40px rgba(0, 0, 0, 0.35),
                0 20px 60px rgba(79, 99, 255, 0.12) !important;
        }
        [data-theme="light"] .sk-card {
            background: rgba(255, 255, 255, 0.92) !important;
            border: 1px solid rgba(79, 99, 255, 0.12) !important;
            box-shadow:
                0 4px 24px rgba(79, 99, 255, 0.10),
                0 2px 8px rgba(0, 0, 0, 0.05) !important;
        }

        /* Transition smooth pada card saat ganti mode */
        .sk-card {
            transition: background 0.5s ease, border-color 0.5s ease, box-shadow 0.5s ease;
        }

        /* ── Flash messages on dark bg ── */
        .sk-flash {
            border-radius: 14px;
        }

        .sk-flash-success {
            background: rgba(16, 185, 129, 0.15) !important;
            border: 1px solid rgba(16, 185, 129, 0.35) !important;
            color: #6ee7b7 !important;
        }

        .sk-flash-error {
            background: rgba(220, 38, 38, 0.15) !important;
            border: 1px solid rgba(220, 38, 38, 0.35) !important;
            color: #fca5a5 !important;
        }

        /* ── Decorative top banner chip ── */
        .sk-top-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.03em;
            transition: background 0.5s ease, border-color 0.5s ease, color 0.5s ease;
        }

        /* dark mode badge */
        [data-theme="dark"] .sk-top-badge {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.85);
        }

        .sk-top-badge span {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 6px #10B981;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        /* ── Stepper header ── */
        .sk-stepper {
            display: flex;
            align-items: flex-start;
            gap: 0;
            margin-bottom: 28px;
            position: relative;
        }

        .sk-stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: var(--sk-border);
            z-index: 0;
        }

        .sk-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .sk-step-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 15px;
            transition: all 0.3s;
            background: var(--sk-surface);
            border: 2px solid var(--sk-border);
            color: var(--sk-faint);
        }

        .sk-step.active .sk-step-dot {
            background: var(--sk-primary);
            border-color: var(--sk-primary);
            color: white;
            box-shadow: 0 4px 16px var(--sk-primary-glow);
        }

        .sk-step.done .sk-step-dot {
            background: var(--sk-green);
            border-color: var(--sk-green);
            color: white;
        }

        .sk-step-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--sk-faint);
            text-align: center;
            line-height: 1.3;
            max-width: 80px;
        }

        .sk-step.active .sk-step-label {
            color: var(--sk-primary);
        }

        .sk-step.done .sk-step-label {
            color: var(--sk-green);
        }

        /* ── Page title ── */
        .sk-page-title {
            margin-bottom: 24px;
        }

        .sk-page-title h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--sk-text);
            line-height: 1.2;
        }

        .sk-page-title p {
            font-size: 14px;
            color: var(--sk-muted);
            margin-top: 5px;
        }

        /* ── Card base ── */
        .sk-card {
            background: var(--sk-surface);
            border: 1px solid var(--sk-border);
            border-radius: var(--sk-radius);
            box-shadow: var(--sk-shadow);
            overflow: hidden;
        }

        /* ── Step panels ── */
        .sk-panel {
            display: none;
        }

        .sk-panel.active {
            display: block;
            animation: panelIn 0.35s ease both;
        }

        @keyframes panelIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* ═══ STEP 1: Aturan ═══ */
        .sk-rules-header {
            background: linear-gradient(135deg, var(--sk-primary) 0%, #6B7FFF 100%);
            padding: 28px 28px 24px;
            color: white;
        }

        .sk-rules-header-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .sk-rules-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sk-rules-icon i {
            font-size: 22px;
        }

        .sk-rules-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 800;
        }

        .sk-rules-header p {
            font-size: 13.5px;
            opacity: 0.85;
            margin-top: 4px;
        }

        .sk-rules-body {
            padding: 24px 28px;
        }

        .sk-rule-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--sk-border);
        }

        .sk-rule-item:last-child {
            border-bottom: none;
        }

        .sk-rule-num {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--sk-primary-soft);
            color: var(--sk-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
            font-family: 'Outfit', sans-serif;
        }

        .sk-rule-text {
            font-size: 13.5px;
            color: var(--sk-text);
            line-height: 1.6;
            padding-top: 4px;
        }

        .sk-rule-text strong {
            color: var(--sk-primary);
        }

        .sk-confirm-row {
            padding: 20px 28px;
            border-top: 1px solid var(--sk-border);
            background: var(--sk-primary-soft);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sk-confirm-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--sk-primary);
            flex-shrink: 0;
            cursor: pointer;
        }

        .sk-confirm-row label {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--sk-text);
            cursor: pointer;
        }

        /* ═══ STEP 2: Pilih Guru ═══ */
        .sk-guru-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--sk-border);
        }

        .sk-guru-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--sk-text);
        }

        .sk-guru-header p {
            font-size: 13px;
            color: var(--sk-muted);
            margin-top: 4px;
        }

        .sk-search-wrap {
            padding: 16px 28px;
            border-bottom: 1px solid var(--sk-border);
        }

        .sk-search-inner {
            position: relative;
        }

        .sk-search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: var(--sk-faint);
            pointer-events: none;
        }

        .sk-search-input {
            width: 100%;
            padding: 11px 14px 11px 42px;
            background: var(--sk-primary-soft);
            border: 1.5px solid var(--sk-border);
            border-radius: 12px;
            font-size: 14px;
            color: var(--sk-text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        .sk-search-input:focus {
            border-color: var(--sk-primary);
            box-shadow: 0 0 0 3px var(--sk-primary-glow);
            background: white;
        }

        .sk-guru-list {
            max-height: 320px;
            overflow-y: auto;
        }

        .sk-guru-list::-webkit-scrollbar {
            width: 4px;
        }

        .sk-guru-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .sk-guru-list::-webkit-scrollbar-thumb {
            background: var(--sk-border);
            border-radius: 4px;
        }

        .sk-guru-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 28px;
            cursor: pointer;
            transition: background 0.15s;
            border-bottom: 1px solid var(--sk-border);
            position: relative;
        }

        .sk-guru-item:last-child {
            border-bottom: none;
        }

        .sk-guru-item:hover {
            background: var(--sk-primary-soft);
        }

        .sk-guru-item.selected {
            background: var(--sk-primary-soft);
        }

        .sk-guru-item.sudah {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .sk-guru-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--sk-primary-soft), rgba(107, 127, 255, 0.15));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 16px;
            color: var(--sk-primary);
            border: 1.5px solid var(--sk-border);
        }

        .sk-guru-item.selected .sk-guru-avatar {
            background: var(--sk-primary);
            color: white;
            border-color: var(--sk-primary);
        }

        .sk-guru-info {
            flex: 1;
            min-width: 0;
        }

        .sk-guru-nama {
            font-weight: 700;
            font-size: 14px;
            color: var(--sk-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sk-guru-mapel {
            font-size: 12px;
            color: var(--sk-muted);
            margin-top: 2px;
        }

        .sk-guru-check {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            border: 2px solid var(--sk-border);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .sk-guru-item.selected .sk-guru-check {
            background: var(--sk-primary);
            border-color: var(--sk-primary);
            color: white;
        }

        .sk-guru-check i {
            font-size: 11px;
            display: none;
        }

        .sk-guru-item.selected .sk-guru-check i {
            display: block;
        }

        .sk-badge-sudah {
            position: absolute;
            right: 28px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--sk-green-soft);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--sk-green);
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .sk-empty-search {
            padding: 32px 28px;
            text-align: center;
            color: var(--sk-faint);
            font-size: 13.5px;
        }

        .sk-selected-chips-wrap {
            display: none;
            padding: 14px 28px;
            border-top: 1px solid var(--sk-border);
            background: linear-gradient(135deg, rgba(79, 99, 255, 0.06), rgba(107, 127, 255, 0.04));
        }

        .sk-selected-chips-wrap.show {
            display: block;
        }

        .sk-chips-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--sk-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .sk-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .sk-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 99px;
            background: var(--sk-primary);
            color: white;
            font-size: 12px;
            font-weight: 700;
        }

        .sk-chip button {
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            padding: 0;
            line-height: 1;
            font-size: 13px;
        }

        .sk-chip button:hover {
            color: white;
        }

        /* ═══ STEP 3: Kuesioner per guru ═══ */
        .sk-guru-progress {
            padding: 16px 28px;
            border-bottom: 1px solid var(--sk-border);
            background: var(--sk-primary-soft);
        }

        .sk-guru-progress-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .sk-guru-progress-title {
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 800;
            color: var(--sk-primary);
        }

        .sk-guru-progress-count {
            font-size: 12px;
            color: var(--sk-muted);
            font-weight: 600;
        }

        .sk-guru-dots {
            display: flex;
            gap: 6px;
        }

        .sk-guru-dot {
            width: 28px;
            height: 6px;
            border-radius: 99px;
            background: var(--sk-border);
            transition: background 0.3s;
        }

        .sk-guru-dot.current {
            background: var(--sk-primary);
        }

        .sk-guru-dot.done {
            background: var(--sk-green);
        }

        .sk-q-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--sk-border);
        }

        .sk-q-header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .sk-q-header-top h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 17px;
            font-weight: 800;
            color: var(--sk-text);
        }

        .sk-progress-info {
            font-size: 12.5px;
            color: var(--sk-muted);
            font-weight: 600;
        }

        .sk-progress-info span {
            color: var(--sk-primary);
            font-weight: 800;
        }

        .sk-progress-bar-wrap {
            height: 8px;
            background: var(--sk-primary-soft);
            border-radius: 99px;
            overflow: hidden;
        }

        .sk-progress-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--sk-primary), #6B7FFF);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 0%;
        }

        /* Tabs */
        .sk-tabs {
            display: flex;
            gap: 6px;
            padding: 16px 28px;
            overflow-x: auto;
            border-bottom: 1px solid var(--sk-border);
        }

        .sk-tabs::-webkit-scrollbar {
            display: none;
        }

        .sk-tab {
            flex-shrink: 0;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            border: 1.5px solid var(--sk-border);
            cursor: pointer;
            transition: all 0.2s;
            color: var(--sk-muted);
            background: var(--sk-surface);
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            text-transform: capitalize;
        }

        .sk-tab.active {
            background: var(--sk-primary);
            border-color: var(--sk-primary);
            color: white;
            box-shadow: 0 4px 12px var(--sk-primary-glow);
        }

        .sk-tab-done-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--sk-green);
            display: none;
        }

        .sk-tab.tab-done .sk-tab-done-dot {
            display: block;
        }

        .sk-tab.tab-done:not(.active) {
            border-color: rgba(16, 185, 129, 0.3);
            color: var(--sk-green);
        }

        /* Questions */
        .sk-q-section {
            display: none;
            padding: 20px 28px 8px;
        }

        .sk-q-section.active {
            display: block;
            animation: panelIn 0.3s ease both;
        }

        .sk-section-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--sk-primary-soft);
            border: 1px solid rgba(79, 99, 255, 0.2);
            color: var(--sk-primary);
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            margin-bottom: 18px;
        }

        .sk-question-card {
            border: 1.5px solid var(--sk-border);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .sk-question-card:hover {
            border-color: rgba(79, 99, 255, 0.25);
        }

        .sk-question-card.answered {
            border-color: rgba(16, 185, 129, 0.3);
            background: rgba(16, 185, 129, 0.02);
        }

        .sk-q-text {
            font-size: 14px;
            color: var(--sk-text);
            line-height: 1.65;
            margin-bottom: 14px;
            display: flex;
            gap: 10px;
        }

        .sk-q-num {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            color: var(--sk-primary);
            flex-shrink: 0;
        }

        .sk-options {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
        }

        .sk-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 10px 4px;
            border-radius: 12px;
            border: 1.5px solid var(--sk-border);
            cursor: pointer;
            transition: all 0.18s;
            background: var(--sk-surface);
            text-align: center;
        }

        .sk-option:hover {
            border-color: var(--sk-primary);
            background: var(--sk-primary-soft);
        }

        .sk-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 0;
            height: 0;
        }

        .sk-option-num {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: 18px;
            color: var(--sk-muted);
            line-height: 1;
            transition: color 0.18s;
        }

        .sk-option-label {
            font-size: 9.5px;
            font-weight: 600;
            color: var(--sk-faint);
            line-height: 1.2;
            transition: color 0.18s;
        }

        .sk-option.selected {
            border-color: var(--sk-primary);
            background: var(--sk-primary);
        }

        .sk-option.selected .sk-option-num {
            color: white;
        }

        .sk-option.selected .sk-option-label {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Kesan & Pesan */
        .sk-kesan-pesan {
            padding: 20px 28px;
            border-top: 1px solid var(--sk-border);
            background: var(--sk-primary-soft);
        }

        .sk-kesan-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 800;
            color: var(--sk-text);
            margin-bottom: 10px;
        }

        .sk-kesan-label i {
            color: var(--sk-primary);
            font-size: 16px;
        }

        .sk-kesan-textarea {
            width: 100%;
            min-height: 90px;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--sk-border);
            background: var(--sk-surface);
            font-size: 13.5px;
            color: var(--sk-text);
            font-family: inherit;
            resize: vertical;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .sk-kesan-textarea:focus {
            border-color: var(--sk-primary);
            box-shadow: 0 0 0 3px var(--sk-primary-glow);
        }

        .sk-kesan-hint {
            font-size: 11.5px;
            color: var(--sk-faint);
            margin-top: 6px;
        }

        /* Nav footer */
        .sk-footer-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 28px;
            border-top: 1px solid var(--sk-border);
            background: rgba(79, 99, 255, 0.02);
        }

        /* Buttons */
        .sk-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            font-family: inherit;
            transition: all 0.18s;
            text-decoration: none;
        }

        .sk-btn-ghost {
            background: none;
            border: 1.5px solid var(--sk-border);
            color: var(--sk-muted);
        }

        .sk-btn-ghost:hover {
            border-color: var(--sk-primary);
            color: var(--sk-primary);
            background: var(--sk-primary-soft);
        }

        .sk-btn-primary {
            background: linear-gradient(135deg, var(--sk-primary), var(--sk-primary-dark));
            color: white;
            box-shadow: 0 6px 16px var(--sk-primary-glow);
        }

        .sk-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(79, 99, 255, 0.3);
        }

        .sk-btn-primary:active {
            transform: translateY(0);
        }

        .sk-btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .sk-btn-green {
            background: linear-gradient(135deg, var(--sk-green), #059669);
            color: white;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.2);
        }

        .sk-btn-green:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(16, 185, 129, 0.28);
        }

        .sk-btn-orange {
            background: linear-gradient(135deg, var(--sk-orange), #ea6a0a);
            color: white;
            box-shadow: 0 6px 16px rgba(249, 115, 22, 0.2);
        }

        .sk-btn-orange:hover {
            transform: translateY(-1px);
        }

        /* Alert flash */
        .sk-flash {
            border-radius: 14px;
            padding: 12px 18px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 600;
        }

        .sk-flash-success {
            background: var(--sk-green-soft);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #065f46;
        }

        .sk-flash-error {
            background: rgba(220, 38, 38, 0.07);
            border: 1px solid rgba(220, 38, 38, 0.2);
            color: #991B1B;
        }

        @media (max-width: 480px) {
            .sk-option-label {
                font-size: 8.5px;
            }

            .sk-options {
                gap: 4px;
            }

            .sk-option {
                padding: 8px 2px;
                border-radius: 10px;
            }

            .sk-option-num {
                font-size: 16px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="sk-page-outer">
    {{-- Background decorative elements — dikurung dalam sk-page-outer agar animasi tidak keluar ke sidebar --}}
    <div class="sk-bg-stars"></div>
    <div class="sk-bg-shapes">
        <div class="sk-shape sk-shape-1"></div>
        <div class="sk-shape sk-shape-2"></div>
        <div class="sk-shape sk-shape-3"></div>
        <div class="sk-shape sk-shape-4"></div>
    </div>

    <div class="sk-wrap">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="sk-flash sk-flash-success">
                <i class="bi bi-check-circle-fill" style="font-size:18px;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="sk-flash sk-flash-error">
                <i class="bi bi-exclamation-circle-fill" style="font-size:18px;"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Page title — bahasa siswa --}}
        <div class="sk-page-title">
            <div class="sk-top-badge">
                <span></span>
                Kuesioner Penilaian Guru
            </div>
            <h1>Yuk, Nilai Guru Kamu! 📋</h1>
            <p>Ikuti langkah-langkahnya pelan-pelan ya. Gampang kok, nggak sampai 10 menit!</p>
        </div>

        {{-- Stepper --}}
        <div class="sk-stepper" id="stepper">
            <div class="sk-step active" id="dot-1">
                <div class="sk-step-dot">1</div>
                <div class="sk-step-label">Baca Dulu</div>
            </div>
            <div class="sk-step" id="dot-2">
                <div class="sk-step-dot">2</div>
                <div class="sk-step-label">Pilih Guru</div>
            </div>
            <div class="sk-step" id="dot-3">
                <div class="sk-step-dot">3</div>
                <div class="sk-step-label">Isi Kuesioner</div>
            </div>
        </div>

        {{-- ════════════════════════════════════
        STEP 1: ATURAN — bahasa santai siswa
        ════════════════════════════════════ --}}
        <div class="sk-panel active" id="panel-1">
            <div class="sk-card">
                <div class="sk-rules-header">
                    <div class="sk-rules-header-top">
                        <div class="sk-rules-icon"><i class="bi bi-info-circle-fill"></i></div>
                        <div>
                            <h2>Sebelum Mulai, Baca Ini Dulu ya 👋</h2>
                            <p>Cuma sebentar kok — biar pengisiannya lancar dan hasilnya berguna!</p>
                        </div>
                    </div>
                </div>

                <div class="sk-rules-body">
                    <div class="sk-rule-item">
                        <div class="sk-rule-num">1</div>
                        <div class="sk-rule-text">
                            Jawab dengan <strong>jujur sesuai pengalaman belajar kamu</strong> bareng guru tersebut.
                            Nggak ada jawaban benar atau salah — yang penting sesuai kenyataan.
                        </div>
                    </div>
                    <div class="sk-rule-item">
                        <div class="sk-rule-num">2</div>
                        <div class="sk-rule-text">
                            Kamu bisa pilih <strong>lebih dari satu guru sekaligus</strong>.
                            Nanti kuesionernya diisi satu per satu untuk tiap guru yang kamu pilih.
                        </div>
                    </div>
                    <div class="sk-rule-item">
                        <div class="sk-rule-num">3</div>
                        <div class="sk-rule-text">
                            Pilih angka dari <strong>1 (Sangat Tidak Setuju)</strong> sampai
                            <strong>5 (Sangat Setuju)</strong> buat tiap pernyataan.
                        </div>
                    </div>
                    <div class="sk-rule-item">
                        <div class="sk-rule-num">4</div>
                        <div class="sk-rule-text">
                            Nama kamu <strong>tidak akan ditampilkan</strong> ke siapapun.
                            Hasil ini hanya dipakai untuk bantu guru berkembang lebih baik.
                        </div>
                    </div>
                    <div class="sk-rule-item">
                        <div class="sk-rule-num">5</div>
                        <div class="sk-rule-text">
                            Pastikan semua guru sudah selesai kamu nilai sebelum tekan tombol
                            <strong>Kirim Semua</strong>. Setelah dikirim, jawaban nggak bisa diubah lagi ya.
                        </div>
                    </div>
                </div>

                <div class="sk-confirm-row">
                    <input type="checkbox" id="confirmRead" onchange="toggleNextStep1()">
                    <label for="confirmRead">Oke, aku udah baca dan ngerti semua aturannya!</label>
                </div>

                <div style="padding: 16px 28px; border-top: 1px solid var(--sk-border);">
                    <button type="button" class="sk-btn sk-btn-primary" id="btnStep1Next" onclick="goToStep(2)" disabled
                        style="width:100%; justify-content:center;">
                        Lanjut: Pilih Guru
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════
        STEP 2: PILIH GURU
        ════════════════════════════════════ --}}
        <div class="sk-panel" id="panel-2">
            <div class="sk-card">
                <div class="sk-guru-header">
                    <h2>Guru Mana yang Mau Kamu Nilai? 🎯</h2>
                    <p>Boleh pilih lebih dari satu. Centang semua guru yang pernah ngajar kamu ya.</p>
                </div>

                <div class="sk-search-wrap">
                    <div class="sk-search-inner">
                        <i class="bi bi-search sk-search-icon"></i>
                        <input type="text" class="sk-search-input" id="guruSearch"
                            placeholder="Cari nama guru atau mata pelajaran..." oninput="filterGuru(this.value)">
                    </div>
                </div>

                <div class="sk-guru-list" id="guruList">
                    @foreach ($guru as $g)
                        @php $sudah = in_array($g->id, $sudahDinilai); @endphp
                        <div class="sk-guru-item {{ $sudah ? 'sudah' : '' }}" id="guru-item-{{ $g->id }}" data-id="{{ $g->id }}"
                            data-nama="{{ strtolower($g->nama) }}" data-mapel="{{ strtolower($g->mata_pelajaran) }}"
                            onclick="{{ $sudah ? '' : 'toggleGuruSelect(this)' }}">

                            <div class="sk-guru-avatar">{{ strtoupper(substr($g->nama, 0, 1)) }}</div>
                            <div class="sk-guru-info">
                                <div class="sk-guru-nama">{{ $g->nama }}</div>
                                <div class="sk-guru-mapel">{{ $g->mata_pelajaran }}</div>
                            </div>
                            @if ($sudah)
                                <span class="sk-badge-sudah"><i class="bi bi-check2-circle"></i> Sudah Dinilai</span>
                            @else
                                <div class="sk-guru-check">
                                    <i class="bi bi-check2"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div id="emptySearch" class="sk-empty-search" style="display:none;">
                    <i class="bi bi-search" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.3;"></i>
                    Nggak ketemu guru yang kamu cari. Coba kata kunci lain?
                </div>

                <div class="sk-selected-chips-wrap" id="selectedChipsWrap">
                    <div class="sk-chips-label">Guru yang sudah kamu pilih:</div>
                    <div class="sk-chips" id="selectedChips"></div>
                </div>

                <div style="padding: 16px 28px; border-top: 1px solid var(--sk-border); display:flex; gap:10px;">
                    <button type="button" class="sk-btn sk-btn-ghost" onclick="goToStep(1)">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="sk-btn sk-btn-primary" id="btnStep2Next" onclick="startKuesioner()"
                        disabled style="flex:1; justify-content:center;">
                        Ayo Mulai Isi!
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════
        STEP 3: KUESIONER (per guru, sequential)
        ════════════════════════════════════ --}}
        <div class="sk-panel" id="panel-3">
            <form method="POST" action="{{ route('siswa.kuesioner.submit') }}" id="formKuesioner">
                @csrf
                <div id="guruIdsContainer"></div>

                <div class="sk-card">
                    {{-- Guru progress indicator --}}
                    <div class="sk-guru-progress">
                        <div class="sk-guru-progress-top">
                            <div class="sk-guru-progress-title" id="currentGuruLabel">Guru 1 dari 1</div>
                            <div class="sk-guru-progress-count" id="currentGuruName">—</div>
                        </div>
                        <div class="sk-guru-dots" id="guruDots"></div>
                    </div>

                    {{-- Question header with progress bar --}}
                    <div class="sk-q-header">
                        <div class="sk-q-header-top">
                            <h2 id="q-guru-name">Penilaian Guru</h2>
                            <div class="sk-progress-info">
                                <span id="persen">0</span>% selesai
                                (<span id="terisi">0</span>/<span id="total">{{ $pertanyaan->flatten()->count() }}</span>)
                            </div>
                        </div>
                        <div class="sk-progress-bar-wrap">
                            <div class="sk-progress-bar-fill" id="progressFill"></div>
                        </div>
                    </div>

                    {{-- Category tabs --}}
                    <div class="sk-tabs" id="tabsBar">
                        @foreach ($pertanyaan as $kategori => $soalList)
                            <button type="button" class="sk-tab" id="tab-{{ $kategori }}" onclick="gantiTab('{{ $kategori }}')">
                                <div class="sk-tab-done-dot"></div>
                                {{ ucfirst($kategori) }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Questions per category --}}
                    @foreach ($pertanyaan as $kategori => $soalList)
                        <div class="sk-q-section" id="section-{{ $kategori }}">
                            <div class="sk-section-label">
                                <i class="bi bi-bookmark-fill"></i>
                                Aspek {{ ucfirst($kategori) }}
                            </div>

                            @foreach ($soalList as $soal)
                                <div class="sk-question-card" id="qcard-{{ $soal->id }}">
                                    <p class="sk-q-text">
                                        <span class="sk-q-num">{{ $loop->iteration }}.</span>
                                        <span>{{ $soal->teks_pertanyaan }}</span>
                                    </p>
                                    <div class="sk-options" data-soal-id="{{ $soal->id }}" data-kategori="{{ $kategori }}">
                                        @foreach ([1 => 'Banget Nggak', 2 => 'Nggak', 3 => 'Biasa Aja', 4 => 'Setuju', 5 => 'Banget!'] as $val => $label)
                                            <label class="sk-option" id="opt-{{ $soal->id }}-{{ $val }}">
                                                <input type="radio" class="soal-radio" data-soal="{{ $soal->id }}"
                                                    data-kategori="{{ $kategori }}" value="{{ $val }}" onchange="pilihJawaban(this)">
                                                <span class="sk-option-num">{{ $val }}</span>
                                                <span class="sk-option-label">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    {{-- Kesan & Pesan — bahasa siswa --}}
                    <div class="sk-kesan-pesan" id="kesanPesanSection" style="display:none;">
                        <div class="sk-kesan-label">
                            <i class="bi bi-chat-heart-fill"></i>
                            Ada pesan buat guru ini? 💬
                        </div>
                        <textarea class="sk-kesan-textarea" id="kesanPesanInput"
                            placeholder="Tulis kesan atau pesan buat guru ini (boleh dikosongin)..."
                            maxlength="500"></textarea>
                        <div class="sk-kesan-hint">
                            <i class="bi bi-info-circle"></i>
                            Opsional — nama kamu tetap dirahasiakan. Pesan ini cuma dibaca oleh guru yang bersangkutan.
                        </div>
                    </div>

                    {{-- Footer nav --}}
                    <div class="sk-footer-nav">
                        <button type="button" class="sk-btn sk-btn-ghost" id="btnPrev" onclick="prevTab()" disabled>
                            <i class="bi bi-chevron-left"></i> Sebelumnya
                        </button>

                        <button type="button" class="sk-btn sk-btn-primary" id="btnNext" onclick="nextTab()">
                            Selanjutnya <i class="bi bi-chevron-right"></i>
                        </button>

                        <button type="button" class="sk-btn sk-btn-orange" id="btnGuruNext" style="display:none;"
                            onclick="lanjutGuruBerikutnya()">
                            Guru Berikutnya <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>

                        <button type="submit" class="sk-btn sk-btn-green" id="btnKirim" style="display:none;"
                            onclick="return konfirmasiKirim()">
                            <i class="bi bi-send-fill"></i> Kirim Semua Penilaian
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>{{-- /sk-page-outer --}}

    <script>
        const kategoriList = @json(array_keys($pertanyaan->toArray()));
        const totalSoal = {{ $pertanyaan->flatten()->count() }};
        let currentStep = 1;
        let currentTabIdx = 0;

        let selectedGurus = [];
        let currentGuruIndex = 0;

        const allJawaban = {};
        const allKesanPesan = {};

        // ─── Step navigation ───────────────────────────────────────────────
        function goToStep(step) {
            for (let i = 1; i <= 3; i++) {
                document.getElementById('panel-' + i).classList.remove('active');
                const dot = document.getElementById('dot-' + i);
                const dotEl = dot.querySelector('.sk-step-dot');
                dot.classList.remove('active', 'done');
                if (i < step) {
                    dot.classList.add('done');
                    dotEl.innerHTML = '<i class="bi bi-check2" style="font-size:15px;"></i>';
                } else if (i === step) {
                    dot.classList.add('active');
                    dotEl.textContent = i;
                } else {
                    dotEl.textContent = i;
                }
            }
            document.getElementById('panel-' + step).classList.add('active');
            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function toggleNextStep1() {
            document.getElementById('btnStep1Next').disabled =
                !document.getElementById('confirmRead').checked;
        }

        // ─── Step 2: Multi-select guru ──────────────────────────────────────
        function toggleGuruSelect(el) {
            const id = el.dataset.id;
            const nama = el.querySelector('.sk-guru-nama').textContent;
            const mapel = el.querySelector('.sk-guru-mapel').textContent;

            const idx = selectedGurus.findIndex(g => g.id === id);
            if (idx >= 0) {
                selectedGurus.splice(idx, 1);
                el.classList.remove('selected');
            } else {
                selectedGurus.push({ id, nama, mapel });
                el.classList.add('selected');
            }
            renderChips();
            document.getElementById('btnStep2Next').disabled = selectedGurus.length === 0;
        }

        function renderChips() {
            const wrap = document.getElementById('selectedChipsWrap');
            const chips = document.getElementById('selectedChips');
            if (selectedGurus.length === 0) { wrap.classList.remove('show'); return; }
            wrap.classList.add('show');
            chips.innerHTML = selectedGurus.map(g =>
                `<span class="sk-chip">${g.nama}
                        <button type="button" onclick="removeGuruChip('${g.id}')" title="Hapus">×</button>
                    </span>`
            ).join('');
        }

        function removeGuruChip(id) {
            const el = document.getElementById('guru-item-' + id);
            if (el) el.classList.remove('selected');
            selectedGurus = selectedGurus.filter(g => g.id !== id);
            renderChips();
            document.getElementById('btnStep2Next').disabled = selectedGurus.length === 0;
        }

        function filterGuru(q) {
            q = q.toLowerCase().trim();
            let visible = 0;
            document.querySelectorAll('.sk-guru-item').forEach(el => {
                const match = el.dataset.nama.includes(q) || el.dataset.mapel.includes(q) || q === '';
                el.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            document.getElementById('emptySearch').style.display = visible === 0 ? 'block' : 'none';
        }

        // ─── Step 3: Kuesioner per guru ─────────────────────────────────────
        function startKuesioner() {
            if (selectedGurus.length === 0) return;
            selectedGurus.forEach(g => { allJawaban[g.id] = {}; allKesanPesan[g.id] = ''; });
            currentGuruIndex = 0;
            renderGuruDots();
            loadGuru(0);
            goToStep(3);
        }

        function renderGuruDots() {
            document.getElementById('guruDots').innerHTML =
                selectedGurus.map((g, i) => `<div class="sk-guru-dot" id="gdot-${i}"></div>`).join('');
        }

        function loadGuru(idx) {
            const guru = selectedGurus[idx];
            currentGuruIndex = idx;
            currentTabIdx = 0;

            document.getElementById('currentGuruLabel').textContent =
                `Guru ke-${idx + 1} dari ${selectedGurus.length}`;
            document.getElementById('currentGuruName').textContent = guru.mapel;
            document.getElementById('q-guru-name').textContent = 'Nilai: ' + guru.nama;

            selectedGurus.forEach((_, i) => {
                const dot = document.getElementById('gdot-' + i);
                dot.classList.remove('current', 'done');
                if (i < idx) dot.classList.add('done');
                else if (i === idx) dot.classList.add('current');
            });

            restoreOrClearJawaban(guru.id);
            document.getElementById('kesanPesanInput').value = allKesanPesan[guru.id] || '';
            document.querySelectorAll('.sk-tab').forEach(t => t.classList.remove('tab-done'));
            gantiTab(kategoriList[0]);
            updateProgress();
        }

        function restoreOrClearJawaban(guruId) {
            const saved = allJawaban[guruId] || {};
            document.querySelectorAll('.soal-radio').forEach(radio => {
                const soalId = radio.dataset.soal;
                radio.name = `jawaban[${guruId}][${soalId}]`;
                radio.checked = !!(saved[soalId] && parseInt(saved[soalId]) === parseInt(radio.value));

                const opt = radio.closest('.sk-option');
                const card = document.getElementById('qcard-' + soalId);
                if (radio.checked) opt.classList.add('selected'); else opt.classList.remove('selected');
                if (card) {
                    if (saved[soalId]) card.classList.add('answered');
                    else card.classList.remove('answered');
                }
            });
        }

        function saveCurrentJawaban() {
            const guru = selectedGurus[currentGuruIndex];
            if (!guru) return;
            document.querySelectorAll('.soal-radio:checked').forEach(radio => {
                allJawaban[guru.id][radio.dataset.soal] = radio.value;
            });
            allKesanPesan[guru.id] = document.getElementById('kesanPesanInput').value;
        }

        function gantiTab(kat) {
            document.querySelectorAll('.sk-q-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.sk-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('section-' + kat).classList.add('active');
            document.getElementById('tab-' + kat).classList.add('active');
            currentTabIdx = kategoriList.indexOf(kat);

            const isLastTab = currentTabIdx === kategoriList.length - 1;
            const isFirstTab = currentTabIdx === 0;
            const isLastGuru = currentGuruIndex === selectedGurus.length - 1;

            document.getElementById('btnPrev').disabled = isFirstTab;
            document.getElementById('btnNext').style.display = isLastTab ? 'none' : '';
            document.getElementById('btnGuruNext').style.display = (isLastTab && !isLastGuru) ? '' : 'none';
            document.getElementById('btnKirim').style.display = (isLastTab && isLastGuru) ? '' : 'none';
            document.getElementById('kesanPesanSection').style.display = isLastTab ? '' : 'none';
        }

        function nextTab() {
            if (currentTabIdx < kategoriList.length - 1) gantiTab(kategoriList[currentTabIdx + 1]);
        }

        function prevTab() {
            if (currentTabIdx > 0) gantiTab(kategoriList[currentTabIdx - 1]);
        }

        function lanjutGuruBerikutnya() {
            saveCurrentJawaban();
            const sisa = totalSoal - Object.keys(allJawaban[selectedGurus[currentGuruIndex].id]).length;
            if (sisa > 0) {
                if (!confirm(`Masih ada ${sisa} pertanyaan yang belum kamu isi untuk guru ini. Lanjut ke guru berikutnya?`)) return;
            }
            loadGuru(currentGuruIndex + 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function pilihJawaban(radio) {
            const soalId = radio.dataset.soal;
            const guruId = selectedGurus[currentGuruIndex]?.id;

            const grid = radio.closest('.sk-options');
            grid.querySelectorAll('.sk-option').forEach(opt => opt.classList.remove('selected'));
            radio.closest('.sk-option').classList.add('selected');
            document.getElementById('qcard-' + soalId).classList.add('answered');

            if (guruId) {
                if (!allJawaban[guruId]) allJawaban[guruId] = {};
                allJawaban[guruId][soalId] = radio.value;
            }
            updateProgress();
        }

        function updateProgress() {
            const guruId = selectedGurus[currentGuruIndex]?.id;
            const saved = guruId ? (allJawaban[guruId] || {}) : {};
            const terisi = Object.keys(saved).length;
            const pct = Math.round(terisi / totalSoal * 100);

            document.getElementById('progressFill').style.width = pct + '%';
            document.getElementById('persen').textContent = pct;
            document.getElementById('terisi').textContent = terisi;

            kategoriList.forEach(kat => {
                const section = document.getElementById('section-' + kat);
                const soalIds = Array.from(section.querySelectorAll('.soal-radio[value="1"]'))
                    .map(r => r.dataset.soal);
                const allDone = soalIds.length > 0 && soalIds.every(id => saved[id]);
                const tab = document.getElementById('tab-' + kat);
                if (allDone) tab.classList.add('tab-done'); else tab.classList.remove('tab-done');
            });
        }

        function konfirmasiKirim() {
            saveCurrentJawaban();

            const container = document.getElementById('guruIdsContainer');
            container.innerHTML = '';

            selectedGurus.forEach(guru => {
                const hiddenId = document.createElement('input');
                hiddenId.type = 'hidden';
                hiddenId.name = 'guru_ids[]';
                hiddenId.value = guru.id;
                container.appendChild(hiddenId);

                Object.entries(allJawaban[guru.id] || {}).forEach(([soalId, nilai]) => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = `jawaban[${guru.id}][${soalId}]`;
                    inp.value = nilai;
                    container.appendChild(inp);
                });

                const kp = document.createElement('input');
                kp.type = 'hidden';
                kp.name = `kesan_pesan[${guru.id}]`;
                kp.value = allKesanPesan[guru.id] || '';
                container.appendChild(kp);
            });

            document.querySelectorAll('.soal-radio').forEach(r => r.disabled = true);

            const totalAnswered = selectedGurus.reduce((sum, g) =>
                sum + Object.keys(allJawaban[g.id] || {}).length, 0);
            const totalRequired = selectedGurus.length * totalSoal;

            if (totalAnswered < totalRequired) {
                const sisa = totalRequired - totalAnswered;
                return confirm(`Masih ada ${sisa} pertanyaan yang belum kamu jawab. Tetap kirim?`);
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('total').textContent = totalSoal;
        });
    </script>
@endsection
