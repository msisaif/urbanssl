<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\AboutInfo;
use App\Models\ContactInfo;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Project::published()->with(['images', 'categories'])->orderBy('sort_order');

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $projects = $query->get();

        $categories = ProjectCategory::active()->orderBy('sort_order')->get();

        return Inertia::render('public/Projects', [
            'projects' => $projects,
            'categories' => $categories,
            'filters' => [
                'category' => $request->category,
            ],
            'aboutInfo' => AboutInfo::getInfo(),
            'contactInfo' => ContactInfo::getInfo(),
        ]);
    }

    public function show(string $slug): Response
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->with(['images', 'categories'])
            ->firstOrFail();

        // Related projects: same categories, exclude current
        $categoryIds = $project->categories->pluck('id');
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('project_categories.id', $categoryIds);
            })
            ->with('images')
            ->limit(4)
            ->get();

        return Inertia::render('public/ProjectDetail', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
            'aboutInfo' => AboutInfo::getInfo(),
            'contactInfo' => ContactInfo::getInfo(),
        ]);
    }
}
