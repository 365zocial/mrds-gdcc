<?php

use Illuminate\Database\Seeder;

class AddGroupPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_permission')->insert(array(
            'id'=>1,
            'name'=>'A',
            'comment'=>'Domain, Kingdom, Subkingdom, Infrakingdom, Phylum, Subphylum, Infraphylum, Superclass, Class, Subclass, Infraclass, Superorder, Order, Suborder, Infraorder, Superfamily, Family, Subfamily, Genus, Subgenus, Species, Subspecies',
            'status_manager'=>'2',
            'status_user'=>'2',
            'status_board'=>'2',
            'status_pgcp'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));

        DB::table('group_permission')->insert(array(
            'id'=>2,
            'name'=>'B',
            'comment'=>'OceanSeaLake, Country, Province, District, County, Locality',
            'status_manager'=>'2',
            'status_user'=>'2',
            'status_board'=>'2',
            'status_pgcp'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));

        DB::table('group_permission')->insert(array(
            'id'=>3,
            'name'=>'C',
            'comment'=>'Pink_Field',
            'status_manager'=>'2',
            'status_user'=>'2',
            'status_board'=>'2',
            'status_pgcp'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));

    }
}
