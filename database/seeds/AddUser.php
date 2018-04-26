<?php

use Illuminate\Database\Seeder;

class AddUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // DB::table('users')->insert(array(
        //     // 'username'=>'developer',
        //     'name'=>'administrator',
        //     'password' => Hash::make('qwerty'),
        //     'first_name'=>'Administrator',
        //     'last_name'=>'administrator',
        //     'gender'=>'m',
        //     'email'=>'administrator@administrator.com',
        //     'telephone'=>'12345667890',
        //     'position'=>'Developer_at_somewhere_in_Softwarepark',
        //     'company'=>'somewhere_in_Softwarepark',
        //     'address'=>'somewhere_in_Softwarepark',
        //     'approve_permission'=>true,
        //     'marinecenter_id'=>'1',
        //     'role_id'=>'2',
        //     'status'=>'2',
        //     'created_by'=>'1',
        //     'updated_by'=>'1',
        //     'created_at'=>date('Y-m-d H:m:s'),
        //     'updated_at'=>date('Y-m-d H:m:s'),
        // ));
        //
        // DB::table('users')->insert(array(
        //     // 'username'=>'developer',
        //     'name'=>'manager',
        //     'password' => Hash::make('qwerty'),
        //     'first_name'=>'Manager',
        //     'last_name'=>'manager',
        //     'gender'=>'f',
        //     'email'=>'manager@manager.com',
        //     'telephone'=>'12345667890',
        //     'position'=>'Developer_at_somewhere_in_Softwarepark',
        //     'company'=>'somewhere_in_Softwarepark',
        //     'address'=>'somewhere_in_Softwarepark',
        //     'approve_permission'=>false,
        //     'marinecenter_id'=>'1',
        //     'role_id'=>'3',
        //     'status'=>'2',
        //     'created_by'=>'1',
        //     'updated_by'=>'1',
        //     'created_at'=>date('Y-m-d H:m:s'),
        //     'updated_at'=>date('Y-m-d H:m:s'),
        // ));


    }
}
