<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ log');
            $table->string('table_name')->comment('ชื่อของ Table ที่มีการแก้ไข');
            $table->string('column_name')->comment('ชื่อของ Attribute ที่มีการแก้ไข');
            $table->integer('row_id')->comment('row ของ id ที่มีการแก้ไข // FK: อ้างอิงจาก table_name');
            $table->integer('action')->comment('ผู้ใช้ทำอะไรทำอะไร // 1 = Add, 2 = Edit, 3 = Delete');
            $table->text('old_value')->nullable()->comment('ค่าเก่าก่อนแก้ไข');
            $table->text('new_value')->nullable()->comment('ค่าใหม่หลังแก้ไข');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้แก้ไข, FK: users table');
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
        Schema::drop('system_log');
    }
}
