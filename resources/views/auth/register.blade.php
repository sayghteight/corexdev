<x-guest-layout>

    {{-- Title --}}
    <div class="mb-7">
        <h1 class="cx-heading font-black text-white text-3xl mb-1">Crear cuenta</h1>
        <p class="text-sm" style="color:#4b5568">Únete a la comunidad Corex-Dev</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="cx-label">Nombre de usuario</label>
            <div class="relative">
                <i class="fa-solid fa-user absolute left-3 top-1/2 -translate-y-1/2 text-[12px]" style="color:#4b5568"></i>
                <input id="name" type="text" name="name"
                       value="{{ old('name') }}"
                       class="cx-input has-icon"
                       placeholder="Tu nombre"
                       required autofocus autocomplete="name">
            </div>
            @error('name')
                <span class="cx-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="cx-label">Correo electrónico</label>
            <div class="relative">
                <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-[12px]" style="color:#4b5568"></i>
                <input id="email" type="email" name="email"
                       value="{{ old('email') }}"
                       class="cx-input has-icon"
                       placeholder="tu@email.com"
                       required autocomplete="username">
            </div>
            @error('email')
                <span class="cx-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="cx-label">Contraseña</label>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-[12px]" style="color:#4b5568"></i>
                <input id="password" type="password" name="password"
                       class="cx-input has-icon"
                       placeholder="Mínimo 8 caracteres"
                       required autocomplete="new-password">
                <button type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                        style="color:#4b5568; background:none; border:none; cursor:pointer; padding:0"
                        onclick="const i=document.getElementById('password'); i.type=i.type==='password'?'text':'password'; this.querySelector('i').className='fa-solid '+(i.type==='password'?'fa-eye':'fa-eye-slash')">
                    <i class="fa-solid fa-eye text-[12px]"></i>
                </button>
            </div>
            @error('password')
                <span class="cx-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="cx-label">Confirmar contraseña</label>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-[12px]" style="color:#4b5568"></i>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="cx-input has-icon"
                       placeholder="Repite tu contraseña"
                       required autocomplete="new-password">
                <button type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                        style="color:#4b5568; background:none; border:none; cursor:pointer; padding:0"
                        onclick="const i=document.getElementById('password_confirmation'); i.type=i.type==='password'?'text':'password'; this.querySelector('i').className='fa-solid '+(i.type==='password'?'fa-eye':'fa-eye-slash')">
                    <i class="fa-solid fa-eye text-[12px]"></i>
                </button>
            </div>
            @error('password_confirmation')
                <span class="cx-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Terms note --}}
        <p class="text-[11px]" style="color:#4b5568">
            Al registrarte aceptas nuestras
            <a href="#" style="color:var(--cx-blue)">condiciones de uso</a>
            y
            <a href="#" style="color:var(--cx-blue)">política de privacidad</a>.
        </p>

        {{-- Submit --}}
        <button type="submit" class="cx-btn-primary mt-1">
            <i class="fa-solid fa-user-plus mr-2"></i> Crear cuenta
        </button>
    </form>

    {{-- Login link --}}
    <p class="text-center text-xs mt-6" style="color:#4b5568">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}" class="font-bold transition-colors" style="color:var(--cx-blue)"
           onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--cx-blue)'">
            Iniciar sesión
        </a>
    </p>

</x-guest-layout>
