<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Program;
use App\Models\Unit;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

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
        /*if(\Gate::denies('has-position', null))
            abort(403);*/

        $program = Program::with(['plan' => function ($query) {
            $query->with('period');
        }])->find($programId);

        $units_arr = [];
        foreach (Unit::whereNotIn('id', [1])->get() as $unit) {
            $units_arr[$unit->id] = $unit->name;
        }


        return view('private.activity.index')
            ->with('program', $program)
            ->with('units', $units_arr)
            ->with('user', $this->authUser);

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
        if(\Gate::allows('read-only'))
            abort(403);

        $program = Program::find($programId);
        $program->activities()->save(new Activity([
            'name'  => $request->get('name'),
            'unit_id'  => $request->get('unit_id'),
            'in_agreement' => $request->get('in_agreement') ? true : false
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
     * @param $planId
     * @param $programId
     * @param $activityId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($planId, $programId, $activityId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $activity = Activity::find($activityId);

        $units_arr = [];
        foreach (Unit::whereNotIn('id', [1])->get() as $unit) {
            $units_arr[$unit->id] = $unit->name;
        }

        return view('private.activity.edit')
            ->with('activity', $activity)
            ->with('units', $units_arr)
            ->with('id',[
                'plan'      => $planId,
                'program'   => $programId,
                'activity'  => $activityId
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $planId
     * @param $programId
     * @param $activityId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $planId, $programId, $activityId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $activity = Activity::find($activityId);
        $activity->name = $request->get('name');
        $activity->unit_id = $request->get('unit_id');
        $activity->in_agreement = $request->get('in_agreement') ? true : false;
        return (int) $activity->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $planId
     * @param $programId
     * @param $activityId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($planId, $programId, $activityId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        return (int) Activity::destroy($activityId);
    }

    public function data(Request $request)
    {
        $programId  = $request->get('program');
        $planId     = $request->get('plan');
        $type       = $request->get('type');

        $program = Program::with(['activities' => function ($query) {
            $query->with('unit');

            // Jika operator
            // dan jika bukan DIRJEN
            // maka tambah where
            if( $this->authUser->role->name == 'Operator' AND
                $this->authUser->positions[0]->unit->id != 1)
            {
                $query->where('unit_id', $this->authUser->positions[0]->unit->id);
            }
        }])->find($programId);

        return Datatables::of($program->activities)
            ->editColumn('name', function ($data) use ($planId, $programId) {
                return '<a href="'.route('renstra.program.kegiatan.sasaran.index', [$planId, $programId, $data->id]).'">'.$data->name.'</a>';
            })
            ->editColumn('in_agreement', function($data) {
                if($data->in_agreement) {
                    $fa = 'fa-check';
                    $color = '#81B71A';
                }
                else
                {
                    $fa = 'fa-times';
                    $color = '#E9573F';
                }

                return '<span style="color: '.$color.'"><i class="fa '.$fa.'"></i></span>';
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
        $programId = $request->get('program');

        if($request->has('agreement')) {
            $agreementId = $request->get('agreement');
            $agreement = Agreement::with([
                'firstPosition' => function($query) {
                    $query->with(['unit']);
                }
            ])
                ->find($agreementId);

            $program = Program::with(['activities' => function($query) use ($agreement) {
                $query->where('unit_id', $agreement->firstPosition->unit->id);
            }])->find($programId);

        }
        elseif($request->has('unit')) {
            $unitId = $request->get('unit', null);
            $program = Program::with(['activities' => function($query) use ($unitId) {
                $query->where('unit_id', $unitId);
            }])->find($programId);
        }
        else
        {
            $program = Program::find($programId);
        }



        $options = '<option>-Select One-</option>';
        foreach ($program->activities as $activity) {
            $options .= '<option value="'.$activity->id.'">'. $activity->name. '</option>';
        }

        return $options;
    }
}
