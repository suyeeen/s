<!DOCTYPE html>
<html lang="id" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — STQM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Jalankan SEBELUM render supaya tidak flicker --}}
    <script>
        (function() {
            const saved = localStorage.getItem('stqm-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    <style>
        /* ── DARK (default) ── */
        [data-theme="dark"] {
            --bg-page: #0a0a14;
            --bg-card: rgba(255, 255, 255, 0.04);
            --bg-card-header: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
            --border-card: rgba(255, 255, 255, 0.08);
            --border-input: rgba(255, 255, 255, 0.08);
            --border-header: rgba(255, 255, 255, 0.06);
            --text-title: #ffffff;
            --text-sub: #9ca3af;
            --text-label: #9ca3af;
            --text-footer: #4b5563;
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-text: #ffffff;
            --input-placeholder: #6b7280;
            --glow-1: rgba(139, 92, 246, 0.2);
            --glow-2: rgba(249, 115, 22, 0.15);
            --shadow-card: 0 24px 80px rgba(0, 0, 0, 0.4);
            --toggle-bg: rgba(255, 255, 255, 0.06);
            --toggle-border: rgba(255, 255, 255, 0.1);
            --toggle-icon: #f59e0b;
        }

        /* ── LIGHT ── */
        [data-theme="light"] {
            --bg-page: #f1f5f9;
            --bg-card: rgba(255, 255, 255, 0.85);
            --bg-card-header: linear-gradient(135deg, rgba(249, 115, 22, 0.08) 0%, rgba(139, 92, 246, 0.06) 100%);
            --border-card: rgba(0, 0, 0, 0.08);
            --border-input: rgba(0, 0, 0, 0.1);
            --border-header: rgba(0, 0, 0, 0.06);
            --text-title: #0f172a;
            --text-sub: #64748b;
            --text-label: #475569;
            --text-footer: #94a3b8;
            --input-bg: rgba(0, 0, 0, 0.04);
            --input-text: #0f172a;
            --input-placeholder: #94a3b8;
            --glow-1: rgba(139, 92, 246, 0.08);
            --glow-2: rgba(249, 115, 22, 0.07);
            --shadow-card: 0 24px 80px rgba(0, 0, 0, 0.1);
            --toggle-bg: rgba(0, 0, 0, 0.06);
            --toggle-border: rgba(0, 0, 0, 0.1);
            --toggle-icon: #6366f1;
        }

        body {
            background: var(--bg-page);
            transition: background 0.3s ease;
        }

        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            box-shadow: var(--shadow-card);
            backdrop-filter: blur(20px);
            transition: background 0.3s, border 0.3s;
        }

        .card-header {
            border-bottom: 1px solid var(--border-header);
            background: var(--bg-card-header);
            transition: background 0.3s;
        }

        .text-title {
            color: var(--text-title);
        }

        .text-sub {
            color: var(--text-sub);
        }

        .text-label {
            color: var(--text-label);
        }

        .text-footer {
            color: var(--text-footer);
        }

        .login-input {
            background: var(--input-bg);
            border: 1px solid var(--border-input);
            color: var(--input-text);
            transition: border-color 0.2s, background 0.3s;
        }

        .login-input::placeholder {
            color: var(--input-placeholder);
        }

        .login-input:focus {
            border-color: rgba(249, 115, 22, 0.5);
            outline: none;
        }

        .glow-1 {
            background: radial-gradient(circle, var(--glow-1) 0%, transparent 70%);
        }

        .glow-2 {
            background: radial-gradient(circle, var(--glow-2) 0%, transparent 70%);
        }

        /* Toggle button */
        .theme-toggle {
            background: var(--toggle-bg);
            border: 1px solid var(--toggle-border);
            color: var(--toggle-icon);
            transition: all 0.3s;
        }

        .theme-toggle:hover {
            opacity: 0.8;
            transform: rotate(20deg);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative">

    {{-- Background glow --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="glow-1 absolute top-[-30%] left-[-20%] w-[70%] h-[70%] rounded-full opacity-40"></div>
        <div class="glow-2 absolute bottom-[-30%] right-[-20%] w-[70%] h-[70%] rounded-full opacity-40"></div>
    </div>

    {{-- Theme toggle button (pojok kanan atas) --}}
    <button id="theme-toggle" onclick="toggleTheme()"
        class="theme-toggle fixed top-4 right-4 z-50 w-10 h-10 rounded-2xl flex items-center justify-center cursor-pointer">

        {{-- Sun icon (tampil saat dark mode) --}}
        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>

        {{-- Moon icon (tampil saat light mode) --}}
        <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
            stroke="currentColor" class="w-5 h-5 hidden">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
    </button>

    {{-- Card --}}
    <div class="login-card w-full max-w-md rounded-[2rem] overflow-hidden z-10 relative">

        {{-- Header --}}
        <div class="card-header p-10 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-30" style="background: var(--bg-card-header)"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="p-4 rounded-[1.25rem] mb-5"
                    style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 12px 40px rgba(249,115,22,0.35);">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h1 class="text-title text-2xl font-extrabold tracking-tight">STQM System</h1>
                <p class="text-sub text-sm mt-2">Smart Teacher Quality Mapping</p>
            </div>
        </div>

        {{-- Form --}}
        <div class="p-8">

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl text-sm text-red-400"
                    style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="text-label block text-sm font-medium mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-placeholder)" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="Masukkan email..."
                            class="login-input w-full pl-11 pr-4 py-3 rounded-2xl text-sm">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-label block text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-placeholder)" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="login-input w-full pl-11 pr-4 py-3 rounded-2xl text-sm">
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded accent-orange-500">
                    <label for="remember" class="text-label text-sm">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl font-semibold text-white text-sm transition-all mt-2"
                    style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 8px 32px rgba(249,115,22,0.3);"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Masuk ke Sistem
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </form>

            <p class="text-footer text-center text-xs mt-6">
                © {{ date('Y') }} STQM — Smart Teacher Quality Mapping
            </p>
        </div>
    </div>

    <script>
        // Sinkronkan icon saat halaman load
        (function() {
            const theme = localStorage.getItem('stqm-theme') || 'dark';
            syncIcon(theme);
        })();

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'dark';
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('stqm-theme', next);
            syncIcon(next);
        }

        function syncIcon(theme) {
            const sun = document.getElementById('icon-sun');
            const moon = document.getElementById('icon-moon');
            if (!sun || !moon) return;
            if (theme === 'dark') {
                sun.classList.remove('hidden'); // dark → tampilkan sun (untuk switch ke light)
                moon.classList.add('hidden');
            } else {
                sun.classList.add('hidden');
                moon.classList.remove('hidden'); // light → tampilkan moon (untuk switch ke dark)
            }
        }
    </script>

</body>

</html>
