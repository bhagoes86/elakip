<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'  => 'admin',
            'email'     => 'admin@silap-kinerja.com',
            'name'      => 'Administrator',
            'password'  => Hash::make('secret')
        ]);
    }
}
