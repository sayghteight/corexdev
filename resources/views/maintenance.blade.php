<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mantenimiento — Corex-Dev</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cx-red:    #e8392a;
            --cx-bg:     #0b0d11;
            --cx-card:   #161b23;
            --cx-border: #21293a;
        }
        body {
            background-color: var(--cx-bg);
            color: #d1d8e4;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Animated background grid */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(232,57,42,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(232,57,42,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 20s linear infinite;
        }
        @keyframes gridMove { 0% { background-position: 0 0; } 100% { background-position: 60px 60px; } }

        /* Radial glow */
        .bg-glow {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 50% at 50% 0%, rgba(232,57,42,.10) 0%, transparent 70%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(139,92,246,.07) 0%, transparent 60%);
        }

        .card {
            position: relative; z-index: 1;
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 48px 40px;
            max-width: 480px;
            width: 90%;
            text-align: center;
            box-shadow: 0 24px 80px rgba(0,0,0,.5);
        }

        .logo-wrap {
            display: inline-flex; align-items: center; gap: 12px;
            margin-bottom: 32px;
        }
        .logo-box {
            width: 44px; height: 44px; border-radius: 8px;
            background: var(--cx-red);
            display: flex; align-items: center; justify-content: center;
        }
        .logo-box span {
            color: #fff; font-family: 'Rajdhani', sans-serif;
            font-weight: 900; font-size: 18px; letter-spacing: -.02em;
        }
        .logo-text {
            font-family: 'Rajdhani', sans-serif; font-weight: 900;
            font-size: 22px; color: #fff; letter-spacing: -.01em;
        }
        .logo-text span { color: var(--cx-red); }

        .gear-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: rgba(232,57,42,.1);
            border: 2px solid rgba(232,57,42,.3);
            margin: 0 auto 24px;
            display: flex; align-items: center; justify-content: center;
            animation: gearSpin 8s linear infinite;
        }
        @keyframes gearSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .gear-icon i { color: var(--cx-red); font-size: 28px; }

        h1 {
            font-size: 24px; font-weight: 900; color: #fff;
            margin-bottom: 12px; letter-spacing: -.02em;
        }
        .message {
            color: #8899aa; font-size: 15px; line-height: 1.6;
            margin-bottom: 28px;
        }

        .eta-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 18px;
            background: rgba(232,57,42,.08);
            border: 1px solid rgba(232,57,42,.25);
            border-radius: 999px;
            font-size: 13px; color: #aab;
        }
        .eta-badge i { color: var(--cx-red); font-size: 12px; }

        .bar {
            width: 100%; height: 3px;
            background: var(--cx-border);
            border-radius: 999px;
            margin: 32px 0 24px;
            overflow: hidden;
        }
        .bar-fill {
            height: 100%; width: 40%;
            background: linear-gradient(90deg, var(--cx-red), #ff6b35);
            border-radius: 999px;
            animation: barAnim 2.5s ease-in-out infinite alternate;
        }
        @keyframes barAnim { from { width: 20%; margin-left: 0; } to { width: 55%; margin-left: 25%; } }

        .footer {
            position: fixed; bottom: 24px; left: 0; right: 0;
            text-align: center; font-size: 12px; color: #4b5568; z-index: 1;
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <div class="card">
        <div class="logo-wrap">
            <div class="logo-box"><span>CX</span></div>
            <div class="logo-text">COREX<span>-DEV</span></div>
        </div>

        <div class="gear-icon">
            <i class="fa-solid fa-gear"></i>
        </div>

        <h1>Sitio en mantenimiento</h1>
        <p class="message">
            @php
                try { $msg = \App\Models\Setting::get('maintenance_message', 'Estamos realizando tareas de mantenimiento. Volvemos pronto.'); }
                catch (\Throwable) { $msg = 'Estamos realizando tareas de mantenimiento. Volvemos pronto.'; }
            @endphp
            {{ $msg }}
        </p>

        @php
            try { $eta = \App\Models\Setting::get('maintenance_eta', ''); }
            catch (\Throwable) { $eta = ''; }
        @endphp
        @if($eta)
            <div class="eta-badge">
                <i class="fa-regular fa-clock"></i>
                Estimado: {{ $eta }}
            </div>
        @endif

        <div class="bar"><div class="bar-fill"></div></div>

        <p style="font-size: 12px; color: #4b5568;">
            Si eres administrador, <a href="/login" style="color: var(--cx-red); text-decoration: none;">inicia sesión aquí</a>.
        </p>
    </div>

    <div class="footer">© {{ date('Y') }} Corex-Dev — Todos los derechos reservados.</div>
</body>
</html>
