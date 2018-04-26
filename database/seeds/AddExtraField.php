<?php

use Illuminate\Database\Seeder;

class AddExtraField extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = array(
            'Extra1',
            'Extra2',
            'Extra3',
            'Extra4',
            'Extra5',
            'Extra6',
            'Extra7',
            'Extra8',
            'Extra9',
            'Extra10',
            'Extra11',
            'Extra12',
            'Extra13',
            'Extra14',
            'Extra15',
            'Extra16',
            'Extra17',
            'Extra18',
            'Extra19',
            'Extra20',
        );

        for ( $i = 0; $i < sizeof( $arr ); $i++ ) {
            DB::table('extra_field')->insert(array(
                'id'=>$i+1,
                'name'=> $arr[$i],
                'status'=> 2,
                'created_by'=>'1',
                'updated_by'=>'1',
                'created_at'=>date('Y-m-d H:m:s'),
                'updated_at'=>date('Y-m-d H:m:s'),
            ));
        }

    }
}
