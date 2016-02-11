<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementValue extends Model
{
    protected $fillable = ['achievement_id','goal_detail_id',
        'fisik_plan','fisik_real',
        'budget_plan','budget_real',
        'dipa'];

    protected $appends = ['quarter'];

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function goalDetail()
    {
        return $this->belongsTo(GoalDetails::class);
    }

    public function getQuarterAttribute()
    {
        return (int) $this->achievement->quarter;
    }
}
