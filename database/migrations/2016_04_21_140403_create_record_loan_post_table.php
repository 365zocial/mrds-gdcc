<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLoanPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_loan_post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('record_loan_id')->unsigned();
            $table->text('comment');
            $table->string('file_path', 255);
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
        Schema::drop('record_loan_post');
    }
}
