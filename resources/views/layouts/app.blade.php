<!DOCTYPE html>
<html lang="id" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STQM - @yield('title', 'Smart Teacher Quality Mapping')</title>

    <script>
        (function () {
            const saved = localStorage.getItem('stqm-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
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
        }

        [data-theme="light"] {
            /*
             * Light mode — Blue Professional
             * Selaras dengan landing page (#F8FAFC base) dan login page (#EFF6FF bg)
             * Token ini HANYA mengubah light mode; dark mode tidak terpengaruh.
             */

            /* Surfaces */
            --bg-page: #F0F5FF;
            /* biru-slate sangat muda — halaman */
            --bg-sidebar: #FFFFFF;
            /* sidebar putih bersih */

            /* Border & divider */
            --border-color: rgba(29, 78, 216, 0.09);
            /* biru tipis */

            /* Text */
            --text-main: #0F172A;
            /* slate-900 */
            --text-muted: #475569;
            /* slate-600 */

            /* Header (top bar mobile) */
            --header-bg: rgba(240, 245, 255, 0.92);

            /* Theme toggle button */
            --toggle-bg: rgba(29, 78, 216, 0.08);
            --toggle-border: rgba(29, 78, 216, 0.18);
            --toggle-color: #1D4ED8;
            /* biru-700 — ikon bulan/matahari */

            /* Nav items */
            --nav-active-bg: rgba(29, 78, 216, 0.09);
            /* highlight aktif biru muda */
            --nav-hover-bg: rgba(29, 78, 216, 0.05);
            /* hover sangat lembut */

            /* Icon background (lingkaran di samping menu) */
            --icon-bg: rgba(29, 78, 216, 0.07);

            /* User info box di sidebar */
            --user-bg: rgba(29, 78, 216, 0.05);

            /* SweetAlert */
            --swal-bg: #FFFFFF;
            --swal-color: #0F172A;

            /* Cards */
            --card-bg: #FFFFFF;
            --card-border: rgba(29, 78, 216, 0.1);
            --card-bg-soft: rgba(239, 246, 255, 0.6);
            /* biru-50 transparan */
            --card-border-soft: rgba(29, 78, 216, 0.07);
            --card-footer-bg: rgba(239, 246, 255, 0.5);
            --card-divider: rgba(29, 78, 216, 0.08);

            /* Inputs */
            --input-bg: #F8FAFF;
            --input-border: rgba(29, 78, 216, 0.15);

            /* Generic buttons */
            --btn-bg: rgba(29, 78, 216, 0.07);
            --btn-border: rgba(29, 78, 216, 0.15);

            /* Accent utama (untuk komponen yang masih pakai warna aksen inline) */
            --accent: #1D4ED8;
            --accent-hover: #1E40AF;
            --accent-soft: rgba(29, 78, 216, 0.09);
            --accent-ring: rgba(29, 78, 216, 0.2);
        }

        body {
            background: var(--bg-page);
            transition: background 0.3s;
        }

        aside {
            background: var(--bg-sidebar);
            border-color: var(--border-color);
            transition: background 0.3s;
        }

        header {
            background: var(--header-bg);
            border-color: var(--border-color);
        }

        .theme-toggle {
            background: var(--toggle-bg);
            border: 1px solid var(--toggle-border);
            color: var(--toggle-color);
            transition: all 0.3s;
        }

        .theme-toggle:hover {
            opacity: 0.75;
            transform: rotate(20deg);
        }

        /* SweetAlert custom style */
        .swal2-popup {
            border-radius: 1.5rem !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
    </style>
</head>

<body class="min-h-screen" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="hidden md:flex flex-col w-64 min-h-screen border-r">
            @include('layouts.sidebar')
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/60 z-30 md:hidden"
            @click="sidebarOpen = false"></div>

        <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            class="fixed inset-y-0 left-0 w-64 z-40 md:hidden border-r">
            @include('layouts.sidebar')
        </aside>

        {{-- Main content --}}
        <main class="flex-1 flex flex-col">

            {{-- Mobile header --}}
            <header class="md:hidden flex items-center justify-between p-4 border-b backdrop-blur">
                <span class="font-bold" style="color: var(--text-main)">STQM</span>
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

                    <button @click="sidebarOpen = true" style="color: var(--text-muted)" class="p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </header>

            <div class="flex-1 p-4 md:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // ── Ambil warna tema saat ini ──────────────────────────────────────────
        function getSwalTheme() {
            const theme = localStorage.getItem('stqm-theme') || 'dark';
            return {
                background: theme === 'dark' ? '#0e0e1a' : '#ffffff',
                color: theme === 'dark' ? '#ffffff' : '#0f172a',
            };
        }

        // ── Flash session → SweetAlert ─────────────────────────────────────────
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function () {
                const t = getSwalTheme();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ addslashes(session('success')) }}',
                    confirmButtonColor: '#1D4ED8',
                    background: t.background,
                    color: t.color,
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal2-popup'
                    },
                });
            });
        @endif

        @if (session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                const t = getSwalTheme();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ addslashes(session('error')) }}',
                    confirmButtonColor: '#1D4ED8',
                    background: t.background,
                    color: t.color,
                    customClass: {
                        popup: 'swal2-popup'
                    },
                });
            });
        @endif

        @if (session('warning'))
            document.addEventListener('DOMContentLoaded', function () {
                const t = getSwalTheme();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: '{{ addslashes(session('warning')) }}',
                    confirmButtonColor: '#1D4ED8',
                    background: t.background,
                    color: t.color,
                    customClass: {
                        popup: 'swal2-popup'
                    },
                });
            });
        @endif

        // ── Konfirmasi hapus (.swal-delete) ───────────────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.swal-delete').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const nama = form.dataset.nama || 'data ini';
                    const t = getSwalTheme();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Hapus ' + nama + '?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        background: t.background,
                        color: t.color,
                        customClass: {
                            popup: 'swal2-popup'
                        },
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // ── Konfirmasi aksi (.swal-confirm) ───────────────────────────────
            document.querySelectorAll('.swal-confirm').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const judul = btn.dataset.judul || 'Konfirmasi';
                    const pesan = btn.dataset.pesan || 'Lanjutkan aksi ini?';
                    const target = btn.dataset.target;
                    const t = getSwalTheme();
                    Swal.fire({
                        icon: 'question',
                        title: judul,
                        text: pesan,
                        showCancelButton: true,
                        confirmButtonColor: '#1D4ED8',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                        background: t.background,
                        color: t.color,
                        customClass: {
                            popup: 'swal2-popup'
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (target) document.getElementById(target).submit();
                            else btn.closest('form').submit();
                        }
                    });
                });
            });
        });

        // ── Theme toggle ──────────────────────────────────────────────────────
        (function () {
            syncAppIcon(localStorage.getItem('stqm-theme') || 'dark');
        })();

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'dark';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('stqm-theme', next);
            syncAppIcon(next);
        }

        function syncAppIcon(theme) {
            const sun = document.getElementById('app-icon-sun');
            const moon = document.getElementById('app-icon-moon');
            if (!sun || !moon) return;
            if (theme === 'dark') {
                sun.classList.remove('hidden');
                moon.classList.add('hidden');
            } else {
                sun.classList.add('hidden');
                moon.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>
