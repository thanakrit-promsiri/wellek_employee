<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer_route;
use App\Bill_detail;
use App\Route;
use App\Customer;
use Carbon\Carbon;
use Session;
use DateTime;

class OpenBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $route_id = $request -> route_id;
        if($route_id != null) {
          $customers = Customer_route::where('route_id', $route_id)
                                       -> orderBy('cus_route_order', 'ASC')
                                       -> get();
	$routes = Route::pluck('route_code', 'id');

        return view('bill.report', compact('routes', 'customers', 'route_id'));
        }

        $routes = Route::pluck('route_code', 'id');

        return view('bill.report', compact('routes', 'route_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routes = Route::pluck('route_code', 'id');
        $customers = Customer::pluck('cus_code', 'id');

        return view('bill.form', compact('routes', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cus_id = $request -> cus_id;
        $new_bills_array = $request -> new_bill;
        $today = new Carbon();
        $date_bill_array = $request -> date_bill;
        $description_bill_array = $request -> description_bill;
        if(!empty($new_bills_array)) {
          foreach ($new_bills_array as $key => $bill_row) {
            $bill_db = new Bill_detail;
            $bill_db -> cus_id = $cus_id;
            $bill_db -> bill_code = $bill_row;
            if(date('D', strtotime($date_bill_array[$key])) == 'Sun') {
                $bill_db -> time_to_send = Carbon::createFromFormat('Y-m-d', $date_bill_array[$key]) -> addDays(1);
            } else {
                $bill_db -> time_to_send = Carbon::createFromFormat('Y-m-d', $date_bill_array[$key]) -> addDays(0);
            }
            $bill_db -> time_to_start = Carbon::now();
            $bill_db -> emp_id = Session::get('authenticate') -> id;
            $bill_db -> status = 2;
            $test = $description_bill_array[$key];
            if($description_bill_array[$key] !== '-') {
              $bill_db -> bill_description = cutDash($description_bill_array[$key]);
            }
            $bill_db -> transfer_to_container = 0;
            $bill_db -> save();
          }
        }

        return redirect('open-bill/create/insert?customer_id=' . $cus_id);
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
    public function edit(Request $request)
    {
        $cus_id = $request -> cus_id;
        $customer_route = Customer_route::where('cus_id', $cus_id) -> first();
        $bill_details = Bill_detail::where('cus_id', $cus_id)
                                  -> whereBetween('time_to_start', [Carbon::now()->toDateString() . ' 00:00:00', Carbon::now()->toDateString() . ' 23:59:59'])
                                  -> orderBy('time_to_start', 'ASC')
                                  -> get();

        return view('bill.edit', compact('customer_route', 'bill_details'));
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
        $text_1 = "bill_code_";
        $text_2 = "date_bill_";
        $text_3 = "description_bill_";
        $bill_id_array = $request -> bill_res;
        foreach ($bill_id_array as $bill_id) {
          $bill_details = Bill_detail::find($bill_id);
          $request_name_code = $text_1 . $bill_id;
          $bill_details -> bill_code = $request -> $request_name_code;
          $request_name_date = $text_2 . $bill_id;
          if(date('D', strtotime($request -> $request_name_date)) == 'Sun') {
            $bill_details -> time_to_send = Carbon::createFromFormat('Y-m-d', $request -> $request_name_date) -> addDays(1);
          } else {
            $bill_details -> time_to_send = $request -> $request_name_date;
          }
          $request_name_description = $text_3 . $bill_id;
          $bill_details -> bill_description = $request -> $request_name_description;
          $bill_details -> save();
        }

        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insert(Request $request)
    {
        $customer_id = $request -> customer_id;
        $customer_route = Customer_route::where('cus_id', $customer_id) -> first();
        $bill_details = Bill_detail::where('cus_id', $customer_id)
                                -> whereBetween('time_to_start', [Carbon::now()->toDateString() . ' 00:00:00', Carbon::now()->toDateString() . ' 23:59:59'])
                                -> orderBy('time_to_start', 'ASC')
                                -> get();

        return view('bill.insert', compact('customer_route', 'bill_details'));
    }
}
