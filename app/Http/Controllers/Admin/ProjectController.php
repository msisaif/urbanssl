<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/projects/Index', [
            'projects' => Project::with(['images', 'categories'])->orderBy('sort_order')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/projects/Create', [
            'categories' => ProjectCategory::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:255',
            'project_status' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:project_categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $images = $request->file('images', []);
        $categoryIds = $validated['category_ids'] ?? [];
        unset($validated['images'], $validated['category_ids']);

        $project = Project::create($validated);

        // Attach categories
        if (! empty($categoryIds)) {
            $project->categories()->attach($categoryIds);
        }

        // Upload images
        foreach ($images as $index => $image) {
            $path = $image->store('projects', 'public');
            $project->images()->create([
                'image' => $path,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('admin/projects/Edit', [
            'project' => $project->load(['images', 'categories']),
            'categories' => ProjectCategory::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:255',
            'project_status' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:project_categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $images = $request->file('images', []);
        $removeImages = $validated['remove_images'] ?? [];
        $categoryIds = $validated['category_ids'] ?? [];
        unset($validated['images'], $validated['remove_images'], $validated['category_ids']);

        $project->update($validated);

        // Sync categories
        $project->categories()->sync($categoryIds);

        // Remove selected images
        if (! empty($removeImages)) {
            $imagesToDelete = ProjectImage::whereIn('id', $removeImages)->where('project_id', $project->id)->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }

        // Add new images
        $maxOrder = $project->images()->max('sort_order') ?? 0;
        foreach ($images as $index => $image) {
            $path = $image->store('projects', 'public');
            $project->images()->create([
                'image' => $path,
                'sort_order' => $maxOrder + $index + 1,
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
