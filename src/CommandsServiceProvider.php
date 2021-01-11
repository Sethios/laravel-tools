<?php

namespace Sethios\Tools;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Sethios\Tools\Commands\CreateMvc;
use Sethios\Tools\Commands\DatabaseReseed;
use Sethios\Tools\Commands\TestMigration;

class CommandsServiceProvider extends ServiceProvider {

    public function boot(\Illuminate\Routing\Router $router) {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/dbseeder.php' => config_path('dbseeder.php'),
            ], 'config');
        }
        $this->commands([
            CreateMvc::class,
            DatabaseReseed::class,
            TestMigration::class,
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/dbseeder.php',
            'dbseeder'
        );
    }
}

?>