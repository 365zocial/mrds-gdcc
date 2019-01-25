<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ reference');
            $table->integer('marinecenter_id')->unsigned()->comment('เพื่อบอกว่าเอกสารนี้ เป็นของ Marine Center ไหน // FK: marinecenter table');
            $table->string('ref_code', 255)->comment('รหัสของเอกสาร');
            $table->text('name_en')->comment('ชื่อเอกสารภาษาอังกฤษ');
            $table->text('name_th')->comment('ชื่อเอกสารภาษาไทย');
            $table->tinyInteger('status')->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enable, 1 = Disable');
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
        Schema::drop('reference');
    }
}
