<?php

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
            'title'  => 'Intro',
            'content' => ''
        ]);

        Page::create([
            'title'  => 'Tupoksi',
            'content' => ''
        ]);

        Page::create([
            'title'  => 'Rencana Strategis',
            'content' => ''
        ]);

        Page::create([
            'title'  => 'Regulasi',
            'content' => ''
        ]);

        Page::create([
            'title'  => 'Lakip',
            'content' => ''
        ]);
    }
}
