<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_field', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ extra_field');
            $table->string('name', 255)->comment('ชื่อ Field');
            $table->tinyInteger('status')->unsigned()->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enable, 1 = Disable');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้บันทึก, FK: users table');
            $table->integer('updated_by')->unsigned()->comment('ใครเป็นผู้แก้ไข, FK: users table');
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
        Schema::drop('extra_field');
    }

}
