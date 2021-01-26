<?php

namespace App\Http\Controllers\Mpesa;

use App\Mpesa\MpesaC2b;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class C2BController extends Controller
{

    public function index()
    {
//        if (!auth()->user()->can('unit.view') && !auth()->user()->can('unit.create')) {
//            abort(403, 'Unauthorized action.');
//        }

        $unit = MpesaC2b::select(['trans_amount', 'first_name', 'last_name', 'business_short_code',
            'transaction_type', 'trans_time'])->get();
            dd($unit);
        if (request()->ajax()) {

            $unit = MpesaC2b::select(['trans_amount', 'first_name', 'last_name', 'business_short_code',
                    'transaction_type', 'trans_time']);
//            dd($unit);

            return Datatables::of($unit)
                ->editColumn('actual_name', function ($row) {
                        return  $row->first_name . ' ' . $row->middle_name . $row->last_name . ')';

                })
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('mpesa.c2b');
    }
}
