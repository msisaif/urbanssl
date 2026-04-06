<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_info', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->text('tagline')->nullable();
            $table->longText('about_text')->nullable();
            $table->string('years_experience')->nullable();
            $table->string('total_projects')->nullable();
            $table->string('happy_clients')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('why_choose_us')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_info');
    }
};
