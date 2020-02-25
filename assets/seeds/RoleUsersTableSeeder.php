<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'admin@ss.com' => 'admin',
            'user@ss.com' => 'user',
        ];

        foreach ($users as $email => $role) {
            $role = config('vodeamanager.models.role')::where('code', $role)->first();
            $user = config('vodeamanager.models.user')::where('email', $email)->first();

            if ($user && $role) {
                $user->roles()->sync($role);
            }
        }
    }
}
