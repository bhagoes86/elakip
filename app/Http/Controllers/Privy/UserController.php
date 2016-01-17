<?php

namespace App\Http\Controllers\Privy;

use App\Models\Position;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserUnit;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends AdminController
{
    const DITJEN_UNIT_ID = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::denies('read-user', $this->authUser))
            abort(403);

        // dd(User::find($this->authUser->id)->toArray());

        $roles = [];
        foreach (Role::all() as $role) {
            $roles[$role->id] = $role->name;
        }

        return view('private.user.index')
            ->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Gate::denies('create-user', $this->authUser))
            abort(403);

        if(\Gate::allows('read-only'))
            abort(403);

        $this->validate($request, [
            'username'  => 'required|unique:users',
            'email'     => 'required|unique:users',
            'password'  => 'required|min:7',
            'password2' => 'required|same:password'
        ]);

        return User::create([
            'username'  => $request->get('username'),
            'email'     => $request->get('email'),
            'password'  => \Hash::make($request->get('password')),
            'name'     => $request->get('name'),
            'role_id'     => $request->get('role_id')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Gate::denies('read-user', $this->authUser))
            abort(403);

        if(\Gate::allows('read-only'))
            abort(403);

        $user = User::find($id);//->with('roles');

        $roles = Role::all();

        $role_arr = [];
        foreach ($roles as $role) {
            $role_arr[$role->id] = $role->name;
        }

        $selectedRole = isset($user->roles[0]) ? $user->roles[0]->id : null;

        return view('private.user.edit', [
            'user' => $user,
            'roles' => $role_arr,
            'selectedRole' => $selectedRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Gate::denies('update-user', $this->authUser))
            abort(403);

        if(\Gate::allows('read-only'))
            abort(403);

        $this->validate($request, [
            'username'  => 'required',
            'email'     => 'required',
        ]);

        $item = User::find($id);

        $item->username = $request->get('username');
        $item->email = $request->get('email');
        $item->name = $request->get('name');
        $item->role_id = $request->get('role_id');

        if( $item->save() )
            return \Redirect::route('user.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Gate::denies('delete-user', $this->authUser))
            abort(403);

        if(\Gate::allows('read-only'))
            abort(403);

        return (int) User::destroy($id);

    }

    /**
     * Load datatables data
     *
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function data()
    {
        if (\Gate::denies('read-user', $this->authUser))
            abort(403);

        $years = User::all();

        return Datatables::of($years)
            ->addColumn('action', function($data){

                return view('private.user.action')

                    ->with('edit_action', route('user.edit', $data->id))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('user.destroy', $data->id))

                    ->with('pass_action', 'showEdit(this)')
                    ->with('pass_data', 'data-modal-id='.$this->identifier.'
                        data-title=Password
                        data-url='.route('user.password.edit', $data->id))

                    ->render();
            })
            ->make(true);
    }

    /**
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getPassword($id)
    {

        $user = User::find($id);
        return view('private.user.password')
            ->with('user', $user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function putPassword(Request $request, $id)
    {
        $this->validate($request, [
            'password'  => 'required|min:7',
            'password2' => 'required|same:password'
        ]);

        $user = User::find($id);
        $user->password = \Hash::make($request->get('password'));
        if($user->save()) {
            return \Redirect::route('user.edit', $user->id);
        }
    }

    /**
     * Second user / Pihak kedua
     *
     * @param Request $request
     * @return string
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getUserInYear(Request $request)
    {
        $year = $request->get('year');

        $positions = Position::with(['user' => function($query){
            $query->where('role_id', Role::PIMPINAN_ID);
        },'unit'])
            ->where('year', $year)
            // ->whereNotIn('unit_id', [self::DITJEN_UNIT_ID])
            ->get();


        $html = '<option>- Pilih satu -</option>';

        foreach ($positions as $position) {
            if($position->user != null) {
                $html .= '<option value="' . $position->id . '" data-unit-id="' . $position->unit->id . '">' . $position->user->name . ' (' . $position->position . ' ' . $position->year . ' - ' . $position->unit->name . ')' . '</option>';
            }
        }

        return $html;
    }

    public function getDitjenInYear(Request $request)
    {
        $year = $request->get('year');

        $positions = Position::with(['user','unit'])
            ->where('year', $year)
            // ->where('unit_id', self::DITJEN_UNIT_ID)
            ->get();

        $html = '<option>- Pilih satu -</option>';


        foreach ($positions as $position) {
            $html .= '<option value="'.$position->id.'">'.$position->user->name . ' (' . $position->position . ' ' . $position->year . ' - ' . $position->unit->name . ')'.'</option>';
        }

        return $html;
    }

    public function getFirstUserInYear(Request $request)
    {
        //dd($this->authUser->current_position['unit_id']);

        $year = $request->get('year');

        $positions = Position::with(['user','unit']);
        $positions->where('year', $year);

        if($this->authUser->role->id == 2) {
            $positions->where('unit_id', $this->authUser->current_position['unit_id']);
        }
            // ->where('unit_id', self::DITJEN_UNIT_ID)
        $positions = $positions->get();

        //dd($positions);

        $html = '<option>- Pilih satu -</option>';


        foreach ($positions as $position) {
            $html .= '<option value="'.$position->id.'">'.$position->user->name . ' (' . $position->position . ' ' . $position->year . ' - ' . $position->unit->name . ')'.'</option>';
        }

        return $html;
    }
}
