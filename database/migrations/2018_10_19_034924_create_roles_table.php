<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name_th') -> nullable();
            $table->string('role_name_en');
            $table->string('role_name_short') -> nullable();
            $table->timestamps();
        });

        DB::table('roles') -> insert([
          [
            'role_name_th' => 'ออกบิล',
            'role_name_en' => 'BILLING',
            'role_name_short' => 'BL',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => 'เช็คสินค้า',
            'role_name_en' => 'QC',
            'role_name_short' => 'QC',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => 'แพ็คสินค้า',
            'role_name_en' => 'PACKING',
            'role_name_short' => 'PK',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => 'ส่งสินค้า',
            'role_name_en' => 'TRANSPORT',
            'role_name_short' => 'TR',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => '-',
            'role_name_en' => 'ACCOUNT',
            'role_name_short' => '-',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => 'บัญชี',
            'role_name_en' => 'SALE ADMIN',
            'role_name_short' => 'SA',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],

          [
            'role_name_th' => 'ผู้จัดการสาขา',
            'role_name_en' => 'BRANCH MANAGER',
            'role_name_short' => 'BMG',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => 'เจ้าของบริษัท',
            'role_name_en' => 'OWNER',
            'role_name_short' => 'OWN',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => 'ผู้ดูแลระบบ',
            'role_name_en' => 'ADMINISTRATOR',
            'role_name_short' => 'ADMIN',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
          ],
          [
            'role_name_th' => '-',
            'role_name_en' => 'REJECT',
            'role_name_short' => '-',
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
        Schema::dropIfExists('roles');
    }
}
