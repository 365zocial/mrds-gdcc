<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_places', function (Blueprint $table) {
            $table->integer('record_unique_id')->comment('Unique ID ของ record, FK: record table');
            $table->integer('place_id')->comment('ID ของ place ใน form ของ record ภาษาไทย // 1 = น้ำจืด, 2 = น้ำกร่อย, 3 = ทะเล, 4 = ภูเขา, 5 = บนต้นไม้, 6 = หน้าดิน, 7 = ในดิน, 8 = บนบก');
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
        Schema::drop('record_places');
    }
}
