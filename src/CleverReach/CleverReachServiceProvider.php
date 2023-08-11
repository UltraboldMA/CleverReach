<?php

namespace UltraboldMA\CleverReach;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\AliasLoader;

class CleverReachServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //Publish config
        $this->publishes([
            __DIR__ . '/../config/clever-reach.php' => config_path('clever-reach.php'),
        ], 'clever-reach-config');
        //Publish migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'clever-reach-migrations');

        //Publishes Models
        $this->publishes([
            __DIR__ . '/Models' => app_path('/Models')
        ], 'clever-reach-models');

        //Publishes routes
        $this->publishes([
            __DIR__ . '/../routes' => base_path('routes')
        ], 'clever-reach-routes');

        //Publishes Actions
        $this->publishes([
            __DIR__ . '/Actions' => app_path('Actions')
        ], 'clever-reach-actions');

        //Publishes Livewire components
        $this->publishes([
            __DIR__ . '/Livewire' => app_path('Http/Livewire/CleverReach')
        ], 'clever-reach-livewire');

        //Publishes Livewire views
        $this->publishes([
            __DIR__ . '/../resources/views/livewire' => resource_path('views/livewire/clever-reach')
        ], 'clever-reach-views');
    }
    /**
     * Register the service provider.
     */
    public function register()
    {
        //Register command
        $this->commands([
            Commands\PublishCommand::class,
        ]);
    }
}
