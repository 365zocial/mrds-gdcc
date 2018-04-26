<?php

use Illuminate\Database\Seeder;

class AddLanguage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('language')->insert(array(
            'id'=>1,
            'name'=>'English',
            'code_lang'=>'EN',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
        
        DB::table('language')->insert(array(
            'id'=>2,
            'name'=>'Thai',
            'code_lang'=>'TH',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
    }
}
