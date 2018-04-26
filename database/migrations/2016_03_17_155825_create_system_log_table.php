<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name');
            $table->string('column_name');
            $table->integer('row_id');
            $table->integer('action');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->integer('created_by')->unsigned();
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
        Schema::drop('system_log');
    }
}
