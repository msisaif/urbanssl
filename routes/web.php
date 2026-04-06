<?php

use App\Http\Controllers\Admin\AboutInfoController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\PublicSite\ContactController;
use App\Http\Controllers\PublicSite\HomeController;
use App\Http\Controllers\PublicSite\ProjectController;
use App\Http\Controllers\PublicSite\ServiceController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        // Services CRUD
        Route::get('services', [AdminServiceController::class, 'index'])->name('services.index');
        Route::get('services/create', [AdminServiceController::class, 'create'])->name('services.create');
        Route::post('services', [AdminServiceController::class, 'store'])->name('services.store');
        Route::get('services/{service}/edit', [AdminServiceController::class, 'edit'])->name('services.edit');
        Route::post('services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

        // Project Categories CRUD
        Route::get('categories', [ProjectCategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [ProjectCategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [ProjectCategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [ProjectCategoryController::class, 'edit'])->name('categories.edit');
        Route::post('categories/{category}', [ProjectCategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [ProjectCategoryController::class, 'destroy'])->name('categories.destroy');

        // Projects CRUD
        Route::get('projects', [AdminProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/create', [AdminProjectController::class, 'create'])->name('projects.create');
        Route::post('projects', [AdminProjectController::class, 'store'])->name('projects.store');
        Route::get('projects/{project}/edit', [AdminProjectController::class, 'edit'])->name('projects.edit');
        Route::post('projects/{project}', [AdminProjectController::class, 'update'])->name('projects.update');
        Route::delete('projects/{project}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');

        // Contact Info
        Route::get('contact-info', [ContactInfoController::class, 'edit'])->name('contact-info.edit');
        Route::post('contact-info', [ContactInfoController::class, 'update'])->name('contact-info.update');

        // About Info
        Route::get('about-info', [AboutInfoController::class, 'edit'])->name('about-info.edit');
        Route::post('about-info', [AboutInfoController::class, 'update'])->name('about-info.update');
    });
});

require __DIR__ . '/settings.php';
