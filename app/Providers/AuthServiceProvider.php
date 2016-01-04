<?php

namespace App\Providers;

use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->define('read-user', function($user, $userView) {
            if($user->role->name == 'Administrator')
                return true;
        });

        $gate->define('create-user', function($user, $userView) {
            if($user->role->name == 'Administrator')
                return true;
        });

        $gate->define('update-user', function($user, $userView) {
            if($user->role->name == 'Administrator')
                return true;
        });

        $gate->define('delete-user', function($user, $userView) {
            if($user->role->name == 'Administrator')
                return true;
        });

        /**
         * -------Page-----------
         */
        $gate->define('read-page', function($user, $page) {
            if($user->role->name == 'Administrator')
                return true;
        });

        $gate->define('update-page', function($user, $page) {
            if($user->role->name == 'Administrator')
                return true;
        });

        /**
         * ---------Unit--------
         */
        $gate->define('choose-unit', function($user, $unit) {

            //dd(count($user->positions));

            if($user->role->name == 'Administrator')
                return true;

            if($user->role->name == 'Pimpinan')
                return true;
        });


        $gate->define('has-position', function($user) {
            if(count($user->positions) > 0)
                return true;
        });

        // Route jika pimpinan, maka tidak bisa edit
        $gate->define('read-only', function($user) {
            if($user->role->name == 'Pimpinan')
                return true;
        });

        // Hanya dirjen saja yang bisa akses
        $gate->define('dirjen', function($user) {
            //if($user->role->id == 2) {
                /*$position = Position::where('user_id', $user->id)
                    ->where('year', Carbon::now()->year)
                    ->first();

                if(count($position) == 1) {
                    if ($position->unit_id == 1)
                        return true;
                }*/

            //}
        });
    }
}
