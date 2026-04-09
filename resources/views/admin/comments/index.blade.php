@extends('layouts.admin')
@section('title', 'Comentarios — Admin')
@section('breadcrumb', 'Comentarios')

@section('content')

{{-- Flash --}}
@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg text-sm flex items-center gap-2"
         style="background:rgba(0,212,255,.08); border:1px solid rgba(0,212,255,.25); color:#00d4ff">
        <i class="fa-solid fa-circle-check text-xs"></i> {{ session('success') }}
    </div>
@endif

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-white">Comentarios</h1>
        <p class="text-gray-500 text-sm mt-0.5">Modera los comentarios de las publicaciones</p>
    </div>
    @if($pending->total() > 0)
        <span class="px-3 py-1 text-xs font-bold rounded-full"
              style="background:rgba(232,57,42,.15); color:var(--cx-red); border:1px solid rgba(232,57,42,.3)">
            {{ $pending->total() }} pendiente{{ $pending->total() !== 1 ? 's' : '' }}
        </span>
    @endif
</div>

{{-- ── Pending Section ───────────────────────────────────────── --}}
@if($pending->isNotEmpty())
<div class="mb-10">
    <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color:var(--cx-red)">
        <i class="fa-solid fa-clock text-xs mr-1"></i> Pendientes de aprobación
    </h2>
    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Usuario</th>
                    <th class="px-4 py-3 text-left">Comentario</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Artículo</th>
                    <th class="px-4 py-3 text-left hidden lg:table-cell">Fecha</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1e2a3a]">
                @foreach($pending as $c)
                    <tr class="hover:bg-[#0a0e1a]/50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                     style="background:var(--cx-blue); color:#fff">
                                    {{ strtoupper(substr($c->user->name, 0, 1)) }}
                                </div>
                                <span class="text-white text-xs font-medium">{{ $c->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-400 max-w-xs">
                            <p class="line-clamp-2 text-xs">{{ $c->body }}</p>
                            @if($c->parent_id)
                                <span class="text-[10px] mt-0.5 block" style="color:#4b5568">
                                    <i class="fa-solid fa-reply text-[8px]"></i> Respuesta
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 hidden md:table-cell">
                            <a href="{{ route('posts.show', $c->post->slug) }}" target="_blank"
                               class="text-xs hover:underline line-clamp-1" style="color:var(--cx-blue)">
                                {{ $c->post->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs hidden lg:table-cell">
                            {{ $c->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <form method="POST" action="{{ route('admin.comments.approve', $c) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-xs font-semibold transition-colors"
                                            style="color:#22c55e"
                                            onmouseenter="this.style.color='#4ade80'" onmouseleave="this.style.color='#22c55e'">
                                        <i class="fa-solid fa-check text-[9px]"></i> Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.comments.destroy', $c) }}"
                                      onsubmit="return confirm('¿Eliminar este comentario?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs transition-colors" style="color:#e8392a"
                                            onmouseenter="this.style.color='#f87171'" onmouseleave="this.style.color='#e8392a'">
                                        <i class="fa-solid fa-trash text-[9px]"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($pending->hasPages())
        <div class="mt-4">{{ $pending->links() }}</div>
    @endif
</div>
@endif

{{-- ── Approved Section ──────────────────────────────────────── --}}
<div>
    <h2 class="text-sm font-bold uppercase tracking-widest mb-3" style="color:#4b5568">
        <i class="fa-solid fa-circle-check text-xs mr-1" style="color:#22c55e"></i> Aprobados
    </h2>

    @if($approved->isEmpty())
        <div class="text-center py-10" style="color:#4b5568">
            <i class="fa-regular fa-comments text-2xl mb-2 block"></i>
            <p class="text-sm">No hay comentarios aprobados todavía.</p>
        </div>
    @else
        <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Comentario</th>
                        <th class="px-4 py-3 text-left hidden md:table-cell">Artículo</th>
                        <th class="px-4 py-3 text-left hidden lg:table-cell">Fecha</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e2a3a]">
                    @foreach($approved as $c)
                        <tr class="hover:bg-[#0a0e1a]/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                         style="background:var(--cx-blue); color:#fff">
                                        {{ strtoupper(substr($c->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-white text-xs font-medium">{{ $c->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-400 max-w-xs">
                                <p class="line-clamp-2 text-xs">{{ $c->body }}</p>
                                @if($c->parent_id)
                                    <span class="text-[10px] mt-0.5 block" style="color:#4b5568">
                                        <i class="fa-solid fa-reply text-[8px]"></i> Respuesta
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <a href="{{ route('posts.show', $c->post->slug) }}" target="_blank"
                                   class="text-xs hover:underline line-clamp-1" style="color:var(--cx-blue)">
                                    {{ $c->post->title }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs hidden lg:table-cell">
                                {{ $c->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <form method="POST" action="{{ route('admin.comments.approve', $c) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs transition-colors"
                                                style="color:#4b5568"
                                                onmouseenter="this.style.color='#e8392a'" onmouseleave="this.style.color='#4b5568'">
                                            <i class="fa-solid fa-eye-slash text-[9px]"></i> Desaprobar
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.comments.destroy', $c) }}"
                                          onsubmit="return confirm('¿Eliminar este comentario?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs transition-colors" style="color:#e8392a"
                                                onmouseenter="this.style.color='#f87171'" onmouseleave="this.style.color='#e8392a'">
                                            <i class="fa-solid fa-trash text-[9px]"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($approved->hasPages())
            <div class="mt-4">{{ $approved->links() }}</div>
        @endif
    @endif
</div>

@endsection
