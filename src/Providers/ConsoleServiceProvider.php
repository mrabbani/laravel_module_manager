<?php namespace Mrabbani\ModuleManager\Providers;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\ServiceProvider;
use Mrabbani\ModuleManager\Services\ModuleMigrator;

/**
 * Class ConsoleServiceProvider
 * @package Mrabbani\ModuleManager\Providers
 */
class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->generatorCommands();
        $this->migrationCommands();
        $this->otherCommands();
    }

    /**
     * register generator commands
     */
    private function generatorCommands()
    {
        $generators = [
            'module_manager.console.generator.make-module' => \Mrabbani\ModuleManager\Console\Generators\MakeModule::class,
            'module_manager.console.generator.make-provider' => \Mrabbani\ModuleManager\Console\Generators\MakeProvider::class,
            'module_manager.console.generator.make-controller' => \Mrabbani\ModuleManager\Console\Generators\MakeController::class,
            'module_manager.console.generator.make-middleware' => \Mrabbani\ModuleManager\Console\Generators\MakeMiddleware::class,
            'module_manager.console.generator.make-request' => \Mrabbani\ModuleManager\Console\Generators\MakeRequest::class,
            'module_manager.console.generator.make-model' => \Mrabbani\ModuleManager\Console\Generators\MakeModel::class,
//            'module_manager.console.generator.make-repository' => \Mrabbani\ModuleManager\Console\Generators\MakeRepository::class,
            'module_manager.console.generator.make-facade' => \Mrabbani\ModuleManager\Console\Generators\MakeFacade::class,
            'module_manager.console.generator.make-service' => \Mrabbani\ModuleManager\Console\Generators\MakeService::class,
            'module_manager.console.generator.make-support' => \Mrabbani\ModuleManager\Console\Generators\MakeSupport::class,
//            'module_manager.console.generator.make-view' => \Mrabbani\ModuleManager\Console\Generators\MakeView::class,
            'module_manager.console.generator.make-migration' => \Mrabbani\ModuleManager\Console\Generators\MakeMigration::class,
            'module_manager.console.generator.make-command' => \Mrabbani\ModuleManager\Console\Generators\MakeCommand::class,
        ];
        foreach ($generators as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }

    /**
     * register database migrate related command
     */
    private function migrationCommands()
    {
        $this->registerModuleMigrator();
        $this->registerMigrateCommand();
    }

    private function registerMigrateCommand()
    {
        $commands = [
            'module_manager.console.command.module-migrate' => \Mrabbani\ModuleManager\Console\Migrations\ModuleMigrateCommand::class
        ];
        foreach ($commands as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
        $this->registerRollbackCommand();

    }
    private function otherCommands()
    {
        $commands = [
            'module_manager.console.command.module-install' => \Mrabbani\ModuleManager\Console\Commands\InstallModuleCommand::class,
            'module_manager.console.command.module-uninstall' => \Mrabbani\ModuleManager\Console\Commands\UninstallModuleCommand::class,
            'module_manager.console.command.disable-module' => \Mrabbani\ModuleManager\Console\Commands\DisableModuleCommand::class,
            'module_manager.console.command.enable-module' => \Mrabbani\ModuleManager\Console\Commands\EnableModuleCommand::class,
        ];
        foreach ($commands as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }
    /**
     * Register the "rollback" migration command.
     *
     * @return void
     */
    protected function registerRollbackCommand()
    {
        $this->app->singleton('module_manager.console.command.migration-rollback', function ($app) {
            return new \Mrabbani\ModuleManager\Console\Migrations\RollbackCommand($app['module.migrator']);
        });
        $this->commands('module_manager.console.command.migration-rollback');
    }


    protected function registerModuleMigrator()
    {
        // The migrator is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the migrator can resolve any of these connections when it needs to.
        $this->app->singleton('module.migrator', function ($app) {

            return new ModuleMigrator($app);
        });
    }
}
