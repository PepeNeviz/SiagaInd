@extends('layouts.app')

@section('title', 'SiagaInd — Siap Sebelum Terjadi')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, #1a252f 0%, #2C3E50 60%, #1a252f 100%);
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
    MODAL TUTORIAL BENCANA
════════════════════════════════════════════ --}}
<div x-data="tutorialModal()"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @open-tutorial.window="openModal($event.detail.bencana)"
    @keydown.escape.window="open = false"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
    style="display:none">

    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl max-h-[85vh] overflow-hidden flex flex-col"
        @click.stop
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div>
                <p class="text-xs font-semibold text-siaga uppercase tracking-widest mb-1">Tutorial Bencana</p>
                <h3 class="font-head font-bold text-navy text-xl" x-text="bencana"></h3>
            </div>
            <button @click="open = false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Tab fase --}}
        <div class="flex border-b border-gray-100">
            <button @click="fase = 'sebelum'"
                    :class="fase === 'sebelum' ? 'border-b-2 border-siaga text-siaga' : 'text-gray-400'"
                    class="flex-1 py-3 text-sm font-semibold transition-colors">Sebelum</button>
            <button @click="fase = 'saat'"
                    :class="fase === 'saat' ? 'border-b-2 border-danger text-danger' : 'text-gray-400'"
                    class="flex-1 py-3 text-sm font-semibold transition-colors">Saat</button>
            <button @click="fase = 'sesudah'"
                    :class="fase === 'sesudah' ? 'border-b-2 border-safe text-safe' : 'text-gray-400'"
                    class="flex-1 py-3 text-sm font-semibold transition-colors">Sesudah</button>
        </div>

        {{-- Konten step by step --}}
        <div class="overflow-y-auto flex-1 p-6">
            <div class="space-y-4">
                <template x-for="(step, i) in getSteps()" :key="i">
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-sm font-bold text-white"
                             :class="fase === 'sebelum' ? 'bg-siaga' : fase === 'saat' ? 'bg-danger' : 'bg-safe'"
                             x-text="i + 1"></div>
                        <div class="flex-1">
                            {{-- Placeholder gambar --}}
                            <div class="img-ph w-full h-32 mb-3 text-xs">
                                <svg class="w-8 h-8 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Animasi / Gambar Step <span x-text="i + 1"></span></span>
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed" x-text="step"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Footer --}}
        <div class="p-4 border-t border-gray-100 flex gap-2 justify-end">
            <a :href="`{{ route('saat') }}`" class="px-4 py-2 bg-danger text-white text-sm font-semibold rounded-full">
                🚨 Mode Darurat
            </a>
            <button @click="open = false" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-full hover:bg-gray-200">
                Tutup
            </button>
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
            fase: 'sebelum',

            openModal(nama) {
                this.bencana = nama;
                this.fase = 'sebelum';
                this.open = true;
            },

            // Data steps — nanti bisa diambil dari API/blade
            steps: {
                'Gempa Bumi': {
                    sebelum: [
                        'Identifikasi benda-benda yang rawan jatuh di sekitar rumah (lemari, foto, lampu gantung) dan amankan.',
                        'Tentukan titik kumpul keluarga di luar ruangan yang jauh dari gedung tinggi.',
                        'Siapkan tas siaga dengan dokumen penting, air, dan P3K.',
                        'Pelajari cara mematikan gas, listrik, dan air secara manual.',
                        'Latih anggota keluarga dengan simulasi gempa secara rutin.',
                    ],
                    saat: [
                        'DROP — Jatuhkan diri ke lantai sebelum gempa menjatuhkanmu.',
                        'COVER — Berlindunglah di bawah meja kokoh atau lindungi kepala dengan tangan.',
                        'HOLD ON — Pegang erat tempat berlindungmu hingga guncangan berhenti.',
                        'Jauhi jendela, kaca, dan benda yang bisa jatuh.',
                        'Jika di luar, jauhi gedung, pohon, dan tiang listrik. Berjongkok di tanah terbuka.',
                    ],
                    sesudah: [
                        'Periksa diri dan orang sekitar dari cedera sebelum bergerak.',
                        'Waspada gempa susulan — segera ke area terbuka yang aman.',
                        'Periksa kebocoran gas (cium bau), jangan nyalakan korek atau listrik.',
                        'Dokumentasikan kerusakan untuk keperluan asuransi dan laporan.',
                        'Ikuti informasi resmi dari BMKG dan BNPB untuk update kondisi.',
                    ],
                },
            },

            getSteps() {
                return this.steps[this.bencana]?.[this.fase] ?? [
                    'Konten untuk bencana ini sedang dalam penyusunan.',
                    'Pantau terus pembaruan SiagaInd untuk informasi terbaru.',
                ];
            },
        };
    }
</script>
@endpush
