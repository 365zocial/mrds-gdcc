<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderTaxonomy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_taxonomy', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ header taxonomy // 1 = domain
                2 = kingdom,
                3 = subkingdom,
                4 = infrakingdom,
                5 = phylum,
                6 = subphylum,
                7 = infraphylum,
                8 = superclass,
                9 = class,
                10 = subclass,
                11 = infraclass,
                12 = superorder,
                13 = order,
                14 = suborder,
                15 = infraorder,
                16 = superfamily,
                17 = family,
                18 = subfamily,
                19 = genus,
                20 = subgenus,
                21 = species,
                22 = subspecies
                ');
            $table->string('name')->comment('ชื่อของหัวข้อ taxonomy เช่น Kingdom, Phylum, Family, Super Oder เป็นต้น');
            $table->integer('level')->comment('เพื่อบอกว่า หัวข้อ taxonomy อันไหนอยู่บนสุดหรืออยู่ล่างสุด โดยเลขน้อยคืออยู่บนสุด และเลขมากจะอยู่ล่างสุด');
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
        Schema::drop('header_taxonomy');
    }
}
