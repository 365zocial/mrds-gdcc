<?php

use Illuminate\Database\Seeder;

class AddInstitution extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institution')->insert(array(
            'department'=>'Department of Marine and Coastal Resources',
            'department_code'=>'DMCR',
            'department_th'=>'-',
            'department_code_th'=>'-',
            'institution'=>'Marine Coastal Resource Research and Development Institute',
            'institution_code'=>'MCRRDI',
            'institution_th'=>'-',
            'institution_code_th'=>'-',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
    }
}
