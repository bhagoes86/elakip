<?php

namespace App\Http\Controllers\Privy;


use App\Models\Organization;
use Illuminate\Http\Request;

class StaffReportController extends AdminController
{
    protected $organizations;

    /**
     * StaffReportController constructor.
     */
    function __construct()
    {
        parent::__construct();

        $organizations = Organization::all();

        $organization_arr = [];
        foreach ($organizations as $organization) {
            $organization_arr[$organization->id] = $organization->name;
        }

        $this->organizations = $organization_arr;

    }

    public function filter()
    {

        return view('private.staff_report.filter')
            ->with('organizations', $this->organizations);

    }

    public function index(Request $request)
    {
        $organizationId = $request->get('organization');
        $organization = Organization::with(['staff' => function($query) {
            $query->with('education');
        }])->find($organizationId);


        $resumeEducation = [
            's3'    => [],
            's2'    => [],
            's1'    => [],
            'sma'    => [],
            'smp'    => [],
        ];
        foreach ($organization->staff as $staff) {
            switch($staff->last) {
                case 's3':
                    array_push($resumeEducation['s3'], $staff->id);
                    break;
                case 's2':
                    array_push($resumeEducation['s2'], $staff->id);
                    break;
                case 's1':
                    array_push($resumeEducation['s1'], $staff->id);
                    break;
                case 'sma':
                    array_push($resumeEducation['sma'], $staff->id);
                    break;
                case 'smp':
                    array_push($resumeEducation['smp'], $staff->id);
                    break;
            }
        }


        return view('private.staff_report.index')
            ->with('organizations', $this->organizations)
            ->with('resume', $resumeEducation)
            ->with('organization', $organization);
    }


}