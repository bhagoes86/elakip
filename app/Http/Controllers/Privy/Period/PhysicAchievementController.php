<?php

namespace App\Http\Controllers\Privy\Period;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Goal;
use App\Models\Indicator;
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

class PhysicAchievementController extends AdminController
{
    /**
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
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

        return view('private.physic_achievement.filter')
            ->with('plan', $plan)
            ->with('units', $units);
    }


    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getIndicator(Request $request)
    {
        $planId         = Plan::FIX_PLAN_ID; //$request->get('plan'); // renstra
        $programId      = Program::FIX_PROGRAM_ID; //$request->get('program'); // Hanya ada 1 program yaitu dengan id 1
        $year           = $request->get('year');
        $targetId       = $request->get('target');
        $agreementId    = $request->get('agreement');
        $activityId     = $request->get('activity');
        $unitId         = $request->get('unit');

        $selectedAgreement = Agreement::with([
                'firstPosition' => function ($query) {
                    $query->with(['user','unit']);
                },
                'secondPosition' => function ($query) {
                    $query->with(['user','unit']);
                }
            ])
            ->where('year', $year)
            ->where('plan_id', $planId)
            ->get();

        //$plan               = Plan::with(['period'])->find($planId);

        $selectedActivity   = Activity::where('program_id', $programId)
                                ->where('unit_id', $unitId)
                                ->get();

        $selectedTarget     = Target::activity($activityId)->get();

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        $year_arr = $this->years;
        $agreement_arr = [];
        // $program_arr = [];
        $activity_arr = [];
        $target_arr = [];

        foreach ($selectedAgreement as $item) {

            $agreement_arr[$item->id] = $item->firstPosition->user->name .
                ' (' . $item->firstPosition->unit->name . ') - ' .
                $item->secondPosition->user->name .
                ' (' . $item->secondPosition->unit->name . ')';
        }

//        foreach ($plan->programs as $program) {
//            $program_arr[$program->id] = $program->name;
//        }

        foreach ($selectedActivity as $item)
            $activity_arr[$item->id] = $item->name;

        foreach ($selectedTarget as $item)
            $target_arr[$item->id] = $item->name;

        $unit_arr = [];
        foreach (Unit::all() as $unit) {
            $unit_arr[$unit->id] = $unit->name;
        }

        $plan = Plan::with(['period'])
            ->find($planId);

        $target = Target::with([
            'indicators' => function ($query) {
                $query->with(['goals' => function ($query) {
                    $query->with([
                        'achievements'
                    ]);
                    $query->whereBetween('year', [2015,2019]);
                    $query->orderBy('year', 'asc');
                }]);
            }
        ])
            ->find($targetId);

        //dd($target->indicators);

        $indicators = $this->reformatIndicators($target->indicators);

        //dd($indicators);

       return view('private.physic_achievement.detail')
           ->with('id', [
               'plan'      => $planId,
               'year'      => $year,
               'unit'      => $unitId,
               'agreement' => $agreementId,
               'program'   => $programId,
               'activity'  => $activityId,
               'target'  => $targetId,
           ])
           ->with('plans', $plans) //ok
           // ->with('period', $plan->period)
           ->with('indicators', $indicators)
           ->with('agreements', $agreement_arr) //ok
           // ->with('programs', $program_arr) //ok
           ->with('activities', $activity_arr) //ok
           ->with('targets', $target_arr) //ok
           ->with('units', $unit_arr)
           ->with('years', $this->years); //ok
    }

    /**
     * @param Request $request
     * @param $indicatorId
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getChart(Request $request, $indicatorId)
    {

        $goals = Goal::with(['achievements' => function($query) {
            $query->orderBy('quarter', 'asc');
        }])
            ->whereBetween('year', [2015,2019])
            ->where('indicator_id', $indicatorId)->get();

        $indicator = Indicator::find($indicatorId);

        //dd($goals->toArray());

        $year_holder = [];
        $count_holder = [];
        $real_holder = [];
        foreach ($goals as $goal) {
            array_push($year_holder, (int) $goal->year);
            array_push($count_holder, (int) $goal->count);
            array_push($real_holder, (int) $goal->achievements[3]->realization);
        }


        $years = $year_holder;
        $count = $count_holder;
        $real = $real_holder;

        return view('private.physic_achievement.chart')
            ->with('indicator', $indicator)
            ->with('years', json_encode($years))
            ->with('count', json_encode($count))
            ->with('real', json_encode($real));
    }

    /**
     * @param Collection $indicators
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @return array
     */
    protected function reformatIndicators(Collection $indicators)
    {


        $indicatorsBucket = [
            'header'    => [],
            'data'      => []
        ];

        $header_years = [];

        foreach ($indicators as $indicator) {
            $data = [];

            foreach ($indicator->toArray() as $key => $val) {

                if($key != 'goals')
                    $data[$key] = $val;

                else {
                    $yearGoalHolder = [];
                    $yearAchHolder = [];
                    $totalGoalHolder = 0;
                    $totalAchHolder = 0;
                    foreach ($val as $goal) {
                        $yearGoalHolder[$goal['year']] = $goal['count'];
                        $yearAchHolder[$goal['year']] = $goal['achievements'][3]['realization']; // Ambil quarter 4 saja

                        $totalGoalHolder = $totalGoalHolder + $goal['count'];
                        $totalAchHolder = $totalAchHolder + $goal['achievements'][3]['realization']; // Ambil quarter 4 saja
                        array_push($header_years, $goal['year']);
                    }
                    $data['goal']['years'] = $yearGoalHolder;
                    $data['achievement']['years'] = $yearAchHolder;
                    $data['goal']['total']  = $totalGoalHolder;
                    $data['achievement']['total']  = $totalAchHolder;


                }
            }

            array_push($indicatorsBucket['data'], $data);

        }
        $indicatorsBucket['header']['years'] = array_unique($header_years);

        return $indicatorsBucket;

    }

    public function getChartOneYear($targetId, $year)
    {
        $target = Target::with(['indicators' => function ($query)  use ($year) {
            $query->with(['goals' => function ($query) use ($year) {

                $query->with(['achievements' => function ($query) {
                    //$query->where('quarter', 4);
                }]);

                $query->where('year', $year);
            }]);
        }])
            ->find($targetId);

        $indicators = [];
        $count      = [];
        $real       = [];

        foreach ($target->indicators as $indicator) {
            array_push($indicators, $indicator->name);
            if(count($indicator->goals) > 0) {
                array_push($count, (int) $indicator->goals[0]->count);

                if(count($indicator->goals[0]->achievements) > 0)
                {
                    array_push($real, (int) $indicator->goals[0]->achievements[3]->realization);
                }
                else {
                    array_push($real, 0);

                }
            } else {
                array_push($count, 0);
            }
        }

        return view('private.physic_achievement.chart_one_year')
            ->with('indicators', json_encode($indicators))
            ->with('count', json_encode($count))
            ->with('real', json_encode($real));
    }

    public function getTableOneYear($targetId, $year)
    {
        $target = Target::with(['indicators' => function ($query)  use ($year) {
            $query->with(['goals' => function ($query) use ($year) {

                $query->with(['achievements' => function ($query) {
                    //$query->where('quarter', 4);
                }]);

                $query->where('year', $year);
            }]);

        }])->find($targetId);

        $indicators = [];
        foreach ($target->indicators as $indicator) {

            $indicators[$indicator->name] = [
                'id'    => null,
                'pagu'  => [
                    'id'    => null,
                    'with_detail' => false,
                    'count' => 0
                ],
                'real'  => 0,
                'percentation' => 0
            ];

            if(count($indicator->goals) > 0) {
                $indicators[$indicator->name]['id'] = (int) $indicator->id;
                $indicators[$indicator->name]['pagu']['id'] = (int) $indicator->goals[0]->id;
                $indicators[$indicator->name]['pagu']['count'] = (int) $indicator->goals[0]->count;
                $indicators[$indicator->name]['pagu']['with_detail'] = (boolean) $indicator->goals[0]->with_detail;
                $indicators[$indicator->name]['real'] = (int) $indicator->goals[0]->achievements[3]->realization;
                $indicators[$indicator->name]['percentation'] = (int) $indicator->goals[0]->achievements[3]->percentation;
            }
        }

        if($target->type == 'activity')
        {
            $activity = Activity::with([
                'program'   => function($query) {
                    $query->with('plan');
                },
                'unit'
            ])->find($target->type_id);
        }
        
        return view('private.physic_achievement.table_one_year')
            ->with('indicators', $indicators)
            ->with('activity', $activity)
            ->with('target', $target);
    }

    public function getTableQuarterOneYear($targetId, $year)
    {
        $target = Target::with(['indicators' => function ($query)  use ($year) {
            $query->with(['goals' => function ($query) use ($year) {
                $query->with('achievements');
                $query->where('year', $year);
            }]);

        }])->find($targetId);

        $indicators = [];
        foreach ($target->indicators as $indicator) {
            $indicators[$indicator->name] = [
                'target'    => 0,
                'satuan'    => '',
                'quarter'   => [
                    1   => [
                        'target'    => 0,
                        'capaian'   => 0,
                        'prosentase'    => 0
                    ],
                    2   => [
                        'target'    => 0,
                        'capaian'   => 0,
                        'prosentase'    => 0
                    ],
                    3   => [
                        'target'    => 0,
                        'capaian'   => 0,
                        'prosentase'    => 0
                    ],
                    4   => [
                        'target'    => 0,
                        'capaian'   => 0,
                        'prosentase'    => 0
                    ],
                ]
            ];


            if(count($indicator->goals) > 0) {
                $indicators[$indicator->name] = [
                    'target'    => (int) $indicator->goals[0]->count,
                    'satuan'    => $indicator->unit,
                    'goal_id'   => $indicator->goals[0]->id
                ];

                foreach ($indicator->goals[0]->achievements as $achievement) {
                    $indicators[$indicator->name]['quarter'][$achievement->quarter] = [
                        'target'    => $achievement->plan,
                        'capaian'   => $achievement->realization,
                    ];

                    if($achievement->quarter == 4)
                    {
                        $indicators[$indicator->name]['quarter'][$achievement->quarter]['target'] = $indicator->goals[0]->count;
                        $indicators[$indicator->name]['quarter'][$achievement->quarter]['prosentase'] = $achievement->percentation;
                    }
                    else {


                        if ($achievement->plan != 0) {
                            $indicators[$indicator->name]['quarter'][$achievement->quarter]['prosentase'] = $achievement->realization / $achievement->plan * 100;
                        } else {
                            $indicators[$indicator->name]['quarter'][$achievement->quarter]['prosentase'] = 0;
                        }
                    }
                }

            }
        }


        if($target->type == 'activity')
        {
            $activity = Activity::with([
                'program'   => function($query) {
                    $query->with('plan');
                },
                'unit'
            ])->find($target->type_id);
        }

        return view('private.physic_achievement.table_quarter_one_year')
            ->with('indicators', $indicators)
            ->with('activity', $activity)
            ->with('target', $target);
    }

    public function getBudgetTableQuarterOneYear($targetId, $year)
    {

        $target = Target::with(['indicators' => function ($query)  use ($year) {
            $query->with(['goals' => function ($query) use ($year) {
                $query->with('achievements');
                $query->where('year', $year);
            }]);

        }])->find($targetId);


        $indicators = [];
        foreach ($target->indicators as $indicator) {
            $indicators[$indicator->name] = [
                'quarter' => [
                    1 => [
                        'target' => 0,
                        'capaian' => 0,
                    ],
                    2 => [
                        'target' => 0,
                        'capaian' => 0,
                    ],
                    3 => [
                        'target' => 0,
                        'capaian' => 0,
                    ],
                    4 => [
                        'target' => 0,
                        'capaian' => 0,
                        'prosentase' => 0
                    ],
                ]
            ];

            if(count($indicator->goals) > 0) {


                foreach ($indicator->goals[0]->achievements as $achievement) {

                    if($achievement->budget_plan > 0 )
                        $prosentase = $achievement->budget_realization / $achievement->budget_plan * 100;
                    else
                        $prosentase = 0;



                    if($achievement->quarter == 4)
                    {
                        $indicators[$indicator->name]['quarter'][$achievement->quarter] = [
                            'target'    => money_format('%.2n', $achievement->budget_plan),
                            'capaian'   => money_format('%.2n', $achievement->budget_realization),
                            'prosentase' => $prosentase
                        ];
                    }
                    else
                    {
                        $indicators[$indicator->name]['quarter'][$achievement->quarter] = [
                            'target'    => $achievement->budget_plan,
                            'capaian'   => $achievement->budget_realization,
                            'prosentase' => $prosentase
                        ];
                    }
                }

            }

        }


        if($target->type == 'activity')
        {
            $activity = Activity::with([
                'program'   => function($query) {
                    $query->with('plan');
                },
                'unit'
            ])->find($target->type_id);
        }


        return view('private.physic_achievement.table_budget_quarter_one_year')
            ->with('activity', $activity)
            ->with('indicators', $indicators)
            ->with('target', $target);
    }

    public function getGoalDetail(Request $request)
    {
        $indicatorId    = $request->get('indicator');
        $goalId         = $request->get('goal');

        $indicator = Indicator::find($indicatorId);
        $goal = Goal::find($goalId);


        return view('private.physic_achievement.goal_detail')
            ->with('indicator', $indicator)
            ->with('details', $goal->details);
    }
}
