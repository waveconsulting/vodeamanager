<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Support\Facades\Route;

class RouteService
{
    /**
     * Register route file service
     *
     * @return void
     */
    public function mediaService() {
        Route::group(['prefix' => 'media', 'as' => 'media.', 'namespace' => '\Vodeamanager\Core\Http\Controllers'], function () {
            Route::get('/', 'MediaController@index')->name('index');
            Route::post('/','MediaController@store')->name('store');
        });
    }

    /**
     * Register route notification service
     *
     * @return void
     */
    public function notificationService() {
        Route::group(['prefix' => 'notification', 'as' => 'notification.', 'namespace' => '\Vodeamanager\Core\Http\Controllers'], function () {
            Route::get('/','NotificationController@index')->name('index');
            Route::get('/{id}', 'NotificationController@show')->name('show');
            Route::post('/read-all', 'NotificationController@readAll')->name('read-all');
        });
    }

    /**
     * Register route number setting service
     *
     * @return void
     */
    public function numberSettingService() {
        Route::group(['prefix' => 'number-setting', 'as' => 'number-setting.', 'namespace' => '\Vodeamanager\Core\Http\Controllers'], function () {
            Route::get('/','NumberSettingController@index')->name('index');
            Route::post('/','NumberSettingController@store')->name('store');
            Route::get('/{id}','NumberSettingController@show')->name('show');
            Route::put('/{id}','NumberSettingController@update')->name('update');
            Route::delete('/{id}','NumberSettingController@destroy')->name('destroy');
        });
    }
}
