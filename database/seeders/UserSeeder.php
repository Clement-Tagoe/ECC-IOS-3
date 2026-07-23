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
            'name' => 'Linus Darimaani',
            'email' => 'linus@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244565458',
            'department_id' => 1,
        ]); 

        User::create([
            'name' => 'Clement Tagoe',
            'email' => 'clement@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0204532126',
            'department_id' => 2,
        ]);

        User::create([
            'name' => 'Daniel Adjei',
            'email' => 'daniel@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0269097543',
            'department_id' => 6,
        ]);

        User::create([
            'name' => 'Edith Amofah',
            'email' => 'edith@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 6,
        ]);

        User::create([
            'name' => 'Bubu Kumordji',
            'email' => 'bubu@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 6,
        ]);

        User::create([
            'name' => 'Seth Asamoah',
            'email' => 'seth@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 6,
        ]);

        User::create([
            'name' => 'Derrick Asare Bediako',
            'email' => 'derrick@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 2,
        ]);

        User::create([
            'name' => 'Stephen Amuquandoh',
            'email' => 'stephen@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 6,
        ]);

        User::create([
            'name' => 'Rudolf Quansah',
            'email' => 'rudolf@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 6,
        ]);

        User::create([
            'name' => 'Ebenezer Asare',
            'email' => 'eben@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 10,
        ]);

        User::create([
            'name' => 'Abigail Crentsil',
            'email' => 'abigail@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 10,
        ]);

        User::create([
            'name' => 'Ivan Gaisie',
            'email' => 'ivan@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 4,
        ]);

        User::create([
            'name' => 'Justice Owusu',
            'email' => 'justice@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 4,
        ]);

        User::create([
            'name' => 'Monica Dufie Amankwah',
            'email' => 'monica@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 4,
        ]);

        User::create([
            'name' => 'Patience Kwafo',
            'email' => 'patience@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 3,
        ]);

        User::create([
            'name' => 'Georgia Oduro',
            'email' => 'georgia@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 7,
        ]);

        User::create([
            'name' => 'Nana Adjoa Asiedua',
            'email' => 'nana@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 9,
        ]);

        User::create([
            'name' => 'Rosemond Adjei',
            'email' => 'rosemond@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 5,
        ]);

        User::create([
            'name' => 'Osman',
            'email' => 'osman@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 5,
        ]);

        User::create([
            'name' => 'John Bengabu',
            'email' => 'john@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 5,
        ]);

        User::create([
            'name' => 'Olando Hisham',
            'email' => 'olando@ecc.com',
            'password' =>bcrypt('1234'),
            'contact' => '0244123098',
            'department_id' => 8,
        ]);
    }
}
