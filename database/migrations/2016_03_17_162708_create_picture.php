<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture', function (Blueprint $table) {
            $table->increments('id')->comment('หมายเลขที่รันไว้เพื่อสร้างความแตกต่างของภาพ');
            $table->integer('unique_record')->unsigned()->comment('หมายเลข unique_record เพื่อบอกว่าเป็นภาพของ Record ไหน');
            $table->string('path_pic', 255)->comment('เพื่อบอกที่อยู่ของไฟล์ภาพ');
            $table->text('caption')->nullable()->comment('คำบรรยายใต้ภาพ');
            $table->string('photographer', 255)->nullable()->comment('ชื่อผู้ถ่าย');
            $table->tinyInteger('selected_picture')->nullable()->comment('เลือกภาพนี้เพื่อแสดง');
            $table->tinyInteger('level')->comment('เพื่อแสดงว่าภาพไหนเป็นภาพหลัก, เลขน้อยจะเป็นภาพหลัก');
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
        Schema::drop('picture');
    }
}
