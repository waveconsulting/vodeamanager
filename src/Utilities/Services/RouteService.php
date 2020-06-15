<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Support\Facades\Route;

class RouteService
{
    public function apiRoutes(array $resources, array $options = []) {
        foreach ($resources as $name) {
            self::apiRoute($name, '', $options);
        }
    }

    public function apiRoute($name, string $controller = '', array $options = []) {
        self::createRoute($name, $controller, $options);
    }

    public function fileService() {
        Route::group(['prefix' => 'file-manager', 'as' => 'file-manager.', 'namespace' => '\Vodeamanager\Core\Http\Controllers'], function () {
            Route::get('/', 'FileManagerController@index')->name('index');
            Route::post('/','FileManagerController@store')->name('store');

        });
    }

    public function notificationService() {
        Route::group(['prefix' => 'notification', 'as' => 'notification.', 'namespace' => '\Vodeamanager\Core\Http\Controllers'], function () {
            Route::get('/','NotificationController@index')->name('index');
            Route::post('/read-all', 'NotificationController@readAll')->name('read-all');

        });
    }

    public function numberSettingService() {
        Route::group(['prefix' => 'number-setting', 'as' => 'number-setting.', 'namespace' => '\Vodeamanager\Core\Http\Controllers'], function () {
            Route::get('/','NumberSettingController@index')->name('index');
            Route::post('/','NumberSettingController@store')->name('store');
            Route::get('/{id}','NumberSettingController@show')->name('show');
            Route::put('/{id}','NumberSettingController@update')->name('update');
            Route::delete('/{id}','NumberSettingController@destroy')->name('destroy');
        });
    }

    private function createRoute($name, string $controller = '', array $options = []) {
        $only = ['index', 'store', 'show', 'update', 'destroy'];
        $middleware = $options['middleware'] ?? [];

        if (empty($controller)) $controller = kebab_to_pascal($name) . 'Controller';
        if (isset($options['except'])) $only = array_diff($only, (array) $options['except']);

        if (in_array('index', $only)) Route::get("/{$name}","{$controller}@index")->name($name . '.index')->middleware($middleware['index'] ?? null);
        if (in_array('store', $only)) Route::post("/{$name}","{$controller}@store")->name($name . '.store')->middleware($middleware['store'] ?? null);
        if (in_array('show', $only)) Route::get("/{$name}/{id}","{$controller}@show")->name($name . '.show')->middleware($middleware['show'] ?? null);
        if (in_array('update', $only)) Route::put("/{$name}/{id}","{$controller}@update")->name($name . '.update')->middleware($middleware['update'] ?? null);
        if (in_array('destroy', $only)) Route::delete("/{$name}/{id}","{$controller}@destroy")->name($name . '.destroy')->middleware($middleware['destroy'] ?? null);
    }
}
