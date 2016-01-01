<?php

namespace App\Http\Controllers\Privy\Dirjen;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Target;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TargetController extends AdminController
{
    protected $roles = [];

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
     * @param Request $request
     * @param $planId
     * @param $programId
     * @return static
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function store(Request $request, $planId, $programId)
    {
        $this->validate($request, $this->roles);

        $target = Target::create([
            'type'   => 'program',
            'type_id' => $programId,
            'name'  => $request->get('name')
        ]);

        return $target;
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
    public function edit($planId, $programId, $targetId)
    {
        return view('private.target.program_edit')
            ->with('id', [
                'plan'      => $planId,
                'program'   => $programId,
                'target'    => $targetId
            ])->with('target', Target::find($targetId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $planId, $programId, $targetId)
    {
        $this->validate($request, $this->roles);

        $target = Target::find($targetId);
        $target->name = $request->get('name');
        return (int) $target->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId, $programId, $targetId)
    {
        return (int) Target::destroy($targetId);
    }

    public function data(Request $request)
    {
        $programId = $request->get('program');
        $planId = $request->get('plan');
        $type = $request->get('type');

        $targets = Target::where('type', $type)
            ->where('type_id', $programId)
            ->get();


        return Datatables::of($targets)
            ->editColumn('name', function ($data) use ($planId, $programId) {
                return '<a href="'.route('renstra.program.sasaran.indikator.index', [$planId, $programId, $data->id]).'">'.$data->name.'</a>';
            })
            ->addColumn('action', function ($data) use ($programId, $planId) {
                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('renstra.program.sasaran.edit', [$planId, $programId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-sasaran-datatables
                        data-token='.csrf_token().'
                        data-url='.route('renstra.program.sasaran.destroy', [$planId, $programId, $data->id]))

                    ->render();
            })
            ->make(true);
    }
}
