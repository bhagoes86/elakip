<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function activity()
    {
        return $this->hasOne(Activity::class);
    }
}
