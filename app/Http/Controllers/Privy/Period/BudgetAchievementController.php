<?php

namespace App\Http\Controllers\Privy\Period;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Activity;
use App\Models\Budget;
use App\Models\Period;
use App\Models\Plan;
use App\Models\Program;
use App\Models\Role;
use App\Models\Target;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BudgetAchievementController extends AdminController
{
    public function getFilter()
    {
        /*$plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }*/

        $period = Period::where('year_begin', Period::YEAR_BEGIN)->first();
        $plan = Plan::where('period_id', $period->id)->first();


        if($this->authUser->role->id == Role::OPERATOR_ID)
        {
            $units[$this->authUser->positions[0]->unit->id] = $this->authUser->positions[0]->unit->name;
        }
        else
        {
            $units = [ 0 => 'All'];
            foreach (Unit::all() as $unit) {
                $units[$unit->id] = $unit->name;
            }
        }

        return view('private.budget_achievement.filter')
            ->with('plan', $plan)
            ->with('units', $units);
    }

    public function getChart(Request $request, $activityId)
    {
        $budgets = Budget::whereBetween('year', [2015,2019])
            ->where('activity_id', $activityId)
            ->get();


        $years = [];
        $pagu = [];
        $real = [];

        foreach ($budgets as $budget) {
            array_push($years, (int) $budget->year);
            array_push($pagu, (int) $budget->pagu);
            array_push($real, (int) $budget->realization);
        }

        return view('private.budget_achievement.chart')
            ->with('years', json_encode($years))
            ->with('pagu', json_encode($pagu))
            ->with('real', json_encode($real));

    }

    public function getActivity(Request $request)
    {
        $planId     = Plan::FIX_PLAN_ID; //$request->get('plan'); // renstra
        $programId  = Program::FIX_PROGRAM_ID; //$request->get('program');
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

    public function getSelectTarget(Request $request)
    {
        $type   = $request->get('type');
        $typeId = $request->get('typeId');

        if($type == 'activity')
            $targets = Target::activity($typeId)->get();
        elseif($type == 'program')
            $targets = Target::program($typeId)->get();

        $options = '<option>-Select One-</option>';
        foreach ($targets as $target) {
            $options .= '<option value="'.$target->id.'">'. $target->name. '</option>';
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

    public function getChartOneYear($programId, $year, Request $request)
    {
        $unitId = $request->get('unit');

        $program = Program::with(['activities' => function($query) use ($year, $unitId) {

            $query->with(['budget' => function($query) use ($year) {
                $query->where('year', $year);
            }]);

            $query->where('unit_id', $unitId);

        }])->find($programId);

        $activities = [];
        $pagu      = [];
        $real       = [];

        foreach ($program->activities as $activity) {

            array_push($activities, $activity->name);

            if(count($activity->budget) > 0) {
                #dd($activity->toArray());
                array_push($pagu, (int) $activity->budget->pagu);
                array_push($real, (int) $activity->budget->realization);


            } else {
                array_push($pagu, 0);
                array_push($real, 0);
            }
        }

        return view('private.budget_achievement.chart_one_year')
            ->with('activities', json_encode($activities))
            ->with('pagu', json_encode($pagu))
            ->with('real', json_encode($real));

    }

    public function getTableOneYear($programId, $year, Request $request)
    {
        $unitId = $request->get('unit');

        $program = Program::with(['activities' => function($query) use ($year, $unitId) {

            $query->with(['budget' => function($query) use ($year) {
                $query->where('year', $year);
            }]);

            $query->where('unit_id', $unitId);

        }])->find($programId);

        $activities = [];
        foreach ($program->activities as $activity) {
            $activities[$activity->name] = [
                'pagu'  => 0,
                'real'  => 0
            ];

            if(count($activity->budget) > 0) {
                $activities[$activity->name]['pagu'] = (int) $activity->budget->pagu;
                $activities[$activity->name]['real'] = (int) $activity->budget->realization;

            }
        }

        return view('private.budget_achievement.table_one_year')
            ->with('activities', $activities);

    }
}
