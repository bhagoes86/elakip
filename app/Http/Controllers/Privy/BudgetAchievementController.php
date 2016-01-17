<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Budget;
use App\Models\Period;
use App\Models\Plan;
use App\Models\Program;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BudgetAchievementController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $budgetId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $budgetId)
    {

        if(\Gate::allows('read-only'))
            abort(403);

        $budget = Budget::find($budgetId);
        $budget->realization = $request->get('value');
        return (int) $budget->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getFilter()
    {
        /*$plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }*/

        $period = Period::where('year_begin', Period::YEAR_BEGIN)->first();
        $plan = Plan::where('period_id', $period->id)->first();

        return view('private.budget.filter')
            ->with('plan', $plan)
            ->with('years', $this->years);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getActivity(Request $request)
    {
        $this->validate($request, [
            'year'      => 'integer',
            'program'   => 'integer',
        ]);

        $year = $request->get('year');
        $planId = $request->get('plan');
        $programId = $request->get('program');
        $activityId = $request->get('activity');

        $selectedAgreement = Agreement::where('year', $year)
            ->where('plan_id', $planId)
            ->get();

        $selectedProgram = Program::where('plan_id', $planId)->get();

        $program = Program::with(['activities' => function ($query) {

            $query->with(['budget', 'unit']);
            $query->where('unit_id', $this->authUser->positions[0]->unit->id);
            $query->inAgreement();
        }])
            ->where('plan_id', $planId)
            ->find($programId);

        $agreement_arr = [];
        $program_arr = [];

        foreach ($selectedAgreement as $item)
            $agreement_arr[$item->id] = $item->firstPosition->user->name.' ('.$item->firstPosition->unit->name.')'.' - '.
                $item->secondPosition->user->name.' ('.$item->secondPosition->unit->name.')';

        foreach ($selectedProgram as $item)
            $program_arr[$item->id] = $item->name;

        $period = Period::where('year_begin', Period::YEAR_BEGIN)->first();
        $plan = Plan::where('period_id', $period->id)->first();

        return view('private.budget.detail')
            ->with('id', [
                'year'      => $year,
                'program'   => $programId,
                'activity'  => $activityId,
            ])
            ->with('plan', $plan)
            ->with('years', $this->years)
            ->with('agreements', $agreement_arr)
            ->with('programs', $program_arr)
            ->with('activities', $program->activities);
    }
}
