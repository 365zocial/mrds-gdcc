<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('county', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของตำบล');
            $table->integer('district_id')->unsigned()->comment('ID ของอำเภอ, FK: district table');
            $table->string('county_en')->comment('ชื่อตำบล ภาษาอังกฤษ');
            $table->string('county_th')->comment('ชื่อตำบล ภาษาไทย');
            $table->tinyInteger('status')->comment('สถานะที่ต้องการจะให้ปรากฏในระบบหรือไม่ // 2 = Enable, 1 = Disable');
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
        Schema::drop('county');
    }
}
