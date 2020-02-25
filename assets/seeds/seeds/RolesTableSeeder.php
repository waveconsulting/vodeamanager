<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'code' => 'admin',
                'name' => 'Administrator',
                'is_special' => 1,
            ],
            [
                'code' => 'user',
                'name' => 'User',
            ],
        ];

        foreach ($roles as $index => $role) {
            $role['created_by'] = 1;
            $role['updated_by'] = 1;

            config('smoothsystem.models.role')::create($role);
        }
    }
}
