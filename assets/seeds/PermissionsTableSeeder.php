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
            if (!in_array('smoothsystem.gate', $middleware) || !$route->getName()) {
                continue;
            }

            $permission = [
                'name' => $route->getName(),
                'controller' => \Illuminate\Support\Arr::first(explode('@', $route->getActionName())),
                'method' => $route->getActionMethod(),
                'created_by' => 1,
                'updated_by' => 1,
            ];

            if (config('smoothsystem.models.permission')::where($permission)->exists()) {
                continue;
            }

            config('smoothsystem.models.permission')::create($permission);
        }
    }
}
