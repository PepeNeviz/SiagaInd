@extends('layouts.app')

@section('title', 'Sesudah Bencana')

@section('content')

<style>
    [x-cloak] {
        display: none !important;
    }

    /* =========================================
        SESUDAH PAGE STYLE
    ========================================== */

    .after-hero {
        background:
            radial-gradient(circle at top left, rgba(191,49,49,.18), transparent 30%),
            radial-gradient(circle at bottom right, rgba(125,10,10,.15), transparent 35%),
            linear-gradient(135deg, #1b1b1b 0%, #232323 100%);
        position: relative;
        overflow: hidden;
    }

    .after-hero::before{
        content:'';
        position:absolute;
        inset:0;
        background-image:
            linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
        background-size:40px 40px;
        opacity:.4;
    }

    .rust-card{
        background:#EEEEEE;
        border:1px solid rgba(0,0,0,.06);
        box-shadow:
            0 10px 30px rgba(0,0,0,.06),
            inset 0 1px 0 rgba(255,255,255,.6);
        transition:.25s ease;
    }

    .rust-card:hover{
        transform:translateY(-5px);
    }

    .injury-card{
        cursor:pointer;
        transition:.2s ease;
        position:relative;
        overflow:hidden;
    }

    .injury-card:hover{
        background:#fff;
        transform:translateY(-5px);
        box-shadow:0 15px 40px rgba(125,10,10,.12);
    }

    .injury-icon{
        width:74px;
        height:74px;
        border-radius:18px;
        background:linear-gradient(145deg,#d9d9d9,#f5f5f5);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:2rem;
        margin:auto;
    }

    .section-title{
        font-size:clamp(2rem,4vw,3rem);
        line-height:1;
        color:#111;
        font-weight:800;
        font-family:'Sora',sans-serif;
    }

    .section-sub{
        color:#9A9A9A;
        font-size:1.15rem;
        margin-top:.6rem;
    }

    .supply-btn{
        border:1px solid rgba(0,0,0,.08);
        background:#fff;
        transition:.2s ease;
        cursor:pointer;
    }

    .supply-btn:hover{
        transform:translateY(-5px);
        border-color:#BF3131;
    }

    .mini-card{
        background:white;
        border:1px solid rgba(0,0,0,.06);
        transition:.2s ease;
    }

    .mini-card:hover{
        transform:translateY(-5px);
        border-color:#BF3131;
        box-shadow:0 12px 30px rgba(0,0,0,.08);
    }

    .craft-layout{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:2rem;
    }

    .craft-preview{
        background:#fff;
        border:1px solid rgba(0,0,0,.08);
        border-radius:24px;
        padding:1.5rem;
    }

    .craft-materials{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:.8rem;
    }

    .material-box{
        border:1px dashed #BF3131;
        background:#fff7f7;
        border-radius:16px;
        padding:1rem;
        text-align:center;
        position:relative;
    }

    .material-box span{
        position:absolute;
        top:8px;
        right:8px;
        width:22px;
        height:22px;
        border-radius:999px;
        background:#BF3131;
        color:white;
        font-size:.7rem;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
    }

    .pagination-btn{
        width:38px;
        height:38px;
        border-radius:10px;
        background:#E2E2E2;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
        cursor:pointer;
        transition:.2s ease;
    }

    .pagination-btn:hover{
        background:#BF3131;
        color:white;
    }

    .modal-bg{
        background:rgba(0,0,0,.6);
        backdrop-filter:blur(10px);
    }

    .modal-overlay {
        position: fixed !important;
        inset: 0 !important;
        background-color: rgba(0, 0, 0, 0.6) !important;
        backdrop-filter: blur(10px) !important;
        z-index: 50 !important;
        padding: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .modal-box {
        position: relative;
        z-index: 51;
        width: 100% !important;
        max-width: 860px !important;
        display: flex !important;
        flex-direction: column !important;
        background: var(--c-light);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        transform: none !important;
        margin: 0 auto !important;
    }

    .modal-backdrop {
        position: absolute;
        inset: 0;
        background: transparent;
        cursor: pointer;
    }

    .popup-panel{
        background:#F3F3F3;
        border-radius:28px;
        overflow:hidden;
    }

    .popup-video{
        background:#D8D8D8;
        border-radius:22px;
        min-height:280px;
    }

    .rusty-btn{
        background:#BF3131;
        color:white;
        transition:.2s ease;
    }

    .rusty-btn:hover{
        background:#7D0A0A;
    }

    .dark-badge{
        background:#1E1E1E;
        color:#EEE;
    }

    @media(max-width:768px){

        .craft-layout{
            grid-template-columns:1fr;
        }

        .popup-video{
            min-height:200px;
        }

    }

    /* =========================================
        AFTER DISASTER INFO - COLOR PALETTE TEAL
    ========================================== */
    @keyframes fadeIn {
        from { 
            opacity: 0;
            transform: translateY(8px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    #after-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        width: 100%;
    }

    #after-info-grid.fade-loading {
        opacity: 0.5;
        pointer-events: none;
    }

    #after-info-grid.fade-loading .after-info-card {
        animation: fadeIn 0.4s ease-out forwards;
    }

    #after-info-grid .after-info-card {
        animation: fadeIn 0.4s ease-out backwards;
    }

    .after-info-card { 
        background: #FFFFFF; 
        border-radius: 20px; 
        padding: 20px; 
        border: 2px solid #3E8E8E; 
        box-shadow: 0 4px 15px rgba(45, 106, 106, 0.1);
        transition: all 0.3s ease;
    }

    .after-info-card:hover {
        box-shadow: 0 8px 25px rgba(45, 106, 106, 0.2);
        border-color: #2D6A6A;
        transform: translateY(-2px);
    }

    .after-info-img { 
        width: 100%; 
        height: 140px; 
        background: linear-gradient(135deg, #7FC7C7 0%, #3E8E8E 100%); 
        border-radius: 12px; 
        margin-bottom: 15px; 
    }

    .after-info-title { 
        color: #2D6A6A; 
        font-weight: 800; 
    }

    .after-info-desc { 
        color: #2D6A6A; 
        opacity: 0.8; 
    }

    /* TOMBOL - AFTER DISASTER PALETTE */
    .after-category-btn { 
        background: #7FC7C7; 
        color: #2D6A6A; 
        padding: 12px 24px; 
        border-radius: 16px; 
        border: none; 
        cursor: pointer; 
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .after-category-btn:hover:not(.active) {
        background: #5fb3b3;
        transform: none;
    }

    .after-category-btn.active { 
        background: #2D6A6A; 
        color: white; 
    }

    .after-step-btn { 
        width: 52px; 
        height: 52px; 
        border-radius: 18px; 
        background: white; 
        border: 2px solid #7FC7C7; 
        color: #2D6A6A; 
        font-weight: 800; 
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .after-step-btn:hover:not(.active) {
        border-color: #2D6A6A;
        color: #2D6A6A;
        transform: none;
    }

    .after-step-btn.active { 
        background: #2D6A6A; 
        color: white; 
        border-color: #2D6A6A; 
    }

    @media (max-width: 768px) {
        #after-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        #after-info-grid {
            grid-template-columns: 1fr;
        }
    }

</style>

<div
    x-data="sesudahPage()"
    class="bg-[#EEEEEE] text-[#111]"
>

    {{-- HERO --}}
    <section class="after-hero min-h-[55vh] flex items-center">
        <div class="relative z-10 max-w-6xl mx-auto px-5 py-24 w-full">

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full dark-badge text-sm mb-7">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    Mode Pemulihan Pasca Bencana
                </div>

                <h1 class="font-head text-5xl md:text-7xl font-black text-white leading-[1.05]">
                    Tetap Tenang.<br>
                    <span class="text-[#EAD196]">Lanjut Bertahan.</span>
                </h1>

                <p class="text-white/65 max-w-xl mt-7 text-lg leading-relaxed">
                    Penanganan luka, pencarian supply, tutorial survival, dan informasi caregiver
                    untuk kondisi pasca bencana.
                </p>
            </div>

        </div>
    </section>

    {{-- INFORMASI PEMULIHAN BENCANA --}}
    <section class="py-20" style="background: linear-gradient(135deg, #E8F6F3 0%, #f0faf9 100%);">
        <div class="max-w-6xl mx-auto px-4">
            {{-- HEADER --}}
            <div class="mb-10">
                <span class="inline-block px-3 py-1 text-teal-600 text-xs font-bold rounded-full uppercase tracking-widest mb-3" style="background: #E8F6F3; color: #2D6A6A;">
                    Panduan Pemulihan
                </span>
                <h2 class="text-4xl font-extrabold" style="color: #2D6A6A;">
                    Informasi Sesudah Bencana
                </h2>
                <p class="text-gray-600 mt-1 text-sm">
                    Langkah-langkah penting untuk pemulihan setelah bencana alam.
                </p>
            </div>

            {{-- FILTER KATEGORI --}}
            <div id="after-category-container" class="flex justify-center gap-3 mb-10 flex-wrap">
                <button data-category="gempa" class="after-category-btn disaster-btn active">Gempa Bumi</button>
                <button data-category="banjir" class="after-category-btn disaster-btn">Banjir</button>
                <button data-category="longsor" class="after-category-btn disaster-btn">Longsor</button>
            </div>

            {{-- KONTEN INFORMASI --}}
            <div id="after-info-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10"></div>

            {{-- NAVIGASI STEP --}}
            <div id="after-step-container" class="flex justify-center gap-3">
                <button class="after-step-btn active" data-page="0">1</button>
                <button class="after-step-btn" data-page="1">2</button>
            </div>
        </div>
    </section>

    {{-- JENIS LUKA --}}
    <section class="py-24">

        <div class="max-w-6xl mx-auto px-5">

            <div class="text-center mb-16">
                <h2 class="section-title">Jenis Luka</h2>
                <p class="section-sub">Pilih kondisi luka untuk melihat cara penanganannya</p>
            </div>

            <div class="space-y-10">

                {{-- luka luar --}}
                <div>
                    <p class="text-center font-bold text-[#7D0A0A] mb-6 uppercase tracking-[.25em] text-sm">
                        Luka Luar
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

                        <template x-for="item in injuries.luar">
                            <button
                                @click="openCaregiver(item)"
                                class="injury-card rust-card rounded-[28px] p-6 text-center"
                            >
                                <div class="injury-icon" x-text="item.icon"></div>

                                <h3 class="mt-5 font-bold text-sm" x-text="item.name"></h3>

                                <p class="text-xs text-gray-500 mt-2" x-text="item.desc"></p>
                            </button>
                        </template>

                    </div>
                </div>

                {{-- luka dalam --}}
                <div>
                    <p class="text-center font-bold text-[#7D0A0A] mb-6 uppercase tracking-[.25em] text-sm">
                        Luka Dalam
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

                        <template x-for="item in injuries.dalam">
                            <button
                                @click="openCaregiver(item)"
                                class="injury-card rust-card rounded-[28px] p-6 text-center"
                            >
                                <div class="injury-icon" x-text="item.icon"></div>

                                <h3 class="mt-5 font-bold text-sm" x-text="item.name"></h3>

                                <p class="text-xs text-gray-500 mt-2" x-text="item.desc"></p>
                            </button>
                        </template>

                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- TUTORIAL SESUDAH --}}
    <section class="py-24 bg-[#E8E8E8] border-y border-black/5">

        <div class="max-w-6xl mx-auto px-5">

            <div class="flex items-end justify-between gap-6 flex-wrap mb-12">

                <div>
                    <h2 class="section-title">Sesudah Bencana</h2>
                    <p class="section-sub">
                        Hal yang harus diperiksa setelah kondisi mulai stabil
                    </p>
                </div>

                <div class="flex gap-3">
                    <div class="pagination-btn">1</div>
                    <div class="pagination-btn">2</div>
                    <div class="pagination-btn">3</div>
                </div>

            </div>

            <div class="grid md:grid-cols-3 gap-6">

                <template x-for="item in afterTutorials">

                    <button
                        @click="openTutorial(item)"
                        class="mini-card rounded-[28px] overflow-hidden text-left"
                    >

                        <div class="h-48 bg-[#D5D5D5] flex items-center justify-center text-5xl">
                            <span x-text="item.icon"></span>
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2" x-text="item.title"></h3>

                            <p class="text-sm text-gray-500 leading-relaxed" x-text="item.desc"></p>
                        </div>

                    </button>

                </template>

            </div>

        </div>

    </section>

    {{-- KEKURANGAN --}}
    <section class="py-24">

        <div class="max-w-5xl mx-auto px-5">

            <div class="text-center mb-14">
                <h2 class="section-title">Kamu Kekurangan Apa?</h2>
                <p class="section-sub">
                    Pilih kebutuhan utama untuk mendapatkan bantuan survival
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <button
                    @click="openSupply('minum')"
                    class="supply-btn rounded-[28px] p-10 text-center"
                >
                    <div class="text-6xl mb-5">💧</div>

                    <h3 class="font-bold text-xl mb-3">Minum</h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Cari sumber air, filter air darurat, dan tanda alam lokasi air.
                    </p>
                </button>

                <button
                    @click="openSupply('p3k')"
                    class="supply-btn rounded-[28px] p-10 text-center"
                >
                    <div class="text-6xl mb-5">🩹</div>

                    <h3 class="font-bold text-xl mb-3">P3K</h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Penanganan luka dan akses cepat menuju caregiver.
                    </p>
                </button>

                <button
                    @click="openSupply('alat')"
                    class="supply-btn rounded-[28px] p-10 text-center"
                >
                    <div class="text-6xl mb-5">🛠️</div>

                    <h3 class="font-bold text-xl mb-3">Alat</h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Crafting alat darurat dan improvisasi survival.
                    </p>
                </button>

            </div>

        </div>

    </section>

    {{-- INFORMASI --}}
    <section class="py-24 bg-[#E8E8E8] border-y border-black/5">

        <div class="max-w-6xl mx-auto px-5">

            <div class="mb-14">
                <h2 class="section-title">Informasi</h2>
                <p class="section-sub">Alat penanganan dan tutorial cepat</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6">

                <template x-for="item in infoItems">

                    <button
                        @click="openInfo(item)"
                        class="mini-card rounded-[28px] overflow-hidden"
                    >

                        <div class="h-44 bg-[#D5D5D5] flex items-center justify-center text-5xl">
                            <span x-text="item.icon"></span>
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-sm mb-2" x-text="item.title"></h3>

                            <p class="text-xs text-gray-500 leading-relaxed" x-text="item.desc"></p>
                        </div>

                    </button>

                </template>

            </div>

        </div>

    </section>

    {{-- CRAFTING --}}
    <section class="py-24">

        <div class="max-w-6xl mx-auto px-5">

            <div class="mb-16">
                <h2 class="section-title">Crafting khusus Caregiver</h2>
            </div>

            <div class="space-y-12">

                <template x-for="craft in craftingItems">

                    <div class="craft-layout rust-card rounded-[32px] p-8">

                        <div class="craft-preview">

                            <div class="h-72 rounded-[22px] bg-[#D5D5D5] flex items-center justify-center text-7xl">
                                <span x-text="craft.icon"></span>
                            </div>

                            <div class="mt-6 flex items-center justify-between gap-4">

                                <div>
                                    <h3 class="font-bold text-xl" x-text="craft.title"></h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Tutorial improvisasi alat medis
                                    </p>
                                </div>

                                <button
                                    @click="openCraft(craft)"
                                    class="rusty-btn px-5 py-3 rounded-full text-sm font-bold"
                                >
                                    Lihat Tutorial
                                </button>

                            </div>

                        </div>

                        <div class="craft-materials">

                            <template x-for="material in craft.materials">

                                <div class="material-box">
                                    <span x-text="material.qty"></span>

                                    <div class="text-4xl mb-3" x-text="material.icon"></div>

                                    <h4 class="font-bold text-sm" x-text="material.name"></h4>
                                </div>

                            </template>

                        </div>

                    </div>

                </template>

            </div>

        </div>

    </section>

    {{-- MODAL (MENGGUNAKAN X-TELEPORT AGAR SELALU DI ATAS NAVBAR) --}}
    <template x-teleport="body">
        <div
            x-show="modal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="modal-overlay"
        >
            <div
                class="modal-backdrop"
                @click="modal = false"
            ></div>

            <div
                @click.stop="modal = false"
                class="modal-box"
            >
                <div class="grid md:grid-cols-2 h-full">
                    <div class="p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex gap-2 mb-8">
                                <div class="pagination-btn">1</div>
                                <div class="pagination-btn">2</div>
                                <div class="pagination-btn">3</div>
                            </div>

                            <h2 class="font-head text-3xl font-black mb-3" style="color: var(--c-dark-red);" x-text="modalData.title"></h2>
                            <p class="text-gray-500 leading-relaxed" x-text="modalData.desc"></p>
                        </div>

                        <div class="mt-10 flex gap-3 flex-wrap">
                            <template x-for="tag in modalData.tags">
                                <span class="px-4 py-2 rounded-full text-sm font-bold" style="background: rgba(191,49,49,.12); color: var(--c-red);" x-text="tag"></span>
                            </template>
                        </div>
                    </div>

                    <div class="p-8 flex items-center justify-center" style="background: var(--c-beige);">
                        <div class="w-full flex items-center justify-center text-8xl">
                            <span x-text="modalData.icon"></span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-black/5 p-6 flex justify-end bg-gray-50">
                    <button
                        @click="modal = false"
                        class="rusty-btn px-6 py-3 rounded-full font-bold text-sm"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>

<script>
function sesudahPage(){

    return {

        modal:false,

        modalData:{},

        injuries:{
            luar:[
                {
                    name:'Luka Sayat',
                    icon:'🩸',
                    desc:'Luka terbuka akibat benda tajam',
                    tags:['Balut','Bersihkan']
                },
                {
                    name:'Luka Lecet',
                    icon:'🩹',
                    desc:'Gesekan pada kulit',
                    tags:['Antiseptik']
                },
                {
                    name:'Luka Tusuk',
                    icon:'⚠️',
                    desc:'Jangan cabut benda tertancap',
                    tags:['Darurat']
                },
                {
                    name:'Luka Bakar',
                    icon:'🔥',
                    desc:'Dinginkan area luka',
                    tags:['Air Bersih']
                }
            ],

            dalam:[
                {
                    name:'Patah Tulang',
                    icon:'🦴',
                    desc:'Stabilkan area tubuh',
                    tags:['Bidai']
                },
                {
                    name:'Cedera Kepala',
                    icon:'🧠',
                    desc:'Pantau kesadaran',
                    tags:['Bahaya']
                },
                {
                    name:'Sesak Nafas',
                    icon:'🫁',
                    desc:'Pastikan jalan napas',
                    tags:['CPR']
                },
                {
                    name:'Pingsan',
                    icon:'😵',
                    desc:'Cek respon tubuh',
                    tags:['Recovery']
                }
            ]
        },

        afterTutorials:[
            {
                title:'Waspada Gempa Susulan',
                icon:'🌍',
                desc:'Periksa bangunan sebelum kembali masuk.'
            },
            {
                title:'Periksa Kebocoran Gas',
                icon:'🔥',
                desc:'Jangan nyalakan api sebelum aman.'
            },
            {
                title:'Cari Informasi Resmi',
                icon:'📻',
                desc:'Pantau BNPB dan BMKG.'
            }
        ],

        infoItems:[
            {
                title:'CPR Dasar',
                icon:'❤️',
                desc:'Cara bantuan napas darurat.',
                tags:['CPR']
            },
            {
                title:'Membalut Luka',
                icon:'🩹',
                desc:'Teknik balut dasar.',
                tags:['Balut']
            },
            {
                title:'Patah Tulang',
                icon:'🦴',
                desc:'Cara imobilisasi.',
                tags:['Bidai']
            },
            {
                title:'Penurunan Kesadaran',
                icon:'🧠',
                desc:'Cek respon dan napas.',
                tags:['Kesadaran']
            }
        ],

        craftingItems:[
            {
                title:'Kain Segitiga',
                icon:'🧣',
                materials:[
                    {name:'Kain', icon:'🧵', qty:'1x'},
                    {name:'Peniti', icon:'📌', qty:'2x'},
                    {name:'Gunting', icon:'✂️', qty:'1x'},
                    {name:'Air Bersih', icon:'💧', qty:'1x'},
                ],
                tags:['Penyangga','Patah Tulang']
            },
            {
                title:'Bidai Darurat',
                icon:'🪵',
                materials:[
                    {name:'Kayu', icon:'🪵', qty:'2x'},
                    {name:'Kain', icon:'🧵', qty:'2x'},
                    {name:'Tali', icon:'🪢', qty:'1x'},
                    {name:'Gunting', icon:'✂️', qty:'1x'},
                ],
                tags:['Bidai','Tulang']
            }
        ],

        afterDisasterData: {
            gempa: [
                {title: "1. Periksa Bangunan", desc: "Hati-hati terhadap gempa susulan."},
                {title: "2. Catat Damage", desc: "Dokumentasi kerusakan untuk klaim."},
                {title: "3. Rawat Luka", desc: "Berikan first aid pada korban."},
                {title: "4. Evakuasi Barang", desc: "Amankan benda berharga."},
                {title: "5. Hubungi Keluarga", desc: "Konfirmasi keselamatan."},
                {title: "6. Cari Bantuan", desc: "Hubungi posko pengungsian resmi."}
            ],
            banjir: [
                {title: "1. Evakuasi Barang", desc: "Pindahkan ke tempat aman."},
                {title: "2. Bersihkan Rumah", desc: "Musnahkan bakteri dan kuman."},
                {title: "3. Kesehatan Keluarga", desc: "Pantau gejala penyakit."},
                {title: "4. Air Bersih", desc: "Gunakan air terfilter atau rebus."},
                {title: "5. Sanitasi", desc: "Gunakan jamban darurat/portable."},
                {title: "6. Psikologi", desc: "Dukung mental keluarga."}
            ],
            longsor: [
                {title: "1. Relokasi Sementara", desc: "Pindah ke daerah aman."},
                {title: "2. Catat Kerusakan", desc: "Lapor ke pemerintah daerah."},
                {title: "3. Periksa Air", desc: "Gunakan air bersih untuk minum."},
                {title: "4. Nutrisi", desc: "Pastikan asupan gizi keluarga."},
                {title: "5. Sosialisasi", desc: "Kumpul dengan tetangga untuk dukung moral."},
                {title: "6. Rencana Bangkit", desc: "Mulai proses rekonstruksi."}
            ]
        },

        currentDisasterCat: 'gempa',
        currentDisasterPage: 0,

        renderAfterDisasterGrid() {
            const grid = document.getElementById('after-info-grid');
            if (!grid) return;
            
            grid.classList.add('fade-loading');
            
            const items = this.afterDisasterData[this.currentDisasterCat].slice(
                this.currentDisasterPage * 3, 
                (this.currentDisasterPage * 3) + 3
            );
            
            setTimeout(() => {
                grid.innerHTML = items.map((item, idx) => `
                    <div class="after-info-card" style="animation-delay: ${idx * 0.1}s">
                        <div class="after-info-img"></div>
                        <h3 class="font-bold text-lg mb-2 after-info-title">${item.title}</h3>
                        <p class="text-sm text-gray-500 after-info-desc">${item.desc}</p>
                    </div>
                `).join('');
                
                grid.classList.remove('fade-loading');
            }, 150);
        },

        openCaregiver(item){


            this.modalData = {
                title:item.name,
                desc:item.desc,
                icon:item.icon,
                tags:item.tags
            }

            this.modal = true
        },

        openTutorial(item){

            this.modalData = {
                title:item.title,
                desc:item.desc,
                icon:item.icon,
                tags:['Sesudah Bencana']
            }

            this.modal = true
        },

        openInfo(item){

            this.modalData = item
            this.modal = true
        },

        openCraft(item){

            this.modalData = {
                title:item.title,
                desc:'Tutorial langkah demi langkah untuk membuat alat improvisasi.',
                icon:item.icon,
                tags:item.tags
            }

            this.modal = true
        },

        openSupply(type){

            if(type === 'minum'){

                this.modalData = {
                    title:'Filter Air Darurat',
                    desc:'Cari air mengalir. Jika tidak ada, gunakan tutorial filter air improvisasi.',
                    icon:'💧',
                    tags:['Filter Air','Survival']
                }

            }else if(type === 'p3k'){

                this.modalData = {
                    title:'Akses Cepat Caregiver',
                    desc:'Buka panduan medis dan penanganan luka.',
                    icon:'🩹',
                    tags:['P3K']
                }

            }else{

                this.modalData = {
                    title:'Crafting Alat',
                    desc:'Buat alat darurat improvisasi dari bahan sekitar.',
                    icon:'🛠️',
                    tags:['Crafting']
                }

            }

            this.modal = true
        }

    }

}

// Event Listeners untuk Informasi Sesudah Bencana
document.addEventListener('DOMContentLoaded', function() {
    const afterCategoryContainer = document.getElementById('after-category-container');
    const afterStepContainer = document.getElementById('after-step-container');
    
    if (afterCategoryContainer) {
        const sesudahInstance = sesudahPage();
        
        // Render grid pertama kali
        sesudahInstance.renderAfterDisasterGrid();
        
        // Event untuk kategori
        afterCategoryContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.after-category-btn');
            if (btn) {
                document.querySelectorAll('.after-category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                sesudahInstance.currentDisasterCat = btn.getAttribute('data-category');
                sesudahInstance.currentDisasterPage = 0;
                
                document.querySelectorAll('.after-step-btn').forEach(b => b.classList.remove('active'));
                document.querySelector('.after-step-btn[data-page="0"]').classList.add('active');
                
                sesudahInstance.renderAfterDisasterGrid();
            }
        });
        
        // Event untuk pagination
        if (afterStepContainer) {
            afterStepContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('.after-step-btn');
                if (btn) {
                    document.querySelectorAll('.after-step-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    sesudahInstance.currentDisasterPage = parseInt(btn.getAttribute('data-page'));
                    sesudahInstance.renderAfterDisasterGrid();
                }
            });
        }
    }
});
</script>

@endsection