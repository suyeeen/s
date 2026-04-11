<div class="flex flex-col h-full p-4">
    {{-- Logo --}}
    <div class="flex items-center gap-3 px-2 py-4 mb-4 border-b border-white/5">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-yellow-500 flex items-center justify-center">
            <span class="text-white font-bold text-sm">S</span>
        </div>
        <div>
            <p class="font-bold text-white text-sm leading-tight">STQM</p>
            <p class="text-gray-500 text-xs">Teacher Quality Mapping</p>
        </div>
    </div>

    {{-- User info --}}
    <div class="px-2 py-3 mb-4 rounded-2xl bg-white/4 border border-white/6">
        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
        <p class="text-gray-400 text-xs mt-0.5 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
    </div>

    {{-- Nav items --}}
    <nav class="flex-1 space-y-1">
        @php
            $menus = match(auth()->user()->role) {
                'siswa'  => [['route' => 'siswa.kuesioner',     'label' => 'Isi Kuesioner']],
                'guru'   => [
                    ['route' => 'guru.self-assessment', 'label' => 'Self Assessment'],
                    ['route' => 'guru.absensi',         'label' => 'Data Kehadiran'],
                    ['route' => 'guru.prestasi.index',  'label' => 'Data Prestasi'],
                ],
                'kepsek' => [
                    ['route' => 'kepala.dashboard',  'label' => 'Dashboard'],
                    ['route' => 'kepala.evaluasi',   'label' => 'Laporan Evaluasi'],
                ],
                'admin'  => [
                    ['route' => 'admin.index',      'label' => 'Manajemen Pengguna'],
                    ['route' => 'admin.monitoring', 'label' => 'Monitoring'],
                    ['route' => 'admin.settings',   'label' => 'Pengaturan'],
                ],
                default => []
            };
        @endphp

        @foreach($menus as $menu)
            <a href="{{ route($menu['route']) }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm transition-all
                      {{ request()->routeIs($menu['route'])
                         ? 'bg-white/8 text-white font-medium border border-white/10'
                         : 'text-gray-400 hover:text-white hover:bg-white/4' }}">
                {{ $menu['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm text-gray-500 hover:text-red-400 hover:bg-red-500/8 transition-all">
            Keluar
        </button>
    </form>
</div>
