<?php

use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Period::create([
            'year_begin'    => 2015,
            'year_end'      => 2019
        ]);
    }
}
