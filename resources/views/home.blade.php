@extends('layouts.app')
@section('title', __('ui.home_title'))

@section('content')

{{-- ── HERO SLIDER ─────────────────────────────────────────────────────── --}}
@if($sliderPosts->isNotEmpty())
<section class="relative h-[540px] overflow-hidden" style="background:var(--cx-bg)" x-data="slider({{ $sliderPosts->count() }})">
    {{-- Slides --}}
    @foreach($sliderPosts as $i => $post)
        <div class="absolute inset-0 transition-opacity duration-700"
             :class="current === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                     class="w-full h-full object-cover object-center scale-105"
                     loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
            @else
                <div class="w-full h-full" style="background:linear-gradient(135deg,var(--cx-bg) 0%,#141922 50%,var(--cx-bg) 100%)">
                    <div class="absolute inset-0 cx-grid-bg opacity-40"></div>
                </div>
            @endif
            {{-- Overlays --}}
            <div class="absolute inset-0 hero-overlay"></div>
            <div class="absolute inset-0 hero-overlay-bottom"></div>
            {{-- Red accent line left --}}
            <div class="absolute left-0 top-0 bottom-0 w-[3px]" style="background:var(--cx-red)"></div>

            <div class="absolute inset-0 flex items-center">
                <div class="max-w-7xl mx-auto px-8 w-full">
                    <div class="max-w-[680px]"
                         :class="current === {{ $i }} ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                         style="transition: opacity .5s ease .1s, transform .5s ease .1s">
                        @if($post->category)
                            <span class="cx-badge cx-badge-red mb-4 inline-flex">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <h2 class="cx-heading text-white font-black mb-4 leading-[1.05]"
                            style="font-size:clamp(1.8rem,4vw,3rem)">
                            {{ $post->title }}
                        </h2>
                        <p class="text-[#8899aa] text-sm mb-6 line-clamp-2 max-w-xl">{{ $post->excerpt }}</p>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('posts.show', $post->slug) }}"
                               class="inline-flex items-center gap-2 px-6 py-2.5 font-bold text-sm uppercase tracking-wide text-white rounded transition-all"
                               style="background:var(--cx-red); box-shadow:0 0 18px rgba(232,57,42,.4)"
                               onmouseenter="this.style.background='var(--cx-red2)'; this.style.boxShadow='0 0 28px rgba(232,57,42,.6)'"
                               onmouseleave="this.style.background='var(--cx-red)'; this.style.boxShadow='0 0 18px rgba(232,57,42,.4)'">
                                {{ __('ui.read_now') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                            @if($post->published_at)
                                <span class="text-[#4b5568] text-xs">{{ $post->published_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Arrows --}}
    <button @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded flex items-center justify-center text-[#8899aa] hover:text-white transition-all"
            style="background:rgba(11,13,17,.7); border:1px solid var(--cx-border); backdrop-filter:blur(4px)"
            onmouseenter="this.style.borderColor='var(--cx-red)'; this.style.color='#fff'"
            onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#8899aa'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded flex items-center justify-center text-[#8899aa] hover:text-white transition-all"
            style="background:rgba(11,13,17,.7); border:1px solid var(--cx-border); backdrop-filter:blur(4px)"
            onmouseenter="this.style.borderColor='var(--cx-red)'; this.style.color='#fff'"
            onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#8899aa'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Dot indicators --}}
    <div class="absolute bottom-5 left-8 z-20 flex gap-1.5">
        @foreach($sliderPosts as $i => $post)
            <button @click="current = {{ $i }}"
                    :class="current === {{ $i }} ? 'w-6 opacity-100' : 'w-2 opacity-35 hover:opacity-60'"
                    class="h-[3px] rounded-full transition-all duration-300"
                    style="background:var(--cx-red)"></button>
        @endforeach
    </div>
</section>
@endif

{{-- ── PRÓXIMOS EVENTOS (countdown bar) ─────────────────────────────────── --}}
@if($upcomingEvents->isNotEmpty())
<div style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-0 overflow-x-auto py-0 scrollbar-thin">
            <div class="flex-shrink-0 flex items-center gap-2 pr-4 py-3" style="border-right:1px solid var(--cx-border)">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background:var(--cx-red)"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2" style="background:var(--cx-red)"></span>
                </span>
                <span class="font-black text-[10px] uppercase tracking-[.18em] whitespace-nowrap" style="color:var(--cx-red)">{{ __('ui.nav_events') }}</span>
            </div>
            <div class="flex items-center gap-2 px-4 py-3 overflow-x-auto">
                @foreach($upcomingEvents as $event)
                    <a href="{{ route('events.show', $event->slug) }}"
                       class="flex-shrink-0 flex items-center gap-2 rounded px-3 py-2 transition-all group min-w-[160px] text-decoration-none"
                       style="background:var(--cx-card); border:1px solid var(--cx-border)"
                       onmouseenter="this.style.borderColor='rgba(232,57,42,.4)'"
                       onmouseleave="this.style.borderColor='var(--cx-border)'">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                                 class="w-8 h-8 object-cover rounded flex-shrink-0 opacity-80 group-hover:opacity-100 transition-opacity">
                        @else
                            <div class="w-8 h-8 rounded flex items-center justify-center text-sm flex-shrink-0" style="background:#1e2a3a">🎮</div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-white text-xs font-semibold truncate group-hover:text-[#e8392a] transition-colors">{{ $event->name }}</p>
                            <p class="text-[10px] font-mono leading-tight" style="color:var(--cx-red)"
                               x-data="liveCountdown('{{ $event->event_date->toISOString() }}')"
                               x-text="time">—</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── TICKER MARQUEE ─────────────────────────────────────────────────────────────── --}}
<div class="ticker-wrap" style="background:var(--cx-bg); border-bottom:1px solid var(--cx-border)">
    <div class="ticker-track flex gap-10 py-2 text-[11px] font-semibold whitespace-nowrap" style="color:#2d3748">
        @foreach(range(0, 3) as $_)
            <span style="color:#3a4859">▶</span>
            <span>{{ __('ui.ticker_tagline') }}</span>
            <span style="color:var(--cx-border)">|</span>
            <span>{{ __('ui.ticker_giveaways') }}</span>
            <span style="color:var(--cx-border)">|</span>
            <span>{{ __('ui.ticker_news') }}</span>
            <span style="color:var(--cx-border)">|</span>
            <span>{{ __('ui.ticker_launches') }}</span>
            <span style="color:var(--cx-border)">|</span>
        @endforeach
    </div>
</div>

{{-- ── NOTICIAS RECIENTES ─────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="cx-section-title mb-2">{{ __('ui.home_latest_label') }}</p>
            <h2 class="cx-heading text-white text-2xl font-black tracking-tight">{{ __('ui.home_news_heading') }}</h2>
        </div>
        <a href="{{ route('posts.index') }}"
           class="hidden sm:flex items-center gap-1.5 text-xs font-bold hover:gap-3 transition-all uppercase tracking-wide"
           style="color:var(--cx-red)">
            {{ __('ui.see_all') }}
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    @if($latestPosts->isNotEmpty())
        @php $firstPost = $latestPosts->first(); $restPosts = $latestPosts->skip(1); @endphp
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            {{-- Featured large card --}}
            <a href="{{ route('posts.show', $firstPost->slug) }}"
               class="lg:col-span-5 relative rounded-lg overflow-hidden group cx-card flex flex-col min-h-[360px]">
                @if($firstPost->image)
                    <img src="{{ asset('storage/' . $firstPost->image) }}" alt="{{ $firstPost->title }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                    <div class="absolute inset-0 cx-grid-bg" style="background:var(--cx-card)"></div>
                @endif
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(11,13,17,.98) 0%, rgba(11,13,17,.5) 50%, transparent 100%)"></div>
                {{-- Red bottom accent --}}
                <div class="absolute bottom-0 left-0 right-0 h-[2px]" style="background:var(--cx-red)"></div>
                <div class="relative mt-auto p-5">
                    @if($firstPost->category)
                        <span class="cx-badge cx-badge-red mb-3 inline-flex">{{ $firstPost->category->name }}</span>
                    @endif
                    <h3 class="cx-heading text-white font-black text-xl leading-tight group-hover:text-[#e8392a] transition-colors line-clamp-3">
                        {{ $firstPost->title }}
                    </h3>
                    @if($firstPost->excerpt)
                        <p class="text-[#4b5568] text-xs mt-2 line-clamp-2">{{ $firstPost->excerpt }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-3 text-[#4b5568] text-xs">
                        <span>{{ $firstPost->published_at?->diffForHumans() }}</span>
                        <span class="flex items-center gap-1">
                            <i class="fa fa-eye text-[10px]"></i>
                            {{ number_format($firstPost->views) }}
                        </span>
                    </div>
                </div>
            </a>

            {{-- Grid of remaining posts --}}
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach($restPosts->take(6) as $post)
                    @include('components.post-card', ['post' => $post])
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-5xl mb-3 opacity-30">📰</p>
            <p class="text-gray-500">{{ __('ui.no_news') }}</p>
        </div>
    @endif
</section>

{{-- ── GUÍAS Y RESEÑAS (lado a lado) ───────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 pb-10 grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Guías --}}
    <div class="cx-widget">
        <div class="cx-widget-header">
            <i class="fa fa-book-open text-[10px]" style="color:var(--cx-red)"></i>
            {{ __('ui.nav_guides') }}
            <a href="{{ route('guides.index') }}" class="ml-auto text-[10px] font-semibold hover:text-white transition-colors" style="color:#4b5568">{{ __('ui.see_all_arrow') }}</a>
        </div>
        <div class="p-3 space-y-1">
            @forelse($latestGuides as $post)
                <a href="{{ route('posts.show', $post->slug) }}"
                   class="flex gap-3 rounded p-2.5 group transition-all"
                   style="border:1px solid transparent"
                   onmouseenter="this.style.background='rgba(232,57,42,.05)'; this.style.borderColor='rgba(232,57,42,.18)'"
                   onmouseleave="this.style.background='transparent'; this.style.borderColor='transparent'">
                    <div class="w-14 h-14 rounded overflow-hidden flex-shrink-0">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xl" style="background:var(--cx-card)">📖</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex flex-col justify-center">
                        @if($post->category)
                            <span class="text-[10px] font-black uppercase tracking-wide" style="color:var(--cx-red)">{{ $post->category->name }}</span>
                        @endif
                        <p class="text-[#d1d8e4] text-[13px] font-semibold leading-snug group-hover:text-white transition-colors line-clamp-2">{{ $post->title }}</p>
                        <p class="text-[#4b5568] text-[11px] mt-0.5">{{ $post->published_at?->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <p class="text-[#2d3748] text-sm py-5 text-center">{{ __('ui.no_guides') }}</p>
            @endforelse
        </div>
    </div>

    {{-- Reseñas --}}
    <div class="cx-widget">
        <div class="cx-widget-header" style="background:linear-gradient(90deg, rgba(245,158,11,.1), transparent)">
            <i class="fa fa-star text-[10px]" style="color:var(--cx-amber)"></i>
            <span style="color:var(--cx-amber)">{{ __('ui.nav_reviews') }}</span>
            <a href="{{ route('reviews.index') }}" class="ml-auto text-[10px] font-semibold hover:text-white transition-colors" style="color:#4b5568">{{ __('ui.see_all_arrow') }}</a>
        </div>
        <div class="p-3 space-y-1">
            @forelse($latestReviews as $review)
                <a href="{{ route('reviews.show', $review->slug) }}"
                   class="flex gap-3 rounded p-2.5 group transition-all"
                   style="border:1px solid transparent"
                   onmouseenter="this.style.background='rgba(245,158,11,.04)'; this.style.borderColor='rgba(245,158,11,.18)'"
                   onmouseleave="this.style.background='transparent'; this.style.borderColor='transparent'">
                    <div class="w-14 h-14 rounded overflow-hidden flex-shrink-0">
                        @if($review->image)
                            <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xl" style="background:var(--cx-card)">🎮</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <span class="text-[10px] font-black uppercase tracking-wide" style="color:var(--cx-amber)">{{ $review->game }}</span>
                        <p class="text-[#d1d8e4] text-[13px] font-semibold leading-snug group-hover:text-white transition-colors line-clamp-2">{{ $review->title }}</p>
                        <p class="text-[#4b5568] text-[11px] mt-0.5">{{ $review->published_at?->diffForHumans() }}</p>
                    </div>
                    {{-- Score --}}
                    @php
                        $s = (float)$review->score;
                        $scoreClass = $s >= 8 ? 'high' : ($s <= 5 ? 'low' : '');
                    @endphp
                    <div class="flex-shrink-0 cx-score {{ $scoreClass }}">{{ $review->score }}</div>
                </a>
            @empty
                <p class="text-[#2d3748] text-sm py-5 text-center">{{ __('ui.no_reviews') }}</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ── SORTEOS ACTIVOS ──────────────────────────────────────────────────── --}}
@if($activeGiveaways->isNotEmpty())
<section style="background:var(--cx-surf); border-top:1px solid var(--cx-border); border-bottom:1px solid var(--cx-border)">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <p class="cx-section-title mb-2" style="color:var(--cx-amber)">
                    <span style="background:var(--cx-amber)"></span>
                    {{ __('ui.home_giveaways_label') }}
                </p>
                <h2 class="cx-heading text-white text-2xl font-black tracking-tight">{{ __('ui.home_giveaways_heading') }}</h2>
            </div>
            <a href="{{ route('giveaways.index') }}"
               class="hidden sm:flex items-center gap-1.5 text-xs font-bold hover:gap-3 transition-all uppercase tracking-wide"
               style="color:var(--cx-amber)">
                {{ __('ui.see_all_giveaways') }}
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($activeGiveaways as $giveaway)
                <a href="{{ route('giveaways.show', $giveaway->slug) }}"
                   class="rounded-lg overflow-hidden flex flex-col group cx-card"
                   style="border-color:rgba(245,158,11,.2)"
                   onmouseenter="this.style.borderColor='rgba(245,158,11,.5)'; this.style.boxShadow='0 0 20px rgba(245,158,11,.08)'"
                   onmouseleave="this.style.borderColor='rgba(245,158,11,.2)'; this.style.boxShadow='none'">
                    <div class="relative overflow-hidden">
                        @if($giveaway->image)
                            <img src="{{ asset('storage/' . $giveaway->image) }}" alt="{{ $giveaway->title }}"
                                 class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-40 flex items-center justify-center text-5xl"
                                 style="background:linear-gradient(135deg,rgba(245,158,11,.08),rgba(11,13,17,1))">🎁</div>
                        @endif
                        <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(11,13,17,.85) 0%,transparent 60%)"></div>
                        <span class="absolute top-2.5 right-2.5 cx-badge"
                              style="background:var(--cx-amber); color:#000">{{ __('ui.giveaway_ongoing') }}</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="cx-heading text-white font-bold text-sm leading-snug group-hover:text-[#f59e0b] transition-colors line-clamp-2 flex-1">
                            {{ $giveaway->title }}
                        </h3>
                        <div class="mt-3 pt-3 flex items-center justify-between" style="border-top:1px solid var(--cx-border)">
                            <span class="text-xs font-semibold truncate" style="color:var(--cx-amber)">{{ $giveaway->prize }}</span>
                            <span class="text-[#4b5568] text-[11px] flex-shrink-0 ml-2">{{ $giveaway->end_date->format('d M') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
function slider(total) {
    return {
        current: 0,
        timer: null,
        init() { this.timer = setInterval(() => this.next(), 5500); },
        next() { this.current = (this.current + 1) % total; },
        prev() { this.current = (this.current - 1 + total) % total; },
    };
}

function countdown(isoDate) {
    const target = new Date(isoDate);
    const diff = target - new Date();
    if (diff <= 0) return '{{ __('ui.js_available') }}';
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    return `${String(d).padStart(2,'0')}d ${String(h).padStart(2,'0')}h ${String(m).padStart(2,'0')}m ${String(s).padStart(2,'0')}s`;
}

function liveCountdown(isoDate) {
    return {
        time: '—',
        timer: null,
        init() { this.update(); this.timer = setInterval(() => this.update(), 1000); },
        destroy() { clearInterval(this.timer); },
        update() { this.time = countdown(isoDate); }
    };
}
</script>
@endpush
