<?php namespace Mrabbani\ModuleManager\Console\Commands;

use Illuminate\Console\Command;
use Composer\Autoload\ClassLoader;
use Mrabbani\ModuleManager\Console\ModuleInfoTrait;

class ModuleSeedCommand extends Command
{
    use ModuleInfoTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'module:db:seed {alias} {--database=} {--class=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset and re-run all migrations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {            
        $this->loadSeederClass();
        $this->runSeeder();
    }

    /**
     * Load classes from plugin's database/seeds directory
     * 
     * @return void
     */

    protected function loadSeederClass()
    {
        $path =  $this->getPath();
        $seederClasses = \File::glob($path . '*.php');
        foreach ($seederClasses as $className) {
            require_once $className;
        }
    }

   

    /**
     * Get the path of seeder classes
     * 
     * @return string
     */
    protected function getPath()
    {
        $path = $this->getModuleInfo('module-path') . 'database/seeds/';

        return $path;
    }

    /**
     * Run the database seeder command.
     *
     * @param  string  $database
     * @return void
     */
    protected function runSeeder()
    {
        $database = $this->option('database');
        
        $alias = $this->argument('alias');

        $className =  $this->option('class') ?: studly_case(preg_replace('/\-/', '_', $alias)) . 'TableSeeder';
        
        $this->call('db:seed', [
            '--database' => $database,
            '--class' => $className,
            '--force' => $this->option('force'),
        ]);
    }
}