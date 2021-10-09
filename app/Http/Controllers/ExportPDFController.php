<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer_route;
use App\Route;
use PDF;
use DB;
use Carbon\Carbon;
use App\Bill_detail;

class ExportPDFController extends Controller
{
    public function openBillReport(Request $request)
    {
      $route_id = $request -> route_id;
      $time_now = FullNameFormatDateThai(date('Y-m-d H:i:s', strtotime("now")));
      $customers = Customer_route::where('route_id', $route_id)
                                   -> orderBy('cus_route_order', 'ASC')
                                   -> get();
      $pdf = PDF::loadView('pdf.open-bill-report-pdf', ['customers' => $customers, 'time_now' => $time_now]);
      return @$pdf -> stream();
    }

    public function QcLabel(Request $request)
    {
        // $result = Product_import_order::find($import_id);
        // $pdf = PDF::loadView('backend.pdf.import-order-pdf', ['result' => $result]);
        // whereDate('time_to_pack', $today) ->
        $today = Carbon::today();
        $bill_details_qc = Bill_detail::where('status', '=', 5) -> get();
        $pdf = PDF::loadView('pdf.qc-label-pdf', ['bill_details_qc' => $bill_details_qc]);
        // $pdf->setPaper('A4', 'landscape');
        return @$pdf -> stream();
    }

    public function QcLabelGetOnePage(Request $request)
    {
        // $result = Product_import_order::find($import_id);
        // $pdf = PDF::loadView('backend.pdf.import-order-pdf', ['result' => $result]);
        $today = Carbon::today();
        $bill_details_qc = Bill_detail::where('id', $request -> bill_id)
                                        -> where(function($query) {
                                          $query -> where('status', 5)
                                                 -> orwhere('status', 6);
                                        }) -> get();
        $pdf = PDF::loadView('pdf.qc-label-pdf', ['bill_details_qc' => $bill_details_qc]);
        $customPaper = array(0,0,377.9527559055,566.92913386);
        $pdf->setPaper($customPaper, 'landscape');
        return @$pdf -> stream();
    }

    public function ExportBillPreparation(Request $request)
    {
        $route_id = $request -> route_id;
        $time_now = FullNameFormatDateThai(date('Y-m-d H:i:s', strtotime("now")));
        $customers = Customer_route::where('route_id', $route_id)
                                    -> orderBy('cus_route_order', 'ASC')
                                    -> get();
        $route =  Route::where('id','=',$route_id)->first();
      $pdf = PDF::loadView('pdf.export-bill-preparation-pdf', ['customers' => $customers, 'time_now' => $time_now, 'route' => $route]);
      return @$pdf -> stream();
    }

    public function ExportBillWorkOrder(Request $request)
    {
      $route_id = $request -> route_id;
      $time_now = FullNameFormatDateThai(date('Y-m-d H:i:s', strtotime("now")));
      $customers = Customer_route::where('route_id', $route_id)
                                     -> orderBy('cus_route_order', 'ASC')
                                     -> get();
      $route =  Route::where('id','=',$route_id)->first();
      $cost = DB::table("final_bills")
                   ->where('status', '=', 2)
                   ->select(DB::raw("SUM(final_bill_cost) as total"))
                   ->orderBy("created_at")
                   ->get();
      $pdf = PDF::loadView('pdf.export-bill-workorder-pdf', ['customers' => $customers, 'time_now' => $time_now, 'route' => $route, 'cost' => $cost]);
      return @$pdf -> stream();
    }
}
