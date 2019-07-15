<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordingTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wording_type', function (Blueprint $table) {
            $table->increments('id')->comment(' 1 = identification_qualifier,
                                                2 = type_status,
                                                3 = ocean_sea_lake,
                                                4 = gear_method,
                                                5 = sex,
                                                6 = expedition,
                                                7 = preparation_type,
                                                8 = habitat,
                                                9 = life_stage,
                                                10 = donated_from,
                                                11 = deposited_at,
                                                12 = protection_iucn_2019,
                                                13 = reproduction
                                                14 = area_direction,
                                                15 = utilization,
                                                16 = team_exploration_code,
                                                17 = area_exploration,
                                                18 = animal_type1,
                                                19 = animal_type2,
                                                20 = animal_type3,
                                                21 = plant_type,
                                                22 = protection_thai_law,
                                                23 = protection_cites,
                                                24 = economic_value,
                                                25 = sediment_type,
                                                26 = invasive_species,
                                                27 = living
                                                ');
            $table->string('name')->comment('ชื่อประเภทของข้อความ');
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
        Schema::drop('wording_type');
    }
}
