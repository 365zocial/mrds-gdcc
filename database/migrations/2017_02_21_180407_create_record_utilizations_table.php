<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordUtilizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_utilizations', function (Blueprint $table) {
            $table->integer('record_unique_id')->comment('Unique ID ของ record, FK: record table');
            $table->integer('utilization_id')->comment('ID ของ utilization ใน form ของ record ภาษาไทย // 1 = ความเพลิดเพลิน, 2 = การค้า, 3 = ใช้แรงงาน, 4 = อาหาร, 5 = ยา, 6 = ศึกษาวิจัย, 7 = เครื่องนุ่งห่ม, 8 = สวยงาม');
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
        Schema::drop('record_utilizations');
    }
}
