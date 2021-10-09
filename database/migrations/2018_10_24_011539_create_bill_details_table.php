<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cus_id');
            $table->string('bill_code');
            $table->timestamp('time_to_send') -> nullable(); // เวลาที่ต้องส่ง
            $table->timestamp('time_to_start') -> nullable(); // เวลาเปิดบิล
            $table->string('emp_id');
            $table->char('status', 2);
            $table->string('qc_id') -> nullable();
            $table->timestamp('time_to_qc') -> nullable(); // เวลาที่ตรวจสอบเสร็จ
            $table->string('packer_id') -> nullable();
            $table->integer('total') -> nullable();
            $table->integer('total_parlate') -> nullable();
            $table->timestamp('start_to_pack') -> nullable(); // เวลาที่เริ่มแพ็ค
            $table->timestamp('end_to_pack') -> nullable(); // เวลาที่แพ็คเสร็จ
            $table->text('bill_description') -> nullable();
            $table->string('final_bill_id') -> nullable();
            $table->boolean('transfer_to_container') -> nullable();
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
        Schema::dropIfExists('bill_details');
    }
}
