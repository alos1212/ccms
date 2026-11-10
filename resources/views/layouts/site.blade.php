<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'CCMS'))</title>
    <meta name="description" content="@yield('description', 'Sitio web de '.config('app.name', 'CCMS'))">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@7.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-navigation-fixes.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/site-navigation-mobile.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/site-footer.css') }}">
    @if (config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    @stack('head')
    <link rel="stylesheet" href="{{ asset('css/site-buttons.css') }}?v=1">
</head>
<body class="site-body">
    <x-site.header />
    <div class="site-menu-backdrop" aria-hidden="true"></div>
    <x-site.content>
        @yield('content')
    </x-site.content>
    <x-site.footer />
    @stack('scripts')
    <script>
        const siteMenuToggle = document.querySelector('.site-menu-toggle');
        const siteNavigation = document.querySelector('.site-navigation');
        siteMenuToggle?.addEventListener('click', () => {
            const isOpen = siteNavigation.classList.toggle('is-open');
            document.body.classList.toggle('site-menu-open', isOpen);
            siteMenuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
        document.querySelector('.site-menu-backdrop')?.addEventListener('click', () => {
            siteNavigation?.classList.remove('is-open');
            document.body.classList.remove('site-menu-open');
            siteMenuToggle?.setAttribute('aria-expanded', 'false');
        });
        document.querySelectorAll('.site-nav-trigger').forEach((trigger) => {
            trigger.addEventListener('click', (event) => {
                event.stopPropagation();
                const item = trigger.parentElement;
                const isOpen = item.classList.toggle('is-open');
                trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        });
        document.addEventListener('click', () => {
            document.querySelectorAll('.site-nav-item.is-open, .site-submenu-item.is-open').forEach((item) => {
                item.classList.remove('is-open');
                item.querySelector('.site-nav-trigger')?.setAttribute('aria-expanded', 'false');
            });
        });
    </script>
</body>
</html>
