@extends('layouts.admin')
@section('title', 'Estadísticas — Admin')
@section('breadcrumb', 'Estadísticas')

@push('styles')
<style>
    .stat-card { background:#111827; border:1px solid #1e2a3a; }
    .stat-card:hover { border-color:#00d4ff33; box-shadow:0 0 20px #00d4ff10; }
    .cx-chart-wrap { position:relative; height:280px; }
</style>
@endpush

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-white">Estadísticas</h1>
        <p class="text-gray-500 text-sm mt-0.5">Visitas y lecturas de artículos</p>
    </div>
    <span class="text-xs px-3 py-1.5 rounded-lg" style="background:#111827; border:1px solid #1e2a3a; color:#4b5568">
        <i class="fa-solid fa-calendar text-[9px] mr-1"></i>
        Datos de los últimos 30 días
    </span>
</div>

{{-- ── Summary cards ────────────────────────────────────────── --}}
@php
    $summaryCards = [
        ['label' => 'Total visitas',    'value' => number_format($totalViews),     'icon' => 'fa-solid fa-eye',          'color' => '#00d4ff'],
        ['label' => 'Hoy',              'value' => number_format($viewsToday),     'icon' => 'fa-solid fa-sun',          'color' => '#ffd700'],
        ['label' => 'Esta semana',      'value' => number_format($viewsThisWeek),  'icon' => 'fa-solid fa-calendar-week','color' => '#8b5cf6'],
        ['label' => 'Este mes',         'value' => number_format($viewsThisMonth), 'icon' => 'fa-solid fa-calendar',     'color' => '#22c55e'],
    ];
@endphp
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
    @foreach($summaryCards as $c)
        <div class="stat-card rounded-xl p-5 text-center transition-all">
            <div class="w-11 h-11 rounded-xl mx-auto mb-3 flex items-center justify-center"
                 style="background:{{ $c['color'] }}18; border:1px solid {{ $c['color'] }}30">
                <i class="{{ $c['icon'] }} text-base" style="color:{{ $c['color'] }}"></i>
            </div>
            <p class="text-3xl font-black" style="color:{{ $c['color'] }}">{{ $c['value'] }}</p>
            <p class="text-gray-500 text-xs mt-1 font-medium uppercase tracking-wide">{{ $c['label'] }}</p>
        </div>
    @endforeach
</div>

{{-- ── Chart row ────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

    {{-- Daily visits line chart --}}
    <div class="lg:col-span-2 stat-card rounded-xl p-5">
        <div class="flex items-center gap-2 mb-5">
            <div class="w-1 h-4 rounded-full" style="background:#00d4ff"></div>
            <h2 class="text-white font-bold text-sm">Visitas diarias (últimos 30 días)</h2>
        </div>
        <div class="cx-chart-wrap">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    {{-- Views by category doughnut --}}
    <div class="stat-card rounded-xl p-5">
        <div class="flex items-center gap-2 mb-5">
            <div class="w-1 h-4 rounded-full" style="background:#8b5cf6"></div>
            <h2 class="text-white font-bold text-sm">Visitas por categoría</h2>
        </div>
        @if($catData->sum() > 0)
            <div class="cx-chart-wrap flex items-center justify-center" style="height:220px">
                <canvas id="catChart"></canvas>
            </div>
        @else
            <div class="text-center py-16" style="color:#4b5568">
                <i class="fa-solid fa-chart-pie text-2xl mb-2 block"></i>
                <p class="text-xs">Sin datos todavía</p>
            </div>
        @endif
    </div>

</div>

{{-- ── Tables row ───────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Top posts last 30 days --}}
    <div class="stat-card rounded-xl overflow-hidden">
        <div class="px-5 py-3.5 flex items-center justify-between" style="border-bottom:1px solid #1e2a3a">
            <div class="flex items-center gap-2">
                <div class="w-1 h-4 rounded-full" style="background:#ffd700"></div>
                <h2 class="text-white font-bold text-sm">Top artículos (30 días)</h2>
            </div>
        </div>
        @if($topRecent->isEmpty())
            <div class="text-center py-10" style="color:#4b5568">
                <i class="fa-solid fa-chart-bar text-xl mb-2 block"></i>
                <p class="text-xs">Sin visitas registradas todavía.</p>
            </div>
        @else
            <div class="divide-y" style="border-color:#1e2a3a">
                @foreach($topRecent as $i => $p)
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-[#0a0e1a]/40 transition-colors">
                        <span class="w-5 text-center text-xs font-bold flex-shrink-0"
                              style="color:{{ $i === 0 ? '#ffd700' : ($i === 1 ? '#c0c0c0' : ($i === 2 ? '#cd7f32' : '#4b5568')) }}">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('posts.show', $p->slug) }}" target="_blank"
                               class="text-sm text-white/80 hover:text-white hover:underline line-clamp-1 transition-colors">
                                {{ $p->title }}
                            </a>
                            <span class="text-[10px]" style="color:#4b5568">
                                {{ $p->type === 'guide' ? 'Guía' : 'Noticia' }}
                            </span>
                        </div>
                        <span class="text-xs font-bold flex-shrink-0 flex items-center gap-1" style="color:#00d4ff">
                            <i class="fa-solid fa-eye text-[9px]"></i>
                            {{ number_format($p->period_views) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Top all-time --}}
    <div class="stat-card rounded-xl overflow-hidden">
        <div class="px-5 py-3.5 flex items-center justify-between" style="border-bottom:1px solid #1e2a3a">
            <div class="flex items-center gap-2">
                <div class="w-1 h-4 rounded-full" style="background:#22c55e"></div>
                <h2 class="text-white font-bold text-sm">Top artículos (total histórico)</h2>
            </div>
        </div>
        @if($topPosts->isEmpty())
            <div class="text-center py-10" style="color:#4b5568">
                <i class="fa-solid fa-trophy text-xl mb-2 block"></i>
                <p class="text-xs">Sin artículos publicados todavía.</p>
            </div>
        @else
            <div class="divide-y" style="border-color:#1e2a3a">
                @foreach($topPosts as $i => $p)
                    <div class="flex items-center gap-3 px-5 py-3 hover:bg-[#0a0e1a]/40 transition-colors">
                        <span class="w-5 text-center text-xs font-bold flex-shrink-0"
                              style="color:{{ $i === 0 ? '#ffd700' : ($i === 1 ? '#c0c0c0' : ($i === 2 ? '#cd7f32' : '#4b5568')) }}">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('posts.show', $p->slug) }}" target="_blank"
                               class="text-sm text-white/80 hover:text-white hover:underline line-clamp-1 transition-colors">
                                {{ $p->title }}
                            </a>
                            <span class="text-[10px]" style="color:#4b5568">
                                {{ $p->category?->name }} · {{ $p->type === 'guide' ? 'Guía' : 'Noticia' }}
                            </span>
                        </div>
                        <span class="text-xs font-bold flex-shrink-0 flex items-center gap-1" style="color:#22c55e">
                            <i class="fa-solid fa-eye text-[9px]"></i>
                            {{ number_format($p->views) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
    Chart.defaults.color = '#4b5568';
    Chart.defaults.borderColor = '#1e2a3a';

    // ── Daily line chart ─────────────────────────────────────
    const dailyCtx = document.getElementById('dailyChart');
    if (dailyCtx) {
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: @json($dailyLabels),
                datasets: [{
                    label: 'Visitas',
                    data: @json($dailyData),
                    borderColor: '#00d4ff',
                    backgroundColor: 'rgba(0,212,255,0.07)',
                    borderWidth: 2,
                    pointBackgroundColor: '#00d4ff',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        ticks: { maxTicksLimit: 8, font: { size: 10 } },
                        grid: { color: '#1e2a3a' },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { size: 10 } },
                        grid: { color: '#1e2a3a' },
                    },
                },
            },
        });
    }

    // ── Doughnut category chart ──────────────────────────────
    const catCtx = document.getElementById('catChart');
    if (catCtx) {
        const catLabels = @json($catLabels);
        const catData   = @json($catData);
        const catColors = @json($catColors);

        if (catData.reduce((a, b) => a + b, 0) > 0) {
            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catData,
                        backgroundColor: catColors.map(c => c + '99'),
                        borderColor: catColors,
                        borderWidth: 2,
                        hoverOffset: 6,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 10 }, padding: 10, boxWidth: 10 },
                        },
                    },
                    cutout: '65%',
                },
            });
        }
    }
})();
</script>
@endpush
