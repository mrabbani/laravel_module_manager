<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ModuleManagerTest extends TestCase
{
    protected $module = "module_test";
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testAvailableCommands()
    {
//        Artisan::call('module:create', ['alias'=> $this->module, "\n","\n", 'Mahbub' ]);
        Artisan::call('module:make:controller', ['alias'=> $this->module, 'name'=> 'TestController']);
        Artisan::call('module:make:command', ['alias'=> $this->module, 'name'=> 'TestCommand']);
        Artisan::call('module:make:facade', ['alias'=> $this->module, 'name'=> 'TestFacade']);
        Artisan::call('module:make:middleware', ['alias'=> $this->module, 'name'=> 'TestMiddleware']);
        Artisan::call('module:make:migration', ['alias'=> $this->module, 'name' => 'create_test_table' , '--table'=>'tests']);
        Artisan::call('module:make:model',['alias'=> $this->module, 'name'=> 'TestModel']);
        Artisan::call('module:make:provider',['alias'=> $this->module, 'name'=> 'TestProvider']);
        Artisan::call('module:make:request',['alias'=> $this->module, 'name'=> 'TestRequest']);
        Artisan::call('module:make:service',['alias'=> $this->module, 'name'=> 'TestService']);
        Artisan::call('module:migrate',['alias'=> $this->module]);
        Artisan::call('module:migrate:rollback',['alias'=> $this->module]);
        Artisan::call('module:install',['alias'=> $this->module]);
        Artisan::call('module:uninstall',['alias'=> $this->module]);
    }
}
