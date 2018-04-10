<?php namespace Mrabbani\ModuleManager\Console\Generators;

class MakeSeeder extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:seeder
    	{alias : The alias of the module}
    	{name : Seeder name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        
        return __DIR__ . '/../../../resources/stubs/seeds/seeder.stub';
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->createModuleTableSeederIfNotExist();
        $nameInput = $this->getNameInput();

        if ($this->alreadyExists($nameInput)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->createSeederClass($nameInput);

        $this->info($this->type . ' created successfully.');
    }

    protected function createModuleTableSeederIfNotExist()
    {
        $moduleSeederClass = studly_case(preg_replace('/\-/', '_',  $this->argument('alias'))) . 'TableSeeder';

        if ($this->alreadyExists($moduleSeederClass)) {
           
            return false;
        }

        $this->createSeederClass($moduleSeederClass);
    }

    
    protected function createSeederClass($nameInput)
    {

        $name = $this->parseName($nameInput);

        $path = $this->getPath($name);

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));
        
    }
    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $path = $this->getModuleInfo('module-path') . 'database/seeds/' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{alias}',
        ], [
            $this->argument('alias'),
        ], $stub);
    }
}
