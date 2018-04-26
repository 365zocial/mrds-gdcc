<?php

use Illuminate\Database\Seeder;

class AddRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert(array(
            'id'			=>	1,
            'role'          =>  'Super Administrator',
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        DB::table('role')->insert(array(
            'id'			=>	2,
            'role'          =>  'Administrator',
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        DB::table('role')->insert(array(
            'id'			=>	3,
            'role'          =>  'Manager',
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        DB::table('role')->insert(array(
            'id'			=>	4,
            'role'          =>  'Board',
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        DB::table('role')->insert(array(
            'id'			=>	5,
            'role'          =>  'User',
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));

        DB::table('role')->insert(array(
            'id'			=>	6,
            'role'          =>  'PGCP',
            'created_by'	=>	1,
            'updated_by'	=>	1,
            'created_at'	=>	date('Y-m-d H:m:s'),
            'updated_at'	=>	date('Y-m-d H:m:s')
        ));


    }
}
