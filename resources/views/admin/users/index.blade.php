@extends('layouts.admin')
@section('title', 'Usuarios')
@section('breadcrumb', 'Usuarios')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-white">Usuarios</h1>
        <p class="text-gray-500 text-sm mt-0.5">Gestiona las cuentas registradas</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-[#00d4ff] text-[#060910] font-bold text-sm rounded-lg hover:bg-cyan-300">+ Nuevo Usuario</a>
</div>

{{-- Search --}}
<form method="GET" class="mb-5 flex gap-3">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o email..."
           class="flex-1 max-w-sm bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
    <button class="px-4 py-2 bg-[#1e2a3a] text-gray-300 text-sm rounded-lg hover:bg-[#243447]">Buscar</button>
    @if(request('q'))
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-[#0a0e1a] text-gray-500 text-sm rounded-lg hover:text-white border border-[#1e2a3a]">✕ Limpiar</a>
    @endif
</form>

<div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Nombre</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">Email</th>
                <th class="px-4 py-3 text-left hidden lg:table-cell">Registro</th>
                <th class="px-4 py-3 text-left">Rol</th>
                <th class="px-4 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#1e2a3a]">
            @forelse($users as $u)
                <tr class="hover:bg-[#0a0e1a]/50">
                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $u->id }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#1e2a3a] flex items-center justify-center text-[#00d4ff] font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <span class="text-white font-medium">{{ $u->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-400 hidden md:table-cell">{{ $u->email }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs hidden lg:table-cell">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        @if($u->is_admin)
                            <span class="px-2 py-0.5 bg-[#00d4ff]/10 text-[#00d4ff] text-xs font-bold rounded-full border border-[#00d4ff]/30">⚡ Admin</span>
                        @else
                            <span class="px-2 py-0.5 bg-[#1e2a3a] text-gray-400 text-xs rounded-full">Usuario</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-[#00d4ff] text-xs hover:underline">Editar</a>
                            @if($u->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('¿Eliminar usuario {{ $u->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 text-xs">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-gray-500">Sin usuarios.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div class="mt-5">{{ $users->links() }}</div>
@endif
@endsection
