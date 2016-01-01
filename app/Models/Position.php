<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function firstAgreements()
    {
        return $this->belongsTo(Agreement::class, 'first_position_id');
    }

    public function secondAgreements()
    {
        return $this->belongsTo(Agreement::class, 'second_position_id');
    }

}
