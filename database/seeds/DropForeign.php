<?php

use Illuminate\Database\Seeder;

class DropForeign extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE users DROP FOREIGN KEY fk_User_Role');
        DB::statement('ALTER TABLE marinecenter DROP FOREIGN KEY fk_Marine_Institution');
        DB::statement('ALTER TABLE district DROP FOREIGN KEY fk_District_Province');
        DB::statement('ALTER TABLE county DROP FOREIGN KEY fk_County_District');
        DB::statement('ALTER TABLE province DROP FOREIGN KEY fk_Province_Country');
        DB::statement('ALTER TABLE picture DROP FOREIGN KEY fk_Picture_Record');
        DB::statement('ALTER TABLE reference DROP FOREIGN KEY fk_Reference_Marine');
        DB::statement('ALTER TABLE wording DROP FOREIGN KEY fk_Wording_Wording_Type');

        
        // DB::statement('ALTER TABLE login_log DROP FOREIGN KEY fk_Login_Users');
        // DB::statement('ALTER TABLE system_log DROP FOREIGN KEY fk_System_log_Users_Create');

        //record
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_Classification');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_Country');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_Province');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_District');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_County');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_Collection');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_Reference');
        // DB::statement('ALTER TABLE record DROP FOREIGN KEY fk_Record_Language');

        //taxonomy
        DB::statement('ALTER TABLE taxonomy DROP FOREIGN KEY fk_Taxonomy_HeaderTaxonomy');


    }
}
