<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            \Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });

        // To prevent wrapping results of Resource Collection with the 'data' field
        JsonResource::withoutWrapping();
    }
}
