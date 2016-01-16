<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username','name', 'email', 'password','role_id','picture_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['current_position'];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'picture_id');
    }

    public function getCurrentPositionAttribute()
    {
        if(\Auth::check()) {

            $position = Position::with(['unit'])
                ->where('year', Carbon::now()->year)
                ->where('user_id', \Auth::user()->id)
                ->first();

            return [
                'unit_id'   => isset($position->unit) ? $position->unit->id : null,
                'unit_name' => isset($position->unit) ? $position->unit->name : null
            ];

        } else {
            return null;
        }
    }
}
