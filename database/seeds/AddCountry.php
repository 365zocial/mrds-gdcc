<?php

use Illuminate\Database\Seeder;

class AddCountry extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('country')->insert(array(
            'country_en'=>'Thailand',
            'country_th'=>'ประเทศไทย',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));

        DB::table('country')->insert(array(
            'country_en'=>'Myanmar',
            'country_th'=>'สาธารณรัฐแห่งสหภาพเมียนมาร์',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
    }
}
