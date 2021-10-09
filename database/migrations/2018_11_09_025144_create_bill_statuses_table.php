<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bill_status_name_th') -> nullable();
            $table->string('bill_status_name_en') -> nullable();
            $table->timestamps();
        });

        DB::table('bill_statuses') -> insert([
          [
            'bill_status_name_th' => 'ออกบิล',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'รอตรวจสอบ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'รอแพ็ค',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'กำลังแพ็ค',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'พร้อมส่ง',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'ออกใบวางบิลแล้ว',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'ส่งสำเร็จ',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_th' => 'ยกเลิก',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'bill_status_name_en' => 'Reject',
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
        Schema::dropIfExists('bill_statuses');
    }
}
