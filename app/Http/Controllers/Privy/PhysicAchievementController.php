<?php

namespace App\Http\Controllers\Privy;

use App\Models\Achievement;
use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Goal;
use App\Models\Indicator;
use App\Models\Period;
use App\Models\Plan;
use App\Models\Program;
use App\Models\Target;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhysicAchievementController extends AdminController
{
    protected $identifier = 'achievement';

    /**
     * Display a listing of the resource.
     *
     * @param $goalId
     * @return \Illuminate\Http\Response
     */
    public function index($goalId)
    {

        $this->isAchievementExist($goalId);

        $goal = Goal::with([

            'achievements'  => function ($query) {
                $query->orderBy('quarter', 'asc');
            },
            'indicator' => function ($query) {
                $query->with('target');
            }

        ])->find($goalId);

        if($goal->indicator->target->type == 'activity')
        {
            $activity = Activity::with([
                'program' => function ($query) {
                    $query->with('plan');
                }
            ])
                ->find($goal->indicator->target->type_id);

            $agreement = Agreement::where('year', $goal->year)
                ->where('plan_id', $activity->program->plan->id)
                ->first();
        }
        else {
            abort(404);
        }



        $achievements = [
            'first_quarter' => [
                'id'    => isset($goal->achievements[0]) ? $goal->achievements[0]->id : null,
                'quarter' => isset($goal->achievements[0]) ? $goal->achievements[0]->quarter : 1,
                'plan'  => isset($goal->achievements[0]) ? $goal->achievements[0]->plan : 0,
                'realization'   => isset($goal->achievements[0]) ? $goal->achievements[0]->realization : 0
            ],
            'second_quarter' => [
                'id'    => isset($goal->achievements[1]) ? $goal->achievements[1]->id : null,
                'quarter' => isset($goal->achievements[1]) ? $goal->achievements[1]->quarter : 2,
                'plan'  => isset($goal->achievements[1]) ? $goal->achievements[1]->plan : 0,
                'realization'   => isset($goal->achievements[1]) ? $goal->achievements[1]->realization : 0
            ],
            'third_quarter' => [
                'id'    => isset($goal->achievements[2]) ? $goal->achievements[2]->id : null,
                'quarter' => isset($goal->achievements[2]) ? $goal->achievements[2]->quarter : 3,
                'plan'  => isset($goal->achievements[2]) ? $goal->achievements[2]->plan : 0,
                'realization'   => isset($goal->achievements[2]) ? $goal->achievements[2]->realization : 0
            ],
            'fourth_quarter' => [
                'id'    => isset($goal->achievements[3]) ? $goal->achievements[3]->id : null,
                'quarter' => isset($goal->achievements[3]) ? $goal->achievements[3]->quarter : 4,
                'plan'  => isset($goal->achievements[3]) ? $goal->achievements[3]->plan : 0,
                'realization'   => isset($goal->achievements[3]) ? $goal->achievements[3]->realization : 0
            ]
        ];

        return view('private.achievement.index')
            ->with('goal', $goal)
            ->with('activity', $activity)
            ->with('agreement', $agreement)
            ->with('achievements', $achievements);
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
    public function store(Request $request, $goalId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $this->validate($request, [
            'plan'          => 'integer',
            'realization'   => 'integer'
        ]);

        $achievementId  = (int) $request->get('id');
        $quarter        = (int) $request->get('quarter');

        $achievement = Achievement::where('quarter', $quarter)->find($achievementId);
        $achievement->plan = $request->get('plan');
        $achievement->realization = $request->get('realization');
        return (int) $achievement->save();
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

        return view('private.achievement.filter')
            ->with('plans', $plans)
            ->with('years', $this->years);
    }

    public function getIndicator(Request $request)
    {
        $this->validate($request, [
            'year'      => 'integer',
            'agreement' => 'integer',
            'program'   => 'integer',
            'activity'  => 'integer',
        ]);

        $plan = $request->get('plan');
        $year = $request->get('year');
        $agreement = $request->get('agreement');
        $program = $request->get('program');
        $activity = $request->get('activity');
        $target = $request->get('target');

        $selectedAgreement = Agreement::where('year', $year)->where('plan_id', $plan)->get();
        $selectedProgram = Program::where('plan_id', $plan)->get();
        $selectedActivity = Activity::where('program_id', $program)->get();
        $selectedTarget = Target::activity($activity)->get();

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id] = $plan->period->year_begin . ' - ' . $plan->period->year_end;
        }

        $year_arr = $this->years;
        $agreement_arr = [];
        $program_arr = [];
        $activity_arr = [];
        $target_arr = [];

        foreach ($selectedAgreement as $item)
            $agreement_arr[$item->id] = $item->id;

        foreach ($selectedProgram as $item)
            $program_arr[$item->id] = $item->name;

        foreach ($selectedActivity as $item)
            $activity_arr[$item->id] = $item->name;

        foreach ($selectedTarget as $item)
            $target_arr[$item->id] = $item->name;


        return view('private.achievement.detail')
            ->with('id', [
                'plan'      => $plan,
                'year'      => $year,
                'agreement' => $agreement,
                'program'   => $program,
                'activity'  => $activity,
                'target'  => $target,
            ])
            ->with('plans', $plans)
            ->with('years', $year_arr)
            ->with('agreements', $agreement_arr)
            ->with('programs', $program_arr)
            ->with('activities', $activity_arr)
            ->with('targets', $target_arr);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getIndicatorData(Request $request)
    {
        $planId = $request->get('plan');
        $year  = $request->get('year');
        $programId  = $request->get('program');
        $agreementId = $request->get('agreement');
        $activityId = $request->get('activity');
        $targetId   = $request->get('target');

        $target = Target::with(['indicators' => function ($query) use ($year) {
            $query->with(['goals' => function ($query) use ($year) {
                $query->where('year', $year);
            }]);
        }])->find($targetId);

        // Goal::where('year', $year)->where('indicator_id', )->first();

        return Datatables::of($target->indicators)
            ->editColumn('name', function ($data) {
                if (isset($data->goals[0])) {
                    $goalId = $data->goals[0]->id;
                    return '<a href="'.url('capaian/fisik/goal/'.$goalId.'/achievement').'">'.$data->name.'</a>';

                } else {
                    return $data->name;
                }
            })
            ->addColumn('first_goal_count', function($data) {
                if (isset($data->goals[0]))
                    return $data->goals[0]->count;
                else
                    return '-';

            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getMediaData(Request $request)
    {
        $achievementId  = $request->get('achievement');
        $key            = $request->get('key');

        $achievement = Achievement::with('media')
            ->find($achievementId);


        return Datatables::of($achievement->media)
            ->editColumn('name', function ($data) {
                return '<a target="_blank" href="'.url('/').'/'.$data->location.'">'.$data->name.'</a>';
            })
            ->addColumn('action', function ($data) use ($achievementId, $key) {

                return view('private.achievement.action')

                    ->with('destroy_action', 'confirmDelete(this)')
                    //->with('destroy_data', '')

                    ->with('destroy_data', 'data-table=table-attach-'.$key.'
                        data-token='.csrf_token().'
                        data-url='.route('capaian.media.destroy', [ $achievementId, $data->id]))


                    ->render();
            })
            ->make(true);
    }

    /**
     * @param $goalId
     * @param $achievementId
     * @param Request $request
     * @return $this
     * @internal param $indicatorId
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getDocument($goalId, $achievementId, Request $request)
    {
        return view('private.achievement.dropzone')
            ->with('id', [
                'goal'     => $goalId,
                'achievement'   => $achievementId,
                'tw'    => $request->get('twId')
            ]);
    }

    /**
     * @param $goalId
     * @param $achievementId
     * @param Request $request
     * @return mixed
     * @internal param $indicatorId
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function postDocument($goalId, $achievementId, Request $request)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $achievement = Achievement::find($achievementId);
        $achievement->media()->attach($request->get('mediaId'));
        return $achievement->media;

    }

    /**
     * todo: replace it with database trigger someday
     *
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @param $id
     */
    protected function isAchievementExist($id)
    {
        // $achievements = Achievement::where('goal_id', $id)->get();

        for($i=1; $i<=4; $i++) {
            /*Achievement::firstOrCreate([

            ]);*/
            $achievement = Achievement::where('quarter', $i)
                ->where('goal_id', $id)
                ->first();

            if($achievement == null || count($achievement) == 0)
            {
                Achievement::create([
                    'goal_id' => $id,
                    'quarter' => $i,
                    'plan' => 0,
                    'realization' => 0
                ]);
            }
        }

    }

    public function deleteMedia ($achievementId, $mediaId)
    {

        $achievement    = Achievement::find($achievementId);
        $achievement->media()->detach($mediaId);

        return 1;
    }
}
