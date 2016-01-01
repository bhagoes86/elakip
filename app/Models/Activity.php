<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['program_id','unit_id','name'];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
