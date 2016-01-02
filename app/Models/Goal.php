<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['indicator_id','year','count'];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function scopeIndicatorId($query, $id)
    {
        return $query->where('indicator_id', $id);
    }

    public function scopeYear($query, $year)
    {
        return $query->where('year', $year);

    }
}
