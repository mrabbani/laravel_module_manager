<?php  namespace Mrabbani\ModuleManager\Console\Migrations;

use Illuminate\Console\Command;

class ModuleMigrateCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'module:migrate
    {alias : the alias of module or "all" for all module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations by module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $requestedMigrations = $this->getMigrationIfo();
        foreach($requestedMigrations as $migration) {
            $this->info($migration['alias']. ' module migrating');
            \Artisan::call('migrate', ['--path' => $migration['path']]);
            $this->info($migration['alias']. ' module migrated');
        }
    }

    /**
     * return alias name and database migration path by module
     *
     * @return array
     * @throws \Exception
     */
    protected function getMigrationIfo()
    {
        $info = [];
        $migrationDirectory = 'database' . DIRECTORY_SEPARATOR . 'migrations';
        $alias = $this->argument('alias');
        $allAlias = get_all_module_aliases();
        if ($alias === 'all') {
            foreach($allAlias as  $alias) {
                $info[] = [
                    'alias' => $alias,
                    'path' => module_relative_path($alias) . $migrationDirectory
                ];
            }

            return $info;
        }
        if (!in_array($alias, $allAlias)) {
            throw new \Exception($alias .' module not found');
        }
        $info[] = [
            'alias' => $alias,
            'path' => module_relative_path($alias) . $migrationDirectory
        ];

        return $info;
    }
}
