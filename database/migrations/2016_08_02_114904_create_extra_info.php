<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_info', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ extra_info');
            $table->integer('unique_record')->unsigned()->comment('หมายเลข unique_record  เพื่อบอกว่าข้อมูลเป็นของ Record ไหน, FK: record table');
            $table->text('extra1')->nullable()->comment('เก็บข้อมูล Field ที่ 1');
            $table->integer('extra_field_id1')->nullable()->unsigned()->comment('ชื่อ Field ที่ 1, FK: extra_field table');
            $table->text('extra2')->nullable()->comment('เก็บข้อมูล Field ที่ 2');
            $table->integer('extra_field_id2')->nullable()->unsigned()->comment('ชื่อ Field ที่ 2, FK: extra_field table');
            $table->text('extra3')->nullable()->comment('เก็บข้อมูล Field ที่ 3');
            $table->integer('extra_field_id3')->nullable()->unsigned()->comment('ชื่อ Field ที่ 3, FK: extra_field table');
            $table->text('extra4')->nullable()->comment('เก็บข้อมูล Field ที่ 4');
            $table->integer('extra_field_id4')->nullable()->unsigned()->comment('ชื่อ Field ที่ 4, FK: extra_field table');
            $table->text('extra5')->nullable()->comment('เก็บข้อมูล Field ที่ 5');
            $table->integer('extra_field_id5')->nullable()->unsigned()->comment('ชื่อ Field ที่ 5, FK: extra_field table');
            $table->text('extra6')->nullable()->comment('เก็บข้อมูล Field ที่ 6');
            $table->integer('extra_field_id6')->nullable()->unsigned()->comment('ชื่อ Field ที่ 6, FK: extra_field table');
            $table->text('extra7')->nullable()->comment('เก็บข้อมูล Field ที่ 7');
            $table->integer('extra_field_id7')->nullable()->unsigned()->comment('ชื่อ Field ที่ 7, FK: extra_field table');
            $table->text('extra8')->nullable()->comment('เก็บข้อมูล Field ที่ 8');
            $table->integer('extra_field_id8')->nullable()->unsigned()->comment('ชื่อ Field ที่ 8, FK: extra_field table');
            $table->text('extra9')->nullable()->comment('เก็บข้อมูล Field ที่ 9');
            $table->integer('extra_field_id9')->nullable()->unsigned()->comment('ชื่อ Field ที่ 9, FK: extra_field table');
            $table->text('extra10')->nullable()->comment('เก็บข้อมูล Field ที่ 10');
            $table->integer('extra_field_id10')->nullable()->unsigned()->comment('ชื่อ Field ที่ 10, FK: extra_field table');
            $table->text('extra11')->nullable()->comment('เก็บข้อมูล Field ที่ 11');
            $table->integer('extra_field_id11')->nullable()->unsigned()->comment('ชื่อ Field ที่ 11, FK: extra_field table');
            $table->text('extra12')->nullable()->comment('เก็บข้อมูล Field ที่ 12');
            $table->integer('extra_field_id12')->nullable()->unsigned()->comment('ชื่อ Field ที่ 12, FK: extra_field table');
            $table->text('extra13')->nullable()->comment('เก็บข้อมูล Field ที่ 13');
            $table->integer('extra_field_id13')->nullable()->unsigned()->comment('ชื่อ Field ที่ 13, FK: extra_field table');
            $table->text('extra14')->nullable()->comment('เก็บข้อมูล Field ที่ 14');
            $table->integer('extra_field_id14')->nullable()->unsigned()->comment('ชื่อ Field ที่ 14, FK: extra_field table');
            $table->text('extra15')->nullable()->comment('เก็บข้อมูล Field ที่ 15');
            $table->integer('extra_field_id15')->nullable()->unsigned()->comment('ชื่อ Field ที่ 15, FK: extra_field table');
            $table->text('extra16')->nullable()->comment('เก็บข้อมูล Field ที่ 16');
            $table->integer('extra_field_id16')->nullable()->unsigned()->comment('ชื่อ Field ที่ 16, FK: extra_field table');
            $table->text('extra17')->nullable()->comment('เก็บข้อมูล Field ที่ 17');
            $table->integer('extra_field_id17')->nullable()->unsigned()->comment('ชื่อ Field ที่ 17, FK: extra_field table');
            $table->text('extra18')->nullable()->comment('เก็บข้อมูล Field ที่ 18');
            $table->integer('extra_field_id18')->nullable()->unsigned()->comment('ชื่อ Field ที่ 18, FK: extra_field table');
            $table->text('extra19')->nullable()->comment('เก็บข้อมูล Field ที่ 19');
            $table->integer('extra_field_id19')->nullable()->unsigned()->comment('ชื่อ Field ที่ 19, FK: extra_field table');
            $table->text('extra20')->nullable()->comment('เก็บข้อมูล Field ที่ 20');
            $table->integer('extra_field_id20')->nullable()->unsigned()->comment('ชื่อ Field ที่ 20, FK: extra_field table');
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
        Schema::drop('extra_info');
    }
}
