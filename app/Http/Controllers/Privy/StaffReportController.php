<?php

namespace App\Http\Controllers\Privy;


use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PHPExcel_Style_Border;

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


        // Jika level 0 = Dirjen
        // dan level 1 = direktorat
        $rekap = [
            'pns'       => ['smp' => 0, 'sma' => 0, 'd3' => 0, 's1' => 0, 's2' => 0, 's3' => 0, 'total' => 0],
            'non_pns'   => ['smp' => 0, 'sma' => 0, 'd3' => 0, 's1' => 0, 's2' => 0, 's3' => 0, 'total' => 0]
        ];
        if($organization->getLevel() == 0 || $organization->getLevel() == 1) {
            $rekap = $this->generateRekapData($organization, $rekap);

        }

        $resumeEducation = [
            's3'    => [],
            's2'    => [],
            's1'    => [],
            'd3'    => [],
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
                case 'd3':
                    array_push($resumeEducation['d3'], $staff->id);
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
            ->with('rekap', $rekap)
            ->with('organization', $organization);
    }

    public function getExport(Request $request)
    {
        $organizationId = $request->get('organization');

        $organization = Organization::with(['staff' => function($query) {
            $query->with('education');
        }])->find($organizationId);

        $rekap = [
            'pns'       => ['smp' => 0, 'sma' => 0, 'd3' => 0, 's1' => 0, 's2' => 0, 's3' => 0, 'total' => 0],
            'non_pns'   => ['smp' => 0, 'sma' => 0, 'd3' => 0, 's1' => 0, 's2' => 0, 's3' => 0, 'total' => 0]
        ];

        $rekap = $this->generateRekapData($organization, $rekap);

        return \Excel::create(Carbon::now()->toDateTimeString(), function($excel) use ($organization, $rekap) {
            $excel->sheet('Rekap SDM', function($sheet) use ($organization, $rekap) {

                $sheet->row(1, [
                    'SDM - '. $organization->name
                ]);
                $sheet->mergeCells('A1:G1'); // fix

                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setFontWeight('bold'); // fix
                });

                $sheet->row(3, [
                    'Status Pegawai',
                    'Jenjang Pendidikan'
                ]);

                $sheet->row(4, [
                    null,
                    'SMA',
                    'D3',
                    'S1',
                    'S2',
                    'S3',
                    'Total'
                ]);

                $sheet->row(5, [
                    'PNS',
                    $rekap['pns']['sma'],
                    $rekap['pns']['d3'],
                    $rekap['pns']['s1'],
                    $rekap['pns']['s2'],
                    $rekap['pns']['s3'],
                    $rekap['pns']['total'],
                ]);

                $sheet->row(6, [
                    'Non PNS',
                    $rekap['non_pns']['sma'],
                    $rekap['non_pns']['d3'],
                    $rekap['non_pns']['s1'],
                    $rekap['non_pns']['s2'],
                    $rekap['non_pns']['s3'],
                    $rekap['non_pns']['total'],
                ]);

                $sheet->row(7, [
                    'Total',
                    $rekap['pns']['sma'] + $rekap['non_pns']['sma'],
                    $rekap['pns']['d3'] + $rekap['non_pns']['d3'],
                    $rekap['pns']['s1'] + $rekap['non_pns']['s1'],
                    $rekap['pns']['s2'] + $rekap['non_pns']['s2'],
                    $rekap['pns']['s3'] + $rekap['non_pns']['s3'],
                    $rekap['pns']['total'] + $rekap['non_pns']['total'],
                ]);

                $sheet->setWidth('A', 20); // fix

                $sheet->mergeCells('A3:A4'); // fix
                $sheet->mergeCells('B3:G3'); // fix

                $sheet->getStyle('A3:G7')->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                ));

                $sheet->cells('A3:G4', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setBackground('#11326f'); // fix
                    $cells->setFontColor('#ffffff'); // fix
                    $cells->setFontWeight('bold'); // fix
                });
            });
        })->export('xls');
    }

    /**
     * @param $organization
     * @param $rekap
     * @return array
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    private function generateRekapData(Organization $organization, array $rekap)
    {
        $descendants = $organization->getDescendants();

        $organizationIds = [];
        foreach ($descendants as $unit)
            array_push($organizationIds, $unit->id);

        $units = Organization::with('staff')->whereIn('id', $organizationIds)->get();

        $dumpRekapStaffId = [
            'pns' => ['smp' => [], 'sma' => [], 'd3' => [], 's1' => [], 's2' => [], 's3' => []],
            'non_pns' => ['smp' => [], 'sma' => [], 'd3' => [], 's1' => [], 's2' => [], 's3' => []]
        ];


        foreach ($units as $unit) {
            foreach ($unit->staff as $staff) {

                if ($staff->last != null) {
                    if ($staff->status == 'pns') {
                        array_push($dumpRekapStaffId['pns'][$staff->last], $staff->id);
                    } elseif ($staff->status == 'non-pns') {
                        array_push($dumpRekapStaffId['non_pns'][$staff->last], $staff->id);
                    }
                }
            }

        }

        // Override $rekap array
        foreach ($dumpRekapStaffId as $k => $v) {
            $rekap[$k]['total'] = 0;
            foreach ($v as $eKey => $eVal) {
                $rekap[$k][$eKey] = count($eVal);
                $rekap[$k]['total'] = $rekap[$k]['total'] + count($eVal);
            }
        }

        return $rekap;
    }
}