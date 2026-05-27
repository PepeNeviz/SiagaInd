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

    :root {
        --c-teal-dark:      #2D6A6A;
        --c-teal-main:      #3E8E8E;
        --c-teal-light:     #7FC7C7;
        --c-teal-bg:        #E8F6F3;
        
        --c-light:          #EEEEEE;
        --c-dark-red:       #7D0A0A;
        --c-red:            #BF3131;
    }

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
        display: flex;
        align-items: center;
        justify-content: center;
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

    /* =========================================
        INJURY MODAL STYLING - TEAL PALETTE
    ========================================== */
    .injury-modal-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        height: 100%;
    }

    .injury-modal-left {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: white;
    }

    .injury-modal-right {
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--c-teal-bg);
    }

    .injury-modal-header {
        margin-bottom: 1.5rem;
    }

    .injury-modal-title {
        font-size: 1.875rem;
        font-weight: 900;
        color: var(--c-teal-dark);
        margin-bottom: 0.5rem;
    }

    .injury-modal-desc {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .injury-modal-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .injury-modal-tag {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        background: white;
        color: var(--c-teal-main);
        font-weight: 700;
        font-size: 0.8rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .injury-modal-icon {
        font-size: 5rem;
        color: var(--c-teal-dark);
    }

    .injury-modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        padding: 1rem 2rem;
        background: white;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .injury-modal-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        border: none;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .injury-modal-btn-close {
        background: #e0e0e0;
        color: #333;
    }

    .injury-modal-btn-close:hover {
        background: #d0d0d0;
    }

    .injury-modal-btn-action {
        background: var(--c-teal-dark);
        color: white;
    }

    .injury-modal-btn-action:hover {
        background: #1f4848;
    }

    @media (max-width: 768px) {
        .injury-modal-content {
            grid-template-columns: 1fr;
        }

        .injury-modal-left {
            padding: 1.5rem;
        }

        .injury-modal-right {
            padding: 1.5rem;
            min-height: 250px;
        }

        .injury-modal-title {
            font-size: 1.5rem;
        }
    }

    /* =========================================
        INJURY MODAL ANIMATION - MODE SWITCH
    ========================================== */
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

    @keyframes slideInFromLeft {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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

    /* =========================================
        TOGGLE BUTTON ANIMATION
    ========================================== */
    .injury-mode-toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        background-color: #f3f3f3;
        border-radius: 9999px;
        padding: 4px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .injury-mode-toggle::before {
        content: '';
        position: absolute;
        top: 4px;
        bottom: 4px;
        /* RUMUS BARU: 50% dikurangi 4px (jatah padding) biar ukurannya presisi */
        width: calc(50% - 4px);
        background: white;
        border-radius: 9999px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 0;
    }

    .injury-mode-toggle[data-mode="text"]::before {
        /* RUMUS BARU: Pas di titik 50%, nggak akan nabrak dinding kanan lagi */
        left: 50%;
    }

    .injury-mode-toggle[data-mode="visual"]::before {
        left: 4px;
    }

    .injury-mode-toggle button {
        position: relative;
        z-index: 1;
        flex: 1;
        white-space: nowrap;
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
    @load="$nextTick(() => autoOpenInjury())"
    x-init="$nextTick(() => autoOpenInjury())"
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

    {{-- KEKURANGAN --}}
    <section class="py-24">

        <div class="max-w-5xl mx-auto px-5">

            <div class="text-center mb-14">
                <h2 class="section-title">Kamu Kekurangan Apa?</h2>
                <p class="section-sub">
                    Pilih kebutuhan utama untuk mendapatkan bantuan survival
                </p>
            </div>

            <div id="supply" class="grid md:grid-cols-3 gap-8">

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
    <template x-teleport="body" @teleport="$nextTick(() => {})">
        <div
            x-show="modal"
            style="display: none"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="modal-overlay"
        >
            <div
                class="modal-backdrop"
                @click="modal = false"
            ></div>

            <!-- INJURY MODAL -->
            <template x-if="currentInjuryType === 'injury'">
                
                {{-- min-h diatur agar boxnya punya ruang luas untuk visual mode --}}
                <div class="modal-box relative overflow-hidden bg-white" style="min-height: 85vh; md:min-height: 600px;">
                    
                    {{-- ==========================================
                         TOGGLE SWITCH & TOMBOL TUTUP (Posisi Tetap)
                    ========================================== --}}
                    <div class="absolute top-4 right-4 z-[60] flex items-center gap-3">
                        
                        {{-- Switcher Mode --}}
                        {{-- Lebar dilegakan jadi w-[240px] --}}
                        <div class="injury-mode-toggle w-[240px]" :data-mode="injuryViewMode">
                            <button @click="injuryViewMode = 'visual'" 
                                :class="injuryViewMode === 'visual' ? 'text-[var(--c-teal-dark)]' : 'text-gray-500 hover:text-gray-700'" 
                                class="w-1/2 py-1.5 text-center rounded-full text-xs font-bold transition-colors">
                                Visual
                            </button>
                            <button @click="injuryViewMode = 'text'" 
                                :class="injuryViewMode === 'text' ? 'text-[var(--c-teal-dark)]' : 'text-gray-500 hover:text-gray-700'" 
                                class="w-1/2 py-1.5 text-center rounded-full text-xs font-bold transition-colors">
                                Teks Lengkap
                            </button>
                        </div>

                        {{-- Tombol Tutup --}}
                        <button @click="modal = false" class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-gray-500 shadow-sm border hover:bg-gray-50 transition-colors">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    {{-- ==========================================
                         1. VISUAL MODE (Palette Sesudah & Swipe Scroll)
                    ========================================== --}}
                    {{-- Area ini dipasangi @touchstart, @touchmove, @touchend untuk geser HP --}}
                    <div x-show="injuryViewMode === 'visual'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-full"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-full"
                         class="grid grid-cols-1 md:grid-cols-2 h-full w-full absolute inset-0"
                         @touchstart="handleTouchStart" @touchend="handleTouchEnd" @touchmove="handleTouchMove">
                        
                        {{-- KIRI: Navigasi & Langkah (Area Thumb Zone) --}}
                        {{-- style="overflow-y: auto;" ditambahkan untuk fitur scroll jika teks panjang --}}
                        <div class="px-6 pb-8 pt-[12vh] md:p-8 flex flex-col h-full justify-between md:justify-center gap-6 relative bg-white z-10" style="overflow-y: auto;">
                            
                            {{-- Header Pertanyaan / Judul --}}
                            <div class="flex items-center justify-between shrink-0">
                                <button @click="if(injuryStepIndex > 0) injuryStepIndex--" 
                                    class="w-10 h-10 rounded-xl flex items-center justify-center font-bold transition-opacity" 
                                    :class="injuryStepIndex === 0 ? 'opacity-30 cursor-not-allowed bg-gray-100' : 'bg-[#E8F6F3] hover:bg-[#7FC7C7] text-[#2D6A6A]'">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                </button>

                                <div class="text-center px-2">
                                    <p class="text-xs uppercase tracking-[.25em] text-gray-400 mb-1" x-text="'Langkah ' + (injuryStepIndex + 1)"></p>
                                    <h2 class="font-head text-2xl md:text-3xl font-black" style="color: var(--c-teal-dark);" x-text="modalData.title"></h2>
                                </div>

                                <button @click="if(injuryStepIndex < modalData.steps.length - 1) injuryStepIndex++" 
                                    class="w-10 h-10 rounded-xl flex items-center justify-center font-bold transition-opacity" 
                                    :class="injuryStepIndex === modalData.steps.length - 1 ? 'opacity-30 cursor-not-allowed bg-gray-100' : 'bg-[#E8F6F3] hover:bg-[#7FC7C7] text-[#2D6A6A]'">
                                     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-5 h-5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </button>
                            </div>

                            {{-- KONTEN UTAMA: Instruksi Langkah & Gambar Mobile --}}
                            <div class="flex-1 flex flex-col items-center justify-center text-center">
                                <div class="w-full rounded-[24px] p-6 md:p-8 border-2 border-dashed shadow-sm transition-all duration-300" 
                                     style="border-color: var(--c-teal-light); background: var(--c-teal-bg);">
                                    
                                    {{-- Ikon Dinamis Mobile: Akan mencari stepVisuals, kalau kosong balik ke ikon utama --}}
                                    <div class="text-[4.5rem] mb-5 md:hidden drop-shadow-md transition-transform duration-300" 
                                         x-text="(modalData.stepVisuals && modalData.stepVisuals[injuryStepIndex]) ? modalData.stepVisuals[injuryStepIndex] : modalData.icon"></div> 
                                    
                                    <p class="text-lg md:text-xl font-bold leading-relaxed" style="color: var(--c-teal-dark);" x-text="modalData.steps[injuryStepIndex]"></p>
                                </div>
                            </div>

                            {{-- Area Bawah: Pagination & Tombol Next --}}
                            <div class="flex items-stretch justify-between gap-4 shrink-0 w-full mt-4">
                                
                                {{-- Tombol Angka --}}
                                {{-- md:flex dihapus. grid-cols-3 sekarang berlaku permanen di HP dan PC! --}}
                                {{-- Tambahan w-fit memastikan jarak antar kotak tetap rapat (tidak melar) --}}
                                <div class="grid grid-cols-3 gap-2 md:gap-3 w-fit">
                                    <template x-for="(step, index) in modalData.steps">
                                        <button @click="injuryStepIndex = index"
                                            class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center rounded-xl font-bold transition-all"
                                            :style="injuryStepIndex === index ? 'background: var(--c-teal-dark); color: white;' : 'background: #F3F3F3; color: #999;'"
                                            x-text="index + 1"></button>
                                    </template>
                                </div>

                                {{-- Tombol Aksi --}}
                                <button x-show="injuryStepIndex < modalData.steps.length - 1" @click="injuryStepIndex++" 
                                    class="w-28 md:w-28 rounded-xl font-bold text-white shadow-md flex items-center justify-center transition-all hover:opacity-90" style="background: var(--c-teal-main);">
                                    Next
                                </button>
                                
                                <button x-show="injuryStepIndex === modalData.steps.length - 1" @click="modal = false" 
                                    class="w-28 md:w-28 rounded-xl font-bold text-white shadow-md flex items-center justify-center transition-all hover:opacity-90 bg-red-600">
                                    Selesai
                                </button>
                            </div>
                        </div>

                        {{-- KANAN: Visual Icon Dinamis (Desktop) --}}
                        {{-- Background pakai palette Sesudah (E8F6F3) dan font Teal Dark --}}
                        <div class="hidden md:flex flex-col items-center justify-center p-8 relative" style="background: var(--c-teal-bg);">
                            
                            {{-- Ikon Raksasa Dinamis Desktop --}}
                            <div class="text-[9rem] drop-shadow-2xl hover:scale-110 transition-transform duration-300" 
                                 x-text="(modalData.stepVisuals && modalData.stepVisuals[injuryStepIndex]) ? modalData.stepVisuals[injuryStepIndex] : modalData.icon"></div>
                            
                            <h3 class="mt-8 font-head text-3xl font-black" style="color: var(--c-teal-dark);" x-text="modalData.title"></h3>
                            
                            <div class="mt-4 flex flex-wrap justify-center gap-2">
                                <template x-for="tag in modalData.tags">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold" 
                                          style="background: white; color: var(--c-teal-main); box-shadow: 0 2px 4px rgba(0,0,0,0.05);" 
                                          x-text="tag"></span>
                                </template>
                            </div>
                        </div>

                    </div>

                    {{-- ==========================================
                         2. TEXT MODE (UI Lu yang Asli)
                    ========================================== --}}
                    {{-- Dibungkus dengan pt-16 agar teks tidak tertimpa tombol switch di atas --}}
                    <div x-show="injuryViewMode === 'text'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-x-full"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 translate-x-full"
                         class="injury-modal-content w-full h-full pt-16 md:pt-0 absolute inset-0 overflow-y-auto">
                        
                        <div class="injury-modal-left">
                            <div class="pt-4 md:pt-0">
                                <div class="injury-modal-header">
                                    <h2 class="injury-modal-title" x-text="modalData.title"></h2>
                                    <p class="injury-modal-desc" x-text="modalData.desc"></p>
                                </div>

                                <div class="injury-modal-tags">
                                    <template x-for="tag in modalData.tags">
                                        <span class="injury-modal-tag" x-text="tag"></span>
                                    </template>
                                </div>

                                <template x-if="modalData.steps && modalData.steps.length > 0">
                                    <div style="margin-top: 1.5rem;">
                                        <h4 style="font-weight: 700; color: var(--c-teal-dark); margin-bottom: 0.75rem; font-size: 0.95rem;">Langkah Penanganan Lengkap:</h4>
                                        <ol style="list-style: none; padding: 0; color: #666; font-size: 0.85rem; line-height: 1.8;">
                                            <template x-for="(step, index) in modalData.steps">
                                                <li style="margin-bottom: 0.5rem; padding-left: 1.5rem; position: relative;">
                                                    <span style="position: absolute; left: 0; font-weight: 700; color: var(--c-teal-light);" x-text="index + 1 + '.'"></span>
                                                    <span x-text="step"></span>
                                                </li>
                                            </template>
                                        </ol>
                                    </div>
                                </template>
                            </div>
                            
                            {{-- Spasi kosong di bawah untuk scroll --}}
                            <div class="h-8 md:hidden"></div>
                        </div>

                        <div class="injury-modal-right hidden md:flex">
                            <div class="injury-modal-icon" x-text="modalData.icon"></div>
                        </div>

                    </div>

                </div>
            </template>

            <!-- DEFAULT MODAL (untuk konten lain) -->
            <template x-if="currentInjuryType !== 'injury'">
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
            </template>
        </div>
    </template>

</div>

<script>
function sesudahPage(){

    return {

        modal:false,
        modalData:{},

        // --- TAMBAHAN BARU: Variabel Mode Visual & Swipe ---
        currentInjuryType: null,
        injuryViewMode: 'visual',
        injuryStepIndex: 0,
        
        touchStartX: 0,
        touchStartY: 0,
        touchEndX: 0,
        touchEndY: 0,
        // --------------------------------------------------

        injuries:{
            luar:[
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
                    ],
                    // Ikon dinamis tiap langkah
                    stepVisuals: ['🧼', '🩸', '🚰', '🩹', '🤕']
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
                    ],
                    stepVisuals: ['🚰', '🧹', '🩹', '🤕', '🌬️']
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
                    ],
                    stepVisuals: ['🚫', '🎗️', '🚑', '🛌', '👀']
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
                    ],
                    stepVisuals: ['🏃', '🚰', '🧊', '💍', '🩹']
                }
            ],

            dalam:[
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
                    ],
                    stepVisuals: ['🛑', '🪵', '🪢', '🧊', '🚑']
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
                    ],
                    stepVisuals: ['🛌', '👀', '🩸', '🚫', '🚑']
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
                    ],
                    stepVisuals: ['😮‍💨', '🔍', '❤️', '🛌', '🚑']
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
                    ],
                    stepVisuals: ['🛌', '👋', '👀', '🚫', '🚑']
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

        // --- TAMBAHAN BARU: Fungsi Touch Swipe (Android/Mobile) ---
        handleTouchStart(e){
            this.touchStartX = e.changedTouches[0].screenX;
            this.touchStartY = e.changedTouches[0].screenY;
        },

        handleTouchMove(e){
            this.touchEndX = e.changedTouches[0].screenX;
            this.touchEndY = e.changedTouches[0].screenY;
        },

        handleTouchEnd(){
            const diffX = this.touchStartX - this.touchEndX;
            const diffY = Math.abs(this.touchStartY - this.touchEndY);
            
            // Pastikan swipe adalah horizontal, dan bukan scroll vertikal
            if(Math.abs(diffX) > diffY && Math.abs(diffX) > 50){
                if(diffX > 0){
                    // Swipe Kiri (Next)
                    if(this.injuryStepIndex < this.modalData.steps.length - 1) this.injuryStepIndex++;
                } else {
                    // Swipe Kanan (Prev)
                    if(this.injuryStepIndex > 0) this.injuryStepIndex--;
                }
            }
        },
        // ---------------------------------------------------------

        openCaregiver(item){
            this.modalData = {
                title: item.name,
                desc: item.detail || item.desc,
                icon: item.icon,
                tags: item.tags,
                steps: item.steps || [],
                stepVisuals: item.stepVisuals || [] // <-- Data Visual Masuk Sini
            }

            this.currentInjuryType = 'injury'
            this.injuryViewMode = 'visual' // Default ke visual step-by-step
            this.injuryStepIndex = 0       // Selalu mulai dari halaman 1 (index 0)
            this.modal = true
        },

        openInjuryDetail(item){
            this.modalData = {
                title: item.name,
                desc: item.detail || item.desc,
                icon: item.icon,
                tags: item.tags,
                steps: item.steps || [],
                stepVisuals: item.stepVisuals || [] // <-- Data Visual Masuk Sini
            }

            this.currentInjuryType = 'injury'
            this.injuryViewMode = 'visual' // Default ke visual step-by-step
            this.injuryStepIndex = 0       // Selalu mulai dari halaman 1 (index 0)
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
        },

        autoOpenInjury(){
            const urlParams = new URLSearchParams(window.location.search);
            const injuryId = urlParams.get('injury');
            
            if (!injuryId) return;
            
            let foundInjury = null;
            
            for (let category of ['luar', 'dalam']) {
                const injuries = this.injuries[category];
                foundInjury = injuries.find(inj => inj.id === injuryId);
                if (foundInjury) break;
            }
            
            if (foundInjury) {
                const sections = document.querySelectorAll('section');
                for (let section of sections) {
                    const title = section.querySelector('.section-title');
                    if (title && title.textContent.includes('Jenis Luka')) {
                        section.scrollIntoView({ behavior: 'smooth' });
                        setTimeout(() => {
                            this.openInjuryDetail(foundInjury);
                        }, 800);
                        break;
                    }
                }
            }
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