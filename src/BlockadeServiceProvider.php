<?php

namespace Konsulting\Laravel\Blockade;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BlockadeServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $root = dirname(__DIR__);

        $viewsPath = $root . '/views';
        $this->loadViewsFrom($viewsPath, 'blockade');

        $this->publishes([$viewsPath => base_path('resources/views/vendor/blockade')], 'views');
        $this->publishes([$root . '/config/blockade.php' => config_path('blockade.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/blockade.php', 'blockade');
    }
}
