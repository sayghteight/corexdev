@extends('layouts.app')
@section('title', __('ui.legal_privacy_title') . ' — Corex-Dev')
@section('description', 'Corex-Dev — ' . __('ui.legal_privacy_title'))

@push('styles')
<style>
    .legal-section { border-left: 3px solid var(--cx-blue); padding-left: 1.25rem; margin-bottom: 2.5rem; }
    .legal-section h2 { font-size: 1.05rem; font-weight: 800; color: #d1d8e4; margin-bottom: .75rem; text-transform: uppercase; letter-spacing: .05em; }
    .legal-section p, .legal-section li { font-size: .9rem; line-height: 1.8; color: #6b7a90; }
    .legal-section ul { list-style: none; padding: 0; }
    .legal-section ul li { padding-left: 1.25rem; position: relative; margin-bottom: .4rem; }
    .legal-section ul li::before { content: ''; position: absolute; left: 0; top: .7rem; width: 5px; height: 5px; border-radius: 50%; background: var(--cx-blue); }
    .legal-section a { color: var(--cx-blue); text-decoration: none; }
    .legal-section a:hover { text-decoration: underline; }
    .data-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    .data-table th { text-align: left; padding: 8px 12px; font-size: .7rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--cx-blue); border-bottom: 1px solid var(--cx-border); }
    .data-table td { padding: 10px 12px; color: #6b7a90; border-bottom: 1px solid rgba(33,41,58,.5); vertical-align: top; }
    .data-table tr:last-child td { border-bottom: none; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-14">

    {{-- Page header --}}
    <div class="mb-10">
        <p class="cx-section-title mb-4" style="color:var(--cx-blue)">
            <span style="background:var(--cx-blue);width:3px;height:18px;border-radius:2px;display:inline-block;flex-shrink:0"></span>
            {{ __('ui.legal_label') }}
        </p>
        <h1 class="cx-heading text-white font-black text-4xl mb-3">{{ __('ui.legal_privacy_title') }}</h1>
        <p class="text-sm" style="color:#4b5568">
            {{ __('ui.legal_updated') }}: {{ \Carbon\Carbon::now()->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
        </p>
        <div class="mt-4 p-4 rounded-lg text-sm" style="background:rgba(59,158,221,.07); border:1px solid rgba(59,158,221,.2); color:#8899aa">
            <i class="fa fa-shield-halved mr-2" style="color:var(--cx-blue)"></i>
            {!! __('ui.legal_privacy_notice') !!}
        </div>
    </div>

    {{-- Locale-specific body --}}
    @includeFirst(['legal.' . app()->getLocale() . '.privacy-body', 'legal.es.privacy-body'])

    {{-- Bottom nav --}}
    <div class="flex flex-wrap items-center gap-4 mt-10 pt-6" style="border-top:1px solid var(--cx-border)">
        <a href="{{ route('legal.terms') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold transition-colors"
           style="color:var(--cx-blue)"
           onmouseenter="this.style.color='#63b3ed'"
           onmouseleave="this.style.color='var(--cx-blue)'">
            <i class="fa fa-file-lines text-xs"></i>
            {{ __('ui.go_to_terms') }}
        </a>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 text-sm transition-colors"
           style="color:#4b5568"
           onmouseenter="this.style.color='#d1d8e4'"
           onmouseleave="this.style.color='#4b5568'">
            <i class="fa fa-arrow-left text-xs"></i>
            {{ __('ui.back_to_home') }}
        </a>
    </div>
</div>
@endsection
