<?php

use Illuminate\Database\Seeder;

class AddMarineCenter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('marinecenter')->insert(array(
            'institution_id'=>'1',
            'marinecenter'=>'Phuket Marine Biological Center',
            'marinecenter_code'=>'PMBC',
            'marinecenter_th'=>'ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทะเลอันดามัน',
            'marinecenter_code_th'=>'-',
            'address'=>'-',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
        DB::table('marinecenter')->insert(array(
            'institution_id'=>'1',
            'marinecenter'=>'Marine and Coastal Resources Research and Development Center, Eastern Gulf of Thailand',
            'marinecenter_code'=>'MCRRDE',
            'marinecenter_th'=>'ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยฝั่งตะวันออก',
            'marinecenter_code_th'=>'-',
            'address'=>'-',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
        DB::table('marinecenter')->insert(array(
            'institution_id'=>'1',
            'marinecenter'=>'Marine and Coastal Resources Research and Development Center, Upper Gulf of Thailand',
            'marinecenter_code'=>'MCRRDU',
            'marinecenter_th'=>'ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนบน',
            'marinecenter_code_th'=>'-',
            'address'=>'-',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
        DB::table('marinecenter')->insert(array(
            'institution_id'=>'1',
            'marinecenter'=>'Marine and Coastal Resources Research and Development Center, Center Gulf of Thailand',
            'marinecenter_code'=>'MCRRDC',
            'marinecenter_th'=>'ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนกลาง',
            'marinecenter_code_th'=>'-',
            'address'=>'-',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
        DB::table('marinecenter')->insert(array(
            'institution_id'=>'1',
            'marinecenter'=>'Marine and Coastal Resources Research and Development Center, Lower Gulf of Thailand',
            'marinecenter_code'=>'MCRRDL',
            'marinecenter_th'=>'ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนล่าง',
            'marinecenter_code_th'=>'-',
            'address'=>'-',
            'status'=>'2',
            'created_by'=>'1',
            'updated_by'=>'1',
            'created_at'=>date('Y-m-d H:m:s'),
            'updated_at'=>date('Y-m-d H:m:s'),
        ));
    }
}
