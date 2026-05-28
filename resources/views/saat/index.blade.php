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
    <section class="pt-28 md:pt-32 pb-24">

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
                            <span x-html="item.icon"></span>
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
            class="fixed inset-0 z-[9000] flex items-center justify-center p-4"
        >
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="popup = false"></div>

            <div
                @click.stop
                class="w-full max-w-4xl bg-white rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col relative z-10 max-h-[90vh]"
                style="background: var(--c-light); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);"
            >

                {{-- 1. HEADER --}}
                <div class="px-6 py-4 md:py-5 border-b flex justify-between items-center bg-white shrink-0" style="border-color: var(--c-light);">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl" x-html="currentDisasterIcon"></span>
                        <h3 class="font-head text-lg md:text-xl font-black" style="color: var(--c-dark-red);" x-text="currentDisasterName"></h3>
                    </div>
                    <button @click="popup = false" class="w-8 h-8 rounded-full flex items-center justify-center transition-colors hover:opacity-80" style="background: var(--c-light); color: var(--c-dark-red);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Area konten yang bisa di swipe --}}
                <div class="flex-1 overflow-y-auto flex flex-col" 
                     @touchstart="touchStartX = $event.changedTouches[0].screenX" 
                     @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()">
                    
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

                                <div class="w-full h-32 md:h-48 mt-8 mb-4 md:mb-6 rounded-xl flex items-center justify-center text-6xl md:text-7xl transition-colors border border-black/5 overflow-hidden"
                                    :style="selectedChoice === choice ? 'background: rgba(191,49,49,0.05);' : 'background: var(--c-light);'">
                                    
                                    <!-- IF GIF PROPERTY EXISTS: Read the .gif property for the path -->
                                    <template x-if="choice.gif">
                                        <img :src="'{{ asset('') }}' + choice.gif" :alt="choice.desc" class="w-full h-full object-cover">
                                    </template>

                                    <!-- FALLBACK: If NO GIF property exists, render the FontAwesome vector icon -->
                                    <template x-if="!choice.gif">
                                        <span class="drop-shadow-sm" x-html="choice.icon"></span>
                                    </template>
                                </div>
                                <h3 class="font-bold text-sm md:text-lg text-gray-800 text-center w-full leading-tight" x-text="choice.desc"></h3>
                            </button>
                        </template>
                    </div>

                </div>

                {{-- 5. FOOTER (Warna terintegrasi) --}}
                <div class="px-6 md:px-12 py-5 border-t flex flex-wrap items-center justify-center md:justify-between gap-4 shrink-0" style="background: #FAFAFA; border-color: var(--c-light);">
                    
                    <div class="flex flex-wrap justify-center gap-2 w-full">
                        <template x-for="(step, index) in (questions[currentDisasterName] || [])">
                            <button @click="goQuestion(index)"
                                class="h-9 md:h-10 px-3.5 md:px-4 rounded-xl flex flex-shrink-0 items-center justify-center text-sm font-bold transition-all duration-300 shadow-sm border"
                                :style="currentStep === index ? 'background: var(--c-dark-red); color: white; border-color: var(--c-dark-red);' : 'background: white; color: var(--c-red); border-color: var(--c-beige);'">
                                
                                {{-- Ikon FontAwesome (Selalu Muncul) --}}
                                <i :class="step.navIcon" 
                                   class="mr-1.5 md:mr-2 text-[11px] md:text-[13px]"></i>
                                
                                {{-- Angka --}}
                                <span x-text="index + 1"></span>
                                
                            </button>
                        </template>
                    </div>

                    <button x-show="questions[currentDisasterName] && currentStep < questions[currentDisasterName].length - 1" @click="nextQuestion"
                        class="w-full md:w-auto px-10 py-3 md:py-3.5 rounded-xl font-bold text-white shadow-md transition-transform hover:-translate-y-0.5 active:scale-95" style="background: var(--c-red);">
                        Selanjutnya
                    </button>
                    <button x-show="questions[currentDisasterName] && currentStep === questions[currentDisasterName].length - 1" @click="finishFlow"
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
            class="fixed inset-0 z-[9000] flex items-center justify-center p-4"
        >
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="caregiverPopup = false"></div>

            <div
                @click.stop
                class="w-full max-w-4xl bg-white rounded-[24px] md:rounded-[32px] flex flex-col relative z-10 max-h-[90vh] overflow-y-auto"
                style="background: var(--c-light); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);"
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

                                <div class="text-4xl md:text-5xl mb-2 md:mb-4" x-html="injury.icon"></div>

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
                icon:'<i class="fa-solid fa-earth-asia text-blue-600"></i>',
                desc:'Decision tree cepat untuk kondisi gempa bumi.',
                tags:['Shelter','Evakuasi','Drop Cover Hold']
            },
            {
                name:'Banjir',
                icon:'<i class="fa-solid fa-water text-teal-600"></i>',
                desc:'Panduan mencari tempat tinggi dan menghindari arus.',
                tags:['Air','Evakuasi']
            },
            {
                name:'Kebakaran',
                icon:'<i class="fa-solid fa-fire text-red-500"></i>',
                desc:'Evakuasi asap dan mencari jalur keluar.',
                tags:['Asap','Api']
            },
            {
                name:'Tsunami',
                icon:'<i class="fa-solid fa-water text-teal-600"></i>',
                desc:'Menuju dataran tinggi secepat mungkin.',
                tags:['Evakuasi','Pantai']
            }
        ],

        questions: {
            'Gempa Bumi': [
                {
                    title:'Dimana?',
                    visual:'🏢',
                    caption:'Lokasi Saat Ini',
                    description:'Pilih kondisi lokasi kamu saat gempa terjadi.',
                    navIcon: 'fa-solid fa-location-dot',
                    options:[
                        { label:'Luar Ruangan', icon:'<i class="fa-solid fa-tree text-green-700"></i>', desc:'Jauhi benda rawan jatuh.', gif:'assets/gifs/gempa/Fall.gif' },
                        { label:'Dalam Ruangan', icon:'<i class="fa-solid fa-house text-green-700"></i>', desc:'Lindungi kepala.', gif:'assets/gifs/gempa/Hide & Grab.gif' }
                    ]
                },
                {
                    title:'Berapa Orang?',
                    visual:'👥',
                    caption:'Cek Sekitar',
                    description:'Pastikan siapa saja berada dekat denganmu.',
                    navIcon: 'fa-solid fa-users',
                    options:[
                        { label:'Sendiri', icon:'<i class="fa-solid fa-person text-gray-700"></i>', desc:'Fokus evakuasi diri.', gif:'assets/gifs/gempa/Run.gif' },
                        { label:'Bersama Orang', icon:'<i class="fa-solid fa-people-group text-blue-600"></i>', desc:'Bantu kelompok.', gif:'assets/gifs/gempa/Gathering.gif' }
                    ]
                },
                {
                    title:'Ada Anak?',
                    visual:'<i class="fa-solid fa-child-reaching text-orange-500"></i>',
                    caption:'Prioritas Evakuasi',
                    description:'Anak dan lansia harus diprioritaskan.',
                    navIcon: 'fa-solid fa-child-reaching',
                    options:[
                        { label:'Ada', icon:'<i class="fa-solid fa-child-reaching text-orange-500"></i>', desc:'Bantu lebih dulu.', gif:'assets/gifs/gempa/Child.gif' },
                        { label:'Tidak Ada', icon:'<i class="fa-solid fa-thumbs-up text-green-500"></i>', desc:'Lanjut evakuasi.', gif:'assets/gifs/gempa/Run.gif' }
                    ]
                },
                {
                    title:'Akses Keluar?',
                    visual:'<i class="fa-solid fa-door-open text-amber-800"></i>',
                    caption:'Cari Jalur Aman',
                    description:'Periksa jalur evakuasi.',
                    navIcon: 'fa-solid fa-door-open',
                    options:[
                        { label:'Terbuka', icon:'<i class="fa-solid fa-door-open text-amber-800"></i>', desc:'Segera keluar.', gif:'assets/gifs/gempa/Evakuate.gif' },
                        { label:'Tertutup', icon:'<i class="fa-solid fa-hill-rockslide text-gray-600"></i>', desc:'Cari jalur alternatif.', gif:'assets/gifs/gempa/Alternate.gif' }
                    ]
                },
                {
                    title:'Ada Api?',
                    visual:'<i class="fa-solid fa-fire text-red-500"></i>',
                    caption:'Bahaya Tambahan',
                    description:'Periksa adanya kebakaran atau gas.',
                    navIcon: 'fa-solid fa-fire',
                    options:[
                        { label:'Ada', icon:'<i class="fa-solid fa-fire text-red-500"></i>', desc:'Jauhi area.', gif:'assets/gifs/gempa/Fire.gif' },
                        { label:'Tidak', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Lanjut aman.', gif:'assets/gifs/gempa/Evakuate.gif' }
                    ]
                },
                {
                    title:'Menuju Shelter',
                    visual:'<i class="fa-solid fa-person-running text-green-500"></i>',
                    caption:'Evakuasi',
                    description:'Ikuti jalur evakuasi resmi.',
                    navIcon: 'fa-solid fa-person-running',
                    options:[
                        { label:'Ikuti Jalur', icon:'<i class="fa-solid fa-arrow-right text-blue-500"></i>', desc:'Tetap tenang.', gif:'assets/gifs/gempa/Follow.gif' },
                        { label:'Cari Jalur', icon:'<i class="fa-solid fa-compass text-gray-600"></i>', desc:'Gunakan area terbuka.', gif:'assets/gifs/gempa/Open.gif' }
                    ]
                },
                {
                    title:'Area Aman?',
                    visual:'<i class="fa-solid fa-tent text-green-600"></i>',
                    caption:'Shelter',
                    description:'Pastikan area jauh dari bangunan retak.',
                    navIcon: 'fa-solid fa-tents',
                    options:[
                        { label:'Sudah', icon:'<i class="fa-solid fa-tent text-green-600"></i>', desc:'Tetap di shelter.', gif:'assets/gifs/gempa/Shelter.gif' },
                        { label:'Belum', icon:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>', desc:'Cari tempat lain.', gif:'assets/gifs/gempa/Crack.gif' }
                    ]
                },
                {
                    title:'Aman',
                    visual:'<i class="fa-solid fa-house-chimney text-green-600"></i>',
                    caption:'Kondisi Stabil',
                    description:'Kamu telah mencapai area aman.',
                    navIcon: 'fa-solid fa-check-circle',
                    options:[
                        { label:'Lanjut', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Periksa kondisi tubuh.', gif:'assets/gifs/gempa/Save.gif' }
                    ]
                }
            ],
            'Tsunami': [
                {
                    title:'Dimana?',
                    visual:'<i class="fa-solid fa-location-dot text-red-500"></i>',
                    caption:'Lokasi Saat Ini',
                    description:'Di mana posisi kamu sekarang?',
                    navIcon: 'fa-solid fa-location-dot',
                    options:[
                        { label:'Dekat Pantai', icon:'<i class="fa-solid fa-umbrella-beach text-yellow-500"></i>', desc:'Segera menjauh.' },
                        { label:'Jauh Pantai', icon:'<i class="fa-solid fa-city text-gray-500"></i>', desc:'Tetap waspada.' }
                    ]
                },
                {
                    title:'Peringatan?',
                    visual:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>',
                    caption:'Tanda Alam',
                    description:'Apakah ada tanda tsunami?',
                    navIcon: 'fa-solid fa-triangle-exclamation',
                    options:[
                        { label:'Air Surut', icon:'<i class="fa-solid fa-water text-teal-600"></i>', desc:'Tanda bahaya.' },
                        { label:'Gempa Kuat', icon:'<i class="fa-solid fa-house-crack text-orange-600"></i>', desc:'Potensi tsunami.' }
                    ]
                },
                {
                    title:'Berapa Orang?',
                    visual:'👥',
                    caption:'Cek Sekitar',
                    description:'Siapa yang bersamamu saat ini?',
                    navIcon: 'fa-solid fa-users',
                    options:[
                        { label:'Sendiri', icon:'<i class="fa-solid fa-person text-gray-700"></i>', desc:'Evakuasi diri.' },
                        { label:'Bersama', icon:'<i class="fa-solid fa-people-group text-blue-600"></i>', desc:'Bantu yang lain.' }
                    ]
                },
                {
                    title:'Ada Rentan?',
                    visual:'<i class="fa-solid fa-person-cane text-purple-500"></i>',
                    caption:'Prioritas',
                    description:'Adakah lansia atau anak kecil?',
                    navIcon: 'fa-solid fa-person-cane',
                    options:[
                        { label:'Ada', icon:'<i class="fa-solid fa-child-reaching text-orange-500"></i>', desc:'Bantu mereka.' },
                        { label:'Tidak', icon:'<i class="fa-solid fa-thumbs-up text-green-500"></i>', desc:'Segera lari.' }
                    ]
                },
                {
                    title:'Evakuasi?',
                    visual:'<i class="fa-solid fa-person-running text-green-500"></i>',
                    caption:'Metode',
                    description:'Cara menuju tempat aman.',
                    navIcon: 'fa-solid fa-person-running',
                    options:[
                        { label:'Jalan Kaki', icon:'<i class="fa-solid fa-person-walking text-green-600"></i>', desc:'Lebih disarankan.' },
                        { label:'Kendaraan', icon:'<i class="fa-solid fa-car text-red-500"></i>', desc:'Bisa macet.' }
                    ]
                },
                {
                    title:'Tujuan?',
                    visual:'<i class="fa-solid fa-mountain text-amber-700"></i>',
                    caption:'Tempat Tinggi',
                    description:'Cari area evakuasi vertikal.',
                    navIcon: 'fa-solid fa-mountain-sun',
                    options:[
                        { label:'Bukit', icon:'<i class="fa-solid fa-mountain text-amber-700"></i>', desc:'Minimal 10m dpl.' },
                        { label:'Gedung', icon:'🏢', desc:'Lantai 3 ke atas.' }
                    ]
                },
                {
                    title:'Area Aman?',
                    visual:'<i class="fa-solid fa-circle-check text-green-500"></i>',
                    caption:'Status Lokasi',
                    description:'Apakah posisi sudah cukup tinggi?',
                    navIcon: 'fa-solid fa-flag-checkered',
                    options:[
                        { label:'Sudah Tinggi', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Tetap di sana.' },
                        { label:'Masih Rendah', icon:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>', desc:'Naik lagi.' }
                    ]
                },
                {
                    title:'Aman',
                    visual:'<i class="fa-solid fa-water text-teal-600"></i>',
                    caption:'Bertahan',
                    description:'Tunggu info resmi sebelum turun.',
                    navIcon: 'fa-solid fa-tower-broadcast',
                    options:[
                        { label:'Bertahan', icon:'<i class="fa-solid fa-ban text-red-600"></i>', desc:'Jangan ke pantai.' }
                    ]
                }
            ],
            'Banjir': [
                {
                    title:'Dimana?',
                    visual:'<i class="fa-solid fa-house text-green-700"></i>',
                    caption:'Lokasi',
                    description:'Posisi kamu saat air naik.',
                    navIcon: 'fa-solid fa-house-flood-water',
                    options:[
                        { label:'Dalam Rumah', icon:'<i class="fa-solid fa-couch text-amber-700"></i>', desc:'Naik ke lantai atas.' },
                        { label:'Luar Rumah', icon:'<i class="fa-solid fa-road text-gray-600"></i>', desc:'Cari dataran tinggi.' }
                    ]
                },
                {
                    title:'Kondisi Air?',
                    visual:'<i class="fa-solid fa-water text-teal-600"></i>',
                    caption:'Ketinggian',
                    description:'Bagaimana arus airnya?',
                    navIcon: 'fa-solid fa-water',
                    options:[
                        { label:'Cepat Naik', icon:'<i class="fa-solid fa-arrow-trend-up text-red-600"></i>', desc:'Bahaya.' },
                        { label:'Genangan', icon:'<i class="fa-solid fa-droplet text-blue-500"></i>', desc:'Waspada.' }
                    ]
                },
                {
                    title:'Listrik?',
                    visual:'<i class="fa-solid fa-bolt text-yellow-400"></i>',
                    caption:'Risiko',
                    description:'Apakah listrik sudah dipadamkan?',
                    navIcon: 'fa-solid fa-plug-circle-xmark',
                    options:[
                        { label:'Padamkan', icon:'<i class="fa-solid fa-plug text-gray-500"></i>', desc:'Hindari setrum.' },
                        { label:'Sudah', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Bagus.' }
                    ]
                },
                {
                    title:'Barang?',
                    visual:'<i class="fa-solid fa-backpack text-green-600"></i>',
                    caption:'Penyelamatan',
                    description:'Amankan dokumen penting.',
                    navIcon: 'fa-solid fa-file-shield',
                    options:[
                        { label:'Amankan', icon:'<i class="fa-solid fa-arrow-up text-blue-500"></i>', desc:'Taruh di atas.' },
                        { label:'Tinggalkan', icon:'<i class="fa-solid fa-person-running text-green-500"></i>', desc:'Utamakan nyawa.' }
                    ]
                },
                {
                    title:'Arus Deras?',
                    visual:'<i class="fa-solid fa-water text-teal-600"></i>',
                    caption:'Bahaya',
                    description:'Apakah air mengalir deras?',
                    navIcon: 'fa-solid fa-triangle-exclamation',
                    options:[
                        { label:'Hindari', icon:'<i class="fa-solid fa-ban text-red-600"></i>', desc:'Bisa terseret.' },
                        { label:'Jangan Terjang', icon:'<i class="fa-solid fa-circle-xmark text-red-600"></i>', desc:'Berbahaya.' }
                    ]
                },
                {
                    title:'Evakuasi?',
                    visual:'<i class="fa-solid fa-life-ring text-orange-500"></i>',
                    caption:'Alat',
                    description:'Bagaimana cara evakuasi?',
                    navIcon: 'fa-solid fa-life-ring',
                    options:[
                        { label:'Pelampung', icon:'<i class="fa-solid fa-life-ring text-orange-500"></i>', desc:'Gunakan ban/botol.' },
                        { label:'Tongkat', icon:'<i class="fa-solid fa-crutch text-gray-400"></i>', desc:'Cek kedalaman.' }
                    ]
                },
                {
                    title:'Tujuan?',
                    visual:'<i class="fa-solid fa-tent text-green-600"></i>',
                    caption:'Posko',
                    description:'Cari posko pengungsian terdekat.',
                    navIcon: 'fa-solid fa-tents',
                    options:[
                        { label:'Posko', icon:'<i class="fa-solid fa-tent text-green-600"></i>', desc:'Tempat kering.' },
                        { label:'Dataran Tinggi', icon:'<i class="fa-solid fa-mountain text-amber-700"></i>', desc:'Aman dari air.' }
                    ]
                },
                {
                    title:'Aman',
                    visual:'<i class="fa-solid fa-circle-check text-green-500"></i>',
                    caption:'Bertahan',
                    description:'Tunggu air surut sepenuhnya.',
                    navIcon: 'fa-solid fa-check-circle',
                    options:[
                        { label:'Lanjut', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Periksa keluarga.' }
                    ]
                }
            ],
            'Kebakaran': [
                {
                    title:'Dimana?',
                    visual:'🏢',
                    caption:'Lokasi',
                    description:'Posisi kamu saat kebakaran terjadi.',
                    navIcon: 'fa-solid fa-location-dot',
                    options:[
                        { label:'Dalam Ruangan', icon:'<i class="fa-solid fa-door-open text-amber-800"></i>', desc:'Cari jalan keluar.' },
                        { label:'Luar Ruangan', icon:'<i class="fa-solid fa-tree text-green-700"></i>', desc:'Jauhi bangunan.' }
                    ]
                },
                {
                    title:'Kondisi Asap?',
                    visual:'<i class="fa-solid fa-wind text-gray-400"></i>',
                    caption:'Asap',
                    description:'Seberapa tebal asapnya?',
                    navIcon: 'fa-solid fa-smog',
                    options:[
                        { label:'Asap Tebal', icon:'<i class="fa-solid fa-cloud text-gray-400"></i>', desc:'Merangkak di bawah.' },
                        { label:'Asap Tipis', icon:'<i class="fa-solid fa-wind text-gray-400"></i>', desc:'Jalan cepat.' }
                    ]
                },
                {
                    title:'Pakaian?',
                    visual:'<i class="fa-solid fa-shirt text-blue-400"></i>',
                    caption:'Risiko',
                    description:'Apakah pakaian terbakar?',
                    navIcon: 'fa-solid fa-fire',
                    options:[
                        { label:'Stop Drop Roll', icon:'<i class="fa-solid fa-rotate text-blue-500"></i>', desc:'Berguling.' },
                        { label:'Aman', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Lanjut lari.' }
                    ]
                },
                {
                    title:'Gagang Pintu?',
                    visual:'<i class="fa-solid fa-door-open text-amber-800"></i>',
                    caption:'Cek Suhu',
                    description:'Periksa suhu gagang pintu.',
                    navIcon: 'fa-solid fa-door-closed',
                    options:[
                        { label:'Panas', icon:'<i class="fa-solid fa-fire text-red-500"></i>', desc:'Jangan dibuka.' },
                        { label:'Dingin', icon:'<i class="fa-solid fa-snowflake text-cyan-400"></i>', desc:'Buka perlahan.' }
                    ]
                },
                {
                    title:'Akses Keluar?',
                    visual:'<i class="fa-solid fa-person-running text-green-500"></i>',
                    caption:'Jalur',
                    description:'Gunakan tangga darurat.',
                    navIcon: 'fa-solid fa-stairs',
                    options:[
                        { label:'Tangga', icon:'<i class="fa-solid fa-stairs text-amber-800"></i>', desc:'Jangan pakai lift.' },
                        { label:'Jendela', icon:'<i class="fa-solid fa-border-all text-blue-300"></i>', desc:'Tunggu bantuan (jika terjebak).' }
                    ]
                },
                {
                    title:'Pemadam?',
                    visual:'<i class="fa-solid fa-fire-extinguisher text-red-600"></i>',
                    caption:'Tindakan',
                    description:'Apakah api masih kecil?',
                    navIcon: 'fa-solid fa-fire-extinguisher',
                    options:[
                        { label:'Pakai APAR', icon:'<i class="fa-solid fa-fire-extinguisher text-red-600"></i>', desc:'Padamkan.' },
                        { label:'Tinggalkan', icon:'<i class="fa-solid fa-person-running text-green-500"></i>', desc:'Bila membesar.' }
                    ]
                },
                {
                    title:'Titik Kumpul?',
                    visual:'<i class="fa-solid fa-location-dot text-red-500"></i>',
                    caption:'Evakuasi',
                    description:'Menuju titik kumpul yang aman.',
                    navIcon: 'fa-solid fa-people-group',
                    options:[
                        { label:'Titik Kumpul', icon:'<i class="fa-solid fa-location-dot text-red-500"></i>', desc:'Kumpul di sana.' },
                        { label:'Jauhi Gedung', icon:'🏢', desc:'Awas runtuhan.' }
                    ]
                },
                {
                    title:'Aman',
                    visual:'<i class="fa-solid fa-circle-check text-green-500"></i>',
                    caption:'Bertahan',
                    description:'Hubungi pemadam dan tunggu.',
                    navIcon: 'fa-solid fa-check-circle',
                    options:[
                        { label:'Lanjut', icon:'<i class="fa-solid fa-circle-check text-green-500"></i>', desc:'Cek luka bakar.' }
                    ]
                }
            ]
        },

        injuries:[
            {
                id:'luka_sayat',
                name:'Luka Sayat',
                icon:'<i class="fa-solid fa-droplet text-red-600"></i>',
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
                icon:'<i class="fa-solid fa-band-aid text-orange-300"></i>',
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
                icon:'<i class="fa-solid fa-fire text-red-500"></i>',
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
                icon:'<i class="fa-solid fa-bone text-gray-300 drop-shadow-md"></i>',
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
                icon:'<i class="fa-solid fa-brain text-pink-300"></i>',
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
                icon:'<i class="fa-solid fa-lungs text-pink-400"></i>',
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
                icon:'<i class="fa-solid fa-face-dizzy text-yellow-600"></i>',
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
                icon:'<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>',
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
            const q = this.questions[this.currentDisasterName];
            return q ? q[this.currentStep] : {};
        },

        startDisaster(item){

            this.currentDisasterName = item.name;
            this.currentDisasterIcon = item.icon;
            this.currentStep = 0;
            this.selectedChoice = null;
            this.popup = true;

        },

        nextQuestion(){
            const q = this.questions[this.currentDisasterName];
            if(q && this.currentStep < q.length - 1){
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

        handleSwipe() {
            if (this.touchEndX < this.touchStartX - 50) this.nextQuestion();
            if (this.touchEndX > this.touchStartX + 50) this.prevQuestion();
        }

    }

}

</script>

@endsection