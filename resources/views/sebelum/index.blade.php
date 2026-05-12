@extends('layouts.app')

@section('title', 'Sebelum — Tas Siaga')

@push('styles')
<style>
    /* ── Zona Tas ── */
    .zona-box {
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .zona-box.drag-valid {
        border-color: #27AE60 !important;
        background: #F0FBF4 !important;
        box-shadow: 0 0 0 3px rgba(39,174,96,0.15);
    }
    .zona-box.drag-invalid {
        border-color: #C0392B !important;
        background: #FEF0EE !important;
        box-shadow: 0 0 0 3px rgba(192,57,43,0.15);
    }
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        20%      { transform: translateX(-6px); }
        40%      { transform: translateX(6px); }
        60%      { transform: translateX(-4px); }
        80%      { transform: translateX(4px); }
    }
    .shake { animation: shake 0.35s ease; }

    /* ── Item di dalam tas ── */
    .item-in-tas {
        cursor: grab;
        user-select: none;
        transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
    }
    .item-in-tas:active { cursor: grabbing; }
    .item-in-tas.dragging { opacity: 0.35; }

    /* ── Item di daftar bawah ── */
    .item-daftar {
        cursor: grab;
        user-select: none;
        transition: transform 0.15s, box-shadow 0.15s, opacity 0.2s;
    }
    .item-daftar:active { cursor: grabbing; transform: scale(1.04); }
    .item-daftar.dragging { opacity: 0.35; }
    .item-daftar.sudah-ada { opacity: 0.38; cursor: default; pointer-events: none; }

    /* ── Ghost label ── */
    #drag-ghost {
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
        background: #2C3E50;
        color: #fff;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        display: none;
        transform: translate(-50%, -140%);
    }

    /* ── Tab tas ── */
    .tas-tab { white-space: nowrap; transition: all 0.2s; }
    .tas-tab.active { background: #2C3E50; color: #fff; border-color: #2C3E50; }

    /* zona border-top accent */
    .zona-sangat { border-top: 4px solid #C0392B; }
    .zona-penting { border-top: 4px solid #E67E22; }
    .zona-cukup   { border-top: 4px solid #27AE60; }

    .slim-scroll::-webkit-scrollbar { height: 0; }
</style>
@endpush

@section('content')

<div x-data="tasSiaga()" x-init="init()" class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-6">
        <span class="inline-block px-3 py-1 bg-siaga/10 text-siaga text-xs font-bold rounded-full uppercase tracking-widest mb-3">Sebelum Bencana</span>
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
                    <span @click.stop="hapusTas(tas.id)"
                          class="w-4 h-4 rounded-full bg-gray-200 hover:bg-red-100 hover:text-red-500 flex items-center justify-center text-xs transition-colors">✕</span>
                </button>
            </template>
        </div>
        <button @click="$store.tasBuat.open = true"
                class="flex-shrink-0 px-4 py-2 bg-navy text-white text-sm font-semibold rounded-full hover:bg-navy-dk transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tas Baru
        </button>
    </div>

    {{-- KONTEN --}}
    <template x-if="activeTas">
        <div class="space-y-5">

            {{-- ══ LITER + KATEGORI ══ --}}
            <div class="grid sm:grid-cols-2 gap-4">

                {{-- Liter --}}
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <p class="font-head font-semibold text-navy text-sm">Liter</p>
                        <button @click="modalKalkulator = true"
                                class="text-xs text-siaga font-semibold hover:underline flex items-center gap-1">
                            🧮 Hitung
                        </button>
                    </div>
                    <p class="text-xs text-gray-400">
                        <span class="font-semibold text-navy">Rumus:</span> Volume (p×l×t) / 1000
                    </p>
                    <select x-model="aktivLiter" @change="updateLiter()"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy bg-white transition-colors">
                        <option value="">Pilih rekomendasi...</option>
                        <option value="10">10 L — Tas kecil</option>
                        <option value="20">20 L — Tas sekolah</option>
                        <option value="30">30 L — Medium</option>
                        <option value="40">40 L — Ransel besar</option>
                        <option value="50">50 L — Carrier kecil</option>
                        <option value="70">70 L — Carrier besar</option>
                    </select>
                    <div class="flex items-center gap-2">
                        <input type="number" x-model="aktivLiter"
                               @change="updateLiter()"
                               placeholder="Atau input manual..."
                               min="1" max="200" step="0.5"
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy transition-colors" />
                        <span class="text-sm text-gray-400 font-medium flex-shrink-0">Liter</span>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                    <p class="font-head font-semibold text-navy text-sm">Kategori</p>
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="kat in ['anak', 'remaja', 'dewasa', 'lansia']" :key="kat">
                            <button @click="updateKategori(kat)"
                                    :class="activeTas.kategori === kat
                                        ? 'bg-navy text-white border-navy'
                                        : 'bg-white text-gray-600 border-gray-200 hover:border-navy'"
                                    class="px-3 py-2.5 border rounded-xl text-sm font-semibold transition-colors">
                                <span x-text="kat === 'anak' ? 'Anak-anak' : kat.charAt(0).toUpperCase() + kat.slice(1)"></span>
                            </button>
                        </template>
                    </div>
                    <p class="text-xs text-gray-400">Rekomendasi item akan disesuaikan</p>
                </div>
            </div>

            {{-- ══ SUPPLY BAG ══ --}}
            <div class="bg-gray-50 rounded-3xl p-5 border border-gray-200 shadow-sm space-y-3">
                <p class="font-head font-semibold text-navy text-center text-sm tracking-wide">Supply Bag</p>

                {{-- Zona Sangat Penting --}}
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 zona-box zona-sangat"
                     id="zona-sangat_penting"
                     @dragover.prevent="onDragOver($event, 'sangat_penting')"
                     @dragleave="onDragLeave('sangat_penting')"
                     @drop.prevent="onDrop($event, 'sangat_penting')">
                    <div class="flex items-center gap-2 px-4 pt-3 pb-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-danger flex-shrink-0"></span>
                        <p class="font-head font-semibold text-xs text-navy">Sangat Penting</p>
                        <span class="text-xs text-gray-400">(akses cepat)</span>
                        <span class="ml-auto text-xs text-gray-400" x-text="getItemByZona('sangat_penting').length + ' item'"></span>
                    </div>
                    <div class="px-4 pb-3 pt-1 flex flex-wrap gap-2 min-h-[52px]">
                        <template x-for="item in getItemByZona('sangat_penting')" :key="item.id">
                            <div class="item-in-tas bg-red-50 border border-red-200 rounded-lg px-3 py-1.5 text-xs font-semibold text-red-800 flex items-center gap-1.5"
                                 draggable="true"
                                 @dragstart="dragStartInTas($event, item)"
                                 @dragend="onDragEnd($event)">
                                <span x-text="item.nama_item"></span>
                                <button @click="hapusItem(item.id)" class="text-red-300 hover:text-red-600 transition-colors">✕</button>
                            </div>
                        </template>
                        <p x-show="getItemByZona('sangat_penting').length === 0"
                           class="text-xs text-gray-300 italic self-center">Drag item ke sini</p>
                    </div>
                </div>

                {{-- Zona Penting --}}
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 zona-box zona-penting"
                     id="zona-penting"
                     @dragover.prevent="onDragOver($event, 'penting')"
                     @dragleave="onDragLeave('penting')"
                     @drop.prevent="onDrop($event, 'penting')">
                    <div class="flex items-center gap-2 px-4 pt-3 pb-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-siaga flex-shrink-0"></span>
                        <p class="font-head font-semibold text-xs text-navy">Penting</p>
                        <span class="text-xs text-gray-400">(akses biasa)</span>
                        <span class="ml-auto text-xs text-gray-400" x-text="getItemByZona('penting').length + ' item'"></span>
                    </div>
                    <div class="px-4 pb-3 pt-1 flex flex-wrap gap-2 min-h-[52px]">
                        <template x-for="item in getItemByZona('penting')" :key="item.id">
                            <div class="item-in-tas bg-orange-50 border border-orange-200 rounded-lg px-3 py-1.5 text-xs font-semibold text-orange-800 flex items-center gap-1.5"
                                 draggable="true"
                                 @dragstart="dragStartInTas($event, item)"
                                 @dragend="onDragEnd($event)">
                                <span x-text="item.nama_item"></span>
                                <button @click="hapusItem(item.id)" class="text-orange-300 hover:text-orange-600 transition-colors">✕</button>
                            </div>
                        </template>
                        <p x-show="getItemByZona('penting').length === 0"
                           class="text-xs text-gray-300 italic self-center">Drag item ke sini</p>
                    </div>
                </div>

                {{-- Zona Cukup Penting --}}
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 zona-box zona-cukup"
                     id="zona-cukup_penting"
                     @dragover.prevent="onDragOver($event, 'cukup_penting')"
                     @dragleave="onDragLeave('cukup_penting')"
                     @drop.prevent="onDrop($event, 'cukup_penting')">
                    <div class="flex items-center gap-2 px-4 pt-3 pb-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-safe flex-shrink-0"></span>
                        <p class="font-head font-semibold text-xs text-navy">Cukup Penting</p>
                        <span class="text-xs text-gray-400">(akses lambat)</span>
                        <span class="ml-auto text-xs text-gray-400" x-text="getItemByZona('cukup_penting').length + ' item'"></span>
                    </div>
                    <div class="px-4 pb-3 pt-1 flex flex-wrap gap-2 min-h-[52px]">
                        <template x-for="item in getItemByZona('cukup_penting')" :key="item.id">
                            <div class="item-in-tas bg-green-50 border border-green-200 rounded-lg px-3 py-1.5 text-xs font-semibold text-green-800 flex items-center gap-1.5"
                                 draggable="true"
                                 @dragstart="dragStartInTas($event, item)"
                                 @dragend="onDragEnd($event)">
                                <span x-text="item.nama_item"></span>
                                <button @click="hapusItem(item.id)" class="text-green-300 hover:text-green-600 transition-colors">✕</button>
                            </div>
                        </template>
                        <p x-show="getItemByZona('cukup_penting').length === 0"
                           class="text-xs text-gray-300 italic self-center">Drag item ke sini</p>
                    </div>
                </div>
            </div>

            {{-- ══ DAFTAR ITEM ══ --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-head font-bold text-navy text-lg">Daftar Item</h3>
                    <span class="text-xs text-gray-400">
                        Rekomendasi: <span class="capitalize" x-text="activeTas.kategori"></span>
                    </span>
                </div>

                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text" x-model="search" placeholder="Cari item..."
                           class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy transition-colors shadow-sm" />
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                    <template x-for="item in filteredRekomendasi" :key="item.nama_item">
                        <div draggable="true"
                             :class="{'sudah-ada': sudahDiTas(item.nama_item)}"
                             class="item-daftar bg-white rounded-2xl p-3 flex flex-col items-center gap-1.5 shadow-sm border border-gray-100 hover:border-siaga/40 hover:shadow-md transition-all text-center"
                             @dragstart="dragStartDaftar($event, item)"
                             @dragend="onDragEnd($event)">

                            {{-- Placeholder ikon --}}
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center relative">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4-1.3 4-4s-1.3-4-4-4-4 1.3-4 4 1.3 4 4 4zm0 2c-2.7 0-8 1.3-8 4v1h16v-1c0-2.7-5.3-4-8-4z"/>
                                </svg>
                                <span x-show="item.jumlah > 1"
                                      class="absolute -top-1 -right-1 w-4 h-4 bg-navy text-white rounded-full text-xs flex items-center justify-center font-bold leading-none"
                                      x-text="'×' + item.jumlah"></span>
                            </div>

                            <p class="text-xs font-semibold text-navy leading-tight" x-text="item.nama_item"></p>

                            <span class="text-xs"
                                  x-text="item.zona_saran === 'sangat_penting' ? '🔴' : item.zona_saran === 'penting' ? '🟠' : '🟢'">
                            </span>

                            <span x-show="sudahDiTas(item.nama_item)" class="text-xs text-gray-400">✓ Sudah</span>
                        </div>
                    </template>
                </div>

                <p class="text-xs text-gray-400 text-center">
                    🔴 Sangat Penting &nbsp;·&nbsp; 🟠 Penting &nbsp;·&nbsp; 🟢 Cukup Penting
                    &nbsp;&nbsp;<span class="italic">Item hanya bisa masuk zona yang sesuai</span>
                </p>
            </div>

            {{-- Link ke Sesudah --}}
            <a href="{{ route('sesudah') }}"
               class="flex items-center justify-between bg-safe/10 border border-safe/30 rounded-2xl px-5 py-4 hover:bg-safe/20 transition-colors group">
                <div>
                    <p class="font-head font-semibold text-safe text-sm">Cek Supply Sesudah Bencana</p>
                    <p class="text-xs text-gray-500 mt-0.5">Lihat status kelengkapan tas ini di section Sesudah</p>
                </div>
                <svg class="w-5 h-5 text-safe group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>
    </template>

    {{-- EMPTY STATE --}}
    <template x-if="!activeTas">
        <div class="text-center py-24">
            <div class="text-7xl mb-4">🎒</div>
            <h3 class="font-head font-bold text-navy text-2xl mb-2">Belum ada tas siaga</h3>
            <p class="text-gray-500 mb-6">Buat tas pertamamu untuk mulai menyusun perlengkapan darurat.</p>
            <button @click="$store.tasBuat.open = true"
                    class="px-6 py-3 bg-navy text-white font-semibold rounded-full hover:bg-navy-dk transition-colors">
                Buat Tas Sekarang
            </button>
        </div>
    </template>

</div>

{{-- Ghost drag label --}}
<div id="drag-ghost"></div>

{{-- ══ MODAL BUAT TAS ══ --}}
<div x-data
     x-show="$store.tasBuat.open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     @keydown.escape.window="$store.tasBuat.open = false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
     style="display:none">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl p-6" @click.stop
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        <div class="flex items-center justify-between mb-6">
            <h3 class="font-head font-bold text-navy text-xl">Buat Tas Baru</h3>
            <button @click="$store.tasBuat.open = false"
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form @submit.prevent="$store.tasBuat.submit()">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-navy mb-1">Nama Tas</label>
                    <input type="text" x-model="$store.tasBuat.form.nama_tas"
                           placeholder="Contoh: Tas Keluarga, Tas Anak"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy transition-colors" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Kategori</label>
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="kat in ['anak', 'remaja', 'dewasa', 'lansia']" :key="kat">
                            <button type="button" @click="$store.tasBuat.form.kategori = kat"
                                    :class="$store.tasBuat.form.kategori === kat ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200 hover:border-navy'"
                                    class="px-4 py-2.5 border rounded-xl text-sm font-semibold capitalize transition-colors">
                                <span x-text="kat === 'anak' ? 'Anak-anak' : kat.charAt(0).toUpperCase() + kat.slice(1)"></span>
                            </button>
                        </template>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-1">
                        Kapasitas <span class="text-gray-400 font-normal text-xs">(p×l×t / 1000)</span>
                    </label>
                    <div class="flex gap-2">
                        <select x-model="$store.tasBuat.form.liter"
                                class="flex-1 px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy bg-white transition-colors">
                            <option value="">Pilih rekomendasi...</option>
                            <option value="10">10 L — Tas kecil</option>
                            <option value="20">20 L — Tas sekolah</option>
                            <option value="30">30 L — Medium</option>
                            <option value="40">40 L — Ransel besar</option>
                            <option value="50">50 L — Carrier kecil</option>
                            <option value="70">70 L — Carrier besar</option>
                        </select>
                        <input type="number" x-model="$store.tasBuat.form.liter"
                               placeholder="Manual" min="1" max="200" step="0.5"
                               class="w-24 px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy transition-colors" />
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" @click="$store.tasBuat.open = false"
                        class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl hover:bg-navy-dk transition-colors">
                    Buat Tas
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL KALKULATOR LITER ══ --}}
<div x-data="kalkulator()"
     x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     @open-kalkulator.window="open = true"
     @keydown.escape.window="open = false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
     style="display:none">
    <div class="bg-white rounded-2xl max-w-sm w-full shadow-2xl p-6" @click.stop
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        <div class="flex items-center justify-between mb-4">
            <h3 class="font-head font-bold text-navy text-lg">🧮 Kalkulator Liter Tas</h3>
            <button @click="open = false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="bg-cream rounded-xl p-3 mb-4 text-center">
            <p class="text-xs text-gray-400 mb-0.5">Rumus</p>
            <p class="font-head font-bold text-navy">Volume = P × L × T ÷ 1000</p>
            <p class="text-xs text-gray-400 mt-0.5">Satuan cm → hasil Liter</p>
        </div>

        <div class="grid grid-cols-3 gap-3 mb-4">
            <div>
                <label class="block text-xs font-semibold text-navy mb-1 text-center">Panjang (cm)</label>
                <input type="number" x-model="p" @input="hitung()" min="1"
                       class="w-full px-2 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy text-center transition-colors" />
            </div>
            <div>
                <label class="block text-xs font-semibold text-navy mb-1 text-center">Lebar (cm)</label>
                <input type="number" x-model="l" @input="hitung()" min="1"
                       class="w-full px-2 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy text-center transition-colors" />
            </div>
            <div>
                <label class="block text-xs font-semibold text-navy mb-1 text-center">Tinggi (cm)</label>
                <input type="number" x-model="t" @input="hitung()" min="1"
                       class="w-full px-2 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-navy text-center transition-colors" />
            </div>
        </div>

        <div x-show="hasil > 0" class="bg-navy rounded-xl p-4 text-center mb-4">
            <p class="text-white/60 text-xs mb-1">Kapasitas tas kamu</p>
            <p class="font-head font-extrabold text-white text-3xl" x-text="hasil + ' Liter'"></p>
            <p class="text-white/40 text-xs mt-1" x-text="p + ' × ' + l + ' × ' + t + ' ÷ 1000'"></p>
        </div>

        <div class="flex gap-2">
            <button @click="open = false"
                    class="flex-1 py-2.5 border border-gray-200 text-gray-500 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                Tutup
            </button>
            <button x-show="hasil > 0" @click="pakaiHasil()"
                    class="flex-1 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl hover:bg-navy-dk transition-colors">
                Pakai <span x-text="hasil + ' L'"></span>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Store: Buat Tas ──────────────────────────────────────
document.addEventListener('alpine:init', () => {
    Alpine.store('tasBuat', {
        open: false,
        form: { nama_tas: '', kategori: 'dewasa', liter: '' },

        async submit() {
            if (!this.form.nama_tas || !this.form.kategori || !this.form.liter) return;
            const res = await fetch('/api/tas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(this.form),
            });
            const data = await res.json();
            if (data.success) {
                this.open = false;
                this.form = { nama_tas: '', kategori: 'dewasa', liter: '' };
                window.dispatchEvent(new CustomEvent('tas-created', { detail: data.tas }));
            }
        },
    });
});

// ── Kalkulator Liter ────────────────────────────────────
function kalkulator() {
    return {
        open: false,
        p: '', l: '', t: '',
        hasil: 0,

        hitung() {
            const p = parseFloat(this.p), l = parseFloat(this.l), t = parseFloat(this.t);
            this.hasil = (p > 0 && l > 0 && t > 0)
                ? parseFloat((p * l * t / 1000).toFixed(1))
                : 0;
        },

        pakaiHasil() {
            window.dispatchEvent(new CustomEvent('pakai-liter', { detail: this.hasil }));
            this.open = false;
        },
    };
}

// ── Komponen Tas Siaga ───────────────────────────────────
function tasSiaga() {
    return {
        semuaTas:    @json($semuaTas ?? []),
        activeTasId: {{ $activeTas?->id ?? 'null' }},
        items:       { sangat_penting: [], penting: [], cukup_penting: [] },
        rekomendasi: @json($rekomendasi ?? []),
        search:      '',
        aktivLiter:  '{{ $activeTas?->liter ?? "" }}',
        modalKalkulator: false,

        draggedItem:     null,
        draggedFromZona: null,

        get activeTas() {
            return this.semuaTas.find(t => t.id === this.activeTasId) ?? null;
        },

        get filteredRekomendasi() {
            if (!this.search) return this.rekomendasi;
            return this.rekomendasi.filter(i =>
                i.nama_item.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        getItemByZona(zona) { return this.items[zona] ?? []; },

        sudahDiTas(namaItem) {
            return Object.values(this.items).flat().some(i => i.nama_item === namaItem);
        },

        async init() {
            if (this.activeTasId) {
                await this.loadItems();
                await this.loadRekomendasi();
            }

            window.addEventListener('tas-created', async (e) => {
                this.semuaTas.push(e.detail);
                await this.setAktif(e.detail.id);
            });

            window.addEventListener('pakai-liter', async (e) => {
                if (!this.activeTas) return;
                this.aktivLiter = String(e.detail);
                this.activeTas.liter = e.detail;
                await this.updateLiter();
            });
        },

        // ── API ──────────────────────────────────────────
        async setAktif(id) {
            const res = await fetch(`/api/tas/${id}/aktif`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            });
            if ((await res.json()).success) {
                this.activeTasId = id;
                this.aktivLiter  = String(this.activeTas?.liter ?? '');
                await this.loadItems();
                await this.loadRekomendasi();
            }
        },

        async loadItems() {
            const res  = await fetch(`/api/tas/${this.activeTasId}/items`);
            const data = await res.json();
            this.items = { sangat_penting: [], penting: [], cukup_penting: [] };
            data.forEach(i => this.items[i.zona]?.push(i));
        },

        async loadRekomendasi() {
            const res = await fetch(`/api/tas/rekomendasi/${this.activeTas.kategori}`);
            this.rekomendasi = await res.json();
        },

        async hapusTas(id) {
            if (!confirm('Hapus tas ini beserta semua itemnya?')) return;
            const res = await fetch(`/api/tas/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            });
            if ((await res.json()).success) {
                this.semuaTas = this.semuaTas.filter(t => t.id !== id);
                if (this.activeTasId === id) {
                    this.activeTasId = this.semuaTas[0]?.id ?? null;
                    this.items = { sangat_penting: [], penting: [], cukup_penting: [] };
                    if (this.activeTasId) await this.loadItems();
                }
            }
        },

        async updateLiter() {
            if (!this.activeTas) return;
            await fetch(`/api/tas/${this.activeTas.id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ liter: this.aktivLiter }),
            });
            this.activeTas.liter = parseFloat(this.aktivLiter);
        },

        async updateKategori(kat) {
            if (!this.activeTas) return;
            this.activeTas.kategori = kat;
            await fetch(`/api/tas/${this.activeTas.id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ kategori: kat }),
            });
            await this.loadRekomendasi();
        },

        async hapusItem(item_id) {
            const res = await fetch(`/api/item/${item_id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            });
            if ((await res.json()).success) {
                for (const z of Object.keys(this.items))
                    this.items[z] = this.items[z].filter(i => i.id !== item_id);
            }
        },

        async simpanItem(nama_item, zona, jumlah, satuan) {
            const res = await fetch('/api/item', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ tas_id: this.activeTasId, nama_item, zona, jumlah, satuan }),
            });
            const data = await res.json();
            if (data.success) this.items[zona].push(data.item);
        },

        async pindahZona(item_id, zona) {
            const res = await fetch(`/api/item/${item_id}/zona`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ zona }),
            });
            if ((await res.json()).success) {
                let moved = null;
                for (const z of Object.keys(this.items)) {
                    const idx = this.items[z].findIndex(i => i.id === item_id);
                    if (idx >= 0) { moved = this.items[z].splice(idx, 1)[0]; break; }
                }
                if (moved) { moved.zona = zona; this.items[zona].push(moved); }
            }
        },

        // ── Drag & Drop ──────────────────────────────────
        dragStartDaftar(e, item) {
            this.draggedItem     = { ...item, isInTas: false };
            this.draggedFromZona = null;
            e.currentTarget.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'copy';
            this._showGhost(e, item.nama_item);
        },

        dragStartInTas(e, item) {
            this.draggedItem     = { ...item, isInTas: true, zona_saran: item.zona };
            this.draggedFromZona = item.zona;
            e.currentTarget.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            this._showGhost(e, item.nama_item);
        },

        onDragOver(e, zona) {
            const el = document.getElementById(`zona-${zona}`);
            if (!el || !this.draggedItem) return;
            const valid = this.draggedItem.zona_saran === zona;
            el.classList.toggle('drag-valid',   valid);
            el.classList.toggle('drag-invalid', !valid);
        },

        onDragLeave(zona) {
            const el = document.getElementById(`zona-${zona}`);
            el?.classList.remove('drag-valid', 'drag-invalid');
        },

        async onDrop(e, zona) {
            const el = document.getElementById(`zona-${zona}`);
            el?.classList.remove('drag-valid', 'drag-invalid');
            this._hideGhost();

            if (!this.draggedItem) return;

            if (this.draggedItem.zona_saran !== zona) {
                // Tolak — shake merah
                el?.classList.add('shake');
                setTimeout(() => el?.classList.remove('shake'), 400);
                this.draggedItem = null;
                return;
            }

            if (!this.draggedItem.isInTas) {
                await this.simpanItem(
                    this.draggedItem.nama_item, zona,
                    this.draggedItem.jumlah ?? 1,
                    this.draggedItem.satuan ?? null
                );
            } else if (this.draggedFromZona !== zona) {
                await this.pindahZona(this.draggedItem.id, zona);
            }

            this.draggedItem = null;
        },

        onDragEnd(e) {
            e.currentTarget.classList.remove('dragging');
            this._hideGhost();
            ['sangat_penting', 'penting', 'cukup_penting'].forEach(z => {
                document.getElementById(`zona-${z}`)?.classList.remove('drag-valid', 'drag-invalid');
            });
            this.draggedItem = null;
        },

        _showGhost(e, label) {
            const ghost = document.getElementById('drag-ghost');
            if (!ghost) return;
            ghost.textContent = label;
            ghost.style.display = 'block';
            ghost.style.left = e.clientX + 'px';
            ghost.style.top  = e.clientY + 'px';
            const blank = document.createElement('canvas');
            e.dataTransfer.setDragImage(blank, 0, 0);
        },

        _hideGhost() {
            const ghost = document.getElementById('drag-ghost');
            if (ghost) ghost.style.display = 'none';
        },

        set modalKalkulator(v) {
            if (v) window.dispatchEvent(new CustomEvent('open-kalkulator'));
        },
    };
}

// Update posisi ghost saat drag
document.addEventListener('dragover', (e) => {
    const ghost = document.getElementById('drag-ghost');
    if (ghost && ghost.style.display !== 'none') {
        ghost.style.left = e.clientX + 'px';
        ghost.style.top  = e.clientY + 'px';
    }
});
</script>
@endpush