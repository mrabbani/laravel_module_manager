<?php namespace Mrabbani\ModuleManager\Console\Generators;

class MakeCommand extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:command
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new module command';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Command';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/console/command.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Console\\Commands\\' . $this->argument('name');
    }
}
