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
        backdrop-filter: blur(12px) !important;
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
        border-radius: 32px;
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
        background: var(--c-light);
        border-radius:32px;
        overflow:hidden;
    }

    .question-option{
        border: 1px solid rgba(191,49,49,.12);
        transition:.2s ease;
        background:white;
    }

    .question-option:hover{
        border-color: var(--c-red);
        transform:translateY(-4px);
    }

    .step-btn{
        width:38px;
        height:38px;
        border-radius:10px;
        background: var(--c-beige);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:.8rem;
        font-weight:700;
        transition:.2s ease;
        cursor:pointer;
    }

    .step-btn.active{
        background: var(--c-red);
        color:white;
    }

    .nav-arrow{
        width:44px;
        height:44px;
        border-radius:14px;
        background: var(--c-beige);
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition:.2s ease;
    }

    .nav-arrow:hover{
        background: var(--c-red);
        color:white;
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
    <section class="py-24">

        <div class="max-w-6xl mx-auto px-5">

            <div class="text-center mb-12 mt-14">

                <h2 class="font-head text-5xl font-black" style="color: var(--c-dark-red)">
                    Tutorial
                </h2>

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

                                    <div class="w-8 h-8 rounded-full text-white flex items-center justify-center" style="background: var(--c-red)">
                                        →
                                    </div>

                                </div>

                                <p
                                    class="text-sm text-gray-500 leading-relaxed mb-5"
                                    x-text="item.desc"
                                ></p>

                                <div class="flex gap-2 flex-wrap">

                                    <template x-for="tag in item.tags">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold" style="background: rgba(191,49,49,.12); color: var(--c-red)">
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
    <template x-teleport="body">
        <div
            x-show="popup"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="modal-overlay"
        >
            <div class="modal-backdrop" @click="popup = false"></div>

            <div
                @click.stop
                class="modal-box"
            >

                <div class="grid md:grid-cols-2 h-full">

                    {{-- LEFT --}}
                    <div class="p-8 flex flex-col justify-between">

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
                    <div class="p-8 flex items-center" style="background: var(--c-beige)">

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
    </template>

    {{-- =========================================
        POPUP ADA LUKA?
    ========================================== --}}
    <template x-teleport="body">
        <div
            x-show="injuryPopup"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="modal-overlay"
        >
            <div class="modal-backdrop" @click="injuryPopup = false"></div>

            <div
                @click.stop
                class="modal-box"
            >

                <div class="p-12 text-center">

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

        </div>
    </template>

    {{-- =========================================
        POPUP JENIS LUKA
    ========================================== --}}
    <template x-teleport="body">
        <div
            x-show="caregiverPopup"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="modal-overlay"
        >
            <div class="modal-backdrop" @click="caregiverPopup = false"></div>

            <div
                @click.stop
                class="modal-box"
            >

                <div class="p-10">

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