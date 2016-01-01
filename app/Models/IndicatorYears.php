<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorYears extends Model
{
    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
