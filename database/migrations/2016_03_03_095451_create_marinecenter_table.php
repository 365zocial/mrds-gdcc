<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarinecenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marinecenter', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของสถาบัน // 1 = PMBC, 2 = EGMCRRC, 3 = UGMCRRC, 4 = CGMCRRC, 5 = LGMCRRC');
            $table->integer('institution_id')->unsigned()->comment('ID ของ institution, FK: institution table');
            $table->string('marinecenter')->comment('ชื่อสถาบัน ภาษาอังกฤษ');
            $table->string('marinecenter_code', 20)->comment('ตัวย่อของสถาบัน ใช้ในการอ้างอิง Record ด้วย ภาษาอังกฤษ');
            $table->string('marinecenter_th')->comment('ชื่อสถาบัน ภาษาไทย');
            $table->string('marinecenter_code_th', 20)->comment('ตัวย่อของสถาบัน ภาษาไทย');
            $table->text('address')->comment('ที่อยู่ของสถาบัน');
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
        Schema::drop('marinecenter');
    }
}
