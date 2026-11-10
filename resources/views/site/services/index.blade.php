@extends('layouts.site')

@section('title', 'Servicios · '.config('app.name', 'CCMS'))
@section('description', 'Conoce los servicios de limpieza y gestión de CCMS.')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/service-pages.css') }}?v=1">
@endpush

@section('content')
    @php
        $fallbackImages = [
            'commercial-facility-services' => 'images/page/home-hero-clean.png',
            'construction-cleaning' => 'images/page/certification/Construction.png',
            'remediation-and-specialty' => 'images/page/about-ccms.png',
            'government-facilities' => 'images/page/home-hero.png',
        ];
    @endphp

    <main class="service-index-page">
        <section class="service-index-hero">
            <div class="site-shell service-index-hero-inner">
                <span class="site-kicker">Our services</span>
                <h1>Forward-thinking solutions<br>designed for your unique needs.</h1>
                <p>Explore the specialized services we use to create cleaner, safer and more prepared spaces.</p>
            </div>
        </section>

        <section class="service-index-list">
            <div class="site-shell">
                <div class="service-index-grid">
                    @forelse ($services as $service)
                        @php
                            $serviceImage = $service->image
                                ? asset('storage/'.$service->image)
                                : asset($fallbackImages[$service->slug] ?? 'images/page/home-hero-clean.png');
                        @endphp
                        <a class="service-index-card" href="{{ route('services.show', $service) }}">
                            <div class="service-index-card-image">
                                <div class="service-index-image-viewport"><img src="{{ $serviceImage }}" alt="{{ $service->title }}"></div>
                                <span class="service-index-card-icon"><i class="fa-solid {{ $service->icon ?: 'fa-building' }}"></i></span>
                            </div>
                            <div class="service-index-card-content">
                                <small>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</small>
                                <h2>{{ $service->title }}</h2>
                                @if ($service->subtitle)<p>{{ $service->subtitle }}</p>@endif
                                <strong>View service <span class="service-index-card-arrow" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span></strong>
                            </div>
                        </a>
                    @empty
                        <p class="service-empty">No hay servicios publicados todavía.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        const publicServiceCards = document.querySelectorAll('.service-index-card');
        const canUsePublicServiceParallax = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

        if (canUsePublicServiceParallax) {
            publicServiceCards.forEach((card) => {
                const image = card.querySelector('.service-index-image-viewport img');

                card.addEventListener('pointermove', (event) => {
                    const bounds = card.getBoundingClientRect();
                    const pointerX = (event.clientX - bounds.left) / bounds.width;
                    const pointerY = (event.clientY - bounds.top) / bounds.height;

                    image?.style.setProperty('--service-image-x', `${((pointerX - .5) * -22).toFixed(2)}px`);
                    image?.style.setProperty('--service-image-y', `${((pointerY - .5) * -16).toFixed(2)}px`);
                });

                card.addEventListener('pointerleave', () => {
                    image?.style.setProperty('--service-image-x', '0px');
                    image?.style.setProperty('--service-image-y', '0px');
                });
            });
        }
    </script>
@endpush
