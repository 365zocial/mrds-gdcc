<?php

use Illuminate\Database\Seeder;

class DropData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('DELETE FROM system_log');
        DB::statement('DELETE FROM login_log');
        DB::statement('DELETE FROM users');
        DB::statement('DELETE FROM marinecenter');
        DB::statement('DELETE FROM institution');
        DB::statement('DELETE FROM county');
        DB::statement('DELETE FROM district');
        DB::statement('DELETE FROM province');
        DB::statement('DELETE FROM country');
        DB::statement('DELETE FROM header_taxonomy');
        DB::statement('DELETE FROM wording');
        DB::statement('DELETE FROM wording_type');
        DB::statement('DELETE FROM language');
        DB::statement('DELETE FROM taxonomy');
        DB::statement('DELETE FROM record');
        DB::statement('DELETE FROM picture');
        DB::statement('DELETE FROM collection');
        DB::statement('DELETE FROM reference');
        DB::statement('DELETE FROM classification');
        DB::statement('DELETE FROM reference');
        DB::statement('DELETE FROM role');
        DB::statement('DELETE FROM record');
        DB::statement('DELETE FROM file_migrate_log');
        DB::statement('DELETE FROM group_permission');
        DB::statement('DELETE FROM extra_field');


    }
}
