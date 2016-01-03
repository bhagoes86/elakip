<?php

namespace App\Http\Controllers\Privy\Period;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Budget;
use App\Models\Plan;
use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;
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
        $programId = $request->get('program');
        $unitId = $request->get('unit');

        $program = Program::with([
            'activities' => function($query) use ($unitId) {
                $query->where('unit_id', $unitId);
            }
        ])->find($programId);

        //dd($program->toArray());

        $activities = $this->reformatActivity($program->activities);

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        $plan = Plan::with(['period'])
            ->find($planId);

        return view('private.budget_achievement.detail')
            ->with('activities', $activities)
            ->with('plans', $plans)
            ->with('period', $plan->period)
            ->with('years', $this->years);

    }

    /**
     * @param Collection $activities
     * @return array
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    protected function reformatActivity(Collection $activities)
    {
        /**
         * $ab = [
         *  'header' => [
         *      'years' => [2015,2019,2010]
         *  ],
         *  'data'  => [
         *      [...],
         *      [...],
         *      [
         *          ''' => ''''
         *          ''' => ''''
         *          ''' => ''''
         *          'budget' => [
         *              '2010' => [
         *                  'pagu' => 10,
         *                  'real'  => 38
         *               ],
         *              2011=> [
         *                  'pagu' => 10,
         *                  'real'  => 38
         *               ]
         *          ],
         *          'total' =>[
         *                  'pagu' => 20,
         *                  'real'  => 76
         *               ]
         *      ]
         *  ]
         * ];
         */

        $activitiesBucket = [
            'header'    => [],
            'data'      => []
        ];

        $activityIdCollections = [];
        foreach ($activities as $activity)
            array_push($activityIdCollections, $activity->id);

        $budgets = Budget::whereIn('activity_id', $activityIdCollections)
            ->whereBetween('year', [2015,2019])
            ->get();

        $years_holder = [];
        foreach ($budgets as $budget)
            array_push($years_holder, $budget->year);

        $unique_years = array_unique($years_holder);
        $activitiesBucket['header']['years'] = $unique_years;

        $data = [];
        foreach ($activities as $activity) {
            $activity_arr = $activity->toArray();

            $activity_arr['budget'] = [
                'pagu'  => [],
                'real' => []
            ];

            $pagu = [];
            $real = [];
            foreach ($unique_years as $year) {

                $pagu[$year] = 0;
                $real[$year] = 0;

                foreach ($budgets->toArray() as $budget) {
                    if ($budget['year'] == $year AND
                        $budget['activity_id'] == $activity->id)
                    {
                        $pagu[$year] = $budget['pagu'];
                        $real[$year] = $budget['realization'];
                    }
                }
            }

            $activity_arr['budget']['pagu'] = $pagu;
            $activity_arr['budget']['real'] = $real;

            array_push($data, $activity_arr);
        }

        $activitiesBucket['data'] = $data;

        return $activitiesBucket;
    }
}
