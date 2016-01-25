<?php

namespace App\Http\Controllers\Privy;
use App\Models\Organization;
use App\Models\Staff;
use Datatables;
use Illuminate\Http\Request;

/**
 * Class SdmController
 * @package App\Http\Controllers\Privy
 */
class SdmController extends AdminController
{
    /**
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function index()
    {
        $organizations = Organization::all();

        $organization_arr = [];
        foreach ($organizations as $organization) {
            $organization_arr[$organization->id] = $organization->name;
        }

        return view('private.sdm.index')
            ->with('organizations', $organization_arr);

    }

    /**
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @param Request $request
     */
    public function store(Request $request)
    {
        $organization = Organization::find($request->get('organization_id'));

        $organization->staff()->save(new Staff([
            'name'      => $request->get('name'),
            'position'  => $request->get('position'),
            'status'    => $request->get('status')
        ]));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function edit(Request $request, $id)
    {
        $organizations = Organization::all();

        $organization_arr = [];
        foreach ($organizations as $organization) {
            $organization_arr[$organization->id] = $organization->name;
        }

        $staff = Staff::find($id);
        return view('private.sdm.edit')
            ->with('staff', $staff)
            ->with('organizations', $organization_arr);
    }

    /**
     * @param Request $request
     * @param $id
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::find($id);

        $staff->organization_id = $request->get('organization_id');
        $staff->name            = $request->get('name');
        $staff->status          = $request->get('status');
        $staff->position        = $request->get('position');

        return (int) $staff->save();
    }

    /**
     * @param $id
     * @return int
     * @internal param Request $request
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function destroy($id){
        return (int) Staff::destroy($id);
    }

    /**
     * @param Request $request
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function data(Request $request){
        $staff = Staff::with('organization')->get();

        return Datatables::of($staff)
            ->editColumn('name', function($data) {
                return "<a href='".route('sdm.education.index', [$data->id])."'>".$data->name."</a>";
            })
            ->editColumn('status', function($data) {
                if($data->status == 'pns') {
                    return 'PNS';
                } elseif ($data->status == 'non-pns') {
                    return 'Non-PNS';
                }
            })
            ->addColumn('action', function($data){

                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('sdm.edit', $data->id))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('sdm.destroy', $data->id))

                    ->render();
            })
            ->make(true);
    }
}