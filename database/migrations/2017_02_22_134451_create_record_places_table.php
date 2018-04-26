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
            $table->integer('record_unique_id');
            $table->integer('place_id')->comment('1: น้ำจืด, 2: น้ำกร่อย, 3: ทะเล, 4: ภูเขา, 4: บนต้นไม้, 5: หน้าดิน, 6: ในดิน, 7: บนบก');
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
