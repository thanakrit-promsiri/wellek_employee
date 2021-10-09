<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill_status extends Model
{
    protected $table = 'bill_statuses';

    protected $fillable = ['bill_status_name_th', 'bill_status_name_en'];
}
