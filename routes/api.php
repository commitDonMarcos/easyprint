<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogoController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

RateLimiter::for('api', function (Request $request) {
    return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('auth', function (Request $request) {
    return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
});

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'environment' => config('app.env'),
            'version' => '1.0.0',
        ]);
    })->name('health');

    Route::middleware(['throttle:auth'])->group(function () {
        Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::post('/analytics/track', [AnalyticsController::class, 'track'])->name('analytics.track');

    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{template}', [TemplateController::class, 'show'])->name('templates.show');

    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::apiResource('projects', ProjectController::class)->except(['create', 'show']);
        Route::post('/logos/upload', [LogoController::class, 'upload'])->name('logos.upload');
        Route::delete('/logos', [LogoController::class, 'destroy'])->name('logos.destroy');
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});
