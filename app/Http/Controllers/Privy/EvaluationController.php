<?php

namespace App\Http\Controllers\Privy;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Evaluation;
use App\Models\Program;
use Datatables;
use Illuminate\Http\Request;

class EvaluationController extends AdminController
{
    protected $identifier = 'evaluation';


    /**
     * Display a listing of the resource.
     *
     * @param $activityId
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($activityId, Request $request)
    {
        $agreementId = $request->get('agreement');

        $activity = Activity::with(['program'])
            ->find($activityId);

        $agreement = Agreement::with([
            'plan',
            'firstPosition' => function($query) {
                $query->with(['unit','user']);
            },
            'secondPosition' => function($query) {
                $query->with(['unit','user']);
            }
        ])->find($agreementId);

        //dd($agreement);

        return view('private.evaluation.index')
            ->with('activity', $activity)
            ->with('agreement', $agreement);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($activityId, Request $request)
    {
        $agreementId = $request->get('agreement');

        $agreement = Agreement::with([
            'plan',
            'firstPosition' => function($query) {
                $query->with(['unit','user']);
            },
            'secondPosition' => function($query) {
                $query->with(['unit','user']);
            }
        ])->find($agreementId);

        $activity = Activity::with([

            'program',

            'evaluations'   => function ($query) use ($agreement) {

                $query->where('year', $agreement->year);
            }

        ])->find($activityId);

        return view('private.evaluation.create')
            ->with('agreement', $agreement)
            ->with('activity', $activity);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $activityId, $agreementId)
    {
        $activity = Activity::find($activityId);
        $agreement = Agreement::find($agreementId);

        $activity->evaluations()->save(new Evaluation([
            'year'  => $agreement->year,
            'issue' => $request->get('issue'),
            'solutions' => $request->get('solutions'),
        ]));

        //return \Redirect::('kegiatan.evaluasi.index', $activityId) . '?agreement='.$agreement->id;
        return \Redirect::to('kegiatan/'.$activityId.'/evaluasi/create?agreement='.$agreement->id);
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

    public function getFilter(Request $request)
    {
        return view('private.evaluation.filter')
            ->with('years', $this->years);
    }

    public function getActivity(Request $request)
    {
        $this->validate($request, [
            'year'      => 'integer',
            'agreement' => 'integer',
            'program'   => 'integer',
        ]);

        $year       = $request->get('year');
        $agreementId  = $request->get('agreement');
        $programId    = $request->get('program');

        //$program = Program::with('activities')->find($programId);

        $selectedAgreement = Agreement::where('year', $year)->get();
        $selectedProgram = Program::where('plan_id', Agreement::find($agreementId)->plan_id)->get();

        $agreement_arr = [];
        $program_arr = [];

        foreach ($selectedAgreement as $item)
            $agreement_arr[$item->id] = $item->id;

        foreach ($selectedProgram as $item)
            $program_arr[$item->id] = $item->name;


        return view('private.evaluation.detail')
            ->with('id', [
                'year'      => $year,
                'agreement' => $agreementId,
                'program'   => $programId,
            ])
            ->with('years', $this->years)
            ->with('agreements', $agreement_arr)
            ->with('programs', $program_arr);
    }

    public function getDataActivity(Request $request)
    {
        $programId = $request->get('program');
        $agreementId = $request->get('agreement');

        $agreement = Agreement::find($agreementId);

        $program = Program::with(['activities' => function ($query) use ($agreement) {

            $query->with(['evaluations' => function($query) use ($agreement) {

                $query->where('year', $agreement->year);

            }]);

        }])->find($programId);


        return Datatables::of($program->activities)
            ->editColumn('name', function($data) use ($agreement) {
                return '<a href="'.route('kegiatan.evaluasi.index', $data->id).'?agreement='.$agreement->id.'">'.$data->name.'</a>';
            })
            ->make(true);
    }

    public function data(Request $request)
    {
        $activityId  = $request->get('activity');
        $agreementId       = $request->get('agreement');
        $agreement  = Agreement::find($agreementId);

        //dd($agreementId);

        $activity = Activity::with([
            'evaluations' => function($query) use ($agreement) {
                $query->where('year', $agreement->year);
            }
        ])->find($activityId);


        return Datatables::of($activity->evaluations)
            ->addColumn('action', function($data) use ($activity) {

                /*return view('private._partials.action.2')

                    ->with('edit_action', route('activity.evaluation.edit', [$activity->id, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('activity.evaluation.destroy', [$activity->id, $data->id]))
                    ->render();*/
            })
            ->make(true);
    }
}
