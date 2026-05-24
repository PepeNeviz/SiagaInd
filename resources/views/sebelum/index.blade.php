@extends('layouts.app')

@section('title', 'Sebelum — Tas Siaga')

@push('styles')
<style>
#bag-wrap{position:relative;width:260px;user-select:none}
#bag-svg{width:260px;display:block}
#inner-area{position:absolute;top:108px;left:46px;width:168px;height:218px;overflow:hidden}
.zona{position:absolute;left:0;width:168px;transition:background .15s,box-shadow .15s}
#zona-a{top:0;height:72px;background:rgba(192,57,43,.04);border-bottom:1px dashed rgba(192,57,43,.25)}
#zona-b{top:72px;height:72px;background:rgba(230,126,34,.04);border-bottom:1px dashed rgba(230,126,34,.25)}
#zona-c{top:144px;height:74px;background:rgba(39,174,96,.04)}
.zona.drag-v{background:rgba(39,174,96,.18)!important;box-shadow:inset 0 0 0 2px #27AE60}
.zona.drag-iv{background:rgba(192,57,43,.13)!important;box-shadow:inset 0 0 0 2px #C0392B}
@keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
.do-shake{animation:shake .3s ease}
.placed{position:absolute;cursor:grab;border-radius:3px;transition:opacity .15s}
.placed:active{cursor:grabbing}
.placed.dp{opacity:.3}
.ghost-box{position:absolute;pointer-events:none;border:2px dashed #27AE60;border-radius:4px;background:rgba(39,174,96,.12);z-index:40;display:none}
.ghost-box.bad{border-color:#C0392B;background:rgba(192,57,43,.1)}
.tas-tab{white-space:nowrap;transition:all .2s}
.tas-tab.active{background:#2C3E50;color:#fff;border-color:#2C3E50}
.slim-scroll::-webkit-scrollbar{height:0}
.icard{border:.5px solid #e5e7eb;border-radius:12px;padding:8px 6px 6px;display:flex;flex-direction:column;align-items:center;gap:4px;cursor:grab;background:#fff;transition:opacity .2s}
.icard:active{cursor:grabbing}
.icard.used{opacity:.32;cursor:default;pointer-events:none}
.zdot{width:6px;height:6px;border-radius:50%}
.da{background:#C0392B}.db{background:#E67E22}.dc{background:#27AE60}
.zona-bar{height:5px;border-radius:3px;background:#e5e7eb;overflow:hidden;flex:1;margin:0 8px}
.zona-bar-fill{height:100%;border-radius:3px;transition:width .3s}
#drag-ghost{position:fixed;pointer-events:none;z-index:9999;display:none;transform:translate(-50%,-50%);opacity:.82}
.dim-input{width:64px;padding:4px 8px;border:1px solid #e5e7eb;border-radius:8px;font-size:12px;text-align:center;outline:none}
.dim-input:focus{border-color:#2C3E50}
@keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease forwards;
        }
</style>
@endpush

@section('content')
<div x-data="tasSiaga()" x-init="init()" class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

  <body class="bg-gray-50 min-h-screen p-8 flex flex-col items-center justify-between font-sans">

    <div class="max-w-5xl w-full flex flex-col gap-12 my-20">
        
        <div class="flex flex-wrap justify-center gap-4" id="category-buttons">
            <button data-category="gempa" class="category-btn bg-gray-800 text-white font-medium py-3 px-6 rounded-xl transition duration-200">Gempa Bumi</button>
            <button data-category="banjir" class="category-btn bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-6 rounded-xl transition duration-200">Banjir</button>
            <button data-category="longsor" class="category-btn bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-6 rounded-xl transition duration-200">Longsor</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8" id="content-grid">
            </div>
    </div>

  {{-- HEADER --}}
  <div class="mb-6">
    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full uppercase tracking-widest mb-3">Sebelum Bencana</span>
    <h1 class="font-head text-4xl font-extrabold text-navy">Tas Siaga</h1>
    <p class="text-gray-500 mt-1 text-sm">Susun perlengkapan darurat sesuai prioritas akses.</p>
  </div>

  {{-- TABS --}}
  <div class="flex items-center gap-2 mb-6">
    <div class="flex gap-2 overflow-x-auto slim-scroll flex-1 pb-1">
      <template x-for="tas in semuaTas" :key="tas.id">
        <button @click="setAktif(tas.id)"
                :class="{'active': activeTasId === tas.id}"
                class="tas-tab px-4 py-2 rounded-full text-sm font-semibold border border-gray-200 text-gray-600 hover:border-navy hover:text-navy flex items-center gap-2">
          <span x-text="tas.nama_tas"></span>
          <span class="text-xs opacity-50" x-text="tas.liter + 'L'"></span>
          <span @click.stop="hapusTas(tas.id)" class="w-4 h-4 rounded-full bg-gray-200 hover:bg-red-100 hover:text-red-500 flex items-center justify-center text-xs transition-colors">✕</span>
        </button>
      </template>
    </div>
    <button @click="$store.tasBuat.open = true"
            class="flex-shrink-0 px-4 py-2 bg-navy text-white text-sm font-semibold rounded-full hover:opacity-90 flex items-center gap-2">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tas Baru
    </button>
  </div>

  <template x-if="activeTas">
    <div class="grid lg:grid-cols-2 gap-8 items-start">

      {{-- KOLOM KIRI --}}
      <div class="space-y-4">

        {{-- Kategori --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-2">
          <p class="font-head font-semibold text-navy text-sm">Kategori</p>
          <div class="grid grid-cols-4 gap-1.5">
            <template x-for="kat in ['anak','remaja','dewasa','lansia']" :key="kat">
              <button @click="updateKategori(kat)"
                      :class="activeTas.kategori===kat?'bg-navy text-white border-navy':'bg-white text-gray-600 border-gray-200 hover:border-navy'"
                      class="px-2 py-2 border rounded-xl text-xs font-semibold capitalize transition-colors">
                <span x-text="kat==='anak'?'Anak':kat.charAt(0).toUpperCase()+kat.slice(1)"></span>
              </button>
            </template>
          </div>
        </div>

        {{-- Dimensi tas (editable) --}}
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

        {{-- Info dimensi real-time --}}
        <div class="bg-navy/5 rounded-xl px-4 py-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-navy font-medium">
          <span>📐 Tas: <strong x-text="bagCm.p + ' × ' + bagCm.t + ' cm'"></strong></span>
          <span>📦 Zona: <strong x-text="bagCm.p + ' × ' + bagCm.zh + ' cm'"></strong> per area</span>
          <span class="text-gray-400 font-normal">skala: <span x-text="Math.round(pxPerCm*10)/10 + ' px/cm'"></span></span>
        </div>

        {{-- TAS VISUAL --}}
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

          {{-- Zona stats --}}
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

          {{-- Tombol rapikan --}}
          <div class="flex gap-2 mt-3 flex-wrap justify-center">
            <button @click="sortAll()" class="px-3 py-1.5 text-xs font-semibold border border-gray-200 rounded-full hover:bg-gray-50 transition-colors">✦ Rapikan Semua</button>
            <button @click="sortZona('sangat_penting')" class="px-3 py-1.5 text-xs font-semibold border border-red-200 text-red-600 rounded-full hover:bg-red-50">🔴 Atas</button>
            <button @click="sortZona('penting')"        class="px-3 py-1.5 text-xs font-semibold border border-orange-200 text-orange-600 rounded-full hover:bg-orange-50">🟠 Tengah</button>
            <button @click="sortZona('cukup_penting')"  class="px-3 py-1.5 text-xs font-semibold border border-green-200 text-green-600 rounded-full hover:bg-green-50">🟢 Bawah</button>
          </div>
          <p class="text-xs text-gray-400 mt-2 text-center">Geser item bebas · Klik 2× untuk hapus dari tas</p>
        </div>
      </div>

      {{-- KOLOM KANAN: Daftar Item --}}
      <div class="space-y-3">
        <div class="flex items-center justify-between">
          <h3 class="font-head font-bold text-navy text-lg">Daftar Item</h3>
          <span class="text-xs text-gray-400 capitalize">Rekomendasi: <span x-text="activeTas.kategori"></span></span>
        </div>
        <div class="relative">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
          <input type="text" x-model="search" placeholder="Cari item..."
                 class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy shadow-sm"/>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3" id="item-grid-blade">
          <template x-for="item in filteredRekomendasi" :key="item.id">
            <div :data-item-id="item.id"
                 :data-rotated="rotatedIds.includes(item.id) ? '1' : '0'"
                 :class="{'used': usedIds.includes(item.id)}"
                 class="icard relative">

              {{-- Tombol rotate --}}
              <button
                x-show="!usedIds.includes(item.id)"
                @click.stop="toggleRotate(item.id)"
                :class="rotatedIds.includes(item.id) ? 'bg-orange-100 text-orange-500' : 'bg-gray-100 text-gray-400'"
                class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full flex items-center justify-center text-xs hover:opacity-80 transition-all"
                title="Rotate item">
                🔄
              </button>

              {{-- Preview ukuran relatif --}}
              <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden relative">
                {{-- Box preview sesuai orientasi --}}
                <div :style="getPreviewStyle(item)"
                     class="rounded-sm opacity-60 border border-gray-300 bg-gray-300 transition-all duration-200">
                </div>
              </div>

              <p class="text-xs font-semibold text-navy text-center leading-tight" x-text="item.nama_item"></p>

              {{-- Dimensi hint --}}
              <span class="text-xs text-gray-400" x-text="getDimHint(item)"></span>

              <span class="zdot" :class="item.zona_saran==='sangat_penting'?'da':item.zona_saran==='penting'?'db':'dc'"></span>
              <span x-show="usedIds.includes(item.id)" class="text-xs text-gray-400">✓ Sudah</span>
            </div>
          </template>
        </div>

        <p class="text-xs text-gray-400 text-center">
          🔴 Sangat penting &nbsp;·&nbsp; 🟠 Penting &nbsp;·&nbsp; 🟢 Cukup penting<br>
          Item hanya masuk zona yang sesuai · 🔄 untuk rotate · ukuran menyesuaikan dimensi tas
        </p>

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

  {{-- EMPTY STATE --}}
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
<div x-data x-show="$store.tasBuat.open"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     @keydown.escape.window="$store.tasBuat.open=false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display:none">
  <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl p-6" @click.stop
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
    <div class="flex items-center justify-between mb-5">
      <h3 class="font-head font-bold text-navy text-xl">Buat Tas Baru</h3>
      <button @click="$store.tasBuat.open=false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <form @submit.prevent="$store.tasBuat.submit()">
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-semibold text-navy mb-1">Nama Tas</label>
          <input type="text" x-model="$store.tasBuat.form.nama_tas" placeholder="Contoh: Tas Keluarga"
                 class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy" required/>
        </div>
        <div>
          <label class="block text-sm font-semibold text-navy mb-2">Kategori</label>
          <div class="grid grid-cols-2 gap-2">
            <template x-for="kat in ['anak','remaja','dewasa','lansia']" :key="kat">
              <button type="button" @click="$store.tasBuat.form.kategori=kat"
                      :class="$store.tasBuat.form.kategori===kat?'bg-navy text-white border-navy':'bg-white text-gray-600 border-gray-200 hover:border-navy'"
                      class="px-4 py-2.5 border rounded-xl text-sm font-semibold capitalize transition-colors">
                <span x-text="kat==='anak'?'Anak-anak':kat.charAt(0).toUpperCase()+kat.slice(1)"></span>
              </button>
            </template>
          </div>
        </div>

        {{-- Input dimensi --}}
        <div>
          <label class="block text-sm font-semibold text-navy mb-1">
            Dimensi Tas <span class="text-gray-400 font-normal text-xs">(cm) — Liter otomatis dihitung</span>
          </label>
          <div class="flex items-center gap-2">
            <div class="flex-1">
              <p class="text-xs text-gray-400 text-center mb-1">Panjang</p>
              <input type="number" x-model="$store.tasBuat.form.dim_p" @input="$store.tasBuat.hitungLiter()"
                     placeholder="cm" min="1" max="200" step="0.5"
                     class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy text-center"/>
            </div>
            <span class="text-gray-300 mt-4">×</span>
            <div class="flex-1">
              <p class="text-xs text-gray-400 text-center mb-1">Lebar</p>
              <input type="number" x-model="$store.tasBuat.form.dim_l" @input="$store.tasBuat.hitungLiter()"
                     placeholder="cm" min="1" max="200" step="0.5"
                     class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy text-center"/>
            </div>
            <span class="text-gray-300 mt-4">×</span>
            <div class="flex-1">
              <p class="text-xs text-gray-400 text-center mb-1">Tinggi</p>
              <input type="number" x-model="$store.tasBuat.form.dim_t" @input="$store.tasBuat.hitungLiter()"
                     placeholder="cm" min="1" max="200" step="0.5"
                     class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy text-center"/>
            </div>
          </div>
          {{-- Hasil liter --}}
          <div x-show="$store.tasBuat.form.liter" class="mt-2 bg-navy/5 rounded-xl px-3 py-2 flex items-center justify-between">
            <span class="text-xs text-gray-500">Kapasitas:</span>
            <span class="font-head font-bold text-navy text-sm" x-text="$store.tasBuat.form.liter + ' Liter'"></span>
          </div>
          {{-- Atau input manual --}}
          <div class="mt-2">
            <p class="text-xs text-gray-400 mb-1">Atau input liter langsung:</p>
            <input type="number" x-model="$store.tasBuat.form.liter" placeholder="Liter" min="1" max="500" step="0.1"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy"/>
          </div>
        </div>
      </div>
      <div class="flex gap-3 mt-5">
        <button type="button" @click="$store.tasBuat.open=false" class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50">Batal</button>
        <button type="submit" class="flex-1 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl hover:opacity-90">Buat Tas</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>

// 1. Data konten untuk masing-masing kategori bencana
        const bencanaData = {
            gempa: [
                "Mengenali Gempa Bumi serta memastikan struktur dan lokasi rumah aman dari risiko dan likuefaksi melalui evaluasi serta renovasi bangunan agar lebih tahan terhadap bahaya Gempa Bumi.",
                "Memahami lokasi pintu, lift, dan tangga darurat untuk mencari tempat aman saat gempabumi serta mempelajari P3K, penggunaan alat pemadam kebakaran, dan mencatat nomor telepon penting untuk keadaan darurat.",
                "Pastikan perabotan seperti lemari dan kabinet menempel pada dinding agar tidak roboh saat gempabumi lalu simpan bahan mudah terbakar di tempat aman yang tidak mudah pecah serta selalu matikan air gas dan listrik ketika tidak digunakan.",
                "Letakkan benda-benda berat di bagian bawah dan pastikan benda yang tergantung seperti lampu memiliki kestabilan yang baik agar tidak jatuh saat terjadi Gempa Bumi."
            ],
            banjir: [
                "Simpan dokumen-dokumen penting di dalam wadah kedap air dan letakkan di area rumah yang paling tinggi atau aman dari jangkauan air.",
                "Pantau informasi prakiraan cuaca dan tinggi muka air secara berkala melalui kanal resmi BMKG atau BPBD setempat.",
                "Matikan jaringan listrik dan cabut seluruh peralatan elektronik dari stopkontak saat air mulai meninggi untuk menghindari risiko kesetrum.",
                "Siapkan tas siaga bencana yang berisi makanan siap saji, air minum, obat-obatan, dan lampu senter untuk evakuasi mandiri.",
                "Scan dan simpan salinan digital dokumen penting seperti KTP KK ijazah sertifikat rumah buku tabungan dan surat berharga lainnya ke dalam penyimpanan online atau perangkat cadangan agar tetap aman dan mudah diakses apabila dokumen asli rusak atau hilang akibat banjir."
            ],
            longsor: [
                "Hindari membangun rumah atau infrastruktur di bawah tebing curam atau di area lereng yang tidak memiliki pohon penahan.",
                "Waspadai munculnya retakan baru di tanah, penurunan tanah mendadak, atau pohon yang tiba-tiba miring setelah hujan lebat.",
                "Lakukan penghijauan dengan menanam pohon berakar dalam (seperti vetiver atau bambu) untuk memperkuat struktur tanah di area lereng.",
                "Segera lakukan evakuasi ke zona aman jika terdengar suara gemuruh dari arah perbukitan setelah hujan turun berhari-hari."
            ]
        };

        // 2. Ambil elemen HTML yang dibutuhkan
        const contentGrid = document.getElementById('content-grid');
        const buttons = document.querySelectorAll('.category-btn');

        // 3. Fungsi untuk merender/menindahkan konten ke dalam Grid
        function renderContent(category) {
            // Bersihkan isi grid terlebih dahulu
            contentGrid.innerHTML = "";

            // Ambil array teks berdasarkan kategori yang dipilih
            const items = bencanaData[category];

            // Mengubah class container utama secara dinamis agar mendukung perataan tengah di baris terakhir
            contentGrid.className = "flex flex-wrap justify-center gap-8 w-full";

            // Looping data dan buat elemen HTML-nya
            items.forEach(text => {
                const cardHtml = `
                    <div class="flex flex-col items-center text-center gap-4 opacity-0 animate-fade-in w-full md:w-[calc(50%-1rem)] max-w-[480px]">
                        <div class="w-full aspect-[4/2.5] bg-gray-300 rounded-2xl shadow-sm"></div>
                        <p class="text-sm text-gray-700 leading-relaxed max-w-[380px]">
                            ${text}
                        </p>
                    </div>
                `;
                // Tambahkan kartu ke dalam grid
                contentGrid.insertAdjacentHTML('beforeend', cardHtml);
            });
        }

        // 4. Fungsi untuk mengatur gaya tombol aktif (Active State)
        function updateButtonStyles(activeButton) {
            buttons.forEach(btn => {
                // Kembalikan semua tombol ke warna abu-abu (tidak aktif)
                btn.classList.remove('bg-gray-800', 'text-white');
                btn.classList.add('bg-gray-300', 'text-gray-800', 'hover:bg-gray-400');
            });
            // Berikan warna hitam/gelap pada tombol yang sedang aktif
            activeButton.classList.remove('bg-gray-300', 'text-gray-800', 'hover:bg-gray-400');
            activeButton.classList.add('bg-gray-800', 'text-white');
        }

        // 5. Tambahkan event listener 'click' pada setiap tombol
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                renderContent(category);
                updateButtonStyles(this);
            });
        });

        // 6. Jalankan konten "Gempa Bumi" secara default saat pertama kali web dibuka
        renderContent('gempa');

// ─── Ukuran fisik item dalam cm (terlipat/terdiri) ────────
// Semua item diasumsikan dalam kondisi terlipat/terdiri di tas
const ITEM_CM = {
  // Berdiri tegak
  'Air Minum':         {w: 7,  h: 23}, // botol 600ml berdiri
  'Senter':            {w: 5,  h: 10}, // senter panjang berdiri
  'Susu/Formula':      {w: 8,  h: 22}, // tetra pack berdiri
  'Radio Portabel':    {w:12,  h: 18}, // berdiri
  'Alat bantu':        {w: 8,  h: 25}, // tongkat lipat berdiri

  // Berbaring (landscape)
  'P3K':               {w: 20, h: 5}, // kotak P3K berbaring
  'Masker':            {w: 7, h:  2}, // terlipat flat
  'Makanan Kaleng':    {w: 5, h: 8}, // kaleng berbaring
  'Dokumen Penting':   {w: 22, h:  3}, // dalam map tipis, berbaring
  'Uang Tunai':        {w: 18, h:  3}, // amplop tipis berbaring
  'Popok':             {w: 20, h:  8}, // terlipat berbaring
  'Selimut darurat':   {w: 25, h:  6}, // digulung → berbaring lonjong

  // Compact / hampir kotak
  'Peluit darurat':    {w: 4, h:  4}, // kecil
  'Korek api':         {w:  2, h:  4}, // kecil berdiri
  'Baju ganti':        {w: 25, h:  6}, // terlipat rapi berbaring
  'Tali':              {w: 5, h: 5}, // digulung jadi bundel kotak
  'Obat Pribadi':      {w: 10, h:  8}, // kotak obat
  'Power Bank':        {w: 10, h: 14}, // berbaring
  'Obat Anak':         {w:  8, h:  8}, // kotak kecil
  'Mainan kecil':      {w: 10, h: 10}, // kotak
  'Obat Rutin':        {w:  8, h:  8}, // kotak kecil
  'Kacamata cadangan': {w: 15, h:  6}, // dalam case tipis berbaring
};
const DEFAULT_CM = {w: 10, h: 10};

// ─── Bag & zona constants (px) ────────────────────────────
const BAG_W   = 168;
const ZONA_H  = {sangat_penting:72, penting:72, cukup_penting:74};
const ZONA_TOP= {sangat_penting:0,  penting:72, cukup_penting:144};
const ZONA_KEY= {sangat_penting:'a',penting:'b',cukup_penting:'c'};
const ZONA_CLR= {sangat_penting:'#C0392B',penting:'#E67E22',cukup_penting:'#27AE60'};

let placed = {sangat_penting:[], penting:[], cukup_penting:[]};
let dragging = null;
let PX_PER_CM = 3;

function itemPx(namaItem) {
  const cm = ITEM_CM[namaItem] || DEFAULT_CM;
  return {
    w: Math.max(10, Math.round(cm.w * PX_PER_CM)),
    h: Math.max(8,  Math.round(cm.h * PX_PER_CM)),
  };
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
  for (let dy=-zh; dy<=zh; dy+=2)
    for (let dx=-BAG_W; dx<=BAG_W; dx+=2) {
      const tx=cX(prefX+dx), ty=cY(prefY+dy);
      const tc={x:tx,y:ty,w:px.w,h:px.h};
      if (!others.some(o=>rectsOverlap(tc,{x:o.x,y:o.y,w:o.px.w,h:o.px.h}))) {
        const d=Math.hypot(tx-prefX, ty-prefY);
        if (d<bestD) { bestD=d; best={x:tx,y:ty}; }
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

function getPos(e) {
  if (e.touches?.length)        return {x:e.touches[0].clientX, y:e.touches[0].clientY};
  if (e.changedTouches?.length) return {x:e.changedTouches[0].clientX, y:e.changedTouches[0].clientY};
  return {x:e.clientX, y:e.clientY};
}

function getZonaAt(relY) {
  if (relY>=0   && relY<72)  return 'sangat_penting';
  if (relY>=72  && relY<144) return 'penting';
  if (relY>=144 && relY<=218)return 'cukup_penting';
  return null;
}

function clearHL() {
  ['zona-a','zona-b','zona-c'].forEach(id =>
    document.getElementById(id)?.classList.remove('drag-v','drag-iv')
  );
}

// ─── SVG per item (menggunakan w dan h dinamis) ───────────
function makeSvg(nama, zona, w, h, rotated=false) {
  const fill  = ZONA_CLR[zona] || '#888';
  const fs    = Math.max(6, Math.min(10, Math.round(Math.min(w,h) / 3.5)));
  // Potong nama jika terlalu panjang untuk kotak
  const maxChar = Math.floor(w / (fs * 0.62));
  const label   = nama.length > maxChar ? nama.slice(0, maxChar - 1) + '…' : nama;

  return `<svg width="${w}" height="${h}" viewBox="0 0 ${w} ${h}" xmlns="http://www.w3.org/2000/svg">
    <rect width="${w}" height="${h}" rx="3" fill="${fill}" opacity="0.18" stroke="${fill}" stroke-width="1.5"/>
    <text x="${w/2}" y="${h/2 + fs*0.38}"
          text-anchor="middle"
          font-size="${fs}"
          fill="${fill}"
          font-weight="700"
          font-family="sans-serif">${label}</text>
  </svg>`;
}

function createPlacedEl(p) {
  const el = document.createElement('div');
  el.className = 'placed';
  el.style.cssText = `left:${p.x}px;top:${p.y}px;width:${p.px.w}px;height:${p.px.h}px;z-index:10`;
  el.innerHTML = makeSvg(p.namaItem, p.zona, p.px.w, p.px.h);
  el.title = 'Geser bebas · Klik 2× hapus';
  el.addEventListener('mousedown', e => startDragPlaced(e, p, el));
  el.addEventListener('touchstart', e => startDragPlaced(e, p, el), {passive:false});
  el.addEventListener('dblclick', () => removePlaced(p));
  p.el = el;
  document.getElementById('inner-area')?.appendChild(el);
}

function removePlaced(p) {
  p.el?.remove();
  placed[p.zona] = placed[p.zona].filter(x => x !== p);
  window.dispatchEvent(new CustomEvent('item-removed', {detail:{id:p.itemId}}));
  window.dispatchEvent(new CustomEvent('update-stats'));
}

function startDragCard(e, itemId, namaItem, zonaSaran, rotated=false) {
  e.preventDefault();
  const pos = getPos(e);
  const baseCm = ITEM_CM[namaItem] || DEFAULT_CM;
  const cm  = rotated ? {w: baseCm.h, h: baseCm.w} : baseCm;
  const px  = {
    w: Math.max(10, Math.round(cm.w * PX_PER_CM)),
    h: Math.max(8,  Math.round(cm.h * PX_PER_CM)),
  };
  dragging = {itemId, namaItem, zonaSaran, px, isNew:true, placed:null, rotated};
  const dg = document.getElementById('drag-ghost');
  dg.innerHTML = makeSvg(namaItem, zonaSaran, px.w, px.h, rotated);
  dg.style.display = 'block';
  moveGhost(pos.x, pos.y);
  bindMove();
}

function startDragPlaced(e, p, el) {
  e.preventDefault(); e.stopPropagation();
  const pos = getPos(e);
  const rect = el.getBoundingClientRect();
  dragging = {itemId:p.itemId, namaItem:p.namaItem, zonaSaran:p.zona, px:p.px,
              isNew:false, placed:p, offX:pos.x-rect.left, offY:pos.y-rect.top};
  const dg = document.getElementById('drag-ghost');
  dg.innerHTML = makeSvg(p.namaItem, p.zona, p.px.w, p.px.h);
  dg.style.display = 'block';
  el.classList.add('dp');
  moveGhost(pos.x, pos.y);
  bindMove();
}

function moveGhost(cx, cy) {
  const dg = document.getElementById('drag-ghost');
  dg.style.left = cx+'px'; dg.style.top = cy+'px';
}

function bindMove() {
  document.addEventListener('mousemove', onMove);
  document.addEventListener('mouseup',   onUp);
  document.addEventListener('touchmove', onMove, {passive:false});
  document.addEventListener('touchend',  onUp);
}
function unbindMove() {
  document.removeEventListener('mousemove', onMove);
  document.removeEventListener('mouseup',   onUp);
  document.removeEventListener('touchmove', onMove);
  document.removeEventListener('touchend',  onUp);
}

function onMove(e) {
  if (!dragging) return;
  e.preventDefault();
  const pos = getPos(e);
  moveGhost(pos.x, pos.y);
  const ia = document.getElementById('inner-area');
  if (!ia) return;
  const ir = ia.getBoundingClientRect();
  const offX = dragging.offX ?? dragging.px.w/2;
  const offY = dragging.offY ?? dragging.px.h/2;
  const relX = pos.x - ir.left - offX;
  const relY = pos.y - ir.top  - offY;
  const zona = getZonaAt(relY + dragging.px.h/2);
  clearHL();
  const gb = document.getElementById('ghost-box');
  if (!zona) { gb.style.display='none'; return; }
  const valid = zona === dragging.zonaSaran;
  document.getElementById('zona-'+ZONA_KEY[zona])?.classList.add(valid?'drag-v':'drag-iv');
  if (!valid) { gb.style.display='none'; return; }
  const excl = dragging.isNew ? null : dragging.placed.uid;
  const snap = findSnap(zona, dragging.px, relX, relY, excl);
  // Tandai merah jika item terlalu tinggi atau tidak ada slot
  const overflowH = dragging.px.h > ZONA_H[zona];
  gb.style.cssText = `display:block;left:${snap.x}px;top:${snap.y}px;width:${dragging.px.w}px;height:${dragging.px.h}px`;
  gb.className = 'ghost-box' + (snap.valid && !overflowH ? '' : ' bad');
}

function onUp(e) {
  if (!dragging) return;
  unbindMove();
  document.getElementById('drag-ghost').style.display = 'none';
  document.getElementById('ghost-box').style.display  = 'none';
  clearHL();
  const pos = getPos(e);
  const ia = document.getElementById('inner-area');
  if (!ia) { dragging=null; return; }
  const ir = ia.getBoundingClientRect();
  const offX = dragging.offX ?? dragging.px.w/2;
  const offY = dragging.offY ?? dragging.px.h/2;
  const relX = pos.x - ir.left - offX;
  const relY = pos.y - ir.top  - offY;
  const zona = getZonaAt(relY + dragging.px.h/2);

  // Tolak: zona salah
  if (!zona || zona !== dragging.zonaSaran) {
    const te = zona ? document.getElementById('zona-'+ZONA_KEY[zona]) : null;
    if (te) { te.classList.add('do-shake'); setTimeout(()=>te.classList.remove('do-shake'),350); }
    if (!dragging.isNew) dragging.placed.el?.classList.remove('dp');
    dragging=null; return;
  }

  // Tolak: item lebih tinggi dari zona (overflow vertikal)
  if (dragging.px.h > ZONA_H[zona]) {
    const te = document.getElementById('zona-'+ZONA_KEY[zona]);
    if (te) { te.classList.add('do-shake'); setTimeout(()=>te.classList.remove('do-shake'),350); }
    if (!dragging.isNew) dragging.placed.el?.classList.remove('dp');
    showToast('Item terlalu tinggi untuk zona ini — coba rotate 🔄 agar tiduran');
    dragging=null; return;
  }

  // Tolak: item lebih lebar dari tas
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
    window.dispatchEvent(new CustomEvent('item-placed', {detail:{id:dragging.itemId}}));
  } else {
    dragging.placed.x = snap.x; dragging.placed.y = snap.y;
    if (dragging.placed.el) {
      dragging.placed.el.style.left = snap.x+'px';
      dragging.placed.el.style.top  = snap.y+'px';
      dragging.placed.el.classList.remove('dp');
    }
  }
  dragging = null;
  window.dispatchEvent(new CustomEvent('update-stats'));
}

// Toast notifikasi
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
  toastTimer = setTimeout(() => { toast.style.opacity = '0'; }, 2500);
}

document.addEventListener('dragover', e => {
  const g = document.getElementById('drag-ghost');
  if (g?.style.display !== 'none') { g.style.left=e.clientX+'px'; g.style.top=e.clientY+'px'; }
});

// ─── Alpine Store: Buat Tas ───────────────────────────────
document.addEventListener('alpine:init', () => {
  Alpine.store('tasBuat', {
    open: false,
    form: {nama_tas:'', kategori:'dewasa', liter:'', dim_p:'', dim_l:'', dim_t:''},

    hitungLiter() {
      const p=parseFloat(this.form.dim_p), l=parseFloat(this.form.dim_l), t=parseFloat(this.form.dim_t);
      if (p>0 && l>0 && t>0) this.form.liter = parseFloat((p*l*t/1000).toFixed(1));
    },

    async submit() {
      if (!this.form.nama_tas || !this.form.kategori || !this.form.liter) return;
      const res = await fetch('/api/tas', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify(this.form),
      });
      const data = await res.json();
      if (data.success) {
        this.open = false;
        this.form = {nama_tas:'', kategori:'dewasa', liter:'', dim_p:'', dim_l:'', dim_t:''};
        window.dispatchEvent(new CustomEvent('tas-created', {detail:data.tas}));
      }
    },
  });
});

// ─── Alpine Komponen Utama ────────────────────────────────
function tasSiaga() {
  return {
    semuaTas:    @json($semuaTas ?? []),
    activeTasId: {{ $activeTas?->id ?? 'null' }},
    rekomendasi: [],
    search:      '',
    dimP: '{{ $activeTas?->dim_p ?? "" }}',
    dimL: '{{ $activeTas?->dim_l ?? "" }}',
    dimT: '{{ $activeTas?->dim_t ?? "" }}',
    usedIds:    [],
    rotatedIds: [], // id item yang sedang dalam orientasi rotated
    bagCm:    {p:0, t:0, zh:0},
    pxPerCm:  3,
    zonaList: [
      {key:'sangat_penting', label:'Sangat penting', short:'a', color:'#C0392B', pct:0},
      {key:'penting',        label:'Penting',         short:'b', color:'#E67E22', pct:0},
      {key:'cukup_penting',  label:'Cukup penting',   short:'c', color:'#27AE60', pct:0},
    ],

    get activeTas() { return this.semuaTas.find(t=>t.id===this.activeTasId) ?? null; },
    get filteredRekomendasi() {
      if (!this.search) return this.rekomendasi;
      return this.rekomendasi.filter(i=>i.nama_item.toLowerCase().includes(this.search.toLowerCase()));
    },
    get literHitung() {
      const p=parseFloat(this.dimP), l=parseFloat(this.dimL), t=parseFloat(this.dimT);
      return (p>0&&l>0&&t>0) ? parseFloat((p*l*t/1000).toFixed(1)) : (this.activeTas?.liter ?? 0);
    },

    async init() {
      await this.$nextTick();
      this.initCardDelegation();
      if (this.activeTasId) {
        await this.loadRekomendasi();
        this.calcScale();
      }
      window.addEventListener('tas-created', async e => {
        this.semuaTas.push(e.detail);
        await this.setAktif(e.detail.id);
      });
      window.addEventListener('item-placed', e => {
        if (!this.usedIds.includes(e.detail.id)) this.usedIds.push(e.detail.id);
        this.recalcStats();
      });
      window.addEventListener('item-removed', e => {
        this.usedIds = this.usedIds.filter(x=>x!==e.detail.id);
        this.recalcStats();
      });
      window.addEventListener('update-stats', () => this.recalcStats());
    },

    // Hitung skala dari dimensi nyata (p dan t dari input user)
    calcScale() {
      const p  = parseFloat(this.dimP) || 30;  // lebar tas (panjang)
      const t  = parseFloat(this.dimT) || 40;  // tinggi tas
      const zh = Math.round(t / 3);            // tinggi per zona (cm)
      const scaleW = BAG_W / p;
      const scaleH = 72 / zh;
      PX_PER_CM    = Math.min(scaleW, scaleH);
      this.pxPerCm = Math.round(PX_PER_CM * 10) / 10;
      this.bagCm   = {p, t, zh};
      // Reset isi tas
      placed = {sangat_penting:[], penting:[], cukup_penting:[]};
      this.usedIds = [];
      document.getElementById('inner-area')?.querySelectorAll('.placed').forEach(el=>el.remove());
      this.recalcStats();
    },

    recalcStats() {
      this.zonaList = this.zonaList.map(z => {
        const total = BAG_W * ZONA_H[z.key];
        const used  = placed[z.key].reduce((s,p)=>s+p.px.w*p.px.h, 0);
        return {...z, pct: Math.min(100, Math.round(used/total*100))};
      });
    },

    toggleRotate(itemId) {
      if (this.rotatedIds.includes(itemId)) {
        this.rotatedIds = this.rotatedIds.filter(x => x !== itemId);
      } else {
        this.rotatedIds.push(itemId);
      }
    },

    isRotated(itemId) {
      return this.rotatedIds.includes(itemId);
    },

    // Preview kotak kecil di card — menunjukkan orientasi item
    getPreviewStyle(item) {
      const cm = ITEM_CM[item.nama_item] || DEFAULT_CM;
      const rotated = this.rotatedIds.includes(item.id);
      const rawW = rotated ? cm.h : cm.w;
      const rawH = rotated ? cm.w : cm.h;
      // Scale ke dalam kotak 40×40px
      const maxDim = 40;
      const scale = Math.min(maxDim/rawW, maxDim/rawH);
      const pw = Math.round(rawW * scale);
      const ph = Math.round(rawH * scale);
      const zona = item.zona_saran;
      const color = zona==='sangat_penting'?'#C0392B':zona==='penting'?'#E67E22':'#27AE60';
      return `width:${pw}px;height:${ph}px;background:${color};opacity:0.25;border:1.5px solid ${color}`;
    },

    // Tampilkan ukuran cm di bawah nama item
    getDimHint(item) {
      const cm = ITEM_CM[item.nama_item] || DEFAULT_CM;
      const rotated = this.rotatedIds.includes(item.id);
      const w = rotated ? cm.h : cm.w;
      const h = rotated ? cm.w : cm.h;
      return `${w}×${h}cm`;
    },

    initCardDelegation() {
      const grid = document.getElementById('item-grid-blade');
      if (!grid || grid._delegated) return;
      grid._delegated = true;
      const handler = (e) => {
        const card = e.target.closest('[data-item-id]');
        // Jangan trigger drag jika klik tombol rotate
        if (e.target.closest('button')) return;
        if (!card || card.classList.contains('used')) return;
        const id      = parseInt(card.dataset.itemId);
        const item    = this.rekomendasi.find(r => r.id === id);
        if (!item) return;
        const rotated = this.rotatedIds.includes(id);
        startDragCard(e, item.id, item.nama_item, item.zona_saran, rotated);
      };
      grid.addEventListener('mousedown', handler);
      grid.addEventListener('touchstart', handler, {passive:false});
    },

    async setAktif(id) {
      const res = await fetch(`/api/tas/${id}/aktif`, {
        method:'POST',
        headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
      });
      if ((await res.json()).success) {
        this.activeTasId = id;
        const tas = this.activeTas;
        this.dimP = String(tas?.dim_p ?? '');
        this.dimL = String(tas?.dim_l ?? '');
        this.dimT = String(tas?.dim_t ?? '');
        await this.loadRekomendasi();
        this.calcScale();
      }
    },

    async loadRekomendasi() {
      if (!this.activeTas) return;
      const res = await fetch(`/api/tas/rekomendasi/${this.activeTas.kategori}`);
      this.rekomendasi = await res.json();
    },

    async hapusTas(id) {
      if (!confirm('Hapus tas ini?')) return;
      const res = await fetch(`/api/tas/${id}`, {
        method:'DELETE',
        headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
      });
      if ((await res.json()).success) {
        this.semuaTas = this.semuaTas.filter(t=>t.id!==id);
        if (this.activeTasId === id) {
          this.activeTasId = this.semuaTas[0]?.id ?? null;
          if (this.activeTasId) await this.setAktif(this.activeTasId);
          else { placed={sangat_penting:[],penting:[],cukup_penting:[]}; this.recalcStats(); }
        }
      }
    },

    async updateDimensi() {
      if (!this.activeTas) return;
      const liter = this.literHitung;
      // Update di semuaTas lokal
      const tas = this.semuaTas.find(t=>t.id===this.activeTasId);
      if (tas) { tas.dim_p=parseFloat(this.dimP); tas.dim_l=parseFloat(this.dimL); tas.dim_t=parseFloat(this.dimT); tas.liter=liter; }
      await fetch(`/api/tas/${this.activeTas.id}`, {
        method:'PATCH',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({dim_p:this.dimP, dim_l:this.dimL, dim_t:this.dimT, liter}),
      });
      this.calcScale();
    },

    async updateKategori(kat) {
      if (!this.activeTas) return;
      this.activeTas.kategori = kat;
      await fetch(`/api/tas/${this.activeTas.id}`, {
        method:'PATCH',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({kategori:kat}),
      });
      await this.loadRekomendasi();
    },

    sortZona(zona) { sortZona(zona); this.recalcStats(); },
    sortAll()      { ['sangat_penting','penting','cukup_penting'].forEach(z=>sortZona(z)); this.recalcStats(); },
  };
}
</script>
@endpush