<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@ss.com',
                'password' => bcrypt('test12345'),
            ],
            [
                'name' => 'user',
                'email' => 'user@ss.com',
                'password' => bcrypt('test12345'),
            ],
        ];

        foreach ($users as $index => $user) {
            if ($index != 0) {
                $user['created_by'] = 1;
                $user['updated_by'] = 1;
            }

            $user['email_verified_at'] = now();
            $user['remember_token'] = Str::random(10);

            config('smoothsystem.models.user')::create($user);
        }
    }
}
