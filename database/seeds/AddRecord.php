<?php

use Illuminate\Database\Seeder;

class AddRecord extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uniq = 1;
        for($i = 1;$i<=10;$i++){

            $ref_id = rand(1, 10);
            $class = rand(1,50);

            for($j = 1;$j<=2;$j++){

                DB::table('record')->insert(array(
                    'unique_record'		       =>		$uniq,
                    'classification_id'	        =>		$class,
                    'language_id'		         =>		$j,
                    'marinecenter_id'			=>		'1',
                    'collection_code'		     =>		$i,
                    'catalog_number'		      =>	$i,
                    'related_catalog_item'				=>		'PMBC-1-MOL-'.$i, //1-3
                    'source'				=>		'1', //4-6
                    'reference'				=>		'', //7-9
                    'page'				=>		'', //10-12
                    'no_species'					=>		'0', //13-15
                    'no_locality'				=>		'', //16-18
                    'related_reference_item'			=>		'',
                    'individual_count'					=>		'0',
                    'latitude'				=>		'',
                    'verbatim_latitude'			=>		'',
                    'start_latitude'			=>		'',
                    'end_latitude'				=>		'',
                    'longitude'				=>		'',
                    'verbatim_longitude'					=>		'',
                    'start_longitude'				=>		'',
                    'end_longitude'				=>		'',
                    'country'					=>		'1',
                    'province'					=>		'',
                    'district'					=>		'',
                    'county'					=>		'',
                    'locality'					=>		'',
                    'ocean_sea_lake'					=>		'',
                    'habitat'					=>		'',
                    'type_status'					=>		'',
                    'sex'					=>		'',
                    'size'					=>		'',
                    'life_stage'             =>		'',
                    'donated_from'          =>		'',
                    'deposited_at'         =>		'',
                    'gear_method'         =>		'',
                    'depth_start'         =>		'',
                    'depth_end'         =>		'',
                    'collector'         =>		'',
                    'collected_date'         =>		'',
                    'collected_year'         =>		'',
                    'collected_month'         =>		'',
                    'collected_day'         =>		'',
                    'identifier'         =>		'',
                    'identified_date'         =>		'',
                    'identified_year'         =>		'',
                    'identified_month'         =>		'',
                    'identified_day'         =>		'',
                    'previous_identifier'         =>		'',
                    'previous_identified_date'         =>		'',
                    'note_collector'         =>		'',
                    'expedition'         =>		'',
                    'preparation_type'         =>		'30',
                    'gene_bank_number'         =>		'',
                    'local_name'         =>		'',
                    'vernacular_name'         =>		'',
                    'variety_name'         =>		'',
                    'diagnosis'         =>		'',
                    'description'         =>		'',
                    'team_exploration_code'         =>		'69',
                    'area_exploration'         =>		'71',
                    'village_no'         =>		'',
                    'area_direction'         =>		'',
                    'area'         =>		'',
                    'utilization'         =>		'',
                    'folk_wisdom'         =>		'',
                    'recorder'         =>		'73',
                    'knowledge_remarks'         =>		'',
                    // 'soil_temperature'         =>		'',
                    // 'soil_character'         =>		'',
                    // 'soil_ph'         =>		'',
                    'water_temperature'         =>		'',
                    'transparency'         =>		'',
                    'water_ph'         =>		'',
                    'dissolve_oxygen'         =>		'',
                    'suspended_solid'         =>		'',
                    'salinity'         =>		'',
                    'specimen_collection'         =>		'',
                    'specimen_photograph'         =>		'',
                    // 'sighting_no'         =>		'',
                    'exploration_remark'         =>		'',
                    // 'sighting_time'         =>		'',
                    // 'food'         =>		'',
                    'water_place'         =>		'',
                    'tree_place'         =>		'',
                    'soil_earth_place'         =>		'',
                    'ground_earth_place'         =>		'',
                    'coast_place'         =>		'',
                    'solo_living'         =>		'',
                    'group_living'         =>		'',
                    'animal_type1'         =>		'',
                    'animal_type2'         =>		'',
                    'animal_type3'         =>		'',
                    'reproduction'         =>		'',
                    'plant_type'         =>       '',
                    'picture_name'         =>		'',
                    'picture_remark'         =>		'',
                    'migration_data'        =>      true,
                    'approve_status'        =>      true,
                    'approve_by'        =>      1,
                    'status'				=>		'2',
                    'created_by'			=>		'1',
                    'updated_by'			=>		'0',
                    'created_at'			=>		date('Y-m-d H:m:s'),
                    'updated_at'			=>		date('Y-m-d H:m:s'),
                ));
            }

            $uniq = $uniq+1;
        }
    }
}
