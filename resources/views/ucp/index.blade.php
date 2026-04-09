@extends('layouts.app')
@section('title', __('ui.ucp_title'))
@section('content')

{{-- Page hero bar --}}
<div class="border-b border-[var(--cx-border)]" style="background: linear-gradient(135deg, rgba(232,57,42,.08) 0%, rgba(11,13,17,0) 60%);">
    <div class="max-w-5xl mx-auto px-4 py-6 flex items-center gap-3">
        <div class="cx-section-title text-base">{{ __('ui.ucp_title') }}</div>
        <span class="text-[var(--cx-muted)] text-sm">/</span>
        <span class="text-[var(--cx-muted)] text-sm">{{ __('ui.ucp_panel_sub') }}</span>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">

        {{-- Sidebar --}}
        <div class="w-full md:w-52 flex-shrink-0">
            @include('ucp.partials.sidebar')
        </div>

        {{-- Main --}}
        <div class="flex-1 min-w-0 space-y-5">

            {{-- Welcome banner --}}
            <div class="cx-card overflow-hidden">
                <div class="h-1.5 w-full" style="background: linear-gradient(90deg, var(--cx-red), #ff6b35, var(--cx-red)); background-size: 200%; animation: shiftGrad 6s ease infinite;"></div>
                <div class="p-6 flex items-center gap-5">
                    <div class="relative flex-shrink-0">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center font-black text-3xl text-white border-2 border-[var(--cx-red)] shadow-lg"
                             style="background: linear-gradient(135deg, var(--cx-red) 0%, #ff6b35 100%); box-shadow: 0 0 24px rgba(232,57,42,.3);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0.5 right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-[var(--cx-card)]"></span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl font-extrabold text-white leading-tight">{{ __('ui.ucp_hello') }} {{ $user->name }}!</h1>
                        <p class="text-[var(--cx-muted)] text-sm mt-0.5">{{ $user->email }}</p>
                        <p class="text-[var(--cx-muted)] text-xs mt-1 opacity-60">
                            <i class="fa-regular fa-clock mr-1"></i>{{ __('ui.ucp_member_since') }} {{ $user->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if($user->is_admin)
                        <div class="flex-shrink-0">
                            <span class="cx-badge" style="background: rgba(232,57,42,.15); color: var(--cx-red); border: 1px solid rgba(232,57,42,.4);">
                                <i class="fa-solid fa-bolt mr-1 text-[9px]"></i> Admin
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('ucp.profile') }}" class="cx-card p-5 group cursor-pointer block" style="transition: all .2s;">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: rgba(232,57,42,.12); border: 1px solid rgba(232,57,42,.25);">
                            <i class="fa-solid fa-pen-to-square text-sm" style="color: var(--cx-red);"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-white font-semibold text-sm group-hover:text-[var(--cx-red)] transition-colors">{{ __('ui.ucp_edit_profile') }}</div>
                            <div class="text-[var(--cx-muted)] text-xs mt-0.5">{{ __('ui.ucp_edit_profile_desc') }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-right ml-auto text-[10px] text-[var(--cx-muted)] opacity-0 group-hover:opacity-100 transition-opacity self-center"></i>
                    </div>
                </a>

                <a href="{{ route('ucp.security') }}" class="cx-card p-5 group cursor-pointer block" style="transition: all .2s;">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: rgba(139,92,246,.12); border: 1px solid rgba(139,92,246,.25);">
                            <i class="fa-solid fa-shield-halved text-sm text-purple-400"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-white font-semibold text-sm group-hover:text-purple-400 transition-colors">{{ __('ui.ucp_security') }}</div>
                            <div class="text-[var(--cx-muted)] text-xs mt-0.5">{{ __('ui.ucp_security_desc') }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-right ml-auto text-[10px] text-[var(--cx-muted)] opacity-0 group-hover:opacity-100 transition-opacity self-center"></i>
                    </div>
                </a>

                <a href="{{ route('posts.index') }}" class="cx-card p-5 group cursor-pointer block" style="transition: all .2s;">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: rgba(59,158,221,.12); border: 1px solid rgba(59,158,221,.25);">
                            <i class="fa-solid fa-newspaper text-sm" style="color: var(--cx-blue);"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-white font-semibold text-sm group-hover:text-[var(--cx-blue)] transition-colors">{{ __('ui.ucp_browse_news') }}</div>
                            <div class="text-[var(--cx-muted)] text-xs mt-0.5">{{ __('ui.ucp_browse_news_desc') }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-right ml-auto text-[10px] text-[var(--cx-muted)] opacity-0 group-hover:opacity-100 transition-opacity self-center"></i>
                    </div>
                </a>

                <a href="{{ route('giveaways.index') }}" class="cx-card p-5 group cursor-pointer block" style="transition: all .2s;">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: rgba(245,158,11,.12); border: 1px solid rgba(245,158,11,.25);">
                            <i class="fa-solid fa-gift text-sm" style="color: var(--cx-amber);"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-white font-semibold text-sm group-hover:text-[var(--cx-amber)] transition-colors">{{ __('ui.ucp_giveaways_action') }}</div>
                            <div class="text-[var(--cx-muted)] text-xs mt-0.5">{{ __('ui.ucp_giveaways_action_desc') }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-right ml-auto text-[10px] text-[var(--cx-muted)] opacity-0 group-hover:opacity-100 transition-opacity self-center"></i>
                    </div>
                </a>
            </div>

            {{-- Account info --}}
            <div class="cx-card overflow-hidden">
                <div class="px-5 py-4 border-b border-[var(--cx-border)]">
                    <div class="cx-section-title text-xs">{{ __('ui.ucp_account_info') }}</div>
                </div>
                <dl class="divide-y divide-[var(--cx-border)]">
                    <div class="flex items-center justify-between px-5 py-3">
                        <dt class="text-[var(--cx-muted)] text-sm flex items-center gap-2">
                            <i class="fa-solid fa-user w-3.5 text-center text-xs opacity-60"></i> {{ __('ui.ucp_name') }}
                        </dt>
                        <dd class="text-white text-sm font-medium">{{ $user->name }}</dd>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3">
                        <dt class="text-[var(--cx-muted)] text-sm flex items-center gap-2">
                            <i class="fa-solid fa-envelope w-3.5 text-center text-xs opacity-60"></i> {{ __('ui.ucp_email') }}
                        </dt>
                        <dd class="text-white text-sm font-medium">{{ $user->email }}</dd>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3">
                        <dt class="text-[var(--cx-muted)] text-sm flex items-center gap-2">
                            <i class="fa-solid fa-circle-check w-3.5 text-center text-xs opacity-60"></i> {{ __('ui.ucp_verified') }}
                        </dt>
                        <dd>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-400">
                                    <i class="fa-solid fa-check"></i> {{ __('ui.ucp_verified_badge') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-yellow-400">
                                    <i class="fa-solid fa-triangle-exclamation"></i> {{ __('ui.ucp_unverified_badge') }}
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3">
                        <dt class="text-[var(--cx-muted)] text-sm flex items-center gap-2">
                            <i class="fa-regular fa-calendar w-3.5 text-center text-xs opacity-60"></i> {{ __('ui.ucp_registered') }}
                        </dt>
                        <dd class="text-[var(--cx-muted)] text-xs">{{ $user->created_at->format('d/m/Y') }}</dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</div>
@endsection
