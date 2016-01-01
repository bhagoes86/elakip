<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
