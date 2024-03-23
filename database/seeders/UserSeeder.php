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
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'secret',
        ]);

        $user->roles()->attach([1,3]);


        $user2 = User::create([
            'name' => 'Abdulloh',
            'email' => 'abdulloh@example.com',
            'password' => 'secret',
        ]);

        $user2->roles()->attach([2]);

      //  \App\Models\User::factory(10)->create();
    }
}
