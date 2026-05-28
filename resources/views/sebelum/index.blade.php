@extends('layouts.app')

@section('title', 'Sebelum — Tas Siaga')

@push('styles')
<style>

    /* ══════════════════════
   HERO VARIABLES
══════════════════════ */
:root {
  --h-teal:   #5A827E;
  --h-sage:   #84AE92;
  --h-mint:   #B9D4AA;
  --h-cream:  #FAFFCA;
  --h-dark:   #1e3330;
  --h-muted:  #4a6b5e;
  --h-teal-dk:#3d5c59;
}
 
/* ══════════════════════
   HERO SECTION
══════════════════════ */
.hero-siaga {
  position: relative;
  min-height: 90vh;
  display: flex;
  align-items: center;
  overflow: hidden;
  background: var(--h-cream);
}
 
/* ambient glow top right */
.hero-siaga::before {
  content: '';
  position: absolute;
  top: -120px; right: -100px;
  width: 520px; height: 520px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(185,212,170,0.5) 0%, transparent 68%);
  pointer-events: none; z-index: 0;
}
 
/* bottom wave fade */
.hero-siaga::after {
  content: '';
  position: absolute;
  bottom: -2px; left: 0; right: 0;
  height: 72px;
  background: var(--h-mint);
  clip-path: ellipse(55% 100% at 50% 100%);
  z-index: 0;
  opacity: 0.30;
}
 
.hero-siaga__inner {
  position: relative; z-index: 2;
  max-width: 1180px; width: 100%;
  margin: 0 auto;
  padding: 80px 48px;
  display: grid;
  grid-template-columns: 1fr 1.05fr;
  gap: 40px;
  align-items: center;
}
 
/* ── LEFT TEXT ── */
.hero-siaga__text {
  display: flex; flex-direction: column; gap: 22px;
  animation: hEnterLeft 0.8s cubic-bezier(0.22,1,0.36,1) both;
}
 
.hero-siaga__eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(90,130,126,0.12);
  border: 1px solid rgba(90,130,126,0.25);
  border-radius: 99px;
  padding: 6px 16px;
  font-size: 12px; font-weight: 700;
  color: var(--h-teal);
  letter-spacing: 0.06em;
  text-transform: uppercase;
  width: fit-content;
}
 
.hero-siaga__h1 {
  font-size: clamp(34px, 4.2vw, 56px);
  font-weight: 900;
  color: var(--h-dark);
  line-height: 1.1;
  letter-spacing: -0.025em;
}
.hero-siaga__h1 em {
  font-style: normal;
  color: var(--h-teal);
  position: relative;
}
.hero-siaga__h1 em::after {
  content: '';
  position: absolute;
  bottom: 2px; left: 0; right: 0;
  height: 4px;
  background: var(--h-mint);
  border-radius: 99px;
  z-index: -1;
}
 
.hero-siaga__desc {
  font-size: 15.5px;
  color: var(--h-muted);
  line-height: 1.7;
  max-width: 400px;
}
 
.hero-siaga__cta {
  display: flex; gap: 12px; flex-wrap: wrap;
  margin-top: 4px;
}
 
.hero-btn-main {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 14px 28px;
  background: var(--h-teal);
  color: #fff;
  border-radius: 14px;
  font-size: 14px; font-weight: 700;
  text-decoration: none;
  border: none; cursor: pointer;
  box-shadow: 0 6px 20px rgba(90,130,126,0.35);
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.hero-btn-main:hover {
  background: var(--h-teal-dk);
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(90,130,126,0.42);
  color: #fff;
  text-decoration: none;
}
 
.hero-btn-ghost {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 14px 28px;
  background: rgba(255,255,255,0.72);
  color: var(--h-teal-dk);
  border-radius: 14px;
  font-size: 14px; font-weight: 700;
  text-decoration: none;
  border: 1.5px solid rgba(90,130,126,0.28);
  cursor: pointer;
  backdrop-filter: blur(6px);
  transition: background 0.2s, transform 0.15s;
}
.hero-btn-ghost:hover {
  background: rgba(255,255,255,0.95);
  transform: translateY(-2px);
  text-decoration: none;
  color: var(--h-teal-dk);
}
 
/* ── RIGHT ILLUSTRATION ── */
.hero-siaga__scene {
  position: relative;
  height: 480px;
  display: flex; align-items: center; justify-content: center;
  animation: hEnterRight 0.85s cubic-bezier(0.22,1,0.36,1) 0.1s both;
}
 
.hero-siaga__svg {
  width: 100%; height: 100%;
  max-width: 560px;
  overflow: visible;
}
 
/* ── FLOATING BADGES ── */
.h-badge {
  position: absolute;
  background: rgba(255,255,255,0.90);
  backdrop-filter: blur(10px);
  border-radius: 14px;
  padding: 9px 15px;
  display: flex; align-items: center; gap: 10px;
  box-shadow: 0 4px 24px rgba(90,130,126,0.16);
  border: 1.5px solid rgba(185,212,170,0.65);
  white-space: nowrap;
  z-index: 10;
}
.h-badge__icon {
  width: 32px; height: 32px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: 17px; flex-shrink: 0;
}
.h-badge__text strong { display: block; font-size: 13px; font-weight: 800; color: var(--h-dark); }
.h-badge__text small  { display: block; font-size: 10px; color: var(--h-muted); margin-top: 1px; font-weight: 500; }
 
.h-pulse {
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--h-sage);
  position: relative; flex-shrink: 0;
}
.h-pulse::after {
  content: '';
  position: absolute; inset: -3px;
  border-radius: 50%;
  border: 2px solid var(--h-sage);
  animation: hPulse 1.8s ease-out infinite;
  opacity: 0;
}
 
.h-badge--gempa     { top: 38px;    right: -10px;  animation: hFloat 3.2s ease-in-out infinite; }
.h-badge--banjir    { top: 10px;    right: 175px;  animation: hFloat 3.8s ease-in-out 0.5s infinite; }
.h-badge--kebakaran { bottom: 148px; left: -8px;   animation: hFloat 3.5s ease-in-out 1.1s infinite; }
.h-badge--longsor   { bottom: 92px;  right: 0px;   animation: hFloat 3.0s ease-in-out 0.3s infinite; }
 
/* ── KEYFRAMES ── */
@keyframes hFloat   { 0%,100%{transform:translateY(0)}   50%{transform:translateY(-8px)} }
@keyframes hPulse   { 0%{opacity:.7;transform:scale(1)}  100%{opacity:0;transform:scale(2)} }
@keyframes hEnterLeft  { from{opacity:0;transform:translateX(-32px)} to{opacity:1;transform:translateX(0)} }
@keyframes hEnterRight { from{opacity:0;transform:translateX(32px)}  to{opacity:1;transform:translateX(0)} }
 
/* ── RESPONSIVE ── */
@media (max-width: 820px) {
  .hero-siaga__inner { grid-template-columns: 1fr; padding: 60px 24px 60px; gap: 40px; }
  .hero-siaga__h1 { font-size: 36px; }
  .hero-siaga__scene { height: 320px; }
  .h-badge--banjir    { display: none; }
  .h-badge--kebakaran { bottom: 95px; left: -4px; }
  .h-badge--longsor   { bottom: 48px; }
}

/* BATAS BAGIAN TAS */
#bag-wrap{position:relative;width:260px;user-select:none}
#bag-svg{width:260px;display:block}
#inner-area{position:absolute;top:108px;left:46px;width:168px;height:218px;overflow:hidden}
.zona{position:absolute;left:0;width:168px;transition:background .15s,box-shadow .15s}

/* Warna zona: atas=merah (sangat penting), tengah=oranye (penting), bawah=hijau (cukup penting) */
#zona-a{top:0;height:72px;background:rgba(192,57,43,.08);border-bottom:1px dashed rgba(192,57,43,.3)}
#zona-b{top:72px;height:72px;background:rgba(230,126,34,.08);border-bottom:1px dashed rgba(230,126,34,.3)}
#zona-c{top:144px;height:74px;background:rgba(39,174,96,.08)}

/* Label kecil tiap zona */
#zona-a::before{content:'\1F534  Sangat Penting';color:#C0392B}
#zona-b::before{content:'\1F7E0  Penting';color:#E67E22}
#zona-c::before{content:'\1F7E2  Cukup Penting';color:#27AE60}
.zona::before{position:absolute;top:3px;left:4px;font-size:7px;font-weight:700;opacity:0.6;pointer-events:none;white-space:nowrap}

/* Highlight saat drag hover — warna sesuai zona masing-masing */
#zona-a.drag-v{background:rgba(192,57,43,.2)!important;box-shadow:inset 0 0 0 2px #C0392B}
#zona-b.drag-v{background:rgba(230,126,34,.2)!important;box-shadow:inset 0 0 0 2px #E67E22}
#zona-c.drag-v{background:rgba(39,174,96,.2)!important;box-shadow:inset 0 0 0 2px #27AE60}
.zona.drag-iv{background:rgba(0,0,0,.05)!important;box-shadow:inset 0 0 0 2px rgba(0,0,0,.15)}

@keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
.do-shake{animation:shake .3s ease}
.placed{
    position:absolute;
    cursor:grab;
    border-radius:3px;
    transition:opacity .2s, transform .2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,.12);
}
.placed:active{
    cursor:grabbing;
    box-shadow: 0 6px 16px rgba(0,0,0,.22) !important;
}
.placed.dp{opacity:.3}
.ghost-box{
    position:absolute;
    pointer-events:none;
    border-radius:4px;
    z-index:40;
    display:none;
    border:2px dashed #aaa;
    background:rgba(0,0,0,.06);
}
.ghost-box.bad{border-color:#ccc;background:rgba(0,0,0,.03)}

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


/* Modal buat tas — pure vanilla, z-index harus di atas SEMUA elemen termasuk navbar */
    #modal-buat-tas {
        z-index: 99999 !important;
    }

    /* Saat modal buka: navbar/header ikut tercover oleh overlay */
    body.modal-open > nav,
    body.modal-open > header,
    body.modal-open #navbar,
    body.modal-open .navbar {
        z-index: 1 !important;
    }

[x-cloak] { display: none !important; }
body.modal-open { overflow: hidden !important; }

</style>
@endpush

{{--
    HERO SECTION — SiagaInd
    Palette: #5A827E #84AE92 #B9D4AA #FAFFCA
    Flat 2D SVG illustration inline
    → Paste ke dalam @section('content') sebelum section lainnya
--}}

<section class="hero-siaga">
  <div class="hero-siaga__inner pt-28 md:pt-32">
 
    {{-- ══ LEFT TEXT ══ --}}
    <div class="hero-siaga__text">
 
      <div class="hero-siaga__eyebrow">
         Platform Kesiapsiagaan Bencana
      </div>
 
      <h1 class="hero-siaga__h1">
        Persiapan hari ini,<br/>
        <em>keamanan</em> esok hari.
      </h1>
 
      <p class="hero-siaga__desc">
        Kenali risiko bencana di sekitarmu dan siapkan diri, keluarga,
        serta lingkungan menjadi lebih tangguh.
      </p>
 
      <div class="hero-siaga__cta">
        <a href="{{ route('sebelum') }}#bencana-section" class="hero-btn-main">📖 Pelajari Bencana</a>
        <a href="{{ route('sebelum') }}#bag-wrap" class="hero-btn-ghost"><i class="fa-solid fa-backpack text-green-600"></i> Cek Tas Siaga</a>
      </div>
 
    </div>
 
    {{-- ══ RIGHT ILLUSTRATION ══ --}}
    <div class="hero-siaga__scene">
 
      {{-- FLAT 2D SVG SCENE --}}
      <svg class="hero-siaga__svg" viewBox="0 0 540 460" fill="none" xmlns="http://www.w3.org/2000/svg">
 
        {{-- BG --}}
        <rect width="540" height="460" rx="24" fill="#FAFFCA"/>
 
        {{-- sun --}}
        <circle cx="438" cy="72" r="44" fill="url(#sunGrad)"/>
        <g stroke="#B9D4AA" stroke-width="2.5" stroke-linecap="round" opacity="0.7">
          <line x1="438" y1="18"  x2="438" y2="8"/>
          <line x1="438" y1="126" x2="438" y2="136"/>
          <line x1="384" y1="72"  x2="374" y2="72"/>
          <line x1="492" y1="72"  x2="502" y2="72"/>
          <line x1="400" y1="34"  x2="393" y2="27"/>
          <line x1="476" y1="110" x2="483" y2="117"/>
          <line x1="476" y1="34"  x2="483" y2="27"/>
          <line x1="400" y1="110" x2="393" y2="117"/>
        </g>
 
        {{-- clouds --}}
        <g opacity="0.65">
          <ellipse cx="96" cy="78" rx="38" ry="20" fill="#fff"/>
          <ellipse cx="74" cy="84" rx="22" ry="16" fill="#fff"/>
          <ellipse cx="118" cy="86" rx="20" ry="14" fill="#fff"/>
          <ellipse cx="96" cy="90" rx="42" ry="14" fill="#fff"/>
        </g>
        <g opacity="0.42">
          <ellipse cx="318" cy="55" rx="28" ry="14" fill="#fff"/>
          <ellipse cx="302" cy="60" rx="16" ry="11" fill="#fff"/>
          <ellipse cx="334" cy="62" rx="14" ry="10" fill="#fff"/>
          <ellipse cx="318" cy="66" rx="31" ry="10" fill="#fff"/>
        </g>
 
        {{-- mountains --}}
        <ellipse cx="90"  cy="320" rx="140" ry="95" fill="#84AE92" opacity="0.40"/>
        <ellipse cx="470" cy="315" rx="130" ry="88" fill="#84AE92" opacity="0.40"/>
        <ellipse cx="60"  cy="380" rx="170" ry="75" fill="#84AE92" opacity="0.55"/>
        <ellipse cx="490" cy="375" rx="160" ry="70" fill="#84AE92" opacity="0.55"/>
        <ellipse cx="270" cy="430" rx="330" ry="72" fill="#B9D4AA"/>
 
        {{-- ground --}}
        <rect x="0" y="388" width="540" height="72" fill="#B9D4AA"/>
        <ellipse cx="100" cy="388" rx="80"  ry="18" fill="#B9D4AA"/>
        <ellipse cx="270" cy="386" rx="120" ry="20" fill="#B9D4AA"/>
        <ellipse cx="430" cy="388" rx="90"  ry="18" fill="#B9D4AA"/>
 
        {{-- path --}}
        <path d="M248 390 Q270 350 292 390 L296 460 L244 460 Z" fill="#FAFFCA" opacity="0.6"/>
        <path d="M263 370 Q270 358 277 370 L279 390 L261 390 Z" fill="#FAFFCA" opacity="0.4"/>
 
        {{-- trees left --}}
        <rect x="44" y="340" width="12" height="52" rx="5" fill="#5A827E"/>
        <ellipse cx="50" cy="324" rx="28" ry="34" fill="#5A827E"/>
        <ellipse cx="50" cy="316" rx="20" ry="24" fill="#84AE92"/>
 
        <rect x="98" y="354" width="10" height="38" rx="4" fill="#5A827E"/>
        <ellipse cx="103" cy="340" rx="22" ry="28" fill="#5A827E"/>
        <ellipse cx="103" cy="332" rx="16" ry="20" fill="#84AE92"/>
 
        <ellipse cx="160" cy="385" rx="20" ry="14" fill="#84AE92"/>
        <ellipse cx="148" cy="388" rx="14" ry="11" fill="#5A827E" opacity="0.6"/>
        <ellipse cx="172" cy="387" rx="13" ry="10" fill="#5A827E" opacity="0.6"/>
 
        {{-- trees right --}}
        <rect x="434" y="342" width="12" height="50" rx="5" fill="#5A827E"/>
        <ellipse cx="440" cy="326" rx="28" ry="34" fill="#5A827E"/>
        <ellipse cx="440" cy="318" rx="20" ry="24" fill="#84AE92"/>
 
        <rect x="382" y="356" width="10" height="36" rx="4" fill="#5A827E"/>
        <ellipse cx="387" cy="342" rx="22" ry="27" fill="#5A827E"/>
        <ellipse cx="387" cy="335" rx="16" ry="19" fill="#84AE92"/>
 
        <ellipse cx="480" cy="386" rx="22" ry="14" fill="#84AE92"/>
        <ellipse cx="468" cy="389" rx="14" ry="10" fill="#5A827E" opacity="0.55"/>
 
        {{-- house shadow --}}
        <ellipse cx="270" cy="396" rx="95" ry="10" fill="#5A827E" opacity="0.12"/>
 
        {{-- house walls --}}
        <rect x="184" y="294" width="172" height="100" rx="6" fill="#FAFFCA"/>
        <rect x="318" y="294" width="38"  height="100" rx="0" fill="#B9D4AA" opacity="0.4"/>
 
        {{-- door --}}
        <rect x="248" y="336" width="44" height="58" rx="5" fill="#84AE92"/>
        <rect x="248" y="336" width="44" height="58" rx="5" fill="#5A827E" opacity="0.28"/>
        <rect x="254" y="342" width="14" height="20" rx="3" fill="#5A827E" opacity="0.22"/>
        <rect x="272" y="342" width="14" height="20" rx="3" fill="#5A827E" opacity="0.22"/>
        <circle cx="268" cy="368" r="3.5" fill="#5A827E"/>
        <circle cx="272" cy="368" r="3.5" fill="#5A827E"/>
 
        {{-- left window --}}
        <rect x="196" y="310" width="42" height="36" rx="5" fill="#B9D4AA" opacity="0.7"/>
        <rect x="196" y="310" width="42" height="36" rx="5" stroke="#84AE92" stroke-width="2.5" fill="none"/>
        <line x1="217" y1="310" x2="217" y2="346" stroke="#84AE92" stroke-width="1.5"/>
        <line x1="196" y1="328" x2="238" y2="328" stroke="#84AE92" stroke-width="1.5"/>
        <rect x="193" y="344" width="48" height="5" rx="2.5" fill="#84AE92" opacity="0.5"/>
 
        {{-- right window --}}
        <rect x="302" y="310" width="42" height="36" rx="5" fill="#B9D4AA" opacity="0.7"/>
        <rect x="302" y="310" width="42" height="36" rx="5" stroke="#84AE92" stroke-width="2.5" fill="none"/>
        <line x1="323" y1="310" x2="323" y2="346" stroke="#84AE92" stroke-width="1.5"/>
        <line x1="302" y1="328" x2="344" y2="328" stroke="#84AE92" stroke-width="1.5"/>
        <rect x="299" y="344" width="48" height="5" rx="2.5" fill="#84AE92" opacity="0.5"/>
 
        {{-- roof --}}
        <polygon points="170,296 270,200 370,296" fill="#5A827E"/>
        <polygon points="170,296 270,200 210,296" fill="#84AE92" opacity="0.22"/>
        <polygon points="164,298 270,197 376,298 370,300 270,204 170,300" fill="#3d5c59"/>
 
        {{-- chimney --}}
        <rect x="300" y="224" width="22" height="44" rx="4" fill="#3d5c59"/>
        <rect x="296" y="220" width="30" height="8" rx="3" fill="#3d5c59"/>
        <circle cx="311" cy="206" r="8"   fill="#FAFFCA" opacity="0.52"/>
        <circle cx="318" cy="196" r="6"   fill="#FAFFCA" opacity="0.38"/>
        <circle cx="312" cy="188" r="4.5" fill="#FAFFCA" opacity="0.26"/>
 
        {{-- fence left --}}
        <g fill="#5A827E" opacity="0.35">
          <rect x="165" y="366" width="6" height="24" rx="2"/>
          <rect x="178" y="366" width="6" height="24" rx="2"/>
          <rect x="191" y="366" width="6" height="24" rx="2"/>
          <rect x="163" y="368" width="36" height="4" rx="2"/>
          <rect x="163" y="378" width="36" height="4" rx="2"/>
          <polygon points="168,366 171,360 174,366"/>
          <polygon points="181,366 184,360 187,366"/>
          <polygon points="194,366 197,360 200,366"/>
        </g>
 
        {{-- fence right --}}
        <g fill="#5A827E" opacity="0.35">
          <rect x="340" y="366" width="6" height="24" rx="2"/>
          <rect x="353" y="366" width="6" height="24" rx="2"/>
          <rect x="366" y="366" width="6" height="24" rx="2"/>
          <rect x="338" y="368" width="36" height="4" rx="2"/>
          <rect x="338" y="378" width="36" height="4" rx="2"/>
          <polygon points="343,366 346,360 349,366"/>
          <polygon points="356,366 359,360 362,366"/>
          <polygon points="369,366 372,360 375,366"/>
        </g>
 
        {{-- grass tufts + flowers --}}
        <g stroke="#84AE92" stroke-width="2" stroke-linecap="round" opacity="0.7">
          <line x1="130" y1="390" x2="128" y2="378"/>
          <line x1="135" y1="390" x2="136" y2="377"/>
          <line x1="140" y1="390" x2="142" y2="380"/>
          <line x1="390" y1="390" x2="388" y2="378"/>
          <line x1="395" y1="390" x2="396" y2="377"/>
        </g>
        <circle cx="129" cy="377" r="3"   fill="#FAFFCA" opacity="0.9"/>
        <circle cx="136" cy="376" r="2.5" fill="#FAFFCA" opacity="0.9"/>
        <circle cx="142" cy="379" r="2"   fill="#FAFFCA" opacity="0.9"/>
        <circle cx="388" cy="377" r="2.5" fill="#FAFFCA" opacity="0.9"/>
        <circle cx="396" cy="376" r="2"   fill="#FAFFCA" opacity="0.9"/>
 
        {{-- emergency bag --}}
        <ellipse cx="410" cy="408" rx="46" ry="8" fill="#5A827E" opacity="0.14"/>
        <path d="M390 360 Q390 345 400 345 L418 345 Q428 345 428 360" stroke="#5A827E" stroke-width="5" stroke-linecap="round" fill="none"/>
        <rect x="366" y="358" width="88" height="50" rx="12" fill="#5A827E"/>
        <rect x="366" y="358" width="88" height="22" rx="12" fill="#84AE92" opacity="0.3"/>
        <line x1="366" y1="378" x2="454" y2="378" stroke="#3d5c59" stroke-width="2.5"/>
        <rect x="406" y="372" width="8" height="12" rx="2" fill="#FAFFCA" opacity="0.8"/>
        <rect x="402" y="367" width="16" height="4" rx="2" fill="#FAFFCA"/>
        <rect x="408" y="361" width="4"  height="16" rx="2" fill="#FAFFCA"/>
        <rect x="370" y="398" width="80" height="10" rx="0 0 10 10" fill="#3d5c59" opacity="0.6"/>
 
        {{-- map --}}
        <g transform="rotate(-8 320 390)">
          <rect x="310" y="372" width="52" height="40" rx="4" fill="#FAFFCA"/>
          <rect x="310" y="372" width="52" height="40" rx="4" stroke="#B9D4AA" stroke-width="1.5" fill="none"/>
          <line x1="316" y1="381" x2="356" y2="381" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <line x1="316" y1="387" x2="348" y2="387" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <line x1="316" y1="393" x2="354" y2="393" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <line x1="316" y1="399" x2="344" y2="399" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <circle cx="348" cy="385" r="4" fill="#5A827E"/>
          <line x1="348" y1="389" x2="348" y2="395" stroke="#5A827E" stroke-width="2" stroke-linecap="round"/>
        </g>
 
        {{-- radio --}}
        <g transform="translate(148,370)">
          <rect width="52" height="36" rx="8" fill="#5A827E"/>
          <rect x="6" y="6" width="24" height="18" rx="4" fill="#84AE92" opacity="0.5"/>
          <circle cx="40" cy="10" r="3" fill="#84AE92" opacity="0.5"/>
          <circle cx="40" cy="18" r="3" fill="#84AE92" opacity="0.5"/>
          <circle cx="40" cy="26" r="3" fill="#84AE92" opacity="0.5"/>
          <line x1="42" y1="6" x2="48" y2="-12" stroke="#3d5c59" stroke-width="2" stroke-linecap="round"/>
          <circle cx="20" cy="15" r="6" fill="#FAFFCA" opacity="0.6"/>
        </g>
 
        {{-- checklist --}}
        <g transform="rotate(5 460 350)">
          <rect x="456" y="340" width="44" height="58" rx="5" fill="#FAFFCA"/>
          <rect x="456" y="340" width="44" height="12" rx="5 5 0 0" fill="#B9D4AA"/>
          <line x1="463" y1="362" x2="493" y2="362" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <line x1="463" y1="370" x2="490" y2="370" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <line x1="463" y1="378" x2="492" y2="378" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <line x1="463" y1="386" x2="488" y2="386" stroke="#84AE92" stroke-width="1.5" stroke-linecap="round"/>
          <polyline points="459,363 461,366 465,360" stroke="#5A827E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
          <polyline points="459,371 461,374 465,368" stroke="#5A827E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </g>
 
        <defs>
          <radialGradient id="sunGrad" cx="50%" cy="50%" r="50%">
            <stop offset="0%"   stop-color="#FAFFCA"/>
            <stop offset="55%"  stop-color="#B9D4AA" stop-opacity="0.75"/>
            <stop offset="100%" stop-color="#B9D4AA" stop-opacity="0"/>
          </radialGradient>
        </defs>
 
      </svg>
 
      {{-- FLOATING BADGES --}}
      <div class="h-badge h-badge--gempa">
        <div class="h-badge__icon" style="background:rgba(90,130,126,0.12);"><i class="fa-solid fa-earth-asia text-blue-600"></i></div>
        <div class="h-badge__text">
          <strong>Gempa Bumi</strong>
          <small>Skala VI — Waspada</small>
        </div>
        <div class="h-pulse"></div>
      </div>
 
      <div class="h-badge h-badge--banjir">
        <div class="h-badge__icon" style="background:rgba(132,174,146,0.14);"><i class="fa-solid fa-water text-teal-600"></i></div>
        <div class="h-badge__text">
          <strong>Banjir</strong>
          <small>Siaga I</small>
        </div>
        <div class="h-pulse"></div>
      </div>
 
      <div class="h-badge h-badge--kebakaran">
        <div class="h-badge__icon" style="background:rgba(185,212,170,0.2);"><i class="fa-solid fa-fire text-red-500"></i></div>
        <div class="h-badge__text">
          <strong>Kebakaran</strong>
          <small>+13 titik aktif</small>
        </div>
        <div class="h-pulse"></div>
      </div>
 
      <div class="h-badge h-badge--longsor">
        <div class="h-badge__icon" style="background:rgba(90,130,126,0.12);"><i class="fa-solid fa-mountain text-amber-700"></i></div>
        <div class="h-badge__text">
          <strong>Longsor</strong>
          <small>Risiko Tinggi</small>
        </div>
        <div class="h-pulse"></div>
      </div>
 
    </div>{{-- /hero-siaga__scene --}}
 
  </div>{{-- /hero-siaga__inner --}}
</section>
 

@section('content')
<div x-data="tasSiaga" class="max-w-5xl mx-auto px-4 sm:px-6 py-10">


    
{{-- SECTION INFORMASI BENCANA (SEBELUM) --}}
<section id="bencana-section" class="py-20">
    <div class="max-w-6xl mx-auto px-4">
        
        {{-- HEADER (Tetap di kiri bang, udah aman!) --}}
        <div class="mb-10 text-left">
            <span class="inline-block px-3 py-1 text-teal-600 text-xs font-bold rounded-full uppercase tracking-widest mb-3" style="color: #2D6A6A;">
                Panduan Mitigasi
            </span>
            <h2 class="text-4xl font-extrabold" style="color: #2D6A6A;">
                Informasi Sebelum Bencana
            </h2>
            <p class="text-gray-600 mt-2 text-sm">
                Langkah-langkah kesiapsiagaan penting untuk mengurangi risiko dan melindungi diri sebelum bencana alam terjadi.
            </p>
        </div>

        {{-- FILTER KATEGORI (Hanya tombol yang di tengah) --}}
        <div id="category-container" class="flex justify-center gap-3 mb-10 flex-wrap">
            <button data-category="gempa" class="category-btn disaster-btn active">Gempa Bumi</button>
            <button data-category="banjir" class="category-btn disaster-btn">Banjir</button>
            <button data-category="kebakaran" class="category-btn disaster-btn">Kebakaran</button>
            <button data-category="tsunami" class="category-btn disaster-btn">Tsunami</button>
        </div>

        {{-- KONTEN INFORMASI --}}
        <div id="content-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full mb-10"></div>

        {{-- NAVIGASI STEP --}}
        <div id="step-container" class="flex justify-center gap-3 mt-8">
            <button class="step-btn active" data-page="0">1</button>
            <button class="step-btn" data-page="1">2</button>
        </div>
        
    </div>
</section>


  {{-- =========================================
      HEADER TAS
  ========================================== --}}
  <div class="mb-6">
    <span class="inline-block px-3 py-1 text-[var(--c-teal-dk)] text-xs font-bold rounded-full uppercase tracking-widest mb-3" style="background: var(--c-sage-lt);">
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
                ? 'text-white'
                : 'bg-white text-gray-700 border-gray-200 hover:border-[var(--c-teal-dk)] hover:text-[var(--c-teal-dk)]'"
              :style="activeTasId === tas.id ? 'background: var(--c-teal-dk); border-color: var(--c-teal-dk);' : ''">
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
  <button @click="$store.tasBuat.open = true; document.body.classList.add('modal-open')"
          class="flex-shrink-0 px-4 py-2 text-sm font-semibold rounded-full flex items-center gap-2 transition-colors"
          style="background: var(--c-teal-dk); color: white;">
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
    <div class="flex flex-col space-y-6">

      {{-- 1. [100% Width] Kategori & Dimensi --}}
      <div class="grid lg:grid-cols-2 gap-4 lg:gap-8">
        
        {{-- Kategori Umur --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-2">
          <p class="font-head font-semibold text-navy text-sm">Kategori</p>
          <div class="grid grid-cols-4 gap-1.5">
            <template x-for="kat in ['anak','remaja','dewasa','lansia']" :key="kat">
              <button @click="updateKategori(kat)"
                      class="px-2 py-2 border rounded-xl text-xs font-semibold capitalize transition-colors"
                      :class="activeTas.kategori===kat
                        ? 'text-white'
                        : 'bg-white text-gray-700 border-gray-200 hover:border-[var(--c-teal-dk)] hover:text-[var(--c-teal-dk)]'"
                      :style="activeTas.kategori===kat ? 'background: var(--c-teal-dk); border-color: var(--c-teal-dk);' : ''">
                <span x-text="kat==='anak'?'Anak':kat.charAt(0).toUpperCase()+kat.slice(1)"></span>
              </button>
            </template>
          </div>
        </div>

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
      </div>

      {{-- [TOP] Bag Info / Dimensions (Centered) --}}
      <div class="bg-navy/5 w-full max-w-lg mx-auto rounded-xl px-4 py-2 flex flex-wrap justify-center items-center gap-x-4 gap-y-1 text-xs text-navy font-medium">
        <span><i class="fa-solid fa-ruler-combined text-gray-500"></i> Tas: <strong x-text="bagCm.p + ' × ' + bagCm.t + ' cm'"></strong></span>
        <span><i class="fa-solid fa-box-open text-amber-600"></i> Zona: <strong x-text="bagCm.p + ' × ' + bagCm.zh + ' cm'"></strong> per area</span>
        <span class="text-gray-400 font-normal">skala: <span x-text="pxPerCm + ' px/cm'"></span></span>
      </div>

      {{-- 2. [55% Bag | 45% Item List] SPLIT SECTION --}}
      <div class="grid grid-cols-[55%_45%] sm:grid-cols-[55%_45%] lg:grid-cols-2 gap-2 sm:gap-4 lg:gap-8 items-start h-[500px] lg:h-[600px] w-full overflow-hidden">
        
        {{-- KIRI: ONLY THE BAG (55%) --}}
        <div class="flex flex-col h-full justify-center items-center overflow-hidden w-full min-w-0">
          <div class="w-full max-w-full overflow-hidden flex justify-center items-center transform scale-[0.80] md:scale-100 lg:scale-[1.1] 2xl:scale-[1.2] origin-center md:origin-top">
            <div id="bag-wrap" class="flex-shrink-0">
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
          </div>
        </div>

        {{-- KANAN: DAFTAR ELEMEN ITEM (45%) --}}
        <div class="flex flex-col h-full overflow-hidden w-full min-w-0 pr-3 pl-1">
          
          <div class="flex items-center justify-between mb-2 px-1">
            <h3 class="font-head font-bold text-navy text-sm sm:text-base lg:text-lg whitespace-nowrap overflow-hidden text-ellipsis truncate w-full">Daftar Item</h3>
          </div>

          {{-- Search Input in right column --}}
          <div class="relative w-full mb-3 px-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            <input type="text" x-model="search" placeholder="Cari..."
                   class="w-full pl-8 pr-2 py-2 bg-white border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-navy shadow-sm"/>
          </div>

          <!-- Item Grid with Internal Scroll (Strictly 2 Cols on mobile) -->
          <div class="item-scroll-container flex-1 overflow-y-auto slim-scroll px-1 pb-4">
            <div class="grid grid-cols-2 gap-2 w-full" id="item-grid-blade">
              <template x-for="item in filteredRekomendasi" :key="item.id">
                
                <div :data-item-id="item.id"
                     :data-rotated="rotatedIds.includes(item.id) ? '1' : '0'"
                     :class="{'used': usedIds.includes(item.id)}"
                     draggable="true"
                     @dragstart="window.startDragCard(event, item.id, item.nama_item, item.zona_saran, rotatedIds.includes(item.id))"
                     class="icard overflow-hidden w-full min-w-0 h-full min-h-[130px] relative z-10 cursor-pointer select-none transition-all duration-200 bg-white rounded-xl border border-gray-100 p-2 sm:p-3 shadow-sm flex flex-col items-center justify-center"
                     @click="if(!usedIds.includes(item.id)) { 
                         $el.classList.add('scale-90', 'opacity-75');
                         setTimeout(() => $el.classList.remove('scale-90', 'opacity-75'), 200);
                         window.tapAddItemMobile(item.id, item.nama_item, item.zona_saran, rotatedIds.includes(item.id));
                     }">

                  {{-- Unified Rotate Button --}}
                  <button x-show="!usedIds.includes(item.id)"
                    @click.stop="toggleRotate(item.id)"
                    class="absolute top-1 right-1 z-20 w-6 h-6 flex items-center justify-center rounded-full bg-teal-500 text-white text-[10px] shadow-sm cursor-pointer"
                    title="Rotate item">
                    <i class="fa-solid fa-rotate-right"></i>
                  </button>

                  {{-- Dimensi Mini Preview --}}
                  <div draggable="false" class="w-16 h-16 max-w-full overflow-hidden transform scale-[0.8] sm:scale-100 origin-center bg-gray-100 rounded-xl flex items-center justify-center relative mx-auto mb-1">
                    <div :style="getPreviewStyle(item)" class="rounded-sm opacity-60 border border-gray-300 bg-gray-300 transition-all duration-200"></div>
                  </div>

                  <p class="text-[11px] sm:text-xs font-bold text-navy text-center leading-tight mt-1" x-text="item.nama_item"></p>
                  <span class="text-[9px] sm:text-[10px] text-gray-400 block text-center mt-0.5" x-text="getDimHint(item)"></span>
                  <div class="flex justify-center mt-1">
                    <span class="zdot" :class="item.zona_saran==='sangat_penting'?'da':item.zona_saran==='penting'?'db':'dc'"></span>
                  </div>
                  <span x-show="usedIds.includes(item.id)" class="text-[8px] sm:text-[10px] text-gray-400 text-center block mt-0.5 font-bold">✓</span>
                </div>

              </template>
            </div>
          </div>
        </div>
      </div>

      {{-- 3. [BOTTOM] PERCENTAGE LEGENDS, FILTER BUTTONS, TEXT, SAVE BUTTON --}}
      <div class="flex flex-col space-y-4 pt-4 border-t border-gray-100">
        
        {{-- Progress Bar Kapasitas Zona --}}
        <div class="w-full max-w-lg mx-auto space-y-2">
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
        <div class="flex gap-2 flex-wrap justify-center w-full max-w-lg mx-auto mt-2">
          <button @click="sortAll()" class="px-3 py-1.5 text-xs font-semibold border border-gray-200 rounded-full hover:bg-gray-50 transition-colors">✦ Rapikan Semua</button>
          <button @click="sortZona('sangat_penting')" class="px-3 py-1.5 text-xs font-semibold border border-red-200 text-red-600 rounded-full hover:bg-red-50">🔴 Atas</button>
          <button @click="sortZona('penting')"        class="px-3 py-1.5 text-xs font-semibold border border-orange-200 text-orange-600 rounded-full hover:bg-orange-50">🟠 Tengah</button>
          <button @click="sortZona('cukup_penting')"  class="px-3 py-1.5 text-xs font-semibold border border-green-200 text-green-600 rounded-full hover:bg-green-50">🟢 Bawah</button>
        </div>

        {{-- Legends --}}
        <p class="text-[10px] sm:text-xs text-gray-400 text-center lg:text-left mt-2">
          🔴 Sangat penting &nbsp;·&nbsp; 🟠 Penting &nbsp;·&nbsp; 🟢 Cukup penting<br>
          <span class="hidden lg:inline">Geser item bebas · Klik 2× untuk hapus dari tas</span>
          <span class="lg:hidden">Tap item untuk masuk tas · Tap di dalam tas untuk hapus</span>
          &nbsp;·&nbsp; 🔄 rotate menyesuaikan tas
        </p>

        {{-- Save Button --}}
        <div class="flex justify-center lg:justify-start mt-2">
          <button @click="saveManual()" 
                  class="w-full sm:w-auto px-6 py-3.5 lg:px-8 lg:py-3 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-xl shadow-md flex items-center justify-center gap-2 transition-all duration-200 transform active:scale-95">
            💾 Simpan Perubahan Tas
          </button>
        </div>

      </div>

    </div>
  </template>

  {{-- EMPTY STATE TAS --}}
  <template x-if="!activeTas">
    <div class="text-center py-24">
      <div class="text-7xl mb-4"><i class="fa-solid fa-backpack text-green-600"></i></div>
      <h3 class="font-head font-bold text-navy text-2xl mb-2">Belum ada tas siaga</h3>
      <p class="text-gray-500 mb-6">Buat tas pertamamu untuk mulai menyusun perlengkapan darurat.</p>
      <button onclick="bukaModalTas()" class="px-6 py-3 bg-navy text-white font-semibold rounded-full hover:opacity-90">Buat Tas Sekarang</button>
    </div>
  </template>
</div>

<div id="drag-ghost"></div>

{{-- ══════ MODAL BUAT TAS — Alpine JS ══════ --}}
<template x-teleport="body">
    <div
        x-show="$store.tasBuat.open"
        style="display:none;"
        class="fixed inset-0 z-[9000] flex items-center justify-center p-4"
    >
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="$store.tasBuat.tutup()"></div>
        <div class="bg-white rounded-[24px] md:rounded-[32px] w-full max-w-[480px] max-h-[90vh] overflow-y-auto p-6 md:p-8 relative z-10" @click.stop>
            
            {{-- HEADER --}}
            <div class="flex items-start justify-between mb-6">
                <h3 class="font-head font-bold text-navy" style="font-size:28px; color: var(--c-teal-xdk);">Buat Tas Baru</h3>
                <button type="button" @click="$store.tasBuat.tutup()"
                    class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 transition-colors bg-gray-100 hover:bg-gray-200">
                    <svg width="20" height="20" fill="none" stroke="#6b7280" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form @submit.prevent="$store.tasBuat.submit()">
                <div class="flex flex-col gap-5">
                    {{-- Nama Tas --}}
                    <div>
                        <label class="block text-[14px] font-semibold mb-2" style="color: var(--c-teal-xdk);">Nama Tas</label>
                        <input type="text" x-model="$store.tasBuat.form.nama" placeholder="Contoh: Tas Keluarga" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-2xl text-[14px] text-gray-800 outline-none focus:border-[var(--c-teal-dk)]"/>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-[14px] font-semibold mb-2" style="color: var(--c-teal-xdk);">Kategori</label>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="k in ['anak','remaja','dewasa','lansia']" :key="k">
                                <button type="button" @click="$store.tasBuat.form.kategori = k"
                                    class="p-3 border rounded-2xl text-[14px] font-semibold capitalize transition-all"
                                    :class="$store.tasBuat.form.kategori === k ? 'text-white' : 'bg-white text-gray-700 border-gray-200'"
                                    :style="$store.tasBuat.form.kategori === k ? 'background: var(--c-teal-dk); border-color: var(--c-teal-dk);' : ''"
                                    x-text="k">
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Dimensi --}}
                    <div>
                        <label class="block text-[14px] font-semibold mb-1" style="color: var(--c-teal-xdk);">
                            Dimensi Tas <span class="font-normal text-[12px] text-gray-400">(cm) — opsional jika isi liter langsung</span>
                        </label>
                        <div class="flex items-end gap-2">
                            <div class="flex-1 text-center">
                                <p class="text-[12px] text-gray-500 mb-1">Panjang</p>
                                <input type="number" x-model="$store.tasBuat.form.p" @input="$store.tasBuat.hitungLiter()" placeholder="cm" min="1" max="200" step="0.5"
                                    class="w-full py-2 px-3 border border-gray-200 rounded-xl text-[13px] text-center outline-none"/>
                            </div>
                            <span class="text-gray-300 mb-2 font-medium">×</span>
                            <div class="flex-1 text-center">
                                <p class="text-[12px] text-gray-500 mb-1">Lebar</p>
                                <input type="number" x-model="$store.tasBuat.form.l" @input="$store.tasBuat.hitungLiter()" placeholder="cm" min="1" max="200" step="0.5"
                                    class="w-full py-2 px-3 border border-gray-200 rounded-xl text-[13px] text-center outline-none"/>
                            </div>
                            <span class="text-gray-300 mb-2 font-medium">×</span>
                            <div class="flex-1 text-center">
                                <p class="text-[12px] text-gray-500 mb-1">Tinggi</p>
                                <input type="number" x-model="$store.tasBuat.form.t" @input="$store.tasBuat.hitungLiter()" placeholder="cm" min="1" max="200" step="0.5"
                                    class="w-full py-2 px-3 border border-gray-200 rounded-xl text-[13px] text-center outline-none"/>
                            </div>
                        </div>

                        {{-- Preview liter dari dimensi --}}
                        <div x-show="$store.tasBuat.previewLiter > 0" class="mt-2 bg-gray-50 rounded-xl px-3 py-2 flex items-center justify-between">
                            <span class="text-[12px] text-gray-600">Kapasitas dari dimensi:</span>
                            <span class="font-bold text-[14px]" style="color: var(--c-teal-xdk);" x-text="$store.tasBuat.previewLiter + ' Liter'"></span>
                        </div>

                        {{-- Input liter langsung --}}
                        <div class="mt-3">
                            <p class="text-[12px] text-gray-500 mb-1">
                                Atau input liter langsung: <span class="text-gray-400">(dimensi dihitung otomatis)</span>
                            </p>
                            <input type="number" x-model="$store.tasBuat.form.liter" @input="$store.tasBuat.resetDimensi()" placeholder="Contoh: 50" min="1" max="500" step="0.1"
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-[13px] outline-none"/>
                        </div>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="$store.tasBuat.tutup()"
                        class="flex-1 p-3.5 border border-gray-200 bg-white text-gray-700 text-[14px] font-semibold rounded-2xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 p-3.5 text-white text-[14px] font-semibold rounded-2xl transition-colors"
                        style="background: var(--c-teal-dk);">
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
        {title: "1. Kenali Risiko", desc: "Pastikan struktur rumah kuat & aman."}, 
        {title: "2. Amankan Area", desc: "Ikat furnitur berat ke dinding."}, 
        {title: "3. Jalur Evakuasi", desc: "Tentukan titik kumpul keluarga."},
        {title: "4. Simulasi", desc: "Lakukan latihan evakuasi rutin."}, 
        {title: "5. Tas Siaga", desc: "Siapkan tas P3K, makanan, dan senter."}, 
        {title: "6. Kontak Darurat", desc: "Simpan nomor penting di HP/kertas."}
    ],
    banjir: [
        {title: "1. Cek Drainase", desc: "Bersihkan selokan dari tumpukan sampah."}, 
        {title: "2. Simpan Dokumen", desc: "Bungkus surat penting di plastik kedap air."}, 
        {title: "3. Pahami Jalur", desc: "Ketahui letak posko pengungsian terdekat."},
        {title: "4. Posisi Barang", desc: "Pindahkan alat elektronik ke tempat tinggi."}, 
        {title: "5. Siaga Listrik", desc: "Ketahui letak saklar utama untuk dimatikan."}, 
        {title: "6. Pantau Info", desc: "Selalu cek perkiraan cuaca lokal."}
    ],
    kebakaran: [
        {title: "1. Siapkan APAR", desc: "Sediakan alat pemadam atau karung goni."}, 
        {title: "2. Cek Listrik", desc: "Hindari stop kontak bertumpuk/kabel terkelupas."}, 
        {title: "3. Bahan Mudah Terbakar", desc: "Jauhkan barang mudah terbakar dari kompor."},
        {title: "4. Detektor Asap", desc: "Pasang dan cek baterai secara berkala."}, 
        {title: "5. Rute Keluar", desc: "Pastikan pintu atau jendela tidak terhalang barang."}
    ],
    tsunami: [
        {title: "1. Kenali Tanda Alam", desc: "Gempa sangat kuat atau air laut surut tiba-tiba."}, 
        {title: "2. Peta Evakuasi", desc: "Hafalkan jalur lari ke dataran yang lebih tinggi."}, 
        {title: "3. Tas Siaga Bencana", desc: "Siapkan tas darurat yang mudah dibawa lari."},
        {title: "4. Sistem Peringatan", desc: "Ketahui suara sirine bahaya di daerahmu."}
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
            <div class="info-card w-full h-full flex flex-col" style="animation-delay: ${idx * 0.1}s">
                <div class="img-box w-full h-32 md:h-40 bg-gray-100 rounded-lg mb-4 flex-shrink-0"></div>
                <h3 class="font-bold text-lg mb-2 text-[var(--h-teal-dk)]">${item.title}</h3>
                <p class="text-sm text-gray-500 flex-1">${item.desc}</p>
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

function removePlacedItem(el, p) {
    el.remove();
    placed[p.zona] = placed[p.zona].filter(x => x !== p);
    const card = document.querySelector(`[data-item-id="${p.itemId}"]`);
    if (card) card.classList.remove('used');
    window.dispatchEvent(new CustomEvent('item-removed', {detail:{id: p.itemId}}));
    window.dispatchEvent(new CustomEvent('update-stats'));
}

function createPlacedEl(p) {
    const el = document.createElement('div');
    el.className = 'placed-item';
    el.dataset.itemId = p.itemId;
    el.style.cssText = `left:${p.x}px;top:${p.y}px;width:${p.px.w}px;height:${p.px.h}px;z-index:10;position:absolute;cursor:move`;
    el.innerHTML = makeSvg(p.namaItem, p.zona, p.px.w, p.px.h);
    el.title = window.innerWidth < 1024 ? 'Tap untuk kembalikan' : 'Geser bebas · Klik 2× hapus';
    
    if (window.innerWidth >= 1024) {
        el.addEventListener('mousedown', e => startDragPlaced(e, p, el));
    }
    el.addEventListener('touchstart', e => {
        if (window.innerWidth >= 1024) startDragPlaced(e, p, el);
    }, {passive:false});
    
    el.addEventListener('dblclick', e => {
        e.stopPropagation();
        removePlacedItem(el, p);
    });
    
    el.addEventListener('click', e => {
        if (window.innerWidth < 1024) {
            e.stopPropagation();
            removePlacedItem(el, p);
        }
    });

    document.getElementById('inner-area')?.appendChild(el);
    p.el = el; // simpan referensi el ke dalam objek p
    return el;
}

window.tapAddItemMobile = function(itemId, namaItem, zonaSaran, rotated) {
    const baseCm = ITEM_CM[namaItem] || DEFAULT_CM;
    const cm = rotated ? {w: baseCm.h, h: baseCm.w} : baseCm;
    const px = {
        w: Math.max(10, Math.round(cm.w * PX_PER_CM)),
        h: Math.max(8, Math.round(cm.h * PX_PER_CM)),
    };
    
    const p = {uid:'r_'+itemId+'_'+Date.now(), itemId, namaItem, zona: zonaSaran, px, x:0, y:ZONA_TOP[zonaSaran], rotated: !!rotated};
    placed[zonaSaran].push(p);
    
    createPlacedEl(p);
    sortZona(zonaSaran);
    
    window.dispatchEvent(new CustomEvent('item-placed', {detail:{id: itemId, namaItem: namaItem, zona_saran: zonaSaran, x:p.x, y:p.y, rotated: !!rotated}}));
    window.dispatchEvent(new CustomEvent('update-stats'));
};

function startDragCard(e, itemId, namaItem, zonaSaran, rotated = false) {
    // Guard: cek modal vanilla JS, bukan Alpine store
    const modalEl = document.getElementById('modal-buat-tas');
    if (modalEl && modalEl.style.display === 'flex') return;

    const pos = getPos(e);
    const baseCm = ITEM_CM[namaItem] || DEFAULT_CM;
    const cm = rotated ? {w: baseCm.h, h: baseCm.w} : baseCm;
    const px = {
        w: Math.max(10, Math.round(cm.w * PX_PER_CM)),
        h: Math.max(8, Math.round(cm.h * PX_PER_CM)),
    };
    
    dragging = {itemId, namaItem, zonaSaran, px, isNew: true, placed: null, rotated, offX: px.w/2, offY: px.h/2};
    
    let dg = document.getElementById('drag-ghost');
    if (!dg) { 
        dg = document.createElement('div'); 
        dg.id = 'drag-ghost'; 
        document.body.appendChild(dg); 
    }
    
    dg.innerHTML = makeSvg(namaItem, zonaSaran, px.w, px.h);
    
    dg.style.cssText = 'position:fixed;z-index:9999;pointer-events:none;display:block;left:0;top:0';
    
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
        const zonaColor = zona==='sangat_penting' ? '#C0392B' : zona==='penting' ? '#E67E22' : '#27AE60';
        const zonaRgb   = zona==='sangat_penting' ? '192,57,43' : zona==='penting' ? '230,126,34' : '39,174,96';
        const isValid   = snap.valid && !overflowH;
        gb.style.cssText = `display:block;left:${snap.x}px;top:${snap.y}px;width:${dragging.px.w}px;height:${dragging.px.h}px;z-index:40;border-radius:4px;pointer-events:none;position:absolute;border:2px dashed ${isValid ? zonaColor : '#aaa'};background:rgba(${isValid ? zonaRgb : '0,0,0'},.${isValid ? '12' : '04'});`;
        gb.className = 'ghost-box' + (isValid ? '' : ' bad');
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
// 6. ALPINE STORE
// ==========================================
document.addEventListener('alpine:init', () => {
    Alpine.store('tasBuat', {
        open: false,
        form: { nama: '', kategori: 'dewasa', liter: '', p: '', l: '', t: '' },
        previewLiter: 0,
        tutup() {
            this.open = false;
            document.body.classList.remove('modal-open');
            this.form = { nama: '', kategori: 'dewasa', liter: '', p: '', l: '', t: '' };
            this.previewLiter = 0;
        },
        hitungLiter() {
            const p = parseFloat(this.form.p);
            const l = parseFloat(this.form.l);
            const t = parseFloat(this.form.t);
            if (p > 0 && l > 0 && t > 0) {
                this.previewLiter = parseFloat((p * l * t / 1000).toFixed(1));
                this.form.liter = '';
            } else {
                this.previewLiter = 0;
            }
        },
        resetDimensi() {
            if (this.form.liter) {
                this.form.p = ''; this.form.l = ''; this.form.t = '';
                this.previewLiter = 0;
            }
        },
        submit() {
            const nama = this.form.nama.trim();
            const kat = this.form.kategori;
            let liter = parseFloat(this.form.liter);
            const p = parseFloat(this.form.p);
            const l = parseFloat(this.form.l);
            const t = parseFloat(this.form.t);

            const hasDim = p > 0 && l > 0 && t > 0;
            if (hasDim && !liter) liter = this.previewLiter;

            if (!nama || !kat || !liter) {
                alert('Lengkapi nama tas, kategori, dan kapasitas (liter).');
                return;
            }

            const newTasObj = {
                id:       'local_' + Date.now(),
                nama_tas: nama,
                kategori: kat,
                liter:    liter,
                dim_p:    hasDim ? p : 0,
                dim_l:    hasDim ? l : 0,
                dim_t:    hasDim ? t : 0,
                items:    []
            };

            this.tutup();
            window.dispatchEvent(new CustomEvent('tas-local-created', { detail: newTasObj }));
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
            // Guard: jika modal vanilla JS terbuka, hentikan drag
            const modalEl = document.getElementById('modal-buat-tas');
            if (modalEl && modalEl.style.display === 'flex') return;
            
            if (e.type==='mousedown' && e.button!==0) return;
            if (e.target.closest('button')) return;
            
            const card = e.target.closest('.icard');
            if (!card || card.classList.contains('used')) return;
            
            // Allow default for touchstart so click can fire on mobile taps
            if (e.cancelable && e.type !== 'touchstart') e.preventDefault();
            
            // Allow drag to continue on mobile without blocking
            const id = card.dataset.itemId || card.dataset.id;
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