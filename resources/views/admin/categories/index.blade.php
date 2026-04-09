@extends('layouts.admin')
@section('title', 'Categorías — Admin')
@section('breadcrumb', 'Categor�as')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Categorías</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-xs">← Dashboard</a>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-[#00d4ff] text-[#060910] font-bold text-sm rounded-lg hover:bg-cyan-300">+ Nueva Categoría</a>
    </div>
    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Color</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Slug</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Posts</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1e2a3a]">
                @forelse($categories as $cat)
                    <tr class="hover:bg-[#0a0e1a]/50">
                        <td class="px-4 py-3">
                            <div class="w-5 h-5 rounded-full border border-white/10" style="background-color: {{ $cat->color }}"></div>
                        </td>
                        <td class="px-4 py-3 text-white font-medium">{{ $cat->name }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs hidden md:table-cell">{{ $cat->slug }}</td>
                        <td class="px-4 py-3 text-gray-400 hidden md:table-cell">{{ $cat->posts_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="text-[#00d4ff] text-xs hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">Sin categorías.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
