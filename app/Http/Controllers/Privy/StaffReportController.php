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

        #dd($organization->toArray());

        return view('private.staff_report.index')
            ->with('organizations', $this->organizations)
            ->with('organization', $organization);
    }


}