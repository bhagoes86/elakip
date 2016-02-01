<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Indicator;
use App\Models\Target;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndicatorController extends AdminController
{
    protected $rules = [
        'name'  => 'required',
        'unit'  => 'required'
    ];
    protected $messages = [
        'name.required' => 'Indikator wajib diisi',
        'unit.required' => 'Satuan wajib diisi',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param $planId
     * @param $programId
     * @param $activityId
     * @param $targetId
     * @return \Illuminate\Http\Response
     */
    public function index($planId, $programId, $activityId, $targetId)
    {
        $target = Target::find($targetId);
        $activity = Activity::with(['program' => function ($query) {
            $query->with(['plan' => function ($query) {
                $query->with(['period']);
            }]);
        }])->find($activityId);

        return view('private.indicator.index')
            ->with('target', $target)
            ->with('activity', $activity);
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
     * @param  \Illuminate\Http\Request $request
     * @param $planId
     * @param $programId
     * @param $activityId
     * @param $targetId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $planId, $programId, $activityId, $targetId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $this->validate($request, $this->rules, $this->messages);

        $target = Target::find($targetId);
        $target->indicators()->save(new Indicator([
            'name'  => $request->get('name'),
            'unit'  => $request->get('unit'),
            'location'  => $request->get('location'),
        ]));

        return $target->indicators;
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
     * @param $targetId
     * @param $indicatorId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($planId, $programId, $activityId, $targetId, $indicatorId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $indicator = Indicator::find($indicatorId);
        return view('private.indicator.edit')
            ->with('id', [
                'plan'  => $planId,
                'program' => $programId,
                'activity'  => $activityId,
                'target'    => $targetId,
                'indicator'    => $indicatorId
            ])
            ->with('indicator', $indicator);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $planId
     * @param $programId
     * @param $activityId
     * @param $targetId
     * @param $indicatorId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $planId, $programId, $activityId, $targetId, $indicatorId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $this->validate($request, $this->rules, $this->messages);


        $indicator = Indicator::find($indicatorId);
        $indicator->name = $request->get('name');
        $indicator->unit = $request->get('unit');
        $indicator->location = $request->get('location');
        return (int) $indicator->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $planId
     * @param $programId
     * @param $activityId
     * @param $targetId
     * @param $indicatorId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($planId, $programId, $activityId, $targetId, $indicatorId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        return (int) Indicator::destroy($indicatorId);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function data(Request $request)
    {
        $programId = $request->get('program');
        $planId = $request->get('plan');
        $activityId = $request->get('activity');
        $targetId = $request->get('target');

        $target = Target::find($targetId);

        return Datatables::of($target->indicators)

            ->addColumn('action', function ($data) use ($programId, $planId, $activityId, $targetId) {
                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('renstra.program.kegiatan.sasaran.indikator.edit', [$planId, $programId, $activityId, $targetId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('renstra.program.kegiatan.sasaran.indikator.destroy', [$planId, $programId, $activityId, $targetId, $data->id]))

                    ->render();
            })
            ->make(true);
    }
}
