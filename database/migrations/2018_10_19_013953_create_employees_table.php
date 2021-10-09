<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_code');
            $table->string('emp_image') -> nullable();
            $table->string('emp_firstname');
            $table->string('emp_lastname');
            $table->string('emp_nickname') -> nullable();
            $table->char('emp_phone', 10) -> nullable();
            $table->string('emp_password');
            $table->string('emp_role');
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
        Schema::dropIfExists('employees');
    }
}
