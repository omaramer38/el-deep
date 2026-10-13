<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(string $locale): View
    {
        $services = Service::published()->orderBy('sort_order')->get();

        return view('site.services.index', compact('services'));
    }

    public function show(string $locale, string $slug): View
    {
        $service = Service::published()
            ->where("slug->{$locale}", $slug)
            ->firstOrFail();

        $otherServices = Service::published()
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        return view('site.services.show', compact('service', 'otherServices'));
    }
}
