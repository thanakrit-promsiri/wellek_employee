<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['cus_code', 'cus_name', 'cus_address', 'cus_phone1', 'cus_phone2', 'cus_phone3', 'route_id'];
}
