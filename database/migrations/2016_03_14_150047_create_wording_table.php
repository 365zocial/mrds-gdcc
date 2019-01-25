<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wording', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ word');
            $table->integer('wording_type_id')->unsigned()->comment('เพื่อบอกว่ามาจากประเภทอะไร, FK: wording_type table');
            $table->string('name_en')->comment('ข้อความภาษาอังกฤษ');
            $table->string('name_th')->comment('ข้อความภาษาไทย');
            $table->tinyInteger('status')->comment('สถานะของข้อความที่ต้องการจะให้ปรากฏในระบบหรือไม่ // 2 = Enable, 1 = Disable');
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
        Schema::drop('wording');
    }
}
