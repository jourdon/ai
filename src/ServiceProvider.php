<?php
namespace Ai;


class ServiceProvider  extends  \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ai.php' => config_path('ai.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('ai', function ($app) {
            return new Ai($app['config']['ai']);
        });
    }
}
