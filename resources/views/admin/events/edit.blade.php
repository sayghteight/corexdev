@extends('layouts.admin')
@section('title', 'Editar Evento — Admin')

@section('breadcrumb', 'Eventos � Editar')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-white">Editar Evento</h1>
        <a href="{{ route('admin.events.index') }}" class="text-gray-500 text-xs hover:text-[#00d4ff]">← Volver</a>
    </div>
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-5">
        @csrf @method('PATCH')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $event->name) }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Tipo *</label>
                <select name="type" required class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
                    @foreach(['launch'=>'Lanzamiento','expansion'=>'Expansión','demo'=>'Demo','update'=>'Update','sale'=>'Sale','event'=>'Evento'] as $val => $label)
                        <option value="{{ $val }}" {{ old('type', $event->type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Fecha *</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Juego</label>
                <input type="text" name="game" value="{{ old('game', $event->game) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Plataforma</label>
                <input type="text" name="platform" value="{{ old('platform', $event->platform) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">URL</label>
                <input type="url" name="url" value="{{ old('url', $event->url) }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Descripción</label>
                <textarea name="description" rows="4"
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none resize-none">{{ old('description', $event->description) }}</textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Imagen</label>
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="w-24 h-16 object-cover rounded mb-2">
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-gray-400 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}
                           class="rounded border-[#1e2a3a] bg-[#0a0e1a] text-[#8b5cf6]">
                    <span class="text-gray-300 text-sm">★ Destacado</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#8b5cf6] text-white font-bold text-sm rounded-lg hover:bg-purple-400 transition-all">
                Actualizar Evento
            </button>
            <a href="{{ route('admin.events.index') }}" class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 font-semibold text-sm rounded-lg hover:bg-[#243447] transition-all">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
