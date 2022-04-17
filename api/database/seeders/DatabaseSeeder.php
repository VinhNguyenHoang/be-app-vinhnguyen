<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // seeder for Admin account
        DB::table('users')->delete();
        DB::table('users')->insert([
            'id' => 1,
            'email' => 'admin@gm.test',
            'password' => Hash::make(123456),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // seeder for Events table
        DB::table('events')->delete();
        DB::table('events')->insert(array(
            [
                'id' => 1,
                'name' => 'Event A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Event B',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ));
    }
}
