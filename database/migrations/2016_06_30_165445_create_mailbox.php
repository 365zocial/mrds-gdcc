<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailbox extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailbox', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ mailbox');
            $table->integer('marinecenter_id')->unsigned()->comment('ศูนย์ที่ต้องการแจ้ง, FK: marinecenter table');
            $table->integer('user_id')->unsigned()->comment('ใครเป็นผู้บันทึก, ใช้เป็นช่องทางให้ admin ติดต่อกลับไป, FK: user table');
            $table->tinyInteger('type')->unsigned()->comment('ชนิด // 1 = ร้องเรียน (Comment), 2 = ข้อเสนอแนะ (Question)');
            $table->string('subject')->comment('หัวเรื่องที่ต้องการนำเสนอ');
            $table->text('text')->comment('เนื้อหาที่ได้มีการร้องเรียนหรือข้อเสนอแนะ');
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
        Schema::drop('mailbox');
    }
}
