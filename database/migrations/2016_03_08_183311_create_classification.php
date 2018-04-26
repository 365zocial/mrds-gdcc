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
            $table->increments('id');
            $table->string('current_scientific_name');
            $table->string('current_scientific_name_format');
            $table->string('previous_scientific_name')->nullable();
            $table->string('previous_scientific_name_format');
            $table->integer('domain')->unsigned()->nullable();
            $table->integer('kingdom')->unsigned()->nullable();
            $table->integer('subkingdom')->unsigned()->nullable();
            $table->integer('infrakingdom')->unsigned()->nullable();
            $table->integer('phylum')->unsigned()->nullable();
            $table->integer('subphylum')->unsigned()->nullable();
            $table->integer('infraphylum')->unsigned()->nullable();
            $table->integer('superclass')->unsigned()->nullable();
            $table->integer('class')->unsigned()->nullable();
            $table->integer('subclass')->unsigned()->nullable();
            $table->integer('infraclass')->unsigned()->nullable();
            $table->integer('superorder')->unsigned()->nullable();
            $table->integer('order_o')->unsigned()->nullable();
            $table->integer('suborder')->unsigned()->nullable();
            $table->integer('infraorder')->unsigned()->nullable();
            $table->integer('superfamily')->unsigned()->nullable();
            $table->integer('family')->unsigned()->nullable();
            $table->integer('subfamily')->unsigned()->nullable();
            $table->integer('genus')->unsigned()->nullable();
            $table->integer('subgenus')->unsigned()->nullable();
            $table->integer('species')->unsigned()->nullable();
            $table->integer('subspecies')->unsigned()->nullable();
            $table->tinyInteger('identification_qualifier')->unsigned()->nullable();
            $table->integer('status')->unsigned();
            $table->text('common_name')->nullable();
            $table->integer('protection_type')->nullable();
            $table->boolean('migration_data')->default(false);
            $table->integer('created_by');
            $table->integer('updated_by');
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
