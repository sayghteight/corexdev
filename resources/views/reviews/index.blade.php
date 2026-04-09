@extends('layouts.app')
@section('title', __('ui.reviews_title'))

@push('styles')
<style>
    /* Score color helpers */
    .score-great  { background:#16a34a; color:#fff; box-shadow:0 0 18px rgba(22,163,74,.4); }
    .score-good   { background:#ca8a04; color:#fff; box-shadow:0 0 18px rgba(202,138,4,.4); }
    .score-avg    { background:#c2410c; color:#fff; box-shadow:0 0 18px rgba(194,65,12,.4); }
    .score-bad    { background:#991b1b; color:#fff; box-shadow:0 0 18px rgba(153,27,27,.4); }

    /* Score progress bar */
    .score-bar-fill { height:4px; border-radius:4px; transition: width .8s cubic-bezier(.4,0,.2,1); }

    /* Feature card badge */
    .verdict-badge {
        display:inline-flex; align-items:center; gap:5px;
        padding:3px 10px; border-radius:3px;
        font-size:.6rem; font-weight:900; letter-spacing:.12em; text-transform:uppercase;
    }
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER ──────────────────────────────────────────────────────── --}}
<div style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
    <div class="max-w-7xl mx-auto px-4 py-10 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="cx-section-title mb-2" style="color:var(--cx-amber); --cx-red:var(--cx-amber)">{{ __('ui.reviews_label') }}</p>
            <h1 class="cx-heading text-3xl font-black text-white">{{ __('ui.reviews_heading') }}</h1>
            <p class="mt-1.5 text-sm" style="color:#4b5568">{{ __('ui.reviews_desc') }}</p>
        </div>
        {{-- Score legend --}}
        <div class="hidden md:flex items-center gap-3 text-[11px] font-bold">
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm inline-block bg-[#16a34a]"></span><span style="color:#4b5568">9-10 &middot; {{ __('ui.score_essential') }}</span></div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm inline-block bg-[#ca8a04]"></span><span style="color:#4b5568">7-8 &middot; {{ __('ui.score_recommended') }}</span></div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm inline-block bg-[#c2410c]"></span><span style="color:#4b5568">5-6 &middot; {{ __('ui.score_average') }}</span></div>
            <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm inline-block bg-[#991b1b]"></span><span style="color:#4b5568">&lt;5 &middot; {{ __('ui.score_bad') }}</span></div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
@if($reviews->isNotEmpty())

    {{-- ── FEATURED REVIEW (first) ─────────────────────────────────────── --}}
    @php
        $featured = $reviews->first();
        $rest     = $reviews->skip(1);
        function scoreClass($s) {
            $s = (float)$s;
            if ($s >= 9)  return ['cls'=>'score-great', 'label'=>__('ui.score_essential'), 'bar'=>'#16a34a'];
            if ($s >= 7)  return ['cls'=>'score-good',  'label'=>__('ui.score_recommended'), 'bar'=>'#ca8a04'];
            if ($s >= 5)  return ['cls'=>'score-avg',   'label'=>__('ui.score_average'), 'bar'=>'#c2410c'];
            return            ['cls'=>'score-bad',   'label'=>__('ui.score_bad'), 'bar'=>'#991b1b'];
        }
        $fi = scoreClass($featured->score);
    @endphp

    <a href="{{ route('reviews.show', $featured->slug) }}"
       class="group flex flex-col md:flex-row rounded-lg overflow-hidden mb-10 transition-all"
       style="background:var(--cx-card); border:1px solid var(--cx-border)"
       onmouseenter="this.style.borderColor='rgba(202,138,4,.4)'"
       onmouseleave="this.style.borderColor='var(--cx-border)'">

        {{-- Image --}}
        <div class="relative overflow-hidden md:w-[55%] flex-shrink-0" style="min-height:280px">
            @if($featured->image)
                <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->game }}"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            @else
                <div class="absolute inset-0 cx-grid-bg flex items-center justify-center text-7xl" style="background:var(--cx-bg)">🎮</div>
            @endif
            <div class="absolute inset-0" style="background:linear-gradient(to right, transparent 40%, var(--cx-card) 100%)"></div>
            <div class="absolute inset-0 md:hidden" style="background:linear-gradient(to top, var(--cx-card) 0%, transparent 60%)"></div>

            {{-- Platform badge --}}
            @if($featured->platform)
                <span class="absolute top-3 left-3 cx-badge" style="background:rgba(11,13,17,.85); color:#8899aa; border:1px solid var(--cx-border); backdrop-filter:blur(4px)">
                    <i class="fa-solid fa-gamepad text-[8px]"></i> {{ $featured->platform }}
                </span>
            @endif

            {{-- FEATURED label --}}
            <span class="absolute top-3 right-3 cx-badge cx-badge-red">
                <i class="fa-solid fa-star text-[8px]"></i> {{ __('ui.review_feat_badge') }}
            </span>
        </div>

        {{-- Content --}}
        <div class="flex flex-col justify-center p-7 md:w-[45%]">
            <p class="text-[11px] font-black uppercase tracking-widest mb-1" style="color:var(--cx-amber)">{{ $featured->game }}</p>
            <h2 class="cx-heading text-white font-black text-2xl leading-snug group-hover:text-[#f0c040] transition-colors line-clamp-3 mb-4">
                {{ $featured->title }}
            </h2>
            @if($featured->excerpt)
                <p class="text-sm line-clamp-3 mb-5" style="color:#4b5568">{{ $featured->excerpt }}</p>
            @endif

            {{-- Score row --}}
            <div class="flex items-center gap-4">
                {{-- Big score circle --}}
                <div class="w-16 h-16 rounded-lg flex flex-col items-center justify-center flex-shrink-0 {{ $fi['cls'] }}">
                    <span class="font-black text-2xl leading-none">{{ $featured->score }}</span>
                    <span class="text-[9px] font-bold opacity-80 leading-none mt-0.5">/10</span>
                </div>
                <div>
                    <p class="text-white font-black text-sm">{{ $fi['label'] }}</p>
                    {{-- Score bar --}}
                    <div class="w-36 mt-2 rounded-full overflow-hidden" style="height:4px; background:var(--cx-border)">
                        <div class="score-bar-fill" style="width:{{ ($featured->score / 10) * 100 }}%; background:{{ $fi['bar'] }}"></div>
                    </div>
                    <p class="text-[11px] mt-1.5" style="color:#4b5568">{{ $featured->published_at?->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </a>

    {{-- ── REVIEWS GRID ─────────────────────────────────────────────────── --}}
    @if($rest->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($rest as $review)
            @php $ri = scoreClass($review->score); @endphp
            <a href="{{ route('reviews.show', $review->slug) }}"
               class="group rounded-lg overflow-hidden flex flex-col transition-all"
               style="background:var(--cx-card); border:1px solid var(--cx-border)"
               onmouseenter="this.style.borderColor='rgba(202,138,4,.35)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 28px rgba(0,0,0,.4)'"
               onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">

                {{-- Cover --}}
                <div class="relative overflow-hidden" style="height:190px">
                    @if($review->image)
                        <img src="{{ asset('storage/' . $review->image) }}" alt="{{ $review->game }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @else
                        <div class="w-full h-full cx-grid-bg flex items-center justify-center text-4xl" style="background:var(--cx-bg)">🎮</div>
                    @endif
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(22,27,35,.95) 0%, transparent 55%)"></div>

                    {{-- Score badge (bottom-right) --}}
                    <div class="absolute bottom-2.5 right-2.5 w-11 h-11 rounded-md flex flex-col items-center justify-center {{ $ri['cls'] }}">
                        <span class="font-black text-base leading-none">{{ $review->score }}</span>
                        <span class="text-[8px] opacity-75">/10</span>
                    </div>

                    {{-- Platform (bottom-left) --}}
                    @if($review->platform)
                        <span class="absolute bottom-2.5 left-2.5 cx-badge" style="background:rgba(11,13,17,.85); color:#8899aa; border:1px solid var(--cx-border)">
                            {{ $review->platform }}
                        </span>
                    @endif
                </div>

                {{-- Body --}}
                <div class="p-4 flex flex-col flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest mb-1" style="color:var(--cx-amber)">{{ $review->game }}</p>
                    <h3 class="cx-heading text-[#d1d8e4] font-bold text-sm leading-snug group-hover:text-white transition-colors line-clamp-2 flex-1">
                        {{ $review->title }}
                    </h3>

                    {{-- Verdict + date --}}
                    <div class="flex items-center justify-between mt-3 pt-3" style="border-top:1px solid var(--cx-border)">
                        <span class="verdict-badge {{ $ri['cls'] }}">{{ $ri['label'] }}</span>
                        <span class="text-[11px]" style="color:#3a4859">{{ $review->published_at?->diffForHumans() }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @endif

    <div class="mt-10">{{ $reviews->links() }}</div>

@else
    <div class="text-center py-24">
        <div class="w-20 h-20 rounded-lg mx-auto mb-5 flex items-center justify-center" style="background:var(--cx-card); border:1px solid var(--cx-border)">
            <i class="fa-solid fa-star text-3xl" style="color:#2d3748"></i>
        </div>
        <p class="font-semibold mb-1" style="color:#4b5568">{{ __('ui.no_reviews_yet') }}</p>
        <p class="text-sm" style="color:#2d3748">{{ __('ui.no_reviews_sub') }}</p>
    </div>
@endif
</div>
@endsection
