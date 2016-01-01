<?php

namespace App\Http\Controllers\Privy\Dirjen;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Indicator;
use App\Models\Program;
use App\Models\Target;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndicatorController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($planId, $programId, $targetId)
    {
        $target = Target::find($targetId);
        $program = Program::with(['plan' => function($query){
            $query->with('period');
        }])->find($programId);

        // dd($program->toArray());

        return view('private.indicator.program_index')
            ->with('target', $target)
            ->with('program', $program);
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
    public function store(Request $request, $planId, $programId, $targetId)
    {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($planId, $programId, $targetId, $indicatorId)
    {
        return view('private.indicator.program_edit')
            ->with('id', [
                'plan'  => $planId,
                'program'   => $programId,
                'target'    => $targetId,
                'indicator' => $indicatorId
            ])
            ->with('indicator', Indicator::find($indicatorId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $planId, $programId, $targetId, $indicatorId)
    {
        $indicator = Indicator::find($indicatorId);
        $indicator->name = $request->get('name');
        $indicator->unit = $request->get('unit');
        $indicator->location = $request->get('location');
        return (int) $indicator->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId, $programId, $targetId, $indicatorId)
    {
        return (int) Indicator::destroy($indicatorId);
    }

    public function data(Request $request)
    {
        $planId = $request->get('plan');
        $programId = $request->get('program');
        $targetId = $request->get('target');

        $target = Target::find($targetId);


        return Datatables::of($target->indicators)

            ->addColumn('action', function ($data) use ($planId, $programId, $targetId) {
                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('renstra.program.sasaran.indikator.edit', [$planId, $programId, $targetId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('renstra.program.sasaran.indikator.destroy', [$planId, $programId, $targetId, $data->id]))

                    ->render();
            })
            ->make(true);
    }
}
