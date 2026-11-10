<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('site.services.index', [
            'services' => $this->activeServices(),
        ]);
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('site.services.show', [
            'service' => $service,
            'fallbackImage' => $this->fallbackImage($service),
        ]);
    }

    protected function activeServices()
    {
        return Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    protected function fallbackImage(Service $service): string
    {
        $images = [
            'commercial-facility-services' => 'images/page/home-hero-clean.png',
            'construction-cleaning' => 'images/page/certification/Construction.png',
            'remediation-and-specialty' => 'images/page/about-ccms.png',
            'government-facilities' => 'images/page/home-hero.png',
        ];

        return asset($images[$service->slug] ?? 'images/page/home-hero-clean.png');
    }
}
