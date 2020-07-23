<?php

namespace Vodeamanager\Core;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Vodeamanager\Core\Http\Middleware\Gate;
use Vodeamanager\Core\Http\Middleware\Notification;
use Vodeamanager\Core\Utilities\Services\FileLogService;
use Vodeamanager\Core\Utilities\Services\ExceptionService;
use Vodeamanager\Core\Utilities\Services\FileService;
use Vodeamanager\Core\Utilities\Services\NumberSettingService;
use Vodeamanager\Core\Utilities\Services\ResourceService;
use Vodeamanager\Core\Utilities\Services\RouteService;

class VodeaManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();

        $this->registerFacades();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerAssets();

        $this->registerSchemas();

        $this->registerEvents();

        $this->registerCommands();

        $this->registerMiddleware();

        if (config('vodeamanager.passport.register', true)) {
            $this->registerPassport();
        }
    }

    private function registerAssets()
    {
        $this->mergeConfigFrom($configVodeaManager = __DIR__ . '/../assets/config/vodeamanager.php','vodeamanager-config');
        $this->mergeConfigFrom($configCors = __DIR__ . '/../assets/config/cors.php','vodeamanager-config');

        if ($this->app->runningInConsole()) {
            $this->publishes([$configVodeaManager => config_path('vodeamanager.php')], 'vodeamanager-config');
            $this->publishes([$configCors => config_path('cors.php')], 'vodeamanager-config');
        }

        $this->publishes([__DIR__ . '/../assets/migrations' => database_path('migrations')],'vodeamanager-migration');
        $this->publishes([__DIR__ . '/../assets/factories' => database_path('factories')],'vodeamanager-factory');
        $this->publishes([__DIR__ . '/../assets/seeds' => database_path('seeds')],'vodeamanager-seed');
    }

    private function registerSchemas()
    {
        Blueprint::macro('userTimeStamp', function($created = 'created_by', $updated = 'updated_by', $deleted = 'deleted_by') {
            $this->timestamps();
            $this->softDeletes();
            $this->unsignedBigInteger($created)->nullable();
            $this->unsignedBigInteger($updated)->nullable();
            $this->unsignedBigInteger($deleted)->nullable();
        });

        Blueprint::macro('relation', function($column, $table, $nullable = true) {
            $this->unsignedBigInteger($column)->nullable($nullable);
            $this->foreign($column)->on($table)->references('id')->onUpdate('cascade');
        });
    }

    private function registerHelpers()
    {
        foreach(glob(__DIR__ . '/Utilities/Helpers/*.php') as $fileHelper){
            require_once($fileHelper);
        }
    }

    private function registerEvents()
    {
        Event::listen('Illuminate\Auth\Events\Login','Vodeamanager\Core\Listeners\LogSuccessfulLogin');
        Event::listen('Laravel\Passport\Events\AccessTokenCreated','Vodeamanager\Core\Listeners\TokenSuccessfulGenerate');
    }

    private function registerCommands()
    {
        $this->commands('Vodeamanager\Core\Commands\RefreshCommand');
        $this->commands('Vodeamanager\Core\Commands\PermissionSeedCommand');
        $this->commands('Vodeamanager\Core\Commands\CreatePassportClientCommand');
    }

    private function registerPassport()
    {
        if (!config('vodeamanager.passport.custom_routes', false)) {
            Passport::routes();
        }

        Passport::tokensExpireIn(now()->addDays(config('vodeamanager.passport.expires.token', 15)));

        Passport::refreshTokensExpireIn(now()->addDays(config('vodeamanager.passport.expires.refresh_token', 30)));

        Passport::personalAccessTokensExpireIn(now()->addMonths(config('vodeamanager.passport.expires.personal_access_token', 6)));
    }

    private function registerFacades()
    {
        app()->bind('exception.service', function() {
            return new ExceptionService;
        });

        app()->bind('file.service', function() {
            return new FileService;
        });

        app()->bind('file_log.service', function() {
            return new FileLogService;
        });

        app()->bind('route.service', function() {
            return new RouteService;
        });

        app()->bind('number-setting.service', function() {
            return new NumberSettingService;
        });

        app()->bind('resource.service', function() {
            return new ResourceService;
        });
    }

    private function registerMiddleware()
    {
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
        $kernel->pushMiddleware('Fruitcake\Cors\HandleCors');

        $this->app['router']->aliasMiddleware('vodeamanager.gate', Gate::class);
        $this->app['router']->aliasMiddleware('vodeamanager.notification', Notification::class);
    }

}
