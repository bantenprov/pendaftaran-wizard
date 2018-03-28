<?php

namespace Bantenprov\PendaftaranWizard;

use Illuminate\Support\ServiceProvider;
use Bantenprov\PendaftaranWizard\Console\Commands\PendaftaranWizardCommand;

/**
 * The PendaftaranWizardServiceProvider class
 *
 * @package Bantenprov\PendaftaranWizard
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PendaftaranWizardServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pendaftaran-wizard', function ($app) {
            return new PendaftaranWizard;
        });

        $this->app->singleton('command.pendaftaran-wizard', function ($app) {
            return new PendaftaranWizardCommand;
        });

        $this->commands('command.pendaftaran-wizard');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'pendaftaran-wizard',
            'command.pendaftaran-wizard',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('pendaftaran-wizard.php');

        $this->mergeConfigFrom($packageConfigPath, 'pendaftaran-wizard');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'pendaftaran-wizard-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'pendaftaran-wizard');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/pendaftaran-wizard'),
        ], 'pendaftaran-wizard-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'pendaftaran-wizard');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/pendaftaran-wizard'),
        ], 'pendaftaran-wizard-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'pendaftaran-wizard-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'pendaftaran-wizard-migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'pendaftaran-wizard-public');
    }

    public function seedHandle()
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], 'pendaftaran-wizard-seeds');
    }
}
