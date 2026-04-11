<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STQM - @yield('title', 'Smart Teacher Quality Mapping')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#0a0a14] min-h-screen" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="hidden md:flex flex-col w-64 min-h-screen border-r border-white/5 bg-[#0e0e1a]">
            @include('layouts.sidebar')
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/60 z-30 md:hidden"
             @click="sidebarOpen = false"></div>
        <aside x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
               class="fixed inset-y-0 left-0 w-64 z-40 md:hidden border-r border-white/5 bg-[#0e0e1a]">
            @include('layouts.sidebar')
        </aside>

        {{-- Main content --}}
        <main class="flex-1 flex flex-col">
            {{-- Mobile header --}}
            <header class="md:hidden flex items-center justify-between p-4 border-b border-white/5 bg-[#0a0a14]/80 backdrop-blur">
                <span class="font-bold text-white">STQM</span>
                <button @click="sidebarOpen = true" class="text-gray-400 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </header>

            <div class="flex-1 p-4 md:p-8">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>