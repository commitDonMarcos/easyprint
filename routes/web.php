<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');
Route::resource('projects', ProjectController::class);
Route::post('/logos/upload', [LogoController::class, 'upload'])->name('logos.upload');
Route::post('/analytics/track', [AnalyticsController::class, 'track'])->name('analytics.track');

require __DIR__.'/admin.php';
