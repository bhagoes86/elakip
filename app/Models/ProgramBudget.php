<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramBudget extends Model
{
    protected $fillable = ['year','program_id','pagu','realization'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
