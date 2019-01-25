<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLoanPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_loan_post', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของประเภทคำ');
            $table->integer('user_id')->comment('ID ของ record loan, FK: record_loan table');
            $table->integer('record_loan_id')->unsigned()->comment('User ID ของผู้ที่โต้ตอบการยืมคืนในระบบ, FK: users table');
            $table->text('comment')->comment('ข้อความที่ต้องการส่งถึงกัน');
            $table->string('file_path', 255)->comment('เก็บชื่อไฟล์, ตอนที่ Admin ตอบ ไม่จำเป็นต้องแนบ file');
            $table->timestamps();   // created_at ใช้บอกวันที่ยื่นคำขอยืม
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('record_loan_post');
    }
}
