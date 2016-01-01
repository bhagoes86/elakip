<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Program;
use App\Models\Target;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TargetController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($planId, $programId, $activityId)
    {
        $target = Target::activity($activityId)->get();
        $activity = Activity::with(['program' => function ($query) {
            $query->with(['plan' => function ($query) {
                $query->with(['period']);
            }]);
        }])->find($activityId);


        return view('private.target.index')
            ->with('target', $target)
            ->with('activity', $activity)
            ->with('id', [
                'plan'  => $planId,
                'program' => $programId,
                'activity'  => $activityId
            ]);
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
    public function store(Request $request, $planId, $programId, $activityId)
    {
        $target = Target::create([
            'type'      => 'activity',
            'type_id'   => $activityId,
            'name'      => $request->get('name')
        ]);

        return $target;
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
    public function edit($planId, $programId, $activityId, $targetId)
    {
        $target = Target::find($targetId);
        return view('private.target.edit')
            ->with('id', [
                'plan'  => $planId,
                'program' => $programId,
                'activity'  => $activityId,
                'target'    => $targetId
            ])
            ->with('target', $target);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $planId, $programId, $activityId, $targetId)
    {
        $target = Target::find($targetId);
        $target->name = $request->get('name');
        return (int) $target->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId, $programId, $activityId, $targetId)
    {
        return (int) Target::destroy($targetId);
    }

    public function data(Request $request)
    {
        $programId = $request->get('program');
        $planId = $request->get('plan');
        $activityId = $request->get('activity');

        $targets = Target::activity($activityId)->get();

        return Datatables::of($targets)
            ->editColumn('name', function ($data) use ($planId, $programId, $activityId) {
                return '<a href="'.route('renstra.program.kegiatan.sasaran.indikator.index', [$planId, $programId, $activityId, $data->id]).'">'.$data->name.'</a>';
            })
            ->addColumn('action', function ($data) use ($programId, $planId, $activityId) {
                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('renstra.program.kegiatan.sasaran.edit', [$planId, $programId, $activityId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('renstra.program.kegiatan.sasaran.destroy', [$planId, $programId, $activityId, $data->id]))

                    ->render();
            })
            ->make(true);
    }
}
