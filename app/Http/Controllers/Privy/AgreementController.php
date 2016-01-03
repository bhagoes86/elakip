<?php

namespace App\Http\Controllers\Privy;

use App\Models\Agreement;
use App\Models\Budget;
use App\Models\Goal;
use App\Models\Period;
use App\Models\Plan;
use App\Models\Position;
use App\Models\Program;
use App\Models\Target;
use App\Models\Unit;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPExcel_Style_Border;

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

        return view('private.agreement.index')
            ->with('units', $units)
            ->with('years', $this->years);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id]   = $plan->period->year_begin .' - '. $plan->period->year_end;
        }
        return view('private.agreement.create')
            ->with('plans', $plans)
            ->with('years', $this->years);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        $agreement = Agreement::create([

            //'unit_id'           => $request->get('unit'),
            'plan_id'   => $request->get('plan_id'),
            'year'           => $request->get('year'),
            'first_position_id'     => $request->get('first_user_id'),
            'second_position_id'    => $request->get('second_user_id'),
            'date'    => $request->get('date_agreement'),
        ]);

        return \Redirect::route('pk.program.index', $agreement->id);
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
        $agreement = Agreement::find($id);


        $plans = [];
        foreach (Plan::with('period')->get() as $plan) {
            $plans[$plan->id]   = $plan->period->year_begin .' - '. $plan->period->year_end;
        }
        $first_positions_arr = [];
        $first_positions = Position::with(['user','unit'])
            ->where('year', $agreement->year)
            // ->where('unit_id', self::DITJEN_UNIT_ID)
            ->get();

        foreach ($first_positions as $position) {
            $first_positions_arr[$position->id] = $position->user->name . ' ('.$position->position.' '.$position->year.' - '.$position->unit->name.')';
        }

        $second_positions_arr = [];
        $second_positions = Position::with(['user','unit'])
            ->where('year', $agreement->year)
            // ->whereNotIn('unit_id', [self::DITJEN_UNIT_ID])
            ->get();

        /*foreach ($second_positions as $position) {
            $second_positions_arr[$position->id] = [
                'unit_id' => $position->unit->id,
                'text' => $position->user->name . ' ('.$position->position.' '.$position->year.' - '.$position->unit->name.')'
            ];
        }*/

        foreach ($second_positions as $position) {
            $second_positions_arr[$position->id] = $position->user->name . ' ('.$position->position.' '.$position->year.' - '.$position->unit->name.')';
        }

        return view('private.agreement.edit')
            ->with('plans', $plans)
            ->with('agreement', $agreement)
            ->with('years', $this->years)
            ->with('firstPositions', $first_positions_arr)
            ->with('secondPositions', $second_positions_arr);
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
        if(\Gate::allows('read-only'))
            abort(403);

        $agreement = Agreement::find($id);

        $agreement->plan_id           = $request->get('plan_id');
        $agreement->year           = $request->get('year');
        $agreement->first_position_id     = $request->get('first_position_id');
        $agreement->second_position_id    = $request->get('second_position_id');
        $agreement->date    = $request->get('date');

        if($agreement->save()) {
            return \Redirect::route('pk.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Gate::allows('read-only'))
            abort(403);

        return (int) Agreement::destroy($id);
    }

    public function data(Request $request)
    {
        $agreements = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with([
                    'unit',
                    'user'
                ]);
                // $query->where('unit_id', 90);
            },
            'secondPosition'    => function ($query) {
                $query->with([
                    'unit',
                    'user'
                ]);
            },
        ])
            //->join('positions', 'agreements.first_position_id', '=', 'positions.id')

            ->get();

        //dd($agreements->toArray());

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

    public function getExport($id)
    {
// Set locale ke Indonesia
        // Jika belum ada sebaiknya install terlebih dahulu locale-nya di server
        //
        // @reference   http://askubuntu.com/questions/76013/how-do-i-add-locale-to-ubuntu-server
        //              http://whplus.com/blog/2008/11/27/format-penulisan-tanggal-phpdalam-bahasa-indonesia.html
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');

        /*$agreement = Agreement::with([
            'unit',
            'year',
            'firstUser',
            'secondUser',
            'programs' => function ($query) {
                $query->with(['activities' => function ($query) {
                    $query->with(['budget', 'targets' => function ($query) {
                        $query->with('indicators');
                    }]);
                }]);
            }])->find($id);*/

        $agreement = Agreement::with([
            'firstPosition' => function ($query) {
                $query->with([
                    'user',
                    'unit'
                ]);
            },
            'secondPosition' => function ($query) {
                $query->with([
                    'user',
                    'unit'
                ]);
            },
            'plan'
        ])->find($id);

        $plan = Plan::with([
            'programs'=> function($query) use ($agreement) {
                $query->with(['activities' => function($query) use ($agreement) {
                    $query->with(['budget']);
                    $query->where('unit_id', $agreement->firstPosition->unit->id);
                }]);
            }
        ])->find($agreement->plan_id);

        //$target = Target::activity()->first();

        // dd($agreement->toArray());

        return \Excel::create(Carbon::now()->toDateTimeString(), function ($excel) use ($agreement, $plan) {

            $excel->sheet('Pendahuluan', function ($sheet) use ($agreement, $plan) {

                $sheet->setAutoSize(true); // fix
                $sheet->setWidth('A', 20); // fix
                $sheet->setWidth('B', 50); // fix
                $sheet->setWidth('C', 70); // fix

                $sheet->row(1, [null, 'KEMENTERIAN PEKERJAAN UMUM DAN PERUMAHAN RAKYAT']);
                $sheet->row(2, [null, 'REPUBLIK INDONESIA']);
                $sheet->row(3, [null, 'Jl. Patimura No.2, Kebayoran Baru Jakarta Selatan 12110']);
                $sheet->row(4, [null, 'Telepon/Fax (021) 7245751, (021) 7226601']);
                $sheet->row(5, [null, 'www.pu.go.id']);
                $sheet->mergeCells('B1:C1'); // fix
                $sheet->mergeCells('B2:C2'); // fix
                $sheet->mergeCells('B3:C3'); // fix
                $sheet->mergeCells('B4:C4'); // fix
                $sheet->mergeCells('B5:C5'); // fix
                $sheet->cells('B1:B2', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setFontSize(22); // fix
                    $cells->setFontWeight('bold'); // fix
                });
                $sheet->cells('B3:B5', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setFontSize(10); // fix
                });
                $sheet->setHeight(3, 12); // fix
                $sheet->setHeight(4, 12); // fix
                $sheet->setHeight(5, 12); // fix

                $sheet->row(8, ['Dalam rangka mewujudkan manajemen pemerintahan yang efektif, transparan dan akuntabel serta berorientasi pada hasil, kami yang bertandatangan di bawah ini:']);
                $sheet->mergeCells('A8:C8'); // fix
                $sheet->getStyle('A8')->getAlignment()->setWrapText(true);
                $sheet->setHeight(8, 30); // fix

                $sheet->row(10, ['Nama', ': '.$agreement->firstPosition->user->name,]);
                $sheet->row(11, ['Jabatan', ': '.$agreement->firstPosition->position ]);

                // http://stackoverflow.com/questions/8045056/phpexcel-how-to-make-part-of-the-text-bold
                $pihakPertamaText = new \PHPExcel_RichText();
                $pihakPertamaText->createText('Selanjutnya disebut ');

                $pihakPertamaTextBold = $pihakPertamaText->createTextRun('pihak pertama');
                $pihakPertamaTextBold->getFont()->setBold(true);

                $sheet->row(13, [$pihakPertamaText]);

                $sheet->row(15, ['Nama', ': '.$agreement->secondPosition->user->name,]);
                $sheet->row(16, ['Jabatan', ': '.$agreement->secondPosition->position ]);

                $pihakKeduaText = new \PHPExcel_RichText();
                $pihakKeduaText->createText('Selanjutnya disebut ');

                $pihakKeduaTextBold = $pihakKeduaText->createTextRun('pihak kedua');
                $pihakKeduaTextBold->getFont()->setBold(true);

                $sheet->row(18, [$pihakKeduaText]);

                $sheet->row(20, ['Pihak pertama berjanji akan mewujudkan target kinerja tahunan yang seharusnya sesuai lampiran '.
                    'perjanjian ini, dalam rangka mencapai target kinerja jangka menengah seperti yang telah ditetapkan '.
                    'dalam dokumen perencanaan. Keberhasilan dan kegagalan pencapaian target kinerja tersebut '.
                    'menjadi tanggungjawab kami.']);
                $sheet->mergeCells('A20:C20'); // fix
                $sheet->getStyle('A20')->getAlignment()->setWrapText(true);
                $sheet->setHeight(20, 45); // fix


                $sheet->row(22, ['Pihak kedua akan memberikan supervisi yang diperlukan serta akan melakukan evaluasi terhadap '.
                    'capaian kinerja dari perjanjian ini dan mengambil tindakan yang diperlukan dalam rangka pemberian '.
                    'penghargaan dan sanksi.']);
                $sheet->mergeCells('A22:C22'); // fix
                $sheet->getStyle('A22')->getAlignment()->setWrapText(true);
                $sheet->setHeight(22, 30); // fix



                $sheet->row(26, [
                    null, null, 'Jakarta, '. Carbon::parse($agreement->date)->formatLocalized('%d %B %Y')
                ]);
                $sheet->row(27, [
                    'Pihak Kedua',
                    null,
                    'Pihak Pertama',
                ]);
                $sheet->mergeCells('A27:B27'); // fix

                $sheet->row(32, [
                    $agreement->secondPosition->user->name,
                    null,
                    $agreement->firstPosition->user->name,
                ]);
                $sheet->mergeCells('A32:B32'); // fix

                $sheet->cells('A26:C32', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setFontWeight('bold'); // fix
                });


            });

            $excel->sheet('Perjanjian kinerja', function ($sheet) use ($agreement, $plan) {

                $sheet->setAutoSize(true); // fix
                $sheet->setWidth('A', 50); // fix
                $sheet->setWidth('B', 50); // fix
                $sheet->setWidth('C', 30); // fix
                $sheet->setWidth('D', 20); // fix

                // Set content heading
                $sheet->row(1, ['PERJANJIAN KINERJA TAHUN ' . $agreement->year]);
                //$sheet->row(2, [ isset($agreement->first_user_unit->unit) ? strtoupper($agreement->first_user_unit->unit->name) : '' . ' - '.isset($agreement->second_user_unit->unit) ? strtoupper($agreement->second_user_unit->unit->name) : '']);
                $sheet->row(2, [ (isset($agreement->firstPosition->unit) ? strtoupper($agreement->firstPosition->unit->name) : '...') . ' - ' . (isset($agreement->secondPosition->unit) ? strtoupper($agreement->secondPosition->unit->name) : '...')]);
                $sheet->row(3, ['KEMENTERIAN PEKERJAAN UMUM DAN PERUMAHAN RAKYAT']);

                // Set style heading
                $sheet->mergeCells('A1:D1'); // fix
                $sheet->mergeCells('A2:D2'); // fix
                $sheet->mergeCells('A3:D3'); // fix
                $sheet->cells('A1:A3', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setBackground('#000000'); // fix
                    $cells->setFontColor('#ffffff'); // fix
                    $cells->setFontSize(14); // fix
                    $cells->setFontWeight('bold'); // fix
                });

                // Set content title table
                $sheet->row(5, ['SASARAN PROGRAM/KEGIATAN','INDIKATOR KINERJA', null, 'TARGET']); // fix
                $sheet->row(6, ['(1)','(2)', null, '(3)']); // fix

                // Set title table style
                $sheet->mergeCells('B5:C5'); // fix
                $sheet->mergeCells('B6:C6'); // fix
                $sheet->mergeCells('B7:C7'); // fix

                $sheet->cells('A5:D6', function ($cells) {
                    $cells->setAlignment('center'); // fix
                    $cells->setValignment('middle'); // fix
                    $cells->setFontWeight('bold'); // fix
                });
                $sheet->setHeight(5, 30); // fix
                $sheet->setBorder('A5:D7', PHPExcel_Style_Border::BORDER_THIN);

                $counter = 8;
                foreach ($plan->programs as $program) :
                    // Set program dan kegiatan
                    $sheet->row($counter, ['PROGRAM ' . strtoupper($program->name)]);
                    $sheet->mergeCells('A'.$counter.':D'.$counter);
                    $sheet->cells('A'.$counter.':D'.$counter, function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->setBorder('A'.$counter.':D'.$counter, PHPExcel_Style_Border::BORDER_THIN);
                    $counter++;

                    $i = 1;
                    foreach ($program->activities as $activity) {
                        $sheet->row($counter, [$i . '. Kegiatan ' . $activity->name]);
                        $sheet->mergeCells('A'.$counter.':D'.$counter);
                        $sheet->cells('A'.$counter.':D'.$counter, function ($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->setBorder('A'.$counter.':D'.$counter, PHPExcel_Style_Border::BORDER_THIN);
                        $counter++;
                        $i++;
                    }
                    $sheet->mergeCells('B'.$counter.':C'.$counter);


                    $j = 1;
                    $outlineRowStart = $counter;
                    foreach ($program->activities as $activity) {

                        $targets = Target::with([
                                'indicators' => function($query) {
                                    //$query->with();
                                }
                            ])
                            ->activity($activity->id)
                            ->get();

                        $k = 1;
                        foreach ($targets as $target) {

                            $sheet->mergeCells('B'.$counter.':C'.$counter);
                            $counter++; // tambah baris kosong baru
                            if(count($target->indicators) > 0)
                            {
                                $targetRowStart = $counter;
                                $l = 1;
                                foreach ($target->indicators as $indicator) {

                                    $goal = Goal::where('year', $agreement->year)
                                        ->where('indicator_id', $indicator->id)
                                        ->first();

                                    //dd($goal->toArray());

                                    if ($l == 1) {
                                        $sheet->row($counter, [
                                            $j . '.' . $k . '. ' . $target->name, $l . '. ' . $indicator->name, null, isset($goal->count) ? $goal->count : '-' . ' ' . $indicator->unit
                                        ]);

                                        $sheet->getStyle('A'.$counter)->getAlignment()->setWrapText(true);
                                        $sheet->cell('A'.$counter, function ($cells) {
                                            $cells->setValignment('top');
                                        });
                                        $sheet->mergeCells('B'.$counter.':C'.$counter);
                                        $counter++;
                                    } else {
                                        $sheet->row($counter, [
                                            null, $l . '. ' . $indicator->name, null, isset($goal->count) ? $goal->count : '-' . ' ' . $indicator->unit
                                        ]);
                                        $sheet->mergeCells('B'.$counter.':C'.$counter);
                                        $counter++;
                                    }
                                    $l++;
                                }
                                $targetRowEnd = $counter-1;
                                $sheet->mergeCells('A'.$targetRowStart.':A'.$targetRowEnd);

                            }
                            else
                            {
                                $sheet->row($counter, [
                                    $j . '.' . $k . '. ' . $target->name, null, null, null
                                ]);
                                $sheet->getStyle('A'.$counter)->getAlignment()->setWrapText(true);
                                $sheet->cell('A'.$counter, function ($cells) {
                                    $cells->setValignment('top');
                                });
                                $sheet->mergeCells('B'.$counter.':C'.$counter);

                                $counter++;
                            }
                            $k++;
                        }

                        $j++;
                    }
                    $outlineRowEnd = $counter - 1;


                    // Set content style
                    $sheet->getStyle('A'.$outlineRowStart.':D'.$outlineRowEnd)->applyFromArray(array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                            ),
                        ),
                    ));
                    $sheet->getStyle('A'.$outlineRowStart.':D'.$outlineRowEnd)->applyFromArray(array(
                        'borders' => array(
                            'vertical' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                            ),
                        ),
                    ));

                    $counter++; // add empty line

                    $sheet->row($counter, [
                        'Kegiatan', null,'Anggaran'
                    ]);
                    // Set footer style
                    $sheet->cell('A'.$counter, function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $counter++;

                    $m = 1;
                    foreach ($program->activities as $activity) {

                        $budget = Budget::where('year', $agreement->year)
                            ->where('activity_id', $activity->id)
                            ->first();

                        $sheet->row($counter, [
                            $m . '. ' . $activity->name, null, isset($budget->pagu) ? $budget->pagu : '-'
                        ]);
                        // Set footer style
                        $sheet->cell('A'.$counter, function ($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->getStyle('C'.$counter)
                            ->getNumberFormat()
                            ->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
                        $counter++;
                        $m++;
                    }

                    $counter = $counter + 2;

                    // Set signature content
                    $sheet->row($counter, [
                        null, null, 'Jakarta, '. Carbon::parse($agreement->date)->formatLocalized('%d %B %Y')
                    ]);
                    $sheet->mergeCells('C'.$counter.':D'.$counter);
                    $sheet->cells('A'.$counter.':C'.$counter, function ($cells) {
                        $cells->setAlignment('center');
                        $cells->setFontWeight('bold');

                    });
                    $counter++;

                    $sheet->row($counter, [
                        isset($agreement->secondPosition->position) ? $agreement->secondPosition->position : '',
                        null,
                        isset($agreement->firstPosition->position) ? $agreement->firstPosition->position : '',
                    ]);
                    $sheet->mergeCells('C'.$counter.':D'.$counter);
                    $sheet->cells('A'.$counter.':C'.$counter, function ($cells) {
                        $cells->setAlignment('center');
                        $cells->setFontWeight('bold');

                    });
                    $counter = $counter + 5;

                    $sheet->row($counter, [
                        $agreement->secondPosition->user->name,
                        null,
                        $agreement->firstPosition->user->name,

                    ]);
                    $sheet->mergeCells('C'.$counter.':D'.$counter);
                    $sheet->cells('A'.$counter.':C'.$counter, function ($cells) {
                        $cells->setAlignment('center');
                        $cells->setFontWeight('bold');

                    });
                    $counter++;

                endforeach;

            });

        })->export('xls');
    }

    public function getDocumentForm($id)
    {
        return view('private.agreement.dropzone')
            ->with('id', $id);
    }

    public function postDocument(Request $request, $id)
    {

        $agreement = Agreement::find($id);
        $agreement->media()->attach($request->get('mediaId'));

        return $agreement->media;
    }
}
