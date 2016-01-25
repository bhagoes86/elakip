<?php

use App\Models\Plan;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::find(1);
        $plan->programs()->save(new Program([
            'name'  => 'Pengembangan Perumahan'
        ]));
    }
}
