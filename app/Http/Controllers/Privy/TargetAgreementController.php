<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Program;
use App\Models\Target;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TargetAgreementController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($agreementId, $programId, $activityId)
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

        $activity = Activity::with('program')->find($activityId);

        return view('private.target_agreement.index')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId,
                'activity'  => $activityId
            ])
            ->with('agreement', $agreement)
            ->with('activity', $activity);
    }

    public function data(Request $request)
    {
        $agreementId = $request->get('agreement');
        $programId = $request->get('program');
        $activityId = $request->get('activity');

        $targets = Target::activity($activityId)->get();

        return \Datatables::of($targets)
            ->editColumn('name', function ($data) use ($agreementId, $programId, $activityId) {
                return '<a href="'.route('pk.program.kegiatan.sasaran.indikator.index', [
                    $agreementId,
                    $programId,
                    $activityId,
                    $data->id
                ]).'">'.$data->name.'</a>';
            })

            ->make(true);
    }
}
