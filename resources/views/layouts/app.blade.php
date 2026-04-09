<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $__siteName = \App\Models\Setting::get('site_name', 'Corex-Dev');
        $__siteDesc = \App\Models\Setting::get('site_description', 'Tu portal de noticias, guías, reseñas y eventos gaming.');
        $__siteKw   = \App\Models\Setting::get('site_keywords', '');
        $__tw       = \App\Models\Setting::get('social_twitter', '');
        $__dc       = \App\Models\Setting::get('social_discord', '');
        $__yt       = \App\Models\Setting::get('social_youtube', '');
    @endphp
    <title>@yield('title', $__siteName . __('ui.title_suffix'))</title>
    <meta name="description" content="@yield('description', $__siteDesc)">
    @if($__siteKw)
    <meta name="keywords" content="{{ $__siteKw }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: dark;
            --cx-red:    #e8392a;
            --cx-red2:   #c42d1f;
            --cx-amber:  #f59e0b;
            --cx-blue:   #3b9edd;
            --cx-bg:     #0b0d11;
            --cx-surf:   #111419;
            --cx-card:   #161b23;
            --cx-border: #21293a;
            --cx-muted:  #4b5568;
        }
        body {
            background-color: var(--cx-bg);
            color: #d1d8e4;
            font-family: 'Inter', sans-serif;
        }

        /* ── Top accent bar ─────────────────────── */
        .top-accent-bar {
            background: linear-gradient(90deg, var(--cx-red), #ff6b35, var(--cx-red));
            background-size: 200% 100%;
            animation: shiftGrad 6s ease infinite;
        }
        @keyframes shiftGrad { 0%,100%{background-position:0%} 50%{background-position:100%} }

        /* ── Navbar ─────────────────────────────── */
        .cx-navbar { background: rgba(11,13,17,.97); box-shadow: 0 1px 0 var(--cx-border), 0 4px 24px rgba(0,0,0,.7); }
        .nav-active {
            color: #fff !important;
        }
        .nav-active::after {
            content: ''; position: absolute; bottom: -1px; left: 8px; right: 8px;
            height: 2px; background: var(--cx-red); border-radius: 999px;
        }
        .nav-item {
            position: relative;
            padding: 6px 12px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #8899aa;
            transition: color .15s;
        }
        .nav-item:hover { color: #fff; }

        /* ── Section headers ─────────────────────── */
        .cx-section-title {
            display: flex; align-items: center; gap: 10px;
            font-size: .68rem; font-weight: 800; letter-spacing: .14em;
            text-transform: uppercase; color: var(--cx-red);
        }
        .cx-section-title::before {
            content: ''; display: block; width: 3px; height: 18px;
            background: var(--cx-red); border-radius: 2px; flex-shrink: 0;
        }

        /* ── Cards ──────────────────────────────── */
        .cx-card {
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 8px;
            transition: border-color .2s, transform .2s, box-shadow .2s;
        }
        .cx-card:hover {
            border-color: rgba(232,57,42,.4);
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0,0,0,.4);
        }

        /* ── Hero ───────────────────────────────── */
        .hero-overlay { background: linear-gradient(to right, rgba(11,13,17,.98) 0%, rgba(11,13,17,.75) 45%, rgba(11,13,17,.2) 100%); }
        .hero-overlay-bottom { background: linear-gradient(to top, rgba(11,13,17,.95) 0%, transparent 50%); }

        /* ── Badge / label ───────────────────────── */
        .cx-badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px; font-size: .65rem; font-weight: 800;
            letter-spacing: .1em; text-transform: uppercase; border-radius: 3px;
        }
        .cx-badge-red   { background: var(--cx-red);   color: #fff; }
        .cx-badge-live  { background: #22c55e; color: #fff; animation: badgePulse 2s infinite; }
        @keyframes badgePulse { 0%,100%{opacity:1} 50%{opacity:.7} }

        /* ── Score ──────────────────────────────── */
        .cx-score {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: .85rem;
            border: 2px solid var(--cx-amber);
            color: var(--cx-amber);
            background: rgba(245,158,11,.1);
        }
        .cx-score.high { border-color: #22c55e; color: #22c55e; background: rgba(34,197,94,.1); }
        .cx-score.low  { border-color: var(--cx-red); color: var(--cx-red); background: rgba(232,57,42,.1); }

        /* ── Scrollbar ──────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--cx-bg); }
        ::-webkit-scrollbar-thumb { background: #21293a; border-radius: 9px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(232,57,42,.4); }

        /* ── Grid bg texture ─────────────────────── */
        .cx-grid-bg {
            background-image:
                linear-gradient(rgba(232,57,42,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(232,57,42,.025) 1px, transparent 1px);
            background-size: 36px 36px;
        }

        /* ── Toast ──────────────────────────────── */
        @keyframes toastIn { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
        .toast-anim { animation: toastIn .25s ease forwards; }

        /* ── Ticker ─────────────────────────────── */
        @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .ticker-track { animation: ticker 40s linear infinite; }
        .ticker-wrap { overflow: hidden; }
        .ticker-wrap:hover .ticker-track { animation-play-state: paused; }

        /* ── Category pill ───────────────────────── */
        .cat-pill {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 3px;
            font-size: .63rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase;
        }
        .cat-pill::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; }

        /* ── Rajdhani for big headings ───────────── */
        .cx-heading { font-family: 'Rajdhani', sans-serif; letter-spacing: .02em; }

        /* ── Sidebar widget ─────────────────────── */
        .cx-widget { background: var(--cx-surf); border: 1px solid var(--cx-border); border-radius: 8px; overflow: hidden; }
        .cx-widget-header {
            padding: 10px 14px;
            background: linear-gradient(90deg, rgba(232,57,42,.12), transparent);
            border-bottom: 1px solid var(--cx-border);
            font-size: .68rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase;
            color: #fff; display: flex; align-items: center; gap: 8px;
        }
        .cx-widget-header::before {
            content:''; width:3px; height:14px; background:var(--cx-red); border-radius:2px; flex-shrink:0;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen antialiased">

    {{-- ── Top pixel accent bar ───────────────────────────────────── --}}
    <div class="top-accent-bar h-[3px] w-full"></div>

    {{-- ── Top meta bar ───────────────────────────────────────────── --}}
    <div class="hidden md:block border-b border-[#21293a]" style="background:#0d1018">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-8 text-[11px] text-[#4b5568]">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#22c55e] animate-pulse inline-block"></span>
                    {{ __('ui.gaming_portal') }}
                </span>
                <span>|</span>
                    <span>{{ now()->locale(app()->getLocale())->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-[#8899aa]">{{ __('ui.welcome') }}, {{ \Illuminate\Support\Str::limit(auth()->user()->name, 14) }}</span>
                @else
                    <a href="{{ route('login') }}" class="hover:text-[#d1d8e4] transition-colors">{{ __('ui.nav_login') }}</a>
                    <span>|</span>
                    <a href="{{ route('register') }}" class="hover:text-[#d1d8e4] transition-colors">{{ __('ui.nav_register') }}</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- ── Navbar ─────────────────────────────────────────────────── --}}
    <nav class="sticky top-0 z-50 cx-navbar backdrop-blur-md" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[56px]">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0 group">
                    {{-- CX monogram --}}
                    <div class="w-9 h-9 rounded-md flex items-center justify-center flex-shrink-0 relative overflow-hidden"
                         style="background:var(--cx-red)">
                        <span class="text-white font-black text-base leading-none cx-heading" style="letter-spacing:-.02em">CX</span>
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity"
                             style="background:linear-gradient(135deg,rgba(255,255,255,.15),transparent)"></div>
                    </div>
                    <div class="leading-none">
                        <span class="cx-heading text-white font-black text-[1.2rem] uppercase tracking-tight">COREX</span><span class="cx-heading font-black text-[1.2rem] uppercase tracking-tight" style="color:var(--cx-red)">-DEV</span>
                    </div>
                </a>

                {{-- Nav links --}}
                <div class="hidden md:flex items-center">
                    @php
                        $navLinks = [
                            ['route' => 'posts.index',    'label' => __('ui.nav_news'),      'pattern' => 'posts.*'],
                            ['route' => 'events.index',   'label' => __('ui.nav_events'),    'pattern' => 'events.*'],
                            ['route' => 'guides.index',   'label' => __('ui.nav_guides'),    'pattern' => 'guides.*'],
                            ['route' => 'reviews.index',  'label' => __('ui.nav_reviews'),   'pattern' => 'reviews.*'],
                            ['route' => 'giveaways.index','label' => __('ui.nav_giveaways'), 'pattern' => 'giveaways.*'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           class="nav-item {{ request()->routeIs($link['pattern']) ? 'nav-active' : '' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Right actions --}}
                <div class="flex items-center gap-2">
                    @auth
                        @if(auth()->user()->is_admin ?? false)
                            <a href="{{ route('admin.dashboard') }}"
                               class="hidden md:inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-bold uppercase tracking-widest rounded transition-all"
                               style="background:rgba(232,57,42,.15); border:1px solid rgba(232,57,42,.5); color:var(--cx-red)"
                               onmouseenter="this.style.background='rgba(232,57,42,.25)'"
                               onmouseleave="this.style.background='rgba(232,57,42,.15)'">
                                <i class="fa fa-bolt text-[10px]"></i> {{ __('ui.admin_label') }}
                            </a>
                        @endif
                        <a href="{{ route('ucp.index') }}"
                           class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-[11px] font-semibold rounded transition-all"
                           style="background:var(--cx-card); border:1px solid var(--cx-border); color:#8899aa"
                           onmouseenter="this.style.borderColor='rgba(232,57,42,.4)'; this.style.color='#fff'"
                           onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#8899aa'">
                            <span class="w-5 h-5 rounded flex items-center justify-center font-black text-[10px] text-white"
                                  style="background:var(--cx-red)">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 12) }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="px-2.5 py-1.5 text-[11px] rounded transition-all"
                                    style="border:1px solid var(--cx-border); color:#4b5568"
                                    onmouseenter="this.style.borderColor='rgba(239,68,68,.4)'; this.style.color='#ef4444'"
                                    onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#4b5568'">
                                {{ __('ui.nav_logout') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden sm:inline-flex px-4 py-1.5 text-[11px] font-semibold uppercase tracking-wide rounded transition-all"
                           style="border:1px solid var(--cx-border); color:#8899aa"
                           onmouseenter="this.style.borderColor='rgba(232,57,42,.4)'; this.style.color='#fff'"
                           onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#8899aa'">
                            {{ __('ui.nav_login') }}
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex px-4 py-1.5 text-[11px] font-bold uppercase tracking-wide rounded transition-all text-white"
                           style="background:var(--cx-red); box-shadow:0 0 14px rgba(232,57,42,.35)"
                           onmouseenter="this.style.background='var(--cx-red2)'"
                           onmouseleave="this.style.background='var(--cx-red)'">
                            {{ __('ui.nav_join') }}
                        </a>
                    @endauth

                    {{-- Language switcher --}}
                    <form method="POST" action="{{ route('locale.switch', __('ui.lang_switch_target')) }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-1.5 px-2.5 py-1.5 text-[11px] font-bold rounded transition-all uppercase tracking-wider"
                                style="border:1px solid var(--cx-border); color:#8899aa"
                                title="{{ __('ui.lang_switch_title') }}"
                                onmouseenter="this.style.borderColor='rgba(232,57,42,.4)'; this.style.color='#fff'"
                                onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#8899aa'">
                            <i class="fa fa-language text-xs"></i>
                            {{ __('ui.lang_switch_label') }}
                        </button>
                    </form>

                    {{-- Mobile burger --}}
                    <button @click="mobileOpen = !mobileOpen"
                            class="md:hidden p-2 rounded transition-colors"
                            style="color:#4b5568"
                            onmouseenter="this.style.color='#fff'"
                            onmouseleave="this.style.color='#4b5568'">
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen"  class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div x-show="mobileOpen" x-cloak
                 x-transition:enter="transition duration-150 ease-out"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="md:hidden border-t pb-3 pt-2 space-y-0.5"
                 style="border-color:var(--cx-border)">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" @click="mobileOpen=false"
                       class="flex items-center gap-2 px-3 py-2.5 text-sm font-bold uppercase tracking-wide rounded-md transition-colors"
                       style="{{ request()->routeIs($link['pattern']) ? 'background:rgba(232,57,42,.12); color:var(--cx-red)' : 'color:#8899aa' }}"
                       onmouseenter="if(!this.style.background){ this.style.color='#fff'; }"
                       onmouseleave="if(!this.style.background){ this.style.color='#8899aa'; }">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                @auth
                    <div class="pt-2 mt-2 border-t flex items-center gap-2" style="border-color:var(--cx-border)">
                        <a href="{{ route('ucp.index') }}" class="flex-1 text-center py-2 rounded text-sm font-semibold text-white" style="background:var(--cx-card); border:1px solid var(--cx-border)">{{ __('ui.nav_my_account') }}</a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button class="w-full py-2 rounded text-sm font-semibold text-[#ef4444]" style="background:var(--cx-card); border:1px solid rgba(239,68,68,.25)">{{ __('ui.nav_close_session') }}</button>
                        </form>
                    </div>
                @else
                    <div class="pt-2 mt-2 border-t flex gap-2" style="border-color:var(--cx-border)">
                        <a href="{{ route('login') }}" class="flex-1 text-center py-2 rounded text-sm font-bold text-[#8899aa]" style="border:1px solid var(--cx-border)">{{ __('ui.nav_login') }}</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center py-2 rounded text-sm font-bold text-white" style="background:var(--cx-red)">{{ __('ui.nav_join') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash toasts --}}
    @if(session('success') || session('error'))
        <div class="fixed top-16 right-4 z-50 toast-anim max-w-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            @if(session('success'))
                <div class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm text-green-300 shadow-2xl"
                     style="background:#0b1a10; border:1px solid rgba(34,197,94,.4); box-shadow:0 0 24px rgba(34,197,94,.08)">
                    <i class="fa fa-check text-[#22c55e]"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm text-red-300 shadow-2xl"
                     style="background:#1a0a0a; border:1px solid rgba(239,68,68,.4)">
                    <i class="fa fa-times text-red-400"></i>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    {{-- Main --}}
    <main>
        @yield('content')
    </main>

    {{-- ── Footer ──────────────────────────────────────────────────── --}}
    <footer class="relative mt-16">
        {{-- Top divider with accent --}}
        <div class="h-[3px]" style="background:linear-gradient(90deg, var(--cx-red), transparent 60%)"></div>
        <div style="background:#0d1018; border-top:1px solid var(--cx-border)">
            <div class="max-w-7xl mx-auto px-4 pt-12 pb-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-10">
                    {{-- Brand --}}
                    <div class="md:col-span-5">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 rounded-md flex items-center justify-center" style="background:var(--cx-red)">
                                <span class="cx-heading text-white font-black text-base" style="letter-spacing:-.02em">CX</span>
                            </div>
                            <div>
                                <span class="cx-heading text-white font-black text-[1.25rem] uppercase tracking-tight">COREX</span><span class="cx-heading font-black text-[1.25rem] uppercase tracking-tight" style="color:var(--cx-red)">-DEV</span>
                            </div>
                        </a>
                        <p class="text-[#4b5568] text-sm leading-relaxed max-w-xs">
                            {!! __('ui.footer_desc') !!}
                        </p>
                        <div class="flex items-center gap-3 mt-5">
                            @if($__tw)
                            <a href="{{ $__tw }}" target="_blank" rel="noopener" class="w-8 h-8 rounded flex items-center justify-center transition-colors text-[#4b5568] hover:text-white hover:bg-[#1d2535]" style="border:1px solid var(--cx-border)"><i class="fab fa-twitter text-xs"></i></a>
                            @endif
                            @if($__dc)
                            <a href="{{ $__dc }}" target="_blank" rel="noopener" class="w-8 h-8 rounded flex items-center justify-center transition-colors text-[#4b5568] hover:text-white hover:bg-[#1d2535]" style="border:1px solid var(--cx-border)"><i class="fab fa-discord text-xs"></i></a>
                            @endif
                            @if($__yt)
                            <a href="{{ $__yt }}" target="_blank" rel="noopener" class="w-8 h-8 rounded flex items-center justify-center transition-colors text-[#4b5568] hover:text-white hover:bg-[#1d2535]" style="border:1px solid var(--cx-border)"><i class="fab fa-youtube text-xs"></i></a>
                            @endif
                        </div>
                    </div>
                    {{-- Secciones --}}
                    <div class="md:col-span-3 md:col-start-7">
                        <h4 class="text-[11px] font-black uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-sm inline-block" style="background:var(--cx-red)"></span>
                            <span style="color:var(--cx-red)">{{ __('ui.footer_sections') }}</span>
                        </h4>
                        <ul class="space-y-2.5 text-sm">
                            <li><a href="{{ route('posts.index') }}"    class="footer-link flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-red)"></i>{{ __('ui.nav_news') }}</a></li>
                            <li><a href="{{ route('guides.index') }}"   class="footer-link flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-red)"></i>{{ __('ui.nav_guides') }}</a></li>
                            <li><a href="{{ route('reviews.index') }}"  class="footer-link flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-red)"></i>{{ __('ui.nav_reviews') }}</a></li>
                            <li><a href="{{ route('events.index') }}"   class="footer-link flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-red)"></i>{{ __('ui.nav_events') }}</a></li>
                            <li><a href="{{ route('giveaways.index') }}" class="footer-link flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-red)"></i>{{ __('ui.nav_giveaways') }}</a></li>
                        </ul>
                    </div>
                    {{-- Cuenta --}}
                    <div class="md:col-span-3">
                        <h4 class="text-[11px] font-black uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-sm inline-block" style="background:var(--cx-blue)"></span>
                            <span style="color:var(--cx-blue)">{{ __('ui.footer_account') }}</span>
                        </h4>
                        <ul class="space-y-2.5 text-sm">
                            @auth
                                <li><a href="{{ route('ucp.index') }}" class="flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-blue)"></i>{{ __('ui.nav_my_account') }}</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="flex items-center gap-2 text-[#4b5568] hover:text-red-400 transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-blue)"></i>{{ __('ui.nav_close_session') }}</button>
                                    </form>
                                </li>
                                @if(auth()->user()->is_admin ?? false)
                                    <li><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 transition-colors hover:text-white" style="color:rgba(232,57,42,.6)"><i class="fa fa-bolt text-[9px]"></i>{{ __('ui.nav_admin_panel') }}</a></li>
                                @endif
                            @else
                                <li><a href="{{ route('login') }}"    class="flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-blue)"></i>{{ __('ui.nav_login') }}</a></li>
                                <li><a href="{{ route('register') }}" class="flex items-center gap-2 text-[#4b5568] hover:text-white transition-colors"><i class="fa fa-chevron-right text-[9px]" style="color:var(--cx-blue)"></i>{{ __('ui.nav_register') }}</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs" style="border-top:1px solid var(--cx-border)">
                    <p style="color:#2d3748">© {{ date('Y') }} <strong class="cx-heading text-[#4b5568]">COREX-DEV</strong> &mdash; {{ __('ui.footer_tagline') }}</p>
                    <div class="flex items-center gap-4" style="color:#4b5568">
                        <a href="{{ route('legal.terms') }}" class="hover:text-white transition-colors">{{ __('ui.footer_terms') }}</a>
                        <span>·</span>
                        <a href="{{ route('legal.privacy') }}" class="hover:text-white transition-colors">{{ __('ui.footer_privacy') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

    {{-- Cookie Consent Banner --}}
    <x-cookie-banner />
</body>
</html>
