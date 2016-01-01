<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{

    protected $fillable = ['type','type_id','name'];

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }

    public function scopeProgram($query)
    {
        return $query->where('type', 'program');
    }

    public function scopeActivity($query)
    {
        return $query->where('type', 'activity');
    }
}
