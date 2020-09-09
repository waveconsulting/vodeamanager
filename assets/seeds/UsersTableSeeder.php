<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
        factory(config('vodeamanager.models.user'))->create([
            'name' => 'Administrator',
            'email' => 'admin@vodea.id',
            'password' => bcrypt('codes239'),
        ]);

        factory(config('vodeamanager.models.user'))->create([
            'name' => 'user',
            'email' => 'user@vodea.id',
            'password' => bcrypt('codes239'),
        ]);
    }
}
