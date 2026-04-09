@extends('layouts.admin')
@section('title', 'Nuevo Evento — Admin')

@section('breadcrumb', 'Eventos � Nuevo')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-white">Nuevo Evento</h1>
        <a href="{{ route('admin.events.index') }}" class="text-gray-500 text-xs hover:text-[#00d4ff]">← Volver</a>
    </div>
    @if($errors->any())
        <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-xl p-4 mb-6 text-sm">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Nombre del evento *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Tipo *</label>
                <select name="type" required
                        class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
                    <option value="launch"    {{ old('type') === 'launch'    ? 'selected' : '' }}>Lanzamiento</option>
                    <option value="expansion" {{ old('type') === 'expansion' ? 'selected' : '' }}>Expansión</option>
                    <option value="demo"      {{ old('type') === 'demo'      ? 'selected' : '' }}>Demo</option>
                    <option value="update"    {{ old('type') === 'update'    ? 'selected' : '' }}>Update</option>
                    <option value="sale"      {{ old('type') === 'sale'      ? 'selected' : '' }}>Sale</option>
                    <option value="event"     {{ old('type') === 'event'     ? 'selected' : '' }}>Evento</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Fecha *</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Juego</label>
                <input type="text" name="game" value="{{ old('game') }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Plataforma</label>
                <input type="text" name="platform" value="{{ old('platform') }}" placeholder="PC, PS5, Xbox, Multi..."
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">URL de información</label>
                <input type="url" name="url" value="{{ old('url') }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Descripción</label>
                <textarea name="description" rows="4"
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#8b5cf6] focus:outline-none resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Imagen</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-gray-400 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded border-[#1e2a3a] bg-[#0a0e1a] text-[#8b5cf6]">
                    <span class="text-gray-300 text-sm">★ Destacado en home</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#8b5cf6] text-white font-bold text-sm rounded-lg hover:bg-purple-400 transition-all">
                Guardar Evento
            </button>
            <a href="{{ route('admin.events.index') }}" class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 font-semibold text-sm rounded-lg hover:bg-[#243447] transition-all">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
