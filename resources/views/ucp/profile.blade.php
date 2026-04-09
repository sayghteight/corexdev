@extends('layouts.app')
@section('title', __('ui.ucp_edit_profile'))
@section('content')

{{-- Page hero bar --}}
<div class="border-b border-[var(--cx-border)]" style="background: linear-gradient(135deg, rgba(232,57,42,.08) 0%, rgba(11,13,17,0) 60%);">
    <div class="max-w-5xl mx-auto px-4 py-6 flex items-center gap-3">
        <div class="cx-section-title text-base">{{ __('ui.ucp_title') }}</div>
        <span class="text-[var(--cx-muted)] text-sm">/</span>
        <a href="{{ route('ucp.index') }}" class="text-[var(--cx-muted)] text-sm hover:text-white transition-colors">{{ __('ui.ucp_panel') }}</a>
        <span class="text-[var(--cx-muted)] text-sm">/</span>
        <span class="text-white text-sm font-medium">{{ __('ui.ucp_edit_profile') }}</span>
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
                     style="background: rgba(232,57,42,.12); border: 1px solid rgba(232,57,42,.25);">
                    <i class="fa-solid fa-pen-to-square text-sm" style="color: var(--cx-red);"></i>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold text-white leading-tight">{{ __('ui.ucp_edit_profile') }}</h1>
                    <p class="text-[var(--cx-muted)] text-xs">{{ __('ui.ucp_profile_subtitle') }}</p>
                </div>
            </div>

            {{-- Profile info form --}}
            <div class="cx-card overflow-hidden" style="transition: none;">
                <div class="px-5 py-4 border-b border-[var(--cx-border)]">
                    <div class="cx-section-title text-xs">{{ __('ui.ucp_personal_info') }}</div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf @method('PATCH')

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-[var(--cx-muted)]">
                                {{ __('ui.ucp_name') }} <span style="color:var(--cx-red)">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                                   class="w-full rounded-md px-3.5 py-2.5 text-sm text-white transition-all
                                          focus:outline-none focus:ring-1
                                          @error('name') ring-1 ring-red-600 @else focus:ring-[var(--cx-red)] @enderror"
                                   style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                            @error('name')
                                <p class="text-red-400 text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-[var(--cx-muted)]">
                                {{ __('ui.ucp_email_field') }} <span style="color:var(--cx-red)">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                                   class="w-full rounded-md px-3.5 py-2.5 text-sm text-white transition-all
                                          focus:outline-none focus:ring-1
                                          @error('email') ring-1 ring-red-600 @else focus:ring-[var(--cx-red)] @enderror"
                                   style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                            @error('email')
                                <p class="text-red-400 text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                                </p>
                            @enderror

                            @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2 p-3 rounded-md flex items-start gap-2.5"
                                     style="background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.3);">
                                    <i class="fa-solid fa-triangle-exclamation text-yellow-400 text-xs mt-0.5"></i>
                                    <p class="text-yellow-400 text-xs leading-relaxed">
                                        {{ __('ui.ucp_email_unverified_msg') }}
                                        <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="inline">
                                            @csrf
                                            <button class="underline hover:no-underline text-yellow-300 ml-1">{{ __('ui.ucp_resend_verification') }}</button>
                                        </form>
                                    </p>
                                    @if(session('status') === 'verification-link-sent')
                                        <p class="text-green-400 text-xs mt-1"><i class="fa-solid fa-check mr-1"></i>{{ __('ui.ucp_link_sent') }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 pt-1 border-t border-[var(--cx-border)]">
                            <button type="submit"
                                    class="px-6 py-2.5 text-white text-sm font-bold rounded-md transition-all mt-4 hover:opacity-90 active:scale-95"
                                    style="background: var(--cx-red);">
                                <i class="fa-solid fa-floppy-disk mr-1.5"></i> {{ __('ui.ucp_save') }}
                            </button>
                            @if(session('status') === 'profile-updated')
                                <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                                      class="text-green-400 text-xs flex items-center gap-1 mt-4">
                                    <i class="fa-solid fa-check"></i> {{ __('ui.ucp_saved') }}
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
