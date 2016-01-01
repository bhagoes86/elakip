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

    public function scopeProgram($query, $id)
    {
        return $query->where('type', 'program')
            ->where('type_id', $id);
    }

    public function scopeActivity($query, $id)
    {
        return $query->where('type', 'activity')
            ->where('type_id', $id);

    }
}
