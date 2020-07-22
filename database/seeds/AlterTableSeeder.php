<?php

use Illuminate\Database\Seeder;

class AlterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE marinecenter DROP PRIMARY KEY, ADD PRIMARY KEY(id, institution_id)');
        DB::statement('ALTER TABLE province DROP PRIMARY KEY, ADD PRIMARY KEY(id ,country_id )');
        DB::statement('ALTER TABLE district DROP PRIMARY KEY, ADD PRIMARY KEY(id ,province_id)');
        DB::statement('ALTER TABLE county DROP PRIMARY KEY, ADD PRIMARY KEY(id, district_id)');
        DB::statement('ALTER TABLE picture DROP PRIMARY KEY, ADD PRIMARY KEY(id, unique_record)');

        DB::statement('ALTER TABLE record_utilizations DROP PRIMARY KEY, ADD PRIMARY KEY(record_unique_id, utilization_id)');
        DB::statement('ALTER TABLE record_places DROP PRIMARY KEY, ADD PRIMARY KEY(record_unique_id, place_id)');
        DB::statement('ALTER TABLE record_sexes DROP PRIMARY KEY, ADD PRIMARY KEY(record_unique_id, sex_id)');
    }
}
