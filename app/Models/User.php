<?php

namespace App\Models;

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
    protected $fillable = ['username','name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function units()
    {
        return $this->belongsToMany(Unit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function firstAgreement()
    {
        return $this->hasMany(Agreement::class, 'first_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function secondAgreement()
    {
        return $this->hasMany(Agreement::class, 'second_user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }
}
