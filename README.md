# Introduction
When you work on small project, you will feel laravel default structure 
is enough. When your project grows up, you will think to divide 
your app into  module where each module will contain all of it resources
such as Controllers, Models, Views, Migrations, Config etc. This `laravel-module-manager` 
package will help you to manage laravel modular application easily.

### Installation

<!--`composer require mrabbani/lara-module-manager`-->

Add the module manager service provider to `config/app.php` file

`Mrabbani\ModuleManager\Providers\ModuleProvider::class,`

To create new module run the bellow command:

`php artisan module:create name-of-your-module`

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
- `php artisan module:make:command {alias} {CommandName}`
- `php artisan module:make:facade {alias} {FacadeName}`
- `php artisan module:make:middleware {alias} {MiddlewareName}`
- `php artisan module:make:migration {alias} {migration_name} --create --table=table_name`
- `php artisan module:make:migration {alias} {migration_name} --table=table_name`
- `php artisan module:make:model {alias} {ModelName}`
- `php artisan module:make:provider {alias} {ProviderName}`
- `php artisan module:make:request {alias} {RequestName}`
- `php artisan module:make:service {alias} {ServiceClassName}`
- `php artisan module:make:service {alias} {SupportClassName}`
- `php artisan module:install {alias}`
- `php artisan module:uninstall {alias}`
- `php artisan module:enable {alias}`
- `php artisan module:disable {alias}`

> 'alias' is your module's alias name. you can find module's alias name in `module.json` file of module directory
 
#### Credit 
[WebEd](https://github.com/sgsoft-studio/webed)
