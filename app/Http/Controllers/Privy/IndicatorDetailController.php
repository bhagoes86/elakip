<?php
/**
 * Created by PhpStorm.
 * User: Akung
 * Date: 26/01/2016
 * Time: 20:13
 */

namespace App\Http\Controllers\Privy;


use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Goal;
use App\Models\GoalDetails;
use App\Models\Indicator;
use App\Models\Program;
use App\Models\Target;
use Illuminate\Http\Request;

class IndicatorDetailController extends AdminController
{
    public function index($agreementId, $programId, $activityId, $targetId, $indicatorId)
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
        $indicator = Indicator::find($indicatorId);



        return view('private.indicator_detail.index')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'activity'  => $activityId,
                'target'    => $targetId,
                'indicator' => $indicatorId
            ])
            ->with('agreement', $agreement)
            ->with('target', $target)
            ->with('activity', $activity)
            ->with('indicator', $indicator);
    }

    public function store($agreementId, $programId, $activityId, $targetId, $indicatorId)
    {

    }

    public function edit($agreementId, $programId, $activityId, $targetId, $indicatorId, $detailId)
    {
        $detail = GoalDetails::find($detailId);

        return view('private.indicator_detail.edit')
            ->with('detail', $detail)
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'activity'  => $activityId,
                'target'    => $targetId,
                'indicator' => $indicatorId,
                'detail'    => $detailId
            ]);

    }

    public function update(
        $agreementId,
        $programId,
        $activityId,
        $targetId,
        $indicatorId,
        $detailId,
        Request $request
    ) {
        $detail = GoalDetails::find($detailId);
        $detail->description = $request->get('description');
        $detail->action_plan = $request->get('action_plan');
        $detail->dipa = $request->get('dipa');

        return (int) $detail->save();
    }

    public function destroy($agreementId, $programId, $activityId, $targetId, $indicatorId, $detailId, Request $request)
    {
        $detail = GoalDetails::find($detailId);
        $detail->description = null;
        $detail->action_plan = null;
        $detail->dipa = null;

        return (int) $detail->save();
    }

    public function data(Request $request)
    {
        $programId = Program::FIX_PROGRAM_ID;
        $agreementId = $request->get('agreement');
        $indicatorId = $request->get('indicator');
        $activityId = $request->get('activity');
        $targetId = $request->get('target');

        $agreement = Agreement::find($agreementId);

        $goal = Goal::with(['details' => function($query) {
            $query->orderBy('description','desc');
        }])
            ->where('year', $agreement->year)
            ->where('indicator_id', $indicatorId)
            ->first();


        return \Datatables::of($goal->details)
            ->editColumn('dipa', function($data) {
                return money_format('%.2n', $data->dipa);
            })
            ->addColumn('action', function($data) use ($agreementId, $programId, $activityId, $targetId, $indicatorId) {
                return view('private._partials.action.1')
                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('pk.program.kegiatan.sasaran.indikator.detail.edit', [$agreementId, $programId, $activityId, $targetId, $indicatorId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('pk.program.kegiatan.sasaran.indikator.detail.destroy', [$agreementId, $programId, $activityId, $targetId, $indicatorId, $data->id]))

                    ->render();
            })
            ->make(true);
    }
}