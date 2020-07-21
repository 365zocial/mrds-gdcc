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
            $table->integer('sex_id')->comment('ID ของ sex ใน form ของ record  // 1 = , 2 = การค้า, 3 = ใช้แรงงาน, 4 = อาหาร, 5 = ยา, 6 = ศึกษาวิจัย, 7 = เครื่องนุ่งห่ม');
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
