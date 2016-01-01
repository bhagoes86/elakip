<?php

namespace App\Http\Controllers\Privy\Dirjen;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Agreement;
use App\Models\Goal;
use App\Models\Indicator;
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
    public function index($agreementId, $programId, $targetId)
    {
        return view('private.indicator_agreement.dirjen_index')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'target'    => $targetId
            ]);
    }

    public function edit($agreementId, $programId, $targetId, $indicatorId)
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

        return view('private.indicator_agreement.dirjen_edit')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'target'    => $targetId,
                'indicator'    => $indicatorId,
            ])
            ->with('goal', $goal);
    }

    public function update(Request $request, $agreementId, $programId, $targetId, $indicatorId)
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
            ->addColumn('action', function($data) use ($agreementId, $programId, $targetId) {
                return view('private.indicator_agreement.action')
                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('pk.program.sasaran.indikator.edit', [$agreementId, $programId, $targetId, $data->id]))

                    ->render();
            })
            ->make(true);
    }
}
