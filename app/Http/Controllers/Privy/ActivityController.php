<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Program;
use App\Models\Unit;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityController extends AdminController
{
    protected $roles = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($planId, $programId)
    {
        $program = Program::with(['plan' => function ($query) {
            $query->with('period');
        }])->find($programId);

        $units_arr = [];
        foreach (Unit::all() as $unit) {
            $units_arr[$unit->id] = $unit->name;
        }


        return view('private.activity.index')
            ->with('program', $program)
            ->with('units', $units_arr);
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
    public function store(Request $request, $planId, $programId)
    {
        $program = Program::find($programId);
        $program->activities()->save(new Activity([
            'name'  => $request->get('name'),
            'unit_id'  => $request->get('unit_id')
        ]));

        return $program->activities;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId, $programId, $activityId)
    {
        return (int) Activity::destroy($activityId);
    }

    public function data(Request $request)
    {
        $programId = $request->get('program');
        $planId = $request->get('plan');
        $type = $request->get('type');

        $program = Program::with(['activities' => function ($query) {
            $query->with('unit');
        }])
            ->find($programId);

        return Datatables::of($program->activities)
            ->editColumn('name', function ($data) use ($planId, $programId) {
                return '<a href="'.route('renstra.program.kegiatan.sasaran.index', [$planId, $programId, $data->id]).'">'.$data->name.'</a>';
            })
            ->addColumn('action', function ($data) use ($programId, $planId) {
                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('renstra.program.kegiatan.edit', [$planId, $programId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-kegiatan-datatables
                        data-token='.csrf_token().'
                        data-url='.route('renstra.program.kegiatan.destroy', [$planId, $programId, $data->id]))

                    ->render();
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return string
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getSelect2(Request $request)
    {
        $program = $request->get('program');
        $program = Program::find($program);

        $options = '<option>-Select One-</option>';
        foreach ($program->activities as $activity) {
            $options .= '<option value="'.$activity->id.'">'. $activity->name. '</option>';
        }

        return $options;
    }
}
