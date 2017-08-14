<?php

namespace Janaagraha\Sanitizer;

use Illuminate\Support\ServiceProvider;

class SanitizerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register the sanitizer factory:
        $this->app->singleton('sanitizer', function ($app) {
            return new Factory;
        });
    }
}