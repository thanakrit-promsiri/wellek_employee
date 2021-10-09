<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Bill_detail;
use Carbon\Carbon;
use Session;

class CredentialController extends Controller
{
    public function checklogin(Request $request)
    {
        $request_code = $request -> user_code;
        $request_password = md5($request -> user_password);

        $credential = Employee::where('emp_code', '=', $request_code) -> where('emp_password', '=', $request_password) -> first();

        if(!empty($credential)) {
          Session::put('authenticate', $credential);
          if($credential -> emp_role == 2) {
            return redirect('/quality-control');
          } else if($credential -> emp_role == 4) {
            return redirect('/transfer-to-container');
          } else if($credential -> emp_role == 6) {
            return redirect('/export-bill');
          } else if($credential -> emp_role == 9) {
            return redirect('/customers-management');
          } else if($credential -> emp_role == 10) {
            return redirect('/quality-control-reject');
          } else {
            return redirect('/main-menu');
          }
        } else {
          return redirect('/') -> with('fail', 'เข้าสู่ระบบผิดพลาด') -> withInput();
        }
    }

    public function logout()
    {
        $logout = Session::forget('authenticate');
        if(!empty($logout)) {
          return redirect('/logout');
        } else {
          return redirect('/');
        }
    }
}
