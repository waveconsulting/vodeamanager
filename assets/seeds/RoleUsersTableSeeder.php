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
            'admin@vodea.id' => 'admin',
            'user@vodea.id' => 'user',
        ];

        foreach ($users as $email => $role) {
            $role = config('vodeamanager.models.role')::where('code', $role)->firstOrFail();
            $user = config('vodeamanager.models.user')::where('email', $email)->firstOrFail();

            $user->roleUsers()->create([
                'role_id' => $role->id,
                'valid_from' => now(),
            ]);
        }
    }
}
