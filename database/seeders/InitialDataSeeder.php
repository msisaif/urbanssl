<?php

namespace Database\Seeders;

use App\Models\AboutInfo;
use App\Models\ContactInfo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@urbanssl.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create default contact info
        ContactInfo::firstOrCreate([], [
            'phone' => '01766-777276',
            'email' => 'urbansslbd@gmail.com',
            'whatsapp' => '8801766777276',
            'address' => 'Dhaka, Bangladesh',
        ]);

        // Create default about info
        AboutInfo::firstOrCreate([], [
            'company_name' => 'Urban Structural Solutions',
            'tagline' => 'Engineering Excellence',
            'hero_title' => "Building Tomorrow's Structures Today",
            'hero_subtitle' => 'Professional engineering consultancy providing comprehensive architectural, structural, and MEP solutions for your construction projects.',
            'years_experience' => '10',
            'total_projects' => '150',
            'happy_clients' => '100',
        ]);
    }
}
