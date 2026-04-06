<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AboutInfoController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/AboutInfo', [
            'aboutInfo' => AboutInfo::getInfo(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:500',
            'about_text' => 'nullable|string',
            'years_experience' => 'nullable|string|max:50',
            'total_projects' => 'nullable|string|max:50',
            'happy_clients' => 'nullable|string|max:50',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_image' => 'nullable|image|max:2048',
            'logo' => 'nullable|image|max:1024',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'why_choose_us' => 'nullable|string',
        ]);

        $aboutInfo = AboutInfo::getInfo();

        if ($request->hasFile('hero_image')) {
            if ($aboutInfo->hero_image) {
                Storage::disk('public')->delete($aboutInfo->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('about', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($aboutInfo->logo) {
                Storage::disk('public')->delete($aboutInfo->logo);
            }
            $validated['logo'] = $request->file('logo')->store('about', 'public');
        }

        $aboutInfo->update($validated);

        return redirect()->back()->with('success', 'About info updated successfully.');
    }
}
