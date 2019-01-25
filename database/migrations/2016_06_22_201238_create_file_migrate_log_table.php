<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileMigrateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_migrate_log', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ file_migrate_log');
            $table->string('file_name', 255)->comment('ชื่อของ File ที่ Upload เข้ามา');
            $table->integer('row')->unsigned()->comment('จำนวน row ใน File');
            $table->boolean('have_error')->comment('มี error หรือไม่ // 0 = ไม่มี error, 1 = มี error');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้ Upload File, FK: users table');
            $table->integer('updated_by')->unsigned()->comment('ใครเป็นผู้แก้ไข Upload File, FK: users table');
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
        //
        Schema::drop('file_migrate_log');
    }
}
