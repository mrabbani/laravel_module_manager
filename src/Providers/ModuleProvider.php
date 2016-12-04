<?php namespace Mrabbani\ModuleManager\Providers;

use Illuminate\Support\ServiceProvider;
use Mrabbani\ModuleManager\Support\Facades\ModulesManagementFacade;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        $this->loadHelpers();

        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(LoadModulesServiceProvider::class);
        $this->mergeConfigFrom(
            __DIR__.'/../../config/module_manager.php', 'module_manager'
        );

        //Register related facades
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('ModulesManagement', ModulesManagementFacade::class);
    }

    protected function loadHelpers()
    {
        $helpers = $this->app['files']->glob(__DIR__ . '/../../helpers/*.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }
}
