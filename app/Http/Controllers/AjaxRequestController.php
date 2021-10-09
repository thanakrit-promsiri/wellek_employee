<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Customer_route;
use App\Route;
use App\Customer;
use App\Bill_detail;
use App\Final_bill;
use App\Reject;
use App\Role;
use Carbon\Carbon;
class AjaxRequestController extends Controller
{
    // Auto complete //
    public function autocompleteGetRoute()
    {
        $routes = Route::select('id', 'route_code', 'route_description') -> get();
        return response() -> json($routes);
    }

    public function autocompleteGetCustomer()
    {
        $customers = Customer::select('id', 'cus_code', 'cus_name') -> get();
        return response() -> json($customers);
    }

    public function autocompleteGetNewRoute(Request $request)
    {
        $route_id = $request -> route_id;
        $customers = Customer_route::where('route_id', $route_id)
                                    -> leftJoin('customers', 'customers.id', '=', 'customer_routes.cus_id')
                                    -> get();
        return response() -> json($customers);
    }

    public function autocompleteGetNewCustomer(Request $request)
    {
        $customer_id = $request -> customer_id;
        $route = Customer_route::where('cus_id', $customer_id)
                                -> leftJoin('routes', 'routes.id', '=', 'customer_routes.route_id')
                                -> first();
        return response() -> json($route);
    }
    // Auto complete //

    public function requestFromRoute(Request $request)
    {
        $route_id = $request -> route_id;
        $route = Route::find($route_id);
        $customers = Customer_route::where('route_id', $route_id) -> with('get_customer') -> get();

        return response() -> json([$route, $customers]);
    }

    // public function requestFromCustomer(Request $request)
    // {
    //     $customer_id = $request -> customer_id;
    //     $customer = Customer::find($customer_id);
    //     $route = Customer_route::where('cus_id', $customer_id) -> with('get_route') -> first();
    //
    //     // $customer_id = $request -> customer_id;
    //     // $customer = Customer::where('cus_code',$customer_id)->first();
    //     // $route = Customer_route::where('cus_id', $customer->id) -> with('get_route') -> first();
    //
    //     return response() -> json([$customer, $route]);
    // }

    public function requestEditBillDetail(Request $request)
    {
        $usercode = $request -> usercode;
        $password = md5($request -> password);
        $status = 0;

        $success = Employee::where('emp_code', $usercode) -> where('emp_password', $password) -> where('emp_role', 7) -> first();
        if($success != null) {
          $status = 1;
        } else {
          $status = 0;
        }

        return response() -> json($status);
    }

    // public function requestEditBillDetailForm(Request $request)
    // {
    //     $bill_id = $request -> bill_id;
    //     $bill_code = $request -> bill_code;
    //     $bill_details = Bill_detail::where('id', $bill_id)->get();
    //     foreach($bill_details as $bill_detail){
    //         $bill_detail -> bill_code = $request -> bill_code;
    //         $bill_detail -> updated_at = Carbon::now();
    //         $bill_detail -> save();
    //     }
    //     return response() -> json($bill_detail);
    // }

    // public function requestZoomBillDetail(Request $request)
    // {
    //     $cus_id = $request -> cus_id;
    //     $bill_details = Bill_detail::where('status', '=', 0)->where('cus_id', '=' ,$cus_id)->with('get_customer_route.get_route')->with('get_customer')->get();
    //
    //     return response() -> json($bill_details);
    // }

    // public function EditQCBillDetail(Request $request)
    // {
    //     $packer = Employee::where('emp_code', $request -> packer_id) -> first();
    //
    //     $today = Carbon::now();
    //     $authenticate_id = Session('authenticate') -> id;
    //     $bill_details = Bill_detail::where('id', $request -> bill_id)-> first();
    //     $bill_details -> status = 1;
    //     $bill_details -> qc_id = $authenticate_id;
    //     $bill_details -> time_to_qc = $today;
    //     $bill_details -> packer_id = $packer -> id;
    //
    //     $bill_details -> save();
    //
    //     return response() -> json($bill_details);
    // }

    public function ValidatePackerId(Request $request)
    {
        $request_packer_id = $request -> packer_id;
        $packer = Employee::where('emp_role', '=' , 3) -> where('emp_code', '=' , $request_packer_id) -> first();

        if($packer == null) {
            return response() -> json('fail');
        } else {
            return response() -> json($packer);
        }
    }

    // public function requestFinalBillCode(Request $request)
    // {
    //     $bill_id = $request -> bill_id;
    //     $bill_code = $request -> bill_code;
    //     $bill_cost = $request -> bill_cost;
    //
    //     $final_bill = New Final_bill;
    //     $final_bill -> final_bill_code = $bill_code;
    //     $final_bill -> final_bill_cost = $bill_cost;
    //     $final_bill -> save();
    //
    //     $bill_details = Bill_detail::where('id', $bill_id) -> get();
    //     foreach($bill_details as $bill_detail) {
    //         $bill_detail -> final_bill_id = $final_bill -> id;
    //         $bill_detail -> status = 5;
    //         $bill_detail -> updated_at = Carbon::now();
    //         $bill_detail -> save();
    //     }
    //
    //     return response() -> json([$bill_detail, $final_bill]);
    // }

    public function validateFinalBillCode(Request $request)
    {
        $code = $request -> code;
        $found_code = Final_bill::where('final_bill_code', $code) -> first();

        if($found_code == null) {
          return response() -> json('success');
        } else {
          return response() -> json('fail');
        }
    }

    public function saveFinalBillData(Request $request)
    {
        $bill_array = $request -> data_bill_id;
        $code = $request -> data_code;
        $cost = $request -> data_cost;

        $final_sql_data = new Final_bill;
        $final_sql_data -> final_bill_code = $code;
        $final_sql_data -> final_bill_cost = $cost;
        $final_sql_data -> status = 1;
        $final_sql_data -> save();

        foreach ($bill_array as $bill_row) {
          $bill_sql_data = Bill_detail::find($bill_row);
          $bill_sql_data -> final_bill_id = $final_sql_data -> id;
          $bill_sql_data -> status = 6;
          $bill_sql_data -> save();
        }

        return response() -> json('success');
    }

    public function updateFinalBillData(Request $request)
    {
        $request_final_bill_ids = $request -> final_bill_ids;
        foreach ($request_final_bill_ids as $final_bill_id) {
          $final_bill_sql = Final_bill::find($final_bill_id);
          $final_bill_sql -> status = 2;
          $final_bill_sql -> save();
        }

        return response() -> json('success');
    }

    public function EditBillDescription(Request $request)
    {
        $bill_id = $request -> bill_id;
        $bill_description = $request -> bill_description;
        $bill_data = Bill_detail::find($bill_id);
        $bill_data -> bill_description = $bill_description;
        $bill_data -> save();

        return response() -> json($bill_data);
    }

    public function saveReject(Request $request)
    {
        $bill_id = $request -> bill_id;
        $reject_description = $request -> reject_description;
        $authenticate_id = Session('authenticate') -> id;

        $bill_data = Bill_detail::find($bill_id);
        $bill_data -> status = 9;
        $bill_data -> save();

        $reject = new Reject;
        $reject -> emp_id = $authenticate_id;
        $reject -> bill_id = $bill_id;
        $reject -> reject_description = $reject_description;
        $reject -> save();

        return response() -> json([$reject, $bill_data]);
    }

    public function ValidateDriverCode(Request $request)
    {
        $emp_code_input = $request -> emp_code_input;

        $success = Employee::where('emp_role', 4) -> where('emp_code', $emp_code_input) -> first();
        if(!empty($success)) {
          return response() -> json('success');
        } else {
          return response() -> json('fail');
        }
    }

    public function ValidateDriverLiftCode(Request $request)
    {
        $emp_lift_code_input = $request -> emp_lift_code_input;

        $success = Employee::where('emp_role', 4) -> where('emp_code', $emp_lift_code_input) -> first();
        if(!empty($success)) {
          return response() -> json('success');
        } else {
          return response() -> json('fail');
        }
    }

    public function updateTransferToCon(Request $request)
    {
        $bill_id = $request -> bill_id;
        $bill_sql_data = Bill_detail::find($bill_id);
        $bill_sql_data -> transfer_to_container = 1;
        $bill_sql_data -> save();

        $final_bill_id = $bill_sql_data -> final_bill_id;
        $bill_detail_array = Bill_detail::where('final_bill_id', $final_bill_id) -> get();
        $count = count($bill_detail_array);
        $loop_count = 0;
        foreach($bill_detail_array as $row) {
          if($row -> transfer_to_container == 1) {
            $loop_count = $loop_count + 1;
          }
        }
        if($count == $loop_count) {
          $final_bill_sql = Final_bill::find($bill_sql_data -> final_bill_id);
          $final_bill_sql -> status = 3;
          $final_bill_sql -> save();
        }

        return response() -> json('success');
    }

    public function getRoleShortCode(Request $request)
    {
        $emp_role_id = $request -> emp_role_id;
        $role_short_name = Role::where('id', $emp_role_id) -> first();

        return response() -> json($role_short_name);
    }

    public function checkEmpCode(Request $request)
    {
        $emp_full_code = $request -> emp_full_code;
        $result = Employee::where('emp_code', $emp_full_code) -> first();

        if($result) {
          return response() -> json('fail');
        } else {
          return response() -> json('success');
        }
    }

    public function oldPassCheck(Request $request)
    {
        $emp_id = $request -> emp_id;
        $old_pass = md5($request -> old_pass);
        $result = Employee::where('id', $emp_id) -> where('emp_password', $old_pass) -> first();

        if($result != null) {
          return response() -> json('true');
        } else {
          return response() -> json('false');
        }
    }
}
