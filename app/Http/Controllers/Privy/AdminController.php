<?php


namespace App\Http\Controllers\Privy;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;

class AdminController extends Controller {

    protected $defaultLanguage;
    protected $identifier = 'view';

    function __construct()
    {

        view()->share('viewId', $this->identifier);

        if(\Auth::check()) {
            $authenticatedUser = \Auth::user();
            $user = User::with('role')->find($authenticatedUser->id);
            view()->share('authUser', $user);
        }
        // if(!$this->hasAccess())
        //    abort(403);


    }

    /**
     * @param $router
     * @return \Illuminate\Http\RedirectResponse
     */
    private function hasAccess()
    {

        if(\Auth::guest())
            return redirect()->guest('login');

        $groupId = \Auth::user()->group_id;


        $permission = Permission::where('action', \Route::currentRouteAction())->first();
        if($permission->roles->count())
        {
            return true;

        }

        return false;
    }
}