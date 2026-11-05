<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso administrativo · {{ config('app.name', 'CCMS') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-login-body">
    <main class="admin-login-card">
        <div class="admin-login-brand"><span class="admin-brand-mark">C</span><span><strong>{{ config('app.name', 'CCMS') }}</strong><small>Administración</small></span></div>
        <div class="admin-login-intro"><span class="admin-eyebrow"><i data-lucide="shield-check" class="admin-inline-icon"></i> Acceso restringido</span><h1>Bienvenido de nuevo</h1><p>Ingresa tus credenciales para continuar al panel.</p></div>
        @if ($errors->any()) <div class="admin-alert admin-alert-error">{{ $errors->first() }}</div> @endif
        <form class="admin-form" method="POST" action="{{ route('admin.login.store') }}">
            @csrf
            <label for="login">Usuario o correo electrónico</label><input id="login" name="login" type="text" value="{{ old('login') }}" autocomplete="username" required autofocus placeholder="admin o admin@ejemplo.com">
            <label for="password">Contraseña</label><input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••">
            <label class="admin-checkbox"><input name="remember" type="checkbox" value="1"> <span>Recordarme en este dispositivo</span></label>
            <button class="admin-button admin-button-primary" type="submit">Entrar al panel <span>→</span></button>
        </form>
        <p class="admin-login-note">Esta zona está protegida. Si no tienes acceso, contacta al responsable del sitio.</p>
    </main>
</body>
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
</html>
