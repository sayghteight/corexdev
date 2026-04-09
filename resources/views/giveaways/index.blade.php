@extends('layouts.app')
@section('title', __('ui.giveaways_title'))

@section('content')
{{-- Page header --}}
<div style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <p class="cx-section-title mb-2" style="color:var(--cx-amber); --cx-red:var(--cx-amber)">{{ __('ui.giveaways_label') }}</p>
        <h1 class="cx-heading text-3xl font-black text-white">{{ __('ui.giveaways_heading') }}</h1>
        <p class="mt-2" style="color:#4b5568">{{ __('ui.giveaways_desc') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Active --}}
    @if($activeGiveaways->isNotEmpty())
        <div class="flex items-center gap-2 mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ff6b00] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ff6b00]"></span>
            </span>
            <h2 class="text-white font-extrabold text-lg">{{ __('ui.giveaways_active') }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-12">
            @foreach($activeGiveaways as $g)
                <a href="{{ route('giveaways.show', $g->slug) }}"
                   class="rounded-xl overflow-hidden group card-hover flex flex-col"
                   style="background:#111827; border:1px solid rgba(255,107,0,.3)"
                   onmouseenter="this.style.borderColor='rgba(255,107,0,.6)'; this.style.boxShadow='0 0 20px rgba(255,107,0,.12)'"
                   onmouseleave="this.style.borderColor='rgba(255,107,0,.3)'; this.style.boxShadow='none'">
                    <div class="relative overflow-hidden">
                        @if($g->image)
                            <img src="{{ asset('storage/' . $g->image) }}" alt="{{ $g->title }}"
                                 class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-44 flex items-center justify-center text-5xl"
                                 style="background:linear-gradient(135deg,rgba(255,107,0,.1),#0a0e1a)">🎁</div>
                        @endif
                        <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(17,24,39,.85) 0%,transparent 55%)"></div>
                        <span class="absolute top-3 right-3 px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-full text-white"
                              style="background:rgba(255,107,0,.9); backdrop-filter:blur(4px)">{{ __('ui.giveaway_badge_ongoing') }}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-white font-bold text-sm group-hover:text-[#ff6b00] transition-colors line-clamp-2 flex-1">{{ $g->title }}</h3>
                        <div class="mt-3 pt-3 border-t border-[#1e2a3a] flex items-center justify-between">
                            <span class="text-[#ffd700] text-xs font-semibold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 010 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 010-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"/><path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"/></svg>
                                {{ $g->prize }}
                            </span>
                            <span class="text-gray-600 text-xs">{{ __('ui.giveaway_until') }}{{ $g->end_date->format('d M') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Upcoming --}}
    @if($upcomingGiveaways->isNotEmpty())
        <h2 class="text-gray-300 font-bold text-lg mb-4">{{ __('ui.giveaways_upcoming') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-12">
            @foreach($upcomingGiveaways as $g)
                <a href="{{ route('giveaways.show', $g->slug) }}"
                   class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden group card-hover opacity-80 hover:opacity-100">
                    @if($g->image)
                        <img src="{{ asset('storage/' . $g->image) }}" alt="{{ $g->title }}"
                             class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-[#111827] flex items-center justify-center text-4xl">🎁</div>
                    @endif
                    <div class="p-4">
                        <span class="inline-block px-2 py-0.5 text-xs font-bold bg-[#1e2a3a] text-gray-400 rounded uppercase mb-2">{{ __('ui.giveaway_badge_soon') }}</span>
                        <h3 class="text-white font-bold text-sm group-hover:text-[#00d4ff] transition-colors line-clamp-2">{{ $g->title }}</h3>
                        <p class="text-[#ffd700] text-xs font-semibold mt-1">🏆 {{ $g->prize }}</p>
                        <p class="text-gray-500 text-xs mt-1">{{ __('ui.giveaway_starts') }} {{ $g->start_date->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Ended --}}
    @if($endedGiveaways->isNotEmpty())
        <h2 class="text-gray-500 font-bold text-lg mb-4">{{ __('ui.giveaways_ended') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 opacity-50">
            @foreach($endedGiveaways as $g)
                <div class="bg-[#111827] border border-[#1e2a3a] rounded-lg p-4">
                    <span class="text-xs font-bold text-gray-500 uppercase">{{ __('ui.giveaway_badge_ended') }}</span>
                    <p class="text-gray-400 font-semibold text-sm mt-1 line-clamp-2">{{ $g->title }}</p>
                    <p class="text-gray-600 text-xs mt-1">{{ $g->end_date->format('d M Y') }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $endedGiveaways->links() }}</div>
    @endif

    @if($activeGiveaways->isEmpty() && $upcomingGiveaways->isEmpty() && $endedGiveaways->isEmpty())
        <div class="text-center py-20">
            <p class="text-5xl mb-4">🎁</p>
            <p class="text-gray-400">{{ __('ui.no_giveaways') }}</p>
        </div>
    @endif
</div>
@endsection
