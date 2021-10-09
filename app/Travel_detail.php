<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel_detail extends Model
{
    protected $table = 'travel_details';

    protected $fillable = [
      'emp_id', 'route_id', 'car_id', 'travel_date', 'brunch_number', 'emp_lift_id',
      'start_time', 'depart_time', 'first_delivery', 'last_pick_up', 'return_time', 'finish_time',
      'start_km', 'finish_km', 'total_km', 'fuel_cost', 'total_liter', 'mileage', 'ex_press_way', 'car_park',
      'mirror', 'car_light', 'break_light', 'tire', 'wiper', 'key_lock', 'spare_tire',
      'boiler_water', 'brake_pads', 'glass_cleaner', 'engine_oil', 'battery_water', 'phone',
      'description', 'total_delivery_success', 'total_delivery_fail', 'inspector_id'
    ];
}
