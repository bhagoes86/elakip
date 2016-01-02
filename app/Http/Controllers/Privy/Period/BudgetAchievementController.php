<?php

namespace App\Http\Controllers\Privy\Period;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Plan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BudgetAchievementController extends AdminController
{
    public function getFilter()
    {
        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }
        return view('private.budget_achievement.filter')
            ->with('plans', $plans)
            ->with('years', $this->years);
    }

    public function getChart()
    {
        return view('private.budget_achievement.chart');

    }

    public function getActivity(Request $request)
    {
        $planId = $request->get('plan'); // renstra
        $targetId = $request->get('target');

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        $plan = Plan::with(['period'])
            ->find($planId);

        return view('private.budget_achievement.detail')
            ->with('plans', $plans)
            ->with('period', $plan->period)
            ->with('years', $this->years);

    }
}
