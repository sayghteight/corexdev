@extends('layouts.admin')
@section('title', 'Sorteos — Admin')
@section('breadcrumb', 'Sorteos')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Sorteos</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 text-xs">← Dashboard</a>
        </div>
        <a href="{{ route('admin.giveaways.create') }}" class="px-4 py-2 bg-[#ff6b00] text-white font-bold text-sm rounded-lg hover:bg-orange-500">+ Nuevo Sorteo</a>
    </div>
    <div class="bg-[#111827] border border-[#1e2a3a] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#0a0e1a] text-gray-400 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left hidden md:table-cell">Premio</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left hidden lg:table-cell">Fin</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1e2a3a]">
                @forelse($giveaways as $giveaway)
                    <tr class="hover:bg-[#0a0e1a]/50">
                        <td class="px-4 py-3 text-white font-medium">{{ $giveaway->title }}</td>
                        <td class="px-4 py-3 text-[#ffd700] text-xs hidden md:table-cell">{{ $giveaway->prize }}</td>
                        <td class="px-4 py-3">
                            @php $sc = ['active'=>'bg-[#ff6b00]/20 text-[#ff6b00]','upcoming'=>'bg-[#00d4ff]/10 text-[#00d4ff]','ended'=>'bg-gray-800 text-gray-500']; @endphp
                            <span class="px-2 py-0.5 text-xs rounded {{ $sc[$giveaway->status] ?? '' }}">{{ ucfirst($giveaway->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs hidden lg:table-cell">{{ $giveaway->end_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.giveaways.edit', $giveaway) }}" class="text-[#ff6b00] text-xs hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.giveaways.destroy', $giveaway) }}" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 text-xs">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">Sin sorteos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $giveaways->links() }}@endsection
