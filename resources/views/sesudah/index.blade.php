@extends('layouts.app')

@section('title', 'Sesudah Bencana')

@section('content')

<style>
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

    {{-- MODAL --}}
    <div
        x-show="modal"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-5 modal-bg"
        style="display:none"
    >

        <div
            @click.outside="modal = false"
            class="popup-panel max-w-4xl w-full"
        >

            <div class="grid md:grid-cols-2">

                <div class="p-8">

                    <div class="flex gap-2 mb-8">
                        <div class="pagination-btn">1</div>
                        <div class="pagination-btn">2</div>
                        <div class="pagination-btn">3</div>
                    </div>

                    <h2 class="font-head text-3xl font-black mb-3" x-text="modalData.title"></h2>

                    <p class="text-gray-500 leading-relaxed" x-text="modalData.desc"></p>

                    <div class="mt-10 flex gap-3 flex-wrap">

                        <template x-for="tag in modalData.tags">
                            <span class="px-4 py-2 rounded-full bg-[#BF3131]/10 text-[#BF3131] text-sm font-bold" x-text="tag"></span>
                        </template>

                    </div>

                </div>

                <div class="bg-[#E5E5E5] p-8 flex items-center">

                    <div class="popup-video w-full flex items-center justify-center text-8xl">
                        <span x-text="modalData.icon"></span>
                    </div>

                </div>

            </div>

            <div class="border-t border-black/5 p-6 flex justify-end">
                <button
                    @click="modal = false"
                    class="rusty-btn px-6 py-3 rounded-full font-bold"
                >
                    Tutup
                </button>
            </div>

        </div>

    </div>

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
</script>

@endsection