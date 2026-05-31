<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\UsageLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('production')) {
            $this->app->register(\Sentry\Laravel\ServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        JsonResource::withoutWrapping();

        Model::shouldBeStrict(!$this->app->environment('production'));

        Model::preventLazyLoading(!$this->app->environment('production'));

        if ($this->app->environment('production')) {
            DB::prohibitDestructiveCommands();
        }
    }
}
