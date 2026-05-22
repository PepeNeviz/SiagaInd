@extends('layouts.app')

@section('title', 'SiagaInd — Siap Sebelum Terjadi')

@push('styles')
<style>
    .hero-bg {
        background:
        linear-gradient(
            rgba(16,24,32,0.65),
            rgba(16,24,32,0.78)
        ),
        url('/images/Nav_bg.jpg');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    position: relative;
    overflow: hidden;
    }

    .hero-bg::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 70% 50%, rgba(230,126,34,0.12) 0%, transparent 65%),
                    radial-gradient(ellipse at 20% 80%, rgba(192,57,43,0.10) 0%, transparent 55%);
    }

    /* Quick access cards */
    .phase-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .phase-card:hover { transform: translateY(-6px); }
    .phase-card .bar {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 4px;
        transition: height 0.3s ease;
    }
    .phase-card:hover .bar { height: 6px; }

    /* Tutorial grid item */
    .tutorial-item {
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .tutorial-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    }

    /* Section divider */
    .divider {
        width: 48px; height: 4px;
        background: #E67E22;
        border-radius: 99px;
        margin-bottom: 1rem;
    }

    /* Crafting tag */
    .tag {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════
    HERO
════════════════════════════════════════════ --}}
<section class="hero-bg min-h-[88vh] flex items-center" id="hero">
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 py-24 grid md:grid-cols-2 gap-12 items-center">

        {{-- Teks --}}
        <div id="hero-text">
            <span class="inline-block px-3 py-1 bg-siaga/20 text-siaga text-xs font-bold rounded-full uppercase tracking-widest mb-6">
                Platform Kesiapsiagaan Bencana
            </span>
            <h1 class="font-head text-5xl sm:text-6xl font-extrabold text-white leading-[1.1] mb-6">
                Siap<br/>
                <span class="text-siaga">Sebelum</span><br/>
                Terjadi.
            </h1>
            <p class="text-white/60 text-lg leading-relaxed mb-8 max-w-md">
                SiagaInd membekali kamu dengan pengetahuan, keterampilan survival, dan panduan tindakan cepat — untuk semua fase bencana.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('sebelum') }}"
                   class="px-6 py-3 bg-siaga hover:bg-siaga/90 text-white font-semibold rounded-full transition-all duration-200 text-sm">
                    Mulai Persiapan
                </a>
                <a href="{{ route('saat') }}"
                   class="px-6 py-3 bg-danger hover:bg-danger-dk text-white font-semibold rounded-full transition-all duration-200 text-sm">
                    🚨 Mode Darurat
                </a>
            </div>
        </div>

        {{-- Ilustrasi / kompas placeholder --}}
        <div class="flex justify-center" id="hero-img">
            <div class="img-ph w-72 h-72 sm:w-80 sm:h-80">
                <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6-10l6-3m0 13l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 4V9"/>
                </svg>
                <span>Ilustrasi / Kompas</span>
            </div>
        </div>
    </div>

    {{-- Scroll hint --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-white/30 text-xs" id="scroll-hint">
        <span>Scroll</span>
        <div class="w-px h-8 bg-white/20 animate-pulse"></div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    3 PHASE QUICK ACCESS
════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="text-center mb-10 reveal">
        <div class="divider mx-auto"></div>
        <h2 class="font-head text-3xl font-bold text-navy">Tiga Fase Kesiapsiagaan</h2>
        <p class="text-gray-500 mt-2">Pilih fase sesuai kondisimu sekarang</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        {{-- Sebelum --}}
        <a href="{{ route('sebelum') }}" class="phase-card bg-white rounded-2xl p-6 shadow-sm reveal block no-underline">
            <div class="w-12 h-12 rounded-xl bg-siaga/10 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-siaga" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="font-head font-bold text-navy text-xl mb-2">Sebelum</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Siapkan tas siaga, cek lingkungan, dan latih respons sebelum bencana datang.</p>
            <div class="bar bg-siaga"></div>
        </a>

        {{-- Saat --}}
        <a href="{{ route('saat') }}" class="phase-card bg-white rounded-2xl p-6 shadow-sm reveal block no-underline" style="animation-delay:0.1s">
            <div class="w-12 h-12 rounded-xl bg-danger/10 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 class="font-head font-bold text-navy text-xl mb-2">Saat</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Panduan tindakan cepat berbasis decision tree. Tap — dan kamu tahu apa yang harus dilakukan.</p>
            <div class="bar bg-danger"></div>
        </a>

        {{-- Sesudah --}}
        <a href="{{ route('sesudah') }}" class="phase-card bg-white rounded-2xl p-6 shadow-sm reveal block no-underline" style="animation-delay:0.2s">
            <div class="w-12 h-12 rounded-xl bg-safe/10 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-safe" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h3 class="font-head font-bold text-navy text-xl mb-2">Sesudah</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Panduan pemulihan, penanganan luka, dan pengecekan supply pasca bencana.</p>
            <div class="bar bg-safe"></div>
        </a>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    TUTORIAL BENCANA
════════════════════════════════════════════ --}}
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-10 reveal">
            <div class="divider"></div>
            <h2 class="font-head text-3xl font-bold text-navy">Tutorial Bencana</h2>
            <p class="text-gray-500 mt-2">Klik untuk melihat panduan lengkap sebelum, saat, dan sesudah bencana</p>
        </div>

        {{-- Grid bencana --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="tutorial-grid">

            @php
            $bencana = [
                ['nama' => 'Gempa Bumi',     'icon' => '🌍', 'tersedia' => true],
                ['nama' => 'Tsunami',         'icon' => '🌊', 'tersedia' => false],
                ['nama' => 'Banjir',          'icon' => '💧', 'tersedia' => false],
                ['nama' => 'Gunung Meletus',  'icon' => '🌋', 'tersedia' => false],
                ['nama' => 'Tanah Longsor',   'icon' => '⛰️',  'tersedia' => false],
                ['nama' => 'Kebakaran',       'icon' => '🔥', 'tersedia' => false],
                ['nama' => 'Angin Puting',    'icon' => '🌪️', 'tersedia' => false],
                ['nama' => 'Kekeringan',      'icon' => '☀️',  'tersedia' => false],
            ];
            @endphp

            @foreach($bencana as $b)
            <button
                class="tutorial-item bg-cream rounded-2xl p-5 text-center shadow-sm border border-transparent hover:border-siaga/30 relative"
                @if($b['tersedia'])
                    @click="$dispatch('open-tutorial', { bencana: '{{ $b['nama'] }}' })"
                @else
                    disabled
                @endif
                title="{{ $b['tersedia'] ? 'Lihat tutorial ' . $b['nama'] : 'Segera hadir' }}"
            >
                <div class="text-4xl mb-3">{{ $b['icon'] }}</div>
                <p class="font-head font-semibold text-navy text-sm">{{ $b['nama'] }}</p>
                @if(!$b['tersedia'])
                    <span class="tag bg-gray-100 text-gray-400 mt-2">Segera</span>
                @else
                    <span class="tag bg-siaga/10 text-siaga mt-2">Tersedia</span>
                @endif
            </button>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    INFORMASI & CRAFTING — SURVIVE
════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="mb-10 reveal">
        <div class="divider"></div>
        <h2 class="font-head text-3xl font-bold text-navy">Informasi & Crafting <span class="text-siaga">Survive</span></h2>
        <p class="text-gray-500 mt-2">Keterampilan bertahan hidup yang bisa kamu pelajari dan praktikkan</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">

        {{-- Informasi (1 bahan) --}}
        <div class="reveal">
            <h3 class="font-head font-semibold text-navy mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-siaga/10 rounded-full flex items-center justify-center text-xs text-siaga font-bold">1</span>
                Informasi Cepat
                <span class="tag bg-siaga/10 text-siaga">1 bahan</span>
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="info-survive-grid">
                @php
                $infoItems = [
                    ['nama' => 'Membuat Simpul', 'icon' => '🪢', 'bahan' => 'Hanya tali'],
                    ['nama' => 'Buka Kaleng', 'icon' => '🥫', 'bahan' => 'Hanya kaleng'],
                    ['nama' => 'Arah Mata Angin', 'icon' => '🧭', 'bahan' => 'Tanpa alat'],
                    ['nama' => 'Sinyal Darurat', 'icon' => '🔦', 'bahan' => 'Hanya senter'],
                    ['nama' => 'Berlindung', 'icon' => '🌿', 'bahan' => 'Bahan alam'],
                ];
                @endphp
                @foreach($infoItems as $item)
                <button class="tutorial-item bg-white rounded-xl p-4 text-center shadow-sm border border-transparent hover:border-siaga/30"
                        @click="$dispatch('open-info', { nama: '{{ $item['nama'] }}', tipe: 'survive' })">
                    <div class="text-3xl mb-2">{{ $item['icon'] }}</div>
                    <p class="font-semibold text-navy text-xs leading-tight">{{ $item['nama'] }}</p>
                    <p class="text-gray-400 text-xs mt-1">{{ $item['bahan'] }}</p>
                </button>
                @endforeach
            </div>
        </div>

        {{-- Crafting (lebih dari 1 bahan) --}}
        <div class="reveal">
            <h3 class="font-head font-semibold text-navy mb-4 flex items-center gap-2">
                <span class="w-6 h-6 bg-navy/10 rounded-full flex items-center justify-center text-xs text-navy font-bold">+</span>
                Crafting Darurat
                <span class="tag bg-navy/10 text-navy">multi bahan</span>
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="crafting-survive-grid">
                @php
                $craftItems = [
                    ['nama' => 'Filter Air', 'icon' => '💧', 'bahan' => 'Batu · Pasir · Arang'],
                    ['nama' => 'Lentera Darurat', 'icon' => '🕯️', 'bahan' => 'Minyak · Kain · Kaleng'],
                    ['nama' => 'Tandu Darurat', 'icon' => '🪵', 'bahan' => 'Bambu · Kain'],
                    ['nama' => 'Pelampung', 'icon' => '🛟', 'bahan' => 'Botol · Tali'],
                    ['nama' => 'Kompor Darurat', 'icon' => '🔥', 'bahan' => 'Kaleng · Arang'],
                ];
                @endphp
                @foreach($craftItems as $item)
                <button class="tutorial-item bg-white rounded-xl p-4 text-center shadow-sm border border-transparent hover:border-navy/30"
                        @click="$dispatch('open-crafting', { nama: '{{ $item['nama'] }}', tipe: 'survive' })">
                    <div class="text-3xl mb-2">{{ $item['icon'] }}</div>
                    <p class="font-semibold text-navy text-xs leading-tight">{{ $item['nama'] }}</p>
                    <p class="text-gray-400 text-xs mt-1">{{ $item['bahan'] }}</p>
                </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    INFORMASI & CRAFTING — CAREGIVER
════════════════════════════════════════════ --}}
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-10 reveal">
            <div class="divider" style="background:#27AE60"></div>
            <h2 class="font-head text-3xl font-bold text-navy">Informasi & Crafting <span class="text-safe">Caregiver</span></h2>
            <p class="text-gray-500 mt-2">Penanganan medis darurat dan pembuatan alat kesehatan improvisasi</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">

            {{-- Informasi caregiver --}}
            <div class="reveal">
                <h3 class="font-head font-semibold text-navy mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-safe/10 rounded-full flex items-center justify-center text-xs text-safe font-bold">ℹ</span>
                    Panduan Medis Darurat
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @php
                    $careInfo = [
                        ['nama' => 'CPR Dasar', 'icon' => '❤️'],
                        ['nama' => 'Balut Luka', 'icon' => '🩹'],
                        ['nama' => 'Penurunan Kesadaran', 'icon' => '🧠'],
                        ['nama' => 'Patah Tulang', 'icon' => '🦴'],
                        ['nama' => 'Luka Bakar', 'icon' => '🔥'],
                    ];
                    @endphp
                    @foreach($careInfo as $item)
                    <button class="tutorial-item bg-cream rounded-xl p-4 text-center shadow-sm border border-transparent hover:border-safe/30"
                            @click="$dispatch('open-info', { nama: '{{ $item['nama'] }}', tipe: 'caregiver' })">
                        <div class="text-3xl mb-2">{{ $item['icon'] }}</div>
                        <p class="font-semibold text-navy text-xs leading-tight">{{ $item['nama'] }}</p>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Crafting caregiver --}}
            <div class="reveal">
                <h3 class="font-head font-semibold text-navy mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-safe/10 rounded-full flex items-center justify-center text-xs text-safe font-bold">+</span>
                    Crafting Alat Medis
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @php
                    $careCraft = [
                        ['nama' => 'Kain Segitiga', 'icon' => '📐', 'bahan' => 'Kain · Peniti'],
                        ['nama' => 'Kasa Steril', 'icon' => '🩻', 'bahan' => 'Kain · Alkohol'],
                        ['nama' => 'Masker Darurat', 'icon' => '😷', 'bahan' => 'Kain · Tali'],
                        ['nama' => 'Bidai Tulang', 'icon' => '🪵', 'bahan' => 'Kayu · Kain'],
                    ];
                    @endphp
                    @foreach($careCraft as $item)
                    <button class="tutorial-item bg-cream rounded-xl p-4 text-center shadow-sm border border-transparent hover:border-safe/30"
                            @click="$dispatch('open-crafting', { nama: '{{ $item['nama'] }}', tipe: 'caregiver' })">
                        <div class="text-3xl mb-2">{{ $item['icon'] }}</div>
                        <p class="font-semibold text-navy text-xs leading-tight">{{ $item['nama'] }}</p>
                        <p class="text-gray-400 text-xs mt-1">{{ $item['bahan'] }}</p>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
    NOMOR DARURAT
════════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16" id="darurat">
    <div class="mb-8 reveal">
        <div class="divider" style="background:#C0392B"></div>
        <h2 class="font-head text-3xl font-bold text-navy">Nomor Darurat</h2>
        <p class="text-gray-500 mt-2">Hubungi segera jika membutuhkan bantuan</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $darurat = [
            ['nama' => 'Polisi',        'no' => '110',   'warna' => 'bg-navy',   'icon' => '👮'],
            ['nama' => 'Ambulans',      'no' => '118',   'warna' => 'bg-danger', 'icon' => '🚑'],
            ['nama' => 'Pemadam',       'no' => '113',   'warna' => 'bg-siaga',  'icon' => '🚒'],
            ['nama' => 'BNPB',          'no' => '117',   'warna' => 'bg-safe',   'icon' => '🆘'],
            ['nama' => 'SAR',           'no' => '115',   'warna' => 'bg-navy',   'icon' => '⛑️'],
            ['nama' => 'PLN',           'no' => '123',   'warna' => 'bg-warn',   'icon' => '⚡'],
            ['nama' => 'Pos Indonesia', 'no' => '161',   'warna' => 'bg-gray-600','icon' => '📮'],
            ['nama' => 'PDAM',          'no' => '119',   'warna' => 'bg-sky-600','icon' => '💧'],
        ];
        @endphp

        @foreach($darurat as $d)
        <a href="tel:{{ $d['no'] }}"
            class="reveal flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1 group">
            <div class="w-12 h-12 {{ $d['warna'] }} rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                {{ $d['icon'] }}
            </div>
            <div>
                <p class="font-head font-bold text-navy text-sm">{{ $d['nama'] }}</p>
                <p class="text-2xl font-extrabold font-head text-danger group-hover:text-siaga transition-colors">{{ $d['no'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ═══════════════════════════════════════════
    MODAL TUTORIAL BENCANA (FIXED HEIGHT & NEW LAYOUT)
════════════════════════════════════════════ --}}

<div
    x-data="tutorialModal()"
    x-show="open"
    x-transition.opacity
    x-cloak

    @open-tutorial.window="openModal($event.detail.bencana)"
    @keydown.escape.window="closeModal()"
    @click.self="closeModal()"

    x-effect="
    if(open){
        document.body.classList.add('overflow-hidden');
        document.querySelector('nav')?.classList.add('pointer-events-none', '!z-0');
    } else {
        document.body.classList.remove('overflow-hidden');
        document.querySelector('nav')?.classList.remove('pointer-events-none', '!z-0');
    }
    "

    class="modal-superfront p-4 bg-black/70 backdrop-blur-md"
    :class="open ? '' : '!hidden'"
>

    {{-- WRAPPER UTAMA --}}

    <div
    @click.stop
    class="relative w-full max-w-3xl bg-white rounded-[28px] shadow-[0_25px_80px_rgba(0,0,0,0.35)] flex flex-col h-[620px] overflow-hidden"
    >

        {{-- CLOSE BUTTON --}}
        <button
            @click="closeModal()"
            class="absolute top-4 right-4 z-50 w-10 h-10 rounded-full bg-white shadow-md border border-gray-200 flex items-center justify-center hover:scale-105 transition-all duration-200"
        >
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- HEADER --}}
        <div class="px-6 pt-5 pb-4 border-b border-gray-100 pr-14 shrink-0">
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <div class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-semibold capitalize">
                    <span x-text="bencana"></span>
                </div>
            </div>

                <template x-if="fase !== 'saat'">
                    <span>
                        Tutorial <span class="capitalize" x-text="fase"></span> Bencana
                    </span>
                </template>
            </h2>
        </div>

        {{-- TAB NAVIGASI --}}
        <div class="grid grid-cols-3 border-b border-gray-100 shrink-0">
            <button
                @click="fase='sebelum'; currentStep=0"
                :class="fase==='sebelum' ? 'border-b-2 border-siaga text-siaga bg-siaga/5' : 'text-gray-400 hover:bg-gray-50'"
                class="h-12 text-sm font-semibold transition-all duration-200"
            >
                Sebelum
            </button>
            <button
                @click="fase='saat'; currentStep=0"
                :class="fase==='saat' ? 'border-b-2 border-danger text-danger bg-danger/5' : 'text-gray-400 hover:bg-gray-50'"
                class="h-12 text-sm font-semibold transition-all duration-200"
            >
                Saat
            </button>
            <button
                @click="fase='sesudah'; currentStep=0"
                :class="fase==='sesudah' ? 'border-b-2 border-safe text-safe bg-safe/5' : 'text-gray-400 hover:bg-gray-50'"
                class="h-12 text-sm font-semibold transition-all duration-200"
            >
                Sesudah
            </button>
        </div>

        {{-- AREA CONTENT --}}
        <div class="flex-1 overflow-y-auto p-5">

            {{-- ═════════════════════════════
                KHUSUS SAAT
            ═════════════════════════════ --}}
            <template x-if="fase === 'saat'">
                <div class="h-full flex flex-col justify-between">
                    
                    {{-- HEADER PERTANYAAN --}}
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <button @click="prevStep()" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        
                        <div class="text-center">
                            <h3 class="font-head text-base sm:text-lg font-bold text-navy" x-text="currentQuestion() || 'Dimana Posisi Anda?'"></h3>
                        </div>

                        <button @click="nextStep()" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center shrink-0 transition">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>

                    {{-- DUA KARTU PILIHAN KONDISI (Grid 2 Kolom) --}}
                    <div class="grid grid-cols-2 gap-4 my-auto">
                        
                        <div class="group border border-gray-200 hover:border-danger/40 rounded-2xl p-3 bg-gray-50/50 flex flex-col items-center text-center transition-all duration-300 shadow-sm">
                            <span class="px-3 py-1 bg-gray-200 text-gray-700 font-bold text-xs rounded-full mb-3 group-hover:bg-danger group-hover:text-white transition-colors">
                                Luar Ruangan
                            </span>
                            <div class="w-full h-[260px] rounded-2xl bg-gray-200 mb-3 overflow-hidden">
                                <img src="/images/tutorial-gempa.jpg" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                            </div>
                            <p class="font-bold text-xs sm:text-sm text-navy leading-tight">Jauhi Benda Rawan & Tiang</p>
                        </div>

                        <div class="group border border-gray-200 hover:border-danger/40 rounded-2xl p-3 bg-gray-50/50 flex flex-col items-center text-center transition-all duration-300 shadow-sm">
                            <span class="px-3 py-1 bg-gray-200 text-gray-700 font-bold text-xs rounded-full mb-3 group-hover:bg-danger group-hover:text-white transition-colors">
                                Dalam Ruangan
                            </span>
                            <div class="w-full h-[260px] rounded-2xl bg-gray-200 mb-3 overflow-hidden">
                                <img src="/images/tutorial-gempa.jpg" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                            </div>
                            <p class="font-bold text-xs sm:text-sm text-navy leading-tight">Lindungi Kepala di Bawah Meja</p>
                        </div>

                    </div>

                    {{-- BOTTOM AREA: FAST ACCESS BUTTONS & DONE --}}
                    

                        {{-- Fast Access Step Number di Paling Bawah --}}
                        <div class="flex items-center justify-center gap-1.5 overflow-x-auto py-1">
                            <template x-for="(item,index) in getSteps()" :key="index">
                                <button
                                    @click="currentStep=index"
                                    :class="currentStep===index ? 'bg-danger text-white shadow-md' : 'bg-gray-100 text-gray-400 hover:bg-gray-200'"
                                    class="w-7 h-7 rounded-lg text-[11px] font-extrabold transition-all flex items-center justify-center shrink-0"
                                >
                                    <template x-if="index === 0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </template>
                                    <template x-if="index !== 0">
                                        <span x-text="index+1"></span>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </div>

                </div>
            </template>

            {{-- ═════════════════════════════
                SEBELUM & SESUDAH 
            ═════════════════════════════ --}}
            <template x-if="fase !== 'saat'">
                <div class="space-y-5">
                    <template x-for="(step, i) in getSteps()" :key="i">
                        <div class="flex gap-3.5 items-start">
                            {{-- NUMBER BADGE --}}
                            <div
                                class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold text-white shadow-sm"
                                :class="fase === 'sebelum' ? 'bg-siaga' : 'bg-safe'"
                                x-text="i + 1"
                            ></div>

                            {{-- CONTENT STEP --}}
                            <div class="flex-1">
                              <div class="rounded-xl overflow-hidden h-44 bg-gray-100 mb-3 border border-gray-100 shadow-sm">
                                    <img src="/images/tutorial-gempa.jpg" alt="Fase Image" class="w-full h-full object-cover">
                                </div>
                                <p class="text-gray-700 leading-relaxed text-xs sm:text-sm" x-text="step"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // GSAP Hero entrance
    gsap.from('#hero-text > *', {
        opacity: 0,
        y: 40,
        stagger: 0.15,
        duration: 0.9,
        ease: 'power3.out',
        delay: 0.2,
    });
    gsap.from('#hero-img', {
        opacity: 0,
        scale: 0.9,
        duration: 1,
        ease: 'power3.out',
        delay: 0.4,
    });
    gsap.from('#scroll-hint', {
        opacity: 0,
        y: 10,
        duration: 1,
        delay: 1.2,
        ease: 'power2.out',
    });

    // Alpine component tutorial modal
    function tutorialModal() {
    return {
        open: false,
        bencana: '',
        fase: 'saat',
        currentStep: 0,

        openModal(nama) {
            this.bencana = nama;
            this.fase = 'saat';
            this.currentStep = 0;
            this.open = true;

            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.open = false;

            document.body.classList.remove('overflow-hidden');
        },

        steps: {
            'Gempa Bumi': {

                sebelum: [
                    'Identifikasi benda yang rawan jatuh dan amankan.',
                    'Siapkan tas siaga dan dokumen penting.',
                    'Latih simulasi evakuasi keluarga.'
                ],

                saat: [
                    {
                        question: 'Apa yang harus dilakukan saat guncangan pertama terasa?',
                        description: 'Segera jatuhkan badan ke lantai agar tidak kehilangan keseimbangan akibat getaran.'
                    },

                    {
                        question: 'Dimana tempat paling aman saat gempa berlangsung?',
                        description: 'Berlindung di bawah meja kokoh atau lindungi kepala menggunakan tangan dan jauhi kaca.'
                    },

                    {
                        question: 'Apa yang harus dilakukan setelah guncangan berhenti?',
                        description: 'Keluar menuju area terbuka dengan tenang dan hindari bangunan, tiang, atau kabel listrik.'
                    }
                ],

                sesudah: [
                    'Periksa kondisi diri dan keluarga.',
                    'Waspada gempa susulan.',
                    'Ikuti informasi resmi dari BMKG dan BNPB.'
                ]
            }
        },

        getSteps() {
            return this.steps[this.bencana]?.[this.fase] ?? [];
        },

        currentQuestion() {
            return this.getSteps()[this.currentStep]?.question ?? '';
        },

        currentDescription() {
            return this.getSteps()[this.currentStep]?.description ?? '';
        },

        nextStep() {
            if (this.currentStep < this.getSteps().length - 1) {
                this.currentStep++;
            }
        },

        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
            }
        }
    }
}
</script>
@endpush
