<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsuarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@correo.com',
            'password' => bcrypt('123456789'),
        ]);
    }
}
