<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    protected $table = 'rejects';

    protected $fillable = ['bill_id', 'emp_id', 'reject_description'];

    protected $dates = ['created_at'];

    public function get_bill()
    {
      return $this -> hasOne('App\Bill_detail', 'id', 'bill_id');
    }

    public function get_employee()
    {
      return $this -> hasOne('App\Employee', 'id', 'emp_id');
    }

}
