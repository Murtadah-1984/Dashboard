<?php

namespace Murtadah\Dashboard;

use Illuminate\Support\ServiceProvider;
use Murtadah\Dashboard\Commands\DashboardInstallCommand;
use Murtadah\Dashboard\Commands\DashboardMakeCommand;
use App;

class DashboardServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCommands();
        //App::bind('dashboard',function() {
           // return new Murtadah\Dashboard\Facades\Dashboard;
        // });

         //$this->mergeConfigFrom(
         //   __DIR__.'/../config/dashboard.php', 'dashboard'
        //);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        //Routes Load
        //$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        //Load Views
        //$this->loadViewsFrom(__DIR__.'/../resources/views','dashboard');
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DashboardInstallCommand::class,
                DashboardMakeCommand::class
            ]);
        }
    }


}