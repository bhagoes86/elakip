<?php

namespace App\Http\Controllers\Privy;
use App\Models\Education;
use App\Models\Staff;
use Datatables;
use Illuminate\Http\Request;

/**
 * Class EducationController
 * @package App\Http\Controllers\Privy
 */
class EducationController extends AdminController
{
    protected $level = [
        'smp'  => 'SLTP',
        'sma'  => 'SLTA',
        'd3'    => 'D3',
        's1'   => 'S1',
        's2'   => 'S2',
        's3'   => 'S3',
    ];

    /**
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @param $staffId
     * @return $this
     */
    public function index($staffId)
    {
        $staff = Staff::find($staffId);

        return view('private.education.index')
            ->with('levels', $this->level)
            ->with('staff', $staff);

    }

    /**
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @param Request $request
     */
    public function store(Request $request, $staffId)
    {
        $staff = Staff::find($staffId);
        $staff->education()->save(new Education([
            'level' => $request->get('level'),
            'institution' => $request->get('institution'),
            'major' => $request->get('major'),
        ]));
    }

    /**
     * @param Request $request
     * @param $staffId
     * @param $educationId
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $id
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function edit(Request $request, $staffId, $educationId)
    {
        $education = Education::find($educationId);
        return view('private.education.edit')
            ->with('id', [
                'staff' => $staffId
            ])
            ->with('levels', $this->level)
            ->with('education', $education);
    }

    /**
     * @param Request $request
     * @param $staffId
     * @param $educationId
     * @return int
     * @internal param $id
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function update(Request $request, $staffId, $educationId)
    {
        $education = Education::find($educationId);

        $education->level = $request->get('level');
        $education->institution = $request->get('institution');
        $education->major = $request->get('major');

        return (int) $education->save();
    }

    /**
     * @param $staffId
     * @param $educationId
     * @return int
     * @internal param $id
     * @internal param Request $request
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function destroy($staffId, $educationId){
        return (int) Education::destroy($educationId);
    }

    /**
     * @param Request $request
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function data(Request $request){

        $staffId = $request->get('staff');

        $staff = Staff::with('education')->find($staffId);

        if($staff == null)
        {
            $education = collect([]);
        }
        else
        {
            $education = $staff->education;

        }
        return Datatables::of($education)

            ->addColumn('action', function($data) use ($staffId) {

                return view('private._partials.action.1')

                    ->with('edit_action', 'showEdit(this)')
                    ->with('edit_data', 'data-modal-id='.$this->identifier.'
                        data-title=Edit
                        data-url='.route('sdm.education.edit', [$staffId, $data->id]))

                    ->with('destroy_action', 'confirmDelete(this)')
                    ->with('destroy_data', 'data-table='.$this->identifier.'-datatables
                        data-token='.csrf_token().'
                        data-url='.route('sdm.education.destroy', [$staffId, $data->id]))

                    ->render();
            })
            ->make(true);
    }

}