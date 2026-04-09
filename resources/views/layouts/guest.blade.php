<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Corex-Dev') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: dark;
            --cx-red:    #e8392a;
            --cx-amber:  #f59e0b;
            --cx-blue:   #3b9edd;
            --cx-bg:     #0b0d11;
            --cx-surf:   #111419;
            --cx-card:   #161b23;
            --cx-border: #21293a;
        }
        body { background: var(--cx-bg); color: #d1d8e4; font-family: 'Inter', sans-serif; margin: 0; }
        .cx-heading { font-family: 'Rajdhani', sans-serif; letter-spacing: .02em; }
        .top-accent-bar {
            background: linear-gradient(90deg, var(--cx-red), #ff6b35, var(--cx-red));
            background-size: 200% 100%;
            animation: shiftGrad 6s ease infinite;
        }
        @keyframes shiftGrad { 0%,100%{background-position:0%} 50%{background-position:100%} }

        /* Grid texture */
        .cx-grid-bg {
            background-image:
                linear-gradient(rgba(232,57,42,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(232,57,42,.025) 1px, transparent 1px);
            background-size: 36px 36px;
        }

        /* Input field */
        .cx-input {
            width: 100%;
            background: var(--cx-bg);
            border: 1px solid var(--cx-border);
            border-radius: 6px;
            color: #d1d8e4;
            font-size: .875rem;
            padding: 10px 12px;
            outline: none;
            transition: border-color .15s;
            box-sizing: border-box;
        }
        .cx-input:focus { border-color: var(--cx-red); box-shadow: 0 0 0 2px rgba(232,57,42,.15); }
        .cx-input::placeholder { color: #4b5568; }
        .cx-input.has-icon { padding-left: 38px; }

        /* Submit button */
        .cx-btn-primary {
            width: 100%;
            background: var(--cx-red);
            color: #fff;
            font-size: .8rem;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
            border: none;
            border-radius: 6px;
            padding: 11px 16px;
            cursor: pointer;
            transition: background .15s, transform .1s;
            font-family: 'Inter', sans-serif;
        }
        .cx-btn-primary:hover { background: #c42d1f; transform: translateY(-1px); }
        .cx-btn-primary:active { transform: translateY(0); }

        .cx-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #8899aa; margin-bottom: 6px; display: block; }

        /* Left branding panel */
        .auth-brand-panel {
            background: linear-gradient(145deg, #0f1218 0%, #0b0d11 60%, #120a0a 100%);
            position: relative; overflow: hidden;
        }
        .auth-brand-panel::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(232,57,42,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(232,57,42,.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .brand-glow {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(232,57,42,.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Error message */
        .cx-error { display: block; font-size: .72rem; color: #f87171; margin-top: 4px; }
    </style>
</head>
<body class="min-h-screen antialiased">

    <div class="top-accent-bar h-[3px] w-full"></div>

    <div class="min-h-screen flex">

        {{-- ── Left branding panel (hidden on mobile) ─────────────── --}}
        <div class="hidden lg:flex lg:w-[420px] xl:w-[480px] flex-shrink-0 auth-brand-panel flex-col items-center justify-center px-12 relative">
            <div class="brand-glow"></div>
            <div class="relative z-10 text-center">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="inline-block mb-8">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center"
                             style="background: linear-gradient(135deg, var(--cx-red), #ff6b35)">
                            <i class="fa-solid fa-gamepad text-white text-xl"></i>
                        </div>
                        <span class="cx-heading font-black text-white text-4xl tracking-tight">COREX</span>
                        <span class="cx-badge text-[9px] font-black" style="background:var(--cx-red); color:#fff; border-radius:3px; padding:2px 6px; align-self:flex-start; margin-top:4px">DEV</span>
                    </div>
                </a>

                <p class="text-sm leading-relaxed mb-10" style="color:#4b5568; max-width:280px; margin-left:auto; margin-right:auto">
                    Tu portal de noticias, guías, reseñas y eventos del mundo gaming.
                </p>

                {{-- Feature list --}}
                <div class="space-y-4 text-left" style="max-width:260px; margin:0 auto">
                    @foreach([
                        ['fa-newspaper','Noticias', 'Las últimas del mundo gaming'],
                        ['fa-book-open','Guías', 'Tutoriales y walkthroughs completos'],
                        ['fa-star','Reseñas', 'Análisis honestos y detallados'],
                        ['fa-trophy','Eventos', 'Sorteos y torneos exclusivos'],
                    ] as [$icon, $title, $desc])
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded flex items-center justify-center flex-shrink-0 mt-0.5"
                                 style="background:rgba(232,57,42,.1); border:1px solid rgba(232,57,42,.2)">
                                <i class="fa-solid {{ $icon }} text-[11px]" style="color:var(--cx-red)"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">{{ $title }}</div>
                                <div class="text-xs" style="color:#4b5568">{{ $desc }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Right form panel ─────────────────────────────────────── --}}
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 cx-grid-bg" style="background:var(--cx-surf)">

            {{-- Mobile logo --}}
            <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2 mb-8">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: linear-gradient(135deg, var(--cx-red), #ff6b35)">
                    <i class="fa-solid fa-gamepad text-white text-sm"></i>
                </div>
                <span class="cx-heading font-black text-white text-2xl tracking-tight">COREX<span style="color:var(--cx-red)">DEV</span></span>
            </a>

            <div class="w-full max-w-[400px]">
                {{ $slot }}
            </div>

            <p class="text-[11px] mt-8" style="color:#4b5568">
                &copy; {{ date('Y') }} Corex-Dev &mdash; Portal Gaming en Español
            </p>
        </div>
    </div>
</body>
</html>
