<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routes = Route::getRoutes()->getRoutes();
        foreach ($routes as $route) {
            $middleware = $route->gatherMiddleware();
            if (!in_array('vodeamanager.gate', $middleware) || !$route->getName()) {
                continue;
            }

            $permission = [
                'name' => $route->getName(),
                'controller' => \Illuminate\Support\Arr::first(explode('@', $route->getActionName())),
                'method' => $route->getActionMethod(),
                'created_by' => 1,
                'updated_by' => 1,
            ];

            if (config('vodeamanager.models.permission')::where($permission)->exists()) {
                continue;
            }

            config('vodeamanager.models.permission')::create($permission);
        }
    }
}
