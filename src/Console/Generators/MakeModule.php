<?php namespace Mrabbani\ModuleManager\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class MakeModule extends Command
{
    /**
     * @var string
     */
    protected $signature = 'module:create 
        {alias : The alias of the module}
    ';

    /**
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container = [];

    /**
     * Accepted module types
     * @var array
     */
    protected $acceptedTypes = [
        'module' => 'Module',
        'plugin' => 'Plugins',
    ];

    protected $moduleType;

    protected $moduleFolderName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->moduleType = 'module'; //$this->ask('Your modular type. Eccepted: module,plugin. Other types will return "module".', 'module');
        if (!in_array($this->moduleType, array_keys($this->acceptedTypes))) {
            $this->moduleType = 'module';
        }

        $this->container['alias'] = str_slug($this->argument('alias'));

        $this->step1();
    }

    private function step1()
    {
        $this->moduleFolderName = str_slug($this->ask('Module folder name:', $this->container['alias']));
        $this->container['name'] = $this->ask('Name of module:', config('app.name') . ' '. $this->container['alias']);
        $this->container['author'] = $this->ask('Author of module:');
        $this->container['description'] = $this->ask('Description of module:', $this->container['name']);
        $this->container['namespace'] = $this->ask('Namespace of module:', $this->laravel->getNamespace() . $this->acceptedTypes[$this->moduleType] . '\\' . studly_case($this->container['alias']));
        $this->container['version'] = $this->ask('Module version.', '1.0');
        $this->container['autoload'] = $this->ask('Autoloading type.', 'psr-4');

        $this->step2();
    }

    private function step2()
    {
        $this->generatingModule();

        $this->info("\nYour module generated successfully.");
    }

    private function generatingModule()
    {
        $pathType = $this->makeModuleFolder();
        $directory = $pathType($this->moduleFolderName);
        $source = __DIR__ . '/../../../resources/stubs/_folder-structure';

        /**
         * Make directory
         */
        $this->files->makeDirectory($directory);
        $this->files->copyDirectory($source, $directory, null);

        /**
         * Replace files placeholder
         */
        $files = $this->files->allFiles($directory);
        foreach ($files as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $filePath = $pathType($this->moduleFolderName . '/' . $file->getRelativePathname());

            $this->files->put($filePath, $contents);
        }

        /**
         * Modify the module.json information
         */
        \File::put($directory . '/module.json', json_encode_pretify($this->container));
    }

    private function makeModuleFolder()
    {
        switch ($this->moduleType) {
            case 'module':
                if (!$this->files->isDirectory(module_base_path())) {
                    $this->files->makeDirectory(module_base_path());
                }
                return 'module_base_path';
                break;
            case 'plugin':
            default:
                if (!$this->files->isDirectory(plugins_base_path())) {
                    $this->files->makeDirectory(plugins_base_path());
                }
                return 'plugins_base_path';
                break;
        }
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyNamespace',
            'DummyAlias',
            'DummyName',
        ];

        $replace = [
            $this->container['namespace'],
            $this->container['alias'],
            $this->container['name'],
        ];

        return str_replace($find, $replace, $contents);
    }
}
