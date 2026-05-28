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
        --h-teal:   #2D6A6A;
        --h-sage:   #3E8E8E;
        --h-mint:   #7FC7C7;
        --h-cream:  #E8F6F3;
        --h-dark:   #122B2B;
        --h-muted:  #4A6B6B;
        --h-teal-dk:#1f4848;
        
        --c-teal-dark:      #2D6A6A;
        --c-teal-main:      #3E8E8E;
        --c-teal-light:     #7FC7C7;
        --c-teal-bg:        #E8F6F3;
        
        --c-light:          #EEEEEE;
    }

    /* ══════════════════════
       HERO SECTION
    ══════════════════════ */
    .hero-siaga {
      position: relative;
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
      background: radial-gradient(circle, rgba(127, 199, 199, 0.4) 0%, transparent 68%);
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
      background: rgba(45, 106, 106, 0.12);
      border: 1px solid rgba(45, 106, 106, 0.25);
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
      box-shadow: 0 6px 20px rgba(45, 106, 106, 0.35);
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .hero-btn-main:hover {
      background: var(--h-teal-dk);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(45, 106, 106, 0.42);
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
      border: 1.5px solid rgba(45, 106, 106, 0.28);
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
      box-shadow: 0 4px 24px rgba(45, 106, 106, 0.16);
      border: 1.5px solid rgba(127, 199, 199, 0.65);
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

    .rust-card {
        background: #FFFFFF;
        border: 1px solid #F3F4F6;
        border-radius: 1rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .rust-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .injury-card {
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .injury-card:hover {
        background: #FFFFFF;
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(45, 106, 106, 0.1), 0 4px 6px -2px rgba(45, 106, 106, 0.05);
        border-color: var(--c-teal-light);
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

    .supply-btn {
        background: #FFFFFF;
        border: 1px solid #F3F4F6;
        border-radius: 1rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .supply-btn:hover {
        transform: translateY(-4px);
        border-color: var(--c-teal-main);
        box-shadow: 0 10px 15px -3px rgba(45, 106, 106, 0.1), 0 4px 6px -2px rgba(45, 106, 106, 0.05);
    }

    .mini-card {
        background: #FFFFFF;
        border: 1px solid #F3F4F6;
        border-radius: 1rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .mini-card:hover {
        transform: translateY(-4px);
        border-color: var(--c-teal-main);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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
        border:1px dashed var(--c-teal-main);
        background:var(--c-teal-bg);
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
        background:var(--c-teal-main);
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
        background:var(--c-teal-main);
        color:white;
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
    <section class="hero-siaga pt-24 md:pt-28 min-h-[calc(100vh-5rem)]">
      <div class="hero-siaga__inner">
     
        {{-- ══ LEFT TEXT ══ --}}
        <div class="hero-siaga__text">
     
          <div class="hero-siaga__eyebrow">
             Mode Pemulihan Pasca Bencana
          </div>
     
          <h1 class="hero-siaga__h1">
            Tetap Tenang.<br/>
            <em>Lanjut Bertahan.</em>
          </h1>
     
          <p class="hero-siaga__desc">
            Penanganan luka, pencarian supply, tutorial survival, dan informasi caregiver untuk kondisi pasca bencana.
          </p>
     
          <div class="hero-siaga__cta">
            <a href="#after-category-container" class="hero-btn-main">🏥 Panduan Pemulihan</a>
            <a href="#supply" class="hero-btn-ghost"><i class="fa-solid fa-screwdriver-wrench text-gray-600"></i> Cari Supply</a>
          </div>
     
        </div>
     
        {{-- ══ RIGHT ILLUSTRATION ══ --}}
        <div class="hero-siaga__scene">
     
          {{-- FLAT 2D SVG SCENE (TWILIGHT PALETTE) --}}
          <svg class="hero-siaga__svg" viewBox="0 0 540 460" fill="none" xmlns="http://www.w3.org/2000/svg">
     
            {{-- BG --}}
            <rect width="540" height="460" rx="24" fill="#0B1B1B"/>
     
            {{-- Moon --}}
            <circle cx="438" cy="100" r="32" fill="#E8F6F3" opacity="0.9"/>
            <circle cx="438" cy="100" r="44" fill="#E8F6F3" opacity="0.15"/>
     
            {{-- clouds --}}
            <g opacity="0.25">
              <ellipse cx="96" cy="78" rx="38" ry="20" fill="#7FC7C7"/>
              <ellipse cx="74" cy="84" rx="22" ry="16" fill="#7FC7C7"/>
              <ellipse cx="118" cy="86" rx="20" ry="14" fill="#7FC7C7"/>
              <ellipse cx="96" cy="90" rx="42" ry="14" fill="#7FC7C7"/>
            </g>
            <g opacity="0.15">
              <ellipse cx="318" cy="55" rx="28" ry="14" fill="#7FC7C7"/>
              <ellipse cx="302" cy="60" rx="16" ry="11" fill="#7FC7C7"/>
              <ellipse cx="334" cy="62" rx="14" ry="10" fill="#7FC7C7"/>
              <ellipse cx="318" cy="66" rx="31" ry="10" fill="#7FC7C7"/>
            </g>
     
            {{-- mountains --}}
            <ellipse cx="90"  cy="320" rx="140" ry="95" fill="#1F3E3E" opacity="0.40"/>
            <ellipse cx="470" cy="315" rx="130" ry="88" fill="#1F3E3E" opacity="0.40"/>
            <ellipse cx="60"  cy="380" rx="170" ry="75" fill="#1F3E3E" opacity="0.55"/>
            <ellipse cx="490" cy="375" rx="160" ry="70" fill="#1F3E3E" opacity="0.55"/>
            <ellipse cx="270" cy="430" rx="330" ry="72" fill="#2D5353"/>
     
            {{-- ground --}}
            <rect x="0" y="388" width="540" height="72" fill="#2D5353"/>
            <ellipse cx="100" cy="388" rx="80"  ry="18" fill="#2D5353"/>
            <ellipse cx="270" cy="386" rx="120" ry="20" fill="#2D5353"/>
            <ellipse cx="430" cy="388" rx="90"  ry="18" fill="#2D5353"/>
     
            {{-- path --}}
            <path d="M248 390 Q270 350 292 390 L296 460 L244 460 Z" fill="#122B2B" opacity="0.6"/>
            <path d="M263 370 Q270 358 277 370 L279 390 L261 390 Z" fill="#122B2B" opacity="0.4"/>
     
            {{-- trees left --}}
            <rect x="44" y="340" width="12" height="52" rx="5" fill="#0B1B1B"/>
            <ellipse cx="50" cy="324" rx="28" ry="34" fill="#0B1B1B"/>
            <ellipse cx="50" cy="316" rx="20" ry="24" fill="#122B2B"/>
     
            <rect x="98" y="354" width="10" height="38" rx="4" fill="#0B1B1B"/>
            <ellipse cx="103" cy="340" rx="22" ry="28" fill="#0B1B1B"/>
            <ellipse cx="103" cy="332" rx="16" ry="20" fill="#122B2B"/>
     
            <ellipse cx="160" cy="385" rx="20" ry="14" fill="#122B2B"/>
            <ellipse cx="148" cy="388" rx="14" ry="11" fill="#0B1B1B" opacity="0.6"/>
            <ellipse cx="172" cy="387" rx="13" ry="10" fill="#0B1B1B" opacity="0.6"/>
     
            {{-- trees right --}}
            <rect x="434" y="342" width="12" height="50" rx="5" fill="#0B1B1B"/>
            <ellipse cx="440" cy="326" rx="28" ry="34" fill="#0B1B1B"/>
            <ellipse cx="440" cy="318" rx="20" ry="24" fill="#122B2B"/>
     
            <rect x="382" y="356" width="10" height="36" rx="4" fill="#0B1B1B"/>
            <ellipse cx="387" cy="342" rx="22" ry="27" fill="#0B1B1B"/>
            <ellipse cx="387" cy="335" rx="16" ry="19" fill="#122B2B"/>
     
            <ellipse cx="480" cy="386" rx="22" ry="14" fill="#122B2B"/>
            <ellipse cx="468" cy="389" rx="14" ry="10" fill="#0B1B1B" opacity="0.55"/>
     
            {{-- house shadow --}}
            <ellipse cx="270" cy="396" rx="95" ry="10" fill="#0B1B1B" opacity="0.4"/>
     
            {{-- house walls --}}
            <rect x="184" y="294" width="172" height="100" rx="6" fill="#1F3E3E"/>
            <rect x="318" y="294" width="38"  height="100" rx="0" fill="#122B2B" opacity="0.4"/>
     
            {{-- door --}}
            <rect x="248" y="336" width="44" height="58" rx="5" fill="#122B2B"/>
            <rect x="248" y="336" width="44" height="58" rx="5" fill="#0B1B1B" opacity="0.28"/>
            <rect x="254" y="342" width="14" height="20" rx="3" fill="#0B1B1B" opacity="0.22"/>
            <rect x="272" y="342" width="14" height="20" rx="3" fill="#0B1B1B" opacity="0.22"/>
            <circle cx="268" cy="368" r="3.5" fill="#0B1B1B"/>
            <circle cx="272" cy="368" r="3.5" fill="#0B1B1B"/>
     
            {{-- left window (lights on) --}}
            <rect x="196" y="310" width="42" height="36" rx="5" fill="#FDE68A" opacity="0.85"/>
            <rect x="196" y="310" width="42" height="36" rx="5" fill="#F59E0B" opacity="0.2"/>
            <g stroke="#D97706" stroke-width="2.5" opacity="0.5">
              <line x1="217" y1="310" x2="217" y2="346"/>
              <line x1="196" y1="328" x2="238" y2="328"/>
            </g>
     
            {{-- right window (lights off) --}}
            <rect x="302" y="310" width="42" height="36" rx="5" fill="#122B2B" opacity="0.7"/>
            <g stroke="#0B1B1B" stroke-width="2.5" opacity="0.5">
              <line x1="323" y1="310" x2="323" y2="346"/>
              <line x1="302" y1="328" x2="344" y2="328"/>
            </g>
     
            {{-- roof --}}
            <path d="M168 296 L270 230 L372 296 Z" fill="#122B2B"/>
            <path d="M270 230 L372 296 L356 296 L270 240 Z" fill="#0B1B1B" opacity="0.3"/>
            <path d="M220 262 L234 262 L234 220 L220 220 Z" fill="#0B1B1B"/>
     
            {{-- roof edge --}}
            <path d="M164 298 L270 228 L376 298 L370 304 L270 238 L170 304 Z" fill="#091414"/>
     
            {{-- bushes --}}
            <ellipse cx="178" cy="388" rx="26" ry="14" fill="#0B1B1B"/>
            <ellipse cx="204" cy="392" rx="18" ry="10" fill="#122B2B"/>
            <ellipse cx="362" cy="388" rx="26" ry="14" fill="#0B1B1B"/>
            <ellipse cx="336" cy="392" rx="18" ry="10" fill="#122B2B"/>
          </svg>
     
          {{-- FLOATING BADGES --}}
          <div class="h-badge h-badge--gempa">
            <div class="h-badge__icon" style="background:#FFEBEB; color:#C0392B;"><i class="fa-solid fa-droplet text-red-600"></i></div>
            <div class="h-badge__text">
              <strong>P3K Darurat</strong>
              <small>Rawat Luka Cepat</small>
            </div>
          </div>
     
          <div class="h-badge h-badge--banjir">
            <div class="h-badge__icon" style="background:#EBF5FF; color:#2980B9;"><i class="fa-solid fa-droplet text-blue-500"></i></div>
            <div class="h-badge__text">
              <strong>Cari Air Minum</strong>
              <small>Filter Darurat</small>
            </div>
          </div>
     
          <div class="h-badge h-badge--kebakaran">
            <div class="h-badge__icon" style="background:#E8F6F3; color:#16A085;">🏕️</div>
            <div class="h-badge__text">
              <strong>Bangun Bivak</strong>
              <small>Tutorial Survival</small>
            </div>
          </div>
     
          <div class="h-badge h-badge--longsor">
            <div class="h-badge__icon" style="background:#F4ECF7; color:#8E44AD;"><i class="fa-solid fa-brain text-pink-300"></i></div>
            <div class="h-badge__text">
              <strong>Pemulihan Mental</strong>
              <small>Trauma Healing</small>
            </div>
          </div>
     
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                        <template x-for="item in injuries.luar">
                            <button
                                @click="openCaregiver(item)"
                                class="injury-card rust-card rounded-[28px] p-6 text-center"
                            >
                                <div class="injury-icon" x-html="item.icon"></div>

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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                        <template x-for="item in injuries.dalam">
                            <button
                                @click="openCaregiver(item)"
                                class="injury-card rust-card rounded-[28px] p-6 text-center"
                            >
                                <div class="injury-icon" x-html="item.icon"></div>

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
                <button data-category="kebakaran" class="after-category-btn disaster-btn">Kebakaran</button>
                <button data-category="tsunami" class="after-category-btn disaster-btn">Tsunami</button>
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

            <div id="supply" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-8">

                <button
                    @click="openSupply('minum')"
                    class="supply-btn rounded-[28px] p-10 text-center"
                >
                    <div class="text-6xl mb-5"><i class="fa-solid fa-droplet text-blue-500"></i></div>

                    <h3 class="font-bold text-xl mb-3">Minum</h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Cari sumber air, filter air darurat, dan tanda alam lokasi air.
                    </p>
                </button>

                <a href="#informasi-section"
                    class="supply-btn rounded-[28px] p-10 text-center block"
                >
                    <div class="text-6xl mb-5"><i class="fa-solid fa-band-aid text-orange-300"></i></div>

                    <h3 class="font-bold text-xl mb-3">P3K</h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Penanganan luka dan akses cepat menuju caregiver.
                    </p>
                </a>

                <a href="#crafting-section"
                    class="supply-btn rounded-[28px] p-10 text-center block"
                >
                    <div class="text-6xl mb-5"><i class="fa-solid fa-screwdriver-wrench text-gray-600"></i></div>

                    <h3 class="font-bold text-xl mb-3">Alat</h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Crafting alat darurat dan improvisasi survival.
                    </p>
                </a>

            </div>

        </div>

    </section>

{{-- INFORMASI --}}
    {{-- Background pakai #EEEEEE biar misah sama section di bawahnya --}}
    <section id="informasi-section" class="py-16 bg-[#EEEEEE] border-y border-black/5">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <div class="mb-10">
                {{-- Accent Bar kecil di atas judul ala Netral --}}
                <div class="w-11 h-1.5 rounded-full mb-3" style="background: var(--c-teal-main);"></div>
                <h2 class="font-head text-3xl font-bold" style="color: var(--c-teal-dark);">Informasi & Survive</h2>
                <p class="mt-2 text-gray-500">Panduan penanganan medis dan tutorial cepat</p>
            </div>

            {{-- Grid 2 Kolom Lebar --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                <template x-for="item in infoItems">
                    <div @click="openInfo(item)" class="bg-white p-5 rounded-[22px] border border-gray-200 shadow-sm cursor-pointer transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                        
                        {{-- Box Gambar Lebar --}}
                        <div class="h-48 rounded-xl flex items-center justify-center text-6xl mb-4" style="background: var(--c-teal-bg);">
                            <span x-html="item.icon"></span>
                        </div>
                        
                        {{-- Teks Rata Kiri --}}
                        <h3 class="text-xl font-bold mt-2" style="color: var(--c-teal-dark);" x-text="item.title"></h3>
                        <p class="text-sm mt-1 leading-relaxed text-gray-500" x-text="item.desc"></p>
                    </div>
                </template>
            </div>

        </div>
    </section>

    {{-- CRAFTING --}}
    <section id="crafting-section" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <div class="mb-10">
                {{-- Accent Bar kecil di atas judul --}}
                <div class="w-11 h-1.5 rounded-full mb-3" style="background: var(--c-teal-main);"></div>
                <h2 class="font-head text-3xl font-bold" style="color: var(--c-teal-dark);">Crafting Caregiver</h2>
                <p class="mt-2 text-gray-500">Informasi pembuatan alat (Bahan lebih dari 1)</p>
            </div>

            {{-- Grid 4 Kolom --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <template x-for="craft in craftingItems">
                    <button @click="openCraft(craft)" class="bg-white p-5 rounded-[22px] border border-gray-200 cursor-pointer transition-all hover:shadow-md hover:-translate-y-1 text-center w-full shadow-sm">
                        
                        {{-- Box Gambar Kotak --}}
                        <div class="h-48 rounded-xl flex items-center justify-center text-6xl mb-4" style="background: var(--c-teal-bg);">
                            <span x-html="craft.icon"></span>
                        </div>
                        
                        {{-- Teks Rata Tengah --}}
                        <h3 class="text-sm font-bold" style="color: var(--c-teal-dark);" x-text="craft.title"></h3>
                        <p class="text-[11px] mt-1 text-gray-400">Tap untuk detail crafting</p>
                    </button>
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
            class="fixed inset-0 z-[9000] flex items-center justify-center p-4"
        >
            <div
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                @click="modal = false"
            ></div>

            <!-- INJURY MODAL -->
            <template x-if="currentInjuryType === 'injury'">
                
                {{-- min-h diatur agar boxnya punya ruang luas untuk visual mode --}}
                <div class="w-full max-w-4xl bg-white rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col relative z-10" style="min-height: 85vh; max-height: 90vh;">
                    
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
                         class="h-full w-full absolute inset-0 flex flex-col p-6 md:p-8 pt-[12vh] bg-white z-10 overflow-y-auto"
                         @touchstart="touchStartX = $event.changedTouches[0].screenX" 
                         @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()">
                         
                        {{-- 1. Area Tengah: Gambar --}}
                        <div class="flex items-center justify-center mb-6 mt-20 md:mt-16">
                            {{-- Ukuran box h-64 dan max-w-[450px] persis Netral --}}
                            <div class="h-64 w-full max-w-[450px] rounded-2xl flex items-center justify-center border border-black/5 shadow-inner transition-all duration-300" style="background: var(--c-teal-bg);">
                                <div class="text-[100px] drop-shadow-sm transition-transform duration-300" x-html="(modalData.stepVisuals && modalData.stepVisuals[injuryStepIndex]) ? modalData.stepVisuals[injuryStepIndex] : modalData.icon"></div>
                            </div>
                        </div>

                        {{-- 2. Judul & Deskripsi --}}
                        <div class="text-center mb-6 flex-grow">
                            <h3 class="font-bold text-lg" style="color: var(--c-teal-dark);" x-text="modalData.title"></h3>
                            <p class="text-gray-500 text-sm mt-2 max-w-md mx-auto leading-relaxed" x-text="modalData.steps[injuryStepIndex]"></p>
                        </div>

                        {{-- 3. Footer: Grid Pagination, dan Tombol Done --}}
                        <div class="flex flex-wrap md:flex-nowrap justify-between items-center mt-auto pt-4 border-t border-gray-100 gap-4">
                            
                            {{-- Grid Pagination --}}
                            <div class="flex justify-start md:justify-center gap-2 flex-grow overflow-x-auto pb-1 md:pb-0">
                                <template x-for="(step, i) in modalData.steps">
                                    <button @click="injuryStepIndex = i"
                                            class="w-9 h-9 shrink-0 rounded-lg border font-bold text-sm transition-colors"
                                            :class="injuryStepIndex === i ? 'text-white border-transparent' : 'bg-gray-50 text-gray-400 hover:bg-gray-100 border-gray-200'"
                                            :style="injuryStepIndex === i ? 'background: var(--c-teal-dark);' : ''"
                                            x-text="i + 1"></button>
                                </template>
                            </div>

                            <button @click="modal = false"
                                    :disabled="injuryStepIndex !== modalData.steps.length - 1"
                                    :class="injuryStepIndex === modalData.steps.length - 1 ? 'hover:opacity-90' : 'bg-gray-300 cursor-not-allowed'"
                                    :style="injuryStepIndex === modalData.steps.length - 1 ? 'background: var(--c-teal-dark); color: white;' : 'color: white;'"
                                    class="px-6 h-10 shrink-0 rounded-xl font-bold text-xs transition-colors hidden md:block">
                                Done
                            </button>
                        </div>
                        
                        {{-- Tombol Done Mobile --}}
                        <div class="mt-4 md:hidden">
                            <button @click="modal = false"
                                    :disabled="injuryStepIndex !== modalData.steps.length - 1"
                                    :class="injuryStepIndex === modalData.steps.length - 1 ? 'hover:opacity-90' : 'bg-gray-300 cursor-not-allowed'"
                                    :style="injuryStepIndex === modalData.steps.length - 1 ? 'background: var(--c-teal-dark); color: white;' : 'color: white;'"
                                    class="w-full h-10 rounded-xl font-bold text-xs transition-colors">
                                Done
                            </button>
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
                            <div class="injury-modal-icon" x-html="modalData.icon"></div>
                        </div>

                    </div>

                </div>
            </template>

            <!-- INFO MODAL (Ukuran dan Layout Fix 100% Netral) -->
            <template x-if="currentInjuryType === 'info'">
                <div @click.stop class="bg-white rounded-[24px] md:rounded-[32px] w-full max-w-2xl p-6 md:p-8 shadow-2xl flex flex-col relative z-10 max-h-[90vh] overflow-y-auto mx-auto">

                    {{-- 1. Navigasi Angka Atas --}}
                    <div class="flex justify-center gap-2 mb-6">
                        <template x-for="(step, i) in modalData.steps">
                            <button @click="injuryStepIndex = i"
                                    class="w-9 h-9 rounded-lg border font-bold text-sm transition-colors"
                                    :class="injuryStepIndex === i ? 'text-white border-transparent' : 'bg-gray-50 text-gray-400 hover:bg-gray-100 border-gray-200'"
                                    :style="injuryStepIndex === i ? 'background: var(--c-teal-dark);' : ''"
                                    x-text="i + 1"></button>
                        </template>
                    </div>

                    {{-- 2. Area Tengah: Panah - Gambar - Panah --}}
                    <div class="flex items-center justify-center mb-6 gap-2">
                        
                        {{-- Menggunakan teks panah persis seperti di Netral --}}
                        <button @click="if(injuryStepIndex > 0) injuryStepIndex--"
                                class="w-14 flex justify-center text-3xl p-3 rounded-full transition"
                                :class="injuryStepIndex === 0 ? 'text-gray-200 cursor-not-allowed' : 'text-gray-400 hover:bg-gray-100 hover:text-[var(--c-teal-dark)]'">
                            ◀
                        </button>

                        {{-- Ukuran box h-64 dan max-w-[450px] persis Netral --}}
                        <div class="h-64 w-full max-w-[450px] rounded-2xl flex items-center justify-center border border-black/5 shadow-inner" style="background: var(--c-teal-bg);">
                            <div class="text-[100px]" x-html="modalData.steps[injuryStepIndex].i"></div>
                        </div>

                        <button @click="if(injuryStepIndex < modalData.steps.length - 1) injuryStepIndex++"
                                class="w-14 flex justify-center text-3xl p-3 rounded-full transition"
                                :class="injuryStepIndex === modalData.steps.length - 1 ? 'text-gray-200 cursor-not-allowed' : 'text-gray-400 hover:bg-gray-100 hover:text-[var(--c-teal-dark)]'">
                            ▶
                        </button>
                    </div>

                    {{-- 3. Judul & Deskripsi --}}
                    <div class="text-center mb-6 flex-grow">
                        <h3 class="font-bold text-lg" style="color: var(--c-teal-dark);" x-text="modalData.title"></h3>
                        <p class="text-gray-500 text-sm mt-2 max-w-md mx-auto" x-text="modalData.steps[injuryStepIndex].d"></p>
                    </div>

                    {{-- 4. Footer --}}
                    <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                        
                        {{-- Kotak ikon bahan di kiri bawah (Diperbarui dengan Fitur Switch) --}}
                        <template x-if="modalData.tools && modalData.tools.length > 0">
                            <div @click="if(modalData.tools.length > 1) currentToolIndex = (currentToolIndex + 1) % modalData.tools.length" 
                                 class="flex items-center gap-3 transition-all"
                                 :class="modalData.tools.length > 1 ? 'cursor-pointer hover:opacity-80 active:scale-95' : ''">
                                 
                                <div class="relative w-11 h-11 rounded-xl border border-gray-200 bg-[#F8F9FA] flex items-center justify-center text-2xl shadow-sm">
                                    <span x-html="modalData.tools[currentToolIndex].icon"></span>
                                    
                                    {{-- Badge Switch (Hanya muncul jika alat > 1) --}}
                                    <div x-show="modalData.tools.length > 1" 
                                         class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full flex items-center justify-center text-white shadow-sm border-2 border-white"
                                         style="background-color: var(--c-teal-main);">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-gray-400 tracking-wider">TOOL</span>
                                    <span class="text-xs font-bold text-[#111]" x-text="modalData.tools[currentToolIndex].name"></span>
                                </div>
                            </div>
                        </template>
                        <template x-if="!modalData.tools || modalData.tools.length === 0">
                            <div></div> {{-- Spacer kosong kalau gaada tool --}}
                        </template>

                        {{-- Tombol Done ukuran kecil --}}
                        <button @click="modal = false"
                                :disabled="injuryStepIndex !== modalData.steps.length - 1"
                                :class="injuryStepIndex === modalData.steps.length - 1 ? 'hover:opacity-90' : 'bg-gray-300 cursor-not-allowed'"
                                :style="injuryStepIndex === modalData.steps.length - 1 ? 'background: var(--c-teal-dark); color: white;' : 'color: white;'"
                                class="px-8 h-9 rounded-xl font-bold text-xs transition-colors">
                            Done
                        </button>

                    </div>

                </div>
            </template>

            <template x-if="currentInjuryType === 'craft'">
                <div @click.stop class="bg-white rounded-[24px] md:rounded-[32px] w-full max-w-4xl p-6 md:p-10 shadow-2xl flex flex-col transition-all relative z-10 max-h-[95vh] overflow-y-auto mx-auto">
                    
                    {{-- ==========================================
                         VIEW 1: SELECTION BAHAN
                    =========================================== --}}
                    <div x-show="currentView === 'selection'" class="flex flex-col">
                        <div class="flex justify-between items-center mb-5">
                            <h2 class="text-lg font-bold" style="color: var(--c-teal-dark);" x-text="modalData.title"></h2>
                            <button @click="modal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-100 text-gray-400 transition text-sm font-bold">✕</button>
                        </div>
                        
                        <div class="flex gap-5 flex-wrap md:flex-nowrap">
                            <div class="flex flex-col gap-3 flex-shrink-0 w-full md:w-[160px] self-center">
                                <div class="bg-gray-50 rounded-xl border flex flex-col items-center justify-center gap-2 py-6">
                                    <div class="text-6xl drop-shadow-sm" x-html="modalData.icon"></div>
                                    <div class="font-bold text-xs text-center text-gray-600 px-2" style="color: var(--c-teal-dark);" x-text="modalData.title"></div>
                                </div>
                            </div>

                            <div class="flex-1 overflow-y-auto w-full" style="max-height:320px;">
                                <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Bahan (Tap ⇅ untuk Ganti)</p>
                                <div class="grid grid-cols-2 gap-2">
                                    <template x-for="(m, idx) in craftingMaterials" :key="idx">
                                        <div class="border p-3 rounded-xl relative flex flex-col items-center justify-center bg-white shadow-sm min-h-[90px]">
                                            <div class="text-3xl drop-shadow-sm mb-1" x-html="m.icon"></div>
                                            <span class="text-[10px] font-bold text-center leading-tight text-gray-700" x-text="m.name"></span>
                                            <span class="text-[9px] font-semibold uppercase tracking-wide text-gray-400 mt-0.5" x-text="m.role || 'Bahan'"></span>
                                            
                                            <button x-show="m.swappable" @click="switchMaterial(idx)" 
                                                    class="absolute top-1.5 right-1.5 w-5 h-5 flex items-center justify-center bg-teal-500 text-white rounded-full text-[9px] font-bold transition"
                                                    title="Ganti Bahan">⇅</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- SELECTION FOOTER --}}
                        <div class="flex justify-between gap-4 w-full mt-6 pt-4 border-t border-gray-100">
                            <button @click="modal = false" class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition text-sm">Batal</button>
                            <button @click="currentView = 'process'" class="px-8 py-2.5 rounded-xl font-bold text-white shadow-md transition-transform hover:-translate-y-0.5 text-sm tracking-wide" style="background: var(--c-teal-dark);">Next →</button>
                        </div>
                    </div>

                    {{-- ==========================================
                         VIEW 2: PROCESS & SLIDER
                    =========================================== --}}
                    <div x-show="currentView === 'process'" class="flex flex-col"
                         @touchstart="touchStartX = $event.changedTouches[0].screenX" 
                         @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()">
                        
                        <div class="flex justify-center gap-2 mb-6">
                            <template x-for="(step, i) in modalData.steps">
                                <button @click="injuryStepIndex = i" 
                                        class="w-9 h-9 rounded-lg border font-bold text-sm transition-colors" 
                                        :class="injuryStepIndex === i ? 'text-white border-transparent' : 'bg-gray-50 text-gray-400 hover:bg-gray-100 border-gray-200'" 
                                        :style="injuryStepIndex === i ? 'background: var(--c-teal-dark);' : ''"
                                        x-text="i + 1"></button>
                            </template>
                        </div>

                        <div class="h-64 flex items-center justify-center mb-6 gap-2 relative w-full max-w-[450px] mx-auto">
                            {{-- Arrow Kiri (Desktop Only) --}}
                            <button @click="injuryStepIndex--" x-show="injuryStepIndex > 0" class="absolute -left-12 md:-left-16 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border shadow-sm flex items-center justify-center text-gray-400 hover:text-[var(--c-teal-dark)] hidden md:flex transition-colors z-10">◀</button>
                            
                            <div class="w-full h-full rounded-2xl flex items-center justify-center border border-black/5 shadow-inner" style="background: var(--c-teal-bg);">
                                <div class="text-[110px] drop-shadow-sm transition-transform duration-300" x-html="modalData.steps[injuryStepIndex].i"></div>
                            </div>

                            {{-- Arrow Kanan (Desktop Only) --}}
                            <button @click="injuryStepIndex++" x-show="injuryStepIndex < modalData.steps.length - 1" class="absolute -right-12 md:-right-16 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white border shadow-sm flex items-center justify-center text-gray-400 hover:text-[var(--c-teal-dark)] hidden md:flex transition-colors z-10">▶</button>
                        </div>

                        <div class="text-center mb-5">
                            <h3 class="font-bold text-lg mb-1" style="color: var(--c-teal-dark);" x-text="'Step ' + (injuryStepIndex + 1)"></h3>
                            <p class="text-gray-500 text-sm px-10 leading-relaxed" x-text="modalData.steps[injuryStepIndex].d"></p>
                        </div>

                        <div class="flex gap-3 mb-5 justify-center">
                            <template x-for="m in craftingMaterials">
                                <div class="flex flex-col items-center justify-center bg-gray-50 p-1.5 w-[65px] rounded-lg border border-gray-100">
                                    <div class="text-xl mb-0.5" x-html="m.icon"></div>
                                    <span class="text-[8px] font-bold text-center leading-tight text-gray-600" x-text="m.name"></span>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                            <button @click="currentView = 'selection'" 
                                    class="px-6 py-2 border border-gray-200 text-gray-500 rounded-xl font-bold hover:bg-gray-50 transition-colors text-sm">Prev</button>
                            
                            <button @click="modal = false" 
                                    :disabled="injuryStepIndex !== modalData.steps.length - 1"
                                    :class="injuryStepIndex === modalData.steps.length - 1 ? 'hover:opacity-90 shadow-md text-white' : 'bg-gray-300 cursor-not-allowed text-white'"
                                    :style="injuryStepIndex === modalData.steps.length - 1 ? 'background: var(--c-teal-dark);' : ''"
                                    class="px-8 py-2 rounded-xl font-bold transition-all text-sm tracking-wide">Done</button>
                        </div>
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

        currentView: 'selection',
        craftingMaterials: [],

        // --- TAMBAHAN BARU: Variabel Mode Visual & Swipe ---
        currentInjuryType: null,
        injuryViewMode: 'visual',
        injuryStepIndex: 0,
        currentToolIndex: 0,
        
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
                    icon:'<i class="fa-solid fa-droplet text-red-600"></i>',
                    desc:'Luka terbuka akibat benda tajam',
                    detail:'Penanganan luka sayat memerlukan pembersihan menyeluruh. Gunakan air bersih mengalir. Jangan gunakan antiseptik (betadine) langsung pada luka terbuka karena merusak jaringan.',
                    tags:['Air Bersih','Balut', 'Tekan'],
                    steps: [
                        'Cuci tangan dengan sabun bersih',
                        'Bilas luka dengan air bersih yang mengalir secara menyeluruh',
                        'Tekan luka dengan kain bersih untuk menghentikan darah',
                        'Gunakan salep antibiotik ringan (opsional) di sekitar luka',
                        'Balut dengan kain steril'
                    ],
                    stepVisuals: ['🧼', '<i class="fa-solid fa-faucet-drip text-blue-400"></i>', '<i class="fa-solid fa-droplet text-red-600"></i>', '<i class="fa-solid fa-pills text-red-500"></i>', '<i class="fa-solid fa-head-side-medical text-orange-400"></i>']
                },
                {
                    id:'luka_lecet',
                    name:'Luka Lecet',
                    icon:'<i class="fa-solid fa-band-aid text-orange-300"></i>',
                    desc:'Gesekan pada kulit',
                    detail:'Luka lecet (abrasi) adalah luka superfisial akibat gesekan. Fokus pada pembersihan dan pencegahan infeksi menggunakan sabun ringan, bukan yodium keras.',
                    tags:['Sabun Ringan','Bersih'],
                    steps: [
                        'Bilas area lecet dengan air bersih mengalir',
                        'Singkirkan kotoran atau debu dengan lembut menggunakan sabun ringan',
                        'Oleskan salep antibiotik ringan jika tersedia',
                        'Tutup dengan kain kasa jika diperlukan atau di area yang mudah kotor',
                        'Jangan digosok, biarkan kering alami'
                    ],
                    stepVisuals: ['<i class="fa-solid fa-faucet-drip text-blue-400"></i>', '🧼', '<i class="fa-solid fa-pills text-red-500"></i>', '<i class="fa-solid fa-band-aid text-orange-300"></i>', '🌬️']
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
                    ],
                    stepVisuals: ['🚫', '<i class="fa-solid fa-ribbon text-yellow-500"></i>', '<i class="fa-solid fa-truck-medical text-red-500"></i>', '<i class="fa-solid fa-bed text-blue-400"></i>', '👀']
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
                        'Dinginkan area luka dengan air dingin mengalir 10-15 menit',
                        'Jangan menggosok atau memberikan es langsung',
                        'Keluarkan perhiasan/gelang dari area luka',
                        'Tutup dengan perban steril secara longgar (jangan pasta gigi)'
                    ],
                    stepVisuals: ['<i class="fa-solid fa-person-running text-green-500"></i>', '<i class="fa-solid fa-faucet-drip text-blue-400"></i>', '🧊', '💍', '<i class="fa-solid fa-band-aid text-orange-300"></i>']
                }
            ],

            dalam:[
                {
                    id:'patah_tulang',
                    name:'Patah Tulang',
                    icon:'<i class="fa-solid fa-bone text-gray-300 drop-shadow-md"></i>',
                    desc:'Stabilkan area tubuh',
                    detail:'Patah tulang memerlukan imobilisasi segera untuk mencegah kerusakan lebih lanjut. Buat bidai darurat dan ingat untuk JANGAN mengikat tepat di area patah.',
                    tags:['Bidai','Imobilisasi','Medis'],
                    steps: [
                        'Immobilisasi area yang dicurigai patah (jangan coba diluruskan)',
                        'Buat bidai dari ranting, papan, atau benda kaku',
                        'Ikat bidai HARUS di atas dan di bawah area patah (bukan tepat di titik patah)',
                        'Kompres dengan air dingin jika ada pembengkakan',
                        'Segera bawa ke pusat medis'
                    ],
                    stepVisuals: ['<i class="fa-solid fa-ban text-red-600"></i>', '<i class="fa-solid fa-tree text-amber-900"></i>', '<i class="fa-solid fa-compress text-gray-400"></i>', '🧊', '<i class="fa-solid fa-truck-medical text-red-500"></i>']
                },
                {
                    id:'cedera_kepala',
                    name:'Cedera Kepala',
                    icon:'<i class="fa-solid fa-brain text-pink-300"></i>',
                    desc:'Pantau kesadaran',
                    detail:'Cedera kepala dapat mengancam jiwa. JANGAN ubah posisi korban (jangan dimiringkan) jika curiga cedera leher/tulang belakang kecuali korban tersedak muntah.',
                    tags:['BAHAYA','Monitor','Medis'],
                    steps: [
                        'JANGAN pindahkan atau miringkan jika curiga cedera leher/tulang belakang',
                        'Monitor kesadaran dan responsif secara ketat',
                        'Cek adanya perdarahan dari telinga/hidung',
                        'Jika perlu tidur, bangunkan dan cek setiap beberapa jam',
                        'Hubungi medis darurat segera'
                    ],
                    stepVisuals: ['🚫', '👀', '<i class="fa-solid fa-droplet text-red-600"></i>', '⏰', '<i class="fa-solid fa-truck-medical text-red-500"></i>']
                },
                {
                    id:'sesak_nafas',
                    name:'Sesak Nafas',
                    icon:'<i class="fa-solid fa-lungs text-pink-400"></i>',
                    desc:'Posisikan duduk setengah bersandar',
                    detail:'Sesak napas (seperti asma atau panik) membutuhkan ruang paru-paru untuk mengembang. Jangan baringkan rata atau lakukan CPR kecuali henti napas.',
                    tags:['Duduk Bersandar','Tenang','Inhaler'],
                    steps: [
                        'Posisikan korban duduk setengah bersandar (High Fowler / W-position)',
                        'Longgarkan pakaian yang ketat di area dada dan leher',
                        'Bantu gunakan inhaler jika mereka memiliki riwayat asma',
                        'Tenangkan korban, ajak bernapas perlahan bersama',
                        'Hubungi ambulans jika tidak membaik'
                    ],
                    stepVisuals: ['🪑', '<i class="fa-solid fa-shirt text-blue-400"></i>', '🌬️', '<i class="fa-solid fa-handshake text-yellow-600"></i>', '<i class="fa-solid fa-truck-medical text-red-500"></i>']
                },
                {
                    id:'pingsan',
                    name:'Pingsan',
                    icon:'😵',
                    desc:'Baringkan dan angkat kaki',
                    detail:'Pingsan (sinkop) terjadi karena kurangnya darah ke otak. Segera baringkan telentang dan angkat kaki (Shock Position). Hanya gunakan posisi miring jika muntah.',
                    tags:['Angkat Kaki','Shock Position','Monitor'],
                    steps: [
                        'Baringkan telentang, angkat kaki lebih tinggi dari jantung (Shock Position)',
                        'HANYA miringkan (Recovery Position) jika korban muntah',
                        'Cek responsif dengan panggil dan sentuh ringan',
                        'Longgarkan pakaian yang ketat',
                        'Hubungi medis jika belum sadar lebih dari 1 menit'
                    ],
                    stepVisuals: ['🦵', '🤮', '👋', '<i class="fa-solid fa-shirt text-blue-400"></i>', '<i class="fa-solid fa-truck-medical text-red-500"></i>']
                }
            ]
        },

        afterTutorials:[
            {
                title:'Waspada Gempa Susulan',
                icon:'<i class="fa-solid fa-earth-asia text-blue-600"></i>',
                desc:'Periksa bangunan sebelum kembali masuk.'
            },
            {
                title:'Periksa Kebocoran Gas',
                icon:'<i class="fa-solid fa-fire text-red-500"></i>',
                desc:'Jangan nyalakan api sebelum aman.'
            },
            {
                title:'Cari Informasi Resmi',
                icon:'<i class="fa-solid fa-radio text-gray-700"></i>',
                desc:'Pantau BNPB dan BMKG.'
            }
        ],

        infoItems:[
            {
                title:'CPR Dasar',
                icon:'<i class="fa-solid fa-heart-pulse text-red-500"></i>',
                desc:'Cara bantuan napas darurat.',
                tools: [
                    { name: 'Tangan', icon: '<i class="fa-solid fa-hand text-yellow-300"></i>' }
                ],
                steps: [
                    { d: 'Langkah 1: Pastikan lingkungan aman dan cek kesadaran korban.', i: '<i class="fa-solid fa-head-side-cough text-blue-500"></i>' },
                    { d: 'Langkah 2: Lakukan 30 kompresi dada bagian tengah dengan cepat.', i: '<i class="fa-solid fa-heart-pulse text-red-500"></i>' },
                    { d: 'Langkah 3: Berikan 2 napas buatan, lalu ulangi siklus kompresi.', i: '😮‍💨' }
                ]
            },
            {
                title: 'Membalut Luka',
                icon: '<i class="fa-solid fa-bandage text-orange-300"></i>',
                desc:'Teknik balut dasar.',
                tools: [
                    { name: 'Kasa', icon: '<i class="fa-solid fa-compress text-gray-400"></i>' },
                    { name: 'Kain Bersih', icon: '<i class="fa-solid fa-shirt text-blue-400"></i>' }
                ],
                steps: [
                    { d: 'Langkah 1: Bersihkan area luka dengan air mengalir atau antiseptik.', i: '<i class="fa-solid fa-faucet-drip text-blue-400"></i>' },
                    { d: 'Langkah 2: Letakkan kasa steril tepat di atas luka terbuka.', i: '<i class="fa-solid fa-band-aid text-orange-300"></i>' },
                    { d: 'Langkah 3: Balut perlahan, pastikan tidak terlalu ketat.', i: '<i class="fa-solid fa-ribbon text-yellow-500"></i>' }
                ]
            },
            {
                title:'Patah Tulang',
                icon:'<i class="fa-solid fa-bone text-gray-300 drop-shadow-md"></i>',
                desc:'Cara imobilisasi.',
                tools: [
                    { name: 'Bidai / Kayu', icon: '<i class="fa-solid fa-tree text-amber-900"></i>' },
                    { name: 'Karton Tebal', icon: '<i class="fa-solid fa-box-open text-amber-600"></i>' },
                    { name: 'Bambu', icon: '<i class="fa-solid fa-seedling text-green-500"></i>' }
                ],
                steps: [
                    { d: 'Langkah 1: Tenangkan korban dan jangan mencoba meluruskan tulang.', i: '<i class="fa-solid fa-ban text-red-600"></i>' },
                    { d: 'Langkah 2: Siapkan bidai di sisi kiri dan kanan tulang yang patah.', i: '<i class="fa-solid fa-tree text-amber-900"></i>' },
                    { d: 'Langkah 3: Ikat bidai dengan kain secara menyilang, pastikan ikatan kuat.', i: '<i class="fa-solid fa-compress text-gray-400"></i>' }
                ]
            },
            {
                title:'Kain Penyangga Tangan',
                icon:'<i class="fa-solid fa-mitten text-red-400"></i>',
                desc:'Tutorial melipat penyangga lengan & bahu darurat.',
                tools: [
                    { name: 'Mitela', icon: '<i class="fa-solid fa-tape text-blue-400"></i>' },
                    { name: 'Syal / Jilbab', icon: '<i class="fa-solid fa-mitten text-red-400"></i>' },
                    { name: 'Kain Sarung', icon: '<i class="fa-solid fa-person-dress text-pink-400"></i>' }
                ],
                steps: [
                    { d: 'Langkah 1: Lipat kain membentuk segitiga.', i: '<i class="fa-solid fa-ruler-combined text-gray-500"></i>' },
                    { d: 'Langkah 2: Tekuk lengan sekitar 90 derajat dan posisikan telapak tangan sedikit lebih tinggi dari siku.', i: '<i class="fa-solid fa-dumbbell text-gray-600"></i>' },
                    { d: 'Langkah 3: Masukkan lengan ke kain hingga siku tertutup dan tangan berada di tengah.', i: '<i class="fa-solid fa-compress text-gray-400"></i>' },
                    { d: 'Langkah 4: Ikat dua ujung kain ke leher.', i: '<i class="fa-solid fa-compress text-gray-400"></i>' }
                ]
            }
        ],

        craftingItems:[
            {
                title:'Bidai Darurat',
                icon:'<i class="fa-solid fa-band-aid text-orange-300"></i>',
                materials:[
                    { name: 'Kayu Lurus', role: 'Penyangga', icon: '<i class="fa-solid fa-tree text-amber-900"></i>', swappable: true, options: [{n: 'Kayu Lurus', i: '<i class="fa-solid fa-tree text-amber-900"></i>'}, {n: 'Bambu', i: '<i class="fa-solid fa-seedling text-green-500"></i>'}, {n: 'Tongkat', i: '<i class="fa-solid fa-crutch text-gray-400"></i>'}, {n: 'Papan/Karton', i: '<i class="fa-solid fa-box-open text-amber-600"></i>'}] },
                    { name: 'Kain Baju', role: 'Pengikat', icon: '<i class="fa-solid fa-shirt text-blue-400"></i>', swappable: true, options: [{n: 'Kain Baju', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}, {n: 'Perban', i: '<i class="fa-solid fa-band-aid text-orange-300"></i>'}, {n: 'Tali', i: '<i class="fa-solid fa-tape text-blue-400"></i>'}, {n: 'Syal', i: '<i class="fa-solid fa-mitten text-red-400"></i>'}] },
                    { name: 'Kain Lembut', role: 'Bantalan Tambahan', icon: '<i class="fa-solid fa-socks text-orange-300"></i>', swappable: true, options: [{n: 'Kain Lembut', i: '<i class="fa-solid fa-socks text-orange-300"></i>'}, {n: 'Handuk', i: '<i class="fa-solid fa-bath text-blue-200"></i>'}, {n: 'Baju Lipat', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}, {n: 'Kapas', i: '<i class="fa-solid fa-cloud text-gray-300"></i>'}] }
                ],
                steps: [
                    { d: 'Periksa cedera, apakah terluka atau patah. JANGAN mencoba meluruskan bagian yang terlihat patah atau bengkok.', i: '<i class="fa-solid fa-ban text-red-600"></i>' },
                    { d: 'Siapkan 2 penyangga keras (kayu/bambu) yang panjangnya melewati persendian di atas dan di bawah area patah.', i: '<i class="fa-solid fa-tree text-amber-900"></i>' },
                    { d: 'Sisipkan bantalan (kain lembut/baju) di antara kulit dan penyangga keras agar tidak melukai kulit.', i: '<i class="fa-solid fa-shirt text-blue-400"></i>' },
                    { d: 'Tempatkan penyangga keras di sisi kiri dan kanan dari tulang yang patah.', i: '🦵' },
                    { d: 'Ikat penyangga HARUS di atas dan di bawah titik patah. JANGAN mengikat tepat di area patah.', i: '<i class="fa-solid fa-compress text-gray-400"></i>' },
                    { d: 'Ikat cukup erat agar stabil, tapi periksa sirkulasi ujung jari.', i: '<i class="fa-solid fa-hand text-yellow-300"></i>' }
                ]
            },
            {
                title:'Cairan Pembersih',
                icon:'<i class="fa-solid fa-flask text-purple-500"></i>',
                materials:[
                    { name: 'Air Mineral Segel', role: 'Cairan Steril', icon: '<i class="fa-solid fa-droplet text-blue-500"></i>', swappable: true, options: [{n: 'Air Botol Segel', i: '<i class="fa-solid fa-droplet text-blue-500"></i>'}, {n: 'Air Hujan Bersih', i: '<i class="fa-solid fa-cloud-showers-heavy text-blue-400"></i>'}, {n: 'Air Kelapa Muda', i: '<i class="fa-solid fa-bowling-ball text-amber-800"></i>'}] },
                    { name: 'Botol Plastik', role: 'Penyemprot', icon: '<i class="fa-solid fa-bottle-water text-blue-300"></i>', swappable: true, options: [{n: 'Botol Plastik', i: '<i class="fa-solid fa-bottle-water text-blue-300"></i>'}, {n: 'Plastik Kiloan', i: '<i class="fa-solid fa-bag-shopping text-pink-500"></i>'}] }
                ],
                steps: [
                    { d: 'Gunakan HANYA air mineral kemasan yang segelnya belum rusak. Jangan gunakan air genangan atau banjir.', i: '<i class="fa-solid fa-droplet text-blue-500"></i>' },
                    { d: 'Jika tidak ada, tadah air hujan bersih secara langsung menggunakan wadah.', i: '<i class="fa-solid fa-cloud-showers-heavy text-blue-400"></i>' },
                    { d: 'Dalam kondisi darurat di alam bebas, air kelapa muda bisa digunakan untuk membersihkan kotoran dari luka.', i: '<i class="fa-solid fa-bowling-ball text-amber-800"></i>' },
                    { d: 'Tuang air ke dalam botol plastik bersih, lalu lubangi kecil bagian tutupnya.', i: '<i class="fa-solid fa-bottle-water text-blue-300"></i>' },
                    { d: 'Semprotkan air dengan tekanan ke arah luka terbuka (flushing) agar kotoran/kerikil terdorong keluar. JANGAN menggosok luka.', i: '<i class="fa-solid fa-water text-teal-600"></i>' }
                ]
            },
            {
                title:'Perban Darurat',
                icon:'<i class="fa-solid fa-stethoscope text-gray-700"></i>',
                materials:[
                    { name: 'Pembalut Wanita', role: 'Penyerap Darah', icon: '<i class="fa-solid fa-droplet text-red-600"></i>', swappable: true, options: [{n: 'Pembalut Wanita', i: '<i class="fa-solid fa-droplet text-red-600"></i>'}, {n: 'Tampon', i: '<i class="fa-solid fa-droplet text-red-600"></i>'}, {n: 'Kain Katun Bersih', i: '<i class="fa-solid fa-shirt text-blue-400"></i>'}] },
                    { name: 'Baju Kaos Dalam', role: 'Kain Pengikat', icon: '<i class="fa-solid fa-shirt text-gray-300"></i>', swappable: true, options: [{n: 'Baju Kaos Dalam', i: '<i class="fa-solid fa-shirt text-gray-300"></i>'}, {n: 'Lakban (Duct Tape)', i: '<i class="fa-solid fa-tag text-gray-400"></i>'}, {n: 'Kain Panjang', i: '<i class="fa-solid fa-ribbon text-yellow-500"></i>'}] },
                    { name: 'Plastik Bersih', role: 'Pelindung (Opsional)', icon: '<i class="fa-solid fa-bag-shopping text-pink-500"></i>', swappable: true, options: [{n: 'Plastik Bersih', i: '<i class="fa-solid fa-bag-shopping text-pink-500"></i>'}, {n: 'Jas Hujan', i: '<i class="fa-solid fa-vest text-orange-500"></i>'}] }
                ],
                steps: [
                    { d: 'Gunakan pembalut wanita sebagai bantalan trauma (trauma pad) yang sangat efektif menyerap pendarahan berat.', i: '<i class="fa-solid fa-droplet text-red-600"></i>' },
                    { d: 'Tempelkan bagian dalam penyerap tepat pada luka. Jika luka tusuk dalam, tampon dapat digunakan perlahan untuk menyumbat pendarahan.', i: '<i class="fa-solid fa-band-aid text-orange-300"></i>' },
                    { d: 'Robek baju kaos dalam katun (yang tidak berlumpur) menjadi pita panjang sebagai pengikat bantalan.', i: '✂️' },
                    { d: 'Ikat dengan kencang tepat di atas bantalan pembalut untuk memberi tekanan (pressure) agar darah berhenti.', i: '<i class="fa-solid fa-compress text-gray-400"></i>' },
                    { d: 'Jika robekan kain kurang panjang, gunakan lakban/duct tape untuk menahan pembalut. Untuk luka dada tembus, gunakan plastik lalu lakban 3 sisinya.', i: '<i class="fa-solid fa-tag text-gray-400"></i>' }
                ]
            },
            {
                title:'Tandu Darurat',
                icon:'<i class="fa-solid fa-bed text-blue-400"></i>',
                materials:[
                    { name: 'Batang Pohon Tebal', role: 'Rangka Penyangga', icon: '<i class="fa-solid fa-tree text-amber-900"></i>', swappable: true, options: [{n: 'Batang Pohon', i: '<i class="fa-solid fa-tree text-amber-900"></i>'}, {n: 'Pipa Paralon', i: '<i class="fa-solid fa-crutch text-gray-400"></i>'}, {n: 'Pipa Besi Ringan', i: '<i class="fa-solid fa-screwdriver-wrench text-gray-500"></i>'}] },
                    { name: 'Jaket Tebal (2x)', role: 'Kain Penahan', icon: '<i class="fa-solid fa-vest text-orange-500"></i>', swappable: true, options: [{n: 'Jaket Tebal', i: '<i class="fa-solid fa-vest text-orange-500"></i>'}, {n: 'Sarung Kuat', i: '<i class="fa-solid fa-person-dress text-pink-400"></i>'}, {n: 'Terpal / Tenda', i: '<i class="fa-solid fa-tent text-green-600"></i>'}] }
                ],
                steps: [
                    { d: 'Cari DUA tiang penyangga yang lurus dan kokoh sepanjang minimal 2 meter (sesuaikan tinggi korban).', i: '<i class="fa-solid fa-tree text-amber-900"></i>' },
                    { d: 'Siapkan 2 atau 3 jaket tebal ber-resleting kuat, atau 2 kain sarung utuh.', i: '<i class="fa-solid fa-vest text-orange-500"></i>' },
                    { d: 'Metode Jaket: Balik bagian luar jaket ke dalam. Masukkan 2 tiang ke dalam kedua lengan jaket pertama, lalu resletingkan.', i: '🤐' },
                    { d: 'Ulangi langkah tersebut pada jaket kedua (dan ketiga) dengan posisi berhadapan agar area tubuh korban tertopang sempurna.', i: '🥼' },
                    { d: 'Metode Sarung: Masukkan kedua tiang melintasi lubang dua sarung secara sejajar.', i: '<i class="fa-solid fa-person-dress text-pink-400"></i>' },
                    { d: 'Tarik kain hingga tegang. Tiang akan mengunci lipatan kain saat diberi beban. Uji coba dengan tubuh sehat sebelum mengangkat korban terluka.', i: '🏋️' }
                ]
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
            kebakaran: [
                {title: "1. Tunggu Izin", desc: "Jangan masuk sebelum Damkar nyatakan aman."},
                {title: "2. Waspada Titik Api", desc: "Perhatikan bara yang mungkin masih menyala."},
                {title: "3. Cek Instalasi", desc: "Jangan nyalakan listrik yang rusak parah."},
                {title: "4. Dokumentasi", desc: "Foto barang rusak untuk klaim asuransi."},
                {title: "5. Buang Barang", desc: "Buang makanan/obat yang terpapar panas."}
            ],
            tsunami: [
                {title: "1. Tetap di Posko", desc: "Jangan kembali ke pantai sebelum info resmi."},
                {title: "2. Jauhi Reruntuhan", desc: "Hindari genangan air deras dan puing-puing."},
                {title: "3. Cek Keluarga", desc: "Cari kerabat menggunakan data posko pengungsian."},
                {title: "4. Air Konsumsi", desc: "Minum air kemasan, hindari air sumur kotor."},
                {title: "5. Bersihkan Luka", desc: "Cegah infeksi dari air laut yang terkontaminasi."}
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

        handleSwipe() {
            if (this.touchEndX < this.touchStartX - 50 && this.injuryStepIndex < this.modalData.steps.length - 1) this.injuryStepIndex++;
            if (this.touchEndX > this.touchStartX + 50 && this.injuryStepIndex > 0) this.injuryStepIndex--;
        },
        
        handleTouchEnd(){
            this.handleSwipe();
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
            this.modalData = item;
            this.currentInjuryType = 'info'; 
            this.injuryStepIndex = 0; // Mulai dari step awal
            this.currentToolIndex = 0
            this.modal = true;
        },

        openCraft(item){
            this.modalData = item;
            this.currentInjuryType = 'craft';
            this.currentView = 'selection';
            // Kloning material biar kalau di-switch, data aslinya nggak rusak
            this.craftingMaterials = JSON.parse(JSON.stringify(item.materials));
            this.injuryStepIndex = 0;
            this.modal = true;
        },

        switchMaterial(idx){
            let m = this.craftingMaterials[idx];
            if (!m.swappable) return;
            let curIdx = m.options.findIndex(o => o.n === m.name);
            let next = m.options[(curIdx + 1) % m.options.length];
            m.name = next.n;
            m.icon = next.i;
        },

        openSupply(type){
            if(type === 'minum'){
                window.location.href = '{{ route("netral") }}?openTutorial=filter-air';
            }else if(type === 'p3k'){
                this.openInfo(this.infoItems[1]); // Membalut Luka
            }else{
                this.openCraft(this.craftingItems[0]); // Bidai Darurat
            }
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