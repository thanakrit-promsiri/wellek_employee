<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = ['emp_code', 'emp_image', 'emp_firstname', 'emp_lastname', 'emp_nickname', 'emp_phone', 'emp_password', 'emp_role'];

    public function get_role_name()
    {
      return $this->hasOne('App\Role', 'id', 'emp_role');
    }
}
