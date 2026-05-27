@extends('layouts.app')

@section('title', 'Saat Bencana')

@section('content')

<style>

    [x-cloak] {
        display: none !important;
    }

    /* ====================================================
        SAAT PAGE — RED & BEIGE PALETTE
    ==================================================== */
    :root {
        --c-dark-red:   #7D0A0A;
        --c-red:        #BF3131;
        --c-beige:      #EAD196;
        --c-light:      #EEEEEE;
        
        --c-dark-red-dk: #580707;
        --c-red-light:   #d85a5a;
        --c-beige-dk:    #d6bc7d;
        --c-light-dk:    #dcdcdc;
    }

    .saat-bg{
        background:
            radial-gradient(circle at top left, rgba(191,49,49,.14), transparent 28%),
            radial-gradient(circle at bottom right, rgba(125,10,10,.18), transparent 35%),
            linear-gradient(135deg, #f5f1eb 0%, #fffbf5 100%);
        position:relative;
        overflow:hidden;
    }

    .saat-bg::before{
        content:'';
        position:absolute;
        inset:0;
        background-image:
            linear-gradient(rgba(125,10,10,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(125,10,10,.04) 1px, transparent 1px);
        background-size:40px 40px;
        opacity:.5;
    }

    .rust-card{
        background: var(--c-light);
        border: 1px solid rgba(191,49,49,.12);
        box-shadow:
            0 12px 40px rgba(125,10,10,.08),
            inset 0 1px 0 rgba(255,255,255,.7);
    }

    .tutorial-card{
        transition:.25s ease;
        cursor:pointer;
        overflow:hidden;
        position:relative;
    }

    .tutorial-card:hover{
        transform:translateY(-6px);
        box-shadow:0 18px 50px rgba(191,49,49,.16);
    }

    .tutorial-card::after{
        content:'';
        position:absolute;
        inset:0;
        border:1px solid rgba(191,49,49,.18);
        border-radius:28px;
        pointer-events:none;
    }

    .visual-box{
        background: var(--c-beige);
        border-radius:20px;
    }

    .phase-badge{
        background: var(--c-red);
        color:white;
    }

    .popup-bg{
        background:rgba(0,0,0,.68);
        backdrop-filter:blur(12px);
    }

    .modal-overlay {
        position: fixed !important;
        inset: 0 !important;
        background-color: rgba(0, 0, 0, 0.6) !important;
        backdrop-filter: blur(10px) !important;
        z-index: 50 !important;
        padding: 20px !important;
        display: flex;            /* !important dihapus */
        align-items: center;      /* !important dihapus */
        justify-content: center;  /* !important dihapus */
    }

    .modal-box {
        position: relative;
        z-index: 51;
        width: 100% !important;
        max-width: 860px !important;
        display: flex !important;
        flex-direction: column !important;
        background: var(--c-light);
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        transform: none !important;
        margin: 0 auto !important;
        touch-action: pan-y;
    }

    .question-container{
        display:flex;
        flex-direction:column;
        position:relative;
        overflow:hidden;
    }

    .question-slide{
        animation: slideInFromRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .question-slide.exit-right{
        animation: slideOutToLeft 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .question-slide.exit-left{
        animation: slideOutToRight 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes slideInFromRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutToLeft {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(-100px);
        }
    }

    @keyframes slideOutToRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .modal-box {
            max-width: 100% !important;
            border-radius: 20px;
            margin: 0 10px !important;
        }

        .modal-box > .grid {
            grid-template-columns: 1fr !important;
        }

        .modal-box .p-8 {
            padding: 16px !important;
        }
    }

    .modal-backdrop {
        position: absolute;
        inset: 0;
        background: transparent;
        cursor: pointer;
    }

    .popup-panel{
        background: var(--c-light);
        border-radius:32px;
        overflow:hidden;
    }

    .question-option{
        border: 1px solid rgba(191,49,49,.12);
        transition:.2s ease;
        background:white;
        cursor: default;
    }

    .question-option:hover{
        border-color: rgba(191,49,49,.12);
        transform: none;
    }

    .question-option:active{
        transform:scale(0.98);
    }

    .step-btn{
        width:44px;
        height:44px;
        border-radius:12px;
        background: var(--c-beige);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:.9rem;
        font-weight:700;
        transition:.2s ease;
        cursor:pointer;
        border:2px solid transparent;
    }

    .step-btn.active{
        background: var(--c-red);
        color:white;
        box-shadow: 0 4px 12px rgba(191,49,49,.3);
    }

    .step-btn:hover:not(.active){
        background: rgba(191,49,49,.08);
    }

    .nav-arrow{
        width:56px;
        height:56px;
        border-radius:16px;
        background: var(--c-beige);
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition:.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border:none;
        box-shadow: 0 4px 12px rgba(191,49,49,.12);
        padding:0;
    }

    .nav-arrow:hover{
        background: var(--c-red);
        transform: scale(1.08) translateY(-2px);
        box-shadow: 0 8px 24px rgba(191,49,49,.25);
    }

    .nav-arrow:active{
        transform: scale(0.95);
    }

    .nav-arrow svg{
        width:24px;
        height:24px;
        stroke-width:3;
        stroke-linecap:round;
        stroke-linejoin:round;
        transition: inherit;
    }

    .done-btn{
        background: var(--c-red);
        color:white;
        transition:.2s ease;
    }

    .done-btn:hover{
        background: var(--c-dark-red);
    }

    .injury-btn{
        transition:.2s ease;
        background:white;
        border: 1px solid rgba(191,49,49,.12);
    }

    .injury-btn:hover{
        transform:translateY(-4px);
        border-color: var(--c-red);
    }

</style>

<div
    x-data="saatPage()"

    {{-- TUTORIAL --}}
    <section>

        <div class="max-w-6xl mx-auto px-5">

            <div class="text-center mb-12 mt-14">

                <h2 class="font-head text-4xl md:text-5xl font-black" style="color: var(--c-dark-red)">
                    Tutorial
                </h2>
                
                {{-- Gw tambahin sub-judul tipis biar nggak terlalu kosong di bawah judul --}}
                <p class="text-gray-500 mt-3 text-sm md:text-base">Pilih simulasi bencana untuk memulai panduan</p>

            </div>

            <div class="grid md:grid-cols-2 gap-6 md:gap-8">

                <template x-for="item in disasters">

                    {{-- Tambahin class 'group' di pembungkus utama biar bisa trigger animasi barengan --}}
                    <button
                        @click="startDisaster(item)"
                        class="tutorial-card rust-card group rounded-[28px] md:rounded-[32px] p-5 md:p-6 text-left flex gap-5 md:gap-6 items-center transition-all"
                    >

                        {{-- Icon Box dibikin lebih proporsional --}}
                        <div class="visual-box w-24 h-24 md:w-28 md:h-28 rounded-[20px] md:rounded-[24px] flex items-center justify-center text-4xl md:text-5xl flex-shrink-0 shadow-inner">
                            <span x-text="item.icon"></span>
                        </div>

                        <div class="flex-1 w-full">

                            <div class="flex items-center justify-between gap-3 mb-2 md:mb-3">

                                {{-- Judul dikasih transisi: pas di hover berubah merah --}}
                                <h3
                                    class="font-head text-xl md:text-2xl font-black text-gray-800 group-hover:text-[#BF3131] transition-colors"
                                    x-text="item.name"
                                ></h3>

                                {{-- Panah Baru: Diganti SVG keren. Kalau card di hover, panahnya maju ke kanan (group-hover:translate-x-2) --}}
                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center shrink-0 transition-all duration-300 group-hover:translate-x-2 group-hover:shadow-md" style="background: var(--c-light); border: 1px solid var(--c-beige-dk);">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--c-red)" class="w-5 h-5 md:w-6 md:h-6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>

                            </div>

                            <p
                                class="text-sm md:text-base text-gray-500 leading-relaxed mb-4 md:mb-5 line-clamp-2"
                                x-text="item.desc"
                            ></p>

                            <div class="flex gap-2 flex-wrap">

                                <template x-for="tag in item.tags">
                                    {{-- UI Tag diperhalus dengan border tipis --}}
                                    <span class="px-3 py-1.5 rounded-full text-[11px] md:text-xs font-bold tracking-wide" style="background: rgba(191,49,49,.08); color: var(--c-red-light); border: 1px solid rgba(191,49,49,.1);">
                                        <span x-text="tag"></span>
                                    </span>
                                </template>

                            </div>

                        </div>

                    </button>

                </template>

            </div>

        </div>

    </section>

    {{-- =========================================
        POPUP QUESTION FLOW (Palette Saat Bencana)
    ========================================== --}}
    <template x-teleport="body" @teleport="$nextTick(() => {})">
        <div
            x-show="popup"
            style="display: none"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="modal-overlay"
        >
            <div class="modal-backdrop" @click="popup = false"></div>

            <div
                @click.stop
                class="modal-box w-full max-w-4xl bg-white rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col relative"
            >

                {{-- 1. HEADER --}}
                <div class="px-6 py-4 md:py-5 border-b flex justify-between items-center bg-white shrink-0" style="border-color: var(--c-light);">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl" x-text="currentDisasterIcon"></span>
                        <h3 class="font-head text-lg md:text-xl font-black" style="color: var(--c-dark-red);" x-text="currentDisasterName"></h3>
                    </div>
                    <button @click="popup = false" class="w-8 h-8 rounded-full flex items-center justify-center transition-colors hover:opacity-80" style="background: var(--c-light); color: var(--c-dark-red);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Area konten yang bisa di swipe --}}
                <div class="flex-1 overflow-y-auto flex flex-col" @touchstart="handleTouchStart" @touchend="handleTouchEnd" @touchmove="handleTouchMove">
                    
                    {{-- 2. QUESTION NAVIGATION ROW (Panah Diperjelas) --}}
                    <div class="px-6 md:px-12 pt-8 pb-6 flex items-center justify-between shrink-0">
                        {{-- Tombol Kiri --}}
                        <button @click="prevQuestion" class="w-10 h-10 shrink-0 rounded-full border-2 flex items-center justify-center transition-all hover:scale-105" style="border-color: var(--c-beige); color: var(--c-dark-red); background: white;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        
                        <div class="text-center px-4">
                            <span class="text-xs uppercase tracking-[.25em] block mb-1 font-bold" style="color: var(--c-red);" x-text="currentQuestion.title"></span>
                            <h2 class="font-head text-xl md:text-2xl font-black text-gray-800" x-text="currentQuestion.description"></h2>
                        </div>

                        {{-- Tombol Kanan --}}
                        <button @click="nextQuestion" class="w-10 h-10 shrink-0 rounded-full border-2 flex items-center justify-center transition-all hover:scale-105" style="border-color: var(--c-beige); color: var(--c-dark-red); background: white;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>

                    {{-- 3. OPTIONS GRID --}}
                    <div class="px-6 md:px-12 grid grid-cols-2 gap-4 md:gap-6 shrink-0">
                        <template x-for="choice in currentQuestion.options">
                            <button @click="selectedChoice = choice"
                                class="relative w-full rounded-[20px] border-2 p-4 md:p-5 flex flex-col transition-all bg-white hover:shadow-sm"
                                :style="selectedChoice === choice ? 'border-color: var(--c-red); box-shadow: 0 8px 30px rgba(191,49,49,0.12); transform: scale(1.02); z-index: 10;' : 'border-color: var(--c-light);'">
                                
                                <div class="absolute top-4 right-4 flex items-center gap-2">
                                    <span class="text-[10px] md:text-xs font-bold uppercase tracking-wide" 
                                          :style="selectedChoice === choice ? 'color: var(--c-red);' : 'color: var(--c-beige);'" 
                                          x-text="choice.label"></span>
                                    <div class="w-2.5 h-2.5 rounded-full transition-colors" 
                                         :style="selectedChoice === choice ? 'background: var(--c-red);' : 'background: var(--c-beige);'"></div>
                                </div>

                                <div class="w-full h-32 md:h-48 mt-8 mb-4 md:mb-6 rounded-xl flex items-center justify-center text-6xl md:text-7xl transition-colors border border-black/5"
                                    :style="selectedChoice === choice ? 'background: rgba(191,49,49,0.05);' : 'background: var(--c-light);'">
                                    <span class="drop-shadow-sm" x-text="choice.icon"></span>
                                </div>

                                <h3 class="font-bold text-sm md:text-lg text-gray-800 text-center w-full leading-tight" x-text="choice.desc"></h3>
                            </button>
                        </template>
                    </div>

                </div>

                {{-- 5. FOOTER (Warna terintegrasi) --}}
                <div class="px-6 md:px-12 py-5 border-t flex flex-wrap items-center justify-center md:justify-between gap-4 shrink-0" style="background: #FAFAFA; border-color: var(--c-light);">
                    
                    <div class="flex flex-wrap justify-center gap-2">
                        <template x-for="(step, index) in questions">
                            <button @click="goQuestion(index)"
                                class="h-9 md:h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-all duration-300 shadow-sm border"
                                {{-- Jika aktif: padding dilebarkan. Jika tidak: lebarnya dikunci kotak (w-9) --}}
                                :class="currentStep === index ? 'px-3.5 md:px-4' : 'w-9 md:w-10 px-0'"
                                :style="currentStep === index ? 'background: var(--c-dark-red); color: white; border-color: var(--c-dark-red);' : 'background: white; color: var(--c-red); border-color: var(--c-beige);'">
                                
                                {{-- Ikon FontAwesome (Hanya muncul jika tombol sedang aktif) --}}
                                <i x-show="currentStep === index" 
                                   :class="step.navIcon" 
                                   class="mr-1.5 md:mr-2 text-[11px] md:text-[13px]"></i>
                                
                                {{-- Angka --}}
                                <span x-text="index + 1"></span>
                                
                            </button>
                        </template>
                    </div>

                    <button x-show="currentStep < questions.length - 1" @click="nextQuestion"
                        class="w-full md:w-auto px-10 py-3 md:py-3.5 rounded-xl font-bold text-white shadow-md transition-transform hover:-translate-y-0.5 active:scale-95" style="background: var(--c-red);">
                        Selanjutnya
                    </button>
                    <button x-show="currentStep === questions.length - 1" @click="finishFlow"
                        class="w-full md:w-auto px-10 py-3 md:py-3.5 rounded-xl font-bold text-white shadow-md transition-transform hover:-translate-y-0.5 active:scale-95" style="background: var(--c-dark-red);">
                        Selesai
                    </button>

                </div>

            </div>
        </div>
    </template>

    {{-- =========================================
        POPUP PERTANYAAN TERLUKA
    ========================================== --}}
    <template x-teleport="body" @teleport="$nextTick(() => {})">
        <div
            x-show="injuryPopup"
            style="display: none"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-6"
        >
            {{-- Background Gelap --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="injuryPopup = false"></div>

            {{-- Kotak Modal Utama --}}
            {{-- relative dan z-10 agar posisinya di atas background gelap --}}
            <div
                @click.stop
                class="relative z-10 bg-white w-full max-w-lg rounded-[24px] md:rounded-[32px] p-8 md:p-10 shadow-2xl flex flex-col items-center justify-center text-center"
            >
                
                {{-- Judul dan Deskripsi --}}
                <div class="mb-8 md:mb-10">
                    <h2 class="font-head text-3xl md:text-4xl font-black mb-3 md:mb-4">
                        Ada yang terluka?
                    </h2>
                    <p class="text-sm md:text-base text-gray-500 leading-relaxed">
                        Cek kondisi sekitar. Jika ada yang terluka, kami arahkan ke panduan penanganan (Caregiver).
                    </p>
                </div>

                {{-- Pilihan Tombol (Ya/Tidak) --}}
                {{-- Grid 2 kolom yang rapi dengan jarak (gap-4) --}}
                <div class="grid grid-cols-2 gap-4 md:gap-6 w-full">
                    
                    {{-- Tombol Tida, Aman --}}
                    <button 
                        @click="goSupply()" 
                        class="injury-btn rounded-[16px] md:rounded-[20px] p-4 md:p-6 flex flex-col items-center justify-center text-center transition-all bg-gray-50 hover:bg-gray-100"
                    >
                        <h3 class="font-bold text-sm md:text-base">Tidak</h3>
                    </button>

                    {{-- Tombol Ya, Ada --}}
                    <button 
                        @click="openInjurySelect()" 
                        class="injury-btn rounded-[16px] md:rounded-[20px] p-4 md:p-6 flex flex-col items-center justify-center text-center transition-all bg-red-50 hover:bg-red-100"
                    >
                        <h3 class="font-bold text-sm md:text-base text-red-700">Ya</h3>
                    </button>

                </div>

            </div>
        </div>
    </template>

    {{-- =========================================
        POPUP JENIS LUKA
    ========================================== --}}
    <template x-teleport="body" @teleport="$nextTick(() => {})">
        <div
            x-show="caregiverPopup"
            style="display: none"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="modal-overlay"
        >
            <div class="modal-backdrop" @click="caregiverPopup = false"></div>

            <div
                @click.stop
                class="modal-box"
            >

                {{-- Padding diubah agar lebih ramah untuk HP (p-6) dan tetap lega di Desktop (md:p-10) --}}
                <div class="p-6 md:p-10">

                    <div class="text-center mb-14 mt-8 md:mb-10">

                        <h2 class="font-head text-3xl md:text-4xl font-black mb-2 md:mb-3">
                            Jenis Luka
                        </h2>

                        <p class="text-sm md:text-base text-gray-500">
                            Pilih luka untuk pindah ke caregiver
                        </p>

                    </div>

                    {{-- INI KUNCINYA: grid-cols-2 (untuk HP/Mobile) dan md:grid-cols-4 (untuk Desktop) --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">

                        <template x-for="injury in injuries">

                            {{-- flex-col dan justify-center ditambah agar konten rata tengah sempurna walau kotaknya membesar --}}
                            <button
                                @click="goCaregiver(injury)"
                                class="injury-btn rounded-[16px] md:rounded-[20px] p-4 md:p-5 mt-4 flex flex-col items-center justify-center text-center w-full"
                            >

                                <div class="text-4xl md:text-5xl mb-2 md:mb-4" x-text="injury.icon"></div>

                                <h3 class="font-bold text-sm" x-text="injury.name"></h3>

                            </button>

                        </template>

                    </div>

                </div>

            </div>

        </div>
    </template>

</div>

<script>

function saatPage(){

    return{

        popup:false,
        injuryPopup:false,
        caregiverPopup:false,

        currentStep:0,
        selectedChoice:null,

        touchStartX:0,
        touchEndX:0,
        touchStartY:0,
        touchEndY:0,

        // Tambahkan 2 variabel ini di bawah touchEndY: 0,
        currentDisasterName: '',
        currentDisasterIcon: '',

        // ...

        // Update fungsi startDisaster menjadi seperti ini:
        startDisaster(item){
            this.currentDisasterName = item.name;
            this.currentDisasterIcon = item.icon;
            this.currentStep = 0;
            this.selectedChoice = null; // Reset pilihan setiap buka baru
            this.popup = true;
        },

        disasters:[
            {
                name:'Gempa Bumi',
                icon:'🌍',
                desc:'Decision tree cepat untuk kondisi gempa bumi.',
                tags:['Shelter','Evakuasi','Drop Cover Hold']
            },
            {
                name:'Banjir',
                icon:'🌊',
                desc:'Panduan mencari tempat tinggi dan menghindari arus.',
                tags:['Air','Evakuasi']
            },
            {
                name:'Kebakaran',
                icon:'🔥',
                desc:'Evakuasi asap dan mencari jalur keluar.',
                tags:['Asap','Api']
            },
            {
                name:'Tsunami',
                icon:'🌊',
                desc:'Menuju dataran tinggi secepat mungkin.',
                tags:['Evakuasi','Pantai']
            }
        ],

        questions:[
            {
                title:'Dimana?',
                visual:'🏢',
                caption:'Lokasi Saat Ini',
                description:'Pilih kondisi lokasi kamu saat gempa terjadi.',
                navIcon: 'fa-solid fa-location-dot', // <-- TAMBAH INI
                options:[
                    { label:'Luar Ruangan', icon:'🌳', desc:'Jauhi benda rawan jatuh.' },
                    { label:'Dalam Ruangan', icon:'🏠', desc:'Lindungi kepala.' }
                ]
            },
            {
                title:'Berapa Orang?',
                visual:'👥',
                caption:'Cek Sekitar',
                description:'Pastikan siapa saja berada dekat denganmu.',
                navIcon: 'fa-solid fa-users', // <-- TAMBAH INI (Ikon orang banyak)
                options:[
                    { label:'Sendiri', icon:'🧍', desc:'Fokus evakuasi diri.' },
                    { label:'Bersama Orang', icon:'👨‍👩‍👧', desc:'Bantu kelompok.' }
                ]
            },
            {
                title:'Ada Anak?',
                visual:'🧒',
                caption:'Prioritas Evakuasi',
                description:'Anak dan lansia harus diprioritaskan.',
                navIcon: 'fa-solid fa-child-reaching', // <-- TAMBAH INI (Ikon anak)
                options:[
                    { label:'Ada', icon:'🧒', desc:'Bantu lebih dulu.' },
                    { label:'Tidak Ada', icon:'👌', desc:'Lanjut evakuasi.' }
                ]
            },
            {
                title:'Akses Keluar?',
                visual:'🚪',
                caption:'Cari Jalur Aman',
                description:'Periksa jalur evakuasi.',
                navIcon: 'fa-solid fa-door-open', // <-- TAMBAH INI
                options:[
                    { label:'Terbuka', icon:'🚪', desc:'Segera keluar.' },
                    { label:'Tertutup', icon:'🪨', desc:'Cari jalur alternatif.' }
                ]
            },
            {
                title:'Ada Api?',
                visual:'🔥',
                caption:'Bahaya Tambahan',
                description:'Periksa adanya kebakaran atau gas.',
                navIcon: 'fa-solid fa-fire', // <-- TAMBAH INI
                options:[
                    { label:'Ada', icon:'🔥', desc:'Jauhi area.' },
                    { label:'Tidak', icon:'✅', desc:'Lanjut aman.' }
                ]
            },
            {
                title:'Menuju Shelter',
                visual:'🏃',
                caption:'Evakuasi',
                description:'Ikuti jalur evakuasi resmi.',
                navIcon: 'fa-solid fa-person-running', // <-- TAMBAH INI
                options:[
                    { label:'Ikuti Jalur', icon:'➡️', desc:'Tetap tenang.' },
                    { label:'Cari Jalur', icon:'🧭', desc:'Gunakan area terbuka.' }
                ]
            },
            {
                title:'Area Aman?',
                visual:'⛺',
                caption:'Shelter',
                description:'Pastikan area jauh dari bangunan retak.',
                navIcon: 'fa-solid fa-tents', // <-- TAMBAH INI
                options:[
                    { label:'Sudah', icon:'⛺', desc:'Tetap di shelter.' },
                    { label:'Belum', icon:'⚠️', desc:'Cari tempat lain.' }
                ]
            },
            {
                title:'Aman',
                visual:'🏡',
                caption:'Kondisi Stabil',
                description:'Kamu telah mencapai area aman.',
                navIcon: 'fa-solid fa-check-circle', // <-- TAMBAH INI
                options:[
                    { label:'Lanjut', icon:'✅', desc:'Periksa kondisi tubuh.' }
                ]
            }
        ],

        injuries:[
            {
                id:'luka_sayat',
                name:'Luka Sayat',
                icon:'🩸',
                desc:'Luka terbuka akibat benda tajam',
                detail:'Penanganan luka sayat memerlukan pembersihan menyeluruh dan balutan steril untuk mencegah infeksi. Lakukan penekanan untuk menghentikan pendarahan.',
                tags:['Balut','Bersihkan', 'Tekan'],
                steps: [
                    'Cuci tangan dengan sabun bersih',
                    'Tekan luka dengan kain bersih untuk menghentikan darah',
                    'Bilas dengan air bersih yang mengalir',
                    'Oleskan antiseptik (betadine jika tersedia)',
                    'Balut dengan kain steril'
                ]
            },
            {
                id:'luka_lecet',
                name:'Luka Lecet',
                icon:'🩹',
                desc:'Gesekan pada kulit',
                detail:'Luka lecet (abrasi) adalah luka superfisial akibat gesekan. Fokus pada pembersihan dan pencegahan infeksi untuk penyembuhan optimal.',
                tags:['Antiseptik','Bersih'],
                steps: [
                    'Bilas area lecet dengan air bersih',
                    'Singkirkan kotoran atau debu dengan lembut',
                    'Aplikasikan antiseptik (povidon iodine)',
                    'Tutup dengan kain kasa jika diperlukan',
                    'Jangan digosok, biarkan kering alami'
                ]
            },
            {
                id:'luka_bakar',
                name:'Luka Bakar',
                icon:'🔥',
                desc:'Dinginkan area luka',
                detail:'Penanganan luka bakar harus segera. Pendinginan dengan air dingin sangat penting untuk mengurangi kedalaman luka dan menghilangkan rasa sakit.',
                tags:['Air Dingin','Segera'],
                steps: [
                    'Segera jauhkan dari sumber panas',
                    'Dinginkan area luka dengan air dingin 10-15 menit',
                    'Jangan menggosok atau memberikan es langsung',
                    'Keluarkan perhiasan/gelang dari area luka',
                    'Tutup dengan perban steril (jangan pasta gigi)'
                ]
            },
            {
                id:'patah_tulang',
                name:'Patah Tulang',
                icon:'🦴',
                desc:'Stabilkan area tubuh',
                detail:'Patah tulang memerlukan imobilisasi segera untuk mencegah kerusakan lebih lanjut. Buat bidai darurat dari bahan di sekitar untuk menstabilkan anggota yang terluka.',
                tags:['Bidai','Imobilisasi','Medis'],
                steps: [
                    'Immobilisasi area yang dicurigai patah',
                    'Buat bidai dari ranting, papan, atau kain tebal',
                    'Terikat dengan tali atau kain untuk stabilisasi',
                    'Kompres dengan air dingin jika ada pembengkakan',
                    'Segera bawa ke pusat medis'
                ]
            },
            {
                id:'cedera_kepala',
                name:'Cedera Kepala',
                icon:'🧠',
                desc:'Pantau kesadaran',
                detail:'Cedera kepala dapat mengancam jiwa. Monitor kesadaran dan cari tanda peringatan seperti mual, pusing, atau perubahan perilaku. Segera minta bantuan medis.',
                tags:['BAHAYA','Monitor','Medis'],
                steps: [
                    'Letakkan korban dalam posisi recovery (miring)',
                    'Monitor kesadaran dan responsif',
                    'Cek adanya perdarahan dari telinga/hidung',
                    'Jangan biarkan tidur jika cedera serius',
                    'Hubungi medis darurat segera'
                ]
            },
            {
                id:'sesak_nafas',
                name:'Sesak Nafas',
                icon:'🫁',
                desc:'Pastikan jalan napas',
                detail:'Sesak napas adalah kondisi gawat darurat. Pastikan jalan napas terbuka dan lakukan CPR jika korban tidak bernapas. Hubungi ambulans segera.',
                tags:['CPR','DARURAT','Medis'],
                steps: [
                    'Buka jalan napas dengan posisi kepala terdorong ke belakang',
                    'Buka mulut untuk cek sumbatan',
                    'Lakukan CPR jika tidak bernapas (30 kompresi:2 napas)',
                    'Letakkan dalam posisi pemulihan saat sadar',
                    'Hubungi ambulans dan pantau napas'
                ]
            },
            {
                id:'pingsan',
                name:'Pingsan',
                icon:'😵',
                desc:'Cek respon tubuh',
                detail:'Korban pingsan butuh monitoring ketat. Letakkan dalam posisi pemulihan, cek responsif, dan segera hubungi medis jika tidak sadar lama.',
                tags:['Recovery','Monitor','Medis'],
                steps: [
                    'Letakkan dalam posisi pemulihan (miring)',
                    'Cek responsif dengan panggil dan sentuh ringan',
                    'Monitor napas dan denyut nadi',
                    'Jangan memberi minum selama belum sadar sepenuhnya',
                    'Hubungi medis jika belum sadar dalam 5 menit'
                ]
            },
            {
                id:'luka_tusuk',
                name:'Luka Tusuk',
                icon:'⚠️',
                desc:'Jangan cabut benda tertancap',
                detail:'Luka tusuk sangat berbahaya karena dapat menembus organ dalam. JANGAN PERNAH MENCABUT benda asing. Segera minta bantuan medis profesional.',
                tags:['DARURAT','Medis'],
                steps: [
                    'JANGAN CABUT benda tertancap',
                    'Stabilkan benda dengan balutan ringan',
                    'Hubungi ambulans/pusat medis segera',
                    'Letakkan korban dalam posisi nyaman',
                    'Monitor kondisi sampai bantuan datang'
                ]
            }
        ],

        get currentQuestion(){
            return this.questions[this.currentStep]
        },

        startDisaster(item){

            this.currentStep = 0
            this.popup = true

        },

        nextQuestion(){

            if(this.currentStep < this.questions.length - 1){
                this.currentStep++
            }

        },

        prevQuestion(){

            if(this.currentStep > 0){
                this.currentStep--
            }

        },

        goQuestion(index){

            this.currentStep = index

        },

        finishFlow(){

            this.popup = false
            this.injuryPopup = true

        },

        openInjurySelect(){

            this.injuryPopup = false
            this.caregiverPopup = true

        },

        goSupply(){

            this.injuryPopup = false

            window.location.href = "{{ route('sesudah') }}#supply"

        },

        goCaregiver(injury){

            window.location.href = "{{ route('sesudah') }}?injury=" + injury.id

        },

        handleTouchStart(e){
            this.touchStartX = e.changedTouches[0].screenX
            this.touchStartY = e.changedTouches[0].screenY
        },

        handleTouchMove(e){
            this.touchEndX = e.changedTouches[0].screenX
            this.touchEndY = e.changedTouches[0].screenY
        },

        handleTouchEnd(){
            const diffX = this.touchStartX - this.touchEndX
            const diffY = Math.abs(this.touchStartY - this.touchEndY)
            
            // Pastikan swipe adalah horizontal, bukan vertical scroll
            if(Math.abs(diffX) > diffY && Math.abs(diffX) > 50){
                if(diffX > 0){
                    // Swipe kiri (next question)
                    this.nextQuestion()
                } else {
                    // Swipe kanan (prev question)
                    this.prevQuestion()
                }
            }
        }

    }

}

</script>

@endsection