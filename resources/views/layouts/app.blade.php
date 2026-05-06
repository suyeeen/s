<!DOCTYPE html>
<html lang="id" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STQM - @yield('title', 'Smart Teacher Quality Mapping')</title>

    <script>
        (function () {
            /* Default: light — profesional, konsisten dengan landing & login */
            const saved = localStorage.getItem('stqm-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')

    <style>
        /* ═══════════════════════════════════════════════════
           STQM DESIGN TOKENS — Selaras dengan landing & login
           Palet: Warm Neutral + Accent #E8560A (muted)
        ═══════════════════════════════════════════════════ */

        /* ── LIGHT — warm professional ── */
        [data-theme="light"] {
            /* Surfaces */
            --bg-page: #F5F2EE;
            --bg-sidebar: #FFFFFF;

            /* Border */
            --border-color: #E5DDD4;

            /* Text */
            --text-main: #1A1613;
            --text-muted: #7A6F67;

            /* Mobile header */
            --header-bg: rgba(245, 242, 238, 0.92);

            /* Theme toggle */
            --toggle-bg: rgba(26, 22, 19, 0.06);
            --toggle-border: rgba(26, 22, 19, 0.12);
            --toggle-color: #5A4F47;

            /* Nav */
            --nav-active-bg: rgba(232, 86, 10, 0.09);
            --nav-hover-bg: rgba(26, 22, 19, 0.04);

            /* Icon circles */
            --icon-bg: rgba(26, 22, 19, 0.06);

            /* User info box */
            --user-bg: #FAF8F5;

            /* SweetAlert */
            --swal-bg: #FFFFFF;
            --swal-color: #1A1613;

            /* Cards */
            --card-bg: #FFFFFF;
            --card-border: #E5DDD4;
            --card-bg-soft: #FAF8F5;
            --card-border-soft: #EDE7DF;
            --card-footer-bg: #FAF8F5;
            --card-divider: #E5DDD4;

            /* Inputs */
            --input-bg: #FFFFFF;
            --input-border: #D5CCC4;

            /* Buttons */
            --btn-bg: rgba(26, 22, 19, 0.06);
            --btn-border: #D5CCC4;

            /* Accent — lebih muted dari orange murni */
            --accent: #E8560A;
            --accent-hover: #C44608;
            --accent-soft: rgba(232, 86, 10, 0.09);
            --accent-ring: rgba(232, 86, 10, 0.15);
        }

        /* ── DARK — tetap dipertahankan ── */
        [data-theme="dark"] {
            --bg-page: #0a0a14;
            --bg-sidebar: #0e0e1a;
            --border-color: rgba(255, 255, 255, 0.05);
            --text-main: #ffffff;
            --text-muted: #9ca3af;
            --header-bg: rgba(10, 10, 20, 0.8);
            --toggle-bg: rgba(255, 255, 255, 0.06);
            --toggle-border: rgba(255, 255, 255, 0.1);
            --toggle-color: #f59e0b;
            --nav-active-bg: rgba(255, 255, 255, 0.08);
            --nav-hover-bg: rgba(255, 255, 255, 0.04);
            --icon-bg: rgba(255, 255, 255, 0.05);
            --user-bg: rgba(255, 255, 255, 0.04);
            --swal-bg: #0e0e1a;
            --swal-color: #ffffff;
            --card-bg: rgba(255, 255, 255, 0.04);
            --card-border: rgba(255, 255, 255, 0.08);
            --card-bg-soft: rgba(255, 255, 255, 0.02);
            --card-border-soft: rgba(255, 255, 255, 0.05);
            --card-footer-bg: rgba(255, 255, 255, 0.02);
            --card-divider: rgba(255, 255, 255, 0.06);
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(255, 255, 255, 0.08);
            --btn-bg: rgba(255, 255, 255, 0.05);
            --btn-border: rgba(255, 255, 255, 0.08);
            --accent: #f97316;
            --accent-hover: #ea6a0a;
            --accent-soft: rgba(249, 115, 22, 0.1);
            --accent-ring: rgba(249, 115, 22, 0.2);
        }

        body {
            background: var(--bg-page);
            color: var(--text-main);
            transition: background .25s, color .25s;
        }

        aside {
            background: var(--bg-sidebar);
            border-color: var(--border-color);
            transition: background .25s;
        }

        header {
            background: var(--header-bg);
            border-color: var(--border-color);
        }

        .theme-toggle {
            background: var(--toggle-bg);
            border: 1px solid var(--toggle-border);
            color: var(--toggle-color);
            transition: all .3s;
        }

        .theme-toggle:hover {
            opacity: .75;
            transform: rotate(18deg);
        }

        /* ── LIGHT: Inline-style dark glass card fix ──── */
        /* Form sections yang masih pakai rgba(255,255,255,0.04) */
        [data-theme="light"] .lm-card {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            box-shadow: 0 1px 8px rgba(26, 22, 19, 0.06);
        }

        [data-theme="light"] .lm-card-header {
            background: var(--card-bg-soft) !important;
            border-bottom: 1px solid var(--card-divider) !important;
        }

        [data-theme="light"] .lm-inner {
            background: var(--card-bg-soft) !important;
            border: 1px solid var(--card-border-soft) !important;
        }

        /* ── LIGHT: Accent button consistent ─────────── */
        [data-theme="light"] .lm-btn-primary {
            background: var(--accent) !important;
            box-shadow: 0 4px 14px rgba(232, 86, 10, 0.2) !important;
        }

        [data-theme="light"] .lm-btn-primary:hover {
            background: var(--accent-hover) !important;
        }

        /* SweetAlert */
        .swal2-popup {
            border-radius: 1.25rem !important;
        }

        /* ── Fixed sidebar, scrollable content area ── */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .app-sidebar {
            width: 256px;
            /* w-64 */
            flex-shrink: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
            /* tidak perlu sticky/fixed */
        }

        .app-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .app-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .app-sidebar::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .app-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            /* main sendiri tidak scroll */
            min-width: 0;
        }

        .app-content {
            flex: 1;
            overflow-y: auto;
            /* HANYA area ini yang scroll */
            overflow-x: hidden;
        }

        .app-content::-webkit-scrollbar {
            width: 6px;
        }

        .app-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .app-content::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .app-content::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>

<body x-data="{ sidebarOpen: false }">
    <div class="app-shell">

        <aside class="app-sidebar hidden md:flex flex-col border-r">
            @include('layouts.sidebar')
        </aside>

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-30 md:hidden"
            @click="sidebarOpen = false"></div>

        <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            class="fixed inset-y-0 left-0 w-64 z-40 md:hidden border-r">
            @include('layouts.sidebar')
        </aside>

        <main class="app-main">
            <header class="md:hidden flex items-center justify-between p-4 border-b backdrop-blur flex-shrink-0">
                <span class="font-bold text-lg" style="color:var(--text-main)">STQM</span>
                <div class="flex items-center gap-2">
                    <button onclick="toggleTheme()"
                        class="theme-toggle w-9 h-9 rounded-xl flex items-center justify-center">
                        <svg id="app-icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                        <svg id="app-icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                    <button @click="sidebarOpen = true" style="color:var(--text-muted)" class="p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </header>

            <div class="app-content p-4 md:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function getSwalTheme() {
            const theme = localStorage.getItem('stqm-theme') || 'light';
            return {
                background: theme === 'dark' ? '#0e0e1a' : '#ffffff',
                color: theme === 'dark' ? '#ffffff' : '#1A1613',
            };
        }

        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function () {
                const t = getSwalTheme();
                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: '{{ addslashes(session("success")) }}',
                    confirmButtonColor: '#E8560A', background: t.background, color: t.color,
                    timer: 3000, timerProgressBar: true, showConfirmButton: false,
                    customClass: { popup: 'swal2-popup' }
                });
            });
        @endif
        @if (session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                const t = getSwalTheme();
                Swal.fire({
                    icon: 'error', title: 'Gagal!', text: '{{ addslashes(session("error")) }}',
                    confirmButtonColor: '#E8560A', background: t.background, color: t.color,
                    customClass: { popup: 'swal2-popup' }
                });
            });
        @endif
        @if (session('warning'))
            document.addEventListener('DOMContentLoaded', function () {
                const t = getSwalTheme();
                Swal.fire({
                    icon: 'warning', title: 'Perhatian!', text: '{{ addslashes(session("warning")) }}',
                    confirmButtonColor: '#E8560A', background: t.background, color: t.color,
                    customClass: { popup: 'swal2-popup' }
                });
            });
        @endif

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.swal-delete').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const nama = form.dataset.nama || 'data ini';
                    const t = getSwalTheme();
                    Swal.fire({
                        icon: 'warning', title: 'Hapus ' + nama + '?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
                        background: t.background, color: t.color,
                        customClass: { popup: 'swal2-popup' }
                    }).then((result) => { if (result.isConfirmed) form.submit(); });
                });
            });

            document.querySelectorAll('.swal-confirm').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const judul = btn.dataset.judul || 'Konfirmasi';
                    const pesan = btn.dataset.pesan || 'Lanjutkan aksi ini?';
                    const target = btn.dataset.target;
                    const t = getSwalTheme();
                    Swal.fire({
                        icon: 'question', title: judul, text: pesan,
                        showCancelButton: true, confirmButtonColor: '#E8560A', cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Lanjutkan!', cancelButtonText: 'Batal',
                        background: t.background, color: t.color,
                        customClass: { popup: 'swal2-popup' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (target) document.getElementById(target).submit();
                            else btn.closest('form').submit();
                        }
                    });
                });
            });
        });

        (function () { syncAppIcon(localStorage.getItem('stqm-theme') || 'light'); })();

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('stqm-theme', next);
            syncAppIcon(next);
        }

        function syncAppIcon(theme) {
            const sun = document.getElementById('app-icon-sun');
            const moon = document.getElementById('app-icon-moon');
            if (!sun || !moon) return;
            if (theme === 'dark') { sun.classList.remove('hidden'); moon.classList.add('hidden'); }
            else { sun.classList.add('hidden'); moon.classList.remove('hidden'); }
        }
    </script>
</body>

</html>
