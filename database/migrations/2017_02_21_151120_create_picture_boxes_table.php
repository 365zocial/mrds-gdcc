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
            $table->increments('id')->comment('1 = left, 2 = center, 3 = right');
            $table->string('pic', 100)->comment('เก็บเฉพาะชื่อและนามสกุลภาพ')->nullable();
            $table->integer('updated_by')->nullable();
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
