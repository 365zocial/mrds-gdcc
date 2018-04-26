<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_record')->unsigned();
            $table->text('extra1')->nullable();
            $table->integer('extra_field_id1')->nullable()->unsigned();
            $table->text('extra2')->nullable();
            $table->integer('extra_field_id2')->nullable()->unsigned();
            $table->text('extra3')->nullable();
            $table->integer('extra_field_id3')->nullable()->unsigned();
            $table->text('extra4')->nullable();
            $table->integer('extra_field_id4')->nullable()->unsigned();
            $table->text('extra5')->nullable();
            $table->integer('extra_field_id5')->nullable()->unsigned();
            $table->text('extra6')->nullable();
            $table->integer('extra_field_id6')->nullable()->unsigned();
            $table->text('extra7')->nullable();
            $table->integer('extra_field_id7')->nullable()->unsigned();
            $table->text('extra8')->nullable();
            $table->integer('extra_field_id8')->nullable()->unsigned();
            $table->text('extra9')->nullable();
            $table->integer('extra_field_id9')->nullable()->unsigned();
            $table->text('extra10')->nullable();
            $table->integer('extra_field_id10')->nullable()->unsigned();
            $table->text('extra11')->nullable();
            $table->integer('extra_field_id11')->nullable()->unsigned();
            $table->text('extra12')->nullable();
            $table->integer('extra_field_id12')->nullable()->unsigned();
            $table->text('extra13')->nullable();
            $table->integer('extra_field_id13')->nullable()->unsigned();
            $table->text('extra14')->nullable();
            $table->integer('extra_field_id14')->nullable()->unsigned();
            $table->text('extra15')->nullable();
            $table->integer('extra_field_id15')->nullable()->unsigned();
            $table->text('extra16')->nullable();
            $table->integer('extra_field_id16')->nullable()->unsigned();
            $table->text('extra17')->nullable();
            $table->integer('extra_field_id17')->nullable()->unsigned();
            $table->text('extra18')->nullable();
            $table->integer('extra_field_id18')->nullable()->unsigned();
            $table->text('extra19')->nullable();
            $table->integer('extra_field_id19')->nullable()->unsigned();
            $table->text('extra20')->nullable();
            $table->integer('extra_field_id20')->nullable()->unsigned();
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
        Schema::drop('extra_info');
    }
}
