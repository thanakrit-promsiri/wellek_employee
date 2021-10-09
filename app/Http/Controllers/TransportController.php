<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Final_bill;
use App\Bill_detail;
use App\Travel_detail;
use App\Car;
use App\Employee;
use App\Customer;
use App\Route;
use Carbon\Carbon;
use Session;

class TransportController extends Controller
{
    public function transferToCon(Request $request)
    {
        $route_id = $request -> route_id;
        $routes = Route::pluck('route_code', 'id');
        $final_bills = Final_bill::where(function($query) {
                                    $query -> where('status', 2)
                                           -> orWhere('status', 3);
                                  }) -> whereBetween('created_at', [Carbon::yesterday()->toDateString() . ' 00:00:00', Carbon::now()->toDateString() . ' 23:59:59'])
                                  -> orderBy('created_at', 'ASC')
                                  -> get();

        return view('transport.transfer_to_con.index', compact('final_bills', 'routes', 'route_id'));
    }

    public function updateBill()
    {
        $bill_details = Bill_detail::where('status', '=', 6) -> get();

        return view('transport.update_bill.index', compact('bill_details'));
    }

    public function updateBillSendItem(Request $request)
    {
        $bill_details = Bill_detail::where('id', '=', $request -> bill_id) -> first();
        $bill_details -> status = 7;
        $bill_details -> save();

        return redirect('update-bill');
    }

    public function transportBill()
    {
        $routes = Route::pluck('route_code', 'id');
        $car_licenses = Car::pluck('car_license_plate', 'id');

        return view('transport.transport_bill.index', compact('routes', 'car_licenses'));
    }

    public function saveTransportBill(Request $request)
    {
        $travel_detail_sql = new Travel_detail;
        $emp_id = Employee::select('id') -> where('emp_code', $request -> emp_id) -> first() -> id;
        $travel_detail_sql -> emp_id = $emp_id;
        $travel_detail_sql -> route_id = $request -> route_id;
        $travel_detail_sql -> car_id = $request -> car_id;
        $travel_detail_sql -> travel_date = $request -> travel_date;
        $travel_detail_sql -> brunch_number = $request -> brunch_number;
        $emp_lift_id = Employee::select('id') -> where('emp_code', $request -> emp_lift_id) -> first() -> id;
        $travel_detail_sql -> emp_lift_id = $emp_lift_id;
        $travel_detail_sql -> start_time = $request -> start_time;
        $travel_detail_sql -> depart_time = $request -> depart_time;
        $travel_detail_sql -> first_delivery = $request -> first_delivery;
        $travel_detail_sql -> last_pick_up = $request -> last_pick_up;
        $travel_detail_sql -> return_time = $request -> return_time;
        $travel_detail_sql -> finish_time = $request -> finish_time;
        $travel_detail_sql -> start_km = $request -> start_km;
        $travel_detail_sql -> finish_km = $request -> finish_km;
        $travel_detail_sql -> total_km = $request -> total_km;
        $travel_detail_sql -> fuel_cost = $request -> fuel_cost;
        $travel_detail_sql -> total_liter = $request -> total_liter;
        $travel_detail_sql -> mileage = $request -> mileage;
        $travel_detail_sql -> ex_press_way = $request -> ex_press_way;
        $travel_detail_sql -> car_park = $request -> car_park;
        if(empty($request -> mirror)) {
          $travel_detail_sql -> mirror = 0;
        } else {
          $travel_detail_sql -> mirror = $request -> mirror;
        }
        if(empty($request -> car_light)) {
          $travel_detail_sql -> car_light = 0;
        } else {
          $travel_detail_sql -> car_light = $request -> car_light;
        }
        if(empty($request -> break_light)) {
          $travel_detail_sql -> break_light = 0;
        } else {
          $travel_detail_sql -> break_light = $request -> break_light;
        }
        if(empty($request -> tire)) {
          $travel_detail_sql -> tire = 0;
        } else {
          $travel_detail_sql -> tire = $request -> tire;
        }
        if(empty($request -> wiper)) {
          $travel_detail_sql -> wiper = 0;
        } else {
          $travel_detail_sql -> wiper = $request -> wiper;
        }
        if(empty($request -> key_lock)) {
          $travel_detail_sql -> key_lock = 0;
        } else {
          $travel_detail_sql -> key_lock = $request -> key_lock;
        }
        if(empty($request -> spare_tire)) {
          $travel_detail_sql -> spare_tire = 0;
        } else {
          $travel_detail_sql -> spare_tire = $request -> spare_tire;
        }
        if(empty($request -> boiler_water)) {
          $travel_detail_sql -> boiler_water = 0;
        } else {
          $travel_detail_sql -> boiler_water = $request -> boiler_water;
        }
        if(empty($request -> brake_pads)) {
          $travel_detail_sql -> brake_pads = 0;
        } else {
          $travel_detail_sql -> brake_pads = $request -> brake_pads;
        }
        if(empty($request -> glass_cleaner)) {
          $travel_detail_sql -> glass_cleaner = 0;
        } else {
          $travel_detail_sql -> glass_cleaner = $request -> glass_cleaner;
        }
        if(empty($request -> engine_oil)) {
          $travel_detail_sql -> engine_oil = 0;
        } else {
          $travel_detail_sql -> engine_oil = $request -> engine_oil;
        }
        if(empty($request -> battery_water)) {
          $travel_detail_sql -> battery_water = 0;
        } else {
          $travel_detail_sql -> battery_water = $request -> battery_water;
        }
        if(empty($request -> phone)) {
          $travel_detail_sql -> phone = 0;
        } else {
          $travel_detail_sql -> phone = $request -> phone;
        }
        $travel_detail_sql -> description = $request -> description;
        $travel_detail_sql -> total_delivery_success = $request -> total_delivery_success;
        $travel_detail_sql -> total_delivery_fail = $request -> total_delivery_fail;
        $travel_detail_sql -> inspector_id = Session::get('authenticate') -> id;
        $travel_detail_sql -> save();

        return redirect('/transport-bill') -> with('noti', 'บันทึกข้อมูลรถขนส่งของคุณเรียบร้อยแล้ว');
    }
}
