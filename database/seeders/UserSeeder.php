<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'admin',
            'email' => 'admin@tradepal.tn',
            'username' => 'adminTradePal',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        User::factory(10)->create();

    }
}
