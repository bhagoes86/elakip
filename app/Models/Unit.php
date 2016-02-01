<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    const DIRJEN_ID = 1;

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
