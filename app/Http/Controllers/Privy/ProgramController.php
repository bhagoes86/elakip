<?php

namespace App\Http\Controllers\Privy;

use App\Models\Agreement;
use App\Models\Plan;
use App\Models\Program;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProgramController extends AdminController
{
    protected $roles = [
        'name'  => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($planId)
    {
        $plan = Plan::with('period')
            ->find($planId);

        return view('private.program.index')
            ->with('plan', $plan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $planId)
    {
        $this->validate($request, $this->roles);

        $plan = Plan::find($planId);
        $plan->programs()->save(new Program([
            'name'  => $request->get('name')
        ]));

        return $plan->programs;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($planId, $id)
    {
        $program = Program::with('plan')
            ->find($id);

        return view('private.program.edit')
            ->with('program', $program);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $planId, $id)
    {
        $this->validate($request, $this->roles);

        $program = Program::find($id);
        $program->name = $request->get('name');
        return (int) $program->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId, $id)
    {
        return (int) Program::destroy($id);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function data(Request $request)
    {
        $planId = $request->get('plan');

        $plans = Plan::find($planId);

        return Datatables::of($plans->programs)
            ->editColumn('name', function ($data) use ($planId) {
                return '<a href="'.route('renstra.program.kegiatan.index', [$planId, $data->id]).'">'.$data->name.'</a>';
            })
            ->addColumn('action', function ($data) use ($planId) {
                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('renstra.program.edit', [$planId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('renstra.program.destroy', [$planId, $data->id]))

                    ->render();
            })->make(true);
    }

    /**
     * @param Request $request
     * @return string
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getSelect2(Request $request)
    {
        $agreement = $request->get('agreement');

        $agreement = Agreement::find($agreement);

        $programs = Program::where('plan_id', $agreement->plan_id)->get();

        $options = '<option>-Select One-</option>';
        foreach ($programs as $program) {
            $options .= '<option value="'.$program->id.'">'. $program->name. '</option>';
        }

        return $options;
    }
}
