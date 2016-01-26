<?php
/**
 * Created by PhpStorm.
 * User: Akung
 * Date: 26/01/2016
 * Time: 17:06
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GoalDetails extends Model
{
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}