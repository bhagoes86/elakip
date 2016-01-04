<?php

namespace App\Http\Middleware;

use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Closure;

class NotAdminPosition
{
    /**
     * Check jika posisi user belum di assign ke tahun berjalan.
     * Jika belum di assign maka akan redirect ke halaman 403
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();

        $user = User::with('role')->find($user->id);

        if($user->role->id != 1) // Jika bukan admin, alias pimpinan dan operator
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
