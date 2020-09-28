<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        config('vodeamanager.models.user')::factory()->create([
            'email' => 'admin@vodea.id',
            'password' => Hash::make('codes239'),
        ]);

        config('vodeamanager.models.user')::factory()->create([
            'email' => 'user@vodea.id',
            'password' => Hash::make('codes239'),
        ]);
    }
}
