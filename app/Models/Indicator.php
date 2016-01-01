<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function indicatorYears()
    {
        return $this->hasMany(IndicatorYears::class);
    }
}
