@extends('layouts.admin')
@section('title', 'Editar Categoría — Admin')
@section('breadcrumb', 'Categor�as � Editar')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-white">Editar Categoría</h1>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 text-xs">← Volver</a>
    </div>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-4">
        @csrf @method('PATCH')
        <div>
            <label class="block text-gray-400 text-sm mb-1">Nombre *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                   class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
        </div>
        <div>
            <label class="block text-gray-400 text-sm mb-1">Descripción</label>
            <textarea name="description" rows="3"
                      class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none resize-none">{{ old('description', $category->description) }}</textarea>
        </div>
        <div>
            <label class="block text-gray-400 text-sm mb-1">Color</label>
            <input type="color" name="color" value="{{ old('color', $category->color) }}"
                   class="w-12 h-10 bg-[#0a0e1a] border border-[#1e2a3a] rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-gray-400 text-sm mb-1">Icono</label>
            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                   class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#00d4ff] text-[#060910] font-bold text-sm rounded-lg hover:bg-cyan-300">
                Actualizar
            </button>
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 font-semibold text-sm rounded-lg hover:bg-[#243447]">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
