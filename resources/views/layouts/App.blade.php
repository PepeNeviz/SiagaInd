<!DOCTYPE html>
<html lang="id" x-data>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'SiagaInd') — Siap Sebelum Terjadi</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet" />

    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        head: ['Sora', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        // Integrasi Palet Warna Baru ke Utility Class Tailwind
                        'deep-sage': 'var(--color-deep-sage)',
                        'emerald-sage': 'var(--color-emerald-sage)',
                        'mint-pale': 'var(--color-mint-pale)',
                        'sunset-cream': 'var(--color-sunset-cream)',
                        
                        // Status default warna SiagaInd
                        danger: '#C0392B',
                        'danger-dk': '#96281B',
                        siaga: '#E67E22',
                        safe: '#27AE60',
                        warn: '#F39C12',
                        check: 'red'
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- GSAP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <style>
        /* Variabel Root Warna by color pallete */
        :root {
            --color-deep-sage: #5A827E;
            --color-emerald-sage: #84AE92;
            --color-mint-pale: #B9D4AA;
            --color-sunset-cream: #FAFFCA;
            
            --color-bg-base: #F5F2EC;
            --color-scroll-thumb: #C5BFB3;
        }

        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--color-bg-base); }
        h1, h2, h3, h4, h5 { font-family: 'Sora', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--color-bg-base); }
        ::-webkit-scrollbar-thumb { background: var(--color-scroll-thumb); border-radius: 99px; }

        /* Animasi masuk */
        .reveal { opacity: 0; transform: translateY(28px); }

        /* Noise texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Active nav */
        .nav-link.active { color: var(--color-deep-sage) !important; }

        /* Image placeholder */
        .img-ph {
            background: #E8E4DC;
            border: 2px dashed var(--color-scroll-thumb);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #A09890;
            font-size: 0.8rem;
            gap: 6px;
            border-radius: 12px;
        }

        /* Navbar Styling */
        .nav-pill {
            position: relative;
            padding: 12px 22px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            transition: all .3s ease;
        }

        .nav-pill:hover {
            background: rgba(255, 255, 255, 0.15);
            color: var(--color-sunset-cream);
        }

        .active-nav {
            background: var(--color-sunset-cream);
            color: var(--color-deep-sage) !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        nav[x-data] .scrolled .nav-pill {
            color: var(--color-deep-sage);
        }
        
        nav[x-data] .scrolled .nav-pill:hover {
            background: rgba(90, 130, 126, 0.1);
            color: var(--color-deep-sage);
        }

        nav[x-data] .scrolled .active-nav {
            background: var(--color-deep-sage);
            color: var(--color-sunset-cream) !important;
        }

        .mobile-nav {
            height: 48px;
            border-radius: 18px;
            padding-inline: 18px;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--color-deep-sage);
            transition: all .25s ease;
        }

        .mobile-nav:hover {
            background: var(--color-mint-pale);
            color: var(--color-deep-sage);
        }

        /* Footer Styling */
        .footer-title {
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--color-deep-sage);
            margin-bottom: 22px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .footer-links a {
            color: var(--color-deep-sage);
            font-size: 15px;
            transition: all .25s ease;
            opacity: 0.88;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--color-deep-sage);
            transform: translateX(4px);
        }

        .footer-social {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: white;
            color: var(--color-deep-sage);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
            transition: all .3s ease;
        }

        .footer-social:hover {
            transform: translateY(-4px);
            background: var(--color-deep-sage);
            color: var(--color-sunset-cream);
        }

            /* FIX MODAL SELALU DI ATAS */
    [x-cloak] {
        display: none !important;
    }

    body.modal-open {
        overflow: hidden;
    }

    /* pastikan navbar kalah */
    nav {
        z-index: 30 !important;
    }

    /* modal super front */
    .modal-superfront {
    position: fixed !important;
    inset: 0 !important;
    z-index: 99999 !important; /* Menaikkan tumpukan ke tingkat tertinggi */
    display: flex !important;
    align-items: center;
    justify-content: center;
    }

    /* cegah elemen blur bikin nembus */
    .modal-superfront * {
        transform-style: flat !important;
    }

    </style>

    @stack('styles')
</head>

<body class="min-h-screen relative">

    {{-- NAVBAR — TRANSPARENT FLOATING --}}
    <nav
    x-data="{ open: false, scrolled: false }"
    x-init="
        window.addEventListener('scroll', () => {
            scrolled = window.scrollY > 40
        })
    "
    class="fixed top-0 left-0 w-full z-30 transition-all duration-500"
    >

        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-5">
            <div
        :class="scrolled
            ? 'bg-[var(--color-deep-sage)]/40 backdrop-blur-xl border border-white/10 shadow-[0_10px_40px_rgba(0,0,0,0.12)] scrolled'
            : 'bg-[var(--color-deep-sage)]/80 backdrop-blur-md border border-white/20'"
        class="rounded-full transition-all duration-500"
        >

                <div class="h-[64px] px-4 lg:px-6 flex items-center justify-between">

                    {{-- LOGO --}}
                    <a href="{{ route('netral') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-2xl overflow-hidden bg-[var(--color-mint-pale)] border border-white/30 shadow-inner">
                            <img src="{{ asset('images/logo-siagaind.png') }}" class="w-full h-full object-cover" alt="SiagaInd Logo" />
                        </div>

                        <div>
                            <h1 :class="scrolled ? 'text-[var(--color-deep-sage)]' : 'text-[var(--color-sunset-cream)]'" class="font-head font-extrabold text-2xl tracking-tight transition-all duration-300">
                                SiagaInd
                            </h1>
                            <p :class="scrolled ? 'text-[var(--color-emerald-sage)]' : 'text-white/70'" class="text-[10px] tracking-[0.25em] uppercase transition-all duration-300">
                                Disaster Preparedness
                            </p>
                        </div>
                    </a>

                    {{-- MENU --}}
                    <div class="hidden lg:flex items-center gap-2">
                        <a href="{{ route('netral') }}" class="nav-pill active-nav">Beranda</a>
                        <a href="{{ route('sebelum') }}" class="nav-pill">Sebelum</a>
                        <a href="{{ route('saat') }}" class="nav-pill">Saat</a>
                        <a href="{{ route('sesudah') }}" class="nav-pill">Sesudah</a>
                        <a href="#darurat" class="nav-pill">Bantuan</a>
                    </div>

                    {{-- RIGHT ACTION --}}
                    <div class="hidden lg:flex items-center gap-3">
                        {{-- SEARCH --}}
                        <button class="w-12 h-12 rounded-full bg-white/75 backdrop-blur-md border border-white/40 flex items-center justify-center hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 text-[var(--color-deep-sage)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>

                        {{-- DARURAT --}}
                        <a href="{{ route('saat') }}" class="group relative overflow-hidden rounded-full">
                            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                            <div class="relative px-7 h-12 bg-[var(--color-deep-sage)] text-[var(--color-sunset-cream)] flex items-center gap-3 font-semibold shadow-lg shadow-[var(--color-deep-sage)]/30 hover:scale-[1.03] transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                                </svg>
                                Darurat
                            </div>
                        </a>
                    </div>

                    {{-- MOBILE BUTTON --}}
                    <button @click="open = !open" class="lg:hidden w-11 h-11 rounded-full bg-white/20 backdrop-blur-md border border-white/20 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- MOBILE MENU --}}
            <div x-show="open" x-transition class="lg:hidden mt-3 rounded-3xl bg-white/95 backdrop-blur-xl border border-[var(--color-mint-pale)] p-4 shadow-xl" style="display:none">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('netral') }}" class="mobile-nav">Beranda</a>
                    <a href="{{ route('sebelum') }}" class="mobile-nav">Sebelum</a>
                    <a href="{{ route('saat') }}" class="mobile-nav">Saat</a>
                    <a href="{{ route('sesudah') }}" class="mobile-nav">Sesudah</a>
                    <a href="#darurat" class="mt-2 h-12 rounded-2xl bg-[var(--color-deep-sage)] text-[var(--color-sunset-cream)] font-semibold flex items-center justify-center">
                        Mode Darurat
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="relative z-10">
        @yield('content')
    </main>

    {{-- FOOTER — ILLUSTRATED STYLE --}}
    <footer class="relative mt-28 px-4 sm:px-6 pb-6 z-0">
    <div class="max-w-7xl mx-auto">

        <div class="relative overflow-hidden rounded-[42px_42px_0_0] bg-[var(--color-sunset-cream)] border border-[var(--color-mint-pale)]">

            {{-- BACKGROUND --}}
            <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
                <img
                    src="{{ asset('images/Footer_bg.jpg') }}"
                    alt="Footer Background"
                    class="w-full h-full object-cover opacity-100"
                >
            </div>

            {{-- CONTENT --}}
            <div class="relative z-10 grid lg:grid-cols-[1.2fr_0.7fr_0.7fr_0.7fr] gap-10 p-8 lg:p-12 min-h-[420px]">

                {{-- LEFT --}}
                <div class="flex flex-col justify-between">
                    <div>

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-white shadow-md">
                                <img
                                    src="{{ asset('images/logo-siagaind.png') }}"
                                    class="w-full h-full object-cover"
                                    alt="SiagaInd Logo"
                                />
                            </div>

                            <div>
                                <h2 class="font-head text-3xl font-extrabold text-[var(--color-deep-sage)]">
                                    SiagaInd
                                </h2>

                                <p class="text-[var(--color-emerald-sage)] text-sm font-semibold">
                                    Siap sebelum terjadi
                                </p>
                            </div>
                        </div>

                        <p class="text-[var(--color-deep-sage)] leading-relaxed max-w-sm text-[15px]">
                            Platform edukasi kesiapsiagaan bencana dengan visual interaktif,
                            tutorial survival, caregiver, dan panduan kondisi darurat.
                        </p>

                        {{-- SOCIAL --}}
                        <div class="flex items-center gap-3 mt-7">
                            <button class="footer-social"><i class="fa-brands fa-instagram"></i></button>
                            <button class="footer-social"><i class="fa-brands fa-twitter"></i></button>
                            <button class="footer-social"><i class="fa-brands fa-youtube"></i></button>
                            <button class="footer-social"><i class="fa-brands fa-github"></i></button>
                        </div>

                    </div>
                </div>

                {{-- NAV --}}
                <div>
                    <h3 class="footer-title">Navigasi</h3>

                    <div class="footer-links">
                        <a href="{{ route('netral') }}">Beranda</a>
                        <a href="{{ route('sebelum') }}">Mitigasi</a>
                        <a href="{{ route('saat') }}">Darurat</a>
                        <a href="{{ route('sesudah') }}">Recovery</a>
                    </div>
                </div>

                {{-- HELP --}}
                <div>
                    <h3 class="footer-title">Bantuan</h3>

                    <div class="footer-links">
                        <a href="#">FAQ</a>
                        <a href="#">Kontak</a>
                        <a href="#">Panduan</a>
                        <a href="#">Darurat</a>
                    </div>
                </div>

                {{-- OTHER --}}
                <div>
                    <h3 class="footer-title">Lainnya</h3>

                    <div class="footer-links">
                        <a href="#">Tentang</a>
                        <a href="#">Privasi</a>
                        <a href="#">Syarat</a>
                    </div>
                </div>
            </div>

            {{-- BOTTOM --}}
            <div class="relative z-10 border-t border-[var(--color-emerald-sage)]/20">

                <div class="min-h-[64px] flex flex-col lg:flex-row items-center justify-between px-6 lg:px-12 py-4">

                    {{-- COPYRIGHT --}}
                    <div class="text-[var(--color-deep-sage)] text-xs font-medium tracking-wide">
                        © 2026 SiagaInd. All rights reserved.
                    </div>

                    {{-- LINKS --}}
                    <div class="flex items-center gap-4 mt-3 lg:mt-0 text-xs text-[var(--color-deep-sage)] font-medium">

                        <a href="#" class="hover:underline">
                            Privacy
                        </a>

                        <div class="w-1 h-1 rounded-full bg-[var(--color-emerald-sage)]"></div>

                        <a href="#" class="hover:underline">
                            Terms
                        </a>

                        <div class="w-1 h-1 rounded-full bg-[var(--color-emerald-sage)]"></div>

                        <a href="#" class="hover:underline">
                            Contact
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    {{-- GSAP INITIALIZATION --}}
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Reveal animations on scroll
        document.addEventListener('DOMContentLoaded', () => {
            gsap.utils.toArray('.reveal').forEach(el => {
                gsap.to(el, {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 88%',
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>