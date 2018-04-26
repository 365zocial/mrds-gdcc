<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unique_record');
            $table->integer('classification_id');
            $table->integer('language_id');
            $table->integer('marinecenter_id');
            $table->integer('collection_code');
            $table->integer('catalog_number')->nullable();
            $table->string('related_catalog_item', 255)->nullable();
            $table->tinyInteger('source');
            $table->integer('reference')->nullable();
            $table->integer('page')->nullable();
            $table->integer('no_species');
            $table->integer('no_locality')->nullable();
            $table->text('related_reference_item')->nullable(); // marince_code + collection_code + reference + page + no_species + no_locality
            $table->string('individual_count', 255)->nullable();
            $table->string('latitude', 255)->nullable();
            $table->string('verbatim_latitude', 255)->nullable();
            $table->string('start_latitude', 255)->nullable();
            $table->string('end_latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->string('verbatim_longitude', 255)->nullable();
            $table->string('start_longitude', 255)->nullable();
            $table->string('end_longitude', 255)->nullable();
            $table->integer('country');
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('county')->nullable();
            $table->text('locality')->nullable();
            $table->integer('ocean_sea_lake')->nullable();
            $table->integer('habitat')->nullable();
            $table->integer('type_status')->nullable();
            $table->integer('sex')->nullable();
            $table->string('size', 255)->nullable();
            $table->integer('life_stage')->nullable();
            $table->integer('donated_from')->nullable();
            $table->integer('deposited_at')->nullable();
            $table->integer('gear_method')->nullable();
            $table->string('depth_start', 255)->nullable();
            $table->string('depth_end', 255)->nullable();
            $table->string('collector', 255)->nullable();
            $table->date('collected_date')->nullable();
            $table->string('collected_year', 4)->nullable();
            $table->string('collected_month', 2)->nullable();
            $table->string('collected_day', 2)->nullable();
            $table->string('identifier', 255)->nullable();
            $table->date('identified_date')->nullable();
            $table->string('identified_year', 4)->nullable();
            $table->string('identified_month', 2)->nullable();
            $table->string('identified_day', 2)->nullable();
            $table->string('previous_identifier', 255)->nullable();
            $table->date('previous_identified_date')->nullable();
            $table->text('note_collector')->nullable();
            $table->integer('expedition')->nullable();
            $table->integer('preparation_type')->nullable();
            $table->string('gene_bank_number', 255)->nullable();
            $table->text('local_name')->nullable();
            $table->text('vernacular_name')->nullable();
            $table->text('variety_name')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('description')->nullable();
            $table->integer('team_exploration_code')->nullable();
            $table->integer('area_exploration')->nullable();
            $table->integer('village_no')->nullable();
            $table->integer('area_direction')->nullable();
            $table->text('area')->nullable();
            $table->integer('utilization')->nullable();
            $table->text('folk_wisdom')->nullable();
            $table->integer('recorder')->nullable();
            $table->text('knowledge_remarks')->nullable();
            $table->string('soil_temperature', 255)->nullable();
            $table->text('soil_character')->nullable();
            $table->string('soil_ph', 255)->nullable();
            $table->string('water_temperature', 255)->nullable();
            $table->string('transparency', 255)->nullable();
            $table->string('water_ph', 255)->nullable();
            $table->string('dissolve_oxygen', 255)->nullable();
            $table->string('suspended_solid', 255)->nullable();
            $table->string('salinity', 255)->nullable();
            $table->tinyInteger('specimen_collection')->nullable();
            $table->tinyInteger('specimen_photograph')->nullable();
            $table->integer('sighting_no')->nullable();
            $table->text('exploration_remark')->nullable();
            $table->time('sighting_time');
            $table->text('food')->nullable();
            $table->tinyInteger('water_place')->nullable();
            $table->tinyInteger('tree_place')->nullable();
            $table->tinyInteger('soil_earth_place')->nullable();
            $table->tinyInteger('ground_earth_place')->nullable();
            $table->tinyInteger('coast_place')->nullable();
            $table->tinyInteger('solo_living')->nullable();
            $table->tinyInteger('group_living')->nullable();
            $table->tinyInteger('animal_type1')->nullable();
            $table->tinyInteger('animal_type2')->nullable();
            $table->tinyInteger('animal_type3')->nullable();
            $table->string('reproduction', 10)->nullable();
            $table->tinyInteger('plant_type');
            $table->text('picture_name')->nullable();
            $table->text('picture_remark')->nullable();
            $table->boolean('migration_data')->default(false);
            $table->boolean('approve_status')->default(false);
            $table->string('approve_by', 255)->nullable();
            $table->tinyInteger('status');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
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
        Schema::drop('record');
    }
}
