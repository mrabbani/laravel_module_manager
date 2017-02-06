# Introduction
When you work on small project, you will feel laravel default structure 
is enough. When your project grows up, you will think to divide 
your app into  module where each module will contain all of it resources
such as Controllers, Models, Views, Migrations, Config etc. This `laravel-module-manager` 
package will help you to manage laravel modular application easily.

### Installation

- laravel 5.4

    `composer require mrabbani/laravel-module-manager`

- Laravel 5.3, Add the following line to your `composer.json` file and run `composer install` in your terminal. 

      "mrabbani/laravel-module-manager": "^1.4"



Add the module manager service provider to `config/app.php` file

`Mrabbani\ModuleManager\Providers\ModuleProvider::class,`

To create new module run the bellow command:

    php artisan module:create name-of-your-module
    php artisan module:install {module_alias_name}
    

If your module name is `module1` the module structure will be

![Module Structure](https://mrabbani.github.io/public/images/module_structure.png "Module Structure")

### Configuration 

By default, all of your module will be placed inside `modules` directory
into your application's base directory. If you want to change publish 
`module_manager` config file by

`php artisan vendor:publish`

Now you can change the default *modules* directory by changing 
`module_directory` value of `config/module_manager.php` file.

### Available commands

To see all module related commands run `php artisan` into terminal.
Available commands are:

- `php artisan module:create {alias}`
- `php artisan module:make:controller {alias} {ControllerName}`
- `php artisan module:make:controller {alias} {ControllerName} --resource`
- `php artisan module:make:command {alias} {CommandName}`
- `php artisan module:make:facade {alias} {FacadeName}`
- `php artisan module:make:middleware {alias} {MiddlewareName}`
- `php artisan module:make:migration {alias} {migration_name} --create --table=table_name`
- `php artisan module:make:migration {alias} {migration_name} --table=table_name`
- `php artisan module:make:model {alias} {ModelName}`
- `php artisan module:make:provider {alias} {ProviderName}`
- `php artisan module:make:request {alias} {RequestName}`
- `php artisan module:make:service {alias} {ServiceClassName}`
- `php artisan module:make:support {alias} {SupportClassName}`
- `php artisan module:migrate {alias}`
- `php artisan module:migrate:rollback {alias}`
- `php artisan module:routes`
- `php artisan module:install {alias}`
- `php artisan module:uninstall {alias}`
- `php artisan module:enable {alias}`
- `php artisan module:disable {alias}`

> 'alias' is your module's alias name. you can find module's alias name in `module.json` file of module directory

You must install your module to activate 

``php artisan module:install {alias}``

### Loading Component
You have to load views, config and translation by following [laravel package](https://laravel.com/docs/5.3/packages#resources) 

##### Loading view 

    view(module_alias::view_file)

you may load the **module1** module's `index.blade.php` view like so:

    view('module1::index');


##### Loading translation

you may load the **module1** module's `welcome` line from the `messages` file like so:

    trans('module1::messages.welcome');
##### Loading config file

you may load the **module1** module's `welcome` line from the `messages` file like so:

`config('messages.welcome');`


You have to merge the configurations, use the `mergeConfigFrom` method within your `ModuleServiceProvider` provider's `register` method:
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/messages.php', 'messages'
        );
    }


>**You should register all of your module's custom provider in *ModuleServiceProvider* provider's *register* method instead application's *config/app.php* file.**


#### Credit 
[WebEd](https://github.com/sgsoft-studio/webed)
