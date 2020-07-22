<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordSexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_sexes', function (Blueprint $table) {
            $table->integer('record_unique_id')->comment('Unique ID ของ record, FK: record table');
            $table->integer('sex_id')->comment('ID ของ sex ใน form ของ record  // 1 = Male, 2 = Female, 3 = Hermaphrodite, 4 = Indeterminate, 5 = Unknown, 6 = Transitional, 7 = Imposex');
            $table->primary(['record_unique_id', 'sex_id']);
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
        Schema::dropIfExists('record_sexes');
    }
}
