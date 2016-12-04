<?php namespace Mrabbani\ModuleManager\Services;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Arr;

/**
 * Created by PhpStorm.
 * User: mahbub
 * Date: 12/1/16
 * Time: 10:05 PM
 */
class ModuleMigrator extends Migrator
{
    public function __construct($app)
    {
        $repository = $app['migration.repository'];
        parent::__construct($repository, $app['db'], $app['files']);
    }
    /**
     * Rollback the last migration operation.
     *
     * @param  array|string $paths
     * @param  array  $options
     * @return array
     */
    public function rollback($paths = [], array $options = [])
    {
        $this->notes = [];

        $rolledBack = [];


        // We want to pull in the last batch of migrations that ran on the previous
        // migration operation. We'll then reverse those migrations and run each
        // of them "down" to reverse the last migration "operation" which ran.
        if (($steps = Arr::get($options, 'step', 0)) > 0) {
            $migrations = $this->repository->getMigrations($steps);
        } else {
            $migrations = $this->repository->getLast();
        }

        $count = count($migrations);

        $files = $this->getMigrationFiles($paths);

        if ($count === 0) {
            $this->note('<info>Nothing to rollback.</info>');
        } else {
            // Next we will run through all of the migrations and call the "down" method
            // which will reverse each migration in order. This getLast method on the
            // repository already returns these migration's names in reverse order.
            $this->requireFiles($files);

            foreach ($migrations as $migration) {
                $migration = (object) $migration;
                if(! isset($files[$migration->migration])) {
                    continue;
                }

                $rolledBack[] = $files[$migration->migration];

                $this->runDown(
                    $files[$migration->migration],
                    $migration, Arr::get($options, 'pretend', false)
                );
            }
        }

        return $rolledBack;
    }

}