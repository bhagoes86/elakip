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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        return view('private.budget.filter')
            ->with('plans', $plans)
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
            'agreement' => 'integer',
            'program'   => 'integer',
            // 'activity'  => 'integer',
        ]);

        $year = $request->get('year');
        $planId = $request->get('plan');
        $agreementId = $request->get('agreement');
        $programId = $request->get('program');
        $activityId = $request->get('activity');

        $selectedAgreement = Agreement::where('year', $year)
            ->where('plan_id', $planId)
            ->get();

        $selectedProgram = Program::where('plan_id', $planId)->get();

        // $selectedActivity = Activity::where('program_id', $programId)->get();

        $program = Program::with(['activities' => function ($query) use ($agreementId) {

            $agreement = Agreement::with([
                'firstPosition' => function($query) {
                    $query->with(['user','unit']);
                }
            ])->find($agreementId);

            $query->with('budget');
            $query->where('unit_id', $agreement->firstPosition->unit->id);
        }])
            ->where('plan_id', $planId)
            ->find($programId);

        $agreement_arr = [];
        $program_arr = [];
        // $activity_arr = [];

        foreach ($selectedAgreement as $item)
            $agreement_arr[$item->id] = $item->id;

        foreach ($selectedProgram as $item)
            $program_arr[$item->id] = $item->name;

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        /* foreach ($selectedActivity as $item)
            $activity_arr[$item->id] = $item->name;*/

        //dd($program->toArray());


        return view('private.budget.detail')
            ->with('id', [
                'year'      => $year,
                'agreement' => $agreementId,
                'program'   => $program,
                'activity'  => $activityId,
            ])
            ->with('plans', $plans)
            ->with('years', $this->years)
            ->with('agreements', $agreement_arr)
            ->with('programs', $program_arr)
            ->with('activities', $program->activities);
    }
}
