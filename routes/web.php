<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PortofolioController::class, 'home'])->name('home');
Route::get('/about', [PortofolioController::class, 'about'])->name('about');
Route::get('/education', [PortofolioController::class, 'education'])->name('education');
Route::get('/projects', [PortofolioController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [PortofolioController::class, 'show'])->name('projects.show');

Route::resource('posts', PostController::class);

Route::get('/dashboard', function(){
    return redirect()->route('post.dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

Route::prefix('post')->name('post.')->middleware(['auth'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('projects', ProjectController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('technologies', TechnologyController::class);
    Route::post('projects/{project}/gallery', [ProjectGalleryController::class, 'store'])->name('projects.gallery.store');
    Route::delete('projects/{project}/gallery/{image}', [ProjectGalleryController::class, 'destroy'])->name('projects.gallery.destroy');
    Route::get('/profile-saya', function(){
        return view('posts.profile-saya');
    })->name('profile-saya');
    Route::patch('projects/{project}/gallery/{image}/order', [ProjectGalleryController::class, 'updateOrder'])->name('projects.gallery.order');
    Route::patch('projects/{project}/gallery/{image}/caption', [ProjectGalleryController::class, 'updateCaption'])->name('projects.gallery.caption');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';