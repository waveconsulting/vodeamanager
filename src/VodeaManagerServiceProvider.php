<?php

namespace Smoothsystem\Core;

use Illuminate\Auth\SessionGuard;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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

        $this->registerSessionGuard();

        if (config('smoothsystem.passport.register', true)) {
            $this->registerPassport();
        }

    }

    protected function registerAssets() {
        $this->mergeConfigFrom($config = __DIR__ . '/../assets/config/smoothsystem.php',
            'smoothsystem-config');

        if ($this->app->runningInConsole()) {
            $this->publishes([$config => config_path('smoothsystem.php')], 'smoothsystem-config');
        }

        $this->publishes(
            [__DIR__ . '/../assets/migrations' => database_path('migrations')],
            'smoothsystem-migration'
        );

        $this->publishes(
            [__DIR__ . '/../assets/factories' => database_path('factories')],
            'smoothsystem-factory'
        );

        $this->publishes(
            [__DIR__ . '/../assets/seeds' => database_path('seeds')],
            'smoothsystem-seed'
        );
    }

    protected function registerSchemas()
    {
        Blueprint::macro('userTimeStamp', function($created = 'created_by', $updated = 'updated_by', $deleted = 'deleted_by', $table = 'users', $reference = 'id') {
            $this->timestamps();
            $this->softDeletes();
            $this->unsignedBigInteger($created)->nullable();
            $this->foreign($created)->references($reference)->on($table)->onUpdate('cascade');
            $this->unsignedBigInteger($updated)->nullable();
            $this->foreign($updated)->references($reference)->on($table)->onUpdate('cascade');
            $this->unsignedBigInteger($deleted)->nullable();
            $this->foreign($deleted)->references($reference)->on($table)->onUpdate('cascade');
        });

        Blueprint::macro('relation', function($column, $table, $nullable = true) {
            if ($nullable) {
                $this->unsignedBigInteger($column)->nullable();
            } else {
                $this->unsignedBigInteger($column);
            }

            $this->foreign($column)->on($table)->references('id')->onUpdate('cascade');
        });
    }

    protected function registerHelpers()
    {
        foreach(glob(__DIR__ . '/Helpers/*.php') as $fileHelper){
            require_once($fileHelper);
        }
    }

    protected function registerEvents()
    {
        Event::listen(
            'Illuminate\Auth\Events\Login',
            'Smoothsystem\Core\Listeners\LogSuccessfulLogin'
        );

        Event::listen(
            'Laravel\Passport\Events\AccessTokenCreated',
            'Smoothsystem\Core\Listeners\TokenSuccessfulGenerate'
        );
    }

    protected function registerCommands()
    {
        $this->commands('Smoothsystem\Core\Commands\RefreshCommand');
    }

    protected function registerPassport()
    {
        if (!config('smoothsystem.passport.custom_routes', false)) {
            Passport::routes();
        }

        Passport::tokensExpireIn(now()->addDays(config('smoothsystem.passport.expires.token', 15)));

        Passport::refreshTokensExpireIn(now()->addDays(config('smoothsystem.passport.expires.refresh_token', 30)));

        Passport::personalAccessTokensExpireIn(now()->addMonths(config('smoothsystem.passport.expires.personal_access_token', 6)));
    }

    private function registerSessionGuard()
    {
        SessionGuard::macro('hasAuthority', function($action) {
            if (Auth::check()) {
                return false;
            }

            return true;

            /*$user = Auth::user();
            $role = $user->role ?? null;

            if (!$role) {
                return false;
            }

            return true;*/
        });
    }
}
