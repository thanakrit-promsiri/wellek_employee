<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_id'); // พนง.ขับ
            $table->string('route_id'); // สายส่ง
            $table->string('car_id'); // ทะเบียน
            $table->timestamp('travel_date'); // วันที่บันทึก
            $table->string('brunch_number'); // สาขาที่
            $table->string('emp_lift_id'); // พนง.ยกของ
            // Report Detail
            $table->time('start_time'); // เวลาเริ่มงาน
            $table->time('depart_time'); // เวลาที่ออกรถ
            $table->time('first_delivery'); // เวลาส่งงานที่แรก
            $table->time('last_pick_up'); // เวลารับงานที่สุดท้าย
            $table->time('return_time'); // เวลาที่กลับ
            $table->time('finish_time'); // เวลาเสร็จงาน
            $table->float('start_km', 8, 2); // กม.ที่เริ่มงาน
            $table->float('finish_km', 8, 2); // กม.ที่เสร็จงาน
            $table->float('total_km', 8, 2); // กม.ที่วิ่งงาน
            $table->float('fuel_cost', 6, 2); // ค่าน้ำมันรวม
            $table->float('total_liter', 4, 2); // จำนวนลิตรรวม
            $table->float('mileage', 8, 2); // ระยะ กม.ที่เติม
            $table->float('ex_press_way', 8, 2); // ค่าทางด่วนรวม
            $table->float('car_park', 8, 2); // ค่าจอดรถรวม
            // Report Detail
            // Vehicle Inspection
            $table->boolean('mirror') -> nullable();  // กระจกรถ
            $table->boolean('car_light') -> nullable(); // ไฟรถ
            $table->boolean('break_light') -> nullable(); // ไฟเบรค
            $table->boolean('tire') -> nullable(); // ยางรถ
            $table->boolean('wiper') -> nullable(); // ที่ปัดน้ำฝน
            $table->boolean('key_lock') -> nullable(); // กุญแจล็อค
            $table->boolean('spare_tire') -> nullable(); // ยางอะไหล่
            $table->boolean('boiler_water') -> nullable(); // น้ำหม้อน้ำ
            $table->boolean('brake_pads') -> nullable(); // ผ้าเบรค
            $table->boolean('glass_cleaner') -> nullable(); // น้ำล้างกระจก
            $table->boolean('engine_oil') -> nullable(); // น้ำมันเครื่อง
            $table->boolean('battery_water') -> nullable(); // น้ำหม้อแบต
            $table->boolean('phone') -> nullable(); // โทรศัพท์
            // Vehicle Inspection
            $table->text('description') -> nullable(); // หมายเหตุ
            $table->integer('total_delivery_success'); // จำนวนงานที่ส่งสำเร็จ
            $table->integer('total_delivery_fail'); // จำนวนงานที่ไม่ได้ส่ง
            $table->string('inspector_id') -> nullable(); // ผู้ตรวจสอบ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_details');
    }
}
