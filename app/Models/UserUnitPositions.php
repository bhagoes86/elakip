<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUnitPositions extends Model
{
    protected $table = 'positions_with_user_unit';

    public function position()
    {
        return $this->hasOne(Position::class);
    }
}
