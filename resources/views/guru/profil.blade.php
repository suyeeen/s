@extends('layouts.app')

@section('title', 'Profil Kompetensi')

@push('styles')
    <style>
        /* ── Animated gradient orbs ── */
        .profil-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            animation: orbFloat 8s ease-in-out infinite;
        }

        .profil-orb-1 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(232, 86, 10, 0.18) 0%, transparent 70%);
            top: -80px;
            right: -60px;
            animation-delay: 0s;
        }

        .profil-orb-2 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%);
            top: 60px;
            left: -40px;
            animation-delay: -3s;
        }

        @keyframes orbFloat {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        /* ── Hero banner mesh ── */
        .hero-banner {
            background: linear-gradient(135deg, #E8560A 0%, #c44608 40%, #f59e0b 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255, 255, 255, 0.03) 20px, rgba(255, 255, 255, 0.03) 21px),
                repeating-linear-gradient(-45deg, transparent, transparent 20px, rgba(255, 255, 255, 0.03) 20px, rgba(255, 255, 255, 0.03) 21px);
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to top, var(--card-bg), transparent);
        }

        /* ── Avatar ring ── */
        .avatar-ring {
            background: conic-gradient(from 0deg, #E8560A, #f59e0b, #E8560A 360deg);
            padding: 3px;
            border-radius: 20px;
            animation: spinRing 6s linear infinite;
        }

        @keyframes spinRing {
            from {
                filter: hue-rotate(0deg);
            }

            to {
                filter: hue-rotate(360deg);
            }
        }

        .avatar-inner {
            background: var(--card-bg);
            border-radius: 17px;
            padding: 3px;
        }

        .avatar-letter {
            width: 68px;
            height: 68px;
            border-radius: 14px;
            background: linear-gradient(135deg, #1a1613, #3a2825);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            font-weight: 900;
            color: white;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -1px;
        }

        /* ── Skor badge glow ── */
        .skor-badge {
            background: linear-gradient(135deg, #E8560A, #f59e0b);
            border-radius: 14px;
            padding: 8px 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 24px rgba(232, 86, 10, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            position: relative;
            overflow: hidden;
        }

        .skor-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            60%,
            100% {
                left: 100%;
            }
        }

        /* ── Info chips ── */
        .info-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 14px;
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border-soft);
            transition: border-color 0.2s, transform 0.2s;
        }

        .info-chip:hover {
            border-color: rgba(232, 86, 10, 0.3);
            transform: translateY(-1px);
        }

        .info-chip-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(232, 86, 10, 0.1);
            border: 1px solid rgba(232, 86, 10, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ── Progress bars ── */
        .kompetensi-row {
            padding: 16px;
            border-radius: 16px;
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border-soft);
            transition: border-color 0.2s, background 0.2s;
        }

        .kompetensi-row:hover {
            border-color: var(--hover-color, rgba(232, 86, 10, 0.25));
            background: var(--hover-bg, rgba(232, 86, 10, 0.04));
        }

        .progress-track {
            height: 8px;
            border-radius: 99px;
            background: var(--card-bg);
            border: 1px solid var(--card-border-soft);
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 99px;
            width: 0%;
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ── Grade cards ── */
        .grade-card {
            border-radius: 16px;
            padding: 16px 12px;
            text-align: center;
            border: 1px solid;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: default;
        }

        .grade-card:hover {
            transform: translateY(-3px);
        }

        .grade-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--grade-color, #6b7280);
            opacity: 0.6;
        }

        .grade-number {
            font-size: 2rem;
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
            line-height: 1;
            letter-spacing: -2px;
        }

        /* ── Kesan pesan cards ── */
        .kp-card {
            padding: 20px;
            border-radius: 16px;
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border-soft);
            transition: border-color 0.2s, transform 0.2s;
            position: relative;
        }

        .kp-card:hover {
            border-color: rgba(232, 86, 10, 0.2);
            transform: translateY(-2px);
        }

        .kp-card::before {
            content: '"';
            position: absolute;
            top: 10px;
            right: 16px;
            font-size: 4rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            color: rgba(232, 86, 10, 0.08);
            line-height: 1;
            pointer-events: none;
        }

        .anon-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
            font-family: 'Outfit', sans-serif;
        }

        /* ── Stagger reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Empty state ── */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
        }

        .empty-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--card-bg-soft);
            border: 1px solid var(--card-border-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- ══ HERO CARD ══ --}}
        <div class="reveal rounded-3xl overflow-hidden relative"
            style="background:var(--card-bg); border:1px solid var(--card-border); box-shadow: 0 4px 40px rgba(232,86,10,0.08);">

            {{-- Floating orbs --}}
            <div class="profil-orb profil-orb-1"></div>
            <div class="profil-orb profil-orb-2"></div>

            {{-- Banner --}}
            <div class="hero-banner h-32"></div>

            {{-- Profile row --}}
            <div class="px-6 pb-6 relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 -mt-10 mb-5">

                    {{-- Avatar --}}
                    <div class="flex items-end gap-4">
                        <div class="avatar-ring flex-shrink-0">
                            <div class="avatar-inner">
                                <div class="avatar-letter">{{ strtoupper(substr($guru->nama, 0, 1)) }}</div>
                            </div>
                        </div>
                        <div class="pb-1">
                            <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color:var(--accent)">Guru
                                Aktif</p>
                            <h2 class="text-2xl font-black leading-tight"
                                style="color:var(--text-main); font-family:'Outfit',sans-serif; letter-spacing:-0.5px;">
                                {{ $guru->nama }}</h2>
                            <p class="text-sm mt-0.5" style="color:var(--text-muted)">{{ $guru->mata_pelajaran }}</p>
                        </div>
                    </div>

                    {{-- Skor badge --}}
                    @if($skorRata > 0)
                        <div class="skor-badge self-end sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"
                                class="w-4 h-4 flex-shrink-0">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-white text-xs opacity-80 leading-none mb-0.5">Skor Rata-rata</p>
                                <p class="text-white font-black text-lg leading-none" style="font-family:'Outfit',sans-serif;">
                                    {{ number_format($skorRata, 2) }}<span class="text-xs font-normal opacity-70"> /5.0</span>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Info chips --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="info-chip">
                        <div class="info-chip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="#E8560A" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs mb-0.5" style="color:var(--text-muted)">NIP</p>
                            <p class="text-sm font-bold" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                                {{ $guru->nip ?? '—' }}</p>
                        </div>
                    </div>
                    <div class="info-chip">
                        <div class="info-chip-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="#E8560A" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs mb-0.5" style="color:var(--text-muted)">Email</p>
                            <p class="text-sm font-bold" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                                {{ $guru->user->email ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ KOMPETENSI ══ --}}
        @if($skorRata > 0)
            @php
                $kategoriConfig = [
                    'pedagogik' => ['label' => 'Pedagogik', 'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.08)', 'border' => 'rgba(59,130,246,0.2)', 'badgeBg' => 'rgba(59,130,246,0.12)'],
                    'kepribadian' => ['label' => 'Kepribadian', 'color' => '#a855f7', 'bg' => 'rgba(168,85,247,0.08)', 'border' => 'rgba(168,85,247,0.2)', 'badgeBg' => 'rgba(168,85,247,0.12)'],
                    'sosial' => ['label' => 'Sosial', 'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.08)', 'border' => 'rgba(16,185,129,0.2)', 'badgeBg' => 'rgba(16,185,129,0.12)'],
                    'profesional' => ['label' => 'Profesional', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.08)', 'border' => 'rgba(245,158,11,0.2)', 'badgeBg' => 'rgba(245,158,11,0.12)'],
                ];
                $gradeIcon = ['A+' => '🏆', 'A' => '⭐', 'B+' => '✅', 'B' => '👍', 'C' => '📈', 'D' => '💪'];
            @endphp

            <div class="reveal rounded-3xl p-6"
                style="background:var(--card-bg); border:1px solid var(--card-border); box-shadow: 0 4px 30px rgba(0,0,0,0.06);">

                {{-- Section header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background:rgba(232,86,10,0.12); border:1px solid rgba(232,86,10,0.2);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                stroke="#E8560A" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-base" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                                Profil Kompetensi</h3>
                            <p class="text-xs" style="color:var(--text-muted)">{{ $totalPenilai }} penilai &middot; semester
                                aktif</p>
                        </div>
                    </div>
                    <div class="px-3 py-1.5 rounded-xl text-xs font-black"
                        style="background:rgba(232,86,10,0.1); color:var(--accent); border:1px solid rgba(232,86,10,0.18); font-family:'Outfit',sans-serif;">
                        {{ number_format($skorRata, 2) }} / 5.0
                    </div>
                </div>

                {{-- Dua kolom: progress + grade --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    {{-- Progress bars --}}
                    <div class="space-y-3">
                        @foreach($skorKategori as $kategori => $skor)
                            @php
                                $cfg = $kategoriConfig[$kategori] ?? ['label' => ucfirst($kategori), 'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.08)', 'border' => 'rgba(107,114,128,0.2)', 'badgeBg' => 'rgba(107,114,128,0.12)'];
                                $persen = ($skor / 5) * 100;
                                $dot = $persen >= 80 ? '🟢' : ($persen >= 60 ? '🟡' : '🔴');
                            @endphp
                            <div class="kompetensi-row" style="--hover-color:{{ $cfg['border'] }}; --hover-bg:{{ $cfg['bg'] }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                            style="background:{{ $cfg['color'] }}; box-shadow: 0 0 6px {{ $cfg['color'] }}88;">
                                        </div>
                                        <span class="text-sm font-bold"
                                            style="color:var(--text-main); font-family:'Outfit',sans-serif;">{{ $cfg['label'] }}</span>
                                    </div>
                                    <span class="text-sm font-black"
                                        style="color:{{ $cfg['color'] }}; font-family:'Outfit',sans-serif;">{{ number_format($skor, 2) }}<span
                                            class="text-xs font-normal" style="color:var(--text-muted);"> /5</span></span>
                                </div>
                                <div class="progress-track">
                                    <div class="progress-fill" data-target="{{ $persen }}"
                                        style="background: linear-gradient(90deg, {{ $cfg['color'] }}cc, {{ $cfg['color'] }}); box-shadow: 0 0 8px {{ $cfg['color'] }}55;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Grade badges --}}
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($skorKategori as $kategori => $skor)
                            @php
                                $cfg = $kategoriConfig[$kategori] ?? ['label' => ucfirst($kategori), 'color' => '#6b7280', 'badgeBg' => 'rgba(107,114,128,0.12)', 'border' => 'rgba(107,114,128,0.2)'];
                                if ($skor >= 4.5)
                                    $grade = 'A+';
                                elseif ($skor >= 4.0)
                                    $grade = 'A';
                                elseif ($skor >= 3.5)
                                    $grade = 'B+';
                                elseif ($skor >= 3.0)
                                    $grade = 'B';
                                elseif ($skor >= 2.5)
                                    $grade = 'C';
                                else
                                    $grade = 'D';
                                $icon = $gradeIcon[$grade] ?? '📊';
                            @endphp
                            <div class="grade-card"
                                style="background:{{ $cfg['badgeBg'] }}; border-color:{{ $cfg['border'] }}; --grade-color:{{ $cfg['color'] }};">
                                <p class="text-xl mb-1">{{ $icon }}</p>
                                <p class="grade-number" style="color:{{ $cfg['color'] }}">{{ $grade }}</p>
                                <p class="text-xs font-semibold mt-1.5" style="color:var(--text-muted)">{{ $cfg['label'] }}</p>
                                <p class="text-xs font-black mt-0.5"
                                    style="color:{{ $cfg['color'] }}; font-family:'Outfit',sans-serif;">
                                    {{ number_format($skor, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        @else
            {{-- Empty kompetensi --}}
            <div class="reveal rounded-3xl" style="background:var(--card-bg); border:1px dashed var(--card-border);">
                <div class="empty-state">
                    <div class="empty-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8" style="color:var(--text-muted)">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black mb-2" style="color:var(--text-main); font-family:'Outfit',sans-serif;">Belum
                        Ada Penilaian</h3>
                    <p class="text-sm max-w-xs mx-auto" style="color:var(--text-muted)">Profil kompetensi akan muncul otomatis
                        setelah ada rekan guru yang memberikan penilaian.</p>
                </div>
            </div>
        @endif

        {{-- ══ KESAN & PESAN ══ --}}
        <div class="reveal rounded-3xl overflow-hidden"
            style="background:var(--card-bg); border:1px solid var(--card-border); box-shadow: 0 4px 30px rgba(0,0,0,0.06);">

            {{-- Header --}}
            <div class="px-6 py-5 flex items-center justify-between"
                style="border-bottom:1px solid var(--card-border-soft);">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                        style="background:rgba(96,165,250,0.12); border:1px solid rgba(96,165,250,0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="#60a5fa" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-base" style="color:var(--text-main); font-family:'Outfit',sans-serif;">
                            Kesan &amp; Pesan</h3>
                        <p class="text-xs" style="color:var(--text-muted)">Identitas penilai dirahasiakan sepenuhnya</p>
                    </div>
                </div>
                <div class="px-3 py-1.5 rounded-xl text-xs font-black"
                    style="background:rgba(96,165,250,0.1); color:#60a5fa; border:1px solid rgba(96,165,250,0.2); font-family:'Outfit',sans-serif;">
                    {{ $kesanPesan->count() }} <span class="font-normal opacity-70">ulasan</span>
                </div>
            </div>

            {{-- Content --}}
            @if($kesanPesan->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8" style="color:var(--text-muted)">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium" style="color:var(--text-muted)">Belum ada kesan &amp; pesan.</p>
                    <p class="text-xs mt-1" style="color:var(--text-muted); opacity:0.6">Akan muncul setelah rekan mengisi
                        kuesioner.</p>
                </div>
            @else
                @php $avatarColors = ['#3b82f6', '#a855f7', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899', '#8b5cf6']; @endphp
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($kesanPesan as $idx => $item)
                        @php
                            $colorPick = $avatarColors[$idx % count($avatarColors)];
                            $inisial = chr(65 + ($idx % 26)) . str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                            $tgl = $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '—';
                        @endphp
                        <div class="kp-card">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="anon-avatar"
                                    style="background: linear-gradient(135deg, {{ $colorPick }}, {{ $colorPick }}aa);">
                                    {{ $inisial }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold" style="color:var(--text-main)">Anonim</p>
                                    <p class="text-xs" style="color:var(--text-muted)">{{ $tgl }} &middot;
                                        {{ $item->tahun_ajaran }}/{{ ucfirst($item->semester) }}</p>
                                </div>
                                <div class="w-2 h-2 rounded-full mt-1 flex-shrink-0" style="background:{{ $colorPick }};"></div>
                            </div>
                            <p class="text-sm leading-relaxed" style="color:var(--text-main); line-height:1.65;">
                                "{{ $item->kesan_pesan }}"</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Stagger reveal
            var reveals = document.querySelectorAll('.reveal');
            reveals.forEach(function (el, i) {
                setTimeout(function () { el.classList.add('visible'); }, i * 120);
            });

            // Animate progress bars
            setTimeout(function () {
                document.querySelectorAll('.progress-fill').forEach(function (bar) {
                    bar.style.width = bar.dataset.target + '%';
                });
            }, 400);
        });
    </script>
@endsection
