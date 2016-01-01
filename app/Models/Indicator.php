<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $fillable = ['name','unit','location'];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function indicatorYears()
    {
        return $this->hasMany(IndicatorYears::class);
    }
}
