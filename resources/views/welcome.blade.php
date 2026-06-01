<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S-STQM — Sistem Penilaian Kinerja Guru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --navy: #0b1f4b;
            --navy2: #162d65;
            --navy3: #1e3d82;
            --blue: #2952cc;
            --blue-mid: #3d66e8;
            --blue-light: #e8eef9;
            --blue-pale: #f2f5fc;
            --ink: #111827;
            --ink2: #1f2937;
            --muted: #6b7280;
            --subtle: #9ca3af;
            --border: #e5e9f0;
            --border2: #d1d9ea;
            --surface: #f8f9fc;
            --white: #ffffff;
            --gold: #b8862e;
            --gold-bg: #fdf6e9;
            --teal: #0f7a64;
            --teal-bg: #eaf5f2;
            --red: #c0392b;
            --red-bg: #fdf0ee;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 3px rgba(11, 31, 75, 0.06), 0 1px 2px rgba(11, 31, 75, 0.04);
            --shadow: 0 4px 16px rgba(11, 31, 75, 0.08), 0 2px 4px rgba(11, 31, 75, 0.04);
            --shadow-lg: 0 20px 48px rgba(11, 31, 75, 0.12), 0 4px 12px rgba(11, 31, 75, 0.06);
            --mono: 'IBM Plex Mono', monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* PROGRESS */
        #progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 2px;
            background: var(--blue);
            z-index: 300;
            width: 0;
            transition: width 0.1s linear;
        }

        /* NAV */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            height: 68px;
            display: flex;
            align-items: center;
            padding: 0 64px;
            justify-content: space-between;
            transition: all 0.35s ease;
        }

        nav.scrolled {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: -0.02em;
            color: var(--navy);
            text-decoration: none;
        }

        .logo-mark {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-mark svg {
            width: 18px;
            height: 18px;
        }

        .nav-links {
            display: flex;
            gap: 36px;
            align-items: center;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink2);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--blue);
        }

        .btn-nav {
            background: var(--navy);
            color: var(--white) !important;
            padding: 9px 22px;
            border-radius: 8px;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: background 0.2s, transform 0.15s !important;
        }

        .btn-nav:hover {
            background: var(--blue) !important;
            transform: translateY(-1px);
        }

        /* HERO */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 64px 80px;
            position: relative;
            overflow: hidden;
            background: var(--white);
        }

        .hero-bg-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            opacity: 0.035;
        }

        .hero-bg-lines svg {
            width: 100%;
            height: 100%;
        }

        .hero-accent-circle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .hac-1 {
            width: 520px;
            height: 520px;
            top: -160px;
            right: -80px;
            background: radial-gradient(circle, rgba(41, 82, 204, 0.08) 0%, transparent 70%);
        }

        .hac-2 {
            width: 320px;
            height: 320px;
            bottom: 40px;
            left: 5%;
            background: radial-gradient(circle, rgba(11, 31, 75, 0.05) 0%, transparent 70%);
        }

        .hero-inner {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 72px;
            align-items: center;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue-pale);
            border: 1px solid var(--border2);
            color: var(--blue);
            font-family: var(--mono);
            font-size: 11.5px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 6px;
            letter-spacing: 0.05em;
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeUp 0.6s 0.15s ease forwards;
        }

        .eyebrow-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--blue);
            animation: blink 2.5s ease infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.3
            }
        }

        h1.hero-h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(40px, 4.8vw, 60px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.025em;
            color: var(--navy);
            opacity: 0;
            animation: fadeUp 0.75s 0.3s ease forwards;
        }

        h1.hero-h1 span {
            font-style: italic;
            color: var(--blue);
        }

        .hero-sub {
            font-size: 16.5px;
            color: var(--muted);
            line-height: 1.75;
            margin-top: 20px;
            max-width: 460px;
            opacity: 0;
            animation: fadeUp 0.7s 0.5s ease forwards;
        }

        .hero-btns {
            display: flex;
            gap: 14px;
            align-items: center;
            margin-top: 36px;
            opacity: 0;
            animation: fadeUp 0.7s 0.65s ease forwards;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--navy);
            color: var(--white);
            padding: 13px 26px;
            border-radius: 9px;
            font-size: 14.5px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            letter-spacing: -0.01em;
        }

        .btn-primary:hover {
            background: var(--blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(41, 82, 204, 0.28);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1.5px solid var(--border2);
            color: var(--ink2);
            padding: 12px 22px;
            border-radius: 9px;
            font-size: 14.5px;
            font-weight: 600;
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s, transform 0.15s;
        }

        .btn-outline:hover {
            border-color: var(--navy);
            color: var(--navy);
            transform: translateY(-1px);
        }

        .hero-stats {
            display: flex;
            gap: 28px;
            margin-top: 44px;
            padding-top: 36px;
            border-top: 1px solid var(--border);
            opacity: 0;
            animation: fadeUp 0.7s 0.8s ease forwards;
        }

        .hstat {
            display: flex;
            flex-direction: column;
        }

        .hstat-num {
            font-family: var(--mono);
            font-size: 22px;
            font-weight: 500;
            color: var(--navy);
            letter-spacing: -0.02em;
        }

        .hstat-lbl {
            font-size: 12px;
            color: var(--subtle);
            margin-top: 2px;
        }

        /* Hero Visual */
        .hero-visual {
            position: relative;
            opacity: 0;
            animation: fadeUp 0.9s 0.45s ease forwards;
        }

        .dash-window {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .dw-topbar {
            background: var(--navy);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .dw-dots {
            display: flex;
            gap: 7px;
        }

        .dw-dots span {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            opacity: 0.6;
        }

        .dw-dots span:nth-child(1) {
            background: #ff5f57;
        }

        .dw-dots span:nth-child(2) {
            background: #febc2e;
        }

        .dw-dots span:nth-child(3) {
            background: #28c840;
        }

        .dw-title {
            font-family: var(--mono);
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            flex: 1;
            text-align: center;
        }

        .dw-sidebar {
            width: 160px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            padding: 16px 0;
            flex-shrink: 0;
        }

        .dw-body {
            display: flex;
            height: 240px;
        }

        .dw-content {
            flex: 1;
            padding: 20px;
            overflow: hidden;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
            cursor: default;
        }

        .sidebar-item.active {
            color: var(--navy);
            background: var(--white);
            border-right: 2px solid var(--blue);
        }

        .sidebar-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.5;
        }

        .sidebar-item.active .sidebar-dot {
            opacity: 1;
            background: var(--blue);
        }

        .mini-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 12px;
        }

        .mini-card {
            background: var(--surface);
            border-radius: 8px;
            padding: 11px 12px;
            border: 1px solid var(--border);
        }

        .mc-val {
            font-family: var(--mono);
            font-size: 20px;
            font-weight: 500;
            color: var(--navy);
        }

        .mc-lbl {
            font-size: 10px;
            color: var(--subtle);
            margin-top: 2px;
        }

        .cluster-pills {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .cpill {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .cp-a {
            background: #e6f4ec;
            color: #0d6b38;
        }

        .cp-b {
            background: var(--blue-pale);
            color: var(--blue);
        }

        .cp-c {
            background: var(--gold-bg);
            color: var(--gold);
        }

        .cp-d {
            background: var(--red-bg);
            color: var(--red);
        }

        /* floating badge */
        .float-badge {
            position: absolute;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12px;
            font-weight: 600;
            color: var(--ink2);
            white-space: nowrap;
            animation: float 4s ease-in-out infinite;
        }

        .fb-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .fb-1 {
            bottom: -20px;
            left: -36px;
            animation-delay: 0s;
        }

        .fb-2 {
            top: 20px;
            right: -44px;
            animation-delay: -2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-7px)
            }
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: none;
            }
        }

        /* SECTIONS */
        section {
            padding: 112px 64px;
        }

        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .eyebrow-sm {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 500;
            color: var(--blue);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .eyebrow-sm::before {
            content: '';
            width: 20px;
            height: 1.5px;
            background: var(--blue);
            flex-shrink: 0;
        }

        h2.sh2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 3.5vw, 46px);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -0.025em;
            color: var(--navy);
            margin-bottom: 18px;
        }

        h2.sh2 span {
            font-style: italic;
            color: var(--blue);
        }

        .sdesc {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.75;
            max-width: 520px;
        }

        /* REVEAL */
        .r {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }

        .rl {
            opacity: 0;
            transform: translateX(-32px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }

        .rr {
            opacity: 0;
            transform: translateX(32px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }

        .r.in,
        .rl.in,
        .rr.in {
            opacity: 1;
            transform: none;
        }

        /* NUMBERS STRIP */
        #numbers {
            background: var(--navy);
            padding: 72px 64px;
        }

        .numbers-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2px;
        }

        .num-item {
            text-align: center;
            padding: 40px 24px;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .num-item:last-child {
            border-right: none;
        }

        .num-big {
            font-family: 'Playfair Display', serif;
            font-size: 52px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.03em;
            line-height: 1;
            display: block;
            margin-bottom: 10px;
        }

        .num-big sup {
            font-size: 24px;
            vertical-align: super;
            color: rgba(255, 255, 255, 0.5);
        }

        .num-lbl {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.5;
        }

        /* FEATURES */
        #features {
            background: var(--surface);
        }

        .feat-header {
            text-align: center;
            max-width: 620px;
            margin: 0 auto 64px;
        }

        .feat-header .sdesc {
            margin: 0 auto;
        }

        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .feat-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 36px 30px;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            position: relative;
        }

        .feat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--border2);
        }

        .feat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 28px;
            right: 28px;
            height: 2px;
            border-radius: 0 0 2px 2px;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feat-card:hover::after {
            transform: scaleX(1);
        }

        .fc-blue::after {
            background: var(--blue);
        }

        .fc-teal::after {
            background: var(--teal);
        }

        .fc-gold::after {
            background: var(--gold);
        }

        .fc-navy::after {
            background: var(--navy);
        }

        .fc-red::after {
            background: var(--red);
        }

        .fc-mid::after {
            background: var(--blue-mid);
        }

        .feat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 22px;
        }

        .fi-b {
            background: var(--blue-pale);
        }

        .fi-t {
            background: var(--teal-bg);
        }

        .fi-g {
            background: var(--gold-bg);
        }

        .fi-n {
            background: #edeef4;
        }

        .fi-r {
            background: var(--red-bg);
        }

        .feat-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 10px;
            letter-spacing: -0.01em;
        }

        .feat-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.7;
        }

        .feat-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .ftag {
            font-family: var(--mono);
            font-size: 10.5px;
            font-weight: 500;
            padding: 3px 9px;
            border-radius: 4px;
            letter-spacing: 0.03em;
        }

        .ftb {
            background: var(--blue-pale);
            color: var(--blue);
        }

        .ftt {
            background: var(--teal-bg);
            color: var(--teal);
        }

        .ftg {
            background: var(--gold-bg);
            color: var(--gold);
        }

        .ftn {
            background: #edeef4;
            color: var(--navy2);
        }

        /* HOW IT WORKS */
        #how {
            background: var(--white);
        }

        .how-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 72px;
            align-items: start;
            margin-top: 56px;
        }

        .steps {
            display: flex;
            flex-direction: column;
        }

        .step {
            display: flex;
            gap: 20px;
            padding: 24px 0;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: padding-left 0.25s ease;
        }

        .step:first-child {
            padding-top: 0;
        }

        .step:last-child {
            border-bottom: none;
        }

        .step:hover {
            padding-left: 6px;
        }

        .step.on {
            padding-left: 6px;
        }

        .step-n {
            font-family: var(--mono);
            font-size: 12px;
            font-weight: 500;
            color: var(--border2);
            min-width: 28px;
            padding-top: 2px;
            transition: color 0.25s;
        }

        .step.on .step-n {
            color: var(--blue);
        }

        .step-body {}

        .step h3 {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--ink2);
            margin-bottom: 6px;
            letter-spacing: -0.01em;
        }

        .step.on h3 {
            color: var(--navy);
        }

        .step p {
            font-size: 13.5px;
            color: var(--subtle);
            line-height: 1.65;
        }

        .step.on p {
            color: var(--muted);
        }

        .step-bar {
            width: 2px;
            background: var(--blue);
            border-radius: 2px;
            align-self: stretch;
            min-height: 100%;
            display: none;
        }

        .step.on .step-bar {
            display: block;
        }

        .how-panel-wrap {
            position: sticky;
            top: 100px;
        }

        .how-panel {
            display: none;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            animation: pIn 0.35s ease;
        }

        .how-panel.on {
            display: block;
        }

        @keyframes pIn {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .how-panel h4 {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* panel internals */
        .q-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 14px;
            margin-bottom: 8px;
        }

        .q-text {
            font-size: 12.5px;
            color: var(--ink2);
            line-height: 1.55;
            margin-bottom: 10px;
        }

        .q-scale {
            display: flex;
            gap: 5px;
        }

        .q-pip {
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: var(--border);
        }

        .q-pip.on {
            background: var(--blue);
        }

        .kbar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .kbar-lbl {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink2);
            min-width: 96px;
        }

        .kbar-track {
            flex: 1;
            height: 7px;
            background: var(--border);
            border-radius: 4px;
            overflow: hidden;
        }

        .kbar-fill {
            height: 100%;
            border-radius: 4px;
        }

        .kbar-v {
            font-family: var(--mono);
            font-size: 11px;
            color: var(--subtle);
            min-width: 28px;
            text-align: right;
        }

        .cluster-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 700;
            margin-top: 18px;
        }

        .cb-a {
            background: #e6f4ec;
            color: #0d6b38;
        }

        .attend-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 14px;
        }

        .ag-item {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px;
            text-align: center;
        }

        .ag-val {
            font-family: var(--mono);
            font-size: 20px;
            font-weight: 500;
            color: var(--navy);
        }

        .ag-lbl {
            font-size: 10px;
            color: var(--subtle);
            margin-top: 3px;
        }

        .pres-row {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 11px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
        }

        .pr-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink2);
        }

        .pr-year {
            font-size: 11px;
            color: var(--subtle);
        }

        .pr-pts {
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 500;
            color: var(--blue);
            background: var(--blue-pale);
            padding: 3px 8px;
            border-radius: 4px;
        }

        .exp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
        }

        .exp-table th {
            background: var(--navy);
            color: rgba(255, 255, 255, 0.7);
            padding: 7px 10px;
            text-align: left;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .exp-table td {
            padding: 8px 10px;
            border-bottom: 1px solid var(--border);
            color: var(--ink2);
        }

        .exp-table tr:last-child td {
            border-bottom: none;
        }

        .xbadge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 10px;
        }

        .xb-a {
            background: #e6f4ec;
            color: #0d6b38;
        }

        .xb-b {
            background: var(--blue-pale);
            color: var(--blue);
        }

        .xb-c {
            background: var(--gold-bg);
            color: var(--gold);
        }

        /* KOMPETENSI */
        #kompetensi {
            background: var(--surface);
        }

        .komp-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 72px;
            align-items: start;
            margin-top: 56px;
        }

        .komp-text .sdesc {
            margin-top: 16px;
        }

        .komp-list {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: 32px;
        }

        .komp-item {
            display: flex;
            gap: 16px;
            padding: 20px 0;
            border-bottom: 1px solid var(--border);
            align-items: flex-start;
        }

        .komp-item:first-child {
            padding-top: 0;
        }

        .komp-item:last-child {
            border-bottom: none;
        }

        .komp-num-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--mono);
            font-size: 12px;
            font-weight: 500;
            flex-shrink: 0;
        }

        .kn-1 {
            background: var(--blue-pale);
            color: var(--blue);
        }

        .kn-2 {
            background: var(--teal-bg);
            color: var(--teal);
        }

        .kn-3 {
            background: var(--gold-bg);
            color: var(--gold);
        }

        .kn-4 {
            background: var(--red-bg);
            color: var(--red);
        }

        .komp-body h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 5px;
        }

        .komp-body p {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.65;
        }

        .komp-visual {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .kv-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            border-left: 3px solid;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .kv-card:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow);
        }

        .kv-card.kv1 {
            border-left-color: var(--blue);
        }

        .kv-card.kv2 {
            border-left-color: var(--teal);
        }

        .kv-card.kv3 {
            border-left-color: var(--gold);
        }

        .kv-card.kv4 {
            border-left-color: var(--red);
        }

        .kv-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .kv-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
        }

        .kv-score {
            font-family: var(--mono);
            font-size: 12px;
            font-weight: 500;
            color: var(--muted);
        }

        .kv-bar {
            height: 5px;
            background: var(--border);
            border-radius: 3px;
            overflow: hidden;
        }

        .kv-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 1s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .kv1 .kv-fill {
            background: var(--blue);
        }

        .kv2 .kv-fill {
            background: var(--teal);
        }

        .kv3 .kv-fill {
            background: var(--gold);
        }

        .kv4 .kv-fill {
            background: var(--red);
        }

        /* ROLES */
        #roles {
            background: var(--navy);
        }

        .roles-eyebrow {
            color: rgba(255, 255, 255, 0.45);
        }

        .roles-eyebrow::before {
            background: rgba(255, 255, 255, 0.3);
        }

        .roles-h2 {
            color: var(--white);
        }

        .roles-h2 span {
            color: #6c8af7;
        }

        .roles-desc {
            color: rgba(255, 255, 255, 0.5);
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 56px;
        }

        .role-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius);
            padding: 28px 22px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .role-card:hover {
            background: rgba(255, 255, 255, 0.07);
            transform: translateY(-4px);
        }

        .role-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .role-card:hover::before {
            transform: scaleX(1);
        }

        .rc1::before {
            background: var(--blue-mid);
        }

        .rc2::before {
            background: var(--gold);
        }

        .rc3::before {
            background: var(--teal);
        }

        .rc4::before {
            background: #e07070;
        }

        .role-icon {
            font-size: 28px;
            margin-bottom: 18px;
            display: block;
        }

        .role-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 10px;
        }

        .role-card p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.65;
        }

        .role-list {
            list-style: none;
            margin-top: 18px;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .role-list li {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            gap: 7px;
            align-items: flex-start;
        }

        .role-list li::before {
            content: '—';
            opacity: 0.3;
            flex-shrink: 0;
        }

        /* CLUSTER SECTION */
        #cluster {
            background: var(--white);
        }

        .cluster-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 72px;
            align-items: center;
            margin-top: 56px;
        }

        .cluster-explain p {
            font-size: 15px;
            color: var(--muted);
            line-height: 1.8;
            margin-bottom: 14px;
        }

        .cluster-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .cg-card {
            border-radius: var(--radius);
            padding: 28px 24px;
            border: 1px solid;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .cg-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .cg-a {
            background: #f0f9f4;
            border-color: #b6dfc9;
        }

        .cg-b {
            background: var(--blue-pale);
            border-color: var(--border2);
        }

        .cg-c {
            background: var(--gold-bg);
            border-color: #e8d09a;
        }

        .cg-d {
            background: var(--red-bg);
            border-color: #e8c0bc;
        }

        .cg-letter {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 8px;
        }

        .cg-a .cg-letter {
            color: #0d6b38;
        }

        .cg-b .cg-letter {
            color: var(--blue);
        }

        .cg-c .cg-letter {
            color: var(--gold);
        }

        .cg-d .cg-letter {
            color: var(--red);
        }

        .cg-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 4px;
        }

        .cg-desc {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.55;
        }

        .cg-bar {
            height: 4px;
            border-radius: 2px;
            margin-top: 14px;
        }

        .cg-a .cg-bar {
            background: #0d6b38;
        }

        .cg-b .cg-bar {
            background: var(--blue);
        }

        .cg-c .cg-bar {
            background: var(--gold);
        }

        .cg-d .cg-bar {
            background: var(--red);
        }

        /* CTA */
        #cta {
            background: var(--navy);
            padding: 120px 64px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-glow {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            width: 600px;
            height: 600px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: radial-gradient(circle, rgba(41, 82, 204, 0.2) 0%, transparent 70%);
        }

        .cta-inner {
            position: relative;
            max-width: 680px;
            margin: 0 auto;
        }

        .cta-sub {
            font-family: var(--mono);
            font-size: 11px;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .cta-h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 4.5vw, 54px);
            font-weight: 800;
            color: var(--white);
            line-height: 1.1;
            letter-spacing: -0.025em;
            margin-bottom: 20px;
        }

        .cta-h2 span {
            font-style: italic;
            color: #6c8af7;
        }

        .cta-p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.75;
            margin-bottom: 44px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: var(--white);
            color: var(--navy);
            padding: 14px 32px;
            border-radius: 9px;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-cta:hover {
            background: var(--blue-pale);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(255, 255, 255, 0.15);
        }

        /* FOOTER */
        footer {
            background: #060f25;
            padding: 64px 64px 40px;
        }

        .footer-top {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 64px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .footer-brand .nav-logo {
            color: var(--white);
            margin-bottom: 14px;
        }

        .footer-brand p {
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.35);
            line-height: 1.7;
        }

        .fc-head {
            font-size: 12px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.07em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .fc-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .fc-links a {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.35);
            text-decoration: none;
            transition: color 0.2s;
        }

        .fc-links a:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 28px auto 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.2);
        }

        .tech-stack {
            display: flex;
            gap: 6px;
        }

        .ts-badge {
            font-family: var(--mono);
            font-size: 10.5px;
            padding: 3px 8px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.3);
        }

        /* scroll hint */
        .scroll-hint {
            position: absolute;
            bottom: 36px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            opacity: 0;
            animation: fadeUp 0.6s 1.2s ease forwards;
        }

        .sh-label {
            font-size: 10.5px;
            font-family: var(--mono);
            color: var(--subtle);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .sh-line {
            width: 1px;
            height: 36px;
            background: linear-gradient(to bottom, var(--border2), transparent);
            animation: shimmer 1.8s ease infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.3
            }
        }
    </style>
</head>

<body>

    <div id="progress"></div>

    <nav id="nav">
        <a href="/" class="nav-logo">
            <div class="logo-mark">
                <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="6" height="6" rx="1.5" fill="white" opacity="0.9" />
                    <rect x="10" y="2" width="6" height="6" rx="1.5" fill="white" opacity="0.5" />
                    <rect x="2" y="10" width="6" height="6" rx="1.5" fill="white" opacity="0.5" />
                    <rect x="10" y="10" width="6" height="6" rx="1.5" fill="white" opacity="0.8" />
                </svg>
            </div>
            STQM
        </a>
        <div class="nav-links">
            <a href="#features">Fitur</a>
            <a href="#how">Cara Kerja</a>
            <a href="#kompetensi">Kompetensi</a>
            <a href="#cluster">Klaster</a>
            <a href="/login" class="btn-nav">Masuk</a>
        </div>
    </nav>

    <!-- HERO -->
    <section id="hero">
        <div class="hero-accent-circle hac-1"></div>
        <div class="hero-accent-circle hac-2"></div>
        <div class="hero-bg-lines">
            <svg viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice">
                <defs>
                    <pattern id="grid" width="48" height="48" patternUnits="userSpaceOnUse">
                        <path d="M 48 0 L 0 0 0 48" fill="none" stroke="#0b1f4b" stroke-width="0.8" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="hero-inner">
            <div>
                <div class="hero-eyebrow">
                    <span class="eyebrow-dot"></span>
                    Sistem Standar Mutu Guru
                </div>
                <h1 class="hero-h1">
                    Evaluasi guru<br>
                    yang <span>terukur</span><br>
                    dan transparan
                    test lagi
                </h1>
                <p class="hero-sub">
                    Integrasikan penilaian kuesioner, kehadiran, dan prestasi guru dalam satu sistem berbasis web —
                    dengan klasterisasi kinerja otomatis menggunakan algoritma K-Means.
                </p>
                <div class="hero-btns">
                    <a href="/login" class="btn-primary">
                        Masuk ke Sistem
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="#how" class="btn-outline">
                        Pelajari Cara Kerja
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hstat">
                        <span class="hstat-num">4</span>
                        <span class="hstat-lbl">Kompetensi<br>Dinilai</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num">A–D</span>
                        <span class="hstat-lbl">Klaster<br>K-Means</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num">4</span>
                        <span class="hstat-lbl">Tingkat<br>Akses</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num">100%</span>
                        <span class="hstat-lbl">Berbasis<br>Web</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <!-- Floating badges -->
                <div class="float-badge fb-1">
                    <div class="fb-icon" style="background:var(--teal-bg)">📊</div>
                    Klasterisasi selesai
                </div>
                <div class="float-badge fb-2">
                    <div class="fb-icon" style="background:var(--blue-pale)">✅</div>
                    42 guru terevaluasi
                </div>

                <div class="dash-window">
                    <div class="dw-topbar">
                        <div class="dw-dots"><span></span><span></span><span></span></div>
                        <div class="dw-title">sistem.sekolah.id · Dashboard Kepala Sekolah</div>
                    </div>
                    <div class="dw-body">
                        <div class="dw-sidebar">
                            <div class="sidebar-item active"><span class="sidebar-dot"></span> Dashboard</div>
                            <div class="sidebar-item"><span class="sidebar-dot"></span> Evaluasi Guru</div>
                            <div class="sidebar-item"><span class="sidebar-dot"></span> Monitoring</div>
                            <div class="sidebar-item"><span class="sidebar-dot"></span> Export</div>
                        </div>
                        <div class="dw-content">
                            <div class="mini-cards">
                                <div class="mini-card">
                                    <div class="mc-val">42</div>
                                    <div class="mc-lbl">Total Guru</div>
                                </div>
                                <div class="mini-card">
                                    <div class="mc-val">380</div>
                                    <div class="mc-lbl">Siswa</div>
                                </div>
                            </div>
                            <div
                                style="font-size:10px;font-weight:700;color:var(--subtle);letter-spacing:0.07em;text-transform:uppercase;margin-bottom:8px;">
                                Distribusi Klaster</div>
                            <div class="cluster-pills">
                                <div class="cpill cp-a">⬤ A · Sangat Baik · 18</div>
                                <div class="cpill cp-b">⬤ B · Baik · 14</div>
                                <div class="cpill cp-c">⬤ C · Cukup · 7</div>
                                <div class="cpill cp-d">⬤ D · Perlu Bimbingan · 3</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-hint">
            <div class="sh-label">Scroll</div>
            <div class="sh-line"></div>
        </div>
    </section>

    <!-- NUMBERS -->
    <section id="numbers">
        <div class="numbers-inner">
            <div class="num-item r">
                <span class="num-big"><span class="cn" data-t="4">0</span></span>
                <div class="num-lbl">Dimensi kompetensi<br>yang dievaluasi</div>
            </div>
            <div class="num-item r" style="transition-delay:.1s">
                <span class="num-big"><span class="cn" data-t="4">0</span></span>
                <div class="num-lbl">Klaster kinerja dari<br>algoritma K-Means</div>
            </div>
            <div class="num-item r" style="transition-delay:.2s">
                <span class="num-big"><span class="cn" data-t="6">0</span></span>
                <div class="num-lbl">Tingkatan prestasi<br>yang dicatat</div>
            </div>
            <div class="num-item r" style="transition-delay:.3s">
                <span class="num-big">100<sup>%</sup></span>
                <div class="num-lbl">Berbasis web, tanpa<br>instalasi perangkat</div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features">
        <div class="section-inner">
            <div class="feat-header">
                <div class="eyebrow-sm r">Fitur Sistem</div>
                <h2 class="sh2 r" style="transition-delay:.05s">Semua yang dibutuhkan<br>dalam <span>satu
                        platform</span></h2>
                <p class="sdesc r" style="transition-delay:.1s">Dirancang khusus untuk proses evaluasi kinerja guru di
                    lingkungan sekolah — dari pengisian hingga laporan akhir.</p>
            </div>
            <div class="feat-grid">
                <div class="feat-card fc-blue r" style="transition-delay:0s">
                    <div class="feat-icon fi-b">📋</div>
                    <h3>Kuesioner Digital</h3>
                    <p>Formulir penilaian skala Likert yang dapat diisi siswa maupun sesama guru, dengan periode
                        buka-tutup yang dikonfigurasi admin.</p>
                    <div class="feat-tags">
                        <span class="ftag ftb">Siswa → Guru</span>
                        <span class="ftag ftb">Guru → Guru</span>
                    </div>
                </div>
                <div class="feat-card fc-teal r" style="transition-delay:.07s">
                    <div class="feat-icon fi-t">🤖</div>
                    <h3>Klasterisasi K-Means</h3>
                    <p>Algoritma K-Means otomatis mengelompokkan guru ke dalam 4 klaster berdasarkan nilai kompetensi,
                        kehadiran, dan prestasi.</p>
                    <div class="feat-tags">
                        <span class="ftag ftt">Klaster A–D</span>
                        <span class="ftag ftt">Otomatis</span>
                    </div>
                </div>
                <div class="feat-card fc-gold r" style="transition-delay:.14s">
                    <div class="feat-icon fi-g">📅</div>
                    <h3>Rekap Kehadiran</h3>
                    <p>Admin menginput rekapitulasi kehadiran bulanan — hadir, izin, sakit, alpha, terlambat — yang
                        terintegrasi dengan kalkulasi nilai akhir.</p>
                    <div class="feat-tags">
                        <span class="ftag ftg">Import Excel</span>
                        <span class="ftag ftg">Per Bulan</span>
                    </div>
                </div>
                <div class="feat-card fc-red r" style="transition-delay:.21s">
                    <div class="feat-icon fi-r">🏆</div>
                    <h3>Pencatatan Prestasi</h3>
                    <p>Guru mencatat prestasi dari tingkat sekolah hingga internasional. Sistem poin berbobot yang
                        tervalidasi admin berkontribusi pada nilai akhir.</p>
                    <div class="feat-tags">
                        <span class="ftag" style="background:var(--red-bg);color:var(--red)">6 Tingkatan</span>
                        <span class="ftag" style="background:var(--red-bg);color:var(--red)">Poin Berbobot</span>
                    </div>
                </div>
                <div class="feat-card fc-navy r" style="transition-delay:.28s">
                    <div class="feat-icon fi-n">👁️</div>
                    <h3>Dashboard Kepala Sekolah</h3>
                    <p>Pantau distribusi klaster, rata-rata kompetensi sekolah, top performer, dan detail evaluasi tiap
                        guru termasuk kesan-pesan siswa.</p>
                    <div class="feat-tags">
                        <span class="ftag ftn">Monitoring</span>
                        <span class="ftag ftn">Detail Guru</span>
                    </div>
                </div>
                <div class="feat-card fc-mid r" style="transition-delay:.35s">
                    <div class="feat-icon fi-b">📁</div>
                    <h3>Export Laporan Excel</h3>
                    <p>Unduh hasil evaluasi lengkap seluruh guru dalam format Excel — nilai tiap kompetensi, persentase
                        kehadiran, dan label klaster — dengan satu klik.</p>
                    <div class="feat-tags">
                        <span class="ftag ftb">Satu Klik</span>
                        <span class="ftag ftb">Format .xlsx</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how">
        <div class="section-inner">
            <div class="eyebrow-sm r">Cara Kerja</div>
            <h2 class="sh2 r" style="transition-delay:.05s">Dari pengisian hingga<br><span>hasil klaster</span></h2>

            <div class="how-layout">
                <div class="steps rl">
                    <div class="step on" data-p="p1" onclick="switchP(this)">
                        <div class="step-bar"></div>
                        <div class="step-n">01</div>
                        <div class="step-body">
                            <h3>Pengisian Kuesioner</h3>
                            <p>Siswa dan guru mengisi kuesioner penilaian berdasarkan 4 kompetensi guru selama periode
                                yang ditetapkan admin.</p>
                        </div>
                    </div>
                    <div class="step" data-p="p2" onclick="switchP(this)">
                        <div class="step-bar"></div>
                        <div class="step-n">02</div>
                        <div class="step-body">
                            <h3>Input Rekap Kehadiran</h3>
                            <p>Admin memasukkan data kehadiran bulanan tiap guru yang dihitung sebagai persentase
                                kehadiran efektif.</p>
                        </div>
                    </div>
                    <div class="step" data-p="p3" onclick="switchP(this)">
                        <div class="step-bar"></div>
                        <div class="step-n">03</div>
                        <div class="step-body">
                            <h3>Pencatatan Prestasi</h3>
                            <p>Guru menginput prestasi yang diraih. Setiap prestasi mendapat poin sesuai tingkatannya
                                dan divalidasi admin.</p>
                        </div>
                    </div>
                    <div class="step" data-p="p4" onclick="switchP(this)">
                        <div class="step-bar"></div>
                        <div class="step-n">04</div>
                        <div class="step-body">
                            <h3>Proses Klasterisasi K-Means</h3>
                            <p>Admin menjalankan clustering. Sistem menghitung nilai akhir dan menempatkan guru ke
                                klaster A, B, C, atau D secara otomatis.</p>
                        </div>
                    </div>
                    <div class="step" data-p="p5" onclick="switchP(this)">
                        <div class="step-bar"></div>
                        <div class="step-n">05</div>
                        <div class="step-body">
                            <h3>Laporan & Evaluasi</h3>
                            <p>Kepala sekolah memantau dashboard dan mengunduh laporan Excel untuk arsip dan tindak
                                lanjut pembinaan guru.</p>
                        </div>
                    </div>
                </div>

                <div class="how-panel-wrap rr">
                    <div class="how-panel on" id="p1">
                        <h4>Kuesioner Penilaian</h4>
                        <div class="q-card">
                            <div class="q-text">Guru menyampaikan materi dengan jelas dan mudah dipahami siswa</div>
                            <div class="q-scale">
                                <div class="q-pip"></div>
                                <div class="q-pip"></div>
                                <div class="q-pip"></div>
                                <div class="q-pip on"></div>
                                <div class="q-pip on"></div>
                            </div>
                        </div>
                        <div class="q-card">
                            <div class="q-text">Guru berinteraksi dengan baik dan menghargai pendapat siswa</div>
                            <div class="q-scale">
                                <div class="q-pip"></div>
                                <div class="q-pip"></div>
                                <div class="q-pip"></div>
                                <div class="q-pip"></div>
                                <div class="q-pip on"></div>
                            </div>
                        </div>
                        <div class="q-card">
                            <div class="q-text">Guru menggunakan metode pembelajaran yang bervariasi</div>
                            <div class="q-scale">
                                <div class="q-pip"></div>
                                <div class="q-pip"></div>
                                <div class="q-pip on"></div>
                                <div class="q-pip on"></div>
                                <div class="q-pip on"></div>
                            </div>
                        </div>
                        <div style="margin-top:14px;font-size:11.5px;color:var(--subtle)">Skala 1–5 · Diisi Siswa dan
                            Guru · Per semester</div>
                    </div>

                    <div class="how-panel" id="p2">
                        <h4>Rekap Kehadiran Bulanan</h4>
                        <div class="attend-grid">
                            <div class="ag-item">
                                <div class="ag-val" style="color:var(--teal)">22</div>
                                <div class="ag-lbl">Hadir</div>
                            </div>
                            <div class="ag-item">
                                <div class="ag-val" style="color:var(--gold)">2</div>
                                <div class="ag-lbl">Izin/Sakit</div>
                            </div>
                            <div class="ag-item">
                                <div class="ag-val" style="color:var(--red)">0</div>
                                <div class="ag-lbl">Alpha</div>
                            </div>
                        </div>
                        <div style="font-size:12px;color:var(--muted);margin-bottom:8px;">Persentase kehadiran efektif
                        </div>
                        <div class="kbar-track" style="height:9px;border-radius:5px;margin-bottom:6px">
                            <div class="kbar-fill" style="width:91.6%;background:var(--teal)"></div>
                        </div>
                        <div style="font-family:var(--mono);font-size:16px;font-weight:500;color:var(--teal)">91.6%
                        </div>
                        <div style="margin-top:14px;font-size:11.5px;color:var(--subtle)">Diinput Admin · Hadir +
                            Terlambat dihitung sebagai kehadiran efektif</div>
                    </div>

                    <div class="how-panel" id="p3">
                        <h4>Pencatatan Prestasi</h4>
                        <div class="pres-row">
                            <div>
                                <div class="pr-name">Guru Berprestasi Tk. Kota</div>
                                <div class="pr-year">2024</div>
                            </div>
                            <span class="pr-pts">+20 poin</span>
                        </div>
                        <div class="pres-row">
                            <div>
                                <div class="pr-name">Pelatihan & Workshop Nasional</div>
                                <div class="pr-year">2024</div>
                            </div>
                            <span class="pr-pts">+55 poin</span>
                        </div>
                        <div class="pres-row">
                            <div>
                                <div class="pr-name">Karya Ilmiah Tk. Provinsi</div>
                                <div class="pr-year">2023</div>
                            </div>
                            <span class="pr-pts">+35 poin</span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;padding-top:14px;border-top:1px solid var(--border)">
                            <span style="font-size:12px;color:var(--muted)">Total poin prestasi tervalidasi</span>
                            <span
                                style="font-family:var(--mono);font-size:18px;font-weight:500;color:var(--navy)">110</span>
                        </div>
                    </div>

                    <div class="how-panel" id="p4">
                        <h4>Hasil Klasterisasi K-Means</h4>
                        <div class="kbar">
                            <div class="kbar-lbl">Pedagogik</div>
                            <div class="kbar-track">
                                <div class="kbar-fill" style="width:82%;background:var(--blue)"></div>
                            </div>
                            <div class="kbar-v">82</div>
                        </div>
                        <div class="kbar">
                            <div class="kbar-lbl">Profesional</div>
                            <div class="kbar-track">
                                <div class="kbar-fill" style="width:88%;background:var(--teal)"></div>
                            </div>
                            <div class="kbar-v">88</div>
                        </div>
                        <div class="kbar">
                            <div class="kbar-lbl">Sosial</div>
                            <div class="kbar-track">
                                <div class="kbar-fill" style="width:91%;background:var(--gold)"></div>
                            </div>
                            <div class="kbar-v">91</div>
                        </div>
                        <div class="kbar">
                            <div class="kbar-lbl">Kepribadian</div>
                            <div class="kbar-track">
                                <div class="kbar-fill" style="width:86%;background:var(--red)"></div>
                            </div>
                            <div class="kbar-v">86</div>
                        </div>
                        <div class="kbar">
                            <div class="kbar-lbl">Kehadiran</div>
                            <div class="kbar-track">
                                <div class="kbar-fill" style="width:91.6%;background:var(--subtle)"></div>
                            </div>
                            <div class="kbar-v">91.6%</div>
                        </div>
                        <div class="cluster-badge cb-a">✦ Klaster A — Sangat Baik</div>
                    </div>

                    <div class="how-panel" id="p5">
                        <h4>Laporan Evaluasi Guru</h4>
                        <table class="exp-table">
                            <thead>
                                <tr>
                                    <th>Nama Guru</th>
                                    <th>Rata-rata</th>
                                    <th>Hadir</th>
                                    <th>Klaster</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td>88.5</td>
                                    <td>95%</td>
                                    <td><span class="xbadge xb-a">A</span></td>
                                </tr>
                                <tr>
                                    <td>Siti Rahayu</td>
                                    <td>80.2</td>
                                    <td>88%</td>
                                    <td><span class="xbadge xb-b">B</span></td>
                                </tr>
                                <tr>
                                    <td>Ahmad Fauzi</td>
                                    <td>72.8</td>
                                    <td>82%</td>
                                    <td><span class="xbadge xb-c">C</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="margin-top:14px;font-size:11.5px;color:var(--subtle)">Download .xlsx · Semua guru
                            dalam satu file · Satu klik</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KOMPETENSI -->
    <section id="kompetensi">
        <div class="section-inner">
            <div class="komp-layout">
                <div class="komp-text rl">
                    <div class="eyebrow-sm">4 Dimensi Penilaian</div>
                    <h2 class="sh2">Kompetensi yang<br>dinilai <span>secara menyeluruh</span></h2>
                    <p class="sdesc">Berdasarkan standar kompetensi guru nasional, penilaian mencakup empat aspek yang
                        menjadi dasar kalkulasi nilai akhir dan klasterisasi.</p>
                    <div class="komp-list">
                        <div class="komp-item">
                            <div class="komp-num-circle kn-1">01</div>
                            <div class="komp-body">
                                <h4>Kompetensi Pedagogik</h4>
                                <p>Kemampuan merencanakan, melaksanakan, dan mengevaluasi pembelajaran secara efektif
                                    dan inovatif.</p>
                            </div>
                        </div>
                        <div class="komp-item">
                            <div class="komp-num-circle kn-2">02</div>
                            <div class="komp-body">
                                <h4>Kompetensi Profesional</h4>
                                <p>Penguasaan materi pelajaran secara mendalam dan konseptual sesuai bidang studi yang
                                    diampu.</p>
                            </div>
                        </div>
                        <div class="komp-item">
                            <div class="komp-num-circle kn-3">03</div>
                            <div class="komp-body">
                                <h4>Kompetensi Sosial</h4>
                                <p>Kemampuan berkomunikasi dan berinteraksi efektif dengan siswa, rekan guru, dan
                                    komunitas sekolah.</p>
                            </div>
                        </div>
                        <div class="komp-item">
                            <div class="komp-num-circle kn-4">04</div>
                            <div class="komp-body">
                                <h4>Kompetensi Kepribadian</h4>
                                <p>Karakter guru sebagai teladan — stabil, dewasa, berwibawa, dan berakhlak mulia bagi
                                    siswa.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="komp-visual rr">
                    <div class="kv-card kv1">
                        <div class="kv-top"><span class="kv-title">Pedagogik</span><span class="kv-score">Rata-rata
                                Sekolah</span></div>
                        <div class="kv-bar">
                            <div class="kv-fill" style="width:0" data-w="78%"></div>
                        </div>
                    </div>
                    <div class="kv-card kv2">
                        <div class="kv-top"><span class="kv-title">Profesional</span><span class="kv-score">Rata-rata
                                Sekolah</span></div>
                        <div class="kv-bar">
                            <div class="kv-fill" style="width:0" data-w="83%"></div>
                        </div>
                    </div>
                    <div class="kv-card kv3">
                        <div class="kv-top"><span class="kv-title">Sosial</span><span class="kv-score">Rata-rata
                                Sekolah</span></div>
                        <div class="kv-bar">
                            <div class="kv-fill" style="width:0" data-w="86%"></div>
                        </div>
                    </div>
                    <div class="kv-card kv4">
                        <div class="kv-top"><span class="kv-title">Kepribadian</span><span class="kv-score">Rata-rata
                                Sekolah</span></div>
                        <div class="kv-bar">
                            <div class="kv-fill" style="width:0" data-w="80%"></div>
                        </div>
                    </div>
                    <div
                        style="margin-top:8px;padding:20px;background:var(--blue-pale);border-radius:var(--radius);border:1px solid var(--border2)">
                        <div
                            style="font-size:11px;font-family:var(--mono);color:var(--blue);font-weight:500;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:6px">
                            Nilai rata-rata gabungan</div>
                        <div style="font-family:var(--mono);font-size:28px;font-weight:500;color:var(--navy)">81.75
                        </div>
                        <div style="font-size:12px;color:var(--muted);margin-top:4px">Dari skala 0–100 · Semester Ganjil
                            2024/2025</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CLUSTER -->
    <section id="cluster">
        <div class="section-inner">
            <div class="cluster-layout">
                <div class="cluster-explain rl">
                    <div class="eyebrow-sm">Sistem Klasterisasi</div>
                    <h2 class="sh2">Empat klaster<br>kinerja <span>berbasis K-Means</span></h2>
                    <p>Algoritma K-Means mengelompokkan guru berdasarkan nilai akhir yang dihitung dari rata-rata
                        kompetensi, persentase kehadiran, dan poin prestasi tervalidasi.</p>
                    <p>Hasil klasterisasi membantu kepala sekolah mengidentifikasi guru yang memerlukan pembinaan dan
                        yang layak mendapat apresiasi.</p>
                    <div
                        style="margin-top:28px;padding:20px;background:var(--blue-pale);border-radius:var(--radius);border:1px solid var(--border2)">
                        <div style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:10px;">Formula Nilai
                            Akhir</div>
                        <div style="font-family:var(--mono);font-size:13px;color:var(--blue);line-height:1.8">
                            Nilai = (Kompetensi × bobot)<br>+ Kehadiran + Prestasi
                        </div>
                    </div>
                </div>
                <div class="cluster-grid rr">
                    <div class="cg-card cg-a">
                        <div class="cg-letter">A</div>
                        <div class="cg-name">Sangat Baik</div>
                        <div class="cg-desc">Kinerja unggul di semua dimensi. Layak menjadi model bagi guru lain.</div>
                        <div class="cg-bar" style="width:85%"></div>
                    </div>
                    <div class="cg-card cg-b">
                        <div class="cg-letter">B</div>
                        <div class="cg-name">Baik</div>
                        <div class="cg-desc">Kinerja di atas rata-rata dengan beberapa aspek yang perlu ditingkatkan.
                        </div>
                        <div class="cg-bar" style="width:65%"></div>
                    </div>
                    <div class="cg-card cg-c">
                        <div class="cg-letter">C</div>
                        <div class="cg-name">Cukup</div>
                        <div class="cg-desc">Memenuhi standar minimal. Memerlukan pendampingan untuk berkembang.</div>
                        <div class="cg-bar" style="width:45%"></div>
                    </div>
                    <div class="cg-card cg-d">
                        <div class="cg-letter">D</div>
                        <div class="cg-name">Perlu Pembinaan</div>
                        <div class="cg-desc">Di bawah standar. Prioritas utama untuk program pembinaan intensif.</div>
                        <div class="cg-bar" style="width:25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ROLES -->
    <section id="roles">
        <div class="section-inner">
            <div class="eyebrow-sm roles-eyebrow r">Pengguna Sistem</div>
            <h2 class="sh2 roles-h2 r" style="transition-delay:.05s">Dirancang untuk<br>semua peran di
                <span>sekolah</span>
            </h2>
            <p class="sdesc roles-desc r" style="transition-delay:.1s;margin-bottom:0">Setiap pengguna mendapat
                antarmuka dan akses yang sesuai dengan tanggung jawabnya.</p>
            <div class="roles-grid">
                <div class="role-card rc1 r" style="transition-delay:.1s">
                    <span class="role-icon">⚙️</span>
                    <h3>Admin</h3>
                    <p>Mengelola seluruh sistem, pengguna, dan konfigurasi periode.</p>
                    <ul class="role-list">
                        <li>Manajemen akun pengguna</li>
                        <li>Import siswa massal via Excel</li>
                        <li>Input rekap kehadiran guru</li>
                        <li>Konfigurasi periode kuesioner</li>
                        <li>Jalankan proses klasterisasi</li>
                        <li>Validasi prestasi guru</li>
                    </ul>
                </div>
                <div class="role-card rc2 r" style="transition-delay:.18s">
                    <span class="role-icon">🏫</span>
                    <h3>Kepala Sekolah</h3>
                    <p>Memantau dan mengevaluasi kinerja seluruh guru secara menyeluruh.</p>
                    <ul class="role-list">
                        <li>Dashboard distribusi klaster</li>
                        <li>Rata-rata kompetensi sekolah</li>
                        <li>Detail profil evaluasi guru</li>
                        <li>Riwayat kesan-pesan siswa</li>
                        <li>Export laporan Excel</li>
                    </ul>
                </div>
                <div class="role-card rc3 r" style="transition-delay:.26s">
                    <span class="role-icon">👨‍🏫</span>
                    <h3>Guru</h3>
                    <p>Berpartisipasi dalam penilaian dan mengelola data prestasi diri.</p>
                    <ul class="role-list">
                        <li>Isi kuesioner penilaian rekan guru</li>
                        <li>Catat prestasi yang diraih</li>
                        <li>Lihat profil dan klaster sendiri</li>
                        <li>Riwayat evaluasi per semester</li>
                    </ul>
                </div>
                <div class="role-card rc4 r" style="transition-delay:.34s">
                    <span class="role-icon">🎒</span>
                    <h3>Siswa</h3>
                    <p>Memberikan penilaian untuk guru berdasarkan pengalaman belajar.</p>
                    <ul class="role-list">
                        <li>Isi kuesioner penilaian guru</li>
                        <li>Satu kuesioner per guru per semester</li>
                        <li>Tulis kesan dan pesan untuk guru</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="cta">
        <div class="cta-glow"></div>
        <div class="cta-inner r">
            <div class="cta-sub">Sistem Standar Mutu Guru · S-STQM</div>
            <h2 class="cta-h2">Mulai evaluasi yang<br>lebih <span>bermakna</span></h2>
            <p class="cta-p">Tingkatkan kualitas pendidikan dengan sistem penilaian guru yang terstruktur, objektif, dan
                berbasis data nyata dari lingkungan sekolah sendiri.</p>
            <a href="/login" class="btn-cta">
                Masuk ke Sistem
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="nav-logo" style="color:white;margin-bottom:14px;">
                    <div class="logo-mark"><svg viewBox="0 0 18 18" fill="none">
                            <rect x="2" y="2" width="6" height="6" rx="1.5" fill="white" opacity="0.9" />
                            <rect x="10" y="2" width="6" height="6" rx="1.5" fill="white" opacity="0.5" />
                            <rect x="2" y="10" width="6" height="6" rx="1.5" fill="white" opacity="0.5" />
                            <rect x="10" y="10" width="6" height="6" rx="1.5" fill="white" opacity="0.8" />
                        </svg></div>
                    S-STQM
                </div>
                <p>Sistem penilaian kinerja guru berbasis web dengan klasterisasi K-Means untuk mendukung pengembangan
                    mutu pendidikan yang terukur dan transparan.</p>
            </div>
            <div>
                <div class="fc-head">Fitur</div>
                <ul class="fc-links">
                    <li><a href="#features">Kuesioner Digital</a></li>
                    <li><a href="#features">Klasterisasi K-Means</a></li>
                    <li><a href="#features">Rekap Kehadiran</a></li>
                    <li><a href="#features">Pencatatan Prestasi</a></li>
                    <li><a href="#features">Export Laporan</a></li>
                </ul>
            </div>
            <div>
                <div class="fc-head">Sistem</div>
                <ul class="fc-links">
                    <li><a href="#roles">Admin</a></li>
                    <li><a href="#roles">Kepala Sekolah</a></li>
                    <li><a href="#roles">Guru</a></li>
                    <li><a href="#roles">Siswa</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 S-STQM · Sistem Standar Mutu Guru</p>
            <div class="tech-stack">
                <span class="ts-badge">Laravel</span>
                <span class="ts-badge">PHP</span>
                <span class="ts-badge">K-Means</span>
                <span class="ts-badge">MySQL</span>
            </div>
        </div>
    </footer>

    <script>
        // progress bar
        const prog = document.getElementById('progress');
        window.addEventListener('scroll', () => {
            const pct = window.scrollY / (document.body.scrollHeight - window.innerHeight) * 100;
            prog.style.width = pct + '%';
        });

        // nav scroll
        const navEl = document.getElementById('nav');
        window.addEventListener('scroll', () => {
            navEl.classList.toggle('scrolled', window.scrollY > 50);
        });

        // reveal
        const revEls = document.querySelectorAll('.r,.rl,.rr');
        const revObs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
        }, { threshold: 0.1 });
        revEls.forEach(el => revObs.observe(el));

        // counter
        function animCount(el, target, dur) {
            let s = null;
            const step = ts => {
                if (!s) s = ts;
                const p = Math.min((ts - s) / dur, 1);
                const ease = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.round(ease * target);
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        }
        const cnEls = document.querySelectorAll('.cn');
        const cnObs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    animCount(e.target, parseInt(e.target.dataset.t), 900);
                    cnObs.unobserve(e.target);
                }
            });
        }, { threshold: 0.5 });
        cnEls.forEach(el => cnObs.observe(el));

        // kompeteni bars
        const barEls = document.querySelectorAll('.kv-fill[data-w]');
        const barObs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.style.width = e.target.dataset.w;
                    barObs.unobserve(e.target);
                }
            });
        }, { threshold: 0.3 });
        barEls.forEach(el => barObs.observe(el));

        // how it works panels
        function switchP(stepEl) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('on'));
            document.querySelectorAll('.how-panel').forEach(p => p.classList.remove('on'));
            stepEl.classList.add('on');
            document.getElementById(stepEl.dataset.p).classList.add('on');
        }

        let cur = 0;
        const allSteps = document.querySelectorAll('.step');
        setInterval(() => {
            const sec = document.getElementById('how');
            const r = sec.getBoundingClientRect();
            if (r.top < window.innerHeight && r.bottom > 0) {
                cur = (cur + 1) % allSteps.length;
                switchP(allSteps[cur]);
            }
        }, 3200);

        // smooth anchor
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const t = document.querySelector(a.getAttribute('href'));
                if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
            });
        });
    </script>
</body>

</html>
