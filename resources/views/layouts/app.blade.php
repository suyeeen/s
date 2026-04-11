<!DOCTYPE html>
<html lang="id" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STQM - @yield('title', 'Smart Teacher Quality Mapping')</title>

    {{-- Anti-flicker: jalankan SEBELUM render --}}
    <script>
        (function() {
            const saved = localStorage.getItem('stqm-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
            /* ← tambah ini */
            --nav-active-bg: rgba(255, 255, 255, 0.08);
            --nav-hover-bg: rgba(255, 255, 255, 0.04);
            --icon-bg: rgba(255, 255, 255, 0.05);
            --user-bg: rgba(255, 255, 255, 0.04);
        }

        [data-theme="light"] {
            --bg-page: #f1f5f9;
            --bg-sidebar: #ffffff;
            --border-color: rgba(0, 0, 0, 0.07);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --header-bg: rgba(241, 245, 249, 0.8);
            --toggle-bg: rgba(0, 0, 0, 0.06);
            --toggle-border: rgba(0, 0, 0, 0.1);
            --toggle-color: #6366f1;
            /* ← tambah ini */
            --nav-active-bg: rgba(0, 0, 0, 0.06);
            --nav-hover-bg: rgba(0, 0, 0, 0.03);
            --icon-bg: rgba(0, 0, 0, 0.05);
            --user-bg: rgba(0, 0, 0, 0.03);
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
                    {{-- Toggle di mobile header --}}
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
                {{-- Flash messages --}}
                @if (session('success'))
                    <div
                        class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Sinkronkan icon saat load
        (function() {
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
