<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\AboutInfo;
use App\Models\ContactInfo;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('public/Contact', [
            'contactInfo' => ContactInfo::getInfo(),
            'aboutInfo' => AboutInfo::getInfo(),
        ]);
    }
}
