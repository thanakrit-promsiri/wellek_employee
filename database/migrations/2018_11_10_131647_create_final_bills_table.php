<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('final_bill_code');
            $table->float('final_bill_cost', 9, 2); // ex. x,xxx,xxx.xx
            $table->char('status', 2);
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
        Schema::dropIfExists('final_bills');
    }
}
