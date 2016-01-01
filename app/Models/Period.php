<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
