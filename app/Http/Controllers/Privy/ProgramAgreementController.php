<?php

namespace App\Http\Controllers\Privy;

use App\Models\Agreement;
use App\Models\Plan;
use App\Models\Program;
use App\Models\ProgramBudget;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProgramAgreementController extends AdminController
{
    const DIRJEN_ID = 1;

    /**
     * Display a listing of the resource.
     *
     * @param $agreementId
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

        $plan = Plan::with(['programs' => function ($query) use ($agreement) {
            $query->with([
                'activities',
                'budgets'    => function($query) use ($agreement) {
                    if($agreement->firstPosition->unit->id == self::DIRJEN_ID)
                    {
                        $query->where('year', $agreement->year);
                    }
                }
            ]);
        }])->find($agreement->plan_id);


        return view('private.program_agreement.index')
            ->with('id', [
                'agreement' => $agreementId,
                'dirjen'    => self::DIRJEN_ID
            ])
            ->with('plan', $plan)
            ->with('agreement', $agreement);
    }

    public function data(Request $request)
    {
        /*\DB::listen(function($sql) {
            var_dump($sql);
        });*/

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


        $plan = Plan::with(['programs' => function ($query) use ($agreement) {
            $query->with([
                'activities',
                'budgets'    => function($query) use ($agreement) {
                    if($agreement->firstPosition->unit->id == self::DIRJEN_ID)
                    {
                        $query->where('year', $agreement->year);
                    }
                }
            ]);
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
            ->addColumn('budget', function ($data) use ($agreement) {
                if($agreement->firstPosition->unit->id == self::DIRJEN_ID)
                {
                    if(isset($data->budgets) AND count($data->budgets) > 0) {
                        return $data->budgets[0]->pagu;
                    }
                    else {
                        return 0;
                    }
                }
            })
            ->addColumn('action', function ($query) {

            })
            ->make(true);

    }

    public function putBudget(Request $request, $programId)
    {
        $primaryKeyId = $request->get('pk');
        $columnName = $request->get('name');
        $value   = $request->get('value');
        $year   = $request->get('year');

        //dd($primaryKeyId);

        if($primaryKeyId == null || $primaryKeyId == 0)
        {
            $program = Program::find($programId);
            $program->budgets()->save(new ProgramBudget([
                'year'  => $year,
                'pagu'  => $value
            ]));
        }
        else
        {
            $budget = ProgramBudget::find($primaryKeyId);
            $budget->pagu = $value;
            $budget->year   = $year;
            return (int) $budget->save();
        }


    }
}
