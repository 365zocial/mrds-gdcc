<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classification', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ Classification');
            $table->string('current_scientific_name')->comment('ชื่อของ Classification (ปัจจุบัน)');
            $table->string('current_scientific_name_format')->comment('ชื่อของ Classification (ปัจจุบัน) ที่เป็นแบบตัวเอียง');
            $table->string('previous_scientific_name')->nullable()->comment('ชื่อเก่าของ Classification');
            $table->string('previous_scientific_name_format')->nullable()->comment('ชื่อเก่าของ Classification ที่เป็นแบบตัวเอียง');
            $table->integer('domain')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Domain อะไร, FK: taxonomy table');
            $table->integer('kingdom')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Kingdom อะไร, FK: taxonomy table');
            $table->integer('subkingdom')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Subkingdom อะไร, FK: taxonomy table');
            $table->integer('infrakingdom')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Infrakingdom อะไร, FK: taxonomy table');
            $table->integer('phylum')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Phylum อะไร, FK: taxonomy table');
            $table->integer('subphylum')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Subphylum อะไร, FK: taxonomy table');
            $table->integer('infraphylum')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Infraphylum อะไร, FK: taxonomy table');
            $table->integer('superclass')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Superclass อะไร, FK: taxonomy table');
            $table->integer('class')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Class อะไร, FK: taxonomy table');
            $table->integer('subclass')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Subclass อะไร, FK: taxonomy table');
            $table->integer('infraclass')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Infraclass อะไร, FK: taxonomy table');
            $table->integer('superorder')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Superorder อะไร, FK: taxonomy table');
            $table->integer('order_o')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Order อะไร, FK: taxonomy table');
            $table->integer('suborder')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Suborder อะไร, FK: taxonomy table');
            $table->integer('infraorder')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Infraorder อะไร, FK: taxonomy table');
            $table->integer('superfamily')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Superfamily อะไร, FK: taxonomy table');
            $table->integer('family')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Family อะไร, FK: taxonomy table');
            $table->integer('subfamily')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Subfamily อะไร, FK: taxonomy table');
            $table->integer('genus')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Genus อะไร, FK: taxonomy table');
            $table->integer('subgenus')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Subgenus อะไร, FK: taxonomy table');
            $table->integer('species')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Species อะไร, FK: taxonomy table');
            $table->integer('subspecies')->unsigned()->nullable()->comment('รหัสที่บอกว่า Record อยู่ Subspecies อะไร, FK: taxonomy table');
            $table->tinyInteger('identification_qualifier')->unsigned()->nullable()->comment('คุณลักษณะของการยืนยันชื่อ, FK: wording table');
            $table->integer('protection_thai_law')->nullable()->comment('การคุ้มครองสัตว์ (ตามกฎหมายไทย), FK: wording table');
            $table->integer('protection_iucn')->nullable()->comment('การคุ้มครองสัตว์, FK: wording table');
            $table->integer('protection_cites')->nullable()->comment('การคุ้มครองสัตว์ ตามบัญชี CITES, FK: wording table');
            $table->text('common_name')->nullable()->comment('ชื่อสามัญ');
            $table->integer('status')->unsigned()->comment('สถานะที่ต้องการจะให้ปรากฏในระบบหรือไม่ // 2 = Enable, 1 = Disable');
            $table->boolean('migration_data')->default(false)->comment('เป็นตัวบอกว่า Record เป็นข้อมูลใหม่ที่กรอกผ่านเว็บ หรือเป็นข้อมูลที่เกิดจาก migrate // 1 = migrate, 0 = ข้อมูลใหม่');
            $table->integer('created_by')->comment('ใครเป็นผู้บันทึก, FK: users table');
            $table->integer('updated_by')->comment('ใครเป็นผู้แก้ไข, FK: users table');
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
        Schema::drop('classification');
    }
}
