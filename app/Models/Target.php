<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}
