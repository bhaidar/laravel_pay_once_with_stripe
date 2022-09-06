<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // https://medium.com/@cosmeescobedo/how-to-find-the-slowest-query-in-your-laravel-application-76ba6de04716
        DB::listen(function ($query) {
            // grab the first element of non vendor/ calls
            $location = collect(debug_backtrace())->filter(function ($trace) {
                return ! str_contains($trace['file'], 'vendor/');
            })->first();

            $bindings = implode(', ', $query->bindings); // format the bindings as string

            \Log::info("
                — — — — — —
                Sql: $query->sql
                Bindings: $bindings
                Time: $query->time
                File: ${location['file']}
                Line: ${location['line']}
                — — — — — —
            ");
        });

        // To prevent wrapping results of Resource Collection with the 'data' field
        JsonResource::withoutWrapping();
    }
}
