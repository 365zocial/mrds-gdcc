<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_permission', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ permission');
            $table->string('name')->comment('ชื่อของ permission');
            $table->text('comment')->comment('ข้อความที่เกี่ยวกับ permission');
            $table->tinyInteger('status_manager')->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enableม 1 = Disable');
            $table->tinyInteger('status_user')->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enableม 1 = Disable');
            $table->tinyInteger('status_board')->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enableม 1 = Disable');
            $table->tinyInteger('status_pgcp')->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enableม 1 = Disable');
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
        Schema::drop('group_permission');
    }
}
