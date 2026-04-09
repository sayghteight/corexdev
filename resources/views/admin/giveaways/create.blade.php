@extends('layouts.admin')
@section('title', 'Nuevo Sorteo — Admin')
@section('breadcrumb', 'Sorteos � Nuevo')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-white">Nuevo Sorteo</h1>
        <a href="{{ route('admin.giveaways.index') }}" class="text-gray-500 text-xs">← Volver</a>
    </div>
    @if($errors->any())
        <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-xl p-4 mb-6 text-sm">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.giveaways.store') }}" enctype="multipart/form-data"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Título *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Premio *</label>
                <input type="text" name="prize" value="{{ old('prize') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Fecha inicio *</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Fecha fin *</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">URL de participación</label>
                <input type="url" name="participation_url" value="{{ old('participation_url') }}"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Estado *</label>
                <select name="status" required class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none">
                    <option value="upcoming" {{ old('status', 'upcoming') === 'upcoming' ? 'selected' : '' }}>Próximamente</option>
                    <option value="active"   {{ old('status') === 'active'   ? 'selected' : '' }}>Activo</option>
                    <option value="ended"    {{ old('status') === 'ended'    ? 'selected' : '' }}>Finalizado</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-400 text-sm mb-1">Imagen</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-gray-400 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-400 text-sm mb-1">Descripción *</label>
                <textarea name="description" rows="5" required
                          class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#ff6b00] focus:outline-none resize-none">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#ff6b00] text-white font-bold text-sm rounded-lg hover:bg-orange-500 transition-all">
                Guardar Sorteo
            </button>
            <a href="{{ route('admin.giveaways.index') }}" class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 font-semibold text-sm rounded-lg hover:bg-[#243447] transition-all">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
