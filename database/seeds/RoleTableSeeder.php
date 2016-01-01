<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    protected $roles = [
        'Administrator',
        'Operator',
        'Pimpinan'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->roles as $role) {

            Role::create([
                'name'  => $role
            ]);
        }
    }
}
