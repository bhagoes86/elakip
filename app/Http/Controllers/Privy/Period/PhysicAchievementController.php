<?php

namespace App\Http\Controllers\Privy\Period;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Plan;
use App\Models\Target;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhysicAchievementController extends AdminController
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
    public function update(Request $request, $id)
    {
        //
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

        return view('private.physic_achievement.filter')
            ->with('plans', $plans)
            ->with('years', $this->years);
    }

    public function getIndicator(Request $request)
    {
        $planId = $request->get('plan'); // renstra
        $targetId = $request->get('target');

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        $plan = Plan::with(['period'])
            ->find($planId);

        $target = Target::find($targetId);

        //dd($plan->period->toArray());

       return view('private.physic_achievement.detail')
           ->with('plans', $plans)
           ->with('period', $plan->period)
           ->with('indicators', $target->indicators)
           ->with('years', $this->years);
    }

    public function getChart()
    {
        return view('private.physic_achievement.chart');
    }
}
