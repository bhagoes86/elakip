<?php
/**
 * Created by PhpStorm.
 * User: Akung
 * Date: 25/01/2016
 * Time: 15:58
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['staff_id','level','institution','major'];

    /**
     * @param $value
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getIdAttribute($value)
    {
        return (int) $value;
    }

    /**
     * @param $value
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getStaffIdAttribute($value)
    {
        return (int) $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function staff()
    {
        return $this->hasMany(Education::class);
    }
}