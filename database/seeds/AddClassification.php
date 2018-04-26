<?php

use Illuminate\Database\Seeder;

class AddClassification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i = 1;$i<=100;$i++){
            DB::table('classification')->insert(array(
                'current_scientific_name'		=>		'Godzilla '.$i,
                'previous_scientific_name'		=>		'',
                'domain'				=>		'1', //1-3
                'kingdom'				=>		'5', //4-6

                'subkingdom'            =>      '8', //4-6 *
                'infrakingdom'          =>      '5', //4-6 *

                'phylum'				=>		'8', //7-9
                'subphylum'				=>		'11', //10-12

                'infraphylum'           =>      '11', //10-12 *
                'superClass'            =>      '11', //10-12 *

                'class'					=>		'13', //13-15
                'subclass'				=>		'16', //16-18
                'infraclass'			=>		'19', //19-21
                'superorder'			=>		'24', //22-24
                'order_o'				=>		'27', //25-27
                'suborder'				=>		'30', //28-30
                'infraorder'			=>		'31', //31-33
                'superfamily'			=>		'35', //34-36
                'family'				=>		'39', //37-39
                'subfamily'				=>		'40', //40-42
                'genus'					=>		'44', //43-45
                'subgenus'				=>		'48', //46-48
                'species'				=>		'51', //49-51
                'subspecies'			=>		'53', //52-54
                'identification_qualifier'	    =>		'1',
                'status'				=>		'2',
                'created_by'			=>		'1',
                'updated_by'			=>		'0',
                'created_at'			=>		date('Y-m-d H:m:s'),
                'updated_at'			=>		date('Y-m-d H:m:s'),
            ));
        }
    }
}
