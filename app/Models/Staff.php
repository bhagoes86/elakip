<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['organization_id','name','status','position'];

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

    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}