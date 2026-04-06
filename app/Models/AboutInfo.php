<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'company_name', 'tagline', 'about_text', 'years_experience',
    'total_projects', 'happy_clients', 'hero_title', 'hero_subtitle',
    'hero_image', 'logo', 'meta_title', 'meta_description', 'why_choose_us',
])]
class AboutInfo extends Model
{
    protected $table = 'about_info';

    public static function getInfo(): self
    {
        return self::firstOrCreate([]);
    }
}
