<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    const FIX_PLAN_ID = 1;

    protected $fillable = ['period_id'];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
