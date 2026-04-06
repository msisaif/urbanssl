<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\AboutInfo;
use App\Models\ContactInfo;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('public/Services', [
            'services' => Service::published()->orderBy('sort_order')->get(),
            'aboutInfo' => AboutInfo::getInfo(),
            'contactInfo' => ContactInfo::getInfo(),
        ]);
    }

    public function show(string $slug): Response
    {
        $service = Service::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return Inertia::render('public/ServiceDetail', [
            'service' => $service,
            'aboutInfo' => AboutInfo::getInfo(),
            'contactInfo' => ContactInfo::getInfo(),
        ]);
    }
}
