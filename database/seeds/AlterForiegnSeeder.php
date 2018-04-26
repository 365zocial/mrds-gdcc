<?php

use Illuminate\Database\Seeder;

class AlterForiegnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE marinecenter ADD CONSTRAINT fk_Marine_Institution FOREIGN KEY (institution_id) REFERENCES institution(id)');
        DB::statement('ALTER TABLE reference ADD CONSTRAINT fk_Reference_Marine FOREIGN KEY (marinecenter_id) REFERENCES marinecenter(id)');
        DB::statement('ALTER TABLE province ADD CONSTRAINT fk_Province_Country FOREIGN KEY (country_id) REFERENCES country(id)');
        DB::statement('ALTER TABLE district ADD CONSTRAINT fk_District_Province FOREIGN KEY (province_id) REFERENCES province(id)');
        DB::statement('ALTER TABLE county ADD CONSTRAINT fk_County_District FOREIGN KEY (district_id) REFERENCES district(id)');
        DB::statement('ALTER TABLE picture ADD CONSTRAINT fk_Picture_Record FOREIGN KEY (unique_record) REFERENCES record(id)');
        DB::statement('ALTER TABLE users ADD CONSTRAINT fk_User_Role FOREIGN KEY (role_id) REFERENCES role(id)');
        DB::statement('ALTER TABLE wording ADD CONSTRAINT fk_Wording_Wording_Type FOREIGN KEY (wording_type_id) REFERENCES wording_type(id)');
        // DB::statement('ALTER TABLE login_log ADD CONSTRAINT fk_Login_Users FOREIGN KEY (user_id) REFERENCES users(id)');
        // DB::statement('ALTER TABLE system_log ADD CONSTRAINT fk_System_log_Users_Create FOREIGN KEY (created_by) REFERENCES users(id)');

        //record
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_Classification FOREIGN KEY (classification_id) REFERENCES classification(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_Country FOREIGN KEY (country) REFERENCES country(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_Province FOREIGN KEY (province) REFERENCES province(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_District FOREIGN KEY (district) REFERENCES district(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_County FOREIGN KEY (county) REFERENCES county(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_Collection FOREIGN KEY (collection_code) REFERENCES collection(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_Reference FOREIGN KEY (reference) REFERENCES reference(id)');
        // DB::statement('ALTER TABLE record ADD CONSTRAINT fk_Record_Language FOREIGN KEY (language_id) REFERENCES language(id)');

        //taxonomy
        DB::statement('ALTER TABLE taxonomy ADD CONSTRAINT fk_Taxonomy_HeaderTaxonomy FOREIGN KEY (header_taxonomy_id) REFERENCES header_taxonomy(id)');


    }
}
