<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalBillStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_bill_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('final_bill_status_name_th') -> nullable();
            $table->string('final_bill_status_name_en') -> nullable();
            $table->timestamps();
        });

        DB::table('final_bill_statuses') -> insert([
          [
            'final_bill_status_name_th' => 'รอส่งให้แผนกขนส่ง',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'final_bill_status_name_th' => 'รอยกขึ้นรถ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'final_bill_status_name_th' => 'ขึ้นรถเรียบร้อยแล้ว',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_bill_statuses');
    }
}
