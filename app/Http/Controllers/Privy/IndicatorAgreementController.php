<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Goal;
use App\Models\GoalDetails;
use App\Models\Program;
use App\Models\Target;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndicatorAgreementController extends AdminController
{
    protected $rules = [
        'count' => 'required|integer'
    ];
    protected $messages = [
        'count.required' => 'Target wajib diisi.',
        'count.integer' => 'Target harus angka.'
    ];

    /**
     * Display a listing of the resource.
     *
     * @param $agreementId
     * @param $programId
     * @param $activityId
     * @param $targetId
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
     * @param $agreementId
     * @param $programId
     * @param $activityId
     * @param $targetId
     * @param $indicatorId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($agreementId, $programId, $activityId, $targetId, $indicatorId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

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
     * @param  \Illuminate\Http\Request $request
     * @param $agreementId
     * @param $programId
     * @param $activityId
     * @param $targetId
     * @param $indicatorId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $agreementId, $programId, $activityId, $targetId, $indicatorId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $this->validate($request, $this->rules, $this->messages);

        $goal = Goal::where('year', Agreement::find($agreementId)->year)
            ->where('indicator_id', $indicatorId)
            ->first();

        if($request->has('with_detail')) {
            $goal->with_detail = true;
            $goal->count = $this->insertDetail($goal->id, $request->get('count'));
        }
        else {
            $goal->with_detail = false;
            $this->insertDetail($goal->id, 1);
            $goal->count = $request->get('count');
        }

        $goalResult = $goal->save();


        return (int) $goalResult;
    }


    public function data(Request $request)
    {
        $programId = Program::FIX_PROGRAM_ID; //$request->get('program');
        $agreementId = $request->get('agreement');
        $activityId = $request->get('activity');
        $targetId = $request->get('target');

        $target = Target::with(['indicators' => function ($query) use ($agreementId) {
            $query->with(['goals' => function ($query) use ($agreementId) {
                $query->where('year', Agreement::find($agreementId)->year);
            }]);
        }])->find($targetId);

        return \Datatables::of($target->indicators)
            ->editColumn('name', function($data) use ($agreementId, $programId, $activityId, $targetId) {
                //if($data->goals[0]->with_detail) {
                    return '<a href="'.route('pk.program.kegiatan.sasaran.indikator.detail.index', [
                        $agreementId,
                        $programId,
                        $activityId,
                        $targetId,
                        $data->id
                    ]).'">'.$data->name.'</a>';
                /*}
                else
                    return $data->name;*/
            })
            ->addColumn('target', function($data) {
                return (0 == count($data->goals)) ? 0 : $data->goals[0]->count . ' ' . $data->unit;
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

    /**
     * @param $id
     * @param $count
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    private function insertDetail($id, $count)
    {
        $details = GoalDetails::where('goal_id', $id)->get();


        // Jika tidak ada detail
        // maka tambahkan empty detail sesuai dengan
        // jumlah countnya
        if(count($details) == 0)
        {
            $goal = Goal::find($id);

            $goalDetails = [];
            for($i = 0; $i < $count; $i++) {
                array_push($goalDetails, new GoalDetails());
            }

            $goal->details()->saveMany($goalDetails);
        }

        // Jika angka detailnya bertambah
        // maka tambah baris sesuai dengan
        // selisih antara detail lama denagan
        // angka detail baru
        elseif(count($details) < $count)
        {
            $goal = Goal::find($id);

            $goalDetails = [];
            for($i = 0; $i < ($count - count($details)); $i++) {
                array_push($goalDetails, new GoalDetails());
            }

            $goal->details()->saveMany($goalDetails);

        }

        // Jika masukan detail lebih kecil
        // dari jumlah baris record detail,
        // maka hapus semua record yang null
        elseif(count($details) > $count)
        {
            $nullGoalDetails = GoalDetails::where('description', null)
                ->where('goal_id', $id)
                ->get();

            $nullGoalDetailsSubtract = [];
            foreach ($nullGoalDetails as $nullGoalDetail) {
                array_push($nullGoalDetailsSubtract, $nullGoalDetail->id);

                if(($details->count() - (int) $count) == count($nullGoalDetailsSubtract))
                    break;
            }

            GoalDetails::destroy($nullGoalDetailsSubtract);
        }

        return GoalDetails::where('goal_id', $id)->count();
    }
}
