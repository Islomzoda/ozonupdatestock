<?php

namespace Islomzoda\OzonUpdateStock;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Islomzoda\OzonUpdateStock\Console\OzonGetMatchCommand;
use Islomzoda\OzonUpdateStock\Console\OzonUploadAliasMatchCommand;

class OzonUpdateStockServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ozonupdatestock');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ozonupdatestock');
         $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ozonupdatestock.php', 'ozonupdatestock');

        // Register the service the package provides.
        $this->app->singleton('ozonupdatestock', function ($app) {
            return new OzonUpdateStock;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ozonupdatestock'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/ozonupdatestock.php' => config_path('ozonupdatestock.php'),
        ], 'ozonupdatestock.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ozonupdatestock'),
        ], 'ozonupdatestock.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ozonupdatestock'),
        ], 'ozonupdatestock.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ozonupdatestock'),
        ], 'ozonupdatestock.views');*/

        // Registering package commands.
         $this->commands([OzonGetMatchCommand::class, OzonUploadAliasMatchCommand::class]);
    }
}
