<?php

use Illuminate\Database\Seeder;

class AddHeaderTaxonomy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Domain
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	1,
            'name'			=>	'Domain',
            'level'			=>	1,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        // Kingdom
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	2,
            'name'			=>	'Kingdom',
            'level'			=>	2,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        // Subkingdom
        DB::table('header_taxonomy')->insert(array(
            'id'            =>  3,
            'name'          =>  'Subkingdom',
            'level'         =>  3,
            'created_by'    =>  1,
            'updated_by'    =>  1,
            'created_at'    =>  date('Y-m-d H:m:s'),
            'updated_at'    =>  date('Y-m-d H:m:s')
        ));

        // Infrakingdom
        DB::table('header_taxonomy')->insert(array(
            'id'            =>  4,
            'name'          =>  'Infrakingdom',
            'level'         =>  4,
            'created_by'    =>  1,
            'updated_by'    =>  1,
            'created_at'    =>  date('Y-m-d H:m:s'),
            'updated_at'    =>  date('Y-m-d H:m:s')
        ));

        // Phylum
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	5,
            'name'			=>	'Phylum',
            'level'			=>	5,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Subphylum
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	6,
            'name'			=>	'Subphylum',
            'level'			=>	6,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        // Infraphylum
        DB::table('header_taxonomy')->insert(array(
            'id'            =>  7,
            'name'          =>  'Infraphylum',
            'level'         =>  7,
            'created_by'    =>  1,
            'updated_by'    =>  1,
            'created_at'    =>  date('Y-m-d H:m:s'),
            'updated_at'    =>  date('Y-m-d H:m:s')
        ));

        // SuperClass
        DB::table('header_taxonomy')->insert(array(
            'id'            =>  8,
            'name'          =>  'Superclass',
            'level'         =>  8,
            'created_by'    =>  1,
            'updated_by'    =>  1,
            'created_at'    =>  date('Y-m-d H:m:s'),
            'updated_at'    =>  date('Y-m-d H:m:s')
        ));

		// Class
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	9,
            'name'			=>	'Class',
            'level'			=>	9,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Subclass
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	10,
            'name'			=>	'Subclass',
            'level'			=>	10,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Infraclass
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	11,
            'name'			=>	'Infraclass',
            'level'			=>	11,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        // Superorder
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	12,
            'name'			=>	'Superorder',
            'level'			=>	12,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Order
        DB::table('header_taxonomy')->insert(array(
            'id'			=>	13,
            'name'			=>	'Order',
            'level'			=>	13,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Suborder
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	14,
            'name'			=>	'Suborder',
            'level'			=>	14,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Infraorder
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	15,
            'name'			=>	'Infraorder',
            'level'			=>	15,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Superfamily
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	16,
            'name'			=>	'Superfamily',
            'level'			=>	16,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Family
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	17,
            'name'			=>	'Family',
            'level'			=>	17,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Subfamily
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	18,
            'name'			=>	'Subfamily',
            'level'			=>	18,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Genus
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	19,
            'name'			=>	'Genus',
            'level'			=>	19,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Subgenus
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	20,
            'name'			=>	'Subgenus',
            'level'			=>	20,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Species
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	21,
            'name'			=>	'Species',
            'level'			=>	21,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

		// Subspecies
		DB::table('header_taxonomy')->insert(array(
            'id'			=>	22,
            'name'			=>	'Subspecies',
            'level'			=>	22,
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

    }
}
