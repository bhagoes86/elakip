<?php

use App\Models\Period;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $period = Period::where('year_begin', 2015)->first();
        $period->plans()->save(new Plan());
    }
}
