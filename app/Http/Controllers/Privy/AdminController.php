<?php


namespace App\Http\Controllers\Privy;


use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller {

    protected $defaultLanguage;
    protected $identifier = 'view';
    protected $years = [];
    protected $authUser;

    function __construct()
    {

        setlocale(LC_MONETARY, 'id_ID');
        view()->share('viewId', $this->identifier);

        if(\Auth::check()) {


            $authenticatedUser = \Auth::user();

            $user = User::with([
                'media',
                'role',
                'positions' => function ($query) {
                    $query->with(['unit']);
                    $query->where('year', Carbon::now()->year);
                }
            ])->find($authenticatedUser->id);

            $this->authUser = $user;

            view()->share('authUser', $user);
            $this->setYear();

        }

        // if(!$this->hasAccess())
        //    abort(403);


    }

    public function setYear()
    {
        $periods = Period::where('year_begin', 2015)->first();
        $years = [];
        $begin = $periods->year_begin;
        $end = $periods->year_end;
        for($i=$begin; $i <= $end; $i++) {
            $years[$i] = $i;
        }

        $this->years = $years;
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