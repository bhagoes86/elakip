<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
