<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordLoanLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_loan_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->integer('record_loan_id');
            $table->text('old_data');
            $table->text('new_data');
            $table->integer('user_id');
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
        Schema::drop('record_loan_log');
    }
}
