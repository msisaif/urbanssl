<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\AboutInfo;
use App\Models\ContactInfo;
use App\Models\Project;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('public/Home', [
            'services' => Service::published()->orderBy('sort_order')->limit(6)->get(),
            'projects' => Project::published()->with(['images', 'categories'])->orderBy('sort_order')->limit(6)->get(),
            'aboutInfo' => AboutInfo::getInfo(),
            'contactInfo' => ContactInfo::getInfo(),
        ]);
    }
}
