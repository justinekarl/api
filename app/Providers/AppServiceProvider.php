<?php

namespace App\Providers;

use App\FileManagerPlugin;
use App\TemplatePlugin;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $templatePlugin = new TemplatePlugin();

        view()->share(
            'templatePlugin', $templatePlugin
        );

        $fileManager = new FileManagerPlugin();
        view()->share(
            'fileManager', $fileManager
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
