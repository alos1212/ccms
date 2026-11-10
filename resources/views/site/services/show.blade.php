@extends('layouts.site')

@section('title', $service->title.' · '.config('app.name', 'CCMS'))
@section('description', $service->introduction ?: $service->title)

@push('head')
    <link rel="stylesheet" href="{{ asset('css/service-pages.css') }}?v=1">
@endpush

@section('content')
    <main class="service-detail-page">
        <section class="service-detail-hero">
            <div class="site-shell service-detail-hero-grid">
                <div class="service-detail-copy">
                    <a class="service-back-link" href="{{ route('services.index') }}"><span>←</span> All services</a>
                    <span class="service-detail-icon"><i class="fa-solid {{ $service->icon ?: 'fa-building' }}"></i></span>
                    <span class="site-kicker">CCMS service</span>
                    <h1>{{ $service->title }}</h1>
                    @if ($service->subtitle)<h2>{{ $service->subtitle }}</h2>@endif
                    @if ($service->introduction)<p class="service-detail-introduction">{{ $service->introduction }}</p>@endif
                </div>
                <figure class="service-detail-image">
                    <img src="{{ $service->image ? asset('storage/'.$service->image) : $fallbackImage }}" alt="{{ $service->title }}">
                </figure>
            </div>
        </section>

        <section class="service-detail-content">
            <div class="site-shell service-detail-content-grid">
                <div class="service-detail-content-heading">
                    <span class="site-kicker">Service overview</span>
                    <span class="service-detail-line"></span>
                    <h2>Carefully designed<br>for your space.</h2>
                </div>
                <div class="service-rich-text">
                    @if ($service->description)
                        {!! $service->description !!}
                    @else
                        <p>{{ $service->introduction }}</p>
                    @endif
                    <a class="site-button site-action site-action--primary service-detail-button" href="{{ url('/#contact') }}">
                        Request a quote <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
