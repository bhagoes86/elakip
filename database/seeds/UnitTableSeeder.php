<?php

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    protected $units = [
        'Direktorat Jenderal Penyediaan Perumahan',
        'Sekretariat Direktorat Jenderal Penyediaan Perumahan',
        'Direktorat Perencanaan Penyediaan Perumahan',
        'Direktorat Rumah Susun',
        'Direktorat Rumah Khusus',
        'Direktorat Rumah Swadaya',
        'Direktorat Rumah Umum dan Komersial',
        'Lainnya'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->units as $unit) {
            Unit::create([
                'name'  => $unit
            ]);
        }

    }
}
