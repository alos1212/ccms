<header class="site-header">
    <div class="site-shell site-header-inner">
        <a class="site-logo" href="{{ url('/') }}" aria-label="Inicio">
            <img class="site-logo-image" src="{{ asset('images/page/logo.png') }}" alt="CCMS Customer Claims Management Services">
        </a>
        <x-site.navigation />
        <a class="site-header-action site-action site-action--primary" href="#contact">
            Request a Quote <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
        </a>
        <button class="site-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false"><span></span><span></span></button>
    </div>
</header>
