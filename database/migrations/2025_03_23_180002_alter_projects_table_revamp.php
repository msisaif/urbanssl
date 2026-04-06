<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Remove old fields
            $table->dropColumn(['type', 'floors', 'area', 'units', 'is_featured']);

            // Add new fields
            $table->string('owner')->nullable()->after('location');
            $table->string('project_status')->nullable()->after('owner');
            $table->date('project_date')->nullable()->after('project_status');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['owner', 'project_status', 'project_date']);

            $table->string('type')->nullable()->after('slug');
            $table->string('floors')->nullable()->after('type');
            $table->string('area')->nullable()->after('floors');
            $table->string('units')->nullable()->after('area');
            $table->boolean('is_featured')->default(false)->after('meta_description');
        });
    }
};
