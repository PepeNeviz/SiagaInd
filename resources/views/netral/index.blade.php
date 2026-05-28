@extends('layouts.app')
@section('title', 'SiagaInd — Siap Sebelum Terjadi')

@push('styles')
<style>
    /* ══════ HERO ══════ */
    .hero-bg {
        background:
            linear-gradient(rgba(16,24,32,0.6), rgba(16,24,32,0.75)),
            url('/images/Nav_bg.jpg') center/cover no-repeat;
        position: relative; overflow: hidden;
    }
    .hero-bg::after {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse at 70% 50%, rgba(90,130,126,0.18) 0%, transparent 65%),
            radial-gradient(ellipse at 20% 80%, rgba(185,212,170,0.10) 0%, transparent 55%);
        pointer-events: none;
    }

    /* ══════ PHASE CARDS ══════ */
    .phase-card {
        position: relative; overflow: hidden; cursor: pointer;
        transition: transform var(--t-med), box-shadow var(--t-med);
        display: block; text-decoration: none;
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--r-lg); padding: 24px;
    }
    .phase-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); }
    .phase-card .bar { position: absolute; bottom: 0; left: 0; right: 0; height: 4px; transition: height var(--t-fast); }
    .phase-card:hover .bar { height: 6px; }

    /* ══════ TUTORIAL ══════ */
    .tutorial-item {
        cursor: pointer;
        transition: transform var(--t-fast), box-shadow var(--t-fast);
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--r-lg); padding: 20px; text-align: center;
    }
    .tutorial-item:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
    .tutorial-item:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    /* ══════ INFO / CRAFTING ══════ */
    .info-main-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--r-xl); padding: 24px;
        box-shadow: var(--shadow-sm); cursor: pointer;
        transition: transform var(--t-med), box-shadow var(--t-med);
    }
    .info-main-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
    .info-main-card.no-hover { cursor: default; }
    .info-main-card.no-hover:hover { transform: none; box-shadow: var(--shadow-sm); }

    .preview-box { background: var(--color-surface-2); border-radius: var(--r-lg); padding: 18px; }
    .preview-image {
        width: 100%; height: 220px; object-fit: cover; border-radius: var(--r-md);
        background: var(--c-sage-lt); display: flex; align-items: center; justify-content: center;
    }
    .item-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; }
    .item-small {
        position: relative;
        background: var(--color-surface-2);
        border: 1px solid var(--color-border);
        border-radius: var(--r-lg); padding: 14px;
        transition: all var(--t-fast); cursor: pointer;
    }
    .item-small:hover { transform: translateY(-3px); border-color: var(--color-border-md); }
    .item-small-image {
        width: 100%; height: 110px; object-fit: cover; border-radius: var(--r-md);
        background: var(--c-sage-lt); display: flex; align-items: center; justify-content: center;
    }

    .accent-bar { width: 44px; height: 4px; border-radius: var(--r-pill); background: var(--c-teal); margin-bottom: 14px; }

    .tag { display: inline-block; padding: 3px 10px; border-radius: var(--r-pill); font-size: 10px; font-weight: 700; letter-spacing: 0.06em; margin-top: 6px; }
    .tag-available { background: var(--c-sage-lt); color: var(--c-teal-dk); }
    .tag-soon { background: var(--color-surface-2); color: var(--color-text-muted); }

    .darurat-card {
        display: flex; align-items: center; gap: 12px;
        background: var(--color-surface); border: 1px solid var(--color-border);
        border-radius: var(--r-lg); padding: 16px; text-decoration: none;
        transition: all var(--t-fast); box-shadow: var(--shadow-sm);
    }
    .darurat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

    /* Lock scroll saat modal buka */
    body.modal-open {
        overflow: hidden !important;
        height: 100% !important;
    }

    /* x-cloak: sembunyikan elemen sebelum Alpine selesai init */
    [x-cloak] { display: none !important; }

</style>
@endpush

@section('content')

{{-- ══════ HERO ══════ --}}
<section class="hero-bg min-h-[88vh] flex items-center" id="hero">
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-28 md:pt-32 pb-24 grid md:grid-cols-2 gap-12 items-center">
        <div id="hero-text">
            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full uppercase tracking-widest mb-6"
                  style="background: rgba(90,130,126,0.25); color: var(--c-cream);">
                Platform Kesiapsiagaan Bencana
            </span>
            <h1 class="font-head text-5xl sm:text-6xl font-extrabold text-white leading-[1.1] mb-6">
                Siap<br/>
                <span style="color: var(--c-cream);">Sebelum</span><br/>
                Terjadi.
            </h1>
            <p class="text-lg leading-relaxed mb-8 max-w-md" style="color: rgba(255,255,255,0.6);">
                SiagaInd membekali kamu dengan pengetahuan, keterampilan survival, dan panduan tindakan cepat — untuk semua fase bencana.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('sebelum') }}" class="btn btn-primary">Mulai Persiapan</a>
                <a href="{{ route('netral') }}#darurat" class="btn btn-danger">🚨 Mode Darurat</a>
            </div>
        </div>
        <div class="flex justify-center" id="hero-img">
            <div class="w-72 h-72 sm:w-80 sm:h-80 flex flex-col items-center justify-center gap-2"
                 style="background: rgba(185,212,170,0.1); border: 2px dashed rgba(185,212,170,0.3); border-radius: var(--r-xl); color: rgba(255,255,255,0.3); font-size:13px;">
                <svg class="w-16 h-16 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6-10l6-3m0 13l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 4V9"/>
                </svg>
                <span>Ilustrasi / Kompas</span>
            </div>
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-xs" id="scroll-hint"
         style="color: rgba(255,255,255,0.3);">
        <span>Scroll</span>
        <div class="w-px h-8 animate-pulse" style="background: rgba(255,255,255,0.2);"></div>
    </div>
</section>

{{-- ══════ 3 PHASE ══════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="text-center mb-10 reveal">
        <div class="accent-bar mx-auto"></div>
        <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">Tiga Fase Kesiapsiagaan</h2>
        <p class="mt-2" style="color: var(--color-text-muted);">Pilih fase sesuai kondisimu sekarang</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('sebelum') }}" class="phase-card reveal">
            <h3 class="font-head font-bold text-xl mb-2" style="color: var(--color-text-primary);">Sebelum</h3>
            <p class="text-sm leading-relaxed" style="color: var(--color-text-secondary);">Siapkan tas siaga, cek lingkungan, dan latih respons sebelum bencana datang.</p>
            <div class="bar" style="background: var(--c-teal);"></div>
        </a>
        <a href="{{ route('saat') }}" class="phase-card reveal" style="animation-delay:0.1s">
            <h3 class="font-head font-bold text-xl mb-2" style="color: var(--color-text-primary);">Saat</h3>
            <p class="text-sm leading-relaxed" style="color: var(--color-text-secondary);">Panduan tindakan cepat berbasis decision tree. Tap — dan kamu tahu apa yang harus dilakukan.</p>
            <div class="bar" style="background: var(--color-danger);"></div>
        </a>
        <a href="{{ route('sesudah') }}" class="phase-card reveal" style="animation-delay:0.2s">
            <h3 class="font-head font-bold text-xl mb-2" style="color: var(--color-text-primary);">Sesudah</h3>
            <p class="text-sm leading-relaxed" style="color: var(--color-text-secondary);">Panduan pemulihan, penanganan luka, dan pengecekan supply pasca bencana.</p>
            <div class="bar" style="background: #27AE60;"></div>
        </a>
    </div>
</section>

{{-- ══════ TUTORIAL BENCANA ══════ --}}
<section style="background: var(--color-surface);" class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-10 reveal">
            <div class="accent-bar"></div>
            <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">Tutorial Bencana</h2>
            <p class="mt-2" style="color: var(--color-text-muted);">Klik untuk melihat panduan lengkap sebelum, saat, dan sesudah bencana</p>
        </div>
        {{-- Ganti grid jadi flex-wrap dan justify-center --}}
        <div class="flex flex-wrap justify-center gap-4">
            @php
            $bencana = [
                ['nama'=>'Gempa Bumi','icon'=>'<i class="fa-solid fa-earth-asia text-blue-600"></i>','ada'=>true],
                ['nama'=>'Tsunami','icon'=>'<i class="fa-solid fa-water text-teal-600"></i>','ada'=>true],
                ['nama'=>'Banjir','icon'=>'<i class="fa-solid fa-droplet text-blue-500"></i>','ada'=>true],
                ['nama'=>'Gunung Meletus','icon'=>'🌋','ada'=>false],
                ['nama'=>'Tanah Longsor','icon'=>'<i class="fa-solid fa-mountain text-amber-700"></i>','ada'=>false],
                ['nama'=>'Kebakaran','icon'=>'<i class="fa-solid fa-fire text-red-500"></i>','ada'=>true],
                ['nama'=>'Angin Puting','icon'=>'<i class="fa-solid fa-tornado text-gray-500"></i>','ada'=>false],
            ];
            @endphp
            @foreach($bencana as $b)
            <button
                {{-- Tambahin class w-[calc...] buat ngatur lebar persis kayak grid-cols --}}
                class="tutorial-item reveal w-[calc(50%-8px)] sm:w-[calc(33.33%-11px)] md:w-[calc(25%-12px)] flex flex-col items-center"
                @if($b['ada']) @click="$dispatch('open-tutorial', { bencana: '{{ $b['nama'] }}' })" @else disabled @endif
            >
                <div class="text-4xl mb-3">{!! $b['icon'] !!}</div>
                <p class="font-head font-semibold text-sm text-center" style="color: var(--color-text-primary);">{{ $b['nama'] }}</p>
                <span class="tag {{ $b['ada'] ? 'tag-available' : 'tag-soon' }}">{{ $b['ada'] ? 'Tersedia' : 'Segera' }}</span>
            </button>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════ SECTION 1: INFORMASI SURVIVAL (1 BARANG) ══════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="mb-10 reveal">
        <div class="accent-bar" style="background: var(--c-teal, #008080);"></div>
        <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">Informasi</h2>
        <p class="mt-2" style="color: var(--color-text-muted);">Panduan satu langkah untuk bertahan hidup (Hanya butuh 1 barang)</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
        @foreach([
            ['<i class="fa-solid fa-mitten text-red-400"></i>', 'Kain Penyangga Tangan', 'Kain untuk menopang tangan saat cedera.'],
            ['<i class="fa-solid fa-bandage text-orange-300"></i>', 'Membalut Luka', 'Cara membalut luka dengan kain.'],
            ['<i class="fa-solid fa-clock text-gray-600"></i>', 'Jam Matahari', 'Estimasi penunjuk waktu darurat dengan memanfaatkan bayangan dari sinar matahari.'],
            ['<i class="fa-solid fa-glass-water-droplet text-blue-400"></i>', 'Menentukan Keamanan Air', 'Cara menentukan apakah air aman digunakan.']
        ] as $info)
        <div @click="$dispatch('open-info', { type: 'Survive', item: '{{ $info[1] }}' })" 
             class="info-main-card reveal cursor-pointer p-5 rounded-2xl border" 
             style="background: var(--color-surface); border-color: var(--color-border);">
            <div class="preview-box h-48 rounded-xl flex items-center justify-center text-6xl mb-4 bg-opacity-5" style="background: var(--color-text-muted);">
                {!! $info[0] !!}
            </div>
            <h3 class="text-xl font-bold mt-2" style="color: var(--color-text-primary);">{{ $info[1] }}</h3>
            <p class="text-sm mt-1 leading-relaxed" style="color: var(--color-text-muted);">{{ $info[2] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════ SECTION 2: CRAFTING SURVIVAL (LIST ITEM) ══════ --}}
<section style="background: var(--color-surface);" class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-10 reveal">
            <div class="accent-bar" style="background: var(--c-teal, #008080);"></div>
            <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">Crafting Survival</h2>
            <p class="mt-2" style="color: var(--color-text-muted);">Informasi pembuatan alat (Bahan lebih dari 1)</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach([
                ['<i class="fa-solid fa-filter text-blue-400"></i>', 'Filter Air', 'air-bersih'],
                ['<i class="fa-solid fa-utensils text-gray-500"></i>', 'Pisau', 'pisau'],
                ['<i class="fa-solid fa-fire-burner text-orange-500"></i>', 'Korek Darurat', 'korek-api'],
                ['<i class="fa-solid fa-lightbulb text-yellow-500"></i>', 'Lampu Minyak', 'Lampu']
            ] as $craft)
            <button 
                data-item-title="{{ $craft[1] }}" 
                @click='$dispatch("open-crafting", { type: "Survival", item: "{{ $craft[1] }}", icon: `{!! $craft[0] !!}` })'
                class="info-main-card reveal p-5 rounded-2xl border cursor-pointer transition-all hover:shadow-md hover:-translate-y-1"
                style="background: var(--color-surface); border-color: var(--color-border);">
                <div class="preview-box h-48 rounded-xl flex items-center justify-center text-6xl mb-4" style="background: rgba(var(--color-text-muted-rgb, 128,128,128), 0.1);">
                    {!! $craft[0] !!}
                </div>
                <h3 class="text-sm font-bold" style="color: var(--color-text-primary);">{{ $craft[1] }}</h3>
                <p class="text-xs mt-1" style="color: var(--color-text-muted);">Tap untuk detail crafting</p>
            </button>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════ SECTION 3: CRAFTING CAREGIVER (LIST ITEM) ══════ --}}
<section class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-10 reveal">
            <div class="accent-bar" style="background: #27AE60;"></div>
            <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">
                Crafting <span style="color: #27AE60;">Caregiver</span>
            </h2>
            <p class="mt-2" style="color: var(--color-text-muted);">Panduan medis darurat & pembuatan alat kesehatan improvisasi</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach([
                ['<i class="fa-solid fa-band-aid text-orange-300"></i>', 'Bidai Darurat', 'bidai'],
                ['<i class="fa-solid fa-flask text-purple-500"></i>', 'Cairan Pembersih', 'cairan-pembersih'],
                ['<i class="fa-solid fa-stethoscope text-gray-700"></i>', 'Perban Darurat', 'perban-darurat'],
                ['<i class="fa-solid fa-bed text-blue-400"></i>', 'Tandu Darurat', 'tandu']
            ] as $care)
            <button 
                @click='$dispatch("open-crafting", { type: "Caregiver", item: "{{ $care[1] }}", icon: `{!! $care[0] !!}` })'
                class="info-main-card reveal p-5 rounded-2xl border cursor-pointer transition-all hover:shadow-md hover:-translate-y-1"
                style="background: var(--color-surface); border-color: var(--color-border);">
                <div class="preview-box h-48 rounded-xl flex items-center justify-center text-6xl mb-4" style="background: rgba(var(--color-text-muted-rgb, 128,128,128), 0.1);">
                    {!! $care[0] !!}
                </div>
                <h3 class="text-sm font-bold" style="color: var(--color-text-primary);">{{ $care[1] }}</h3>
                <p class="text-xs mt-1" style="color: var(--color-text-muted);">Tap untuk detail crafting</p>
            </button>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════ NOMOR DARURAT ══════ --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16" id="darurat">
    <div class="mb-8 reveal">
        <div class="accent-bar" style="background: var(--color-danger);"></div>
        <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">Nomor Darurat</h2>
        <p class="mt-2" style="color: var(--color-text-muted);">Hubungi segera jika membutuhkan bantuan</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        // Semua sisa emoji udah gw sapu bersih jadi FontAwesome biar seragam 100%
        $darurat = [
            ['Polisi','110','<i class="fa-solid fa-shield-halved text-blue-700"></i>','#2C3E50'],
            ['Ambulans','118','<i class="fa-solid fa-truck-medical text-red-500"></i>','#C0392B'],
            ['Pemadam','113','<i class="fa-solid fa-fire-extinguisher text-orange-500"></i>','#E67E22'],
            ['BNPB','117','<i class="fa-solid fa-life-ring text-green-500"></i>','#27AE60'],
            ['SAR','115','<i class="fa-solid fa-helmet-safety text-slate-700"></i>','#2C3E50'],
            ['PLN','123','<i class="fa-solid fa-bolt text-yellow-400"></i>','#F39C12'],
            ['Pos Indonesia','161','<i class="fa-solid fa-envelope text-gray-500"></i>','#7F8C8D'],
            ['PDAM','119','<i class="fa-solid fa-droplet text-blue-500"></i>','#2980B9'],
        ];
        @endphp
        @foreach($darurat as $d)
        <a href="tel:{{ $d[1] }}" class="darurat-card reveal">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                 style="background: {{ $d[3] }}1a;">
                 
                {{-- INI KUNCINYA BANG: Pakai tanda seru biar HTML-nya dirender --}}
                {!! $d[2] !!}
                
            </div>
            <div>
                <p class="font-head font-bold text-sm" style="color: var(--color-text-primary);">{{ $d[0] }}</p>
                <p class="text-2xl font-extrabold font-head" style="color: var(--color-danger);">{{ $d[1] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     MODAL PORTAL
══════════════════════════════════════════════════ --}}


{{-- ══════ MODALS ══════ --}}
{{-- Modal: Tutorial Bencana --}}
<template x-teleport="body">
<div
    x-data="tutorialModal()"
    x-init="
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('openTutorial') === 'filter-air') {
            // Karena data lengkapnya ada di Alpine netralPage (array craftingData),
            // kita harus ambil dari komponen atasnya. Tapi biar gampang,
            // kita dispatch balik aja event open-crafting pakai data manual.
            setTimeout(() => {
                const filterAirItem = document.querySelector('[data-item-title=\'Filter Air\']');
                if(filterAirItem) filterAirItem.click();
            }, 500);
        }
     "
    x-show="open"
    x-effect="document.body.classList.toggle('modal-open', open)"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    @open-tutorial.window="openModal($event.detail.bencana)"
    @keydown.escape.window="closeModal()"
    style="display:none;"
    class="fixed inset-0 z-[9000] flex items-center justify-center p-4">

    {{-- 1. Backdrop Khas Sesudah/Saat (Blur gelap) --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>

    {{-- 2. Box Modal dengan border-radius 24px/32px dan max-w-4xl --}}
    <div class="w-full max-w-4xl bg-white rounded-[24px] md:rounded-[32px] flex flex-col justify-between overflow-hidden relative z-10 max-h-[90vh] mx-auto" @click.stop>
        
        <div class="modal-header border-b border-slate-100 flex items-center justify-between px-6 py-4 bg-white relative">
            <div class="modal-title flex items-center gap-2 text-slate-800 font-bold text-lg">
                <i class="fa-solid fa-graduation-cap text-teal-600"></i>
                <span x-text="bencana"></span>
            </div>
            <button @click="closeModal()" class="modal-close text-slate-400 hover:text-rose-600 text-lg transition-colors">✕</button>
        </div>

        <div class="grid grid-cols-3 border-b border-slate-200 bg-slate-50">
            <button @click="fase='sebelum'; currentStep=0" class="h-12 text-xs font-bold transition-colors uppercase tracking-wider"
                    :style="fase==='sebelum' ? 'background:var(--c-teal);color:white' : 'color:var(--color-text-muted)'">Sebelum</button>
            <button @click="fase='saat'; currentStep=0" class="h-12 text-xs font-bold transition-colors uppercase tracking-wider"
                    :style="fase==='saat' ? 'background:var(--color-danger);color:white' : 'color:var(--color-text-muted)'">Saat</button>
            <button @click="fase='sesudah'; currentStep=0" class="h-12 text-xs font-bold transition-colors uppercase tracking-wider"
                    :style="fase==='sesudah' ? 'background:#27AE60;color:white' : 'color:var(--color-text-muted)'">Sesudah</button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 pt-2 pb-4 flex flex-col justify-start">
            
            {{-- KONDISI 1: JIKA FASE "SAAT" (KUIS / DECISION TREE INTERAKTIF) --}}
            <template x-if="fase === 'saat'">
                <div class="w-full flex flex-col items-center flex-1 py-0"
                     @touchstart="touchStartX = $event.changedTouches[0].screenX"
                     @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()"> 
                    <div class="flex items-center justify-center gap-6 mb-2 w-full select-none">
                        <button @click="prevStep()" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-800 transition-all">
                            <i class="fa-solid fa-chevron-left text-sm"></i>
                        </button>
                        <h3 class="text-base font-bold text-slate-800 tracking-tight text-center max-w-[550px] w-full min-h-[32px] flex items-center justify-center" x-text="currentQuestion().description"></h3>
                        <button @click="nextStep()" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-800 transition-all">
                            <i class="fa-solid fa-chevron-right text-sm"></i>
                        </button>
                    </div>

                    {{-- Card interaktif diperbesar dengan max-w-2xl --}}
                    <div class="grid grid-cols-2 gap-6 w-full max-w-2xl mx-auto mb-0.5">
                        
                        <template x-for="choice in currentQuestion().options">
                            <button @click="selectedChoice = choice" 
                                    :class="selectedChoice === choice ? 'border-sky-500 bg-sky-50/30 ring-2 ring-sky-500/20' : 'border-slate-200 bg-white hover:bg-slate-50'"
                                    class="relative rounded-xl border p-6 flex flex-col items-center text-center transition-all duration-200 group min-h-[340px]"> 
                                
                                <div class="absolute top-4 right-4 flex items-center gap-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wide" 
                                          :class="selectedChoice === choice ? 'text-sky-600' : 'text-slate-400 group-hover:text-slate-600'" 
                                          x-text="choice.label"></span>
                                    <span :class="selectedChoice === choice ? 'bg-sky-500' : 'bg-slate-200'" class="w-2.5 h-2.5 rounded-full inline-block"></span>
                                </div>
                                
                                <div class="w-full h-56 rounded-lg overflow-hidden mt-6 mb-4 flex items-center justify-center text-7xl transition-colors border border-black/5"
                                     :class="selectedChoice === choice ? 'bg-sky-50/50' : 'bg-slate-50'">
                                    <span class="drop-shadow-sm" x-html="choice.icon"></span>
                                </div>
                                
                                <span class="text-base font-extrabold text-slate-700 tracking-wide mt-auto" x-text="choice.desc"></span> 
                            </button>
                        </template>

                    </div>

                    <div class="w-full max-w-2xl bg-slate-50 rounded-xl p-4 border border-slate-100 text-center mt-2">
                        <p class="text-xs font-medium text-slate-600 leading-relaxed" x-text="currentQuestion().caption"></p>
                    </div>

                </div>
            </template>

            {{-- KONDISI 2: JIKA FASE SEBELUM / SESUDAH (LIST LANGKAH BIASA) --}}
            <template x-if="fase !== 'saat'">
                <div class="w-full flex-1 overflow-y-auto px-6 py-2">
                    
                    {{-- Jarak antar card sedang (gap-3) --}}
                    <div class="flex flex-col gap-3 w-full max-w-2xl mx-auto">
                        
                        {{-- LOOPING DATA LANGKAH --}}
                        <template x-for="(langkah, index) in getSteps()" :key="index">
                            {{-- Padding disetel ke p-4 agar ruang di dalam card pas --}}
                            <div class="bg-white border border-slate-100 rounded-xl p-4 flex items-start gap-4 shadow-sm hover:shadow-md transition-all duration-200 w-full min-h-[120px]">
                                
                                {{-- 1. BOX GAMBAR KOTAK (Ukuran Sedang: w-28 h-28) --}}
                                <div class="w-24 h-24 rounded-xl overflow-hidden border border-slate-100 bg-slate-50 shrink-0 relative">
                                    <img src="/images/tutorial-gempa.jpg" class="w-full h-full object-cover" alt="Panduan">
                                    
                                    {{-- Badge nomor urut --}}
                                    <div class="absolute top-2 left-2 w-5.5 h-5.5 bg-slate-900/80 text-white rounded flex items-center justify-center text-[10px] font-black backdrop-blur-sm">
                                        <span x-text="index + 1"></span>
                                    </div>
                                </div>

                                {{-- 2. KONTEN TEKS (Judul & Deskripsi) --}}
                                <div class="flex-1 text-left flex flex-col justify-start pt-1">
                                    {{-- Judul sedikit dinaikkan ke text-sm/base --}}
                                    <h4 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight mb-1">
                                        <span x-text="index === 0 ? 'Identifikasi Bahaya' : (index === 1 ? 'Persiapan Logistik' : 'Simulasi Rutin')"></span>
                                    </h4>
                                    
                                    {{-- Deskripsi text-xs/sm yang proporsional --}}
                                    <p class="text-xs sm:text-sm font-medium text-slate-500 leading-relaxed" x-text="langkah"></p>
                                </div>

                            </div>
                        </template>

                    </div>
                </div>

            </template>
        </div>


        {{-- FOOTER 1: Khusus muncul saat fase 'saat' --}}
        <div x-show="fase === 'saat'" class="border-t border-slate-200 px-6 py-4 bg-slate-50 rounded-b-[24px] md:rounded-b-[32px] flex flex-col items-center justify-center">
            <div class="flex flex-wrap justify-center gap-2 w-full">
                <template x-for="(item, index) in getSteps()" :key="index">
                    <button @click="currentStep = index" 
                            :class="currentStep === index ? 'bg-slate-800 text-white shadow-sm' : 'bg-slate-200 text-slate-500 hover:bg-slate-300'"
                            class="h-9 sm:h-10 px-3 sm:px-4 rounded-xl flex flex-shrink-0 items-center justify-center text-xs font-black transition-all duration-300 gap-1.5">
                        <i :class="item.navIcon" class="text-[10px]"></i><span x-text="index+1"></span>
                    </button>
                </template>
            </div>
        </div>

    </div>
</div>
</template>

{{-- Modal: Info --}}
<template x-teleport="body">
<div
    x-data="infoModal()"
    x-show="open"
    x-effect="document.body.classList.toggle('modal-open', open)"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    @open-info.window="openModal($event.detail)"
    @keydown.escape.window="closeModal()"
    style="display:none;"
    class="fixed inset-0 z-[9000] flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>

    <div class="bg-white rounded-[24px] md:rounded-[32px] w-full max-w-2xl p-6 md:p-8 shadow-2xl flex flex-col relative z-10 max-h-[90vh] overflow-y-auto" @click.stop
         @touchstart="touchStartX = $event.changedTouches[0].screenX"
         @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()">

        {{-- BUTTON STEP --}}
        <div class="flex justify-center gap-2 mb-6 flex-wrap">
            <template x-for="(step, index) in steps" :key="index">
                <button
                    @click="goToStep(index + 1)"
                    class="w-9 h-9 rounded-lg border font-bold text-sm transition-colors"
                    :class="currentStep === index + 1
                        ? 'bg-gray-800 text-white'
                        : 'bg-gray-100 text-gray-400 hover:bg-gray-200'">

                    <span x-text="index + 1"></span>
                </button>
            </template>
        </div>

        {{-- CONTENT --}}
        <div class="flex items-center justify-center mb-6 gap-2">

            {{-- PREV --}}
            <button
                @click="prevStep()"
                :disabled="currentStep === 1"
                class="w-14 flex justify-center text-3xl p-3 rounded-full transition"
                :class="currentStep === 1
                    ? 'text-gray-200'
                    : 'hover:bg-gray-100 text-gray-800'">
                ◀
            </button>

            {{-- IMAGE / ICON --}}
            <div class="h-64 w-full max-w-[450px] bg-gray-200 rounded-2xl flex items-center justify-center shadow-inner">

                <template x-if="currentContent.type === 'icon'">
                    <div class="text-[100px]" x-html="currentContent.icon"></div>
                </template>

                <template x-if="currentContent.type === 'image'">
                    <img
                        :src="currentContent.image"
                        class="w-full h-full object-cover rounded-2xl">
                </template>

            </div>

            {{-- NEXT --}}
            <button
                @click="nextStep()"
                :disabled="currentStep === steps.length"
                class="w-14 flex justify-center text-3xl p-3 rounded-full transition"
                :class="currentStep === steps.length
                    ? 'text-gray-200'
                    : 'hover:bg-gray-100 text-gray-800'">
                ▶
            </button>
        </div>

        {{-- TEXT --}}
        <div class="text-center mb-6 flex-grow">
            <h3 class="font-bold text-lg text-slate-800" x-text="item"></h3>

            <p class="text-slate-600 text-sm mt-2 max-w-md mx-auto"
               x-text="currentContent.description">
            </p>
        </div>

        {{-- FOOTER --}}
<div class="flex justify-between items-center mt-auto pt-4 border-t border-slate-100">

    {{-- ICON KIRI --}}
    <div class="flex items-center gap-3">

        {{-- BOX ICON --}}
        <div class="relative">

            <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center shadow-sm">
                <span class="text-xl" x-html="toolIcon"></span>
            </div>

            {{-- BUTTON SWITCH --}}
            <button
                x-show="toolIcons.length > 1"
                @click="switchToolIcon()"
                class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-teal-500 hover:bg-teal-600 text-white text-[8px] font-black transition flex items-center justify-center shadow">

                ⇄
            </button>

        </div>

        {{-- NAMA TOOL --}}
        <div class="flex flex-col leading-tight">

            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold">
                Tool
            </span>

            <span class="text-xs font-bold text-slate-700"
                  x-text="toolName">
            </span>

        </div>

    </div>

    {{-- DONE BUTTON --}}
    <button
        @click="closeModal()"
        :disabled="currentStep !== steps.length"
        :class="currentStep === steps.length
            ? 'bg-gray-800 hover:bg-gray-900 text-white'
            : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
        class="px-8 h-10 rounded-xl font-bold text-xs transition-all">

        Done
    </button>

    </div>

    </div>
</div>
</template>

{{-- Modal: Crafting --}}
<template x-teleport="body">
<div x-data="craftingModal()" 
     @open-crafting.window="openModal($event.detail)" 
     x-show="open"
     x-effect="document.body.classList.toggle('modal-open', open)"
     x-cloak
     @keydown.escape.window="open=false"
     style="display:none;"
     class="fixed inset-0 z-[9000] flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

    <div class="bg-white rounded-[24px] md:rounded-[32px] w-full max-w-4xl p-6 md:p-10 shadow-2xl flex flex-col transition-all relative z-10 max-h-[95vh] overflow-y-auto" @click.stop>
        
        {{-- VIEW 1: SELECTION --}}
        <div x-show="currentView === 'selection'" class="flex flex-col">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold" x-text="item"></h2>
                <button @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-100 text-gray-400 transition text-sm font-bold">✕</button>
            </div>

            <div class="flex gap-5">
                <div class="flex flex-col gap-3 flex-shrink-0 self-center" style="width:160px;">
                    <div class="bg-gray-50 rounded-xl border flex flex-col items-center justify-center gap-2 py-6 relative">
                        <div class="text-6xl" x-html="icon"></div>
                        <div class="font-bold text-xs text-center text-gray-600 px-2" x-text="item"></div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto" style="max-height:320px;">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Bahan (Tap ⇅ untuk Ganti)</p>
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="(m, idx) in materials" :key="idx">
                            <div class="border p-3 rounded-xl relative flex flex-col items-center justify-center bg-white shadow-sm min-h-[90px]">
                                <div class="text-3xl mb-1" x-html="m.icon"></div>
                                <span class="text-[10px] font-bold text-center leading-tight text-gray-700" x-text="m.name"></span>
                                <span class="text-[9px] font-semibold uppercase tracking-wide text-gray-400 mt-0.5" x-text="m.role"></span>
                                <button x-show="m.swappable" @click="switchMaterial(idx)" class="absolute top-1.5 right-1.5 w-5 h-5 flex items-center justify-center bg-teal-500 text-white rounded-full text-[9px] font-bold transition">⇅</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            
            {{-- SELECTION FOOTER --}}
            <div class="flex justify-between gap-4 w-full mt-6 pt-4 border-t">
                <button @click="closeModal()" class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition text-sm">Batal</button>
                <button @click="currentView = 'process'" class="px-8 py-2.5 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 shadow-md transition-transform hover:-translate-y-0.5 text-sm tracking-wide">Next →</button>
            </div>
        </div>

        {{-- VIEW 2: PROCESS --}}
<div x-show="currentView === 'process'" class="flex flex-col"
     @touchstart="touchStartX = $event.changedTouches[0].screenX"
     @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()">
    <div class="flex justify-center gap-2 mb-6">
        <template x-for="i in 7">
            <button @click="currentStep = i" class="w-9 h-9 rounded-lg border font-bold text-sm transition-colors" :class="currentStep === i ? 'bg-gray-800 text-white' : 'bg-gray-100 hover:bg-gray-200'" x-text="i"></button>
        </template>
    </div>

    {{-- AREA GAMBAR/IKON DIBUAT LEBIH BESAR (h-64) --}}
    <div class="h-64 flex items-center justify-center mb-6 relative w-full max-w-[400px] mx-auto">
        {{-- Arrow Kiri (Desktop Only) --}}
        <button @click="prevStep()" class="absolute -left-12 md:-left-16 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border shadow-sm flex items-center justify-center text-gray-400 hover:text-teal-600 hidden md:flex transition-colors z-10" x-show="currentStep > 1">◀</button>

        <div class="bg-gray-100 w-full h-full rounded-2xl flex items-center justify-center shadow-inner text-[120px]" x-html="icon"></div>

        {{-- Arrow Kanan (Desktop Only) --}}
        <button @click="nextStep()" class="absolute -right-12 md:-right-16 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border shadow-sm flex items-center justify-center text-gray-400 hover:text-teal-600 hidden md:flex transition-colors z-10" x-show="currentStep < Object.keys(craftingData[item]?.instructions || {}).length">▶</button>
    </div>

    <div class="text-center mb-6">
        <h3 class="font-bold text-md" x-text="'Step ' + currentStep"></h3>
        <p class="text-gray-600 text-sm" x-text="getInstruction()"></p>
    </div>

    {{-- DAFTAR ITEM --}}
    <div class="flex gap-2 mb-6 justify-center overflow-x-auto pb-2">
        <template x-for="m in materials">
            <div class="flex flex-col items-center bg-white border p-2 rounded-lg shadow-sm min-w-[70px]">
                <div class="text-2xl" x-html="m.icon"></div>
                <span class="text-[9px] font-bold text-gray-600 mt-1" x-text="m.name"></span>
            </div>
        </template>
    </div>

    <div class="flex justify-between items-center mt-auto pt-4 border-t">
        <button @click="currentView = 'selection'" class="px-5 py-2 border rounded-xl font-bold hover:bg-gray-50 transition text-sm">Prev</button>
        <button @click="open=false" class="px-7 py-2 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition text-sm">Done</button>
    </div>
</div>

    </div>
</div>
</template>

@push('scripts')
<script>
    gsap.from('#hero-text > *', { opacity: 0, y: 40, stagger: 0.15, duration: 0.9, ease: 'power3.out', delay: 0.2 });
    gsap.from('#hero-img',      { opacity: 0, scale: 0.9, duration: 1, ease: 'power3.out', delay: 0.4 });
    gsap.from('#scroll-hint',   { opacity: 0, y: 10, duration: 1, delay: 1.2, ease: 'power2.out' });

    function tutorialModal() {
        return {
            open: false, bencana: '', fase: 'saat', currentStep: 0, selectedChoice: null,
            touchStartX: 0, touchEndX: 0,
            icons: {
                'Gempa Bumi': 'fa-solid fa-house-chimney',
                'Tsunami': 'fa-solid fa-water',
                'Banjir': 'fa-solid fa-house-flood-water',
                'Kebakaran': 'fa-solid fa-fire-flame-curved'
            },
            openModal(nama) { this.bencana = nama; this.fase = 'saat'; this.currentStep = 0; this.selectedChoice = null; this.open = true; document.body.classList.add('modal-open'); },
            closeModal()    { this.open = false; document.body.classList.remove('modal-open'); },
            steps: {
                'Gempa Bumi': {
                    ambang: ['Identifikasi benda yang rawan jatuh dan amankan.','Siapkan tas siaga dan dokumen penting.','Latih simulasi evakuasi keluarga.'],
                    sebelum: ['Identifikasi benda yang rawan jatuh dan amankan.','Siapkan tas siaga dan dokumen penting.','Latih simulasi evakuasi keluarga.'],
                    saat: [
                        {
                            title:'Dimana?', visual:'🏢', caption:'Lokasi Saat Ini', description:'Pilih kondisi lokasi kamu saat gempa terjadi.',
                            navIcon: 'fa-solid fa-location-dot',
                            options:[
                                { label:'Luar Ruangan', icon:'<i class="fa-solid fa-tree text-green-700"></i>', desc:'Jauhi benda rawan jatuh.' },
                                { label:'Dalam Ruangan', icon:'🏠', desc:'Lindungi kepala.' }
                            ]
                        },
                        {
                            title:'Berapa Orang?', visual:'👥', caption:'Cek Sekitar', description:'Pastikan siapa saja berada dekat denganmu.',
                            navIcon: 'fa-solid fa-users',
                            options:[
                                { label:'Sendiri', icon:'🧍', desc:'Fokus evakuasi diri.' },
                                { label:'Bersama Orang', icon:'👨‍👩‍👧', desc:'Bantu kelompok.' }
                            ]
                        },
                        {
                            title:'Ada Anak?', visual:'🧒', caption:'Prioritas Evakuasi', description:'Anak dan lansia harus diprioritaskan.',
                            navIcon: 'fa-solid fa-child-reaching',
                            options:[
                                { label:'Ada', icon:'🧒', desc:'Bantu lebih dulu.' },
                                { label:'Tidak Ada', icon:'👌', desc:'Lanjut evakuasi.' }
                            ]
                        },
                        {
                            title:'Akses Keluar?', visual:'<i class="fa-solid fa-door-open text-amber-800"></i>', caption:'Cari Jalur Aman', description:'Periksa jalur evakuasi.',
                            navIcon: 'fa-solid fa-door-open',
                            options:[
                                { label:'Terbuka', icon:'<i class="fa-solid fa-door-open text-amber-800"></i>', desc:'Segera keluar.' },
                                { label:'Tertutup', icon:'<i class="fa-solid fa-hill-rockslide text-gray-600"></i>', desc:'Cari jalur alternatif.' }
                            ]
                        },
                        {
                            title:'Ada Api?', visual:'<i class="fa-solid fa-fire text-red-500"></i>', caption:'Bahaya Tambahan', description:'Periksa adanya kebakaran atau gas.',
                            navIcon: 'fa-solid fa-fire',
                            options:[
                                { label:'Ada', icon:'<i class="fa-solid fa-fire text-red-500"></i>', desc:'Jauhi area.' },
                                { label:'Tidak', icon:'✅', desc:'Lanjut aman.' }
                            ]
                        },
                        {
                            title:'Menuju Shelter', visual:'<i class="fa-solid fa-person-running text-green-500"></i>', caption:'Evakuasi', description:'Ikuti jalur evakuasi resmi.',
                            navIcon: 'fa-solid fa-person-running',
                            options:[
                                { label:'Ikuti Jalur', icon:'➡️', desc:'Tetap tenang.' },
                                { label:'Cari Jalur', icon:'<i class="fa-solid fa-compass text-gray-600"></i>', desc:'Gunakan area terbuka.' }
                            ]
                        },
                        {
                            title:'Area Aman?', visual:'<i class="fa-solid fa-tent text-green-600"></i>', caption:'Shelter', description:'Pastikan area jauh dari bangunan retak.',
                            navIcon: 'fa-solid fa-tents',
                            options:[
                                { label:'Sudah', icon:'<i class="fa-solid fa-tent text-green-600"></i>', desc:'Tetap di shelter.' },
                                { label:'Belum', icon:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>', desc:'Cari tempat lain.' }
                            ]
                        },
                        {
                            title:'Aman', visual:'<i class="fa-solid fa-house-chimney text-green-600"></i>', caption:'Kondisi Stabil', description:'Kamu telah mencapai area aman.',
                            navIcon: 'fa-solid fa-check-circle',
                            options:[
                                { label:'Lanjut', icon:'✅', desc:'Periksa kondisi tubuh.' }
                            ]
                        }
                    ],
                    sesudah: ['Periksa kondisi diri dan keluarga.','Waspada gempa susulan.','Ikuti informasi resmi dari BMKG dan BNPB.']
                },
                'Tsunami': {
                    ambang: ['Kenali tanda-tanda peringatan dini seperti gempa kuat atau air laut surut drastis.','Pahami peta rawan tsunami dan jalur evakuasi di daerahmu.','Siapkan tas siaga bencana untuk dibawa kapan saja.'],
                    sebelum: ['Kenali tanda-tanda peringatan dini seperti gempa kuat atau air laut surut drastis.','Pahami peta rawan tsunami dan jalur evakuasi di daerahmu.','Siapkan tas siaga bencana untuk dibawa kapan saja.'],
                    saat: [
                        {
                            title:'Dimana?', visual:'<i class="fa-solid fa-location-dot text-red-500"></i>', caption:'Lokasi Saat Ini', description:'Di mana posisi kamu sekarang?',
                            navIcon: 'fa-solid fa-location-dot',
                            options:[
                                { label:'Dekat Pantai', icon:'<i class="fa-solid fa-umbrella-beach text-yellow-500"></i>', desc:'Segera menjauh.' },
                                { label:'Jauh Pantai', icon:'🏙️', desc:'Tetap waspada.' }
                            ]
                        },
                        {
                            title:'Peringatan?', visual:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>', caption:'Tanda Alam', description:'Apakah ada tanda tsunami?',
                            navIcon: 'fa-solid fa-triangle-exclamation',
                            options:[
                                { label:'Air Surut', icon:'<i class="fa-solid fa-water text-teal-600"></i>', desc:'Tanda bahaya.' },
                                { label:'Gempa Kuat', icon:'🫨', desc:'Potensi tsunami.' }
                            ]
                        },
                        {
                            title:'Berapa Orang?', visual:'👥', caption:'Cek Sekitar', description:'Siapa yang bersamamu saat ini?',
                            navIcon: 'fa-solid fa-users',
                            options:[
                                { label:'Sendiri', icon:'🧍', desc:'Evakuasi diri.' },
                                { label:'Bersama', icon:'👨‍👩‍👧', desc:'Bantu yang lain.' }
                            ]
                        },
                        {
                            title:'Ada Rentan?', visual:'👵', caption:'Prioritas', description:'Adakah lansia atau anak kecil?',
                            navIcon: 'fa-solid fa-person-cane',
                            options:[
                                { label:'Ada', icon:'🧒', desc:'Bantu mereka.' },
                                { label:'Tidak', icon:'👌', desc:'Segera lari.' }
                            ]
                        },
                        {
                            title:'Evakuasi?', visual:'<i class="fa-solid fa-person-running text-green-500"></i>', caption:'Metode', description:'Cara menuju tempat aman.',
                            navIcon: 'fa-solid fa-person-running',
                            options:[
                                { label:'Jalan Kaki', icon:'🚶', desc:'Lebih disarankan.' },
                                { label:'Kendaraan', icon:'🚗', desc:'Bisa macet.' }
                            ]
                        },
                        {
                            title:'Tujuan?', visual:'<i class="fa-solid fa-mountain text-amber-700"></i>', caption:'Tempat Tinggi', description:'Cari area evakuasi vertikal.',
                            navIcon: 'fa-solid fa-mountain-sun',
                            options:[
                                { label:'Bukit', icon:'<i class="fa-solid fa-mountain text-amber-700"></i>', desc:'Minimal 10m dpl.' },
                                { label:'Gedung', icon:'🏢', desc:'Lantai 3 ke atas.' }
                            ]
                        },
                        {
                            title:'Area Aman?', visual:'✅', caption:'Status Lokasi', description:'Apakah posisi sudah cukup tinggi?',
                            navIcon: 'fa-solid fa-flag-checkered',
                            options:[
                                { label:'Sudah Tinggi', icon:'✅', desc:'Tetap di sana.' },
                                { label:'Masih Rendah', icon:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>', desc:'Naik lagi.' }
                            ]
                        },
                        {
                            title:'Aman', visual:'<i class="fa-solid fa-water text-teal-600"></i>', caption:'Bertahan', description:'Tunggu info resmi sebelum turun.',
                            navIcon: 'fa-solid fa-tower-broadcast',
                            options:[
                                { label:'Bertahan', icon:'<i class="fa-solid fa-ban text-red-600"></i>', desc:'Jangan ke pantai.' }
                            ]
                        }
                    ],
                    sesudah: ['Tetap berada di daerah aman dan jauhi pesisir.','Hindari bangunan yang retak atau rusak.','Tunggu informasi resmi pemerintah sebelum kembali.']
                },
                'Banjir': {
                    ambang: ['Perhatikan informasi cuaca, tinggi muka air, dan peringatan dini hujan lebat.','Amankan dokumen penting dan barang berharga di tempat yang lebih tinggi.','Pastikan saluran air di sekitar tempat tinggal tidak tersumbat.'],
                    sebelum: ['Perhatikan informasi cuaca, tinggi muka air, dan peringatan dini hujan lebat.','Amankan dokumen penting dan barang berharga di tempat yang lebih tinggi.','Pastikan saluran air di sekitar tempat tinggal tidak tersumbat.'],
                    saat: [
                        {
                            title:'Dimana?', visual:'🏠', caption:'Lokasi', description:'Posisi kamu saat air naik.',
                            navIcon: 'fa-solid fa-house-flood-water',
                            options:[
                                { label:'Dalam Rumah', icon:'🛋️', desc:'Naik ke lantai atas.' },
                                { label:'Luar Rumah', icon:'🛣️', desc:'Cari dataran tinggi.' }
                            ]
                        },
                        {
                            title:'Kondisi Air?', visual:'<i class="fa-solid fa-water text-teal-600"></i>', caption:'Ketinggian', description:'Bagaimana arus airnya?',
                            navIcon: 'fa-solid fa-water',
                            options:[
                                { label:'Cepat Naik', icon:'📈', desc:'Bahaya.' },
                                { label:'Genangan', icon:'<i class="fa-solid fa-droplet text-blue-500"></i>', desc:'Waspada.' }
                            ]
                        },
                        {
                            title:'Listrik?', visual:'<i class="fa-solid fa-bolt text-yellow-400"></i>', caption:'Risiko', description:'Apakah listrik sudah dipadamkan?',
                            navIcon: 'fa-solid fa-plug-circle-xmark',
                            options:[
                                { label:'Padamkan', icon:'🔌', desc:'Hindari setrum.' },
                                { label:'Sudah', icon:'✅', desc:'Bagus.' }
                            ]
                        },
                        {
                            title:'Barang?', visual:'<i class="fa-solid fa-backpack text-green-600"></i>', caption:'Penyelamatan', description:'Amankan dokumen penting.',
                            navIcon: 'fa-solid fa-file-shield',
                            options:[
                                { label:'Amankan', icon:'⬆️', desc:'Taruh di atas.' },
                                { label:'Tinggalkan', icon:'<i class="fa-solid fa-person-running text-green-500"></i>', desc:'Utamakan nyawa.' }
                            ]
                        },
                        {
                            title:'Arus Deras?', visual:'<i class="fa-solid fa-water text-teal-600"></i>', caption:'Bahaya', description:'Apakah air mengalir deras?',
                            navIcon: 'fa-solid fa-triangle-exclamation',
                            options:[
                                { label:'Hindari', icon:'<i class="fa-solid fa-ban text-red-600"></i>', desc:'Bisa terseret.' },
                                { label:'Jangan Terjang', icon:'❌', desc:'Berbahaya.' }
                            ]
                        },
                        {
                            title:'Evakuasi?', visual:'🛟', caption:'Alat', description:'Bagaimana cara evakuasi?',
                            navIcon: 'fa-solid fa-life-ring',
                            options:[
                                { label:'Pelampung', icon:'🛟', desc:'Gunakan ban/botol.' },
                                { label:'Tongkat', icon:'<i class="fa-solid fa-crutch text-gray-400"></i>', desc:'Cek kedalaman.' }
                            ]
                        },
                        {
                            title:'Tujuan?', visual:'<i class="fa-solid fa-tent text-green-600"></i>', caption:'Posko', description:'Cari posko pengungsian terdekat.',
                            navIcon: 'fa-solid fa-tents',
                            options:[
                                { label:'Posko', icon:'<i class="fa-solid fa-tent text-green-600"></i>', desc:'Tempat kering.' },
                                { label:'Dataran Tinggi', icon:'<i class="fa-solid fa-mountain text-amber-700"></i>', desc:'Aman dari air.' }
                            ]
                        },
                        {
                            title:'Aman', visual:'✅', caption:'Bertahan', description:'Tunggu air surut sepenuhnya.',
                            navIcon: 'fa-solid fa-check-circle',
                            options:[
                                { label:'Lanjut', icon:'✅', desc:'Periksa keluarga.' }
                            ]
                        }
                    ],
                    sesudah: ['Bersihkan rumah dengan disinfektan untuk mencegah penyebaran kuman penyakit.','Jangan langsung menyalakan listrik sebelum dipastikan kering dan aman.','Hindari air genangan yang bisa menyebabkan infeksi kulit.']
                },
                'Kebakaran': {
                    ambang: ['Sediakan Alat Pemadam Api Ringan (APAR) dan pelajari cara penggunaannya.','Pastikan tidak ada instalasi listrik yang kelebihan beban atau rusak.','Buat jalur evakuasi dan latih seluruh anggota keluarga.'],
                    sebelum: ['Sediakan Alat Pemadam Api Ringan (APAR) dan pelajari cara penggunaannya.','Pastikan tidak ada instalasi listrik yang kelebihan beban atau rusak.','Buat jalur evakuasi dan latih seluruh anggota keluarga.'],
                    saat: [
                        {
                            title:'Dimana?', visual:'🏢', caption:'Lokasi', description:'Posisi kamu saat kebakaran terjadi.',
                            navIcon: 'fa-solid fa-location-dot',
                            options:[
                                { label:'Dalam Ruangan', icon:'<i class="fa-solid fa-door-open text-amber-800"></i>', desc:'Cari jalan keluar.' },
                                { label:'Luar Ruangan', icon:'<i class="fa-solid fa-tree text-green-700"></i>', desc:'Jauhi bangunan.' }
                            ]
                        },
                        {
                            title:'Kondisi Asap?', visual:'💨', caption:'Asap', description:'Seberapa tebal asapnya?',
                            navIcon: 'fa-solid fa-smog',
                            options:[
                                { label:'Asap Tebal', icon:'🌫️', desc:'Merangkak di bawah.' },
                                { label:'Asap Tipis', icon:'💨', desc:'Jalan cepat.' }
                            ]
                        },
                        {
                            title:'Pakaian?', visual:'<i class="fa-solid fa-shirt text-blue-400"></i>', caption:'Risiko', description:'Apakah pakaian terbakar?',
                            navIcon: 'fa-solid fa-fire',
                            options:[
                                { label:'Stop Drop Roll', icon:'🔄', desc:'Berguling.' },
                                { label:'Aman', icon:'✅', desc:'Lanjut lari.' }
                            ]
                        },
                        {
                            title:'Gagang Pintu?', visual:'<i class="fa-solid fa-door-open text-amber-800"></i>', caption:'Cek Suhu', description:'Periksa suhu gagang pintu.',
                            navIcon: 'fa-solid fa-door-closed',
                            options:[
                                { label:'Panas', icon:'<i class="fa-solid fa-fire text-red-500"></i>', desc:'Jangan dibuka.' },
                                { label:'Dingin', icon:'❄️', desc:'Buka perlahan.' }
                            ]
                        },
                        {
                            title:'Akses Keluar?', visual:'<i class="fa-solid fa-person-running text-green-500"></i>', caption:'Jalur', description:'Gunakan tangga darurat.',
                            navIcon: 'fa-solid fa-stairs',
                            options:[
                                { label:'Tangga', icon:'🪜', desc:'Jangan pakai lift.' },
                                { label:'Jendela', icon:'🪟', desc:'Tunggu bantuan (jika terjebak).' }
                            ]
                        },
                        {
                            title:'Pemadam?', visual:'<i class="fa-solid fa-fire-extinguisher text-red-600"></i>', caption:'Tindakan', description:'Apakah api masih kecil?',
                            navIcon: 'fa-solid fa-fire-extinguisher',
                            options:[
                                { label:'Pakai APAR', icon:'<i class="fa-solid fa-fire-extinguisher text-red-600"></i>', desc:'Padamkan.' },
                                { label:'Tinggalkan', icon:'<i class="fa-solid fa-person-running text-green-500"></i>', desc:'Bila membesar.' }
                            ]
                        },
                        {
                            title:'Titik Kumpul?', visual:'<i class="fa-solid fa-location-dot text-red-500"></i>', caption:'Evakuasi', description:'Menuju titik kumpul yang aman.',
                            navIcon: 'fa-solid fa-people-group',
                            options:[
                                { label:'Titik Kumpul', icon:'<i class="fa-solid fa-location-dot text-red-500"></i>', desc:'Kumpul di sana.' },
                                { label:'Jauhi Gedung', icon:'🏢', desc:'Awas runtuhan.' }
                            ]
                        },
                        {
                            title:'Aman', visual:'✅', caption:'Bertahan', description:'Hubungi pemadam dan tunggu.',
                            navIcon: 'fa-solid fa-check-circle',
                            options:[
                                { label:'Lanjut', icon:'✅', desc:'Cek luka bakar.' }
                            ]
                        }
                    ],
                    sesudah: ['Jangan kembali ke dalam bangunan sebelum dinyatakan aman oleh pemadam kebakaran.','Segera cari pertolongan medis jika ada yang mengalami luka bakar atau sesak napas.','Hubungi nomor darurat 113 untuk memastikan api telah padam sepenuhnya.']
                }
            },
            getSteps()          { return this.steps[this.bencana]?.[this.fase] ?? []; },
            currentQuestion()   { return this.getSteps()[this.currentStep] || {}; },
            currentDescription(){ return this.getSteps()[this.currentStep]?.description || ''; },
            nextStep() { if (this.currentStep < this.getSteps().length - 1) { this.currentStep++; this.selectedChoice = null; } },
            prevStep() { if (this.currentStep > 0) { this.currentStep--; this.selectedChoice = null; } },
            handleSwipe() {
                if (this.touchEndX < this.touchStartX - 50) this.nextStep();
                if (this.touchEndX > this.touchStartX + 50) this.prevStep();
            }
        }
    }

    function infoModal() {

    const stepsData = {

        'Kain Penyangga Tangan': {

            toolIcons: [

                { icon: '<i class="fa-solid fa-spoon text-gray-400"></i>', name: 'Kain Segitiga' },
                { icon: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>', name: 'Syal' },
                { icon: '<i class="fa-solid fa-kitchen-set text-gray-400"></i>', name: 'Handuk Kecil' },
                {icon: '<i class="fa-solid fa-kitchen-set text-gray-400"></i>', name: 'Kain Panjang' }

            ],

            steps: [

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-box text-gray-500"></i>',
                    description: 'Lipat kain membentuk segitiga.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>',
                    description: 'Tekuk lengan sekitar 90 derajat dan posisikan telapak tangan sedikit lebih tinggi dari siku.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-box text-gray-500"></i>',
                    description: 'Masukkan lengan ke kain hingga siku tertutup dan tangan berada di tengah.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-bowl-food text-orange-400"></i>',
                    description: 'Ikat dua ujung kain ke leher.'
                }

            ]
        },

        'Membalut Luka': {

            toolIcons: [

                { icon: '<i class="fa-solid fa-compress text-gray-400"></i>', name: 'Kasa' },
                { icon: '<i class="fa-solid fa-tape text-blue-400"></i>', name: 'Kain Bersih' },
                { icon: '<i class="fa-solid fa-tape text-blue-400"></i>', name: 'Perban' },
                { icon: '<i class="fa-solid fa-tape text-blue-400"></i>', name: 'Handuk Kecil Bersih' }

            ],

            steps: [

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-tape text-blue-400"></i>',
                    description: 'Bersihkan luka menggunakan air mengalir.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compress text-gray-400"></i>',
                    description: 'Tekan luka perlahan selama beberapa menit menggunakan kain bersih untuk menghentikan pendarahan. Jika darah menembua balutan, tambahkan lapisan kasa tanpa melepas yang sudah ada.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-hand text-yellow-300"></i>',
                    description: 'Tutup luka menggunakan kasa, dan pastikan menutupi seluruh area luka.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-hand text-yellow-300"></i>',
                    description: 'Ikat atau rekatkan dengan kain pengikat.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-hand text-yellow-300"></i>',
                    description: 'Periksa sirkulasi, pastikan tidak terlalu kencang.'
                }

            ]
        },

        'Jam Matahari': {

            toolIcons: [

                { icon: '<i class="fa-solid fa-compass text-gray-600"></i>', name: 'Tongkat Lurus' },
                { icon: '<i class="fa-solid fa-compass text-gray-600"></i>', name: 'Ranting' },
                { icon: '<i class="fa-solid fa-compass text-gray-600"></i>', name: 'Kayu' },
                { icon: '<i class="fa-solid fa-compass text-gray-600"></i>', name: 'Pipa Kecil' },

            ],

            steps: [

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-sun text-yellow-500"></i>',
                    description: 'Tancapkan tongkat ke tanah dengan posisi tegak lurus.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-tree text-amber-900"></i>',
                    description: 'Lihat ujung bayangan dari tongkat dan tandai dengan benda atau buat tanda di tanah.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Tunggu 10-20 menit dan tandai kembali ujung bayangan kedua.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Jika bayangan masih sangat panjang, maka waktu pagi. Jika bayangan mulai pendek, maka waktu mendekati siang. Jika semakin pendek, waktu sudah siang sekitar tengah hari. Setelah itu, bayangan akan mulai memanjang kembali menunjukkan waktu sore hingga petang.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Pagi, bayangan panjang dan bergerak cukup cepat (06.00-09.00). Siang, bayangan pendek dan bergerak lambat (09.00-11.30). Tengah hari, bayangan paling pendek dan matahari paling tinggi (11.30-13.00). Sore, bayangan mulai memanjang kembali (15.00-17.30).'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Batu pertama menunjukkan arah timur, batu kedua menunjukkan arah barat.'
                },

            ]
        },

        'Menentukan Keamanan Air': {

            toolIcons: [

                { icon: '<i class="fa-solid fa-compass text-gray-600"></i>' }

            ],

            steps: [

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-sun text-yellow-500"></i>',
                    description: 'Utamakan air kemasan jika masih tersedia.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-tree text-amber-900"></i>',
                    description: 'Cari air yang mengalir seperti sungai kecil atau mata air.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Tampung air hujan dan pastikan tidak terkontaminasi.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Hindari air yang berbau, berwarna, terkontaminasi, atau berada dekat daerah yang tercemar.'
                },

                {
                    type: 'icon',
                    icon: '<i class="fa-solid fa-compass text-gray-600"></i>',
                    description: 'Usahakan saring dan rebus air, jangan minum air dari pantai karena mengandung garam tinggi'
                }

            ]
        }

    };

    return {

        open: false,

        item: '',

        currentStep: 1,
        touchStartX: 0, 
        touchEndX: 0,

        steps: [],

        currentContent: {},

        toolIcon: '<i class="fa-solid fa-screwdriver-wrench text-gray-600"></i>',

        toolName: '',

        toolIcons: [],

        currentToolIconIndex: 0,

        openModal(data) {

            this.open = true;

            this.item = data.item;

            const itemData = stepsData[data.item] || {

                toolIcons: [
                    { icon: '<i class="fa-solid fa-screwdriver-wrench text-gray-600"></i>', name: 'Tool' }
                ],

                steps: [
                    {
                        type: 'icon',
                        icon: '<i class="fa-solid fa-box-open text-amber-600"></i>',
                        description: 'Belum ada data.'
                    }
                ]
            };

            this.steps = itemData.steps;

            this.toolIcons = itemData.toolIcons;

            this.currentToolIconIndex = 0;

            this.toolIcon = this.toolIcons[0].icon;

            this.toolName = this.toolIcons[0].name;

            this.currentStep = 1;

            this.updateContent();

            document.body.classList.add('modal-open');
        },

        updateContent() {

            this.currentContent = this.steps[this.currentStep - 1];
        },

        nextStep() {

            if (this.currentStep < this.steps.length) {

                this.currentStep++;

                this.updateContent();
            }
        },

        prevStep() {

            if (this.currentStep > 1) {

                this.currentStep--;

                this.updateContent();
            }
        },

        goToStep(step) {

            this.currentStep = step;

            this.updateContent();
        },

        handleSwipe() {
            if (this.touchEndX < this.touchStartX - 50) this.nextStep();
            if (this.touchEndX > this.touchStartX + 50) this.prevStep();
        },

                switchToolIcon() {
            if (this.toolIcons && this.toolIcons.length > 0) {
                this.currentToolIconIndex = (this.currentToolIconIndex + 1) % this.toolIcons.length;
                this.toolIcon = this.toolIcons[this.currentToolIconIndex].icon;
                this.toolName = this.toolIcons[this.currentToolIconIndex].name;
            }
        },

        closeModal() {
            this.open = false;
            document.body.classList.remove('modal-open');
        }
    }
}

function craftingModal() {
    const craftingData = {
        'Filter Air': {
            icon: '<i class="fa-solid fa-filter text-blue-400"></i>',
            materials: [
                { name: 'Botol Plastik', role: 'Wadah Filter', icon: '<i class="fa-solid fa-bottle-water text-blue-300"></i>', swappable: true, options: [{n: 'Botol Plastik', i: '<i class="fa-solid fa-bottle-water text-blue-300"></i>'}, {n: 'Botol Kaca', i: '<i class="fa-solid fa-jar text-gray-400"></i>'}, {n: 'Wadah Bambu', i: '<i class="fa-solid fa-seedling text-green-500"></i>'}, {n: 'Kaleng Tinggi', i: '<i class="fa-solid fa-box text-gray-500"></i>'}] },
                { name: 'Kain Bersih', role: 'Kain Penyaring', icon: '<i class="fa-solid fa-square text-green-400"></i>', swappable: true, options: [{n: 'Kain Bersih', i: '<i class="fa-solid fa-square text-green-400"></i>'}, {n: 'Tisu Tebal', i: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md"></i>'}, {n: 'Kapas', i: '<i class="fa-solid fa-fan text-pink-300"></i>'}, {n: 'Kaos Bekas', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}] },
                { name: 'Arang Kayu', role: 'Penyaring', icon: '<i class="fa-solid fa-fire text-red-500"></i>', swappable: true, options: [{n: 'Arang Kayu', i: '<i class="fa-solid fa-fire text-red-500"></i>'}, {n: 'Arang Tempurung Kelapa', i: '<i class="fa-solid fa-bowling-ball text-amber-800"></i>'}, {n: 'Arang Bambu', i: '<i class="fa-solid fa-seedling text-green-500"></i>'}, {n: 'Arang Kayu Keras', i: '<i class="fa-solid fa-tree text-amber-900"></i>'}] },
                { name: 'Pasir Bersih', role: 'Penyaring Halus', icon: '<i class="fa-solid fa-wheat-awn text-yellow-600"></i>', swappable: true, options: [{n: 'Pasir Bersih', i: '<i class="fa-solid fa-wheat-awn text-yellow-600"></i>'}, {n: 'Pasir Sungai', i: '<i class="fa-solid fa-water text-blue-300"></i>'}, {n: 'Pasir Bangunan', i: '<i class="fa-solid fa-trowel-bricks text-gray-500"></i>'}, {n: 'Pasir Pantai', i: '<i class="fa-solid fa-umbrella-beach text-yellow-500"></i>'}] },
                { name: 'Batu Kerikil', role: 'Penyaring Kasar', icon: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>', swappable: true, options: [{n: 'Batu Kerikil', i: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>'}, {n: 'Batu Kali', i: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>'}, {n: 'Pecahan Bata', i: '<i class="fa-solid fa-brick text-red-700"></i>'}, {n: 'Kerikil Sungai', i: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>'}] },
                { name: 'Gelas', role: 'Wadah Penampung', icon: '<i class="fa-solid fa-glass-water text-blue-200"></i>', swappable: true, options: [{n: 'Gelas', i: '<i class="fa-solid fa-glass-water text-blue-200"></i>'}, {n: 'Botol', i: '<i class="fa-solid fa-jar text-gray-400"></i>'}, {n: 'Baskom', i: '<i class="fa-solid fa-seedling text-green-500"></i>'}, {n: 'Kaleng Bersih', i: '<i class="fa-solid fa-box text-gray-500"></i>'}] }
            ],
            instructions: {
                1: 'Siapkan dan bersihkan semua bahan yang telah dipilih.',
                2: 'Potong bagian bawah dan balik botol.',
                3: 'Taruh kain di mulut botol agar bahan tidak keluar.',
                4: 'Masukkan bahan mulai dari kerikil, pasir, arang, dan kain.',
                5: 'Tuang air kotor perlahan ke dalam filter.',
                6: 'Buang 1-2 hasil penyaringan awal.',
                7: 'Rebus kembali air jika untuk diminum.'
            }
        },

        'Pisau': {
            icon: '<i class="fa-solid fa-utensils text-gray-500"></i>',
            materials: [
                { name: 'Batu', role: 'Bahan Utama', icon: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>', swappable: true, options: [{n: 'Batu', i: '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>'}, {n: 'Logam Pecah', i: '<i class="fa-solid fa-link text-gray-500"></i>'}, {n: 'Plastik Keras', i: '<i class="fa-solid fa-bottle-water text-blue-300"></i>'}] },
                { name: 'Tali', role: 'Pengikat', icon: '<i class="fa-solid fa-tape text-blue-400"></i>', swappable: true, options: [{n: 'Tali', i: '<i class="fa-solid fa-tape text-blue-400"></i>'}, {n: 'Lakban', i: '<i class="fa-solid fa-tag text-gray-400"></i>'}, {n: 'Serat Tanaman', i: '<i class="fa-solid fa-leaf text-green-500"></i>'}, {n: 'Kaos Bekas', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}] },
                { name: 'Kayu', role: 'Pegangan', icon: '<i class="fa-solid fa-tree text-amber-900"></i>', swappable: true, options: [{n: 'Kayu', i: '<i class="fa-solid fa-tree text-amber-900"></i>'}, {n: 'Ranting Tebal', i: '<i class="fa-solid fa-tree text-green-700"></i>'}, {n: 'Bambu', i: '<i class="fa-solid fa-seedling text-green-500"></i>'}, {n: 'Pipa Kecil', i: '<i class="fa-solid fa-crutch text-gray-400"></i>'}] }
            ],
            instructions: {
                1: 'Cari bahan yang paling mudah untuk dibentuk/ditajamkan.',
                2: 'Tajamkan ujung atau pinggiran bahan dengan menggesek atau memukulkannya ke batu maupun benda lain.',
                3: 'Siapkan pengangan sepanjang tangan, lalu posisikan bahan menyesuaikan dengan pegangan.',
                4: 'Ikat bahan ke pegangan dan pastikan kuat.'
            }
        },
        
        'Korek Darurat': {
            icon: '<i class="fa-solid fa-fire-burner text-orange-500"></i>',
            materials: [
                { name: 'Baterai Bekas', role: 'Sumber Listrik', icon: '<i class="fa-solid fa-battery-full text-green-500"></i>', swappable: true, options: [{n: 'Baterai AA/AAA', i: '<i class="fa-solid fa-battery-full text-green-500"></i>'}, {n: 'Baterai Jam', i: '<i class="fa-solid fa-clock text-gray-600"></i>'}, {n: 'Baterai Remote', i: '<i class="fa-solid fa-mobile-screen text-gray-700"></i>'}] },
                { name: 'Kertas Timah', role: 'Konduktor', icon: '<i class="fa-solid fa-candy-cane text-red-400"></i>', swappable: true, options: [{n: 'Bungkus Permen/Rokok', i: '<i class="fa-solid fa-candy-cane text-red-400"></i>'}, {n: 'Aluminium Foil', i: '<i class="fa-solid fa-scroll text-gray-300"></i>'}, {n: 'Bungkus Obat', i: '<i class="fa-solid fa-pills text-red-500"></i>'}] },
                { name: 'Tisu Kering', role: 'Pemantik (Tinder)', icon: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md"></i>', swappable: true, options: [{n: 'Tisu Kering', i: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md"></i>'}, {n: 'Kapas', i: '<i class="fa-solid fa-cloud text-gray-300"></i>'}, {n: 'Serabut Kelapa', i: '<i class="fa-solid fa-bowling-ball text-amber-800"></i>'}, {n: 'Benang Pakaian', i: '<i class="fa-solid fa-tape text-blue-400"></i>'}] }
            ],
            instructions: {
                1: 'Gunting atau robek kertas timah (aluminium foil) memanjang sekitar 10 cm.',
                2: 'Bentuk bagian tengah foil menjadi sangat tipis (sekitar 2mm) seperti bentuk jam pasir.',
                3: 'Siapkan bahan mudah terbakar (tinder) seperti tisu tepat di bawah titik tengah foil.',
                4: 'Tempelkan satu ujung foil ke kutub positif (+) baterai, dan tahan ujung lainnya.',
                5: 'Sentuhkan ujung kedua foil ke kutub negatif (-). Bagian tengah akan seketika memerah dan menyulut api. Tiup perlahan.'
            }
        },
        
        'Lampu Minyak': {
            icon: '<i class="fa-solid fa-lightbulb text-yellow-500"></i>',
            materials: [
                { name: 'Minyak Goreng', role: 'Minyak', icon: '<i class="fa-solid fa-bottle-droplet text-yellow-600"></i>', swappable: true, options: [{n: 'Minyak Goreng', i: '<i class="fa-solid fa-bottle-droplet text-yellow-600"></i>'}, {n: 'Minyak Bekas', i: '<i class="fa-solid fa-oil-can text-yellow-700"></i>'}] },
                { name: 'Tisu', role: 'Sumbu', icon: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md"></i>', swappable: true, options: [{n: 'Tisu', i: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md"></i>'}, {n: 'Kapas', i: '<i class="fa-solid fa-cloud text-gray-300"></i>'}, {n: 'Kain Perca', i: '<i class="fa-solid fa-shirt text-orange-300"></i>'}] },
                { name: 'Mangkuk Kecil', role: 'Wadah', icon: '<i class="fa-solid fa-bowl-food text-orange-200"></i>', swappable: true, options: [{n: 'Mangkuk Kecil', i: '<i class="fa-solid fa-bowl-food text-orange-200"></i>'}, {n: 'Gelas', i: '<i class="fa-solid fa-glass-water text-blue-200"></i>'}, {n: 'Kaleng Belah', i: '<i class="fa-solid fa-jar text-gray-400"></i>'}] }
            ],
            instructions: {
                1: 'Gulung tisu memanjang hingga menjadi padat (sumbu)',
                2: 'Tuang minyak goreng ke dalam mangkuk kecil.',
                3: 'Celupkan seluruh sumbu hingga basah ke dalam minyak, sisakan ujungnya sedikit di atas.',
                4: 'Bakar ujung tisu.'
            }
        },

        'Bidai Darurat': {
            icon: '<i class="fa-solid fa-band-aid text-orange-300"></i>',
            materials: [
                { name: 'Kayu Lurus', role: 'Penyangga', icon: '<i class="fa-solid fa-tree text-amber-900"></i>', swappable: true, options: [{n: 'Kayu Lurus', i: '<i class="fa-solid fa-tree text-amber-900"></i>'}, {n: 'Bambu', i: '<i class="fa-solid fa-seedling text-green-500"></i>'}, {n: 'Tongkat', i: '<i class="fa-solid fa-crutch text-gray-400"></i>'}, {n: 'Papan/Karton', i: '<i class="fa-solid fa-box-open text-amber-600"></i>'}] },
                { name: 'Kain Baju', role: 'Pengikat', icon: '<i class="fa-solid fa-shirt text-blue-400"></i>', swappable: true, options: [{n: 'Kain Baju', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}, {n: 'Perban', i: '<i class="fa-solid fa-band-aid text-orange-300"></i>'}, {n: 'Tali', i: '<i class="fa-solid fa-tape text-blue-400"></i>'}, {n: 'Syal', i: '<i class="fa-solid fa-mitten text-red-400"></i>'}] },
                { name: 'Kain Lembut', role: 'Bantalan Tambahan', icon: '<i class="fa-solid fa-socks text-orange-300"></i>', swappable: true, options: [{n: 'Kain Lembut', i: '<i class="fa-solid fa-socks text-orange-300"></i>'}, {n: 'Handuk', i: '<i class="fa-solid fa-bath text-blue-200"></i>'}, {n: 'Baju Lipat', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}, {n: 'Kapas', i: '<i class="fa-solid fa-cloud text-gray-300"></i>'}] }
            ],
            instructions: {
                1: 'Periksa cedera, apakah terluka atau patah. JANGAN mencoba meluruskan bagian yang terlihat patah atau bengkok.',
                2: 'Siapkan 2 penyangga keras (kayu/bambu) yang panjangnya melewati persendian di atas dan di bawah area patah.',
                3: 'Sisipkan bantalan (kain lembut/baju) di antara kulit dan penyangga keras agar tidak melukai kulit.',
                4: 'Tempatkan penyangga keras di sisi kiri dan kanan dari tulang yang patah.',
                5: 'Ikat penyangga HARUS di atas dan di bawah titik patah. JANGAN mengikat tepat di area patah.',
                6: 'Ikat cukup erat agar stabil, tapi periksa sirkulasi ujung jari.'
            }
        },
        
        'Cairan Pembersih': {
            icon: '<i class="fa-solid fa-flask text-purple-500"></i>',
            materials: [
                { name: 'Air Mineral Segel', role: 'Cairan Steril', icon: '<i class="fa-solid fa-droplet text-blue-500"></i>', swappable: true, options: [{n: 'Air Botol Segel', i: '<i class="fa-solid fa-droplet text-blue-500"></i>'}, {n: 'Air Hujan Bersih', i: '<i class="fa-solid fa-cloud-showers-heavy text-blue-400"></i>'}, {n: 'Air Kelapa Muda', i: '<i class="fa-solid fa-bowling-ball text-amber-800"></i>'}] },
                { name: 'Botol Plastik', role: 'Penyemprot', icon: '<i class="fa-solid fa-bottle-water text-blue-300"></i>', swappable: true, options: [{n: 'Botol Plastik', i: '<i class="fa-solid fa-bottle-water text-blue-300"></i>'}, {n: 'Plastik Kiloan', i: '<i class="fa-solid fa-bag-shopping text-pink-500"></i>'}] }
            ],
            instructions: {
                1: 'Gunakan HANYA air mineral kemasan yang segelnya belum rusak. Jangan gunakan air genangan atau banjir.',
                2: 'Jika tidak ada, tadah air hujan bersih secara langsung menggunakan wadah.',
                3: 'Dalam kondisi darurat di alam bebas, air kelapa muda bisa digunakan untuk membersihkan kotoran dari luka.',
                4: 'Tuang air ke dalam botol plastik bersih, lalu lubangi kecil bagian tutupnya.',
                5: 'Semprotkan air dengan tekanan ke arah luka terbuka (flushing) agar kotoran/kerikil terdorong keluar. JANGAN menggosok luka.'
            }
        },
        
        'Perban Darurat': {
            icon: '<i class="fa-solid fa-stethoscope text-gray-700"></i>',
            materials: [
                { name: 'Pembalut Wanita', role: 'Penyerap Darah', icon: '<i class="fa-solid fa-droplet text-red-600"></i>', swappable: true, options: [{n: 'Pembalut Wanita', i: '<i class="fa-solid fa-droplet text-red-600"></i>'}, {n: 'Tampon', i: '<i class="fa-solid fa-droplet text-red-600"></i>'}, {n: 'Kain Katun Bersih', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}] },
                { name: 'Baju Kaos Dalam', role: 'Kain Pengikat', icon: '<i class="fa-solid fa-shirt text-gray-300"></i>', swappable: true, options: [{n: 'Baju Kaos Dalam', i: '<i class="fa-solid fa-shirt text-gray-300"></i>'}, {n: 'Lakban (Duct Tape)', i: '<i class="fa-solid fa-tag text-gray-400"></i>'}, {n: 'Kain Panjang', i: '<i class="fa-solid fa-ribbon text-yellow-500"></i>'}] },
                { name: 'Plastik Bersih', role: 'Pelindung (Opsional)', icon: '<i class="fa-solid fa-bag-shopping text-pink-500"></i>', swappable: true, options: [{n: 'Plastik Bersih', i: '<i class="fa-solid fa-bag-shopping text-pink-500"></i>'}, {n: 'Jas Hujan', i: '<i class="fa-solid fa-vest text-orange-500"></i>'}] }
            ],
            instructions: {
                1: 'Gunakan pembalut wanita sebagai bantalan trauma (trauma pad) yang sangat efektif menyerap pendarahan berat.',
                2: 'Tempelkan bagian dalam penyerap tepat pada luka. Jika luka tusuk dalam, tampon dapat digunakan perlahan untuk menyumbat pendarahan di rongga.',
                3: 'Robek baju kaos dalam katun (yang tidak berlumpur) menjadi pita panjang sebagai pengikat bantalan.',
                4: 'Ikat dengan kencang tepat di atas bantalan pembalut untuk memberi tekanan (pressure) agar darah berhenti.',
                5: 'Jika robekan kain kurang panjang, gunakan lakban/duct tape untuk menahan pembalut. Untuk luka dada tembus, gunakan plastik lalu lakban 3 sisinya.'
            }
        },
        
        'Tandu Darurat': {
            icon: '<i class="fa-solid fa-bed text-blue-400"></i>',
            materials: [
                { name: 'Batang Pohon Tebal', role: 'Rangka Penyangga', icon: '<i class="fa-solid fa-tree text-amber-900"></i>', swappable: true, options: [{n: 'Batang Pohon', i: '<i class="fa-solid fa-tree text-amber-900"></i>'}, {n: 'Pipa Paralon', i: '<i class="fa-solid fa-crutch text-gray-400"></i>'}, {n: 'Pipa Besi Ringan', i: '<i class="fa-solid fa-screwdriver-wrench text-gray-500"></i>'}] },
                { name: 'Jaket Tebal (2x)', role: 'Kain Penahan', icon: '<i class="fa-solid fa-vest text-orange-500"></i>', swappable: true, options: [{n: 'Jaket Tebal', i: '<i class="fa-solid fa-vest text-orange-500"></i>'}, {n: 'Sarung Kuat', i: '<i class="fa-solid fa-person-dress text-pink-400"></i>'}, {n: 'Terpal / Tenda', i: '<i class="fa-solid fa-tent text-green-600"></i>'}] }
            ],
            instructions: {
                1: 'Cari DUA tiang penyangga yang lurus dan kokoh sepanjang minimal 2 meter (sesuaikan tinggi korban).',
                2: 'Siapkan 2 atau 3 jaket tebal ber-resleting kuat, atau 2 kain sarung utuh.',
                3: 'Metode Jaket: Balik bagian luar jaket ke dalam. Masukkan 2 tiang ke dalam kedua lengan jaket pertama, lalu resletingkan.',
                4: 'Ulangi langkah tersebut pada jaket kedua (dan ketiga) dengan posisi berhadapan agar area tubuh korban tertopang sempurna.',
                5: 'Metode Sarung: Masukkan kedua tiang melintasi lubang dua sarung secara sejajar.',
                6: 'Tarik kain hingga tegang. Tiang akan mengunci lipatan kain saat diberi beban. Uji coba dengan tubuh sehat sebelum mengangkat korban terluka.'
            }
        }
    };

    return {
        open: false,
        item: '',
        icon: '',
        materials: [],
        currentView: 'selection',
        currentStep: 1,
        touchStartX: 0,
        touchEndX: 0,

        openModal(data) {
            this.item = data.item;
            if (craftingData[data.item]) {
                this.icon = craftingData[data.item].icon;
                this.materials = JSON.parse(JSON.stringify(craftingData[data.item].materials));
            } else {
                this.icon = '<i class="fa-solid fa-screwdriver-wrench text-gray-600"></i>';
                this.materials = [];
            }
            this.currentView = 'selection';
            this.currentStep = 1;
            this.open = true;
            document.body.classList.add('modal-open');
        },

        getInstruction() {
            return craftingData[this.item]?.instructions[this.currentStep] || 'Lakukan langkah ini.';
        },

        switchMaterial(idx) {
            let m = this.materials[idx];
            let curIdx = m.options.findIndex(o => o.n === m.name);
            let next = m.options[(curIdx + 1) % m.options.length];
            m.name = next.n; 
            m.icon = next.i;
        },

        nextStep() { 
            if (craftingData[this.item] && this.currentStep < Object.keys(craftingData[this.item].instructions).length) {
                this.currentStep++; 
            }
        },

        prevStep() { 
            if (this.currentStep > 1) {
                this.currentStep--; 
            }
        },

        handleSwipe() {
            if (this.touchEndX < this.touchStartX - 50) this.nextStep();
            if (this.touchEndX > this.touchStartX + 50) this.prevStep();
        },

        closeModal() { 
            this.open = false; 
            document.body.classList.remove('modal-open'); 
        }
    }
}
</script>
@endpush