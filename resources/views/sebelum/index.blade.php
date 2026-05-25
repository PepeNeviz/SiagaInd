@extends('layouts.app')

@section('title', 'Sebelum — Tas Siaga')

@push('styles')
<style>
/* BAGIAN TAS - WARNA BARU */
#bag-wrap{position:relative;width:260px;user-select:none}
#bag-svg{width:260px;display:block}
#inner-area{position:absolute;top:108px;left:46px;width:168px;height:218px;overflow:hidden}
.zona{position:absolute;left:0;width:168px;transition:background .15s,box-shadow .15s}
/* Menggunakan palette baru untuk zona */
#zona-a{top:0;height:72px;background:rgba(90,130,126,.08);border-bottom:1px dashed rgba(90,130,126,.3)}
#zona-b{top:72px;height:72px;background:rgba(132,174,146,.08);border-bottom:1px dashed rgba(132,174,146,.3)}
#zona-c{top:144px;height:74px;background:rgba(185,212,170,.08)}

.zona.drag-v{background:rgba(185,212,170,.3)!important;box-shadow:inset 0 0 0 2px #84AE92}
.zona.drag-iv{background:rgba(90,130,126,.2)!important;box-shadow:inset 0 0 0 2px #5A827E}

@keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
.do-shake{animation:shake .3s ease}
.placed{
    position:absolute;
    cursor:grab;
    border-radius:3px;
    transition:opacity .2s, transform .2s ease;
    box-shadow: 0 2px 8px rgba(90, 130, 126, 0.2);
}
.placed:active{
    cursor:grabbing;
    box-shadow: 0 8px 20px rgba(90, 130, 126, 0.4) !important;
}
.placed.dp{opacity:.3}
.ghost-box{
    position:absolute;
    pointer-events:none;
    border:2px dashed #5A827E;
    border-radius:4px;
    background:rgba(90,130,126,.15);
    z-index:40;
    display:none;
    box-shadow: inset 0 0 10px rgba(90, 130, 126, 0.1);
}
.ghost-box.bad{border-color:#5A827E;background:rgba(90,130,126,.1)}

.tas-tab{white-space:nowrap;transition:all .3s ease;border:1px solid #B9D4AA}
.tas-tab:hover:not(.active){background:rgba(44,62,80,0.05)}
.tas-tab.active{background:#5A827E;color:#fff;border-color:#5A827E}
.slim-scroll::-webkit-scrollbar{height:0}

/* ANIMASI SMOOTH UNTUK BERBAGAI ELEMEN */
button, input, select {
    transition: all 0.3s ease;
}

button:focus, input:focus, select:focus {
    outline: none;
}

/* ANIMASI FADE-IN UNTUK GRID */
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

#content-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    width: 100%;
}

#content-grid.fade-loading {
    opacity: 0.5;
    pointer-events: none;
}

#content-grid.fade-loading .info-card {
    animation: fadeIn 0.4s ease-out forwards;
}

#content-grid .info-card {
    animation: fadeIn 0.4s ease-out backwards;
}

.info-card { 
    background: #FFFFFF; 
    border-radius: 20px; 
    padding: 20px; 
    border: 2px solid #84AE92; 
    box-shadow: 0 4px 15px rgba(90, 130, 126, 0.1);
    transition: box-shadow 0.3s ease;
}

.info-card:hover {
    box-shadow: 0 8px 25px rgba(90, 130, 126, 0.2);
}

.img-box { width: 100%; height: 140px; background: #B9D4AA; border-radius: 12px; margin-bottom: 15px; }
.card-title { color: #5A827E; font-weight: 800; }
.card-desc { color: #5A827E; opacity: 0.8; }

/* TOMBOL - PALETTE BARU */
.category-btn { 
    background: #B9D4AA; 
    color: #5A827E; 
    padding: 12px 24px; 
    border-radius: 16px; 
    border: none; 
    cursor: pointer; 
    font-weight: 700;
    transition: all 0.3s ease;
}

.category-btn:hover:not(.active) {
    background: #a3c399;
    transform: none;
}

.category-btn.active { 
    background: #5A827E; 
    color: white; 
}

.step-btn { 
    width: 52px; 
    height: 52px; 
    border-radius: 18px; 
    background: white; 
    border: 2px solid #B9D4AA; 
    color: #5A827E; 
    font-weight: 800; 
    transition: all 0.3s ease;
    cursor: pointer;
}

.step-btn:hover:not(.active) {
    border-color: #5A827E;
    color: #5A827E;
    transform: none;
}

.step-btn.active { 
    background: #5A827E; 
    color: white; 
    border-color: #5A827E; 
}

/* LAIN-LAIN */
.icard { 
    border: .5px solid #84AE92; 
    border-radius: 12px; 
    padding: 8px 6px 6px; 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    gap: 4px; 
    cursor: grab; 
    background: #fff; 
    transition: opacity .2s, transform .1s ease; 
    touch-action: none !important; 
    user-select: none !important;
    min-height: 100px;
}

.icard:active {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(90, 130, 126, 0.3);
    z-index: 50;
}

/* Container scroll untuk item grid */
.item-scroll-container {
    height: 450px;
    overflow-y: auto;
    overflow-x: hidden;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    background: #fafafa;
    padding: 12px;
    scroll-behavior: smooth;
}

.item-scroll-container::-webkit-scrollbar {
    width: 6px;
}

.item-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.item-scroll-container::-webkit-scrollbar-thumb {
    background: #B9D4AA;
    border-radius: 10px;
}

.item-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #84AE92;
}

#item-grid-blade {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

@media (max-width: 640px) {
    .item-scroll-container {
        height: 500px;
    }
    
    #item-grid-blade {
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    
    .icard {
        padding: 10px 8px 8px;
        min-height: 110px;
    }
    
    .icard:active {
        transform: scale(1.1);
    }
}

/* Touch-friendly improvements untuk mobile */
@media (hover: none) and (pointer: coarse) {
    .icard {
        min-height: 120px;
        padding: 12px 10px;
    }
    
    .icard::before {
        content: '';
        position: absolute;
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        touch-action: none;
    }
}

.zdot{width:6px;height:6px;border-radius:50%}
.da{background:#5A827E}.db{background:#84AE92}.dc{background:#B9D4AA}
.zona-bar{height:5px;border-radius:3px;background:#FAFFCA;overflow:hidden;flex:1;margin:0 8px}
.zona-bar-fill{height:100%;border-radius:3px;transition:width .3s;background:#5A827E}

[x-cloak]{display:none !important}
body.modal-open{overflow:hidden}
</style>
@endpush

@section('content')
<div x-data="tasSiaga" class="max-w-5xl mx-auto px-4 sm:px-6 py-10">


    
    {{-- SECTION INFORMASI BENCANA --}}
<div class="max-w-5xl mx-auto px-4 py-10" id="bencana-section">
    
    <div class="max-w-6xl mx-auto px-4 py-10">

    <div class="max-w-6xl mx-auto px-4 py-10">
    {{-- FILTER KATEGORI --}}
    <div id="category-container" class="flex justify-center gap-3 mb-10">
        <button data-category="gempa" class="category-btn disaster-btn active">Gempa Bumi</button>
        <button data-category="banjir" class="category-btn disaster-btn">Banjir</button>
        <button data-category="longsor" class="category-btn disaster-btn">Longsor</button>
    </div>

    {{-- KONTEN EDUKASI (HANYA INI YANG DIUBAH JS) --}}
    <div id="content-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>

    {{-- NAVIGASI STEP --}}
    <div id="step-container" class="flex justify-center gap-3 mt-8">
        <button class="step-btn active" data-page="0">1</button>
        <button class="step-btn" data-page="1">2</button>
    </div>
</div>


  {{-- =========================================
      HEADER TAS
  ========================================== --}}
  <div class="mb-6">
    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full uppercase tracking-widest mb-3">
      Sebelum Bencana
    </span>

    <h1 class="font-head text-4xl font-extrabold text-navy">
      Tas Siaga
    </h1>

    <p class="text-gray-500 mt-1 text-sm">
      Susun perlengkapan darurat sesuai prioritas akses.
    </p>
  </div>


  {{-- ===================================================
     PASTE INI: ganti blok TABS SELEKTOR TAS
     (dari "TABS SELEKTOR TAS" sampai tutup div-nya)
=================================================== --}}

{{-- TABS SELEKTOR TAS --}}
<div class="flex items-center gap-2 mb-6">
  <div class="flex gap-2 overflow-x-auto slim-scroll flex-1 pb-1">
    <template x-for="tas in semuaTas" :key="tas.id">
      <button @click="setAktif(tas.id)"
              class="tas-tab px-4 py-2 rounded-full text-sm font-semibold border flex items-center gap-2 transition-all"
              :class="activeTasId === tas.id
                ? 'bg-[#2C3E50] text-white border-[#2C3E50]'
                : 'bg-white text-gray-700 border-gray-200 hover:border-[#2C3E50] hover:text-[#2C3E50]'">
        <span x-text="tas.nama_tas"></span>
        <span class="text-xs opacity-60" x-text="tas.liter + 'L'"></span>
        <span @click.stop="hapusTas(tas.id)"
              class="w-4 h-4 rounded-full flex items-center justify-center text-xs transition-colors"
              :class="activeTasId === tas.id
                ? 'bg-white/20 hover:bg-white/40 text-white'
                : 'bg-gray-200 hover:bg-red-100 hover:text-red-500 text-gray-500'">
          ✕
        </span>
      </button>
    </template>
  </div>

  {{-- Tombol Tas Baru --}}
  <button @click="$store.tasBuat.open = true"
          class="flex-shrink-0 px-4 py-2 text-sm font-semibold rounded-full flex items-center gap-2 transition-colors"
          style="background: #2C3E50; color: white;">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tas Baru
  </button>
</div>

{{-- PASTE INI: ganti blok tombol kategori di dalam workspace
     (di dalam template x-if="activeTas", bagian Kategori) --}}

  {{-- WORKSPACE UTAMA --}}
  <template x-if="activeTas">
    <div class="grid lg:grid-cols-2 gap-8 items-start">

      {{-- KOLOM KIRI: VISUALISASI TAS --}}
      <div class="space-y-4">
        {{-- Kategori Umur --}}
<div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-2">
  <p class="font-head font-semibold text-navy text-sm">Kategori</p>
  <div class="grid grid-cols-4 gap-1.5">
    <template x-for="kat in ['anak','remaja','dewasa','lansia']" :key="kat">
      <button @click="updateKategori(kat)"
              class="px-2 py-2 border rounded-xl text-xs font-semibold capitalize transition-colors"
              :class="activeTas.kategori===kat
                ? 'bg-[#2C3E50] text-white border-[#2C3E50]'
                : 'bg-white text-gray-700 border-gray-200 hover:border-[#2C3E50] hover:text-[#2C3E50]'">
        <span x-text="kat==='anak'?'Anak':kat.charAt(0).toUpperCase()+kat.slice(1)"></span>
      </button>
    </template>
  </div>
</div>

        {{-- Info Skala Realtime --}}
        <div class="bg-navy/5 rounded-xl px-4 py-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-navy font-medium">
          <span>📐 Tas: <strong x-text="bagCm.p + ' × ' + bagCm.t + ' cm'"></strong></span>
          <span>📦 Zona: <strong x-text="bagCm.p + ' × ' + bagCm.zh + ' cm'"></strong> per area</span>
          <span class="text-gray-400 font-normal">skala: <span x-text="pxPerCm + ' px/cm'"></span></span>
        </div>

        {{-- Kanvas SVG Tas --}}
        <div class="flex flex-col items-center">
          <div id="bag-wrap">
            <svg id="bag-svg" viewBox="0 0 260 340" fill="none" xmlns="http://www.w3.org/2000/svg">
              <ellipse cx="130" cy="334" rx="88" ry="8" fill="#e2ddd6"/>
              <path d="M82 96 Q78 62 88 38 Q97 20 110 20 Q122 20 124 38 L126 96" stroke="#B0A898" stroke-width="12" stroke-linecap="round" fill="none"/>
              <path d="M178 96 Q182 62 172 38 Q163 20 150 20 Q138 20 136 38 L134 96" stroke="#B0A898" stroke-width="12" stroke-linecap="round" fill="none"/>
              <path d="M82 96 Q78 62 88 38 Q97 20 110 20 Q122 20 124 38 L126 96" stroke="#C8BFB4" stroke-width="4" stroke-linecap="round" fill="none"/>
              <path d="M178 96 Q182 62 172 38 Q163 20 150 20 Q138 20 136 38 L134 96" stroke="#C8BFB4" stroke-width="4" stroke-linecap="round" fill="none"/>
              <rect x="96" y="46" width="68" height="12" rx="4" fill="#8C7B6E" stroke="#6E5E55" stroke-width="0.5"/>
              <rect x="122" y="42" width="16" height="20" rx="3" fill="#A08070" stroke="#7A6055" stroke-width="0.5"/>
              <path d="M38 120 Q36 92 64 82 L196 82 Q224 92 222 120 L234 310 Q235 330 212 332 L48 332 Q25 330 26 310 Z" fill="#C8BFB4" stroke="#A09080" stroke-width="1.5"/>
              <path d="M42 120 Q40 96 65 88 L95 85 L94 330 L50 328 Q28 326 28 308 Z" fill="#D4CCC4" opacity="0.4"/>
              <path d="M56 86 L204 86 L210 108 L50 108 Z" fill="#B8AFA6"/>
              <path d="M56 86 Q130 80 204 86" stroke="#6A5A50" stroke-width="2.5" stroke-linecap="round" fill="none"/>
              <circle cx="130" cy="81" r="5" fill="#7A6A60" stroke="#5A4A40" stroke-width="0.5"/>
              <circle cx="130" cy="81" r="2" fill="#3A2A20"/>
              <rect x="125" y="75" width="10" height="8" rx="2" fill="#8C7A6E"/>
              <line x1="46" y1="180" x2="214" y2="180" stroke="#9A8A7A" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.6"/>
              <line x1="46" y1="252" x2="214" y2="252" stroke="#9A8A7A" stroke-width="0.8" stroke-dasharray="4,3" opacity="0.6"/>
            </svg>
            <div id="inner-area">
              <div class="zona" id="zona-a" data-zona="sangat_penting"></div>
              <div class="zona" id="zona-b" data-zona="penting"></div>
              <div class="zona" id="zona-c" data-zona="cukup_penting"></div>
              <div class="ghost-box" id="ghost-box"></div>
            </div>
          </div>

          {{-- Progress Bar Kapasitas Zona --}}
          <div class="w-full mt-3 space-y-1.5">
            <template x-for="z in zonaList" :key="z.key">
              <div class="flex items-center text-xs">
                <span class="zdot flex-shrink-0" :class="'d'+z.short"></span>
                <span class="ml-2 text-gray-500 w-28" x-text="z.label"></span>
                <div class="zona-bar"><div class="zona-bar-fill" :style="'width:'+z.pct+'%;background:'+z.color"></div></div>
                <span class="text-gray-400 w-8 text-right" x-text="z.pct+'%'"></span>
              </div>
            </template>
          </div>

          {{-- Kontrol Layout Otomatis --}}
          <div class="flex gap-2 mt-3 flex-wrap justify-center">
            <button @click="sortAll()" class="px-3 py-1.5 text-xs font-semibold border border-gray-200 rounded-full hover:bg-gray-50 transition-colors">✦ Rapikan Semua</button>
            <button @click="sortZona('sangat_penting')" class="px-3 py-1.5 text-xs font-semibold border border-red-200 text-red-600 rounded-full hover:bg-red-50">🔴 Atas</button>
            <button @click="sortZona('penting')"        class="px-3 py-1.5 text-xs font-semibold border border-orange-200 text-orange-600 rounded-full hover:bg-orange-50">🟠 Tengah</button>
            <button @click="sortZona('cukup_penting')"  class="px-3 py-1.5 text-xs font-semibold border border-green-200 text-green-600 rounded-full hover:bg-green-50">🟢 Bawah</button>
          </div>
          <p class="text-xs text-gray-400 mt-2 text-center">Geser item bebas · Klik 2× untuk hapus dari tas</p>
        </div>
      </div>

      {{-- KOLOM KANAN: DAFTAR ELEMEN ITEM --}}
      <div class="space-y-3">
        {{-- Dimensi Input --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-3">
          <div class="flex items-center justify-between">
            <p class="font-head font-semibold text-navy text-sm">Dimensi Tas</p>
            <span class="text-xs text-gray-400">Liter = P × L × T ÷ 1000</span>
          </div>
          <div class="flex items-center gap-2 flex-wrap">
            <div class="flex flex-col items-center gap-1">
              <label class="text-xs text-gray-400">Panjang (cm)</label>
              <input type="number" class="dim-input" x-model="dimP" @change="updateDimensi()" min="1" max="200" step="0.5"/>
            </div>
            <span class="text-gray-300 mt-4">×</span>
            <div class="flex flex-col items-center gap-1">
              <label class="text-xs text-gray-400">Lebar (cm)</label>
              <input type="number" class="dim-input" x-model="dimL" @change="updateDimensi()" min="1" max="200" step="0.5"/>
            </div>
            <span class="text-gray-300 mt-4">×</span>
            <div class="flex flex-col items-center gap-1">
              <label class="text-xs text-gray-400">Tinggi (cm)</label>
              <input type="number" class="dim-input" x-model="dimT" @change="updateDimensi()" min="1" max="200" step="0.5"/>
            </div>
            <span class="text-gray-300 mt-4">=</span>
            <div class="flex flex-col items-center gap-1">
              <label class="text-xs text-gray-400">Liter</label>
              <div class="dim-input bg-gray-50 text-navy font-bold flex items-center justify-center" x-text="literHitung + ' L'"></div>
            </div>
          </div>
          <p class="text-xs text-gray-400">Mengubah dimensi akan mereset isi tas (skala berubah)</p>
        </div>

        <div class="flex items-center justify-between my-3">
          <h3 class="font-head font-bold text-navy text-lg">Daftar Item</h3>
          <span class="text-xs text-gray-400 capitalize">Rekomendasi: <span x-text="activeTas.kategori"></span></span>
        </div>
        <div class="relative mb-3">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
          <input type="text" x-model="search" placeholder="Cari item..."
                 class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy shadow-sm"/>
        </div>

        <!-- Item Grid with Internal Scroll -->
        <div class="item-scroll-container">
          <div class="grid grid-cols-3 sm:grid-cols-4 gap-3" id="item-grid-blade">
    <template x-for="item in filteredRekomendasi" :key="item.id">
      
      <div :data-item-id="item.id"
           :data-rotated="rotatedIds.includes(item.id) ? '1' : '0'"
           :class="{'used': usedIds.includes(item.id)}"
           draggable="false"
           class="icard relative select-none">

        {{-- Rotate Button --}}
        <button x-show="!usedIds.includes(item.id)"
          @click.stop="toggleRotate(item.id)"
          :class="rotatedIds.includes(item.id) ? 'bg-orange-100 text-orange-500' : 'bg-gray-100 text-gray-400'"
          class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full flex items-center justify-center text-xs hover:opacity-80 transition-all"
          title="Rotate item">
          🔄
        </button>

        {{-- Dimensi Mini Preview --}}
        <div draggable="false" class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden relative">
          <div :style="getPreviewStyle(item)" class="rounded-sm opacity-60 border border-gray-300 bg-gray-300 transition-all duration-200"></div>
        </div>

        <p class="text-xs font-semibold text-navy text-center leading-tight" x-text="item.nama_item"></p>
        <span class="text-xs text-gray-400" x-text="getDimHint(item)"></span>
        <span class="zdot" :class="item.zona_saran==='sangat_penting'?'da':item.zona_saran==='penting'?'db':'dc'"></span>
        <span x-show="usedIds.includes(item.id)" class="text-xs text-gray-400">✓ Sudah</span>
      </div>

    </template>
  </div>
        </div>

        <p class="text-xs text-gray-400 text-center mt-3">
          🔴 Sangat penting &nbsp;·&nbsp; 🟠 Penting &nbsp;·&nbsp; 🟢 Cukup penting<br>
          Item hanya masuk zona yang sesuai · 🔄 untuk rotate · ukuran menyesuaikan dimensi tas
        </p>

        <button @click="saveManual()" 
        class="w-full sm:w-auto px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-xl shadow-md flex items-center justify-center gap-2 transition-all duration-200 transform active:scale-95">
  💾 Simpan Perubahan Tas
</button>

        <a href="{{ route('sesudah') }}" class="flex items-center justify-between bg-green-50 border border-green-200 rounded-2xl px-5 py-4 hover:bg-green-100 transition-colors group">
          <div>
            <p class="font-head font-semibold text-green-700 text-sm">Cek Supply Sesudah Bencana</p>
            <p class="text-xs text-gray-500 mt-0.5">Lihat kelengkapan tas ini di section Sesudah</p>
          </div>
          <svg class="w-5 h-5 text-green-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </template>

  {{-- EMPTY STATE TAS --}}
  <template x-if="!activeTas">
    <div class="text-center py-24">
      <div class="text-7xl mb-4">🎒</div>
      <h3 class="font-head font-bold text-navy text-2xl mb-2">Belum ada tas siaga</h3>
      <p class="text-gray-500 mb-6">Buat tas pertamamu untuk mulai menyusun perlengkapan darurat.</p>
      <button @click="$store.tasBuat.open = true" class="px-6 py-3 bg-navy text-white font-semibold rounded-full hover:opacity-90">Buat Tas Sekarang</button>
    </div>
  </template>
</div>

<div id="drag-ghost"></div>

{{-- MODAL BUAT TAS --}}
<template x-teleport="body">

<div
    x-show="$store.tasBuat.open"

    x-effect="
        document.body.classList.toggle(
            'modal-open',
            $store.tasBuat.open
        )
    "

    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"

    @keydown.escape.window="$store.tasBuat.open=false"

    class="modal-superfront"
    style="display:none"
>

    {{-- BACKDROP --}}
    <div
        class="modal-backdrop"
        @click="$store.tasBuat.open=false">
    </div>

    {{-- BOX --}}
    <div
        class="modal-box relative px-6 pt-8 pb-6"
        @click.stop

        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
    >

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-6">

            <h3 class="font-head font-bold text-navy text-3xl">
                Buat Tas Baru
            </h3>

            {{-- CLOSE BUTTON --}}
            <button
                type="button"
                @click="$store.tasBuat.open=false"

                class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors flex-shrink-0"
            >
                <svg
                    class="w-5 h-5 text-gray-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

        </div>

        <form @submit.prevent="$store.tasBuat.submit()">

            <div class="space-y-5">

                {{-- Nama Tas --}}
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">
                        Nama Tas
                    </label>

                    <input
                        type="text"
                        x-model="$store.tasBuat.form.nama_tas"

                        placeholder="Contoh: Tas Keluarga"

                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl text-sm text-gray-800 focus:outline-none focus:border-navy"

                        required
                    />
                </div>

                {{-- Kategori --}}
                <div>

                    <label class="block text-sm font-semibold text-navy mb-2">
                        Kategori
                    </label>

                    <div class="grid grid-cols-2 gap-2">

                        <template x-for="kat in ['anak','remaja','dewasa','lansia']" :key="kat">

                            <button
                                type="button"

                                @click="$store.tasBuat.form.kategori=kat"

                                :class="$store.tasBuat.form.kategori===kat
                                    ? 'bg-[#2C3E50] text-white border-[#2C3E50]'
                                    : 'bg-white text-gray-700 border-gray-200 hover:border-[#2C3E50] hover:text-[#2C3E50]'"

                                class="px-4 py-3 border rounded-2xl text-sm font-semibold capitalize transition-colors"
                            >

                                <span
                                    x-text="kat==='anak'
                                    ? 'Anak-Anak'
                                    : kat.charAt(0).toUpperCase()+kat.slice(1)"
                                ></span>

                            </button>

                        </template>

                    </div>

                </div>

                {{-- Dimensi --}}
                <div>

                    <label class="block text-sm font-semibold text-navy mb-1">
                        Dimensi Tas
                        <span class="text-gray-400 font-normal text-xs">
                            (cm) — opsional jika isi liter langsung
                        </span>
                    </label>

                    <div class="flex items-center gap-2">

                        {{-- P --}}
                        <div class="flex-1">

                            <p class="text-xs text-gray-500 text-center mb-1">
                                Panjang
                            </p>

                            <input
                                type="number"

                                x-model="$store.tasBuat.form.dim_p"

                                @input="$store.tasBuat.hitungLiter()"

                                placeholder="cm"
                                min="1"
                                max="200"
                                step="0.5"

                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm text-center text-gray-800 focus:outline-none focus:border-navy"
                            />

                        </div>

                        <span class="text-gray-400 mt-4 font-medium">×</span>

                        {{-- L --}}
                        <div class="flex-1">

                            <p class="text-xs text-gray-500 text-center mb-1">
                                Lebar
                            </p>

                            <input
                                type="number"

                                x-model="$store.tasBuat.form.dim_l"

                                @input="$store.tasBuat.hitungLiter()"

                                placeholder="cm"
                                min="1"
                                max="200"
                                step="0.5"

                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm text-center text-gray-800 focus:outline-none focus:border-navy"
                            />

                        </div>

                        <span class="text-gray-400 mt-4 font-medium">×</span>

                        {{-- T --}}
                        <div class="flex-1">

                            <p class="text-xs text-gray-500 text-center mb-1">
                                Tinggi
                            </p>

                            <input
                                type="number"

                                x-model="$store.tasBuat.form.dim_t"

                                @input="$store.tasBuat.hitungLiter()"

                                placeholder="cm"
                                min="1"
                                max="200"
                                step="0.5"

                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm text-center text-gray-800 focus:outline-none focus:border-navy"
                            />

                        </div>

                    </div>

                    {{-- PREVIEW LITER --}}
                    <div
                        x-show="
                            $store.tasBuat.form.dim_p &&
                            $store.tasBuat.form.dim_l &&
                            $store.tasBuat.form.dim_t
                        "

                        class="mt-2 rounded-xl px-3 py-2 flex items-center justify-between"

                        style="background: rgba(44,62,80,0.06);"
                    >

                        <span class="text-xs text-gray-600">
                            Kapasitas dari dimensi:
                        </span>

                        <span
                            class="font-head font-bold text-navy text-sm"
                            x-text="$store.tasBuat.form.liter + ' Liter'"
                        ></span>

                    </div>

                    {{-- INPUT LITER LANGSUNG --}}
                    <div class="mt-3">

                        <p class="text-xs text-gray-500 mb-1">
                            Atau input liter langsung:
                            <span class="text-gray-400">
                                (dimensi dihitung otomatis)
                            </span>
                        </p>

                        <input
                            type="number"

                            x-model="$store.tasBuat.form.liter"

                            @input="
                                if($store.tasBuat.form.liter){
                                    $store.tasBuat.form.dim_p = ''
                                    $store.tasBuat.form.dim_l = ''
                                    $store.tasBuat.form.dim_t = ''
                                }
                            "

                            placeholder="Contoh: 50"

                            min="1"
                            max="500"
                            step="0.1"

                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-navy"
                        />

                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex gap-3 mt-6">

                <button
                    type="button"

                    @click="$store.tasBuat.open=false"

                    class="flex-1 py-3 border border-gray-200 text-gray-700 text-sm font-semibold rounded-2xl hover:bg-gray-50 transition-colors"
                >
                    Batal
                </button>

                <button
                    type="submit"

                    class="flex-1 py-3 text-sm font-semibold rounded-2xl transition-colors"

                    style="background: #2C3E50; color: white;"
                >
                    Buat Tas
                </button>

            </div>

        </form>

    </div>

</div>

</template>

@endsection

@push('scripts')
<script>
// ==========================================
// 1. SERVICE WORKER PWA
// ==========================================
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('PWA: SW terdaftar', reg.scope))
            .catch(err => console.error('PWA: SW gagal', err));
    });
}

// ==========================================
// 2. DATA EDUKASI BENCANA (DIPERBARUI)
// ==========================================
const fullData = {
    gempa: [
        {title: "1. Kenali Risiko", desc: "Pastikan rumah aman."}, {title: "2. Amankan Area", desc: "Ikat furnitur."}, {title: "3. Jalur Evakuasi", desc: "Cek titik kumpul."},
        {title: "4. Simulasi", desc: "Latihan rutin."}, {title: "5. P3K", desc: "Siapkan obat."}, {title: "6. Kontak", desc: "Nomor darurat."}
    ],
    banjir: [
        {title: "1. Cek Drainase", desc: "Bersihkan sampah."}, {title: "2. Simpan Dokumen", desc: "Plastik kedap air."}, {title: "3. Pahami Jalur", desc: "Lokasi pengungsian."},
        {title: "4. Listrik", desc: "Matikan saklar."}, {title: "5. Barang", desc: "Pindah ke tinggi."}, {title: "6. Info", desc: "Pantau cuaca."}
    ],
    longsor: [
        {title: "1. Cek Retakan", desc: "Waspadai tebing."}, {title: "2. Penghijauan", desc: "Tanam pohon."}, {title: "3. Tanggap Bunyi", desc: "Evakuasi segera."},
        {title: "4. Saluran", desc: "Jangan gali lereng."}, {title: "5. Area", desc: "Hindari bawah tebing."}, {title: "6. Evakuasi", desc: "Cari tempat aman."}
    ]
};

let currentCat = 'gempa';
let currentPage = 0;

function renderGrid() {
    const grid = document.getElementById('content-grid');
    if (!grid) return;
    
    // Tambahkan class loading untuk animasi fade
    grid.classList.add('fade-loading');
    
    // Potong data jadi 3 per halaman
    const items = fullData[currentCat].slice(currentPage * 3, (currentPage * 3) + 3);
    
    // Gunakan setTimeout agar animasi fade out terlihat sebelum konten berubah
    setTimeout(() => {
        grid.innerHTML = items.map((item, idx) => `
            <div class="info-card" style="animation-delay: ${idx * 0.1}s">
                <div class="img-box"></div>
                <h3 class="font-bold text-lg mb-2">${item.title}</h3>
                <p class="text-sm text-gray-500">${item.desc}</p>
            </div>
        `).join('');
        
        // Hapus class loading untuk menampilkan dengan fade in
        grid.classList.remove('fade-loading');
    }, 150);
}

// Event Delegation (Tahan Banting)
document.getElementById('category-container').addEventListener('click', (e) => {
    const btn = e.target.closest('.category-btn');
    if (btn) {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentCat = btn.getAttribute('data-category');
        
        currentPage = 0; // Halaman data sudah direset ke 0

        // ====================================================================
        // TAMBAHKAN 2 BARIS INI UNTUK MERESET TOMBOL PAGINATION / STEP ANGKA:
        // ====================================================================
        document.querySelectorAll('.step-btn').forEach(b => b.classList.remove('active'));
        document.querySelector('.step-btn[data-page="0"]').classList.add('active');
        // ====================================================================

        renderGrid();
    }
});

document.getElementById('step-container').addEventListener('click', (e) => {
    const btn = e.target.closest('.step-btn');
    if (btn) {
        document.querySelectorAll('.step-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentPage = parseInt(btn.getAttribute('data-page'));
        renderGrid();
    }
});

renderGrid(); // Jalankan pertama kali


// ==========================================
// 3. DRAG ENGINE CONSTANTS
// ==========================================
const ITEM_CM = {
    'Air Minum': {w:7,h:23}, 'Senter': {w:5,h:10}, 'Susu/Formula': {w:8,h:22},
    'Radio Portabel': {w:12,h:18}, 'Alat bantu': {w:8,h:25}, 'P3K': {w:20,h:5},
    'Masker': {w:7,h:2}, 'Makanan Kaleng': {w:5,h:8}, 'Dokumen Penting': {w:22,h:3},
    'Uang Tunai': {w:18,h:3}, 'Popok': {w:20,h:8}, 'Selimut darurat': {w:25,h:6},
    'Peluit darurat': {w:4,h:4}, 'Korek api': {w:2,h:4}, 'Baju ganti': {w:25,h:6},
    'Tali': {w:5,h:5}, 'Obat Pribadi': {w:10,h:8}, 'Power Bank': {w:10,h:14},
    'Obat Anak': {w:8,h:8}, 'Mainan kecil': {w:10,h:10}, 'Obat Rutin': {w:8,h:8},
    'Kacamata cadangan': {w:15,h:6}
};
const DEFAULT_CM = {w:10, h:10};

const BAG_W    = 168;
const ZONA_H   = {sangat_penting:72, penting:72, cukup_penting:74};
const ZONA_TOP = {sangat_penting:0,  penting:72, cukup_penting:144};
const ZONA_KEY = {sangat_penting:'a', penting:'b', cukup_penting:'c'};
const ZONA_CLR = {sangat_penting:'#C0392B', penting:'#E67E22', cukup_penting:'#27AE60'};

let placed   = {sangat_penting:[], penting:[], cukup_penting:[]};
let dragging = null;
let PX_PER_CM = 3;

// ==========================================
// 4. DRAG HELPER FUNCTIONS
// ==========================================
function getPos(e) {
    if (e.touches && e.touches.length > 0)
        return {x: e.touches[0].clientX, y: e.touches[0].clientY};
    if (e.changedTouches && e.changedTouches.length > 0)
        return {x: e.changedTouches[0].clientX, y: e.changedTouches[0].clientY};
    return {x: e.clientX, y: e.clientY};
}

function getZonaAt(relY) {
    if (relY >= 0   && relY < 72)  return 'sangat_penting';
    if (relY >= 72  && relY < 144) return 'penting';
    if (relY >= 144 && relY <= 218) return 'cukup_penting';
    return null;
}

function rectsOverlap(a, b) {
    return !(a.x+a.w<=b.x || b.x+b.w<=a.x || a.y+a.h<=b.y || b.y+b.h<=a.y);
}

function findSnap(zona, px, prefX, prefY, excludeUid=null) {
    const zt = ZONA_TOP[zona], zh = ZONA_H[zona];
    const others = placed[zona].filter(p => p.uid !== excludeUid);
    const cX = x => Math.max(0, Math.min(BAG_W - px.w, x));
    const cY = y => Math.max(zt, Math.min(zt + zh - px.h, y));
    const cx = cX(prefX), cy = cY(prefY);
    const c = {x:cx, y:cy, w:px.w, h:px.h};
    if (!others.some(o => rectsOverlap(c, {x:o.x,y:o.y,w:o.px.w,h:o.px.h})))
        return {x:cx, y:cy, valid:true};
    let best=null, bestD=Infinity;
    for (let dy=-zh; dy<=zh; dy+=2) {
        for (let dx=-BAG_W; dx<=BAG_W; dx+=2) {
            const tx=cX(prefX+dx), ty=cY(prefY+dy);
            const tc={x:tx,y:ty,w:px.w,h:px.h};
            if (!others.some(o=>rectsOverlap(tc,{x:o.x,y:o.y,w:o.px.w,h:o.px.h}))) {
                const d=Math.hypot(tx-prefX, ty-prefY);
                if (d<bestD) { bestD=d; best={x:tx,y:ty}; }
            }
        }
    }
    return best ? {...best, valid:true} : {x:cx, y:cy, valid:false};
}

function sortZona(zona) {
    const items = [...placed[zona]].sort((a,b) => b.px.w!==a.px.w ? b.px.w-a.px.w : b.px.h-a.px.h);
    const zt = ZONA_TOP[zona];
    let cx=0, cy=zt, rowH=0;
    placed[zona] = [];
    items.forEach(p => {
        if (cx+p.px.w > BAG_W) { cx=0; cy+=rowH; rowH=0; }
        if (cy+p.px.h > zt+ZONA_H[zona]) return;
        p.x=cx; p.y=cy; cx+=p.px.w; rowH=Math.max(rowH,p.px.h);
        placed[zona].push(p);
        if (p.el) { p.el.style.left=p.x+'px'; p.el.style.top=p.y+'px'; }
    });
}

function clearHL() {
    ['zona-a','zona-b','zona-c'].forEach(id => document.getElementById(id)?.classList.remove('drag-v','drag-iv'));
}

function makeSvg(nama, zona, w, h) {
    const fill = ZONA_CLR[zona] || '#888';
    const fs = Math.max(6, Math.min(10, Math.round(Math.min(w,h) / 3.5)));
    const maxChar = Math.floor(w / (fs * 0.62));
    const label = nama.length > maxChar ? nama.slice(0, maxChar-1) + '…' : nama;
    return `<svg width="${w}" height="${h}" viewBox="0 0 ${w} ${h}" xmlns="http://www.w3.org/2000/svg">
        <rect width="${w}" height="${h}" rx="3" fill="${fill}" opacity="0.18" stroke="${fill}" stroke-width="1.5"/>
        <text x="${w/2}" y="${h/2+fs*0.38}" text-anchor="middle" font-size="${fs}" fill="${fill}" font-weight="700" font-family="sans-serif">${label}</text>
    </svg>`;
}

function createPlacedEl(p) {
    const el = document.createElement('div');
    el.className = 'placed-item';
    el.dataset.itemId = p.itemId;
    el.style.cssText = `left:${p.x}px;top:${p.y}px;width:${p.px.w}px;height:${p.px.h}px;z-index:10;position:absolute;cursor:move`;
    el.innerHTML = makeSvg(p.namaItem, p.zona, p.px.w, p.px.h);
    el.title = 'Geser bebas · Klik 2× hapus';
    el.addEventListener('mousedown', e => startDragPlaced(e, p, el));
    el.addEventListener('touchstart', e => startDragPlaced(e, p, el), {passive:false});
    el.addEventListener('dblclick', e => {
        e.stopPropagation();
        el.remove();
        placed[p.zona] = placed[p.zona].filter(x => x !== p);
        const card = document.querySelector(`[data-item-id="${p.itemId}"]`);
        if (card) card.classList.remove('used');
        window.dispatchEvent(new CustomEvent('item-removed', {detail:{id: p.itemId}}));
        window.dispatchEvent(new CustomEvent('update-stats'));
    });
    document.getElementById('inner-area')?.appendChild(el);
    p.el = el; // simpan referensi el ke dalam objek p
    return el;
}

function startDragCard(e, itemId, namaItem, zonaSaran, rotated=false) {
    const pos = getPos(e);
    const baseCm = ITEM_CM[namaItem] || DEFAULT_CM;
    const cm = rotated ? {w: baseCm.h, h: baseCm.w} : baseCm;
    const px = {
        w: Math.max(10, Math.round(cm.w * PX_PER_CM)),
        h: Math.max(8,  Math.round(cm.h * PX_PER_CM)),
    };
    dragging = {itemId, namaItem, zonaSaran, px, isNew:true, placed:null, rotated, offX:px.w/2, offY:px.h/2};
    let dg = document.getElementById('drag-ghost');
    if (!dg) { dg = document.createElement('div'); dg.id='drag-ghost'; document.body.appendChild(dg); }
    dg.innerHTML = makeSvg(namaItem, zonaSaran, px.w, px.h);
    dg.style.cssText = 'position:fixed;z-index:99999;pointer-events:none;display:block;left:0;top:0';
    moveGhost(pos.x, pos.y);
    bindMove();
}

function startDragPlaced(e, p, el) {
    e.preventDefault(); e.stopPropagation();
    const pos = getPos(e);
    const rect = el.getBoundingClientRect();
    dragging = {itemId:p.itemId, namaItem:p.namaItem, zonaSaran:p.zona, px:p.px, isNew:false, placed:p, offX:pos.x-rect.left, offY:pos.y-rect.top};
    const dg = document.getElementById('drag-ghost');
    dg.innerHTML = makeSvg(p.namaItem, p.zona, p.px.w, p.px.h);
    dg.style.display = 'block';
    el.classList.add('dp');
    moveGhost(pos.x, pos.y);
    bindMove();
}

function moveGhost(cx, cy) {
    const dg = document.getElementById('drag-ghost');
    if (dg && dragging) {
        dg.style.left  = '0px';
        dg.style.top   = '0px';
        dg.style.transform = `translate3d(${cx-(dragging.offX||0)}px,${cy-(dragging.offY||0)}px,0)`;
    }
}

function bindMove() {
    document.addEventListener('mousemove', onMove);
    document.addEventListener('mouseup',   onUp);
    document.addEventListener('touchmove', onMove, {passive:false});
    document.addEventListener('touchend',  onUp,   {passive:false});
}

function unbindMove() {
    document.removeEventListener('mousemove', onMove);
    document.removeEventListener('mouseup',   onUp);
    document.removeEventListener('touchmove', onMove);
    document.removeEventListener('touchend',  onUp);
}

function onMove(e) {
    if (!dragging) return;
    if (e.cancelable) e.preventDefault();
    const pos = getPos(e);
    if (!pos || isNaN(pos.x) || isNaN(pos.y)) return;
    moveGhost(pos.x, pos.y);
    const ia = document.getElementById('inner-area');
    if (!ia) return;
    const ir   = ia.getBoundingClientRect();
    const offX = dragging.offX ?? dragging.px.w/2;
    const offY = dragging.offY ?? dragging.px.h/2;
    const relX = pos.x - ir.left - offX;
    const relY = pos.y - ir.top  - offY;
    const zona = getZonaAt(relY + dragging.px.h/2);
    clearHL();
    const gb = document.getElementById('ghost-box');
    if (!zona) { if (gb) gb.style.display='none'; return; }
    const valid = zona === dragging.zonaSaran;
    document.getElementById('zona-'+ZONA_KEY[zona])?.classList.add(valid ? 'drag-v' : 'drag-iv');
    if (!valid) { if (gb) gb.style.display='none'; return; }
    const excl = dragging.isNew ? null : dragging.placed.uid;
    const snap = findSnap(zona, dragging.px, relX, relY, excl);
    const overflowH = dragging.px.h > ZONA_H[zona];
    if (gb) {
        gb.style.cssText = `display:block;left:${snap.x}px;top:${snap.y}px;width:${dragging.px.w}px;height:${dragging.px.h}px;z-index:40;`;
        gb.className = 'ghost-box' + (snap.valid && !overflowH ? '' : ' bad');
    }
}

function onUp(e) {
    if (!dragging) return;
    unbindMove();
    const dg = document.getElementById('drag-ghost');
    const gb = document.getElementById('ghost-box');
    if (dg) dg.style.display = 'none';
    if (gb) gb.style.display = 'none';
    clearHL();
    const pos  = getPos(e);
    const ia   = document.getElementById('inner-area');
    if (!ia) { dragging=null; return; }
    const ir   = ia.getBoundingClientRect();
    const offX = dragging.offX ?? dragging.px.w/2;
    const offY = dragging.offY ?? dragging.px.h/2;
    const relX = pos.x - ir.left - offX;
    const relY = pos.y - ir.top  - offY;
    const zona = getZonaAt(relY + dragging.px.h/2);

    if (!zona || zona !== dragging.zonaSaran) {
        const te = zona ? document.getElementById('zona-'+ZONA_KEY[zona]) : null;
        if (te) { te.classList.add('do-shake'); setTimeout(()=>te.classList.remove('do-shake'),350); }
        if (!dragging.isNew) dragging.placed.el?.classList.remove('dp');
        dragging=null; return;
    }
    if (dragging.px.h > ZONA_H[zona]) {
        const te = document.getElementById('zona-'+ZONA_KEY[zona]);
        if (te) { te.classList.add('do-shake'); setTimeout(()=>te.classList.remove('do-shake'),350); }
        if (!dragging.isNew) dragging.placed.el?.classList.remove('dp');
        showToast('Item terlalu tinggi — coba rotate 🔄');
        dragging=null; return;
    }
    if (dragging.px.w > BAG_W) {
        const te = document.getElementById('zona-'+ZONA_KEY[zona]);
        if (te) { te.classList.add('do-shake'); setTimeout(()=>te.classList.remove('do-shake'),350); }
        if (!dragging.isNew) dragging.placed.el?.classList.remove('dp');
        showToast('Item terlalu lebar untuk tas ini');
        dragging=null; return;
    }

    const excl = dragging.isNew ? null : dragging.placed.uid;
    const snap = findSnap(zona, dragging.px, relX, relY, excl);

    if (dragging.isNew) {
        const uid = 'p_'+Date.now()+Math.random().toString(36).slice(2,5);
        const p = {uid, itemId:dragging.itemId, namaItem:dragging.namaItem, zona, px:dragging.px, x:snap.x, y:snap.y, rotated:dragging.rotated||false};
        placed[zona].push(p);
        createPlacedEl(p);
        window.dispatchEvent(new CustomEvent('item-placed', {detail:{id:dragging.itemId, namaItem:dragging.namaItem, zona_saran:zona, x:snap.x, y:snap.y, rotated:dragging.rotated||false}}));
    } else {
        dragging.placed.x = snap.x;
        dragging.placed.y = snap.y;
        if (dragging.placed.el) {
            dragging.placed.el.style.left = snap.x+'px';
            dragging.placed.el.style.top  = snap.y+'px';
            dragging.placed.el.classList.remove('dp');
        }
    }
    dragging = null;
    window.dispatchEvent(new CustomEvent('update-stats'));
}

let toastTimer = null;
function showToast(msg) {
    let toast = document.getElementById('bag-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'bag-toast';
        toast.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#1a252f;color:#fff;padding:8px 18px;border-radius:24px;font-size:13px;z-index:9999;pointer-events:none;transition:opacity .3s;white-space:nowrap';
        document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.style.opacity = '1';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(()=>{ toast.style.opacity='0'; }, 2500);
}

// ==========================================
// 5. ALPINE STORE BUAT TAS
// ==========================================
document.addEventListener('alpine:init', () => {
    Alpine.store('tasBuat', {
        open: false,
        form: {nama_tas:'', kategori:'dewasa', liter:'', dim_p:'', dim_l:'', dim_t:''},
        hitungLiter() {
            const p=parseFloat(this.form.dim_p), l=parseFloat(this.form.dim_l), t=parseFloat(this.form.dim_t);
            if (p>0&&l>0&&t>0) this.form.liter = parseFloat((p*l*t/1000).toFixed(1));
        },
        async submit() {
            if (!this.form.nama_tas || !this.form.kategori || !this.form.liter) return;
            const hasDim = this.form.dim_p && this.form.dim_l && this.form.dim_t;
            const newTasObj = {
                id: 'local_'+Date.now(),
                nama_tas: this.form.nama_tas,
                kategori: this.form.kategori,
                liter: parseFloat(this.form.liter),
                // Simpan 0 jika tidak diisi — calcScale() akan reverse-calculate dari liter
                dim_p: hasDim ? parseFloat(this.form.dim_p) : 0,
                dim_l: hasDim ? parseFloat(this.form.dim_l) : 0,
                dim_t: hasDim ? parseFloat(this.form.dim_t) : 0,
                items: []
            };
            this.open = false;
            this.form = {nama_tas:'', kategori:'dewasa', liter:'', dim_p:'', dim_l:'', dim_t:''};
            window.dispatchEvent(new CustomEvent('tas-local-created', {detail: newTasObj}));
        }
    });

    // ==========================================
    // 6. ALPINE COMPONENT UTAMA — SATU init() SAJA
    // ==========================================
    Alpine.data('tasSiaga', () => ({
        semuaTas:    @json($semuaTas ?? []),
        activeTasId: {{ $activeTas?->id ?? 'null' }},
        activeTas:   null,
        rekomendasi: [],
        search:      '',
        dimP:'', dimL:'', dimT:'',
        usedIds:    [],
        rotatedIds: [],
        bagCm:      {p:0, t:0, zh:0},
        pxPerCm:    3,
        zonaList: [
            {key:'sangat_penting', label:'Sangat penting', short:'a', color:'#C0392B', pct:0},
            {key:'penting',        label:'Penting',         short:'b', color:'#E67E22', pct:0},
            {key:'cukup_penting',  label:'Cukup penting',   short:'c', color:'#27AE60', pct:0},
        ],

        get filteredRekomendasi() {
            if (!this.search) return this.rekomendasi;
            return this.rekomendasi.filter(i => i.nama_item.toLowerCase().includes(this.search.toLowerCase()));
        },
        get literHitung() {
            const p=parseFloat(this.dimP), l=parseFloat(this.dimL), t=parseFloat(this.dimT);
            return (p>0&&l>0&&t>0) ? parseFloat((p*l*t/1000).toFixed(1)) : (this.activeTas?.liter ?? 0);
        },

        // ── SATU-SATUNYA init() ──
        async init() {
            // 1. Load dari localStorage dulu
            const raw = localStorage.getItem('tas_siaga_offline_data');
            if (raw) {
                try {
                    const parsed = JSON.parse(raw);
                    if (parsed.semuaTas?.length)  this.semuaTas    = parsed.semuaTas;
                    if (parsed.activeTasId)        this.activeTasId = parsed.activeTasId;
                    if (parsed.rekomendasi?.length) this.rekomendasi = parsed.rekomendasi;
                } catch(e) { console.warn('LocalStorage parse error', e); }
            }

            await this.$nextTick();
            await this.syncActiveTas();

            // 2. Restore item ke kanvas dari data yang tersimpan
            this.restoreItemsToCanvas();

            // 3. Init delegation drag kartu
            this.initCardDelegation();

            // 4. Event listeners
            window.addEventListener('tas-local-created', async e => {
                this.semuaTas.push(e.detail);
                await this.setAktif(e.detail.id);
            });

            window.addEventListener('item-placed', e => {
                const id = e.detail.id;
                if (!this.usedIds.includes(id)) this.usedIds.push(id);

                // Update items di activeTas (cegah duplikat)
                const tas = this.semuaTas.find(t => String(t.id) === String(this.activeTasId));
                if (tas) {
                    if (!tas.items) tas.items = [];
                    const exists = tas.items.some(i => String(i.id_item || i.id) === String(id));
                    if (!exists) {
                        tas.items.push({
                            id_item:   id,
                            id:        id,
                            nama_item: e.detail.namaItem || '',
                            zona_saran:e.detail.zona_saran || '',
                            x:         e.detail.x || 0,
                            y:         e.detail.y || 0,
                            rotated:   e.detail.rotated || false
                        });
                    }
                }
                this.recalcStats();
            });

            window.addEventListener('item-removed', e => {
                const id = e.detail.id;
                this.usedIds = this.usedIds.filter(x => x !== id);
                const tas = this.semuaTas.find(t => String(t.id) === String(this.activeTasId));
                if (tas?.items) {
                    tas.items = tas.items.filter(i => String(i.id_item || i.id) !== String(id));
                }
                this.recalcStats();
            });

            window.addEventListener('update-stats', () => this.recalcStats());
        },

        // ── RESTORE: gambar ulang item dari activeTas.items ke kanvas ──
        restoreItemsToCanvas() {
            const tas = this.semuaTas.find(t => String(t.id) === String(this.activeTasId));
            if (!tas?.items?.length) return;

            // Bersihkan kanvas dulu
            document.getElementById('inner-area')?.querySelectorAll('.placed-item').forEach(el => el.remove());
            placed = {sangat_penting:[], penting:[], cukup_penting:[]};

            tas.items.forEach(item => {
                const id       = item.id_item || item.id;
                const namaItem = item.nama_item || '';
                const zona     = item.zona_saran;
                if (!zona || !ZONA_H[zona]) return;

                const baseCm = ITEM_CM[namaItem] || DEFAULT_CM;
                const cm     = item.rotated ? {w:baseCm.h, h:baseCm.w} : baseCm;
                const px     = {
                    w: Math.max(10, Math.round(cm.w * PX_PER_CM)),
                    h: Math.max(8,  Math.round(cm.h * PX_PER_CM)),
                };
                const x = item.x ?? 0;
                const y = item.y ?? ZONA_TOP[zona];

                const p = {uid:'r_'+id+'_'+Date.now(), itemId:id, namaItem, zona, px, x, y, rotated:!!item.rotated};
                placed[zona].push(p);
                createPlacedEl(p);

                if (!this.usedIds.includes(id)) this.usedIds.push(id);
            });

            this.recalcStats();
        },

        // ── SAVE: sync posisi dari kanvas (placed) → semuaTas → localStorage ──
        syncPlacedToState() {
            const tas = this.semuaTas.find(t => String(t.id) === String(this.activeTasId));
            if (!tas) return;

            // Kumpulkan semua item dari kanvas dengan posisi terkini
            const allPlaced = [
                ...placed.sangat_penting,
                ...placed.penting,
                ...placed.cukup_penting
            ];

            tas.items = allPlaced.map(p => ({
                id_item:    p.itemId,
                id:         p.itemId,
                nama_item:  p.namaItem,
                zona_saran: p.zona,
                x:          p.x,
                y:          p.y,
                rotated:    p.rotated || false
            }));
        },

        saveToLocal() {
            // Sync posisi terkini dari kanvas ke state sebelum simpan
            this.syncPlacedToState();

            const dataToSave = {
                semuaTas:    this.semuaTas,
                activeTasId: this.activeTasId,
                rekomendasi: this.rekomendasi
            };
            localStorage.setItem('tas_siaga_offline_data', JSON.stringify(dataToSave));
            console.log('💾 Tersimpan ke localStorage');

            // Coba sync ke server jika online
            if (navigator.onLine) this.syncToServer();
        },

        // ── TOMBOL SIMPAN MANUAL ──
        saveManual() {
            this.saveToLocal();
            showToast('🎉 Tata letak tas berhasil disimpan!');
        },

        async syncToServer() {
            try {
                await fetch('/api/tas-siaga/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({semuaTas: this.semuaTas, activeTasId: this.activeTasId})
                });
            } catch(e) {
                console.log('Server unreachable, data tersimpan lokal.');
            }
        },

        async syncActiveTas() {
            this.activeTas = this.semuaTas.find(t => String(t.id) === String(this.activeTasId)) || null;
            if (!this.activeTas && this.semuaTas.length > 0) {
                this.activeTas    = this.semuaTas[0];
                this.activeTasId  = this.semuaTas[0].id;
            }
            if (this.activeTas) {
                this.dimP    = String(this.activeTas.dim_p ?? '');
                this.dimL    = String(this.activeTas.dim_l ?? '');
                this.dimT    = String(this.activeTas.dim_t ?? '');
                this.usedIds = (this.activeTas.items || []).map(i => i.id_item || i.id);
                this.calcScale();
                if (navigator.onLine) await this.loadRekomendasi();
            }
        },

        calcScale() {
            const rawP = parseFloat(this.dimP);
            const rawL = parseFloat(this.dimL);
            const rawT = parseFloat(this.dimT);
            const hasDim = rawP > 0 && rawL > 0 && rawT > 0;

            let p, l, t;

            if (hasDim) {
                // Dimensi lengkap — pakai apa adanya
                p = rawP; l = rawL; t = rawT;
            } else {
                // Hanya liter diisi — derive dimensi dengan proporsi standar P:L:T = 1:0.6:1.4
                // V = P*(0.6P)*(1.4P) = 0.84*P³  →  P = cbrt(liter*1000/0.84)
                const liter = parseFloat(this.activeTas?.liter) || 30;
                const volCm3 = liter * 1000;
                p = Math.round(Math.cbrt(volCm3 / 0.84) * 10) / 10;
                l = Math.round(p * 0.6 * 10) / 10;
                t = Math.round(p * 1.4 * 10) / 10;
                // Sync balik ke field input supaya user bisa lihat
                this.dimP = String(p);
                this.dimL = String(l);
                this.dimT = String(t);
                if (this.activeTas) {
                    this.activeTas.dim_p = p;
                    this.activeTas.dim_l = l;
                    this.activeTas.dim_t = t;
                }
            }

            const zh = Math.round(t / 3);
            PX_PER_CM    = Math.min(BAG_W / p, 72 / zh);
            this.pxPerCm = Math.round(PX_PER_CM * 10) / 10;
            this.bagCm   = {p, t, zh};
            // Reset kanvas saat skala berubah
            placed = {sangat_penting:[], penting:[], cukup_penting:[]};
            document.getElementById('inner-area')?.querySelectorAll('.placed-item').forEach(el => el.remove());
            this.usedIds = [];
            this.recalcStats();
        },

        recalcStats() {
            this.zonaList = this.zonaList.map(z => {
                const total = BAG_W * ZONA_H[z.key];
                const used  = placed[z.key].reduce((s,p)=>s+p.px.w*p.px.h, 0);
                return {...z, pct: Math.min(100, Math.round(used/total*100))};
            });
        },

        async setAktif(id) {
            // Simpan state tas sekarang sebelum pindah
            this.syncPlacedToState();
            this.activeTasId = id;
            await this.syncActiveTas();
            this.restoreItemsToCanvas();
            this.saveToLocal();
        },

        async hapusTas(id) {
            if (!confirm('Hapus tas ini?')) return;
            this.semuaTas    = this.semuaTas.filter(t => t.id !== id);
            if (String(this.activeTasId) === String(id)) {
                this.activeTasId = this.semuaTas[0]?.id ?? null;
            }
            await this.syncActiveTas();
            this.restoreItemsToCanvas();
            this.saveToLocal();
        },

        async updateDimensi() {
            if (!this.activeTas) return;
            const p = parseFloat(this.dimP);
            const l = parseFloat(this.dimL);
            const t = parseFloat(this.dimT);
            if (p > 0) this.activeTas.dim_p = p;
            if (l > 0) this.activeTas.dim_l = l;
            if (t > 0) this.activeTas.dim_t = t;
            // Hitung liter dari dimensi kalau lengkap, atau pakai activeTas.liter kalau hanya liter yg diisi
            if (p > 0 && l > 0 && t > 0) {
                this.activeTas.liter = Math.round((p * l * t / 1000) * 10) / 10;
            }
            this.calcScale();
            this.saveToLocal();
        },

        // Dipanggil saat user input liter langsung (tanpa isi dimensi P/L/T)
        updateLiterLangsung(liter) {
            if (!this.activeTas) return;
            const val = parseFloat(liter);
            if (!val || val <= 0) return;
            this.activeTas.liter = val;
            // Kosongkan dim agar calcScale tahu ini mode liter-only
            this.dimP = ''; this.dimL = ''; this.dimT = '';
            this.activeTas.dim_p = 0;
            this.activeTas.dim_l = 0;
            this.activeTas.dim_t = 0;
            this.calcScale();
            this.saveToLocal();
        },

        async updateKategori(kat) {
            if (!this.activeTas) return;
            this.activeTas.kategori = kat;
            if (navigator.onLine) await this.loadRekomendasi();
            this.saveToLocal();
        },

        async loadRekomendasi() {
            if (!this.activeTas) return;
            try {
                const res = await fetch(`/api/tas/rekomendasi/${this.activeTas.kategori}`);
                if (res.ok) {
                    this.rekomendasi = await res.json();
                    // Update backup rekomendasi di localStorage
                    const raw = localStorage.getItem('tas_siaga_offline_data');
                    if (raw) {
                        const d = JSON.parse(raw);
                        d.rekomendasi = this.rekomendasi;
                        localStorage.setItem('tas_siaga_offline_data', JSON.stringify(d));
                    }
                }
            } catch(e) { console.log('Gagal load rekomendasi dari server.'); }
        },

        toggleRotate(itemId) {
            if (this.rotatedIds.includes(itemId)) {
                this.rotatedIds = this.rotatedIds.filter(x => x !== itemId);
            } else {
                this.rotatedIds.push(itemId);
            }
        },

        getPreviewStyle(item) {
            const cm      = ITEM_CM[item.nama_item] || DEFAULT_CM;
            const rotated = this.rotatedIds.includes(item.id);
            const rawW    = rotated ? cm.h : cm.w;
            const rawH    = rotated ? cm.w : cm.h;
            const scale   = Math.min(40/rawW, 40/rawH);
            const pw = Math.round(rawW * scale);
            const ph = Math.round(rawH * scale);
            const zona  = item.zona_saran;
            const color = zona==='sangat_penting'?'#C0392B':zona==='penting'?'#E67E22':'#27AE60';
            return `width:${pw}px;height:${ph}px;background:${color};opacity:0.25;border:1.5px solid ${color}`;
        },

        getDimHint(item) {
            const cm      = ITEM_CM[item.nama_item] || DEFAULT_CM;
            const rotated = this.rotatedIds.includes(item.id);
            return `${rotated?cm.h:cm.w}×${rotated?cm.w:cm.h}cm`;
        },

        initCardDelegation() {
            this.$nextTick(() => {
                const grid = document.getElementById('item-grid-blade');
                if (!grid || grid._delegated) return;
                grid._delegated = true;
                const handler = (e) => {
                    if (e.type==='mousedown' && e.button!==0) return;
                    if (e.target.closest('button')) return;
                    const card = e.target.closest('.icard');
                    if (!card || card.classList.contains('used')) return;
                    if (e.cancelable) e.preventDefault();
                    const id   = card.dataset.itemId || card.dataset.id;
                    const item = this.rekomendasi.find(r => String(r.id) === String(id));
                    if (!item) return;
                    const rotated = this.rotatedIds.includes(parseInt(id));
                    startDragCard(e, item.id, item.nama_item, item.zona_saran, rotated);
                };
                grid.addEventListener('mousedown', handler);
                grid.addEventListener('touchstart', handler, {passive:false});
            });
        },

        sortZona(zona) { sortZona(zona); this.recalcStats(); },
        sortAll()      { ['sangat_penting','penting','cukup_penting'].forEach(z=>sortZona(z)); this.recalcStats(); },
    }));
});

</script>
@endpush