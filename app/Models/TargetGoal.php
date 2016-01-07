<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetGoal extends Model
{
    protected $fillable = ['type','type_id','name'];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
