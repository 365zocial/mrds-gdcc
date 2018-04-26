<?php

use Illuminate\Database\Seeder;

class AddTaxonomy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //for test data
    public function run()
    {

        $data = [
            // ['Domain 1','Domain 2','Domain 3'], //domain
            // ['Kingdom 1','Kingdom 2','Kingdom 3'], //kingdom
            // ['Subkingdom 1','Subkingdom 2','Subkingdom 3'], //subkingdom
            // ['Infrakingdom 1','Infrakingdom 2','Infrakingdom 3'], //infrakingdom

            ['Annelida', 'Arthropoda', 'Bacillariophyta', 'Basidiomycota', 'Brachiopoda',
            'Bryozoa', 'Chlorophyta', 'Chordata', 'Cnidaria', 'Cyanobacteria',
            'Echinodermata', 'Entoprocta', 'Foraminifera', 'Mollusca', 'Myzozoa',
            'Nemertea', 'Ochrophyta', 'Platyhelminthes', 'Xenacoelomorpha', 'Porifera',
            'Rhodophyta', 'Sipuncula', 'Tracheophyta'], //phylum

            // ['Subphylum 1','Subphylum 2','Subphylum 3'], //subphylum
            // ['Infraphylum 1','Infraphylum 2','Infraphylum 3'], //infraphylum
            // ['SuperClass 1','SuperClass 2','SuperClass 3'], //superclass
            // ['Class 1','Class 2','Class 3'], //class
            //
            // ['Subclass 1','Subclass 2','Subclass 3'], //subclass
            // ['Infraclass 1','Infraclass 2','Infraclass 3'], //infraclass
            // ['Superorder 1','Superorder 2','Superorder 3'], //superorder
            // ['Order_o 1','Order_o 2','Order_o 3'], //order_o
            // ['Suborder 1','Suborder 2','Suborder 3'], //suborder
            // ['Infraorder 1','Infraorder 2','Infraorder 3'], //infraorder
            // ['Superfamily 1','Superfamily 2','Superfamily 3'], //Superfamily
            // ['Family 1','Family 2','Family 3'], //Family
            // ['Subfamily 1','Subfamily 2','Subfamily 3'], //Subfamily
            // ['Genus 1','Genus 2','Genus 3'], //Genus
            // ['Subgenus 1','Subgenus 2','Subgenus 3'], //Subgenus
            // ['Species 1','Species 2','Species 3'], //Species
            // ['Subspecies 1','Subspecies 2','Subspecies 3'] //Subspecies
        ];

        $no = 1;
        foreach ($data as $value) {
            foreach($value as $subdata){
                DB::table('taxonomy')->insert(array(
                    'name'					=>		"$subdata",
    	            'header_taxonomy_id'	=>		"5",
    	            'status'				=>		'2',
    	            'created_by'			=>		'1',
    	            'updated_by'			=>		'1',
    	            'created_at'			=>		date('Y-m-d H:m:s'),
    	            'updated_at'			=>		date('Y-m-d H:m:s'),
                ));
            }

            ++$no;
        }


    }
}
