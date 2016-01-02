<?php

namespace App\Http\Controllers\Privy;

use App\Models\Agreement;
use App\Models\Period;
use App\Models\Unit;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AgreementController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $units = [ 0 => 'All'];
        foreach (Unit::all() as $unit) {
            $units[$unit->id] = $unit->name;
        }

        $periods = Period::where('year_begin', 2015)->first();
        $years = [];
        $begin = $periods->year_begin;
        $end = $periods->year_end;
        for($i=$begin; $i <= $end; $i++) {
            $years[$i] = $i;
        }

        return view('private.agreement.index')
            ->with('units', $units)
            ->with('years', $years);
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
    public function store(Request $request)
    {
        //
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

    public function data(Request $request)
    {
        $agreements = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with([
                    'unit',
                    'user'
                ]);
            },
            'secondPosition'    => function ($query) {
                $query->with([
                    'unit',
                    'user'
                ]);
            },
        ])->get();

        return Datatables::of($agreements)
            ->addColumn('action', function($data){
                return view('private.agreement.action')
                    ->with('edit_action', route('pk.edit', $data->id))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('pk.destroy', $data->id))

                    ->with('show_action', route('pk.program.index', [$data->id]))
                    ->render();

            })

            ->make(true);
    }

    /**
     * @param Request $request
     * @return mixed
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getSelect2(Request $request)
    {
        $year = $request->get('year');

        $agreements = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with(['unit','user']);
            },
            'secondPosition' => function ($query) {
                $query->with(['unit','user']);
            }
        ])
            ->where('year', $year)->get();

        $options = '<option>-Select One-</option>';
        foreach ($agreements as $agreement) {
            $options .= '<option value="'.$agreement->id.'">'.
                $agreement->firstPosition->user->name.' ('.$agreement->firstPosition->unit->name.')'.' - '.
                $agreement->secondPosition->user->name.' ('.$agreement->secondPosition->unit->name.')'.
                '</option>';
        }

        return $options;
    }
}
