<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomy', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ taxonomy');
            $table->string('name')->comment('ชื่อของ taxonomy เช่น Chordata, Mollusca');
            $table->integer('header_taxonomy_id')->unsigned()->nullable()->comment('เพื่อบอกว่า หัวข้อของ Taxonomy เป็นอะไร // FK: header_taxonomy table');
            $table->integer('status')->comment('สถานะที่ต้องการจะให้ปรากฏในระบบหรือไม่ // 2 = Enable, 1 = Disable');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้บันทึก, FK: users table');
            $table->integer('updated_by')->unsigned()->comment('ใครเป็นผู้แก้ไข, FK: users table');
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
        Schema::drop('taxonomy');
    }
}
