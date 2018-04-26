
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $use_create = 1;

        if($use_create == 1){
            $this->call(AddInstitution::class);
            $this->call(AddMarineCenter::class);
            $this->call(AddUser::class);
            $this->call(AddCountry::class);
            $this->call(AddHeaderTaxonomy::class);
            $this->call(AddLanguage::class);
            $this->call(AddWordingType::class);
            $this->call(AddReference::class);
            $this->call(AddRole::class);
            $this->call(AddGroupPermission::class);

            $this->call(AddExtraField::class);

            $this->call(AddTaxonomy::class);
            $this->call(AddWording::class);

            $this->call(AlterTableSeeder::class);
            $this->call(AlterForiegnSeeder::class);

            $this->call(PictureBoxSeeder::class);

            // $this->call(AddClassification::class);
            // $this->call(AddRecord::class);

        }else{
            //========== for drop foreign key ===========
            $this->call(DropForeign::class);
            $this->call(DropData::class);
            $this->call(DropAI::class);
            // $this->call(DropTruncate::class);
        }

    }
}
