<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    const YEAR_BEGIN = 2015;    // Tahun awal
    const LONG = 5;             // Lama periode

    protected $fillable = ['year_begin', 'year_end'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
