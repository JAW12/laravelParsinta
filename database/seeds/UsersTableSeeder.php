<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Jem Angkasa Wijaya',
            'username' => 'jemaw',
            'password' => bcrypt('password'),
            'email' => 'jem.angkasa91@gmail.com'
        ]);
    }
}
