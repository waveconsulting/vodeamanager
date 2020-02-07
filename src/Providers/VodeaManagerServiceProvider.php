<?php

namespace Vodea\Vodeamanager\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class VodeaManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('userTimeStamps', function($created = 'created_by', $updated = 'updated_by', $deleted = 'deleted_by', $table = 'users', $reference = 'id') {
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
}

