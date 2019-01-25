<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ User ID');
            $table->string('name')->unique()->comment('เป็น Username ที่ใช้ในการเข้าระบบ, ไม่เกิน 20 ตัวอักษร ขั้นต่ำ 6 ตัวอักษร');
            $table->string('password', 100)->comment('เป็น Password ที่ใช้ในการเข้าระบบ, ไม่เกิน 20 ตัวอักษร ขั้นต่ำ 6 ตัวอักษร');
            $table->string('first_name', 100)->comment('ชื่อของผู้ใช้');
            $table->string('last_name', 100)->comment('นามสกุลของผู้ใช้');
            $table->char('gender', 1)->comment('เพศของ User');
            $table->string('email')->unique()->comment('E-mail ของ User');
            $table->string('telephone', 12)->comment('เบอร์ติดต่อของ User');
            $table->string('position')->comment('ตำแหน่งงาน');
            $table->string('company')->comment('หน่วยงาน หรือ บริษัทอะไร');
            $table->text('address')->comment('ที่อยู่ของหน่วยงาน');
            $table->boolean('approve_permission')->default(false)->comment('สิทธิ์ในการ Approve ข้อมูล // Set Default = 0 // 1 = มีสิทธิ์ approve, 0 = ไม่มีสิทธิ์ approve');
            $table->integer('marinecenter_id')->nullable()->comment('สาขาของ Branch, Admin และ Manager ต้องมี ส่วน User ไม่ต้องมีก็ได้ // FK: marinecenter table');
            $table->integer('role_id')->unsigned()->comment('บทบาทของ User // FK: role table');
            $table->tinyInteger('status')->comment('สถานะที่ต้องการจะให้ผู้ใช้เข้าใช้ระบบได้หรือไม่ // 2 = Enable, 1 = Disable');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้บันทึก, FK: users table');
            $table->integer('updated_by')->unsigned()->comment('ใครเป็นผู้แก้ไข, FK: users table');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
