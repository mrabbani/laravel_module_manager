<?php namespace DummyNamespace\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'DummyNamespace';

    protected $moduleAlias = 'DummyAlias';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        //Resolve your module dependency

        $this->createSchema();
    }

    private function createSchema()
    {
        \Artisan::call('module:migrate', ['alias' => $this->moduleAlias]);
    }
}
