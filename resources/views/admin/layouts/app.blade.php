<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administración') · {{ config('app.name', 'CCMS') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@7.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-services.css') }}?v=1">
</head>
<body class="admin-body">
    <header class="admin-mobile-header">
        <a class="admin-brand" href="{{ route('admin.home') }}">
            <img class="admin-brand-logo" src="{{ asset('images/admin/axiom-growth-labs.png') }}" alt="AXIOM Growth Labs">
        </a>
        <button class="admin-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false">
            <i data-lucide="menu"></i><span>Menú</span>
        </button>
    </header>
    <aside class="admin-sidebar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">
            <img class="admin-brand-logo" src="{{ asset('images/admin/axiom-growth-labs.png') }}" alt="AXIOM Growth Labs">
        </a>
        <nav class="admin-nav" aria-label="Navegación administrativa">
            <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}" title="Resumen">
                <i data-lucide="layout-dashboard" class="admin-icon"></i> Resumen
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}" href="{{ route('admin.users.index') }}" title="Usuarios">
                <i data-lucide="users" class="admin-icon"></i> Usuarios
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}" href="{{ route('admin.services.index') }}" title="Servicios">
                <i data-lucide="briefcase-business" class="admin-icon"></i> Servicios
            </a>
            <a class="admin-nav-link {{ request()->routeIs('admin.content.*') ? 'is-active' : '' }}" href="{{ route('admin.content.index') }}" title="Contenido">
                <i data-lucide="files" class="admin-icon"></i> Contenido
            </a>
        </nav>
        <div class="admin-sidebar-account">
            <span class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div class="admin-account-details"><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->username }}</small></div>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="admin-logout" type="submit" title="Salir"><i data-lucide="log-out" class="admin-button-icon"></i><span>Salir</span></button></form>
        </div>
    </aside>
    <main class="admin-main">
        <section class="admin-content">@yield('content')</section>
    </main>
</body>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
    const menuToggle = document.querySelector('.admin-menu-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    menuToggle?.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('is-open');
        menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
    sidebar?.querySelectorAll('.admin-nav-link').forEach((link) => link.addEventListener('click', () => {
        sidebar.classList.remove('is-open');
        menuToggle?.setAttribute('aria-expanded', 'false');
    }));
</script>
</html>
