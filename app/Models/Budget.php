<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['year','activity_id','pagu','realization'];

    public function getPaguAttribute($value)
    {
        return (int) $value;
    }


    public function getRealizationAttribute($value)
    {
        return (int) $value;
    }

    public function activity()
    {
        return $this->hasOne(Activity::class);
    }
}
