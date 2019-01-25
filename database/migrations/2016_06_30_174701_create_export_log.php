<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ export_log');
            $table->tinyInteger('way')->comment('Export ผ่านช่องทางไหน // 0 = excel, 1 = pdf, 2 = api');
            $table->text('note')->nullable()->comment('จำนวน row ใน File, ชื่อไฟล์, สิ่งที่อยากบันทึก');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้ export, FK: users table');
            $table->integer('updated_by')->unsigned()->comment('ใครเป็นผู้แก้ไข export, FK: users table');
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
        Schema::drop('export_log');
    }
}
