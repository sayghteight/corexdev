@extends('layouts.admin')
@section('title', 'Panel Admin — Corex-Dev')

@section('breadcrumb', 'Dashboard')
@section('content')
    <div class="flex items-center gap-3 mb-8">
        <div class="w-1 h-8 rounded-full" style="background:linear-gradient(180deg,#00d4ff,#8b5cf6)"></div>
        <h1 class="text-2xl font-extrabold text-white">Panel de Administración</h1>
    </div>

    {{-- Stats --}}
    @php
        $statCards = [
            ['label' => 'Artículos',  'value' => $stats['posts'],     'icon' => 'fa-solid fa-newspaper',    'color' => '#00d4ff', 'route' => 'admin.posts.index'],
            ['label' => 'Reseñas',    'value' => $stats['reviews'],   'icon' => 'fa-solid fa-star',          'color' => '#ffd700', 'route' => 'admin.reviews.index'],
            ['label' => 'Eventos',    'value' => $stats['events'],    'icon' => 'fa-solid fa-calendar-days', 'color' => '#8b5cf6', 'route' => 'admin.events.index'],
            ['label' => 'Sorteos',    'value' => $stats['giveaways'], 'icon' => 'fa-solid fa-gift',          'color' => '#ff6b00', 'route' => 'admin.giveaways.index'],
            ['label' => 'Usuarios',   'value' => $stats['users'],     'icon' => 'fa-solid fa-users',         'color' => '#22c55e', 'route' => null],
            ['label' => 'Visitas hoy','value' => number_format($stats['viewsToday']), 'icon' => 'fa-solid fa-eye', 'color' => '#06b6d4', 'route' => 'admin.stats.index'],
            ['label' => 'Total visitas','value' => number_format($stats['views']),   'icon' => 'fa-solid fa-chart-bar', 'color' => '#a78bfa', 'route' => 'admin.stats.index'],
        ];
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 gap-4 mb-10">
        @foreach($statCards as $card)
            @if($card['route'])
                <a href="{{ route($card['route']) }}"
                   class="rounded-xl p-5 text-center group transition-all"
                   style="background:#111827; border:1px solid #1e2a3a"
                   onmouseenter="this.style.borderColor='{{ $card['color'] }}40'; this.style.boxShadow='0 0 18px {{ $card['color'] }}18'"
                   onmouseleave="this.style.borderColor='#1e2a3a'; this.style.boxShadow='none'">
            @else
                <div class="rounded-xl p-5 text-center" style="background:#111827; border:1px solid #1e2a3a">
            @endif
                <div class="w-11 h-11 rounded-xl mx-auto mb-3 flex items-center justify-center"
                     style="background:{{ $card['color'] }}18; border:1px solid {{ $card['color'] }}30">
                    <i class="{{ $card['icon'] }} text-lg" style="color:{{ $card['color'] }}"></i>
                </div>
                <p class="text-3xl font-black" style="color:{{ $card['color'] }}">{{ $card['value'] }}</p>
                <p class="text-gray-500 text-xs mt-1 font-medium uppercase tracking-wide">{{ $card['label'] }}</p>
            @if($card['route'])
                </a>
            @else
                </div>
            @endif
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="rounded-xl p-4 mb-10 flex flex-wrap gap-2" style="background:#0d111d; border:1px solid #1e2a3a">
        <span class="text-gray-600 text-xs font-bold uppercase tracking-widest self-center mr-2">Crear:</span>
        <a href="{{ route('admin.posts.create') }}"
           class="flex items-center gap-1.5 px-4 py-2 font-bold text-sm rounded-lg text-[#060910] transition-all"
           style="background:linear-gradient(135deg,#00d4ff,#0099cc)"
           onmouseenter="this.style.opacity='.85'" onmouseleave="this.style.opacity='1'">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Noticia
        </a>
        <a href="{{ route('admin.reviews.create') }}"
           class="flex items-center gap-1.5 px-4 py-2 font-bold text-sm rounded-lg text-[#060910] transition-all"
           style="background:linear-gradient(135deg,#ffd700,#f59e0b)"
           onmouseenter="this.style.opacity='.85'" onmouseleave="this.style.opacity='1'">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Reseña
        </a>
        <a href="{{ route('admin.events.create') }}"
           class="flex items-center gap-1.5 px-4 py-2 font-bold text-sm rounded-lg text-white transition-all"
           style="background:linear-gradient(135deg,#8b5cf6,#6d28d9)"
           onmouseenter="this.style.opacity='.85'" onmouseleave="this.style.opacity='1'">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Evento
        </a>
        <a href="{{ route('admin.giveaways.create') }}"
           class="flex items-center gap-1.5 px-4 py-2 font-bold text-sm rounded-lg text-white transition-all"
           style="background:linear-gradient(135deg,#ff6b00,#ea580c)"
           onmouseenter="this.style.opacity='.85'" onmouseleave="this.style.opacity='1'">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Sorteo
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-1.5 px-4 py-2 font-bold text-sm rounded-lg text-gray-300 transition-all"
           style="background:#1e2a3a"
           onmouseenter="this.style.background='#243447'" onmouseleave="this.style.background='#1e2a3a'">
            Categorías
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Latest posts --}}
        <div class="rounded-xl overflow-hidden" style="background:#111827; border:1px solid #1e2a3a">
            <div class="px-5 py-3.5 border-b border-[#1e2a3a] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-4 rounded-full" style="background:#00d4ff"></div>
                    <h2 class="text-white font-bold text-sm">Últimos Artículos</h2>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-[#00d4ff] text-xs hover:underline">Ver todos →</a>
            </div>
            @forelse($latestPosts as $post)
                <div class="flex items-center gap-3 px-4 py-3 border-b border-[#1e2a3a]/60 last:border-0 group hover:bg-[#1a2133]/50 transition-colors">
                    <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $post->status === 'published' ? 'bg-green-500' : 'bg-gray-600' }}"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-white/90 text-sm truncate group-hover:text-white">{{ $post->title }}</p>
                        <p class="text-gray-600 text-xs">{{ $post->category?->name }} · {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.posts.edit', $post) }}"
                       class="text-[#00d4ff] text-xs hover:underline flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">Editar</a>
                </div>
            @empty
                <p class="text-gray-600 text-sm text-center py-8">Sin artículos.</p>
            @endforelse
        </div>

        {{-- Latest reviews --}}
        <div class="rounded-xl overflow-hidden" style="background:#111827; border:1px solid #1e2a3a">
            <div class="px-5 py-3.5 border-b border-[#1e2a3a] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-4 rounded-full" style="background:#ffd700"></div>
                    <h2 class="text-white font-bold text-sm">Últimas Reseñas</h2>
                </div>
                <a href="{{ route('admin.reviews.index') }}" class="text-[#ffd700] text-xs hover:underline">Ver todas →</a>
            </div>
            @forelse($latestReviews as $review)
                <div class="flex items-center gap-3 px-4 py-3 border-b border-[#1e2a3a]/60 last:border-0 group hover:bg-[#1a2133]/50 transition-colors">
                    <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center text-xs font-black flex-shrink-0"
                         style="border-color:#ffd700; color:#ffd700; background:rgba(255,215,0,.08)">
                        {{ $review->score }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white/90 text-sm truncate group-hover:text-white">{{ $review->title }}</p>
                        <p class="text-gray-600 text-xs">{{ $review->game }} · {{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.reviews.edit', $review) }}"
                       class="text-[#ffd700] text-xs hover:underline flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">Editar</a>
                </div>
            @empty
                <p class="text-gray-600 text-sm text-center py-8">Sin reseñas.</p>
            @endforelse
        </div>
    </div>
@endsection
