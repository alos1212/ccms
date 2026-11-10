<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Service;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $contents = Content::query()
            ->where('is_active', true)
            ->orderBy('section')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('section');

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('site.home', compact('contents', 'services'));
    }
}
