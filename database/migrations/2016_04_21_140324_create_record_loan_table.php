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
            $table->increments('id');
            $table->integer('marinecenter_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('credit');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status');
            $table->text('remark');
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
