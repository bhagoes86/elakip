<?php

namespace App\Http\Controllers\Privy\Period;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Activity;
use App\Models\Budget;
use App\Models\Plan;
use App\Models\Program;
use App\Models\Unit;
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

        $units = [];
        foreach (Unit::all() as $unit) {
            $units[$unit->id]   = $unit->name;
        }


        return view('private.budget_achievement.filter')
            ->with('plans', $plans)
            ->with('units', $units)
            ->with('years', $this->years);
    }

    public function getChart()
    {
        return view('private.budget_achievement.chart');

    }

    public function getActivity(Request $request)
    {
        $planId     = $request->get('plan'); // renstra
        $programId  = $request->get('program');
        $unitId     = $request->get('unit');

        $program = Program::with([
            'activities' => function($query) use ($unitId) {
                $query->where('unit_id', $unitId);
            }
        ])->find($programId);

        $activities = $this->reformatActivity($program->activities);

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        $plan = Plan::with(['period'])->find($planId);

        $program_arr = [];
        foreach ($plan->programs as $program) {
            $program_arr[$program->id] = $program->name;
        }

        $unit_arr = [];
        foreach (Unit::all() as $unit) {
            $unit_arr[$unit->id] = $unit->name;
        }


        return view('private.budget_achievement.detail')
            ->with('id', [
                'plan'  => $planId,
                'program'   => $programId,
                'unit'  => $unitId
            ])
            ->with('activities', $activities)
            ->with('plans', $plans)
            ->with('units', $unit_arr)
            ->with('programs', $program_arr);

    }

    /**
     * @param Request $request
     * @return string
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getSelectProgram(Request $request)
    {
        $planId = $request->get('plan');

        $plan = Plan::find($planId);

        $options = '<option>-Select One-</option>';
        foreach ($plan->programs as $program) {
            $options .= '<option value="'.$program->id.'">'. $program->name. '</option>';
        }

        return $options;
    }

    /**
     * @param Request $request
     * @return string
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getSelectActivity(Request $request)
    {
        $programId  = $request->get('program');
        $unitId     = $request->get('unit');

        $activities = Activity::where('unit_id', $unitId)
            ->where('program_id', $programId)
            ->get();

        $options = '<option>-Select One-</option>';
        foreach ($activities as $activity) {
            $options .= '<option value="'.$activity->id.'">'. $activity->name. '</option>';
        }

        return $options;
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
