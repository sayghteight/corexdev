@extends('layouts.admin')
@section('title', 'Nuevo Usuario')
@section('breadcrumb', 'Usuarios → Nuevo')
@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-white">Nuevo Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 text-xs">← Volver</a>
    </div>
    <form method="POST" action="{{ route('admin.users.store') }}"
          class="bg-[#111827] border border-[#1e2a3a] rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-gray-400 text-sm mb-1">Nombre *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none @error('name') border-red-600 @enderror">
            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-gray-400 text-sm mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none @error('email') border-red-600 @enderror">
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-gray-400 text-sm mb-1">Contraseña *</label>
            <input type="password" name="password" required
                   class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none @error('password') border-red-600 @enderror">
            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-gray-400 text-sm mb-1">Confirmar contraseña *</label>
            <input type="password" name="password_confirmation" required
                   class="w-full bg-[#0a0e1a] border border-[#1e2a3a] text-white rounded-lg px-3 py-2 text-sm focus:border-[#00d4ff] focus:outline-none">
        </div>
        <div class="flex items-center gap-3 pt-1">
            <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                   class="w-4 h-4 accent-[#00d4ff]">
            <label for="is_admin" class="text-sm text-gray-300">Dar permisos de administrador</label>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#00d4ff] text-[#060910] font-bold text-sm rounded-lg hover:bg-cyan-300">
                Crear Usuario
            </button>
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-[#1e2a3a] text-gray-300 text-sm rounded-lg hover:bg-[#243447]">Cancelar</a>
        </div>
    </form>
</div>
@endsection
