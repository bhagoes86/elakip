<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['organization_id','name','status','position'];
    protected $appends = ['last'];

    public function getIdAttribute($value)
    {
        return (int) $value;
    }

    public function getOrganizationIdAttribute($value)
    {
        return (int) $value;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function getLastAttribute()
    {
        $level = [];
        foreach ($this->education as $edu) {
            array_push($level, $edu->level);
        }

        if(in_array('s3', $level)) return 's3';
        if(in_array('s2', $level)) return 's2';
        if(in_array('s1', $level)) return 's1';
        if(in_array('sma', $level)) return 'sma';

    }
}