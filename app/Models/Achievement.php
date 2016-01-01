<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public function indicatorYear()
    {
        return $this->belongsTo(IndicatorYears::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'achievement_media')
            ->withTimestamps();
    }
}
