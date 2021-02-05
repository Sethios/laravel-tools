# Laravel Tools
A set of tools for generating basic Laravel scaffolding (including Model, Controller, View, Seeders, Migrations...).

It also includes a tool for database reseeding via Factories and/or CSV file.

# Installation:
Require the package with composer:
> composer require --dev sethios/laravel-tools

After installation run this command for the DB reseed function to work:
> php artisan vendor:publish --tag=config

The generated config file includes basic User model configuration. You can add any other model.

# Database reseed
Reseed a table (or tables) with php artisan by running:
> php artisan db:reseed user

## Parameters
- "reset" -> (optional) name of migration file, used if you wish to re-migrate
- "tables" -> array of database table names you wish to reset when running a db:reseed
- "class" -> name od model seeder class ex. UserSeeder

# Create MVC
Generate scaffolding for a model by running:
> php artisan create:mvc user

The default command will generate the following files:app/Models/User.php
```
app/Http/Requests/UserRequest.php
app/Http/Controllers/UserController.php
app/Events/UserEvent.php
app/Listeners/UserDeleted.php
app/Listeners/UserStored.php
app/Listeners/UserUpdated.php
app/Observers/UserObserver.php
database/migrations/2021_02_05_105447_create_users_table.php
database/factories/UserFactory.php
database/seeds/UserSeeder.php
resources/lang/en/user.php
resources/js/includes/user.js
resources/views/user/index.blade.php
resources/views/user/new.blade.php
resources/views/user/edit.blade.php
resources/views/user/partials/form.blade.php
resources/views/user/partials/userListItem.blade.php
resources/views/user/partials/actions.blade.php
resources/views/user/partials/inputs.blade.php
```

It will also try and modify these files by searching for the commented line "*Create mvc*" used as a placeholder: [^1]
```
routes/web.php
resources/views/layouts/partials/sidebar.blade.php
app/Providers/AppServiceProvider.php
app/Providers/EventServiceProvider.php
database/seeds/DatabaseSeeder.php
resources/js/app.js
```

## Options
There are several flags that can be used that reduce the amount of files generated i.e. specify which files you want to generate:
```
--m : Include Model, migration
--c : Include Controller and route
--b : Include Blade, CSS, JS files and route
--s : Include Seeder and Factory
--l : Include logic in AppServiceProvider, Events, Listeners and Observers
```

# To Do
* Remove the need for commented placeholders in files that need to be modified [^1]
* Include a JSON and/or config file to pre-setup a models generation i.e. pre-define models attributes / database columns. Make it so it also generates the code for Seeders and Factories
* Automated model relations via pre-defined attributes configuration