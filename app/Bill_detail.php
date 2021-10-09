<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class Bill_detail extends Model
{
    protected $table = 'bill_details';

    protected $fillable = ['cus_id', 'bill_code', 'emp_id', 'status', 'qc_id', 'packer_id', 'total', 'total_parlate', 'bill_description', 'final_bill_id', 'transfer_to_container'];

    protected $dates = ['time_to_send', 'time_to_start', 'time_to_qc', 'start_to_pack' , 'end_to_pack'];

    public function get_customer()
    {
      return $this -> hasOne('App\Customer', 'id', 'cus_id');
    }

    public function get_customer_route()
    {
      return $this -> hasOne('App\Customer_route', 'cus_id', 'cus_id');
    }

    public function get_packer()
    {
      return $this -> hasOne('App\Employee', 'id', 'packer_id');
    }

    public function get_qc()
    {
      return $this -> hasOne('App\Employee', 'id', 'qc_id');
    }

    public function get_bill_stutus_name()
    {
      return $this -> hasOne('App\Bill_status', 'id', 'status');
    }

    public function get_final_bill()
    {
      return $this -> hasOne('App\Final_bill', 'id', 'final_bill_id');
    }

    public function get_reject()
    {
      return $this -> hasOne('App\Reject', 'bill_id', 'id')
                   -> orderBy('created_at', 'desc');
    }
}
