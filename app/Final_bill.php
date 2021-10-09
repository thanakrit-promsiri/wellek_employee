<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Final_bill extends Model
{
    protected $table = 'final_bills';

    protected $fillable = ['final_bill_code', 'final_bill_cost', 'status'];

    public function get_final_bill_status()
    {
        return $this -> hasOne('App\Final_bill_status', 'id', 'status');
    }

    public function get_bill_details()
    {
        return $this -> hasMany('App\Bill_detail', 'final_bill_id', 'id');
    }
}
