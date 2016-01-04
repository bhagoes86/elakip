<?php

namespace App\Http\Middleware;

use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Closure;

class OperatorPosition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = \Auth::user();

        $user = User::with('role')->find($user->id);

        if($user->role->id == 2) // Jika operator
        {
            $position = Position::with(['unit'])
                ->where('year', Carbon::now()->year)
                ->where('user_id', $user->id)
                ->first();

            if(count($position) == 0)
                return \Redirect::to('error/not-authorized');
        }

        return $next($request);
    }
}
