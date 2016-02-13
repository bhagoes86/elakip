<?php

namespace App\Http\Controllers\Privy;

use App\Models\Schedule;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScheduleController extends AdminController
{
    protected $rules = [
        'task'  => 'required',
        'date'  => 'required',
    ];

    protected $identifier = 'jadwal';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('private.schedule.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        return Schedule::create([
            'task'  => $request->get('task'),
            'date'  => $request->get('date')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::find($id);
        return view('private.schedule.edit')
            ->with('schedule', $schedule);

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
        $this->validate($request, $this->rules);

        $schedule = Schedule::find($id);
        $schedule->task = $request->get('task');
        $schedule->date = $request->get('date');
        return (int) $schedule->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (int) Schedule::destroy($id);

    }

    public function data(Request $request)
    {
        $schedule = Schedule::all();

        return Datatables::of($schedule)

            ->addColumn('action', function($data){

                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('schedule.edit', $data->id))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('schedule.destroy', $data->id))

                    ->render();
            })
            ->make(true);
    }
}
