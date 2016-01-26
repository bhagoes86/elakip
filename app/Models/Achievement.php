<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['goal_id','quarter','plan','realization','budget_plan','budget_realization'];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'achievement_media')
            ->withTimestamps();
    }
}
