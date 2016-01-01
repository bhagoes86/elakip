<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if(DB::table('pages')->count() == 0)
            $this->call(PageTableSeeder::class);

        if(DB::table('roles')->count() == 0)
            $this->call(RoleTableSeeder::class);

        if(DB::table('units')->count() == 0)
            $this->call(UnitTableSeeder::class);

        if(DB::table('users')->count() == 0)
            $this->call(UserTableSeeder::class);

        if(DB::table('periods')->count() == 0)
            $this->call(PeriodTableSeeder::class);

        if(DB::table('plans')->count() == 0)
            $this->call(PlanTableSeeder::class);

        Model::reguard();
    }
}
