@extends('layouts.admin')
@section('title', 'Artículos — Admin')

@section('breadcrumb', 'Noticias')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Artículos</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-xs hover:text-[#00d4ff]">← Volver al dashboard</a>
        </div>
        <a href="{{ route('admin.posts.create') }}"
           class="px-4 py-2 bg-[#00d4ff] text-[#060910] font-bold text-sm rounded-lg hover:bg-cyan-300 transition-all">
            + Nuevo Artículo
        </a>
    </div>

    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Categoría</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Tipo</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left hidden lg:table-cell">Fecha</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1e2a3a]">
                @forelse($posts as $post)
                    <tr class="hover:bg-[#0a0e1a]/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if($post->is_slider)   <span title="Slider" class="text-[#00d4ff] text-xs">◉</span>   @endif
                                @if($post->is_featured) <span title="Destacado" class="text-[#ff6b00] text-xs">★</span> @endif
                                <span class="text-white font-medium truncate max-w-xs">{{ $post->title }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-400 hidden md:table-cell">{{ $post->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3 hidden md:table-cell">
                            <span class="px-2 py-0.5 text-xs rounded {{ $post->type === 'guide' ? 'bg-[#8b5cf6]/20 text-[#8b5cf6]' : 'bg-[#00d4ff]/10 text-[#00d4ff]' }}">
                                {{ $post->type === 'guide' ? 'Guía' : 'Noticia' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 text-xs rounded {{ $post->status === 'published' ? 'bg-green-900/50 text-green-400' : 'bg-gray-800 text-gray-500' }}">
                                {{ $post->status === 'published' ? 'Publicado' : 'Borrador' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs hidden lg:table-cell">{{ $post->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                                   class="text-gray-400 hover:text-white text-xs">Ver</a>
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                   class="text-[#00d4ff] hover:underline text-xs">Editar</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                      onsubmit="return confirm('¿Eliminar este artículo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-400 text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">No hay artículos todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $posts->links() }}@endsection
