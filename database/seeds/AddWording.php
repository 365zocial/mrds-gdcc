<?php

use Illuminate\Database\Seeder;

class AddWording extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        # Set 1: English Only or Thai Only
        // Set Data Type
        $data_type = [   'identification_qualifier',
                    'type_status',
                    'ocean_sea_lake',
                    'gear_method',
                    'sex',
                    'expedition',
                    'preparation_type',
                    'habitat',
                    'life_stage',
                    'donated_from',
                    'deposited_at',
                    'protection_type',
                    'area_direction',
                    'utilization',
                    'team_exploration_code',
                    'area_exploration',
                    'recorder',
                    'animal_type1',
                    'animal_type2',
                    'animal_type3',
                    'plant_type'
                ];

        // Set Data
        $data = [
            ['cf.', 'aff.', 'var.'], //identification_qualifier
            ['Holotype','Paratype','Neotype','Allotype'], //type_status
            [], //ocean_sea_lake
            [], //gear_method
            ['Male','Female','Hermaphrodite','Indeterminate','Unknown','Transitional','Imposex'], //sex',
            [], //expedition
            ['Dry', 'Alcohol', 'Formalin', 'SEM Stuff', 'Slide', 'Herbarium'], //preparation_type
            [], //habitat (*empty)
            ['Juvenile', 'Adult'], //life_stage
            [], //donated_from
            ['deposited_at_0'], //deposited_at
            ['สัตว์ป่าคุ้มครอง','สัตว์ป่าสงวน','สัตว์หายาก','สัตว์ใกล้สูญพันธุ์'], //protection_type
            [], //area_direction empty
            ['ความเพลิดเพลิน','การค้า','ใช้แรงงาน','อาหาร','ยา','ศึกษาวิจัย','เครื่องนุ่งห่ม'], //utilization
            ['team_exploration_code_0'], //team_exploration_code
            ['area_exploration_0'], //area_exploration
            ['recorder_0'], //recorder
            ['สัตว์บก','สัตว์น้ำ'], //animal_type1
            ['สัตว์มีกระดูกสันหลัง','สัตว์ไม่มีกระดูกสันหลัง'], //animal_type2
            ['สัตว์พื้นทะเล', 'ปลา', 'สัตว์ทะเล', 'สัตว์สะเทิ้นน้ำสะเทิ้นบก', 'สัตว์เลี้ยงลูกด้วยนม', 'สัตว์ปีก', 'สัตว์เลื้อยคลาน', 'สัตว์อื่นๆ'], //animal_type3
            ['สาหร่าย', 'หญ้าทะเล', 'พรรณไม้ป่าชายเลน', 'พรรณไม้ป่าชายหาด', 'ไม้อื่นๆ'] //plant_type
        ];

        // Insert Data
        $no = 1;
        foreach ($data as $value) {
            if( sizeof( $value ) > 0 ){
                foreach($value as $subdata){
                    DB::table('wording')->insert(array(
                        'wording_type_id'       =>      "$no",
                        'name_en'				=>	  	"$subdata",
                        'name_th'				=>	  	"$subdata",
                        'status'				=>	  	'2',
                        'created_by'			=>		'1',
                        'updated_by'			=>		'1',
                        'created_at'			=>		date('Y-m-d H:m:s'),
                        'updated_at'			=>		date('Y-m-d H:m:s'),
                    ));
                }
            }

            ++$no;
        }
        # -------------------------------

        # Set 2: English and Thai
        // Set Data Type
        $data_type2 = [
            'habitat',  // 8
            'area_direction'    // 13
        ];

        // Set Data
        $data2 = [
            [[8, 'Rocky Shore', 'หาดหิน'], [8, 'Sandy Beach', 'หาดทราย'], [8, 'Muddy Beach', 'หาดโคลน'], [8, 'Mangrove', 'ป่าชายเลน'], [8, 'Seagrass Bed', 'แนวหญ้าทะเล'], [8, 'Coral Reef', 'แนวปะการัง'], [8, 'Estuary', 'ปากแม่น้ำ'],
            [8, 'Sea Bottom', 'พื้นทะเล'], [8, 'Sea Water Column', 'น้ำทะเล'], [8, 'Deep Sea', 'ทะเลลึก']],
            [[13, 'N', 'เหนือ'], [13, 'NE', 'ตะวันออกเฉียงเหนือ'], [13, 'NW', 'ตะวันตกเฉียงเหนือ'], [13, 'E', 'ตะวันออก'], [13, 'S', 'ใต้'], [13, 'SE', 'ตะวันออกเฉียงใต้'], [13, 'SW', 'ตะวันตกเฉียงใต้'], [13, 'W', 'ตะวันตก']]
        ];

        // Insert Data
        foreach ($data2 as $value) {
            if( sizeof( $value ) > 0 ){
                foreach($value as $subdata){
                    // print_r($subdata);
                    DB::table('wording')->insert(array(
                        'wording_type_id'       =>      $subdata[0],
                        'name_en'				=>	  	$subdata[1],
                        'name_th'				=>	  	$subdata[2],
                        'status'				=>	  	'2',
                        'created_by'			=>		'1',
                        'updated_by'			=>		'1',
                        'created_at'			=>		date('Y-m-d H:m:s'),
                        'updated_at'			=>		date('Y-m-d H:m:s'),
                    ));
                }
            }
        }
        # -----------------------

    }
}
