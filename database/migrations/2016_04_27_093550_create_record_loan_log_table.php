<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLoanLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_loan_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของปรเภทคำ');
            $table->string('action')->comment('ID ของ record loan, FK: record_loan table');
            $table->integer('record_loan_id')->comment('เก็บสถานะต่างๆ');
            $table->text('old_data')->comment('ข้อมูลเก่า');
            $table->text('new_data')->comment('ข้อมูลใหม่');
            $table->integer('user_id')->comment('User ที่โดนบันทึกลงใน log, FK: users table');
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
        Schema::drop('record_loan_log');
    }
}
