<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer_route;
use App\Customer;
use App\Route;
use App\Employee;
use App\Role;
use Session;

class AdminController extends Controller
{
    public function customerIndex()
    {
        $routes = Route::pluck('route_code', 'id');
        $customer_routes = Customer_route::orderBy('created_at', 'DESC') -> get();

        return view('admin.customer_manage.index', compact('routes', 'customer_routes'));
    }

    public function customerInsertData(Request $request)
    {
        $customer_sql = new Customer;
        $customer_sql -> cus_code = $request -> cus_code;
        $customer_sql -> cus_name = $request -> cus_name;
        $customer_sql -> cus_address = $request -> cus_address;
        if($request -> cus_tel1 != null) {
          $customer_sql -> cus_phone1 = cutDash($request -> cus_tel1);
        }
        if($request -> cus_tel2 != null) {
          $customer_sql -> cus_phone2 = cutDash($request -> cus_tel2);
        }
        if($request -> cus_tel3 != null) {
          $customer_sql -> cus_phone3 = cutDash($request -> cus_tel3);
        }
        $customer_sql -> save();

        $customer_route_sql = new Customer_route;
        $customer_route_sql -> cus_id = $customer_sql -> id;
        $customer_route_sql -> route_id = $request -> route_id;
        $customer_route_sql -> cus_route_order = $request -> cus_route_order;
        $customer_route_sql -> save();

        return redirect() -> back();
    }

    public function employeeIndex()
    {
        $roles = Role::where('role_name_th', '!=', '-') -> pluck('role_name_th', 'id');
        $employees = Employee::where('emp_role', '!=', 9) -> get();

        return view('admin.employee_manage.index', compact('roles', 'employees'));
    }

    public function employeeInsertData(Request $request)
    {
        $employee_sql = new Employee;
        $employee_sql -> emp_role = $request -> emp_role;
        $employee_sql -> emp_code = $request -> emp_short_code . $request -> emp_code;
        $employee_sql -> emp_firstname = $request -> emp_firstname;
        $employee_sql -> emp_lastname = $request -> emp_lastname;
        $employee_sql -> emp_phone = $request -> emp_tel;
        $employee_sql -> emp_password = md5($request -> emp_password);
        $employee_sql -> save();

        return redirect() -> back();
    }

    public function changePassData(Request $request)
    {
        $emp_id = $request -> emp_id;
        $new_pass = md5($request -> new_password);

        $emp_query = Employee::where('id', $emp_id) -> first();
        $emp_query -> emp_password = $new_pass;
        $emp_query -> save();

        Session::forget('authenticate');
        return redirect('/') -> with('re_login', 'เข้าสู่ระบบด้วยรหัสผ่านใหม่');
    }
}
