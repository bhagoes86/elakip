<?php


namespace App\Http\Controllers\Privy;
use App\Models\Organization;
use Datatables;
use Illuminate\Http\Request;

/**
 * Class OrganizationStructureController
 * @package App\Http\Controllers\Privy
 */
class OrganizationStructureController extends AdminController
{
    protected $rules = [
        'parent_id' => 'required|integer',
        'name'  => 'required'
    ];
    protected $messages = [
        'parent_id.required' => 'Parent wajib dipilih',
        'parent_id.integer' => 'Masukan yang Anda isi untuk parent tidak valid',
        'name.required'              => 'Nama organisasi wajib diisi.'
    ];
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

        return view('private.structure.index')
            ->with('organizations', $organization_arr);
    }

    /**
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules, $this->messages);

        $parentId = $request->get('parent_id');

        $parent = Organization::find($parentId);

        if($parent != null)
        {
            $parent->children()->create([
                'name' => $request->get('name')
            ]);
        } else {
            Organization::create([
                'name' => $request->get('name')
            ]);
        }
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

        $organization = Organization::find($id);
        return view('private.structure.edit')
            ->with('organization', $organization)
            ->with('organizations', $organization_arr);
    }

    /**
     * @param Request $request
     * @param $id
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @return int
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules, $this->messages);

        $organization = Organization::find($id);
        if($request->has('parent_id') || $request->get('parent_id') != null) {
            $organization->parent_id = $request->get('parent_id');
        }
        $organization->name = $request->get('name');
        return (int) $organization->save();
    }

    /**
     * @param Request $request
     * @param $id
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function destroy(Request $request, $id)
    {
        return (int) Organization::destroy($id);
    }

    /**
     * @param Request $request
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @return mixed
     */
    public function data(Request $request)
    {
        $organizations = Organization::with('parent')->get();

        return Datatables::of($organizations)
            ->addColumn('parent_name', function($data) {
                if($data->parent == null) {
                    return '-';
                }
                else{
                    return $data->parent->name;
                }
            })
            ->addColumn('action', function($data){

                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('structure.edit', $data->id))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('structure.destroy', $data->id))

                    ->render();
            })
            ->make(true);
    }

    /**
     * GET /structure/parents
     *
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function refreshParents()
    {
        $organizations = Organization::all();

        $organization_opt = '';
        foreach ($organizations as $organization) {
            $organization_opt .= '<option value="'.$organization->id.'">'.$organization->name.'</option>';
        }

        return $organization_opt;
    }
}