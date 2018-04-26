<?php

use Illuminate\Database\Seeder;

class DropAI extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE marinecenter AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE institution AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE county AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE district AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE province AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE country AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE header_taxonomy AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE wording_type AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE wording AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE language AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE system_log AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE record AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE picture AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE collection AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE reference AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE classification AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE taxonomy AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE role AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE reference AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE record AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE file_migrate_log AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE group_permission AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE extra_field AUTO_INCREMENT = 1');


    }
}
