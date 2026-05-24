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

    /* ══════ MODAL FIXES (AMANKAN ALPINE.JS & UKURAN BOKS) ══════ */
    
    /* Overlay dikembalikan ke setelan standar tanpa memaksa display grid/flex */
    .modal-overlay {
        position: fixed !important;
        inset: 0 !important;
        background-color: rgba(16, 24, 32, 0.6) !important;
        z-index: 50 !important;
        padding: 20px !important;
    }

    /* Setelan ukuran modal utama agar lebar dan tingginya pas satu layar */
    .modal-box {
        position: relative;
        z-index: 51;  
        width: 100% !important; 
        max-width: 860px !important; 
        
        /* Kunci tinggi agar pas monitor PC dan tidak geser saat ganti step */
        height: 95vh !important; 
        max-height: 95vh !important;
        
        /* Membagi ruang header, body, dan footer di dalam modal */
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important; 
        
        background: var(--color-surface);
        border: 1px solid var(--color-border-md);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-lg);
        transform: none !important; 
        margin: 0 auto !important;
    }

    .modal-box.modal-box-lg { 
        max-width: 860px !important; 
    }

</style>
@endpush

@section('content')

{{-- ══════ HERO ══════ --}}
<section class="hero-bg min-h-[88vh] flex items-center" id="hero">
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 py-24 grid md:grid-cols-2 gap-12 items-center">
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
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: rgba(90,130,126,0.12);">
                <svg class="w-6 h-6" style="color: var(--c-teal);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="font-head font-bold text-xl mb-2" style="color: var(--color-text-primary);">Sebelum</h3>
            <p class="text-sm leading-relaxed" style="color: var(--color-text-secondary);">Siapkan tas siaga, cek lingkungan, dan latih respons sebelum bencana datang.</p>
            <div class="bar" style="background: var(--c-teal);"></div>
        </a>
        <a href="{{ route('saat') }}" class="phase-card reveal" style="animation-delay:0.1s">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: rgba(192,57,43,0.1);">
                <svg class="w-6 h-6" style="color: var(--color-danger);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 class="font-head font-bold text-xl mb-2" style="color: var(--color-text-primary);">Saat</h3>
            <p class="text-sm leading-relaxed" style="color: var(--color-text-secondary);">Panduan tindakan cepat berbasis decision tree. Tap — dan kamu tahu apa yang harus dilakukan.</p>
            <div class="bar" style="background: var(--color-danger);"></div>
        </a>
        <a href="{{ route('sesudah') }}" class="phase-card reveal" style="animation-delay:0.2s">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: rgba(39,174,96,0.1);">
                <svg class="w-6 h-6" style="color: #27AE60;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
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
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @php
            $bencana = [
                ['nama'=>'Gempa Bumi','icon'=>'🌍','ada'=>true],
                ['nama'=>'Tsunami','icon'=>'🌊','ada'=>false],
                ['nama'=>'Banjir','icon'=>'💧','ada'=>false],
                ['nama'=>'Gunung Meletus','icon'=>'🌋','ada'=>false],
                ['nama'=>'Tanah Longsor','icon'=>'⛰️','ada'=>false],
                ['nama'=>'Kebakaran','icon'=>'🔥','ada'=>false],
                ['nama'=>'Angin Puting','icon'=>'🌪️','ada'=>false],
                ['nama'=>'Kekeringan','icon'=>'☀️','ada'=>false],
            ];
            @endphp
            @foreach($bencana as $b)
            <button
                class="tutorial-item reveal"
                @if($b['ada']) @click="$dispatch('open-tutorial', { bencana: '{{ $b['nama'] }}' })" @else disabled @endif
            >
                <div class="text-4xl mb-3">{{ $b['icon'] }}</div>
                <p class="font-head font-semibold text-sm" style="color: var(--color-text-primary);">{{ $b['nama'] }}</p>
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
        <h2 class="font-head text-3xl font-bold" style="color: var(--color-text-primary);">Informasi & Survive</h2>
        <p class="mt-2" style="color: var(--color-text-muted);">Panduan satu langkah untuk bertahan hidup (Hanya butuh 1 barang)</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
        @foreach([
            ['🪢', 'Simpul Kilat', 'Panduan membuat simpul kuat darurat secara cepat hanya menggunakan seutas tali.'],
            ['🥫', 'Membuka Kaleng', 'Teknik membuka makanan kaleng darurat tanpa menggunakan alat pembuka khusus.'],
            ['🧭', 'Arah Mata Angin', 'Cara menentukan arah mata angin menggunakan metode navigasi alamiah.'],
            ['☀️', 'Baca Jam Matahari', 'Estimasi penunjuk waktu darurat dengan memanfaatkan bayangan dari sinar matahari.']
        ] as $info)
        <div @click="$dispatch('open-info', { type: 'Survive', item: '{{ $info[1] }}' })" 
             class="info-main-card reveal cursor-pointer p-5 rounded-2xl border" 
             style="background: var(--color-surface); border-color: var(--color-border);">
            <div class="preview-box h-48 rounded-xl flex items-center justify-center text-6xl mb-4 bg-opacity-5" style="background: var(--color-text-muted);">
                {{ $info[0] }}
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
                ['🧴', 'Filter Air', 'air-bersih'],
                ['🪝', 'Jerat Sederhana', 'jerat-makanan'],
                ['🔥', 'Korek Darurat', 'korek-api'],
                ['🧭', 'Kompas Sederha', 'kompas']
            ] as $craft)
            <button 
                @click="$dispatch('open-crafting', { type: 'Survival', item: '{{ $craft[1] }}', icon: '{{ $craft[0] }}' })"
                class="info-main-card reveal p-5 rounded-2xl border cursor-pointer transition-all hover:shadow-md hover:-translate-y-1"
                style="background: var(--color-surface); border-color: var(--color-border);">
                <div class="preview-box h-40 rounded-xl flex items-center justify-center text-5xl mb-4" style="background: rgba(var(--color-text-muted-rgb, 128,128,128), 0.1);">
                    {{ $craft[0] }}
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
                ['🩹', 'Kain Segitiga', 'kain-segitiga'],
                ['🧪', 'Cairan P3K', 'cairan-p3k'],
                ['🩺', 'Perban Darurat', 'perban-darurat'],
                ['💊', 'Kit Obat Medis', 'kit-obat']
            ] as $care)
            <button 
                @click="$dispatch('open-crafting', { type: 'Caregiver', item: '{{ $care[1] }}', icon: '{{ $care[0] }}' })"
                class="info-main-card reveal p-5 rounded-2xl border cursor-pointer transition-all hover:shadow-md hover:-translate-y-1"
                style="background: var(--color-surface); border-color: var(--color-border);">
                <div class="preview-box h-40 rounded-xl flex items-center justify-center text-5xl mb-4" style="background: rgba(var(--color-text-muted-rgb, 128,128,128), 0.1);">
                    {{ $care[0] }}
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
        $darurat = [
            ['Polisi','110','👮','#2C3E50'],['Ambulans','118','🚑','#C0392B'],
            ['Pemadam','113','🚒','#E67E22'],['BNPB','117','🆘','#27AE60'],
            ['SAR','115','⛑️','#2C3E50'],['PLN','123','⚡','#F39C12'],
            ['Pos Indonesia','161','📮','#7F8C8D'],['PDAM','119','💧','#2980B9'],
        ];
        @endphp
        @foreach($darurat as $d)
        <a href="tel:{{ $d[1] }}" class="darurat-card reveal">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                 style="background: {{ $d[3] }}1a;">{{ $d[2] }}</div>
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
@push('modals')

{{-- Modal: Tutorial Bencana --}}
<div
    x-data="tutorialModal()"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    @open-tutorial.window="openModal($event.detail.bencana)"
    class="modal-overlay"
>
    <div class="modal-backdrop" @click="closeModal()"></div>
    <div class="modal-box modal-box-lg flex flex-col justify-between" @click.stop>
        
        <div class="modal-header border-b border-slate-100 flex items-center justify-between px-6 py-4 bg-white rounded-t-2xl relative">
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
                <div class="w-full flex flex-col items-center flex-1 py-0"> <div class="flex items-center justify-center gap-6 mb-2 w-full select-none">
                        <button @click="prevStep()" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-800 transition-all">
                            <i class="fa-solid fa-chevron-left text-sm"></i>
                        </button>
                        <h3 class="text-base font-bold text-slate-800 tracking-tight text-center max-w-[550px] w-full min-h-[32px] flex items-center justify-center" x-text="currentQuestion()"></h3>
                        <button @click="nextStep()" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-800 transition-all">
                            <i class="fa-solid fa-chevron-right text-sm"></i>
                        </button>
                    </div>

                    {{-- Card interaktif diperbesar dengan max-w-2xl --}}
                    <div class="grid grid-cols-2 gap-6 w-full max-w-2xl mx-auto mb-0.5">
                        
                        <button @click="lokasi = 'dalam'" 
                                :class="lokasi === 'dalam' ? 'border-sky-500 bg-sky-50/30 ring-2 ring-sky-500/20' : 'border-slate-200 bg-white hover:bg-slate-50'"
                                class="relative rounded-xl border p-6 flex flex-col items-center text-center transition-all duration-200 group min-h-[340px]"> <div class="absolute top-4 right-4 flex items-center gap-1">
                                <span class="text-[10px] font-bold text-slate-400 group-hover:text-slate-600">Dalam ruangan</span>
                                <span :class="lokasi === 'dalam' ? 'bg-sky-500' : 'bg-slate-200'" class="w-2 h-2 rounded-full inline-block"></span>
                            </div>
                            
                            <div class="w-full h-56 rounded-lg overflow-hidden mt-6 mb-4 shadow-sm border border-slate-100">
                                <img src="/images/tutorial-gempa.jpg" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Dalam Ruangan">
                            </div>
                            <span class="text-base font-extrabold text-slate-700 tracking-wide mt-auto">Lindungi Kepala</span> </button>

                        <button @click="lokasi = 'luar'" 
                                :class="lokasi === 'luar' ? 'border-teal-500 bg-teal-50/30 ring-2 ring-teal-500/20' : 'border-slate-200 bg-white hover:bg-slate-50'"
                                class="relative rounded-xl border p-6 flex flex-col items-center text-center transition-all duration-200 group min-h-[340px]"> <div class="absolute top-4 right-4 flex items-center gap-1">
                                <span class="text-[10px] font-bold text-slate-400 group-hover:text-slate-600">Luar ruangan</span>
                                <span :class="lokasi === 'luar' ? 'bg-teal-500' : 'bg-slate-200'" class="w-2 h-2 rounded-full inline-block"></span>
                            </div>
                            
                            <div class="w-full h-56 rounded-lg overflow-hidden mt-6 mb-4 shadow-sm border border-slate-100">
                                <img src="/images/tutorial-gempa.jpg" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Luar Ruangan">
                            </div>
                            <span class="text-base font-extrabold text-slate-700 tracking-wide mt-auto">Jauhi Benda Rawan</span> </button>

                    </div>

                    <div class="w-full max-w-2xl bg-slate-50 rounded-xl p-4 border border-slate-100 text-center">
                        <p class="text-xs font-medium text-slate-600 leading-relaxed" x-text="currentDescription()"></p>
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
        <div x-show="fase === 'saat'" class="border-t border-slate-200 px-6 py-4 bg-slate-50 rounded-b-2xl flex flex-col items-center justify-center">
            <div class="flex items-center justify-center gap-2 flex-wrap">
                <template x-for="(item, index) in getSteps()" :key="index">
                    <button @click="currentStep = index" 
                            :class="currentStep === index ? 'bg-slate-800 text-white scale-105 shadow-sm' : 'bg-slate-200 text-slate-500 hover:bg-slate-300'"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-black transition-all duration-150">
                        <span x-show="index === 0" class="flex items-center justify-center gap-0.5 text-[10px]">
                            <i class="fa-solid fa-house-chimney text-[9px]"></i><span x-text="index+1"></span>
                        </span>
                        <span x-show="index !== 0" x-text="index+1"></span>
                    </button>
                </template>
            </div>
        </div>
        
        {{-- FOOTER 2: Dikasih x-show agar HANYA muncul saat BUKAN fase 'saat' (Sebelum & Sesudah) --}}
        <div x-show="fase !== 'saat'" class="border-t border-slate-100 px-6 py-3 bg-slate-50/50 rounded-b-2xl flex items-center justify-center">
            <div class="flex items-center justify-center gap-2 flex-wrap">
                {{-- Looping angka berdasarkan jumlah langkah yang ada --}}
                <template x-for="(item, index) in getSteps()" :key="index">
                    <button @click="currentStep = index" 
                            :class="currentStep === index ? 'bg-slate-800 text-white scale-105 shadow-sm' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50'"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-black transition-all duration-150">
                        <span x-text="index + 1"></span>
                    </button>
                </template>
            </div>
        </div>

    </div>
</div>

{{-- Modal: Info / Caregiver --}}
<div
    x-data="infoModal()"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    @open-info.window="openModal($event.detail)"
    class="modal-overlay"
>
    <div class="modal-backdrop" @click="closeModal()"></div>
    <div class="modal-box flex flex-col justify-between" @click.stop>
        <div class="modal-header border-b border-slate-100 px-6 py-4 bg-white rounded-t-2xl flex justify-between items-center">
            <div>
                <p class="text-[10px] uppercase tracking-widest font-black text-slate-400" x-text="type"></p>
                <h2 class="modal-title mt-0.5 text-lg font-bold text-slate-800" x-text="item"></h2>
            </div>
            <button @click="closeModal()" class="modal-close text-slate-400 hover:text-rose-600">✕</button>
        </div>
        <div class="modal-body flex-1 p-6 overflow-y-auto flex flex-col justify-center">
            <div class="w-full h-44 rounded-2xl flex items-center justify-center text-6xl mb-4 bg-slate-50 border border-slate-100">🧰</div>
            <p class="text-sm leading-relaxed text-slate-600 text-center max-w-md mx-auto" x-text="description"></p>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 rounded-b-2xl text-center">
            <button @click="closeModal()" class="px-6 h-9 rounded-xl text-white font-bold text-xs bg-slate-800 hover:bg-slate-900 transition-colors">Tutup Panduan</button>
        </div>
    </div>
</div>

{{-- Modal: Crafting --}}
<div
    x-data="craftingModal()"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    @open-crafting.window="openModal($event.detail)"
    class="modal-overlay"
>
    <div class="modal-backdrop" @click="closeModal()"></div>
    <div class="modal-box modal-box-lg flex flex-col justify-between" @click.stop>
        <div class="modal-header border-b border-slate-100 px-6 py-4 bg-white rounded-t-2xl flex justify-between items-center">
            <div>
                <p class="text-[10px] uppercase tracking-widest font-black" :style="type==='Survival'?'color:var(--c-teal)':'color:#27AE60'" x-text="'Crafting ' + type"></p>
                <h2 class="modal-title mt-0.5 text-lg font-bold text-slate-800" x-text="item"></h2>
            </div>
            <button @click="closeModal()" class="modal-close text-slate-400 hover:text-rose-600">✕</button>
        </div>
        <div class="modal-body flex-1 p-6 overflow-y-auto">
            <div class="grid md:grid-cols-[300px_1px_1fr] gap-6 items-stretch">
                
                {{-- Kolom Kiri: Icon Besar --}}
                <div class="flex flex-col justify-between items-center p-6 rounded-2xl relative" style="background: rgba(var(--color-text-muted-rgb, 128,128,128), 0.1); min-height: 280px;">
                    <div class="my-auto text-7xl select-none" x-text="icon"></div>
                    <div class="w-full text-center">
                        <span class="inline-block bg-white text-gray-900 px-6 py-2 rounded-full font-bold text-sm tracking-wide shadow-sm" x-text="item">
                        </span>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="hidden md:block w-[1px] bg-gray-300 my-4 opacity-60"></div>

                {{-- Kolom Kanan: Bahan Grid --}}
                <div class="p-5 rounded-2xl flex flex-col justify-center" style="background: rgba(var(--color-text-muted-rgb, 128,128,128), 0.05);">
                    <div class="grid grid-cols-2 gap-4">
                        <template x-for="(material, idx) in materials" :key="idx">
                            <div class="bg-white rounded-xl p-5 flex flex-col items-center justify-center relative shadow-sm border border-gray-100 min-h-[110px]">
                                <template x-if="material.swappable">
                                    <button @click.stop="$dispatch('swap-material', { target: material.name })" 
                                            class="absolute top-2 right-2 w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded-md flex items-center justify-center text-gray-500 hover:text-gray-800 transition shadow-xs text-sm"
                                            title="Pilih bahan alternatif">
                                        ⇅
                                    </button>
                                </template>
                                <div class="text-4xl mb-2 select-none" x-text="material.icon"></div>
                                <p class="text-xs font-bold text-center text-gray-700" x-text="material.name"></p>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 rounded-b-2xl text-right">
            <button @click="closeModal()" class="px-5 h-9 rounded-xl text-white font-bold text-xs bg-slate-800 hover:bg-slate-900 transition-colors">Selesai Menyimak</button>
        </div>
    </div>
</div>

@endpush

@push('scripts')
<script>
    gsap.from('#hero-text > *', { opacity: 0, y: 40, stagger: 0.15, duration: 0.9, ease: 'power3.out', delay: 0.2 });
    gsap.from('#hero-img',      { opacity: 0, scale: 0.9, duration: 1, ease: 'power3.out', delay: 0.4 });
    gsap.from('#scroll-hint',   { opacity: 0, y: 10, duration: 1, delay: 1.2, ease: 'power2.out' });

    function tutorialModal() {
        return {
            open: false, bencana: '', fase: 'saat', currentStep: 0, lokasi: 'dalam',
            openModal(nama) { this.bencana = nama; this.fase = 'saat'; this.currentStep = 0; this.lokasi = 'dalam'; this.open = true; document.body.classList.add('modal-open'); },
            closeModal()    { this.open = false; document.body.classList.remove('modal-open'); },
            steps: {
                'Gempa Bumi': {
                    ambang: ['Identifikasi benda yang rawan jatuh dan amankan.','Siapkan tas siaga dan dokumen penting.','Latih simulasi evakuasi keluarga.'],
                    sebelum: ['Identifikasi benda yang rawan jatuh dan amankan.','Siapkan tas siaga dan dokumen penting.','Latih simulasi evakuasi keluarga.'],
                    saat: [
                        { question: 'Apa yang harus dilakukan saat guncangan pertama terasa?', description: 'Segera jatuhkan badan ke lantai agar tidak kehilangan keseimbangan akibat getaran.' },
                        { question: 'Dimana tempat paling aman saat gempa berlangsung?', description: 'Berlindung di bawah meja kokoh atau lindungi kepala dan jauhi kaca.' },
                        { question: 'Apa yang harus dilakukan setelah guncangan berhenti?', description: 'Keluar menuju area terbuka dengan tenang, hindari bangunan dan kabel listrik.' }
                    ],
                    sesudah: ['Periksa kondisi diri dan keluarga.','Waspada gempa susulan.','Ikuti informasi resmi dari BMKG dan BNPB.']
                }
            },
            getSteps()          { return this.steps[this.bencana]?.[this.fase] ?? []; },
            currentQuestion()   { return this.getSteps()[this.currentStep]?.question ?? ''; },
            currentDescription(){ return this.getSteps()[this.currentStep]?.description ?? ''; },
            nextStep() { if (this.currentStep < this.getSteps().length - 1) this.currentStep++; },
            prevStep() { if (this.currentStep > 0) this.currentStep--; }
        }
    }

    function infoModal() {
        const desc = {
            'Kain Segitiga': 'Digunakan untuk menopang tangan cedera atau sebagai perban darurat di lapangan.',
            'CPR': 'Teknik pertolongan pertama untuk membantu pernapasan dan sirkulasi darah saat darurat.',
            'Perban': 'Digunakan menutup luka agar tidak terinfeksi dan membantu menghentikan pendarahan.',
            'Obat Darurat': 'Persediaan medis dasar termasuk antiseptik, penghilang nyeri, dan obat demam.'
        };
        return {
            open: false, type: '', item: '', description: '',
            openModal(data) { this.open = true; this.type = data.type; this.item = data.item; this.description = desc[data.item] || 'Informasi belum tersedia.'; document.body.classList.add('modal-open'); },
            closeModal()    { this.open = false; document.body.classList.remove('modal-open'); }
        }
    }

    function craftingModal() {
        const craftingData = {
            'Survival': {
                'Filter Air': {
                    icon: '🧴',
                    materials: [
                        {icon: '🧴', name: 'Botol Plastik', swappable: true},
                        {icon: '🔥', name: 'Arang Aktif', swappable: true},
                        {icon: '🪨', name: 'Kerikil / Batu', swappable: false},
                        {icon: '🌾', name: 'Pasir Bersih', swappable: true}
                    ]
                },
                'Jerat Sederhana': {
                    icon: '🪝',
                    materials: [
                        {icon: '🪢', name: 'Tali/Benang', swappable: true},
                        {icon: '🌿', name: 'Ranting', swappable: false},
                        {icon: '🔧', name: 'Batu Tajam', swappable: true},
                        {icon: '🪵', name: 'Kayu Konstruksi', swappable: false}
                    ]
                },
                'Korek Darurat': {
                    icon: '🔥',
                    materials: [
                        {icon: '🪵', name: 'Kayu Kering', swappable: false},
                        {icon: '🪨', name: 'Batu Kersik', swappable: true},
                        {icon: '🍃', name: 'Daun/Rumput', swappable: true},
                        {icon: '💨', name: 'Udara Kering', swappable: false}
                    ]
                },
                'Kompas Sederha': {
                    icon: '🧭',
                    materials: [
                        {icon: '⚡', name: 'Magnet/Logam', swappable: false},
                        {icon: '🪡', name: 'Jarum Logam', swappable: true},
                        {icon: '💧', name: 'Air/Minyak', swappable: true},
                        {icon: '🍃', name: 'Daun Apung', swappable: true}
                    ]
                }
            },
            'Caregiver': {
                'Kain Segitiga': {
                    icon: '🩹',
                    materials: [
                        {icon: '🧣', name: 'Kain Slayer', swappable: true},
                        {icon: '✂️', name: 'Gunting Steril', swappable: false},
                        {icon: '🧷', name: 'Peniti', swappable: true},
                        {icon: '🧼', name: 'Antiseptik', swappable: false}
                    ]
                },
                'Cairan P3K': {
                    icon: '🧪',
                    materials: [
                        {icon: '🧴', name: 'Botol Steril', swappable: true},
                        {icon: '💧', name: 'Air Matang', swappable: false},
                        {icon: '🧂', name: 'Garam/Antiseptik', swappable: true},
                        {icon: '🧹', name: 'Pengaduk', swappable: true}
                    ]
                },
                'Perban Darurat': {
                    icon: '🩺',
                    materials: [
                        {icon: '🧻', name: 'Kain Steril', swappable: true},
                        {icon: '🧵', name: 'Benang/Tali', swappable: true},
                        {icon: '🧼', name: 'Antiseptik', swappable: false},
                        {icon: '✂️', name: 'Gunting', swappable: true}
                    ]
                },
                'Kit Obat Medis': {
                    icon: '💊',
                    materials: [
                        {icon: '💊', name: 'Obat Darurat', swappable: false},
                        {icon: '🩹', name: 'Plester Luka', swappable: true},
                        {icon: '🧴', name: 'Cairan Pembersih', swappable: true},
                        {icon: '🧷', name: 'Pengikat', swappable: true}
                    ]
                }
            }
        };

        return {
            open: false,
            type: '',
            item: '',
            icon: '',
            materials: [],
            openModal(data) {
                this.type = data.type;
                this.item = data.item;
                this.icon = data.icon;
                
                const itemData = craftingData[data.type]?.[data.item];
                if (itemData) {
                    this.materials = itemData.materials;
                }
                
                this.open = true;
                document.body.classList.add('modal-open');
            },
            closeModal() {
                this.open = false;
                document.body.classList.remove('modal-open');
            }
        }
    }
</script>
@endpush