<?php

namespace App\Http\Controllers\Privy;

use App\Models\Agreement;
use App\Models\Plan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProgramAgreementController extends AdminController
{
    const DIRJEN_ID = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($agreementId)
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


        return view('private.program_agreement.index')
            ->with('id', [
                'agreement' => $agreementId
            ])
            ->with('agreement', $agreement);
    }

    public function data(Request $request)
    {
        $agreementId = $request->get('agreement');
        $agreement = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with([
                    'unit',
                    'user'
                ]);
            },
            'secondPosition'    => function ($query) {
                $query->with([
                    'unit',
                    'user'
                ]);
            },
        ])->find($agreementId);

        $plan = Plan::with(['programs' => function ($query) {
            $query->with(['activities' => function ($query) {

            }]);
        }])->find($agreement->plan_id);

        return \Datatables::of($plan->programs)
            ->editColumn('name', function ($data) use ($agreement) {
                if($agreement->firstPosition->unit->id == self::DIRJEN_ID)
                {
                    return '<a href="'.route('pk.program.sasaran.index', [
                        $agreement->id,
                        $data->id
                    ]).'">'.$data->name.'</a>';

                }
                else
                {
                    return '<a href="'.route('pk.program.kegiatan.index', [
                        $agreement->id,
                        $data->id
                    ]).'">'.$data->name.'</a>';

                }
            })
            ->make(true);

    }
}
