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

    {{-- Tailwind via CDN (ganti dengan Vite jika sudah setup) --}}
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
                        cream:   '#F5F2EC',
                        navy:    '#2C3E50',
                        'navy-dk': '#1a252f',
                        danger:  '#C0392B',
                        'danger-dk': '#96281B',
                        siaga:   '#E67E22',
                        safe:    '#27AE60',
                        warn:    '#F39C12',
                    },
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
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F2EC; }
        h1,h2,h3,h4,h5 { font-family: 'Sora', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F5F2EC; }
        ::-webkit-scrollbar-thumb { background: #C5BFB3; border-radius: 99px; }

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
        .nav-link.active { color: #E67E22 !important; }

        /* Image placeholder */
        .img-ph {
            background: #E8E4DC;
            border: 2px dashed #C5BFB3;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #A09890;
            font-size: 0.8rem;
            gap: 6px;
            border-radius: 12px;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen relative">

    {{-- ═══ NAVBAR ═══ --}}
    <nav class="sticky top-0 z-50 bg-navy shadow-lg" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('netral') }}" class="font-head font-extrabold text-xl text-white tracking-tight">
                Siaga<span class="text-siaga">Ind</span>
            </a>

            {{-- Desktop nav --}}
            <ul class="hidden md:flex items-center gap-1 list-none">
                <li>
                    <a href="{{ route('netral') }}"
                       class="nav-link px-4 py-2 rounded-full text-sm font-semibold text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('netral') ? 'active' : '' }}">
                        Netral
                    </a>
                </li>
                <li>
                    <a href="{{ route('sebelum') }}"
                       class="nav-link px-4 py-2 rounded-full text-sm font-semibold text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('sebelum') ? 'active' : '' }}">
                        Sebelum
                    </a>
                </li>
                <li>
                    <a href="{{ route('saat') }}"
                       class="nav-link px-4 py-2 rounded-full text-sm font-semibold text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('saat') ? 'active' : '' }}">
                        Saat
                    </a>
                </li>
                <li>
                    <a href="{{ route('sesudah') }}"
                       class="nav-link px-4 py-2 rounded-full text-sm font-semibold text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('sesudah') ? 'active' : '' }}">
                        Sesudah
                    </a>
                </li>
                <li class="ml-2">
                    <a href="#darurat"
                       class="px-4 py-2 rounded-full text-sm font-semibold bg-danger text-white hover:bg-danger-dk transition-all duration-200">
                        Darurat
                    </a>
                </li>
            </ul>

            {{-- Mobile hamburger --}}
            <button @click="open = !open" class="md:hidden text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition class="md:hidden bg-navy-dk px-4 pb-4 space-y-1">
            <a href="{{ route('netral') }}"   class="block px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 text-sm font-medium">Netral</a>
            <a href="{{ route('sebelum') }}"  class="block px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 text-sm font-medium">Sebelum</a>
            <a href="{{ route('saat') }}"     class="block px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 text-sm font-medium">Saat</a>
            <a href="{{ route('sesudah') }}"  class="block px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 text-sm font-medium">Sesudah</a>
            <a href="#darurat" class="block px-4 py-2 rounded-lg bg-danger text-white text-sm font-semibold">🚨 Darurat</a>
        </div>
    </nav>

    {{-- ═══ KONTEN ═══ --}}
    <main class="relative z-10">
        @yield('content')
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="bg-navy text-white/60 text-sm py-6 text-center relative z-10 mt-16">
        <p class="font-head font-bold text-white mb-1">Siaga<span class="text-siaga">Ind</span></p>
        <p>Platform Kesiapsiagaan Bencana untuk Masyarakat Indonesia</p>
    </footer>

    {{-- GSAP init --}}
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Reveal on scroll
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