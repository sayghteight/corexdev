<x-guest-layout>

    {{-- Title --}}
    <div class="mb-7">
        <h1 class="cx-heading font-black text-white text-3xl mb-1">Iniciar sesión</h1>
        <p class="text-sm" style="color:#4b5568">Accede a tu cuenta de Corex-Dev</p>
    </div>

    {{-- Session flash status (e.g. password reset link sent) --}}
    @if (session('status'))
        <div class="mb-4 px-4 py-3 rounded text-sm font-medium"
             style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.25); color:#4ade80">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="cx-label">Correo electrónico</label>
            <div class="relative">
                <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-[12px]" style="color:#4b5568"></i>
                <input id="email" type="email" name="email"
                       value="{{ old('email') }}"
                       class="cx-input has-icon"
                       placeholder="tu@email.com"
                       required autofocus autocomplete="username">
            </div>
            @error('email')
                <span class="cx-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="cx-label" style="margin-bottom:0">Contraseña</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[11px] transition-colors" style="color:#4b5568"
                       onmouseenter="this.style.color='var(--cx-blue)'" onmouseleave="this.style.color='#4b5568'">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-[12px]" style="color:#4b5568"></i>
                <input id="password" type="password" name="password"
                       class="cx-input has-icon"
                       placeholder="••••••••"
                       required autocomplete="current-password">
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

        {{-- Remember me --}}
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded" style="accent-color:var(--cx-red); width:14px; height:14px">
            <label for="remember_me" class="text-xs cursor-pointer" style="color:#4b5568">Mantener sesión iniciada</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="cx-btn-primary mt-2">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> Entrar
        </button>
    </form>

    {{-- Register link --}}
    <p class="text-center text-xs mt-6" style="color:#4b5568">
        ¿No tienes cuenta?
        <a href="{{ route('register') }}" class="font-bold transition-colors" style="color:var(--cx-blue)"
           onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--cx-blue)'">
            Regístrate gratis
        </a>
    </p>

</x-guest-layout>
