<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('password', 100);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->char('gender', 1);
            $table->string('email')->unique();
            $table->string('telephone', 12);
            $table->string('position');
            $table->string('company');
            $table->text('address');
            $table->boolean('approve_permission')->default(false);
            $table->integer('marinecenter_id')->nullable();
            $table->integer('role_id')->unsigned();
            $table->tinyInteger('status');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
