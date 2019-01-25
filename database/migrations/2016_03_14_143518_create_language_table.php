<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของภาษา // 1 = EN, 2 = TH');
            $table->string('name')->comment('ชื่อของภาษา');
            $table->string('code_lang', 2)->comment('ตัวย่อของภาษา // EN = ภาษาอังกฤษ, TH = ภาษาไทย');
            $table->tinyInteger('status')->comment('สถานะของการใช้งาน // 2 = Enable, 1 = Disable');
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
        Schema::drop('language');
    }
}
