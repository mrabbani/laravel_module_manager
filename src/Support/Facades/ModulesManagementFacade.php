<?php namespace Mrabbani\ModuleManager\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ModulesManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Mrabbani\ModuleManager\Support\ModulesManagement::class;
    }
}
