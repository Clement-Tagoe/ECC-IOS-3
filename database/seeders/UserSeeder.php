<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' =>bcrypt('12345678'),
            'contact' => '0244565458',
            'department_id' => 1,
        ]); 

        User::create([
            'name' => 'Joyce Benson',
            'email' => 'joyce@gmail.com',
            'password' =>bcrypt('12345678'),
            'contact' => '0204532126',
            'department_id' => 3,
        ]);

        User::create([
            'name' => 'Kojo Hayford',
            'email' => 'kojo@gmail.com',
            'password' =>bcrypt('12345678'),
            'contact' => '0269097543',
            'department_id' => 3,
        ]);

        User::create([
            'name' => 'Mary Johnson',
            'email' => 'mary@gmail.com',
            'password' =>bcrypt('12345678'),
            'contact' => '0244123098',
            'department_id' => 3,
        ]);
    }
}
