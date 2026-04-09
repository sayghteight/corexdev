@extends('layouts.app')
@section('title', __('ui.events_title'))

@section('content')
{{-- Page header --}}
<div style="background:var(--cx-surf); border-bottom:1px solid var(--cx-border)">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <p class="cx-section-title mb-2">{{ __('ui.events_label') }}</p>
        <h1 class="cx-heading text-3xl font-black text-white">{{ __('ui.events_heading') }}</h1>
        <p class="mt-2" style="color:#4b5568">{{ __('ui.events_desc') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    {{-- Upcoming events --}}
    <div class="flex items-center gap-2 mb-6">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00d4ff] opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#00d4ff]"></span>
        </span>
        <h2 class="text-white font-extrabold text-lg">{{ __('ui.events_upcoming') }}</h2>
    </div>
    @if($upcomingEvents->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">
            @foreach($upcomingEvents as $event)
                <a href="{{ route('events.show', $event->slug) }}"
                   class="rounded-xl overflow-hidden group card-hover"
                   style="background:#111827; border:1px solid #1e2a3a"
                   onmouseenter="this.style.borderColor='rgba(0,212,255,.3)'"
                   onmouseleave="this.style.borderColor='#1e2a3a'">
                    <div class="relative overflow-hidden">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                                 class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-40 flex items-center justify-center text-4xl"
                                 style="background:linear-gradient(135deg,#111827,#0a0e1a)">🎮</div>
                        @endif
                        <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(17,24,39,.8) 0%,transparent 60%)"></div>
                        <div class="absolute bottom-3 left-3">
                            @php
                                $typeColors = ['launch'=>'#00d4ff','expansion'=>'#8b5cf6','demo'=>'#22c55e','update'=>'#f59e0b','sale'=>'#ff6b00','event'=>'#ec4899'];
                                $typeLabels = ['launch' => __('ui.event_type_launch'), 'expansion' => __('ui.event_type_expansion'), 'demo' => __('ui.event_type_demo'), 'update' => __('ui.event_type_update'), 'sale' => __('ui.event_type_sale'), 'event' => __('ui.event_type_event')];
                            @endphp
                            <span class="px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider rounded"
                                  style="background:{{ ($typeColors[$event->type] ?? '#00d4ff') }}25; color:{{ $typeColors[$event->type] ?? '#00d4ff' }}; border:1px solid {{ ($typeColors[$event->type] ?? '#00d4ff') }}50; backdrop-filter:blur(4px)">
                                {{ $typeLabels[$event->type] ?? $event->type }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-white font-bold text-sm group-hover:text-[#00d4ff] transition-colors line-clamp-2">{{ $event->name }}</h3>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                @if($event->platform)
                                    <p class="text-gray-600 text-xs">{{ $event->platform }}</p>
                                @endif
                                <p class="text-gray-500 text-xs">{{ $event->event_date->format('d M Y') }}</p>
                            </div>
                            <p class="text-[#00d4ff] font-mono text-xs font-bold"
                               x-data="liveCountdown('{{ $event->event_date->toISOString() }}')"
                               x-text="time">—</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-4">{{ $upcomingEvents->links() }}</div>
    @else
        <p class="text-gray-500 py-8">{{ __('ui.no_events') }}</p>
    @endif

    {{-- Past events --}}
    @if($pastEvents->isNotEmpty())
        <h2 class="text-white text-xl font-bold mb-4 mt-12">{{ __('ui.events_past') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($pastEvents as $event)
                <a href="{{ route('events.show', $event->slug) }}"
                   class="flex gap-3 bg-[#111827]/60 border border-[#1e2a3a] rounded-lg p-3 hover:border-[#1e2a3a] group opacity-60 hover:opacity-100 transition-all">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                             class="w-14 h-14 object-cover rounded flex-shrink-0">
                    @else
                        <div class="w-14 h-14 bg-[#1e2a3a] rounded flex-shrink-0 flex items-center justify-center text-xl">🎮</div>
                    @endif
                    <div>
                        <p class="text-gray-400 text-xs">{{ $event->event_date->format('d M Y') }}</p>
                        <p class="text-gray-300 text-sm font-semibold line-clamp-2">{{ $event->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function countdown(isoDate) {
    const diff = new Date(isoDate) - new Date();
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
