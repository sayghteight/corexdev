<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Corex-Dev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { color-scheme: dark; --cx-red:#e8392a; --cx-red2:#c42d1f; --cx-bg:#0b0d11; --cx-surf:#111419; --cx-card:#161b23; --cx-border:#21293a; }
        body  { background-color: var(--cx-bg); color: #d1d8e4; font-family:'Inter',sans-serif; }
        .admin-sidebar { width: 240px; }
        .admin-active  { background: rgba(232,57,42,.12); color: var(--cx-red); border-right: 3px solid var(--cx-red); }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen font-sans antialiased flex">

    {{-- ── Sidebar ─────────────────────────────────────────────────── --}}
    <aside class="admin-sidebar fixed top-0 left-0 h-full bg-[#060910] border-r border-[#1e2a3a] flex flex-col z-40 overflow-y-auto">
        {{-- Brand --}}
        <div class="px-5 py-5 border-b border-[#1e2a3a]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded flex items-center justify-center" style="background:var(--cx-red)">
                    <span class="text-white font-black text-sm" style="font-family:'Rajdhani',sans-serif; letter-spacing:-.02em">CX</span>
                </div>
                <div class="leading-none">
                    <div class="text-white font-black text-sm" style="font-family:'Rajdhani',sans-serif">COREX<span style="color:var(--cx-red)">-DEV</span></div>
                    <div class="text-[9px] font-bold uppercase tracking-widest mt-0.5" style="color:var(--cx-red)">Admin Panel</div>
                </div>
            </a>
        </div>

        {{-- User info --}}
        <div class="px-5 py-4 border-b border-[#1e2a3a]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded flex items-center justify-center text-white font-bold text-sm" style="background:var(--cx-red)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-white text-xs font-semibold truncate">{{ auth()->user()->name }}</div>
                    <div class="text-gray-500 text-[10px] truncate">{{ auth()->user()->email }}</div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4 px-3 space-y-5 overflow-y-auto">
            @php
                $adminNavGroups = [
                    [
                        'label' => 'General',
                        'items' => [
                            ['route' => 'admin.dashboard', 'icon' => 'fa-solid fa-chart-line', 'label' => 'Dashboard', 'pattern' => 'admin.dashboard'],
                        ],
                    ],
                    [
                        'label' => 'Contenido',
                        'items' => [
                            ['route' => 'admin.posts.index',     'icon' => 'fa-solid fa-newspaper',     'label' => 'Noticias',  'pattern' => 'admin.posts.*'],
                            ['route' => 'admin.reviews.index',   'icon' => 'fa-solid fa-star',          'label' => 'Reseñas',  'pattern' => 'admin.reviews.*'],
                            ['route' => 'admin.events.index',    'icon' => 'fa-solid fa-calendar-days', 'label' => 'Eventos',   'pattern' => 'admin.events.*'],
                            ['route' => 'admin.giveaways.index', 'icon' => 'fa-solid fa-gift',          'label' => 'Sorteos',  'pattern' => 'admin.giveaways.*'],
                        ],
                    ],
                    [
                        'label' => 'Taxonomía',
                        'items' => [
                            ['route' => 'admin.categories.index', 'icon' => 'fa-solid fa-tag', 'label' => 'Categorías', 'pattern' => 'admin.categories.*'],
                        ],
                    ],
                    [
                        'label' => 'Comunidad',
                        'items' => [
                            ['route' => 'admin.users.index',    'icon' => 'fa-solid fa-users',    'label' => 'Usuarios',     'pattern' => 'admin.users.*'],
                            ['route' => 'admin.comments.index', 'icon' => 'fa-solid fa-comments', 'label' => 'Comentarios',  'pattern' => 'admin.comments.*'],
                        ],
                    ],
                    [
                        'label' => 'Sistema',
                        'items' => [
                            ['route' => 'admin.stats.index',    'icon' => 'fa-solid fa-chart-bar',  'label' => 'Estadísticas', 'pattern' => 'admin.stats.*'],
                            ['route' => 'admin.settings.index', 'icon' => 'fa-solid fa-sliders',    'label' => 'Configuración', 'pattern' => 'admin.settings.*'],
                        ],
                    ],
                ];
            @endphp

            @foreach($adminNavGroups as $group)
                <div>
                    <p class="px-3 mb-1 text-[10px] font-extrabold uppercase tracking-[.12em] text-gray-600 select-none">
                        {{ $group['label'] }}
                    </p>
                    <div class="space-y-0.5">
                        @foreach($group['items'] as $item)
                            @php
                                $active = request()->routeIs($item['pattern']);
                                $isMaint = $item['pattern'] === 'admin.settings.*'
                                    && \App\Models\Setting::maintenanceActive();
                            @endphp
                            <a href="{{ route($item['route']) }}"
                               class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all
                                      {{ $active ? 'admin-active font-semibold' : 'text-gray-400 hover:text-white hover:bg-[#111827]' }}">
                                <i class="{{ $item['icon'] }} w-4 text-center text-sm leading-none
                                           {{ $active ? '' : 'group-hover:text-[var(--cx-red)]' }} transition-colors"></i>
                                <span class="flex-1">{{ $item['label'] }}</span>
                                @if($isMaint)
                                    <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 animate-pulse"></span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        {{-- Footer links --}}
        <div class="px-3 py-4 border-t border-[#1e2a3a] space-y-0.5">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-white hover:bg-[#111827] transition-all">
                <i class="fa-solid fa-globe w-4 text-center"></i> Ver sitio web
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-red-400 hover:bg-[#111827] transition-all text-left">
                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main Content ─────────────────────────────────────────────── --}}
    <div class="ml-[240px] flex-1 flex flex-col min-h-screen">

        {{-- Top bar --}}
        <header class="sticky top-0 z-30 bg-[#060910]/90 backdrop-blur border-b border-[#1e2a3a] h-14 flex items-center px-6 justify-between">
            <div class="text-sm text-gray-500 flex items-center gap-1.5">
                @yield('breadcrumb', 'Panel de Administración')
            </div>
            <div class="flex items-center gap-3">
                @if(\App\Models\Setting::maintenanceActive())
                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center gap-1.5 text-xs text-red-400 bg-red-900/20 border border-red-700/50 px-3 py-1 rounded-full hover:bg-red-900/40 transition-colors"
                       title="Modo mantenimiento activo">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        Mantenimiento activo
                    </a>
                @endif
                @if(session('success'))
                    <span class="text-xs text-green-400 bg-green-900/30 border border-green-700 px-3 py-1 rounded-full flex items-center gap-1.5">
                        <i class="fa-solid fa-check"></i> {{ session('success') }}
                    </span>
                @endif
                @if(session('error'))
                    <span class="text-xs text-red-400 bg-red-900/30 border border-red-700 px-3 py-1 rounded-full flex items-center gap-1.5">
                        <i class="fa-solid fa-xmark"></i> {{ session('error') }}
                    </span>
                @endif
                <span class="text-xs text-gray-600">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 px-6 py-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
