<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class)
            ->withTimestamps();
    }

    public function agreements()
    {
        return $this->belongsToMany(Agreement::class);
    }
}
