<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Goal;
use App\Models\Target;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndicatorAgreementController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($agreementId, $programId, $activityId, $targetId)
    {
        $agreement = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with([
                    'user',
                    'unit'
                ]);
            },
            'secondPosition' => function ($query) {
                $query->with([
                    'user',
                    'unit'
                ]);
            }
        ])->find($agreementId);

        $activity = Activity::find($activityId);
        $target = Target::find($targetId);

        return view('private.indicator_agreement.index')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'activity'  => $activityId,
                'target'    => $targetId,
            ])
            ->with('agreement', $agreement)
            ->with('target', $target)
            ->with('activity', $activity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agreementId, $programId, $activityId, $targetId, $indicatorId)
    {
        $agreement = Agreement::find($agreementId);

        $goal = Goal::with('indicator')->where('year', $agreement->year)
            ->where('indicator_id', $indicatorId)
            ->first();

        if($goal == null)
        {
            $goal = Goal::create([
                'year'  => $agreement->year,
                'indicator_id'  => $indicatorId,
                'count' => 0
            ]);
        }

        return view('private.indicator_agreement.edit')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'activity'    => $activityId,
                'target'    => $targetId,
                'indicator'    => $indicatorId,
            ])
            ->with('goal', $goal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agreementId, $programId, $activityId, $targetId, $indicatorId)
    {
        $goal = Goal::where('year', Agreement::find($agreementId)->year)
            ->where('indicator_id', $indicatorId)
            ->first();

        $goal->count = $request->get('count');
        return (int) $goal->save();
    }


    public function data(Request $request)
    {
        $programId = $request->get('program');
        $agreementId = $request->get('agreement');
        $activityId = $request->get('activity');
        $targetId = $request->get('target');

        $target = Target::with(['indicators' => function ($query) use ($agreementId) {
            $query->with(['goals' => function ($query) use ($agreementId) {
                $query->where('year', Agreement::find($agreementId)->year);
            }]);
        }])->find($targetId);

        return \Datatables::of($target->indicators)
            ->addColumn('target', function($data) {
                return 0 == count($data->goals) ? 0 : $data->goals[0]->count;
            })
            ->addColumn('action', function($data) use ($agreementId, $programId, $activityId, $targetId) {
                return view('private.indicator_agreement.action')
                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('pk.program.kegiatan.sasaran.indikator.edit', [
                            $agreementId,
                            $programId,
                            $activityId,
                            $targetId,
                            $data->id
                        ]))

                    ->render();
            })
            ->make(true);
    }
}
