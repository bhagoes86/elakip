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
     * @param $activityId
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create($activityId, Request $request)
    {
        if(\Gate::allows('read-only'))
            abort(403);

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
        if(\Gate::allows('read-only'))
            abort(403);

        $activity = Activity::find($activityId);
        $agreement = Agreement::find($agreementId);

        $evaluation = $activity->evaluations()->save(new Evaluation([
            'year'  => $agreement->year,
            'issue' => $request->get('issue'),
            'solutions' => $request->get('solutions'),
        ]));

        //return \Redirect::('kegiatan.evaluasi.index', $activityId) . '?agreement='.$agreement->id;
        return \Redirect::to('kegiatan/'.$activityId.'/evaluasi/'.$evaluation->id.'/edit');

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
     * @param $activityId
     * @param $evaluationId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit($activityId, $evaluationId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $evaluation = Evaluation::with('activity')
            ->find($evaluationId);

        return view('private.evaluation.edit')
            ->with('evaluation', $evaluation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $activityId
     * @param $evaluationId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, $activityId, $evaluationId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $evaluation = Evaluation::find($evaluationId);
        $evaluation->issue = $request->get('issue');
        $evaluation->solutions = $request->get('solutions');
        $evaluation->save();

        //dd($evaluation->activity->program);
        $agreement = Agreement::where('plan_id', $evaluation->activity->program->plan_id)
            ->where('year', $evaluation->year)
            ->first();

        return \Redirect::to('kegiatan/'.$activityId.'/evaluasi/'.$evaluationId.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $activityId
     * @param $evaluationId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($activityId, $evaluationId)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        return (int) Evaluation::destroy($evaluationId);
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
            //'program'   => 'integer',
        ]);

        $year       = $request->get('year');
        $agreementId  = $request->get('agreement');
        $programId    = 1; //$request->get('program');

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
        $programId = 1; //$request->get('program');
        $agreementId = $request->get('agreement');
        $year = $request->get('year');

        $agreement = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with([
                    'user',
                    'unit'
                ]);
            }
        ])
            ->find($agreementId);

        $program = Program::with(['activities' => function ($query) use ($agreement, $year) {

            $query->with(['evaluations' => function($query) use ($year) {

                $query->where('year', $year);

            }]);

            $query->where('unit_id', $agreement->firstPosition->unit->id);

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

                return view('private._partials.action.2')

                    ->with('edit_action', route('kegiatan.evaluasi.edit', [$activity->id, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('kegiatan.evaluasi.destroy', [$activity->id, $data->id]))
                    ->render();
            })
            ->make(true);
    }
}
