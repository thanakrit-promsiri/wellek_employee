<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Customer_route extends Model
{
    protected $table = 'customer_routes';

    protected $fillable = ['cus_id', 'route_id', 'cus_route_order'];

    public function get_customer()
    {
      return $this -> hasOne('App\Customer', 'id', 'cus_id');
    }

    public function get_route()
    {
      return $this -> hasOne('App\Route', 'id', 'route_id');
    }

    public function get_customer_group()
    {
      return $this -> hasMany('App\Bill_detail', 'cus_id', 'cus_id')
                   -> whereBetween('time_to_start', [Carbon::now()->toDateString() . ' 00:00:00', Carbon::now()->toDateString() . ' 23:59:59'])
                   -> groupBy('cus_id');
    }

    public function get_bills()
    {
      return $this -> hasMany('App\Bill_detail', 'cus_id', 'cus_id')
                   -> whereBetween('time_to_start', [Carbon::now()->toDateString() . ' 00:00:00', Carbon::now()->toDateString() . ' 23:59:59'])
                   -> orderBy('time_to_start', 'ASC');
    }

    public function get_bills_for_export_bill_coute_total()
    {
      return $this -> hasMany('App\Bill_detail', 'cus_id', 'cus_id')
                   -> where('status','=',6)
                   -> groupBy('cus_id')
                   -> select('bill_details.final_bill_id', DB::raw('SUM(total) as total'));
    }

    public function get_bills_for_export_bill()
    {
      return $this -> hasMany('App\Bill_detail', 'cus_id', 'cus_id')
                   -> where('status','=',6)
                   -> groupBy('cus_id');
    }
}
