<?php

use Illuminate\Database\Seeder;

class DropTruncate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE users');
        DB::statement('TRUNCATE TABLE marinecenter');
        DB::statement('TRUNCATE TABLE institution');
        DB::statement('TRUNCATE TABLE county');
        DB::statement('TRUNCATE TABLE district');
        DB::statement('TRUNCATE TABLE province');
        DB::statement('TRUNCATE TABLE country');
        DB::statement('TRUNCATE TABLE header_taxonomy');
        DB::statement('TRUNCATE TABLE wording_type');
        DB::statement('TRUNCATE TABLE wording');
        DB::statement('TRUNCATE TABLE language');
        DB::statement('TRUNCATE TABLE system_log');
        DB::statement('TRUNCATE TABLE record');
        DB::statement('TRUNCATE TABLE collection');
        DB::statement('TRUNCATE TABLE reference');
        DB::statement('TRUNCATE TABLE classification');
        DB::statement('TRUNCATE TABLE taxonomy');
        DB::statement('TRUNCATE TABLE role');
        DB::statement('TRUNCATE TABLE reference');
        DB::statement('TRUNCATE TABLE record');
    }
}
