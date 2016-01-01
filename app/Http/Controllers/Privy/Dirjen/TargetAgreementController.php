<?php

namespace App\Http\Controllers\Privy\Dirjen;

use App\Http\Controllers\Privy\AdminController;
use App\Models\Target;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TargetAgreementController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($agreementId, $programId)
    {

        return view('private.target_agreement.dirjen_index')
            ->with('id', [
                'agreement' => $agreementId,
                'program'   => $programId
            ]);
    }

    public function data(Request $request)
    {
        $programId = $request->get('program');
        $agreementId = $request->get('agreement');

        $targets = Target::program($programId)->get();

        return \Datatables::of($targets)
            ->editColumn('name', function ($data) use ($agreementId, $programId) {
                return '<a href="'.route('pk.program.sasaran.indikator.index', [
                    $agreementId,
                    $programId,
                    $data->id
                ]).'">'.$data->name.'</a>';
            })
            ->make(true);

    }
}
