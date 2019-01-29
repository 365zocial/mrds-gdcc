<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictureBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_boxes', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ ตำแหน่งภาพ // 1 = left, 2 = center, 3 = right');
            $table->string('pic', 100)->nullable()->comment('เก็บเฉพาะชื่อและนามสกุลภาพ');
            $table->integer('updated_by')->nullable()->comment('ใครเป็นผู้แก้ไข, FK: users table');
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
        Schema::drop('picture_boxes');
    }
}
