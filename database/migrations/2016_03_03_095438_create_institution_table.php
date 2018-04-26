<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department')->nullable();
            $table->string('department_code', 20)->nullable();
            $table->string('department_th')->nullable();
            $table->string('department_code_th', 20)->nullable();
            $table->string('institution');
            $table->string('institution_code', 20);
            $table->string('institution_th')->nullable();
            $table->string('institution_code_th', 20)->nullable();
            $table->tinyInteger('status');
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
        Schema::drop('institution');
    }
}
