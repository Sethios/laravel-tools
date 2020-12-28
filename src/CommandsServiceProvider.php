<?php

namespace Sethios\Tools;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider {

    public function boot(\Illuminate\Routing\Router $router) {
        $this->commands([
            \Sethios\Tools\Commands\CreateMvc::class,
            \Sethios\Tools\Commands\DatabaseReseed::class,
            \Sethios\Tools\Commands\TestMigration::class,
        ]);
    }
}

?>