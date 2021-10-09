<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill_detail;
use App\Final_bill;
use App\Route;
use Carbon\Carbon;

class SaleAdminController extends Controller
{
    public function exportBill()
    {
        $bill_details = Bill_detail::where('status', '=', 5) -> get();

        return view('saleadmin.export_bill.index', compact('bill_details'));
    }

    public function confirmTrans()
    {
        $final_bills = Final_bill::where('status', 1)
                                   -> whereBetween('created_at', [Carbon::now()->toDateString() . ' 00:00:00', Carbon::now()->toDateString() . ' 23:59:59'])
                                   -> orderBy('created_at', 'DESC')
                                   -> get();

        return view('saleadmin.confirm_to_trans.index', compact('final_bills'));
    }

    public function reportBill()
    {
        $route_details = Route::paginate(30);
        return view('saleadmin.report_bill.index', compact('route_details'));
    }
}
