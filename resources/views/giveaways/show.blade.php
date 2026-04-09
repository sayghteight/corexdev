@extends('layouts.app')
@section('title', $giveaway->title . ' — Corex-Dev')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <nav class="text-xs text-gray-500 mb-6 flex gap-2">
        <a href="{{ route('home') }}" class="hover:text-[#00d4ff]">{{ __('ui.breadcrumb_home') }}</a>/<a href="{{ route('giveaways.index') }}" class="hover:text-[#00d4ff]">{{ __('ui.breadcrumb_giveaways') }}</a>/<span>{{ $giveaway->title }}</span>
    </nav>

    @if($giveaway->image)
        <img src="{{ asset('storage/' . $giveaway->image) }}" alt="{{ $giveaway->title }}"
             class="w-full h-64 object-cover rounded-xl mb-8">
    @endif

    <div class="flex flex-wrap items-center gap-3 mb-4">
        @php
            $statusColor = ['active' => '#ff6b00', 'upcoming' => '#00d4ff', 'ended' => '#6b7280'];
            $statusLabel = ['active' => __('ui.giveaway_status_active'), 'upcoming' => __('ui.giveaway_status_upcoming'), 'ended' => __('ui.giveaway_status_ended')];
        @endphp
        <span class="text-xs font-bold uppercase px-3 py-1 rounded border"
              style="color: {{ $statusColor[$giveaway->status] ?? '#fff' }}; border-color: {{ $statusColor[$giveaway->status] ?? '#fff' }}40; background-color: {{ $statusColor[$giveaway->status] ?? '#fff' }}15">
            {{ $statusLabel[$giveaway->status] ?? $giveaway->status }}
        </span>
    </div>

    <h1 class="text-3xl font-extrabold text-white mb-3">{{ $giveaway->title }}</h1>

    <div class="bg-[#111827] border border-[#ff6b00]/30 rounded-xl p-5 mb-6">
        <p class="text-gray-400 text-sm mb-1">{{ __('ui.giveaway_prize_label') }}</p>
        <p class="text-[#ffd700] font-extrabold text-xl">🏆 {{ $giveaway->prize }}</p>
        <div class="flex flex-wrap gap-6 mt-4 text-sm text-gray-400">
            <div>
                <p class="text-xs text-gray-500">{{ __('ui.giveaway_start_label') }}</p>
                <p class="text-white font-semibold">{{ $giveaway->start_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">{{ __('ui.giveaway_end_label') }}</p>
                <p class="text-white font-semibold">{{ $giveaway->end_date->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="prose prose-invert max-w-none prose-p:text-gray-300 mb-8">
        <p>{{ $giveaway->description }}</p>
    </div>

    @if($giveaway->participation_url && $giveaway->status === 'active')
        <a href="{{ $giveaway->participation_url }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-8 py-3 bg-[#ff6b00] text-white font-extrabold text-lg rounded-xl hover:bg-orange-500 transition-all shadow-lg shadow-orange-900/30">
            {{ __('ui.giveaway_participate') }}
        </a>
    @endif
</div>
@endsection
