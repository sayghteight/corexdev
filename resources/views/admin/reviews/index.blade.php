@extends('layouts.admin')
@section('title', 'Reseñas — Admin')

@section('breadcrumb', 'Rese�as')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Reseñas</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-xs hover:text-[#00d4ff]">← Dashboard</a>
        </div>
        <a href="{{ route('admin.reviews.create') }}"
           class="px-4 py-2 bg-[#ffd700] text-[#060910] font-bold text-sm rounded-lg hover:bg-yellow-300 transition-all">
            + Nueva Reseña
        </a>
    </div>
    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Score</th>
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Juego</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1e2a3a]">
                @forelse($reviews as $review)
                    <tr class="hover:bg-[#0a0e1a]/50 transition-colors">
                        <td class="px-4 py-3">
                            <span class="w-8 h-8 rounded-full border-2 border-[#ffd700] inline-flex items-center justify-center text-[#ffd700] text-xs font-black">{{ $review->score }}</span>
                        </td>
                        <td class="px-4 py-3 text-white font-medium truncate max-w-xs">{{ $review->title }}</td>
                        <td class="px-4 py-3 text-gray-400 hidden md:table-cell">{{ $review->game }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 text-xs rounded {{ $review->status === 'published' ? 'bg-green-900/50 text-green-400' : 'bg-gray-800 text-gray-500' }}">
                                {{ $review->status === 'published' ? 'Publicado' : 'Borrador' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="text-[#ffd700] text-xs hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                      onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-400 text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">Sin reseñas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $reviews->links() }}@endsection
