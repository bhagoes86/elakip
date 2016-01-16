<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Budget;
use App\Models\Plan;
use App\Models\Program;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActivityAgreementController extends AdminController
{
    protected $identifier = 'activity-agreement';

    /**
     * Display a listing of the resource.
     *
     * @param $agreementId
     * @param $programId
     * @return \Illuminate\Http\Response
     */
    public function index($agreementId, $programId)
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

        $program = Program::find($programId);

        return view('private.activity_agreement.index')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId
            ])
            ->with('agreement', $agreement)
            ->with('program', $program);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($agreementId, $programId, $activityId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $agreement = Agreement::find($agreementId);

        $budget = Budget::where('year', $agreement->year)
            ->where('activity_id', $activityId)
            ->first();

        if(count($budget) == 0)
        {
            Budget::create([
                'year'  => $agreement->year,
                'activity_id'   => $activityId,
                'pagu'  => 0,
                'realization'   => 0
            ]);
        }

        $activity = Activity::with([
            'budget'    => function ($query) use ($agreement) {
                $query->where('year', $agreement->year);
            }
        ])
            ->find($activityId);

        return view('private.activity_agreement.edit')
            ->with('activity', $activity)
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'activity'  => $activityId
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agreementId, $programId, $activityId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $agreement = Agreement::find($agreementId);
        $activity = Activity::with([
            'budget'    => function ($query) use ($agreement) {
                $query->where('year', $agreement->year);
            }
        ])
            ->find($activityId);

        $budget = Budget::find($activity->budget->id);
        $budget->pagu = $request->get('pagu');
        return (int) $budget->save();
    }

    public function data(Request $request)
    {
        $agreementId = $request->get('agreement');
        $programId = $request->get('program');

        $agreement = Agreement::with(['firstPosition' => function ($query) {
            $query->with([
                'unit',
                'user'
            ]);
        }])->find($agreementId);

        $program = Program::with(['activities' => function ($query) use ($agreement) {
            $query->with([
                'unit',
                'budget' => function ($query) use ($agreement) {
                    $query->where('year', $agreement->year);
                }
            ]);

            $query->where('unit_id', $agreement->firstPosition->unit->id);
            $query->inAgreement();

        }])
            ->find($programId);

        return \Datatables::of($program->activities)
            ->editColumn('name', function ($data) use ($agreementId, $programId) {
                return '<a href="'.route('pk.program.kegiatan.sasaran.index', [$agreementId, $programId, $data->id]).'">'.$data->name.'</a>';
            })
            ->addColumn('pagu', function($data) {
                if(is_null($data->budget))
                    return 0;
                else
                    return money_format('%.2n', $data->budget->pagu);
            })
            ->addColumn('action', function ($data) use ($agreementId, $programId) {
                return view('private.activity_agreement.action')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('pk.program.kegiatan.edit', [
                            $agreementId,
                            $programId,
                            $data->id
                        ]))

                    ->render();
            })
            ->make(true);



        //return \Datatables::of()
    }
}
