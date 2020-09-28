<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['code' => 'admin', 'name' => 'Administrator', 'is_special' => 1],
            ['code' => 'user', 'name' => 'User'],
        ];

        foreach ($roles as $index => $role) {
            config('vodeamanager.models.role')::create($role);
        }
    }
}
