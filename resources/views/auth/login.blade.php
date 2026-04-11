<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — STQM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: #0a0a14;">

    {{-- Background glow --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-30%] left-[-20%] w-[70%] h-[70%] rounded-full opacity-40"
             style="background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 70%)"></div>
        <div class="absolute bottom-[-30%] right-[-20%] w-[70%] h-[70%] rounded-full opacity-40"
             style="background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, transparent 70%)"></div>
    </div>

    {{-- Card --}}
    <div class="w-full max-w-md rounded-[2rem] overflow-hidden z-10 relative"
         style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 24px 80px rgba(0,0,0,0.4);">

        {{-- Header --}}
        <div class="p-10 text-center relative overflow-hidden"
             style="border-bottom: 1px solid rgba(255,255,255,0.06);">
            <div class="absolute inset-0 opacity-30"
                 style="background: linear-gradient(135deg, rgba(249,115,22,0.15) 0%, rgba(139,92,246,0.1) 100%)"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="p-4 rounded-[1.25rem] mb-5"
                     style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 12px 40px rgba(249,115,22,0.35);">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-white">STQM System</h1>
                <p class="text-gray-400 text-sm mt-2">Smart Teacher Quality Mapping</p>
            </div>
        </div>

        {{-- Form --}}
        <div class="p-8">

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl text-sm text-red-400"
                     style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="Masukkan email..."
                               class="w-full pl-11 pr-4 py-3 rounded-2xl text-white text-sm placeholder-gray-500 outline-none transition-all"
                               style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                               onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-11 pr-4 py-3 rounded-2xl text-white text-sm placeholder-gray-500 outline-none transition-all"
                               style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                               onfocus="this.style.borderColor='rgba(249,115,22,0.5)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.08)'">
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded accent-orange-500">
                    <label for="remember" class="text-sm text-gray-400">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl font-semibold text-white text-sm transition-all mt-2"
                        style="background: linear-gradient(135deg, #f97316, #eab308); box-shadow: 0 8px 32px rgba(249,115,22,0.3);"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                    Masuk ke Sistem
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <p class="text-center text-xs text-gray-600 mt-6">
                © {{ date('Y') }} STQM — Smart Teacher Quality Mapping
            </p>
        </div>
    </div>

</body>
</html>
