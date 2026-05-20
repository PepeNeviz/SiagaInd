@extends('layouts.app')

@section('title', 'Saat Bencana')

@section('content')

<style>

    /* ====================================================
        SAAT PAGE — RUSTY LAKE STYLE
    ==================================================== */

    .saat-bg{
        background:
            radial-gradient(circle at top left, rgba(191,49,49,.14), transparent 28%),
            radial-gradient(circle at bottom right, rgba(125,10,10,.18), transparent 35%),
            linear-gradient(135deg,#1B1B1B 0%, #242424 100%);
        position:relative;
        overflow:hidden;
    }

    .saat-bg::before{
        content:'';
        position:absolute;
        inset:0;
        background-image:
            linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
        background-size:40px 40px;
        opacity:.5;
    }

    .rust-card{
        background:#EEEEEE;
        border:1px solid rgba(0,0,0,.06);
        box-shadow:
            0 12px 40px rgba(0,0,0,.07),
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
        box-shadow:0 18px 50px rgba(125,10,10,.14);
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
        background:#D9D9D9;
        border-radius:20px;
    }

    .phase-badge{
        background:#BF3131;
        color:white;
    }

    .popup-bg{
        background:rgba(0,0,0,.68);
        backdrop-filter:blur(12px);
    }

    .popup-panel{
        background:#F2F2F2;
        border-radius:32px;
        overflow:hidden;
    }

    .question-option{
        border:1px solid rgba(0,0,0,.08);
        transition:.2s ease;
        background:white;
    }

    .question-option:hover{
        border-color:#BF3131;
        transform:translateY(-4px);
    }

    .step-btn{
        width:38px;
        height:38px;
        border-radius:10px;
        background:#D9D9D9;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:.8rem;
        font-weight:700;
        transition:.2s ease;
        cursor:pointer;
    }

    .step-btn.active{
        background:#BF3131;
        color:white;
    }

    .nav-arrow{
        width:44px;
        height:44px;
        border-radius:14px;
        background:#DADADA;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition:.2s ease;
    }

    .nav-arrow:hover{
        background:#BF3131;
        color:white;
    }

    .done-btn{
        background:#BF3131;
        color:white;
        transition:.2s ease;
    }

    .done-btn:hover{
        background:#7D0A0A;
    }

    .injury-btn{
        transition:.2s ease;
        background:white;
        border:1px solid rgba(0,0,0,.06);
    }

    .injury-btn:hover{
        transform:translateY(-4px);
        border-color:#BF3131;
    }

</style>

<div
    x-data="saatPage()"
    class="bg-[#EEEEEE] min-h-screen"
>

    {{-- HERO --}}
    <section class="saat-bg min-h-[45vh] flex items-center">

        <div class="relative z-10 max-w-6xl mx-auto px-5 py-24 w-full">

            <div class="max-w-3xl">

                <div class="phase-badge inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold mb-7">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    MODE DARURAT
                </div>

                <h1 class="font-head text-5xl md:text-7xl font-black text-white leading-[1.05]">
                    Bertindak<br>
                    <span class="text-[#EAD196]">Secepat Mungkin.</span>
                </h1>

                <p class="text-white/65 text-lg max-w-xl mt-7 leading-relaxed">
                    Pilih bencana, jawab situasi secara cepat, dan ikuti decision tree
                    hingga mencapai kondisi aman.
                </p>

            </div>

        </div>

    </section>

    {{-- TUTORIAL --}}
    <section class="py-24">

        <div class="max-w-6xl mx-auto px-5">

            <div class="text-center mb-16">

                <h2 class="font-head text-5xl font-black text-[#111]">
                    Tutorial
                </h2>

                <p class="text-[#8D8D8D] text-2xl mt-2">
                    Sebelum Bencana
                </p>

            </div>

            <div class="grid md:grid-cols-2 gap-8">

                <template x-for="item in disasters">

                    <button
                        @click="startDisaster(item)"
                        class="tutorial-card rust-card rounded-[30px] p-6 text-left"
                    >

                        <div class="flex gap-5">

                            <div class="visual-box w-28 h-28 flex items-center justify-center text-5xl flex-shrink-0">
                                <span x-text="item.icon"></span>
                            </div>

                            <div class="flex-1">

                                <div class="flex items-center justify-between gap-3 mb-3">

                                    <h3
                                        class="font-head text-xl font-black"
                                        x-text="item.name"
                                    ></h3>

                                    <div class="w-8 h-8 rounded-full bg-[#BF3131] text-white flex items-center justify-center">
                                        →
                                    </div>

                                </div>

                                <p
                                    class="text-sm text-gray-500 leading-relaxed mb-5"
                                    x-text="item.desc"
                                ></p>

                                <div class="flex gap-2 flex-wrap">

                                    <template x-for="tag in item.tags">
                                        <span class="px-3 py-1 rounded-full bg-[#BF3131]/10 text-[#BF3131] text-xs font-bold">
                                            <span x-text="tag"></span>
                                        </span>
                                    </template>

                                </div>

                            </div>

                        </div>

                    </button>

                </template>

            </div>

        </div>

    </section>

    {{-- =========================================
        POPUP QUESTION FLOW
    ========================================== --}}
    <div
        x-show="popup"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-5 popup-bg"
        style="display:none"
    >

        <div
            @click.outside="popup = false"
            class="popup-panel max-w-5xl w-full"
        >

            <div class="grid md:grid-cols-2">

                {{-- LEFT --}}
                <div class="p-8">

                    <div class="flex items-center justify-between mb-10">

                        <button
                            @click="prevQuestion"
                            class="nav-arrow"
                        >
                            ←
                        </button>

                        <div class="text-center">

                            <p class="text-xs uppercase tracking-[.25em] text-gray-400 mb-2">
                                Pertanyaan
                            </p>

                            <h2
                                class="font-head text-3xl font-black"
                                x-text="currentQuestion.title"
                            ></h2>

                        </div>

                        <button
                            @click="nextQuestion"
                            class="nav-arrow"
                        >
                            →
                        </button>

                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <template x-for="choice in currentQuestion.options">

                            <button
                                @click="selectedChoice = choice"
                                class="question-option rounded-[22px] p-5 text-center"
                            >

                                <div class="text-4xl mb-4" x-text="choice.icon"></div>

                                <h3 class="font-bold text-sm mb-2" x-text="choice.label"></h3>

                                <p class="text-xs text-gray-500" x-text="choice.desc"></p>

                            </button>

                        </template>

                    </div>

                    <div class="mt-10 flex items-center justify-between">

                        <div class="flex gap-2">

                            <template x-for="(step, index) in questions">

                                <button
                                    @click="goQuestion(index)"
                                    class="step-btn"
                                    :class="{ 'active': currentStep === index }"
                                    x-text="index + 1"
                                ></button>

                            </template>

                        </div>

                        <button
                            x-show="currentStep < questions.length - 1"
                            @click="nextQuestion"
                            class="done-btn px-5 py-3 rounded-full text-sm font-bold"
                        >
                            Next
                        </button>

                        <button
                            x-show="currentStep === questions.length - 1"
                            @click="finishFlow"
                            class="done-btn px-5 py-3 rounded-full text-sm font-bold"
                        >
                            Done
                        </button>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="bg-[#E7E7E7] p-8 flex items-center">

                    <div class="w-full">

                        <div class="visual-box h-[350px] flex items-center justify-center text-[8rem]">
                            <span x-text="currentQuestion.visual"></span>
                        </div>

                        <div class="mt-6 text-center">

                            <h3
                                class="font-head text-2xl font-black mb-3"
                                x-text="currentQuestion.caption"
                            ></h3>

                            <p
                                class="text-gray-500 leading-relaxed"
                                x-text="currentQuestion.description"
                            ></p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================
        POPUP ADA LUKA?
    ========================================== --}}
    <div
        x-show="injuryPopup"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-5 popup-bg"
        style="display:none"
    >

        <div class="popup-panel max-w-xl w-full p-12 text-center">

            <h2 class="font-head text-5xl font-black mb-4">
                Ada Luka?
            </h2>

            <p class="text-gray-500 text-lg mb-12">
                Pilih kondisi setelah mencapai tempat aman
            </p>

            <div class="grid grid-cols-2 gap-5">

                <button
                    @click="goSupply"
                    class="done-btn py-5 rounded-[22px] text-xl font-bold"
                >
                    Tidak
                </button>

                <button
                    @click="openInjurySelect"
                    class="done-btn py-5 rounded-[22px] text-xl font-bold"
                >
                    Ya
                </button>

            </div>

        </div>

    </div>

    {{-- =========================================
        POPUP JENIS LUKA
    ========================================== --}}
    <div
        x-show="caregiverPopup"
        x-transition
        class="fixed inset-0 z-[999] flex items-center justify-center p-5 popup-bg"
        style="display:none"
    >

        <div class="popup-panel max-w-3xl w-full p-10">

            <div class="text-center mb-10">

                <h2 class="font-head text-4xl font-black mb-3">
                    Jenis Luka
                </h2>

                <p class="text-gray-500">
                    Pilih luka untuk pindah ke caregiver
                </p>

            </div>

            <div class="grid grid-cols-4 gap-4">

                <template x-for="injury in injuries">

                    <button
                        @click="goCaregiver(injury)"
                        class="injury-btn rounded-[20px] p-5 text-center"
                    >

                        <div class="text-5xl mb-4" x-text="injury.icon"></div>

                        <h3 class="font-bold text-sm" x-text="injury.name"></h3>

                    </button>

                </template>

            </div>

        </div>

    </div>

</div>

<script>

function saatPage(){

    return{

        popup:false,
        injuryPopup:false,
        caregiverPopup:false,

        currentStep:0,
        selectedChoice:null,

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
                options:[
                    {
                        label:'Luar Ruangan',
                        icon:'🌳',
                        desc:'Jauhi benda rawan jatuh.'
                    },
                    {
                        label:'Dalam Ruangan',
                        icon:'🏠',
                        desc:'Lindungi kepala.'
                    }
                ]
            },

            {
                title:'Berapa Orang?',
                visual:'👥',
                caption:'Cek Sekitar',
                description:'Pastikan siapa saja berada dekat denganmu.',
                options:[
                    {
                        label:'Sendiri',
                        icon:'🧍',
                        desc:'Fokus evakuasi diri.'
                    },
                    {
                        label:'Bersama Orang',
                        icon:'👨‍👩‍👧',
                        desc:'Bantu kelompok.'
                    }
                ]
            },

            {
                title:'Ada Anak?',
                visual:'🧒',
                caption:'Prioritas Evakuasi',
                description:'Anak dan lansia harus diprioritaskan.',
                options:[
                    {
                        label:'Ada',
                        icon:'🧒',
                        desc:'Bantu lebih dulu.'
                    },
                    {
                        label:'Tidak Ada',
                        icon:'👌',
                        desc:'Lanjut evakuasi.'
                    }
                ]
            },

            {
                title:'Akses Keluar?',
                visual:'🚪',
                caption:'Cari Jalur Aman',
                description:'Periksa jalur evakuasi.',
                options:[
                    {
                        label:'Terbuka',
                        icon:'🚪',
                        desc:'Segera keluar.'
                    },
                    {
                        label:'Tertutup',
                        icon:'🪨',
                        desc:'Cari jalur alternatif.'
                    }
                ]
            },

            {
                title:'Ada Api?',
                visual:'🔥',
                caption:'Bahaya Tambahan',
                description:'Periksa adanya kebakaran atau gas.',
                options:[
                    {
                        label:'Ada',
                        icon:'🔥',
                        desc:'Jauhi area.'
                    },
                    {
                        label:'Tidak',
                        icon:'✅',
                        desc:'Lanjut aman.'
                    }
                ]
            },

            {
                title:'Menuju Shelter',
                visual:'🏃',
                caption:'Evakuasi',
                description:'Ikuti jalur evakuasi resmi.',
                options:[
                    {
                        label:'Ikuti Jalur',
                        icon:'➡️',
                        desc:'Tetap tenang.'
                    },
                    {
                        label:'Cari Jalur',
                        icon:'🧭',
                        desc:'Gunakan area terbuka.'
                    }
                ]
            },

            {
                title:'Area Aman?',
                visual:'⛺',
                caption:'Shelter',
                description:'Pastikan area jauh dari bangunan retak.',
                options:[
                    {
                        label:'Sudah',
                        icon:'⛺',
                        desc:'Tetap di shelter.'
                    },
                    {
                        label:'Belum',
                        icon:'⚠️',
                        desc:'Cari tempat lain.'
                    }
                ]
            },

            {
                title:'Aman',
                visual:'🏡',
                caption:'Kondisi Stabil',
                description:'Kamu telah mencapai area aman.',
                options:[
                    {
                        label:'Lanjut',
                        icon:'✅',
                        desc:'Periksa kondisi tubuh.'
                    }
                ]
            }
        ],

        injuries:[
            {
                name:'Luka Sayat',
                icon:'🩸'
            },
            {
                name:'Luka Lecet',
                icon:'🩹'
            },
            {
                name:'Luka Bakar',
                icon:'🔥'
            },
            {
                name:'Patah Tulang',
                icon:'🦴'
            },
            {
                name:'Cedera Kepala',
                icon:'🧠'
            },
            {
                name:'Sesak Nafas',
                icon:'🫁'
            },
            {
                name:'Pingsan',
                icon:'😵'
            },
            {
                name:'Luka Dalam',
                icon:'⚠️'
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

            window.location.href = "{{ route('sesudah') }}#caregiver"

        }

    }

}

</script>

@endsection