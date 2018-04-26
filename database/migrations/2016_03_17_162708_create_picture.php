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
            $table->increments('id');
            $table->integer('unique_record')->unsigned();
            $table->string('path_pic', 255);
            $table->text('caption')->nullable();
            $table->string('photographer', 255)->nullable();
            $table->tinyInteger('selected_picture')->nullable();
            $table->tinyInteger('level');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
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
