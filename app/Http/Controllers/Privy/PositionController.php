<?php

namespace App\Http\Controllers\Privy;

use App\Models\Period;
use App\Models\Position;
use App\Models\Unit;
use App\Models\User;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PositionController extends AdminController
{
    protected $roles = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::where('year_begin', 2015)->first();
        $years = [];
        $begin = $periods->year_begin;
        $end = $periods->year_end;
        for($i=$begin; $i <= $end; $i++) {
            $years[$i] = $i;
        }

        $user_arr = [];
        foreach (User::all() as $user) {
            $user_arr[$user->id] = $user->name;
        }

        $unit_arr = [];
        foreach (Unit::all() as $unit) {
            $unit_arr[$unit->id]    = $unit->name;
        }

        return view('private.position.index')
            ->with('years', $years)
            ->with('users', $user_arr)
            ->with('units', $unit_arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->roles);

        return Position::create([
            'user_id'    => $request->get('user'),
            'unit_id'    => $request->get('unit'),
            'year'       => $request->get('year'),
            'position'   => $request->get('position'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::find($id);

        return view('private.position.edit')
            ->with('position', $position);
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
        $this->validate($request, $this->roles);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (int) Position::destroy($id);
    }

    public function data(Request $request)
    {
        $year = $request->get('year');

        $position = Position::with([
            'user',
            'unit',
        ])->where('year', $year)
            ->get();

        return Datatables::of($position)
            ->addColumn('action', function($data){

                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('position.edit', $data->id))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('position.destroy', $data->id))

                    ->render();
            })
            ->make(true);
    }

    public function getSelectUser($year)
    {
        $userIds = Position::where('year', $year)->lists('user_id');
        $users = User::whereNotIn('id', $userIds)->get();

        $html = "";

        foreach ($users as $user) {
            $html .= "<option value='$user->id'>$user->name</option>";
        }

        return $html;
    }
}
