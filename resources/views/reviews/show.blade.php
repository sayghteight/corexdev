@extends('layouts.app')
@section('title', $review->title . ' — Corex-Dev')

@push('styles')
<style>
    /* Verdict color system */
    .sc-great { --sc:#16a34a; }
    .sc-good  { --sc:#ca8a04; }
    .sc-avg   { --sc:#c2410c; }
    .sc-bad   { --sc:#991b1b; }

    /* Animated score ring */
    @property --pct { syntax:'<integer>'; initial-value:0; inherits:false; }
    .score-donut {
        --size: 120px;
        --track: var(--cx-border);
        width: var(--size); height: var(--size);
        border-radius: 50%;
        display: flex; align-items:center; justify-content:center;
        position: relative;
        background: conic-gradient(var(--sc) calc(var(--pct) * 3.6deg), var(--track) 0deg);
        transition: --pct 1.2s cubic-bezier(.4,0,.2,1);
    }
    .score-donut::after {
        content:''; position:absolute; inset:10px;
        border-radius:50%; background:var(--cx-card);
    }
    .score-donut-inner {
        position:relative; z-index:1; text-align:center;
    }

    /* Score bar */
    .sc-bar { height:6px; border-radius:6px; background:var(--cx-border); overflow:hidden; }
    .sc-bar-fill { height:100%; border-radius:6px; background:var(--sc); transition:width 1s ease .2s; }

    /* Prose reset for content */
    .review-prose h2 { color:#fff; font-size:1.3rem; font-weight:800; margin:1.5rem 0 .6rem; font-family:'Rajdhani',sans-serif; }
    .review-prose h3 { color:#fff; font-size:1.1rem; font-weight:700; margin:1.2rem 0 .5rem; }
    .review-prose p  { color:#8899aa; line-height:1.8; margin-bottom:.9rem; }
    .review-prose img { border-radius:8px; margin:1rem 0; width:100%; border:1px solid var(--cx-border); }
    .review-prose a  { color:var(--cx-amber); text-decoration:underline; }
    .review-prose ul, .review-prose ol { color:#8899aa; padding-left:1.4rem; margin-bottom:.9rem; }
    .review-prose li { margin-bottom:.3rem; }
    .review-prose blockquote { border-left:3px solid var(--sc,var(--cx-amber)); padding-left:1rem; color:#6b7280; margin:1rem 0; }
</style>
@endpush

@section('content')

@php
    $score = (float)$review->score;
    $pct   = (int)(($score / 10) * 100);
    if ($score >= 9)     { $scClass = 'sc-great'; $verdict = __('ui.score_essential'); $verdictIcon = 'fa-trophy'; $verdictColor = '#16a34a'; }
    elseif ($score >= 7) { $scClass = 'sc-good';  $verdict = __('ui.score_recommended'); $verdictIcon = 'fa-thumbs-up'; $verdictColor = '#ca8a04'; }
    elseif ($score >= 5) { $scClass = 'sc-avg';   $verdict = __('ui.score_average'); $verdictIcon = 'fa-circle-half-stroke'; $verdictColor = '#c2410c'; }
    else                 { $scClass = 'sc-bad';   $verdict = __('ui.score_disappointing'); $verdictIcon = 'fa-thumbs-down'; $verdictColor = '#991b1b'; }
@endphp

{{-- ── HERO ─────────────────────────────────────────────────────────────── --}}
<div class="relative overflow-hidden" style="min-height:380px; background:var(--cx-bg)">
    {{-- Background image blur --}}
    @if($review->image)
        <div class="absolute inset-0 scale-110"
             style="background-image:url('{{ asset('storage/'.$review->image) }}'); background-size:cover; background-position:center; filter:blur(18px); opacity:.2;"></div>
    @endif
    <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(11,13,17,.6) 0%, var(--cx-bg) 100%)"></div>

    <div class="relative max-w-7xl mx-auto px-4 pt-8 pb-12">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-[11px] mb-8" style="color:#4b5568">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('ui.breadcrumb_home') }}</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <a href="{{ route('reviews.index') }}" class="hover:text-white transition-colors">{{ __('ui.breadcrumb_reviews') }}</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="truncate text-[#8899aa]">{{ $review->game }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- Cover art --}}
            @if($review->image)
            <div class="flex-shrink-0 rounded-lg overflow-hidden shadow-2xl" style="width:200px; border:1px solid var(--cx-border)">
                <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->game }}"
                     class="w-full aspect-[3/4] object-cover">
            </div>
            @endif

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                {{-- Game title --}}
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <p class="cx-heading font-black text-4xl text-white leading-tight">{{ $review->game }}</p>
                    @if($review->platform)
                        <span class="cx-badge" style="background:var(--cx-surf); color:#8899aa; border:1px solid var(--cx-border)">
                            <i class="fa-solid fa-gamepad text-[8px]"></i> {{ $review->platform }}
                        </span>
                    @endif
                </div>

                {{-- Review title --}}
                <h1 class="text-xl md:text-2xl font-bold mb-4 leading-snug" style="color:#d1d8e4">{{ $review->title }}</h1>

                {{-- Meta pills --}}
                <div class="flex flex-wrap gap-3 text-xs mb-5" style="color:#4b5568">
                    @if($review->developer)
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-screwdriver-wrench text-[9px]"></i>{{ $review->developer }}
                        </span>
                    @endif
                    @if($review->publisher)
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-building text-[9px]"></i>{{ $review->publisher }}
                        </span>
                    @endif
                    @if($review->release_date)
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-days text-[9px]"></i>{{ $review->release_date->format('d M Y') }}
                        </span>
                    @endif
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-[9px]"></i>{{ $review->user?->name ?? __('ui.author_default') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-eye text-[9px]"></i>{{ number_format($review->views) }} {{ __('ui.views_label') }}
                    </span>
                </div>

                {{-- Score block --}}
                <div class="flex flex-wrap items-center gap-6 p-5 rounded-lg {{ $scClass }}"
                     style="background:var(--cx-surf); border:1px solid var(--cx-border)">

                    {{-- Donut --}}
                    <div class="score-donut {{ $scClass }}" id="scoreDonut" style="--pct:0">
                        <div class="score-donut-inner">
                            <span class="cx-heading font-black text-3xl text-white leading-none">{{ $review->score }}</span>
                            <span class="block text-[10px] font-bold" style="color:#8899aa">/10</span>
                        </div>
                    </div>

                    {{-- Verdict + bar --}}
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid {{ $verdictIcon }} text-lg" style="color:{{ $verdictColor }}"></i>
                            <span class="cx-heading font-black text-2xl text-white">{{ $verdict }}</span>
                        </div>
                        <div class="sc-bar w-52 mb-1.5 {{ $scClass }}">
                            <div class="sc-bar-fill" id="scoreBar" style="width:0%"></div>
                        </div>
                        <p class="text-xs" style="color:#4b5568">{{ __('ui.score_caption') }}{{ $review->published_at?->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── CONTENT ──────────────────────────────────────────────────────────── --}}
<div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-10">

    {{-- Main column --}}
    <div>

        {{-- Excerpt / lead --}}
        @if($review->excerpt)
            <div class="flex gap-3 mb-8 p-5 rounded-lg {{ $scClass }}"
                 style="background:var(--cx-surf); border-left:3px solid {{ $verdictColor }}; border-top:1px solid var(--cx-border); border-right:1px solid var(--cx-border); border-bottom:1px solid var(--cx-border)">
                <i class="fa-solid fa-quote-left text-xl mt-0.5 flex-shrink-0" style="color:{{ $verdictColor }}"></i>
                <p class="text-[#d1d8e4] text-base font-medium leading-relaxed italic">{{ $review->excerpt }}</p>
            </div>
        @endif

        {{-- Body --}}
        <div class="review-prose {{ $scClass }}">
            {!! $review->content !!}
        </div>

        {{-- ── PROS / CONS ──────────────────────────────────────────────── --}}
        @php $pros = $review->pros; $cons = $review->cons; @endphp
        @if($pros->isNotEmpty() || $cons->isNotEmpty())
        <div class="mt-10 rounded-lg overflow-hidden" style="border:1px solid var(--cx-border)">
            {{-- Header --}}
            <div class="flex items-center gap-2.5 px-5 py-3.5" style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
                <i class="fa-solid fa-table-list" style="color:var(--cx-amber)"></i>
                <h3 class="cx-heading text-white font-black text-lg tracking-tight">{{ __('ui.pros_cons_title') }}</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2" style="background:var(--cx-card)">
                {{-- Pros --}}
                <div class="p-5" style="border-right:1px solid var(--cx-border); border-bottom:1px solid var(--cx-border)">
                    <h4 class="flex items-center gap-2 text-[11px] font-black uppercase tracking-widest mb-4" style="color:#16a34a">
                        <span class="w-5 h-5 rounded flex items-center justify-center" style="background:rgba(22,163,74,.15)"><i class="fa-solid fa-plus text-[9px]"></i></span>
                        {{ __('ui.pros_label') }}
                    </h4>
                    @if($pros->isNotEmpty())
                        <ul class="space-y-2.5">
                            @foreach($pros as $item)
                                <li class="flex items-start gap-3 text-sm" style="color:#d1d8e4">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background:rgba(22,163,74,.2)">
                                        <i class="fa-solid fa-check text-[8px]" style="color:#16a34a"></i>
                                    </span>
                                    {{ $item->text }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm" style="color:#2d3748">{{ __('ui.not_specified') }}</p>
                    @endif
                </div>
                {{-- Cons --}}
                <div class="p-5" style="border-bottom:1px solid var(--cx-border)">
                    <h4 class="flex items-center gap-2 text-[11px] font-black uppercase tracking-widest mb-4" style="color:#ef4444">
                        <span class="w-5 h-5 rounded flex items-center justify-center" style="background:rgba(239,68,68,.15)"><i class="fa-solid fa-minus text-[9px]"></i></span>
                        {{ __('ui.cons_label') }}
                    </h4>
                    @if($cons->isNotEmpty())
                        <ul class="space-y-2.5">
                            @foreach($cons as $item)
                                <li class="flex items-start gap-3 text-sm" style="color:#d1d8e4">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background:rgba(239,68,68,.2)">
                                        <i class="fa-solid fa-xmark text-[8px]" style="color:#ef4444"></i>
                                    </span>
                                    {{ $item->text }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm" style="color:#2d3748">{{ __('ui.not_specified') }}</p>
                    @endif
                </div>
            </div>

            {{-- Verdict footer --}}
            <div class="flex items-center gap-4 px-5 py-4" style="background:var(--cx-surf)">
                <div class="w-12 h-12 rounded-md flex flex-col items-center justify-center flex-shrink-0 {{ $scClass }}"
                     style="background:{{ $verdictColor }}">
                    <span class="font-black text-lg text-white leading-none">{{ $review->score }}</span>
                    <span class="text-[8px] text-white/70">/10</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid {{ $verdictIcon }} text-sm" style="color:{{ $verdictColor }}"></i>
                        <span class="cx-heading font-black text-white text-lg">{{ $verdict }}</span>
                    </div>
                    <p class="text-xs" style="color:#4b5568">{{ __('ui.verdict_label') }}</p>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- ── SIDEBAR ─────────────────────────────────────────────────────── --}}
    <aside class="space-y-5">

        {{-- Score card --}}
        <div class="cx-widget">
            <div class="cx-widget-header">
                <i class="fa-solid fa-star text-[10px]" style="color:var(--cx-amber)"></i>
                <span style="color:var(--cx-amber)">{{ __('ui.sidebar_score') }}</span>
            </div>
            <div class="p-5 space-y-3">
                {{-- Overall --}}
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold" style="color:#8899aa">{{ __('ui.sidebar_score_global') }}</span>
                    <span class="cx-heading font-black text-2xl text-white">{{ $review->score }}<span class="text-sm font-normal" style="color:#4b5568">/10</span></span>
                </div>
                <div class="sc-bar {{ $scClass }}">
                    <div class="sc-bar-fill sidebar-bar" style="width:0%; --target:{{ $pct }}%"></div>
                </div>
                {{-- Verdict chip --}}
                <div class="flex items-center justify-center gap-2 py-2 rounded-md mt-1" style="background:{{ $verdictColor }}20; border:1px solid {{ $verdictColor }}40">
                    <i class="fa-solid {{ $verdictIcon }} text-sm" style="color:{{ $verdictColor }}"></i>
                    <span class="font-black text-sm" style="color:{{ $verdictColor }}">{{ $verdict }}</span>
                </div>
            </div>
        </div>

        {{-- Game details --}}
        <div class="cx-widget">
            <div class="cx-widget-header">
                <i class="fa-solid fa-circle-info text-[10px]"></i>
                {{ __('ui.sidebar_game_data') }}
            </div>
            <div class="p-4 space-y-0">
                @if($review->developer)
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--cx-border)">
                    <span class="text-[11px] font-bold uppercase tracking-wide" style="color:#4b5568">{{ __('ui.game_developer') }}</span>
                    <span class="text-xs font-semibold text-right" style="color:#d1d8e4">{{ $review->developer }}</span>
                </div>
                @endif
                @if($review->publisher)
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--cx-border)">
                    <span class="text-[11px] font-bold uppercase tracking-wide" style="color:#4b5568">{{ __('ui.game_publisher') }}</span>
                    <span class="text-xs font-semibold text-right" style="color:#d1d8e4">{{ $review->publisher }}</span>
                </div>
                @endif
                @if($review->platform)
                <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--cx-border)">
                    <span class="text-[11px] font-bold uppercase tracking-wide" style="color:#4b5568">{{ __('ui.game_platform') }}</span>
                    <span class="cx-badge" style="background:var(--cx-surf); color:#8899aa; border:1px solid var(--cx-border)">{{ $review->platform }}</span>
                </div>
                @endif
                @if($review->release_date)
                <div class="flex items-center justify-between py-2.5">
                    <span class="text-[11px] font-bold uppercase tracking-wide" style="color:#4b5568">{{ __('ui.game_release') }}</span>
                    <span class="text-xs font-semibold" style="color:#d1d8e4">{{ $review->release_date->format('d M Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Related --}}
        @if($related->isNotEmpty())
        <div class="cx-widget">
            <div class="cx-widget-header">
                <i class="fa-solid fa-film text-[10px]"></i>
                {{ __('ui.more_reviews') }}
            </div>
            <div class="p-3 space-y-1">
                @foreach($related as $r)
                    @php
                        $rs = (float)$r->score;
                        $rc = $rs >= 9 ? '#16a34a' : ($rs >= 7 ? '#ca8a04' : ($rs >= 5 ? '#c2410c' : '#991b1b'));
                    @endphp
                    <a href="{{ route('reviews.show', $r->slug) }}"
                       class="flex gap-3 rounded p-2.5 group transition-all"
                       style="border:1px solid transparent"
                       onmouseenter="this.style.background='rgba(202,138,4,.05)'; this.style.borderColor='rgba(202,138,4,.2)'"
                       onmouseleave="this.style.background='transparent'; this.style.borderColor='transparent'">
                        @if($r->image)
                            <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->game }}"
                                 class="w-12 h-12 rounded object-cover flex-shrink-0">
                        @else
                            <div class="w-12 h-12 rounded flex-shrink-0 flex items-center justify-center text-xl" style="background:var(--cx-card)">🎮</div>
                        @endif
                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                            <p class="text-[10px] font-black uppercase truncate" style="color:var(--cx-amber)">{{ $r->game }}</p>
                            <p class="text-[#d1d8e4] text-xs font-semibold leading-snug group-hover:text-white transition-colors line-clamp-2">{{ $r->title }}</p>
                        </div>
                        <div class="flex-shrink-0 w-9 h-9 rounded flex flex-col items-center justify-center font-black text-sm text-white"
                             style="background:{{ $rc }}">
                            {{ $r->score }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </aside>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Animate score donut
        const donut = document.getElementById('scoreDonut');
        if (donut) {
            requestAnimationFrame(() => {
                setTimeout(() => donut.style.setProperty('--pct', {{ $pct }}), 100);
            });
        }
        // Animate score bar in hero
        const bar = document.getElementById('scoreBar');
        if (bar) setTimeout(() => { bar.style.width = '{{ $pct }}%'; }, 200);

        // Animate sidebar bars
        document.querySelectorAll('.sidebar-bar').forEach(el => {
            const target = el.style.getPropertyValue('--target');
            setTimeout(() => { el.style.width = target; }, 300);
        });
    });
</script>
@endpush

@endsection
