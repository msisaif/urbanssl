<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'phone', 'email', 'whatsapp', 'facebook_url', 'linkedin_url',
    'google_map_embed', 'address',
])]
class ContactInfo extends Model
{
    protected $table = 'contact_info';

    public static function getInfo(): self
    {
        return self::firstOrCreate([]);
    }
}
