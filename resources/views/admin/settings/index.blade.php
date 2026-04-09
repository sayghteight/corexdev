@extends('layouts.admin')
@section('title', 'Configuración del Sitio')
@section('breadcrumb')
    <span class="text-gray-500">Sistema</span>
    <span class="text-gray-700 mx-1.5">/</span>
    <span class="text-white">Configuración</span>
@endsection

@section('content')
<div class="max-w-4xl">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
             style="background: rgba(232,57,42,.12); border: 1px solid rgba(232,57,42,.3);">
            <i class="fa-solid fa-sliders text-[var(--cx-red)]"></i>
        </div>
        <div>
            <h1 class="text-xl font-extrabold text-white leading-tight">Configuración del Sitio</h1>
            <p class="text-gray-500 text-xs">Gestiona el comportamiento global del portal</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" id="settings-form">
        @csrf @method('PUT')

        <div class="space-y-6">

            {{-- ── Mantenimiento ────────────────────────────────────── --}}
            <div class="rounded-xl overflow-hidden border @if($settings->get('maintenance_mode') == '1') border-red-700/60 @else border-[var(--cx-border)] @endif"
                 style="background: var(--cx-card);" id="maintenance-card">
                <div class="px-5 py-4 border-b flex items-center justify-between @if($settings->get('maintenance_mode') == '1') border-red-700/40 @else border-[var(--cx-border)] @endif"
                     style="@if($settings->get('maintenance_mode') == '1') background: rgba(185,28,28,.1); @endif">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-sm @if($settings->get('maintenance_mode') == '1') text-red-400 @else text-gray-500 @endif"></i>
                        <span class="text-sm font-bold text-white uppercase tracking-wider">Modo Mantenimiento</span>
                        @if($settings->get('maintenance_mode') == '1')
                            <span class="cx-badge" style="background:rgba(185,28,28,.2); color:#f87171; border:1px solid rgba(185,28,28,.5); animation: badgePulse 2s infinite;">
                                ACTIVO
                            </span>
                        @else
                            <span class="cx-badge" style="background:rgba(34,197,94,.1); color:#4ade80; border:1px solid rgba(34,197,94,.3);">
                                INACTIVO
                            </span>
                        @endif
                    </div>
                    {{-- Toggle --}}
                    <label class="relative inline-flex items-center cursor-pointer" title="Activar/desactivar modo mantenimiento">
                        <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer"
                               @if($settings->get('maintenance_mode') == '1') checked @endif
                               onchange="document.getElementById('settings-form').submit()">
                        <div class="w-11 h-6 rounded-full peer peer-checked:bg-red-600 bg-gray-700
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:after:translate-x-5 transition-colors"></div>
                    </label>
                </div>
                <div class="p-5 grid grid-cols-1 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400">Mensaje para los visitantes</label>
                        <textarea name="maintenance_message" rows="2"
                                  class="w-full rounded-md px-3.5 py-2.5 text-sm text-white resize-none focus:outline-none focus:ring-1 focus:ring-red-500"
                                  style="background: var(--cx-bg); border: 1px solid var(--cx-border);"
                                  placeholder="Estamos realizando mantenimiento. Volvemos pronto.">{{ $settings->get('maintenance_message') }}</textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400">
                            Tiempo estimado de vuelta
                            <span class="text-gray-600 font-normal ml-1">(opcional, texto libre)</span>
                        </label>
                        <input type="text" name="maintenance_eta"
                               value="{{ $settings->get('maintenance_eta') }}"
                               placeholder="ej. 30 minutos, 14:00 (hora local)"
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-red-500"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                    <p class="text-yellow-600 text-xs flex items-start gap-1.5">
                        <i class="fa-solid fa-circle-info mt-0.5 flex-shrink-0"></i>
                        Los administradores con sesión iniciada siguen viendo el sitio con normalidad.
                    </p>
                </div>
            </div>

            {{-- ── Identidad del sitio ──────────────────────────────── --}}
            <div class="rounded-xl overflow-hidden border border-[var(--cx-border)]" style="background: var(--cx-card);">
                <div class="px-5 py-4 border-b border-[var(--cx-border)] flex items-center gap-2">
                    <i class="fa-solid fa-globe text-gray-500 text-sm"></i>
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Identidad del Sitio</span>
                </div>
                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Nombre del sitio <span class="text-[var(--cx-red)]">*</span></label>
                        <input type="text" name="site_name" value="{{ $settings->get('site_name', 'Corex-Dev') }}" required
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]
                                      @error('site_name') ring-1 ring-red-600 @enderror"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                        @error('site_name')
                            <p class="text-red-400 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Descripción (meta)</label>
                        <textarea name="site_description" rows="2" maxlength="300"
                                  class="w-full rounded-md px-3.5 py-2.5 text-sm text-white resize-none focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]"
                                  style="background: var(--cx-bg); border: 1px solid var(--cx-border);">{{ $settings->get('site_description') }}</textarea>
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400">Palabras clave (separadas por comas)</label>
                        <input type="text" name="site_keywords" value="{{ $settings->get('site_keywords') }}"
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                </div>
            </div>

            {{-- ── Idioma del Portal ────────────────────────────────── --}}
            <div class="rounded-xl overflow-hidden border border-[var(--cx-border)]" style="background: var(--cx-card);">
                <div class="px-5 py-4 border-b border-[var(--cx-border)] flex items-center gap-2">
                    <i class="fa-solid fa-language text-gray-500 text-sm"></i>
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Idioma del Portal</span>
                </div>
                <div class="p-5">
                    <div class="space-y-1.5 max-w-xs">
                        <label class="block text-sm font-medium text-gray-400">Idioma por defecto</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['es' => ['flag' => '🇪🇸', 'label' => 'Español'], 'en' => ['flag' => '🇺🇸', 'label' => 'English']] as $code => $lang)
                            <label class="relative cursor-pointer">
                                <input type="radio" name="site_default_locale" value="{{ $code }}"
                                       class="sr-only peer"
                                       {{ $settings->get('site_default_locale', 'es') === $code ? 'checked' : '' }}>
                                <div class="w-full flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-semibold transition-all
                                            peer-checked:border-[var(--cx-red)] peer-checked:text-white
                                            border-[var(--cx-border)] text-gray-500"
                                     style="background: var(--cx-bg)">
                                    <span class="text-lg">{{ $lang['flag'] }}</span>
                                    <span>{{ $lang['label'] }}</span>
                                    <div class="ml-auto w-3.5 h-3.5 rounded-full border-2 flex items-center justify-center
                                                peer-checked:border-[var(--cx-red)] border-gray-600"
                                         style="border-color: {{ $settings->get('site_default_locale', 'es') === $code ? 'var(--cx-red)' : '#374151' }}">
                                        @if($settings->get('site_default_locale', 'es') === $code)
                                        <div class="w-1.5 h-1.5 rounded-full" style="background:var(--cx-red)"></div>
                                        @endif
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-gray-600 text-xs pt-1 flex items-start gap-1.5">
                            <i class="fa-solid fa-circle-info mt-0.5 flex-shrink-0"></i>
                            Los usuarios pueden cambiar el idioma manualmente desde la barra de navegación.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── Paginación ───────────────────────────────────────── --}}
            <div class="rounded-xl overflow-hidden border border-[var(--cx-border)]" style="background: var(--cx-card);">
                <div class="px-5 py-4 border-b border-[var(--cx-border)] flex items-center gap-2">
                    <i class="fa-solid fa-list-ol text-gray-500 text-sm"></i>
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Paginación</span>
                </div>
                <div class="p-5 grid grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400">Artículos por página</label>
                        <input type="number" name="posts_per_page" min="1" max="100"
                               value="{{ $settings->get('posts_per_page', 12) }}"
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400">Reseñas por página</label>
                        <input type="number" name="reviews_per_page" min="1" max="100"
                               value="{{ $settings->get('reviews_per_page', 12) }}"
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                </div>
            </div>

            {{-- ── Redes Sociales ───────────────────────────────────── --}}
            <div class="rounded-xl overflow-hidden border border-[var(--cx-border)]" style="background: var(--cx-card);">
                <div class="px-5 py-4 border-b border-[var(--cx-border)] flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-gray-500 text-sm"></i>
                    <span class="text-sm font-bold text-white uppercase tracking-wider">Redes Sociales</span>
                </div>
                <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400 flex items-center gap-1.5">
                            <i class="fa-brands fa-x-twitter text-xs"></i> Twitter / X
                        </label>
                        <input type="url" name="social_twitter" value="{{ $settings->get('social_twitter') }}"
                               placeholder="https://x.com/..."
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]
                                      @error('social_twitter') ring-1 ring-red-600 @enderror"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400 flex items-center gap-1.5">
                            <i class="fa-brands fa-discord text-xs text-[#5865F2]"></i> Discord
                        </label>
                        <input type="url" name="social_discord" value="{{ $settings->get('social_discord') }}"
                               placeholder="https://discord.gg/..."
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]
                                      @error('social_discord') ring-1 ring-red-600 @enderror"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-400 flex items-center gap-1.5">
                            <i class="fa-brands fa-youtube text-xs text-red-500"></i> YouTube
                        </label>
                        <input type="url" name="social_youtube" value="{{ $settings->get('social_youtube') }}"
                               placeholder="https://youtube.com/..."
                               class="w-full rounded-md px-3.5 py-2.5 text-sm text-white focus:outline-none focus:ring-1 focus:ring-[var(--cx-red)]
                                      @error('social_youtube') ring-1 ring-red-600 @enderror"
                               style="background: var(--cx-bg); border: 1px solid var(--cx-border);">
                    </div>
                </div>
            </div>

            {{-- Save --}}
            <div class="flex items-center gap-4 pb-2">
                <button type="submit"
                        class="px-7 py-2.5 text-white text-sm font-bold rounded-md transition-all hover:opacity-90 active:scale-95 flex items-center gap-2"
                        style="background: var(--cx-red);">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar configuración
                </button>
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Cancelar</a>
            </div>

        </div>
    </form>
</div>

@push('styles')
<style>
@keyframes badgePulse { 0%,100%{opacity:1} 50%{opacity:.6} }
</style>
@endpush
@endsection
