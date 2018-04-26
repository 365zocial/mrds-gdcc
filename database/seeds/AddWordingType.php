<?php

use Illuminate\Database\Seeder;

class AddWordingType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [ 'identification_qualifier',
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
        'plant_type',
        'place'];

        foreach ($data as $value) {
            DB::table('wording_type')->insert(array(
                'name'					=>	  	"$value",
                'created_by'			=>		'1',
                'updated_by'			=>		'1',
                'created_at'			=>		date('Y-m-d H:m:s'),
                'updated_at'			=>		date('Y-m-d H:m:s'),
            ));

        }

    }
}
