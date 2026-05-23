<div class="flex flex-col h-full p-4">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-2 py-4 mb-4 border-b" style="border-color: var(--border-color)">
        <div class="w-9 h-9 rounded-xl overflow-hidden shrink-0" style="box-shadow: 0 4px 12px rgba(249,115,22,0.3);">
            <img src="{{ asset('images/logo.png') }}" alt="STQM Logo" class="w-full h-full object-cover">
        </div>
        <div>
            <p class="font-bold text-sm leading-tight" style="color: var(--text-main)">STQM</p>
            <p class="text-xs" style="color: var(--text-muted)">Teacher Quality Mapping</p>
        </div>
    </div>

    {{-- User info --}}
    <div class="px-2 py-3 mb-4 rounded-2xl" style="background: var(--user-bg); border: 1px solid var(--border-color)">
        <p class="text-sm font-medium truncate" style="color: var(--text-main)">{{ auth()->user()->name }}</p>
        <p class="text-xs mt-0.5 capitalize" style="color: var(--text-muted)">
            {{ str_replace('_', ' ', auth()->user()->role) }}
        </p>
    </div>

    {{-- Nav items --}}
    <nav class="flex-1 space-y-1">
        @php
            $menus = match (auth()->user()->role) {
                'siswa' => [
                    [
                        'route' => 'siswa.kuesioner',
                        'label' => 'Isi Kuesioner',
                        'icon' => 'pencil',
                        'color' => 'text-sky-400',
                        'bg' => 'bg-sky-500/15',
                    ],
                ],
                'guru' => [
                    [
                        'route' => 'guru.kuesioner',
                        'label' => 'Penilaian Guru',
                        'icon' => 'clipboard',
                        'color' => 'text-violet-400',
                        'bg' => 'bg-violet-500/15',
                    ],
                    [
                        'route' => 'guru.absensi',
                        'label' => 'Data Kehadiran',
                        'icon' => 'calendar',
                        'color' => 'text-emerald-400',
                        'bg' => 'bg-emerald-500/15',
                    ],
                    [
                        'route' => 'guru.prestasi.index',
                        'label' => 'Data Prestasi',
                        'icon' => 'award',
                        'color' => 'text-amber-400',
                        'bg' => 'bg-amber-500/15',
                    ],
                    [
                        'route' => 'guru.profil',
                        'label' => 'Profil Kompetensi',
                        'icon' => 'user-circle',
                        'color' => 'text-orange-400',
                        'bg' => 'bg-orange-500/15',
                    ],
                ],
                'kepsek' => [
                    [
                        'route' => 'kepala.dashboard',
                        'label' => 'Dashboard',
                        'icon' => 'chart',
                        'color' => 'text-cyan-400',
                        'bg' => 'bg-cyan-500/15',
                    ],
                    [
                        'route' => 'kepala.evaluasi',
                        'label' => 'Laporan Evaluasi',
                        'icon' => 'report',
                        'color' => 'text-rose-400',
                        'bg' => 'bg-rose-500/15',
                    ],
                ],
                'admin' => [
                    [
                        'route' => 'admin.users.index',
                        'label' => 'Manajemen Pengguna',
                        'icon' => 'users',
                        'color' => 'text-indigo-400',
                        'bg' => 'bg-indigo-500/15',
                    ],
                    [
                        'route' => 'admin.prestasi.index', // ✅ tambah ini
                        'label' => 'Konfirmasi Prestasi',
                        'icon' => 'award',
                        'color' => 'text-amber-400',
                        'bg' => 'bg-amber-500/15',
                    ],
                    [
                        'route' => 'admin.absensi.index',
                        'label' => 'Rekap Absensi',
                        'icon' => 'calendar',
                        'color' => 'text-emerald-400',
                        'bg' => 'bg-emerald-500/15',
                    ],
                    [
                        'route' => 'admin.monitoring',
                        'label' => 'Monitoring',
                        'icon' => 'monitor',
                        'color' => 'text-teal-400',
                        'bg' => 'bg-teal-500/15',
                    ],
                    [
                        'route' => 'admin.settings',
                        'label' => 'Pengaturan',
                        'icon' => 'cog',
                        'color' => 'text-orange-400',
                        'bg' => 'bg-orange-500/15',
                    ],
                ],
                default => [],
            };

            $icons = [
                'pencil' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 1 1 3.182 3.182L7.5 19.213l-4.5 1.318 1.318-4.5L16.862 3.487z"/>',
                'clipboard' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 0-1-1h4a2 2 0 0 0-1 1m-3 7h6m-6 4h4"/>',
                'calendar' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>',
                'award' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0"/>',
                'chart' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>',
                'report' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>',
                'users' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>',
                'monitor' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0H3"/>',
                'cog' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
                'user-circle' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
            ];
        @endphp

        @foreach ($menus as $menu)
            @php $active = request()->routeIs($menu['route']); @endphp
            <a href="{{ route($menu['route']) }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm transition-all nav-item {{ $active ? 'nav-active ' . $menu['bg'] : 'nav-inactive' }}">
                <span
                    class="w-8 h-8 flex items-center justify-center rounded-xl flex-shrink-0 {{ $active ? $menu['bg'] : '' }}"
                    style="{{ !$active ? 'background: var(--icon-bg)' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-4 h-4 {{ $active ? $menu['color'] : '' }}"
                        style="{{ !$active ? 'color: var(--text-muted)' : '' }}">
                        {!! $icons[$menu['icon']] !!}
                    </svg>
                </span>
                {{ $menu['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- Theme toggle --}}
    <button onclick="toggleTheme()"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm transition-all mt-2 theme-toggle">
        <span class="w-8 h-8 flex items-center justify-center rounded-xl flex-shrink-0"
            style="background: var(--icon-bg)">
            <svg id="sidebar-icon-sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
            <svg id="sidebar-icon-moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.8" stroke="currentColor" class="w-4 h-4 hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
        </span>
        <span id="sidebar-theme-label" style="color: var(--text-muted)">Ganti mode</span>
    </button>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-1">
        @csrf
        <button type="submit"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-2xl text-sm transition-all hover:text-red-400 hover:bg-red-500/8"
            style="color: var(--text-muted)">
            <span class="w-8 h-8 flex items-center justify-center rounded-xl flex-shrink-0"
                style="background: var(--icon-bg)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                </svg>
            </span>
            Keluar
        </button>
    </form>
</div>

<style>
    .nav-active {
        color: var(--text-main);
        font-weight: 600;
        border: 1px solid var(--card-border-soft);
        background: var(--nav-active-bg);
    }

    [data-theme="light"] .nav-active {
        color: #C44608;
        background: rgba(232, 86, 10, 0.09);
        border-color: rgba(232, 86, 10, 0.15);
    }

    .nav-inactive {
        color: var(--text-muted);
    }

    .nav-inactive:hover {
        color: var(--text-main);
        background: var(--nav-hover-bg);
    }
</style>

<script>
    // Sinkronkan icon sidebar saat load
    (function () {
        syncSidebarIcon(localStorage.getItem('stqm-theme') || 'light');
    })();

    function syncSidebarIcon(theme) {
        const sun = document.getElementById('sidebar-icon-sun');
        const moon = document.getElementById('sidebar-icon-moon');
        const label = document.getElementById('sidebar-theme-label');
        const btn = document.querySelector('.theme-toggle');
        if (!sun || !moon) return;
        if (theme === 'dark') {
            sun.classList.remove('hidden');
            moon.classList.add('hidden');
            if (btn) btn.title = 'Beralih ke Mode Terang';
        } else {
            sun.classList.add('hidden');
            moon.classList.remove('hidden');
            if (btn) btn.title = 'Beralih ke Mode Gelap';
        }
        // Label selalu tetap "Ganti mode"
        if (label) label.textContent = 'Ganti mode';
    }
</script>
