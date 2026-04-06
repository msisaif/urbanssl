<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactInfoController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/ContactInfo', [
            'contactInfo' => ContactInfo::getInfo(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:500',
            'linkedin_url' => 'nullable|string|max:500',
            'google_map_embed' => 'nullable|string',
            'address' => 'nullable|string|max:500',
        ]);

        $contactInfo = ContactInfo::getInfo();
        $contactInfo->update($validated);

        return redirect()->back()->with('success', 'Contact info updated successfully.');
    }
}
