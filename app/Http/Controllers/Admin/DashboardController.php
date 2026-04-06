<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_services' => Service::count(),
                'published_services' => Service::published()->count(),
                'total_projects' => Project::count(),
                'published_projects' => Project::published()->count(),
                'total_categories' => ProjectCategory::count(),
            ],
        ]);
    }
}
