<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Final_bill_status extends Model
{
    protected $table = 'final_bill_statuses';

    protected $fillable = ['final_bill_status_name_th', 'final_bill_status_name_en'];
}
