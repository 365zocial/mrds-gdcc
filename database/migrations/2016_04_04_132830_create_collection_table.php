<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ collection');
            $table->string('col_code', 255)->unique()->comment('รหัส (ตัวย่อ) ของ  Collection Code, Unique เพราะว่าจะไม่มีการซ้ำ');
            $table->string('name_en', 255)->comment('ชื่อ collection ภาษาอังกฤษ');
            $table->string('name_th', 255)->comment('ชื่อ collection ภาษาไทย');
            $table->tinyInteger('status')->comment('สถานะที่ต้องการจะให้ใช้งานหรือไม่ // 2 = Enable, 1 = Disable');
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
        Schema::drop('collection');
    }
}
