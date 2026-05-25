<!DOCTYPE html>
<html lang="id" x-data>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'SiagaInd') — Siap Sebelum Terjadi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        /* ══════════════════════════════════════════════════
            DESIGN TOKENS — ubah di sini saja
        ══════════════════════════════════════════════════ */
        :root {
            /* Palette: Netral & Sebelum : colorhunt.co/palette/5a827e84ae92b9d4aafaffca */
            --c-teal:       #5A827E;
            --c-teal-light: #84AE92;
            --c-sage:       #B9D4AA;
            --c-cream:      #FAFFCA;

            /* Turunan */
            --c-teal-dk:    #3d5c59;
            --c-teal-xdk:   #273d3b;
            --c-sage-lt:    #d4e6c9;
            --c-cream-dk:   #e8edae;

            /* Palette: Saat */
            --c-dark-red:   #7D0A0A;
            --c-red:        #BF3131;
            --c-beige:      #EAD196;
            --c-light:      #EEEEEE;

            /* Turunan */
            --c-dark-red-dk:#580707;
            --c-red-light:  #d85a5a;
            --c-beige-dk:   #d6bc7d;
            --c-light-dk:   #dcdcdc;

            /* Semantik */
            --color-bg:           #f4f8f0;
            --color-surface:      #ffffff;
            --color-surface-2:    #f0f5ec;
            --color-border:       rgba(90,130,126,0.18);
            --color-border-md:    rgba(90,130,126,0.32);

            --color-text-primary:   #273d3b;
            --color-text-secondary: rgba(61,92,89,0.65);
            --color-text-muted:     rgba(61,92,89,0.4);

            --color-accent:    #5A827E;
            --color-accent-dk: #3d5c59;
            --color-accent-lt: #d4e6c9;

            --color-danger:    #C0392B;
            --color-danger-lt: #fdecea;
            --color-danger-dk: #96281B;

            /* Layout */
            --r-sm:   8px;
            --r-md:   14px;
            --r-lg:   22px;
            --r-xl:   32px;
            --r-pill: 999px;

            --t-fast: 0.2s ease;
            --t-med:  0.35s ease;

            --shadow-sm: 0 2px 8px rgba(61,92,89,0.08);
            --shadow-md: 0 8px 28px rgba(61,92,89,0.12);
            --shadow-lg: 0 16px 48px rgba(61,92,89,0.16);

            /* ════ Z-INDEX SCALE ════ Centralized Stacking */
            --z-base:    1;
            --z-sticky:  10;
            --z-navbar:  40;      
            --z-modal:   9000;    
            --z-toast:   9500;
        }

        /* ══════ BASE ══════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            line-height: 1.7;
            background: var(--color-bg);
            color: var(--color-text-primary);
            min-height: 100vh;
        }
        body.modal-open { overflow: hidden; }

        h1,h2,h3,h4,h5 { font-family: 'Sora', sans-serif; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--color-surface-2); }
        ::-webkit-scrollbar-thumb { background: var(--c-sage); border-radius: var(--r-pill); }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .reveal { opacity: 0; transform: translateY(24px); }
        [x-cloak] { display: none !important; }

        /* ══════════════════════════════════════════════════
            NAVBAR (Style 3: Transparan & Blur Permanen)
        ══════════════════════════════════════════════════ */
        .main-navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: var(--z-navbar);
            transition: all 0.5s ease;
        }

        .nav-bar-inner {
            position: relative;
            border-radius: var(--r-pill);
            transition: all 0.5s ease;
            background: var(--c-sage-lt) !important;
            border: 1px solid var(--c-sage) !important;
            box-shadow: 0 8px 32px rgba(90, 130, 126, 0.1) !important;
        }

        /* Pseudo-element blur agar tidak merusak stacking context modal */
        .nav-bar-inner::before {
            content: '';
            position: absolute; inset: 0;
            border-radius: inherit;
            backdrop-filter: blur(8px) saturate(120%);
            -webkit-backdrop-filter: blur(8px) saturate(120%);
            z-index: 0;
            pointer-events: none;
        }

        .nav-bar-inner > * { position: relative; z-index: 1; }

        /* Nav pills dengan dark text untuk kontras di bg sage-lt */
        .nav-pill {
            padding: 10px 20px;
            border-radius: var(--r-pill);
            font-size: 14px;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            color: var(--c-teal-dk) !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all var(--t-fast);
        }
        .nav-pill:hover { background: rgba(90, 130, 126, 0.15); color: var(--c-teal) !important; }
        .nav-pill.active-nav { background: var(--c-teal) !important; color: white !important; }

        .mobile-nav {
            height: 48px; border-radius: var(--r-md);
            padding-inline: 18px;
            display: flex; align-items: center;
            font-size: 14px; font-weight: 600;
            font-family: 'Sora', sans-serif;
            color: var(--c-teal);
            text-decoration: none;
            transition: all var(--t-fast);
        }
        .mobile-nav:hover { background: var(--c-sage-lt); }

        /* ══════════════════════════════════════════════════
            MODAL SYSTEM (Updated: Kunci Tinggi & Responsive)
        ══════════════════════════════════════════════════ */
        .modal-overlay {
            position: fixed !important;
            inset: 0 !important;
            z-index: var(--z-modal) !important;  
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-backdrop {
            position: absolute; inset: 0;
            background: rgba(39,61,59,0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .modal-box {
            position: relative;
            z-index: 1;  
            width: 100%;
            max-width: 560px;
            height: 85vh; /* Mengunci tinggi agar semua modal seragam lebih tinggi */
            max-height: 90vh;
            overflow-y: auto;
            background: var(--color-surface);
            border: 1px solid var(--color-border-md);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow-lg);
            transform: translateY(16px);
            transition: transform var(--t-med);
        }
        
        /* Utilitas untuk modal yang butuh ruang lebih lebar (seperti grid 2 kolom) */
        .modal-box-lg { 
            max-width: 680px; 
        }

        .modal-overlay.open .modal-box { transform: translateY(0); }
        .modal-overlay[x-show].open .modal-box { transform: translateY(0); }

        .modal-header {
            padding: 22px 26px 18px;
            border-bottom: 1px solid var(--color-border);
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0;
            z-index: 10; /* Menjaga header tetap di atas konten saat di-scroll */
            background: var(--color-surface);
            border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
        .modal-title {
            font-family: 'Sora', sans-serif;
            font-size: 18px; font-weight: 700;
            color: var(--color-text-primary);
        }
        .modal-close {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--color-surface-2); border: none;
            cursor: pointer; color: var(--color-text-secondary);
            font-size: 15px;
            display: flex; align-items: center; justify-content: center;
            transition: all var(--t-fast);
        }
        .modal-close:hover { background: var(--color-border); color: var(--color-danger); }
        .modal-body { padding: 24px 26px; }

        /* ══════ SHARED COMPONENTS ══════ */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 24px; height: 48px;
            border-radius: var(--r-pill);
            font-family: 'Sora', sans-serif;
            font-size: 14px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: all var(--t-fast); border: none;
        }
        .btn-primary {
            background: var(--c-teal); color: white;
            box-shadow: 0 4px 18px rgba(90,130,126,0.3);
        }
        .btn-primary:hover { background: var(--c-teal-dk); transform: translateY(-1px); }
        .btn-outline {
            background: transparent; color: var(--c-teal);
            border: 1.5px solid var(--color-border-md);
        }
        .btn-outline:hover { background: var(--color-accent-lt); border-color: var(--c-teal); }
        .btn-danger {
            background: var(--color-danger); color: white;
            box-shadow: 0 4px 18px rgba(192,57,43,0.3);
        }
        .btn-danger:hover { background: var(--color-danger-dk); transform: translateY(-1px); }

        .section-tag {
            display: inline-block;
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.22em; text-transform: uppercase;
            color: var(--c-teal); background: var(--c-sage-lt);
            padding: 5px 14px; border-radius: var(--r-pill);
            margin-bottom: 14px;
        }
        .section-title {
            font-family: 'Sora', sans-serif;
            font-weight: 800; color: var(--color-text-primary); line-height: 1.15;
        }
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--r-lg); padding: 24px;
            transition: all var(--t-med);
        }
        .card:hover {
            border-color: var(--color-border-md);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .divider { height: 1px; background: var(--color-border); margin: 2rem 0; }

        /* ══════════════════════════════════════════════════
            FOOTER (Style 1: Illustrated / Light Theme)
        ══════════════════════════════════════════════════ */
        .footer-title {
            font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700;
            color: var(--c-teal-xdk); margin-bottom: 20px;
        }
        .footer-links { display: flex; flex-direction: column; gap: 13px; }
        .footer-links a {
            color: var(--color-text-secondary); font-size: 14px;
            text-decoration: none; transition: all var(--t-fast);
        }
        .footer-links a:hover { color: var(--c-teal); transform: translateX(4px); }
        .footer-social {
            width: 40px; height: 40px; border-radius: var(--r-md);
            background: rgba(90,130,126,0.08); color: var(--c-teal);
            display: flex; align-items: center; justify-content: center;
            border: none; cursor: pointer; font-size: 16px;
            transition: all var(--t-med);
        }
        .footer-social:hover { transform: translateY(-4px); background: var(--c-teal); color: white; }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen relative">

{{-- ══════════════════════════════════════════════════
     NAVBAR (Style 3 - Transparent Header)
══════════════════════════════════════════════════ --}}
<nav class="main-navbar" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-5">

        <div class="nav-bar-inner">
            <div class="h-16 px-4 lg:px-6 flex items-center justify-between">

                {{-- Logo --}}
                <a href="{{ route('netral') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl overflow-hidden"
                         style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);">
                        <img src="{{ asset('images/logo-siagaind.png') }}" class="w-full h-full object-cover" alt="SiagaInd">
                    </div>
                    <div>
                        <div class="font-head font-extrabold text-xl leading-none text-white">
                            SiagaInd
                        </div>
                        <div class="text-[10px] tracking-[0.22em] uppercase text-white/70 mt-1">
                            Disaster Preparedness
                        </div>
                    </div>
                </a>

                {{-- Desktop menu --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('netral') }}"   class="nav-pill {{ request()->routeIs('netral')   ? 'active-nav' : '' }}">Netral</a>
                    <a href="{{ route('sebelum') }}"  class="nav-pill {{ request()->routeIs('sebelum')  ? 'active-nav' : '' }}">Sebelum</a>
                    <a href="{{ route('saat') }}"     class="nav-pill {{ request()->routeIs('saat*')    ? 'active-nav' : '' }}">Saat</a>
                    <a href="{{ route('sesudah') }}"  class="nav-pill {{ request()->routeIs('sesudah*') ? 'active-nav' : '' }}">Sesudah</a>
                </div>

                {{-- Right CTA --}}
                <div class="hidden lg:flex items-center gap-3">
                    
                    <a href="{{ route('netral') }}#darurat" class="btn btn-primary" style="height:44px; font-size:13px; background: var(--c-teal);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                        </svg>
                        Hubungi
                    </a>
                </div>

                {{-- Mobile toggle --}}
                <button @click="open = !open"
                        class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center"
                        style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.25); color: white;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile dropdown --}}
        <div x-show="open" x-transition
             class="lg:hidden mt-3 p-4 flex flex-col gap-2"
             style="border-radius: var(--r-xl); background: rgba(255,255,255,0.96); border: 1px solid var(--color-border); box-shadow: var(--shadow-lg); display: none;">
            <a href="{{ route('netral') }}"  class="mobile-nav">Beranda</a>
            <a href="{{ route('sebelum') }}" class="mobile-nav">Sebelum</a>
            <a href="{{ route('saat') }}"     class="mobile-nav">Saat</a>
            <a href="{{ route('sesudah') }}" class="mobile-nav">Sesudah</a>
            <a href="{{ route('saat') }}" class="btn btn-primary mt-2" style="height:48px; border-radius: var(--r-lg); justify-content: center; background: var(--c-teal);">
                Mode Darurat
            </a>
        </div>
    </div>
</nav>

{{-- ══════ KONTEN ══════ --}}
<main class="relative" style="z-index: var(--z-base);">
    @yield('content')
</main>

{{-- ══════════════════════════════════════════════════
     FOOTER (Style 1 - Illustrated Light Theme)
     PERBAIKAN: Sisi atas berbentuk OVAL TINGGI & ELEGAN sesuai mockup
══════════════════════════════════════════════════ --}}
<footer class="relative mt-24 w-full" style="z-index: var(--z-base);">
    
    <div class="relative overflow-hidden flex flex-col justify-between min-h-[460px] w-full pt-16 pb-0"
         style="background: #1e252b; 
                border-top: 1px solid rgba(255,255,255,0.15);">

        <div class="absolute inset-0 w-full h-full pointer-events-none z-0">
            <img src="{{ asset('images/Footer_bg.png') }}" alt="Footer Background" class="w-full h-full object-cover object-bottom block opacity-40">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-[1.2fr_2fr] gap-12 px-6 sm:px-8 lg:px-12 pb-12 text-white">

            <div class="flex flex-col gap-4 items-start w-full">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm bg-white border border-white/20 flex-shrink-0">
                        <img src="{{ asset('images/logo-siagaind.png') }}" class="w-full h-full object-cover" alt="Logo SiagaInd">
                    </div>
                    <div>
                        <div class="text-2xl font-head font-extrabold tracking-tight text-white leading-tight">SiagaInd</div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-white/70">Siap sebelum terjadi</div>
                    </div>
                </div>
                <p class="leading-relaxed max-w-sm text-[14px] text-white/90 font-medium">
                    Platform edukasi kesiapsiagaan bencana dengan visual interaktif, tutorial survival, caregiver, dan panduan kondisi darurat.
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-white/10 text-white hover:bg-white/20 active:scale-95 text-base"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-white/10 text-white hover:bg-white/20 active:scale-95 text-base"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-white/10 text-white hover:bg-white/20 active:scale-95 text-base"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all bg-white/10 text-white hover:bg-white/20 active:scale-95 text-base"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 sm:gap-8 w-full">
                
                <div>
                    <div class="text-white font-bold text-base sm:text-lg mb-3 tracking-wide relative after:content-[''] after:block after:w-8 after:h-0.5 after:bg-white/30 after:mt-1">Navigasi</div>
                    <div class="flex flex-col gap-2 text-[13px] sm:text-[14px]">
                        <a href="{{ route('netral') }}" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Beranda</a>
                        <a href="{{ route('sebelum') }}" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Mitigasi</a>
                        <a href="{{ route('saat') }}" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Darurat</a>
                        <a href="{{ route('sesudah') }}" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Recovery</a>
                    </div>
                </div>

                <div>
                    <div class="text-white font-bold text-base sm:text-lg mb-3 tracking-wide relative after:content-[''] after:block after:w-8 after:h-0.5 after:bg-white/30 after:mt-1">Bantuan</div>
                    <div class="flex flex-col gap-2 text-[13px] sm:text-[14px]">
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">FAQ</a>
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Kontak</a>
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Panduan</a>
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Darurat</a>
                    </div>
                </div>

                <div>
                    <div class="text-white font-bold text-base sm:text-lg mb-3 tracking-wide relative after:content-[''] after:block after:w-8 after:h-0.5 after:bg-white/30 after:mt-1">Lainnya</div>
                    <div class="flex flex-col gap-2 text-[13px] sm:text-[14px]">
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Tentang Kami</a>
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Kebijakan Privasi</a>
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Syarat & Ketentuan</a>
                        <a href="#" class="text-white/80 hover:text-white font-medium transition-colors w-max block">Peta Situs</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="relative z-10 w-full border-t border-white/10" style="background: rgba(0, 0, 0, 0.3);">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="text-xs font-semibold text-white/80 tracking-wide">
                    © 2026 SiagaInd. All rights reserved. <span class="opacity-60 block sm:inline sm:ml-1">| Made for TECHNOVA 1.0</span>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-4 text-xs font-semibold text-white/80">
                    <a href="#" class="hover:underline hover:text-white transition-all">Privacy</a>
                    <span class="w-1 h-1 rounded-full bg-current opacity-40 hidden sm:inline-block"></span>
                    <a href="#" class="hover:underline hover:text-white transition-all">Terms</a>
                    <span class="w-1 h-1 rounded-full bg-current opacity-40 hidden sm:inline-block"></span>
                    <a href="#" class="hover:underline hover:text-white transition-all">Contact</a>
                </div>
            </div>
        </div>

    </div>
</footer>

{{-- ══════════════════════════════════════════════════
     MODAL PORTAL
══════════════════════════════════════════════════ --}}
@stack('modals')

<script>
    gsap.registerPlugin(ScrollTrigger);
    document.addEventListener('DOMContentLoaded', () => {
        gsap.utils.toArray('.reveal').forEach(el => {
            gsap.to(el, {
                opacity: 1, y: 0, duration: 0.7, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 88%' }
            });
        });
    });
</script>

@stack('scripts')
</body>
</html>