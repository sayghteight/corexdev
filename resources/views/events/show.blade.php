@extends('layouts.app')
@section('title', $event->name . ' — Corex-Dev')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <nav class="text-xs text-gray-500 mb-6 flex gap-2">
        <a href="{{ route('home') }}" class="hover:text-[#00d4ff]">{{ __('ui.breadcrumb_home') }}</a>/<a href="{{ route('events.index') }}" class="hover:text-[#00d4ff]">{{ __('ui.breadcrumb_events') }}</a>/<span>{{ $event->name }}</span>
    </nav>

    @if($event->image)
        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
             class="w-full h-64 object-cover rounded-xl mb-8">
    @endif

    <h1 class="text-3xl font-extrabold text-white mb-4">{{ $event->name }}</h1>

    <div class="flex flex-wrap gap-3 mb-6">
        @php
            $typeColors = ['launch'=>'#00d4ff','expansion'=>'#8b5cf6','demo'=>'#22c55e','update'=>'#f59e0b','sale'=>'#ff6b00','event'=>'#ec4899'];
            $typeLabels = ['launch' => __('ui.event_type_launch'), 'expansion' => __('ui.event_type_expansion'), 'demo' => __('ui.event_type_demo'), 'update' => __('ui.event_type_update'), 'sale' => __('ui.event_type_sale'), 'event' => __('ui.event_type_event')];
        @endphp
        <span class="text-xs font-bold uppercase px-3 py-1 rounded"
              style="background-color: {{ ($typeColors[$event->type] ?? '#00d4ff') }}20; color: {{ $typeColors[$event->type] ?? '#00d4ff' }}; border: 1px solid {{ ($typeColors[$event->type] ?? '#00d4ff') }}40">
            {{ $typeLabels[$event->type] ?? $event->type }}
        </span>
        @if($event->platform) <span class="text-gray-400 text-sm px-3 py-1 bg-[#1e2a3a] rounded">{{ $event->platform }}</span> @endif
        @if($event->game)     <span class="text-gray-400 text-sm px-3 py-1 bg-[#1e2a3a] rounded">🎮 {{ $event->game }}</span>     @endif
    </div>

    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-5 mb-8 flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">{{ __('ui.event_date_label') }}</p>
            <p class="text-white text-xl font-bold">{{ $event->event_date->format('d F Y') }}</p>
        </div>
        <div class="text-right">
            <p class="text-gray-400 text-sm">{{ __('ui.event_countdown_label') }}</p>
            <p class="text-[#00d4ff] font-mono text-lg font-bold"
               x-data="liveCountdown('{{ $event->event_date->toISOString() }}')"
               x-text="time">—</p>
        </div>
    </div>

    @if($event->description)
        <div class="prose prose-invert max-w-none prose-p:text-gray-300">
            <p>{{ $event->description }}</p>
        </div>
    @endif

    @if($event->url)
        <a href="{{ $event->url }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-[#00d4ff] text-[#060910] font-bold rounded hover:bg-cyan-300 transition-all">
            {{ __('ui.event_more_info') }}
        </a>
    @endif

    @if($related->isNotEmpty())
        <section class="mt-12">
            <h3 class="text-white text-xl font-bold mb-5">{{ __('ui.events_upcoming') }}</h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach($related as $e)
                    <a href="{{ route('events.show', $e->slug) }}"
                       class="flex gap-3 bg-[#111827] border border-[#1e2a3a] rounded-lg p-3 hover:border-[#00d4ff]/30 group transition-all">
                        @if($e->image)
                            <img src="{{ asset('storage/' . $e->image) }}" alt="{{ $e->name }}"
                                 class="w-12 h-12 object-cover rounded flex-shrink-0">
                        @else
                            <div class="w-12 h-12 bg-[#1e2a3a] rounded flex-shrink-0 flex items-center justify-center">🎮</div>
                        @endif
                        <div>
                            <p class="text-white text-sm font-semibold group-hover:text-[#00d4ff] transition-colors line-clamp-2">{{ $e->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $e->event_date->format('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
function countdown(isoDate) {
    const diff = new Date(isoDate) - new Date();
    if (diff <= 0) return 'Ya disponible';
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

@push('scripts')
<script>
function countdown(isoDate) {
    const diff = new Date(isoDate) - new Date();
    if (diff <= 0) return 'Ya disponible';
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    return `${d}d ${h}h ${m}m`;
}
</script>
@endpush
