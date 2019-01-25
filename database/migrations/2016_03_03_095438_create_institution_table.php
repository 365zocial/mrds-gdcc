<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของสถาบัน');
            $table->string('department')->nullable()->comment('ชื่อกรม ภาษาอังกฤษ');
            $table->string('department_code', 20)->nullable()->comment('ตัวย่อของกรม ใช้ในการอ้างอิง Record ด้วย ภาษาอังกฤษ');
            $table->string('department_th')->nullable()->comment('ชื่อกรม ภาษาไทย');
            $table->string('department_code_th', 20)->nullable()->comment('ตัวย่อของกรม ภาษาไทย');
            $table->string('institution')->comment('ชื่อสถาบัน ภาษาอังกฤษ');
            $table->string('institution_code', 20)->comment('ตัวย่อของสถาบัน ใช้ในการอ้างอิง Record ด้วย ภาษาอังกฤษ');
            $table->string('institution_th')->nullable()->comment('ชื่อสถาบัน ภาษาไทย');
            $table->string('institution_code_th', 20)->nullable()->comment('ตัวย่อของสถาบัน ภาษาไทย');
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
        Schema::drop('institution');
    }
}
