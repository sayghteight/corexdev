@extends('layouts.admin')
@section('title', 'Eventos — Admin')
@section('breadcrumb', 'Eventos')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-extrabold text-white">Eventos</h1><a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-xs">? Dashboard</a></div>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-[#8b5cf6] text-white font-bold text-sm rounded-lg hover:bg-purple-400">+ Nuevo Evento</a>
    </div>
    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase"><tr>
                <th class="px-4 py-3 text-left">Nombre</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">Tipo</th>
                <th class="px-4 py-3 text-left">Fecha</th>
                <th class="px-4 py-3 text-right">Acciones</th>
            </tr></thead>
            <tbody class="divide-y divide-[#1e2a3a]">
                @forelse($events as $event)
                    <tr class="hover:bg-[#0a0e1a]/50">
                        <td class="px-4 py-3 text-white font-medium">{{ $event->name }}</td>
                        <td class="px-4 py-3 text-gray-400 hidden md:table-cell capitalize">{{ $event->type }}</td>
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $event->event_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.events.edit', $event) }}" class="text-[#8b5cf6] text-xs hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">Sin eventos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $events->links() }}@endsection
