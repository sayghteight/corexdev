@extends('layouts.app')
@section('title', __('ui.ucp_security'))
@section('content')

{{-- Page hero bar --}}
<div class="border-b border-[var(--cx-border)]" style="background: linear-gradient(135deg, rgba(232,57,42,.08) 0%, rgba(11,13,17,0) 60%);">
    <div class="max-w-5xl mx-auto px-4 py-6 flex items-center gap-3">
        <div class="cx-section-title text-base">{{ __('ui.ucp_title') }}</div>
        <span class="text-[var(--cx-muted)] text-sm">/</span>
        <a href="{{ route('ucp.index') }}" class="text-[var(--cx-muted)] text-sm hover:text-white transition-colors">{{ __('ui.ucp_panel') }}</a>
        <span class="text-[var(--cx-muted)] text-sm">/</span>
        <span class="text-white text-sm font-medium">{{ __('ui.ucp_security') }}</span>
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

            {{-- Section header --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                     style="background: rgba(139,92,246,.12); border: 1px solid rgba(139,92,246,.25);">
                    <i class="fa-solid fa-shield-halved text-sm text-purple-400"></i>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold text-white leading-tight">{{ __('ui.ucp_security') }}</h1>
                    <p class="text-[var(--cx-muted)] text-xs">{{ __('ui.ucp_security_subtitle') }}</p>
                </div>
            </div>

            {{-- Change password --}}
            <div class="cx-card overflow-hidden" style="transition: none;">
                <div class="px-5 py-4 border-b border-[var(--cx-border)]">
                    <div class="cx-section-title text-xs" style="color: #a78bfa;">
                        <span style="background: #a78bfa;"></span>{{ __('ui.ucp_change_password') }}
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf @method('PUT')

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-[var(--cx-muted)]">
                                {{ __('ui.ucp_current_pwd') }} <span class="text-purple-400">*</span>
                            </label>
                            <input type="password" name="current_password" autocomplete="current-password" required
                                   class="w-full rounded-md px-3.5 py-2.5 text-sm text-white transition-all
                                          focus:outline-none focus:ring-1 focus:ring-purple-500
                                          @error('current_password', 'updatePassword') ring-1 ring-red-600 @enderror"
                                   style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                            @error('current_password', 'updatePassword')
                                <p class="text-red-400 text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-[var(--cx-muted)]">
                                {{ __('ui.ucp_new_pwd') }} <span class="text-purple-400">*</span>
                            </label>
                            <input type="password" name="password" autocomplete="new-password" required
                                   class="w-full rounded-md px-3.5 py-2.5 text-sm text-white transition-all
                                          focus:outline-none focus:ring-1 focus:ring-purple-500
                                          @error('password', 'updatePassword') ring-1 ring-red-600 @enderror"
                                   style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                            @error('password', 'updatePassword')
                                <p class="text-red-400 text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-[var(--cx-muted)]">
                                {{ __('ui.ucp_confirm_pwd') }} <span class="text-purple-400">*</span>
                            </label>
                            <input type="password" name="password_confirmation" autocomplete="new-password" required
                                   class="w-full rounded-md px-3.5 py-2.5 text-sm text-white transition-all
                                          focus:outline-none focus:ring-1 focus:ring-purple-500"
                                   style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                        </div>

                        <div class="flex items-center gap-4 pt-1 border-t border-[var(--cx-border)]">
                            <button type="submit"
                                    class="px-6 py-2.5 text-white text-sm font-bold rounded-md transition-all mt-4 hover:opacity-90 active:scale-95"
                                    style="background: #7c3aed;">
                                <i class="fa-solid fa-key mr-1.5"></i> {{ __('ui.ucp_update_pwd') }}
                            </button>
                            @if(session('status') === 'password-updated')
                                <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                                      class="text-green-400 text-xs flex items-center gap-1 mt-4">
                                    <i class="fa-solid fa-check"></i> {{ __('ui.ucp_pwd_updated') }}
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="rounded-lg overflow-hidden" style="background: var(--cx-card); border: 1px solid rgba(185,28,28,.4);">
                <div class="px-5 py-4 border-b flex items-center gap-2" style="border-color: rgba(185,28,28,.3); background: rgba(185,28,28,.06);">
                    <i class="fa-solid fa-triangle-exclamation text-red-400 text-xs"></i>
                    <span class="text-red-400 text-xs font-bold uppercase tracking-widest">{{ __('ui.ucp_danger_zone') }}</span>
                </div>
                <div class="p-6">
                    <p class="text-[var(--cx-muted)] text-sm mb-5">
                        {!! __('ui.ucp_danger_desc') !!}
                    </p>

                    <div x-data="{ open: false }">
                        <button @click="open = true"
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-red-400 text-sm font-semibold rounded-md transition-all hover:bg-red-700/30 active:scale-95"
                                style="background: rgba(185,28,28,.15); border: 1px solid rgba(185,28,28,.4);">
                            <i class="fa-solid fa-trash text-xs"></i> {{ __('ui.ucp_delete_account') }}
                        </button>

                        {{-- Modal --}}
                        <div x-show="open" x-cloak
                             class="fixed inset-0 z-50 flex items-center justify-center"
                             style="background: rgba(0,0,0,.8); backdrop-filter: blur(4px);">
                            <div class="rounded-xl p-6 max-w-sm w-full mx-4 shadow-2xl"
                                 style="background: var(--cx-card); border: 1px solid rgba(185,28,28,.5);">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                         style="background: rgba(185,28,28,.15); border: 1px solid rgba(185,28,28,.4);">
                                        <i class="fa-solid fa-trash text-red-400 text-sm"></i>
                                    </div>
                                    <h3 class="text-white font-bold text-base">{{ __('ui.ucp_delete_modal_title') }}</h3>
                                </div>
                                <p class="text-[var(--cx-muted)] text-sm mb-5 leading-relaxed">
                                    {{ __('ui.ucp_delete_modal_desc') }}
                                </p>

                                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                                    @csrf @method('DELETE')
                                    <div>
                                        <input type="password" name="password" placeholder="{{ __('ui.ucp_current_pwd') }}" required
                                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-red-600"
                                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                                        @error('password', 'userDeletion')
                                            <p class="text-red-400 text-xs mt-1 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="flex gap-3">
                                        <button type="submit"
                                                class="flex-1 py-2.5 bg-red-700 hover:bg-red-600 text-white text-sm font-bold rounded-md transition-all active:scale-95">
                                            <i class="fa-solid fa-trash mr-1.5 text-xs"></i> {{ __('ui.ucp_delete_confirm') }}
                                        </button>
                                        <button type="button" @click="open = false"
                                                class="flex-1 py-2.5 text-sm text-[var(--cx-muted)] rounded-md hover:text-white transition-all"
                                                style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                                            {{ __('ui.ucp_cancel') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
