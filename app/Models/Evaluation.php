<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['year','issue','solutions'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
