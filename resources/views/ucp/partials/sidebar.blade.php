{{-- UCP sidebar --}}
@php
    $ucpNav = [
        ['route' => 'ucp.index',    'icon' => 'fa-house',        'label' => __('ui.ucp_title'),        'pattern' => 'ucp.index'],
        ['route' => 'ucp.profile',  'icon' => 'fa-pen-to-square','label' => __('ui.ucp_edit_profile'), 'pattern' => 'ucp.profile'],
        ['route' => 'ucp.security', 'icon' => 'fa-shield-halved','label' => __('ui.ucp_security'),     'pattern' => 'ucp.security'],
    ];
    $authUser = auth()->user();
@endphp

<aside class="cx-card overflow-hidden">
    {{-- Avatar header --}}
    <div class="relative px-4 pt-5 pb-4 border-b border-[var(--cx-border)]"
         style="background: linear-gradient(135deg, rgba(232,57,42,.12) 0%, rgba(22,27,35,.6) 60%);">
        <div class="flex items-center gap-3">
            <div class="relative flex-shrink-0">
                <div class="w-11 h-11 rounded-full flex items-center justify-center font-black text-xl
                            text-white border-2 border-[var(--cx-red)]"
                     style="background: linear-gradient(135deg, var(--cx-red), #ff6b35);">
                    {{ strtoupper(substr($authUser->name, 0, 1)) }}
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-green-500 border-2 border-[var(--cx-card)]"></span>
            </div>
            <div class="min-w-0">
                <div class="text-white font-bold text-sm leading-tight truncate">{{ $authUser->name }}</div>
                @if($authUser->is_admin)
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider"
                          style="color: var(--cx-red);">
                        <i class="fa-solid fa-bolt text-[9px]"></i> Admin
                    </span>
                @else
                    <span class="text-[11px] text-[var(--cx-muted)]">Miembro</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Nav links --}}
    <nav class="p-2 space-y-0.5">
        @foreach($ucpNav as $item)
            @php $active = request()->routeIs($item['pattern']); @endphp
            <a href="{{ route($item['route']) }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-all duration-150
                      {{ $active ? 'text-white' : 'text-[var(--cx-muted)] hover:text-white hover:bg-white/5' }}"
               @if($active) style="background: rgba(232,57,42,.15); color:#fff;" @endif>
                <i class="fa-solid {{ $item['icon'] }} w-4 text-center text-xs
                           {{ $active ? 'text-[var(--cx-red)]' : 'text-[var(--cx-muted)] group-hover:text-[var(--cx-red)]' }}
                           transition-colors duration-150"></i>
                <span>{{ $item['label'] }}</span>
                @if($active)
                    <span class="ml-auto w-1 h-4 rounded-full" style="background:var(--cx-red);"></span>
                @endif
            </a>
        @endforeach

        @if($authUser->is_admin)
            <div class="pt-2 mt-1 border-t border-[var(--cx-border)]">
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium
                          text-[var(--cx-muted)] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <i class="fa-solid fa-gauge w-4 text-center text-xs text-[var(--cx-red)] transition-colors"></i>
                    <span>{{ __('ui.nav_admin_panel') }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ml-auto text-[9px] opacity-40 group-hover:opacity-80"></i>
                </a>
            </div>
        @endif
    </nav>
</aside>
