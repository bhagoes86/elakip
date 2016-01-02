<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['name','original_name','size','mime','hash','ext','location'];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class)
            ->withTimestamps();
    }

    public function agreements()
    {
        return $this->belongsToMany(Agreement::class)
            ->withTimestamps();
    }
}
