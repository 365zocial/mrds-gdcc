<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_loan', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของปรเภทคำ');
            $table->integer('marinecenter_id')->unsigned()->comment('เพื่อใช้ในการอ้างอิง Marine Center ที่ยืม, FK: marinecenter table');
            $table->integer('user_id')->unsigned()->comment('User ที่ต้องการยืม, FK: users table');
            $table->integer('credit')->comment('จำนวนวันที่ให้ยืม');
            $table->date('start_date')->comment('วันที่เริ่มต้นยืม');
            $table->date('end_date')->comment('วันที่ถึงกำหนดคืน');
            $table->tinyInteger('status')->comment('สถานะของการยืม // 1 = ยื่นคำร้อง, 2 = คำร้องไม่สมบูรณ์, 3 = ยื่นเอกสารที่แก้ไข, 4 = คำร้องสมบูรณ์, 5 = รับ Record ไปแล้ว, 6 = ได้ Record คืนแล้ว, 7 = ยกเลิก');
            $table->text('remark')->comment('หมายเหตุของ Manager');
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
        Schema::drop('record_loan');
    }
}
