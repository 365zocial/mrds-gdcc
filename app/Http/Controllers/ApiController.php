<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Response;
use App\Model\Record;
use App\Model\Marinecenter;
use App\Model\Classification;
use App\Model\Header_Taxonomy;
use App\Model\Taxonomy;
use App\Model\Wording;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Users;
use App\Model\Picture;
use App\Model\ExportLog;

class ApiController extends Controller
{

    //Sorawit
    //Created : 29-6-59
    //Modified : -
    //Input : key, username, password, unique_record
    //Key : BUngPQucB9
    # get data for PGCP
    public function dataRecordPGCP( Request $input ) {
        // get data
        $key = $input->key;
        $username = strtolower( $input->username );
        $password = $input->password;
        $unique_record = $input->unique_record;

        // check authenticate
        if ( Auth::attempt(['name' => $username, 'password' => $password]) ) {

            // check key
            if ( $key == 'BUngPQucB9' && $unique_record != null ) {

                // query database
                $db = new Record;
                $db = $db->where('record.unique_record', $unique_record)->where('record.status', 2)->where('record.approve_status', 1);
                $db = $db->leftjoin('classification as c','record.classification_id', '=', 'c.id');
                $db = $db->leftjoin('taxonomy as t1', 'c.domain' ,'=', 't1.id');
                $db = $db->leftjoin('taxonomy as t2', 'c.kingdom' ,'=', 't2.id');
                $db = $db->leftjoin('taxonomy as t3', 'c.subkingdom' ,'=', 't3.id');
                $db = $db->leftjoin('taxonomy as t4', 'c.infrakingdom' ,'=', 't4.id');
                $db = $db->leftjoin('taxonomy as t5', 'c.phylum' ,'=', 't5.id');
                $db = $db->leftjoin('taxonomy as t6', 'c.subphylum' ,'=', 't6.id');
                $db = $db->leftjoin('taxonomy as t7', 'c.infraphylum' ,'=', 't7.id');
                $db = $db->leftjoin('taxonomy as t8', 'c.superclass' ,'=', 't8.id');
                $db = $db->leftjoin('taxonomy as t9', 'c.class' ,'=', 't9.id');
                $db = $db->leftjoin('taxonomy as t10', 'c.subclass' ,'=', 't10.id');
                $db = $db->leftjoin('taxonomy as t11', 'c.infraclass' ,'=', 't11.id');
                $db = $db->leftjoin('taxonomy as t12', 'c.superorder' ,'=', 't12.id');
                $db = $db->leftjoin('taxonomy as t13', 'c.order_o' ,'=', 't13.id');
                $db = $db->leftjoin('taxonomy as t14', 'c.suborder' ,'=', 't14.id');
                $db = $db->leftjoin('taxonomy as t15', 'c.infraorder' ,'=', 't15.id');
                $db = $db->leftjoin('taxonomy as t16', 'c.superfamily' ,'=', 't16.id');
                $db = $db->leftjoin('taxonomy as t17', 'c.family' ,'=', 't17.id');
                $db = $db->leftjoin('taxonomy as t18', 'c.subfamily' ,'=', 't18.id');
                $db = $db->leftjoin('taxonomy as t19', 'c.genus' ,'=', 't19.id');
                $db = $db->leftjoin('taxonomy as t20', 'c.subgenus' ,'=', 't20.id');
                $db = $db->leftjoin('taxonomy as t21', 'c.species' ,'=', 't21.id');
                $db = $db->leftjoin('taxonomy as t22', 'c.subspecies' ,'=', 't22.id');
                $db = $db->leftjoin('marinecenter as marinecenter', 'record.marinecenter_id' ,'=', 'marinecenter.id');
                $db = $db->leftjoin('institution as institution', 'marinecenter.institution_id' ,'=', 'marinecenter.id');
                $db = $db->leftjoin('collection as collection', 'record.collection_code' ,'=', 'collection.id');
                $db = $db->leftjoin('reference as ref', 'record.reference' ,'=', 'ref.id');
                $db = $db->leftjoin('wording as w_donated_from', 'record.donated_from' ,'=', 'w_donated_from.id');
                $db = $db->leftjoin('wording as w_deposited_at', 'record.deposited_at' ,'=', 'w_deposited_at.id');
                $db = $db->leftjoin('wording as w_iq', 'c.identification_qualifier' ,'=', 'w_iq.id');
                $db = $db->leftjoin('wording as w_type_status', 'record.type_status' ,'=', 'w_type_status.id');
                $db = $db->leftjoin('wording as w_sex', 'record.sex' ,'=', 'w_sex.id');
                $db = $db->leftjoin('wording as w_life_stage', 'record.life_stage' ,'=', 'w_life_stage.id');
                $db = $db->leftjoin('wording as w_ocean', 'record.ocean_sea_lake' ,'=', 'w_ocean.id');
                $db = $db->leftjoin('country as country', 'record.country' ,'=', 'country.id');
                $db = $db->leftjoin('province as province', 'record.province' ,'=', 'province.id');
                $db = $db->leftjoin('district as district', 'record.district' ,'=', 'district.id');
                $db = $db->leftjoin('county as county', 'record.county' ,'=', 'county.id');
                $db = $db->leftjoin('wording as w_habitat', 'record.habitat' ,'=', 'w_habitat.id');
                $db = $db->leftjoin('wording as w_gear_method', 'record.gear_method' ,'=', 'w_gear_method.id');
                $db = $db->leftjoin('wording as w_preparation_type', 'record.preparation_type' ,'=', 'w_preparation_type.id');
                $db = $db->leftjoin('wording as w_expedition', 'record.expedition' ,'=', 'w_expedition.id');
                $db = $db->leftjoin('wording as w_team_exploration_code', 'record.team_exploration_code' ,'=', 'w_team_exploration_code.id');
                $db = $db->leftjoin('wording as w_area_exploration', 'record.area_exploration' ,'=', 'w_area_exploration.id');
                $db = $db->leftjoin('wording as w_area_direction', 'record.area_direction' ,'=', 'w_area_direction.id');
                $db = $db->leftjoin('wording as w_utilization', 'record.utilization' ,'=', 'w_utilization.id');
                $db = $db->leftjoin('wording as w_recorder', 'record.recorder' ,'=', 'w_recorder.id');
                $db = $db->leftjoin('wording as w_plant_type', 'record.plant_type' ,'=', 'w_plant_type.id');
                $db = $db->leftjoin('wording as w_animal_type1', 'record.animal_type1' ,'=', 'w_animal_type1.id');
                $db = $db->leftjoin('wording as w_animal_type2', 'record.animal_type2' ,'=', 'w_animal_type2.id');
                $db = $db->leftjoin('wording as w_animal_type3', 'record.animal_type3' ,'=', 'w_animal_type3.id');
                $db = $db->leftjoin('wording as w_protection_type', 'record.protection_type' ,'=', 'w_protection_type.id');

                $data['message'] = 'Successful';
                $data['status'] = '200';
                $data['max_unique_record'] = Record::getMaxUniqueRecord();

                // english language

                    $record_en = $db->select([
                        'c.id as classification_id',
                        'c.current_scientific_name',
                        'c.current_scientific_name_format',
                        'c.previous_scientific_name',
                        'c.previous_scientific_name_format',
                        't1.name as domain',
                        't2.name as kingdom',
                        't3.name as subkingdom',
                        't4.name as infrakingdom',
                        't5.name as phylum',
                        't6.name as subphylum',
                        't7.name as infraphylum',
                        't8.name as superclass',
                        't9.name as class',
                        't10.name as subclass',
                        't11.name as infraclass',
                        't12.name as superorder',
                        't13.name as order',
                        't14.name as suborder',
                        't15.name as infraorder',
                        't16.name as superfamily',
                        't17.name as family',
                        't18.name as subfamily',
                        't19.name as genus',
                        't20.name as subgenus',
                        't21.name as species',
                        't22.name as subspecies',
                        'w_iq.name_en as identification_qualifier',
                        'c.migration_data as classification_migration_data',
                        'c.created_at as classification_created_at',
                        'c.updated_at as classification_updated_at',
                        'record.id as record_id',
                        'record.unique_record',
                        'record.language_id',
                        'institution.department',
                        'institution.institution',
                        'marinecenter.marinecenter',
                        'marinecenter.marinecenter_code',
                        'record.source',
                        'collection.name_en as collection',
                        'collection.col_code as collection_code ',
                        'record.catalog_number',
                        'record.related_catalog_item',
                        'ref.name_en as ref',
                        'ref.ref_code',
                        'record.page',
                        'record.no_species',
                        'record.no_locality',
                        'record.related_reference_item',
                        'record.individual_count',
                        'record.verbatim_latitude',
                        'record.latitude',
                        'record.start_latitude',
                        'record.end_latitude',
                        'record.verbatim_longitude',
                        'record.longitude',
                        'record.start_longitude',
                        'record.end_longitude',
                        'country.country_en',
                        'province.province_en',
                        'district.district_en',
                        'county.county_en',
                        'record.locality',
                        'w_ocean.name_en as ocean_sea_lake',
                        'w_habitat.name_en as habitat',
                        'w_type_status.name_en as type_status',
                        'w_sex.name_en as sex',
                        'record.size',
                        'w_life_stage.name_en as life_stage',
                        'w_donated_from.name_en as donated_from',
                        'w_deposited_at.name_en as deposited_at',
                        'w_gear_method.name_en as gear_method',
                        'record.depth_start',
                        'record.depth_end',
                        'record.collector',
                        'record.collected_date',
                        'record.collected_year',
                        'record.collected_month',
                        'record.collected_day',
                        'record.identifier',
                        'record.identified_date',
                        'record.identified_year',
                        'record.identified_month',
                        'record.identified_day',
                        'record.previous_identifier',
                        'record.previous_identified_date',
                        'record.note_collector',
                        'w_preparation_type.name_en as preparation_type',
                        'w_expedition.name_en as expedition',
                        'record.gene_bank_number',
                        'record.local_name',
                        'record.vernacular_name',
                        'record.common_name',
                        'record.variety_name',
                        'record.diagnosis',
                        'record.description',
                        'w_team_exploration_code.name_en as team_exploration_code',
                        'w_area_exploration.name_en as area_exploration',
                        'record.village_no',
                        'w_area_direction.name_en as area_direction',
                        'record.area',
                        'w_utilization.name_en as utilization',
                        'record.folk_wisdom',
                        'w_recorder.name_en as recorder',
                        'record.knowledge_remarks',
                        // 'record.soil_temperature',
                        // 'record.soil_character',
                        // 'record.soil_ph',
                        'record.water_temperature',
                        'record.transparency',
                        'record.water_ph',
                        'record.dissolve_oxygen',
                        'record.suspended_solid',
                        'record.salinity',
                        'record.specimen_collection',
                        'record.specimen_photograph',
                        // 'record.sighting_no',
                        'record.exploration_remark',
                        // 'record.sighting_time',
                        // 'record.food',
                        'record.water_place',
                        'record.tree_place',
                        'record.soil_earth_place',
                        'record.ground_earth_place',
                        'record.coast_place',
                        'record.solo_living',
                        'record.group_living',
                        'w_plant_type.name_en as plant_type',
                        'w_animal_type1.name_en as animal_type1',
                        'w_animal_type2.name_en as animal_type2',
                        'w_animal_type3.name_en as animal_type3',
                        'w_protection_type.name_en as protection_type',
                        'record.reproduction',
                        'record.picture_name',
                        'record.picture_remark',
                        'record.migration_data as record_migration_data',
                        'record.created_at as record_created_at',
                        'record.updated_at as record_updated_at'
                    ])->get();

                    // at to json
                    if ( sizeof($record_en) ) $data['record_en'] = $record_en;
                    else $data['record_en'] = null;

                // thai language
                    $record_th = $db->select([
                        'c.id as classification_id',
                        'c.current_scientific_name',
                        'c.current_scientific_name_format',
                        'c.previous_scientific_name',
                        'c.previous_scientific_name_format',
                        't1.name as domain',
                        't2.name as kingdom',
                        't3.name as subkingdom',
                        't4.name as infrakingdom',
                        't5.name as phylum',
                        't6.name as subphylum',
                        't7.name as infraphylum',
                        't8.name as superclass',
                        't9.name as class',
                        't10.name as subclass',
                        't11.name as infraclass',
                        't12.name as superorder',
                        't13.name as order',
                        't14.name as suborder',
                        't15.name as infraorder',
                        't16.name as superfamily',
                        't17.name as family',
                        't18.name as subfamily',
                        't19.name as genus',
                        't20.name as subgenus',
                        't21.name as species',
                        't22.name as subspecies',
                        'w_iq.name_th as identification_qualifier',
                        'c.migration_data as classification_migration_data',
                        'c.created_at as classification_created_at',
                        'c.updated_at as classification_updated_at',
                        'record.id as record_id',
                        'record.unique_record',
                        'record.language_id',
                        'institution.department',
                        'institution.institution',
                        'marinecenter.marinecenter',
                        'marinecenter.marinecenter_code',
                        'record.source',
                        'collection.name_th as collection',
                        'collection.col_code as collection_code ',
                        'record.catalog_number',
                        'record.related_catalog_item',
                        'ref.name_th as ref',
                        'ref.ref_code',
                        'record.page',
                        'record.no_species',
                        'record.no_locality',
                        'record.related_reference_item',
                        'record.individual_count',
                        'record.verbatim_latitude',
                        'record.latitude',
                        'record.start_latitude',
                        'record.end_latitude',
                        'record.verbatim_longitude',
                        'record.longitude',
                        'record.start_longitude',
                        'record.end_longitude',
                        'country.country_th',
                        'province.province_th',
                        'district.district_th',
                        'county.county_th',
                        'record.locality',
                        'w_ocean.name_th as ocean_sea_lake',
                        'w_habitat.name_th as habitat',
                        'w_type_status.name_th as type_status',
                        'w_sex.name_th as sex',
                        'record.size',
                        'w_life_stage.name_th as life_stage',
                        'w_donated_from.name_th as donated_from',
                        'w_deposited_at.name_th as deposited_at',
                        'w_gear_method.name_th as gear_method',
                        'record.depth_start',
                        'record.depth_end',
                        'record.collector',
                        'record.collected_date',
                        'record.collected_year',
                        'record.collected_month',
                        'record.collected_day',
                        'record.identifier',
                        'record.identified_date',
                        'record.identified_year',
                        'record.identified_month',
                        'record.identified_day',
                        'record.previous_identifier',
                        'record.previous_identified_date',
                        'record.note_collector',
                        'w_preparation_type.name_th as preparation_type',
                        'w_expedition.name_th as expedition',
                        'record.gene_bank_number',
                        'record.local_name',
                        'record.vernacular_name',
                        'record.common_name',
                        'record.variety_name',
                        'record.diagnosis',
                        'record.description',
                        'w_team_exploration_code.name_th as team_exploration_code',
                        'w_area_exploration.name_th as area_exploration',
                        'record.village_no',
                        'w_area_direction.name_th as area_direction',
                        'record.area',
                        'w_utilization.name_th as utilization',
                        'record.folk_wisdom',
                        'w_recorder.name_th as recorder',
                        'record.knowledge_remarks',
                        // 'record.soil_temperature',
                        // 'record.soil_character',
                        // 'record.soil_ph',
                        'record.water_temperature',
                        'record.transparency',
                        'record.water_ph',
                        'record.dissolve_oxygen',
                        'record.suspended_solid',
                        'record.salinity',
                        'record.specimen_collection',
                        'record.specimen_photograph',
                        // 'record.sighting_no',
                        'record.exploration_remark',
                        // 'record.sighting_time',
                        // 'record.food',
                        'record.water_place',
                        'record.tree_place',
                        'record.soil_earth_place',
                        'record.ground_earth_place',
                        'record.coast_place',
                        'record.solo_living',
                        'record.group_living',
                        'w_plant_type.name_th as plant_type',
                        'w_animal_type1.name_th as animal_type1',
                        'w_animal_type2.name_th as animal_type2',
                        'w_animal_type3.name_th as animal_type3',
                        'w_protection_type.name_th as protection_type',
                        'record.reproduction',
                        'record.picture_name',
                        'record.picture_remark',
                        'record.migration_data as record_migration_data',
                        'record.created_at as record_created_at',
                        'record.updated_at as record_updated_at'
                    ])->get();

                    // at to json
                    if ( sizeof($record_th) ) $data['record_th'] = $record_th;
                    else $data['record_th'] = null;

                // picture
                    $picture = Picture::select('id', 'unique_record', 'path_pic', 'caption', 'photographer', 'created_at as picture.created_at', 'updated_at as picture.updated_at')->where('unique_record', $unique_record)->get();
                    // at to json
                    if ( sizeof($picture) ) $data['picture'] = $picture;
                    else $data['picture'] = null;

            } else {
                $data['message'] = 'Error Key';
    			$data['status'] = '404';
                $data['max_unique_record'] = null;
                $data['record_en'] = null;
    			$data['record_th'] = null;
                $data['picture'] = null;
            }

        } else {
            $data['message'] = 'Error Authentication';
			$data['status'] = '404';
            $data['max_unique_record'] = null;
            $data['record_en'] = null;
			$data['record_th'] = null;
            $data['picture'] = null;
        }

        // save export log : 0 is excel, 1 is pdf, 2 is api
        $note = 'PGCP_API_'.$unique_record;
        ExportLog::saveExportLog( 2, $note );

        return Response::json($data);

    }

    //Sorawit
    //Created : 29-6-59
    //Modified : -
    //Input : key, username, password, language, start_date, end_date
    //Key : BUngPQucB9
    # get data for PGCP
    // public function dataRecordPGCP( Request $input ) {
    //     // get data
    //     $key = $input->key;
    //     $username = strtolower( $input->username );
    //     $password = $input->password;
    //     $language = $input->language;
    //     $start_date = date('Y-m-d', strtotime( $input->start_date ) );
    //     $end_date = date('Y-m-d', strtotime( $input->end_date ) );
    //
    //     // set format end time
    //     $end_time = date_create('23:59:59');
    //     $end_time = date_format( $end_time, 'H:i:s' );
    //     $end_date = date('Y-m-d H:i:s', strtotime( $end_date.' '.$end_time ));
    //
    //     // created export date
    //     $date = date_create();
	// 	   $date_export = date_format( $date, "d M, Y H:i:s" );
    //     $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );
    //
    //     // check authenticate
    //     if ( Auth::attempt(['name' => $username, 'password' => $password]) ) {
    //
    //         // check key
    //         if ( $key == 'BUngPQucB9' ) {
    //
    //             // query database
    //             $db = new Record;
    //             $db = $db->where('record.status', 2)->where('record.approve_status', 1);
    //             $db = $db->whereBetween('record.created_at', [$start_date, $end_date]);
    //             $db = $db->leftjoin('classification as c','record.classification_id', '=', 'c.id');
    //             $db = $db->leftjoin('taxonomy as t1', 'c.domain' ,'=', 't1.id');
    //             $db = $db->leftjoin('taxonomy as t2', 'c.kingdom' ,'=', 't2.id');
    //             $db = $db->leftjoin('taxonomy as t3', 'c.subkingdom' ,'=', 't3.id');
    //             $db = $db->leftjoin('taxonomy as t4', 'c.infrakingdom' ,'=', 't4.id');
    //             $db = $db->leftjoin('taxonomy as t5', 'c.phylum' ,'=', 't5.id');
    //             $db = $db->leftjoin('taxonomy as t6', 'c.subphylum' ,'=', 't6.id');
    //             $db = $db->leftjoin('taxonomy as t7', 'c.infraphylum' ,'=', 't7.id');
    //             $db = $db->leftjoin('taxonomy as t8', 'c.superclass' ,'=', 't8.id');
    //             $db = $db->leftjoin('taxonomy as t9', 'c.class' ,'=', 't9.id');
    //             $db = $db->leftjoin('taxonomy as t10', 'c.subclass' ,'=', 't10.id');
    //             $db = $db->leftjoin('taxonomy as t11', 'c.infraclass' ,'=', 't11.id');
    //             $db = $db->leftjoin('taxonomy as t12', 'c.superorder' ,'=', 't12.id');
    //             $db = $db->leftjoin('taxonomy as t13', 'c.order_o' ,'=', 't13.id');
    //             $db = $db->leftjoin('taxonomy as t14', 'c.suborder' ,'=', 't14.id');
    //             $db = $db->leftjoin('taxonomy as t15', 'c.infraorder' ,'=', 't15.id');
    //             $db = $db->leftjoin('taxonomy as t16', 'c.superfamily' ,'=', 't16.id');
    //             $db = $db->leftjoin('taxonomy as t17', 'c.family' ,'=', 't17.id');
    //             $db = $db->leftjoin('taxonomy as t18', 'c.subfamily' ,'=', 't18.id');
    //             $db = $db->leftjoin('taxonomy as t19', 'c.genus' ,'=', 't19.id');
    //             $db = $db->leftjoin('taxonomy as t20', 'c.subgenus' ,'=', 't20.id');
    //             $db = $db->leftjoin('taxonomy as t21', 'c.species' ,'=', 't21.id');
    //             $db = $db->leftjoin('taxonomy as t22', 'c.subspecies' ,'=', 't22.id');
    //             $db = $db->leftjoin('marinecenter as marinecenter', 'record.marinecenter_id' ,'=', 'marinecenter.id');
    //             $db = $db->leftjoin('institution as institution', 'marinecenter.institution_id' ,'=', 'marinecenter.id');
    //             $db = $db->leftjoin('collection as collection', 'record.collection_code' ,'=', 'collection.id');
    //             $db = $db->leftjoin('reference as ref', 'record.reference' ,'=', 'ref.id');
    //             $db = $db->leftjoin('wording as w_donated_from', 'record.donated_from' ,'=', 'w_donated_from.id');
    //             $db = $db->leftjoin('wording as w_deposited_at', 'record.deposited_at' ,'=', 'w_deposited_at.id');
    //             $db = $db->leftjoin('wording as w_iq', 'c.identification_qualifier' ,'=', 'w_iq.id');
    //             $db = $db->leftjoin('wording as w_type_status', 'record.type_status' ,'=', 'w_type_status.id');
    //             $db = $db->leftjoin('wording as w_sex', 'record.sex' ,'=', 'w_sex.id');
    //             $db = $db->leftjoin('wording as w_life_stage', 'record.life_stage' ,'=', 'w_life_stage.id');
    //             $db = $db->leftjoin('wording as w_ocean', 'record.ocean_sea_lake' ,'=', 'w_ocean.id');
    //             $db = $db->leftjoin('country as country', 'record.country' ,'=', 'country.id');
    //             $db = $db->leftjoin('province as province', 'record.province' ,'=', 'province.id');
    //             $db = $db->leftjoin('district as district', 'record.district' ,'=', 'district.id');
    //             $db = $db->leftjoin('county as county', 'record.county' ,'=', 'county.id');
    //             $db = $db->leftjoin('wording as w_habitat', 'record.habitat' ,'=', 'w_habitat.id');
    //             $db = $db->leftjoin('wording as w_gear_method', 'record.gear_method' ,'=', 'w_gear_method.id');
    //             $db = $db->leftjoin('wording as w_preparation_type', 'record.preparation_type' ,'=', 'w_preparation_type.id');
    //             $db = $db->leftjoin('wording as w_expedition', 'record.expedition' ,'=', 'w_expedition.id');
    //             $db = $db->leftjoin('wording as w_team_exploration_code', 'record.team_exploration_code' ,'=', 'w_team_exploration_code.id');
    //             $db = $db->leftjoin('wording as w_area_exploration', 'record.area_exploration' ,'=', 'w_area_exploration.id');
    //             $db = $db->leftjoin('wording as w_area_direction', 'record.area_direction' ,'=', 'w_area_direction.id');
    //             $db = $db->leftjoin('wording as w_utilization', 'record.utilization' ,'=', 'w_utilization.id');
    //             $db = $db->leftjoin('wording as w_recorder', 'record.recorder' ,'=', 'w_recorder.id');
    //             $db = $db->leftjoin('wording as w_plant_type', 'record.plant_type' ,'=', 'w_plant_type.id');
    //             $db = $db->leftjoin('wording as w_animal_type1', 'record.animal_type1' ,'=', 'w_animal_type1.id');
    //             $db = $db->leftjoin('wording as w_animal_type2', 'record.animal_type2' ,'=', 'w_animal_type2.id');
    //             $db = $db->leftjoin('wording as w_animal_type3', 'record.animal_type3' ,'=', 'w_animal_type3.id');
    //             $db = $db->leftjoin('wording as w_protection_type', 'record.protection_type' ,'=', 'w_protection_type.id');
    //             $db = $db->leftjoin('view_picture as pic', 'record.unique_record' ,'=', 'pic.unique_record');
    //
    //             // english language
    //             if ( $language == 1 ) {
    //                 $db = $db->where('record.language_id', 1);
    //                 $results = $db->select([
    //                     'c.id as c.classification_id',
    //                     'c.current_scientific_name',
    //                     'c.current_scientific_name_format',
    //                     'c.previous_scientific_name',
    //                     'c.previous_scientific_name_format',
    //                     't1.name as domain',
    //                     't2.name as kingdom',
    //                     't3.name as subkingdom',
    //                     't4.name as infrakingdom',
    //                     't5.name as phylum',
    //                     't6.name as subphylum',
    //                     't7.name as infraphylum',
    //                     't8.name as superclass',
    //                     't9.name as class',
    //                     't10.name as subclass',
    //                     't11.name as infraclass',
    //                     't12.name as superorder',
    //                     't13.name as order',
    //                     't14.name as suborder',
    //                     't15.name as infraorder',
    //                     't16.name as superfamily',
    //                     't17.name as family',
    //                     't18.name as subfamily',
    //                     't19.name as genus',
    //                     't20.name as subgenus',
    //                     't21.name as species',
    //                     't22.name as subspecies',
    //                     'w_iq.name_en as identification_qualifier',
    //                     'c.migration_data as classification_migration_data',
    //                     'c.created_at as classification_created_at',
    //                     'c.updated_at as classification_updated_at',
    //                     'record.id as record_id',
    //                     'record.unique_record',
    //                     'record.language_id',
    //                     'institution.department',
    //                     'institution.institution',
    //                     'marinecenter.marinecenter',
    //                     'marinecenter.marinecenter_code',
    //                     'record.source',
    //                     'collection.name_en as collection',
    //                     'collection.col_code as collection_code ',
    //                     'record.catalog_number',
    //                     'record.related_catalog_item',
    //                     'ref.name_en as ref',
    //                     'ref.ref_code',
    //                     'record.page',
    //                     'record.no_species',
    //                     'record.no_locality',
    //                     'record.related_reference_item',
    //                     'record.individual_count',
    //                     'record.verbatim_latitude',
    //                     'record.latitude',
    //                     'record.start_latitude',
    //                     'record.end_latitude',
    //                     'record.verbatim_longitude',
    //                     'record.longitude',
    //                     'record.start_longitude',
    //                     'record.end_longitude',
    //                     'country.country_en',
    //                     'province.province_en',
    //                     'district.district_en',
    //                     'county.county_en',
    //                     'record.locality',
    //                     'w_ocean.name_en as ocean_sea_lake',
    //                     'w_habitat.name_en as habitat',
    //                     'w_type_status.name_en as type_status',
    //                     'w_sex.name_en as sex',
    //                     'record.size',
    //                     'w_life_stage.name_en as life_stage',
    //                     'w_donated_from.name_en as donated_from',
    //                     'w_deposited_at.name_en as deposited_at',
    //                     'w_gear_method.name_en as gear_method',
    //                     'record.depth_start',
    //                     'record.depth_end',
    //                     'record.collector',
    //                     'record.collected_date',
    //                     'record.collected_year',
    //                     'record.collected_month',
    //                     'record.collected_day',
    //                     'record.identifier',
    //                     'record.identified_date',
    //                     'record.identified_year',
    //                     'record.identified_month',
    //                     'record.identified_day',
    //                     'record.previous_identifier',
    //                     'record.previous_identified_date',
    //                     'record.note_collector',
    //                     'w_preparation_type.name_en as preparation_type',
    //                     'w_expedition.name_en as expedition',
    //                     'record.gene_bank_number',
    //                     'record.local_name',
    //                     'record.vernacular_name',
    //                     'record.common_name',
    //                     'record.variety_name',
    //                     'record.diagnosis',
    //                     'record.description',
    //                     'w_team_exploration_code.name_en as team_exploration_code',
    //                     'w_area_exploration.name_en as area_exploration',
    //                     'record.village_no',
    //                     'w_area_direction.name_en as area_direction',
    //                     'record.area',
    //                     'w_utilization.name_en as utilization',
    //                     'record.folk_wisdom',
    //                     'w_recorder.name_en as recorder',
    //                     'record.knowledge_remarks',
    //                     'record.soil_temperature',
    //                     'record.soil_character',
    //                     'record.soil_ph',
    //                     'record.water_temperature',
    //                     'record.transparency',
    //                     'record.water_ph',
    //                     'record.dissolve_oxygen',
    //                     'record.suspended_solid',
    //                     'record.salinity',
    //                     'record.specimen_collection',
    //                     'record.specimen_photograph',
    //                     'record.sighting_no',
    //                     'record.exploration_remark',
    //                     'record.sighting_time',
    //                     'record.food',
    //                     'record.water_place',
    //                     'record.tree_place',
    //                     'record.soil_earth_place',
    //                     'record.ground_earth_place',
    //                     'record.coast_place',
    //                     'record.solo_living',
    //                     'record.group_living',
    //                     'w_plant_type.name_en as plant_type',
    //                     'w_animal_type1.name_en as animal_type1',
    //                     'w_animal_type2.name_en as animal_type2',
    //                     'w_animal_type3.name_en as animal_type3',
    //                     'w_protection_type.name_en as protection_type',
    //                     'record.reproduction',
    //                     'record.picture_name',
    //                     'record.picture_remark',
    //                     'pic.path_pic1',
    //                     'pic.caption1',
    //                     'pic.photographer1',
    //                     'pic.path_pic2',
    //                     'pic.caption2',
    //                     'pic.photographer2',
    //                     'pic.path_pic3',
    //                     'pic.caption3',
    //                     'pic.photographer3',
    //                     'pic.path_pic4',
    //                     'pic.caption4',
    //                     'pic.photographer4',
    //                     'pic.path_pic5',
    //                     'pic.caption5',
    //                     'pic.photographer5',
    //                     'pic.path_pic6',
    //                     'pic.caption6',
    //                     'pic.photographer6',
    //                     'record.migration_data as record_migration_data',
    //                     'record.created_at as record_created_at',
    //                     'record.updated_at as record_updated_at'
    //                 ])->get();
    //                 $data['message'] = 'Successful';
    //                 $data['status'] = '200';
    //                 if ( sizeof($results) ) $data['data'] = $results;
    //                 else $data['data'] = null;
    //             }
    //             // thai language
    //             elseif ( $language == 2 ) {
    //                 $db = $db->where('record.language_id', 2);
    //                 $results = $db->select([
    //                     'c.id as c.classification_id',
    //                     'c.current_scientific_name',
    //                     'c.current_scientific_name_format',
    //                     'c.previous_scientific_name',
    //                     'c.previous_scientific_name_format',
    //                     't1.name as domain',
    //                     't2.name as kingdom',
    //                     't3.name as subkingdom',
    //                     't4.name as infrakingdom',
    //                     't5.name as phylum',
    //                     't6.name as subphylum',
    //                     't7.name as infraphylum',
    //                     't8.name as superclass',
    //                     't9.name as class',
    //                     't10.name as subclass',
    //                     't11.name as infraclass',
    //                     't12.name as superorder',
    //                     't13.name as order',
    //                     't14.name as suborder',
    //                     't15.name as infraorder',
    //                     't16.name as superfamily',
    //                     't17.name as family',
    //                     't18.name as subfamily',
    //                     't19.name as genus',
    //                     't20.name as subgenus',
    //                     't21.name as species',
    //                     't22.name as subspecies',
    //                     'w_iq.name_th as identification_qualifier',
    //                     'c.migration_data as classification_migration_data',
    //                     'c.created_at as classification_created_at',
    //                     'c.updated_at as classification_updated_at',
    //                     'record.id as record_id',
    //                     'record.unique_record',
    //                     'record.language_id',
    //                     'institution.department',
    //                     'institution.institution',
    //                     'marinecenter.marinecenter',
    //                     'marinecenter.marinecenter_code',
    //                     'record.source',
    //                     'collection.name_th as collection',
    //                     'collection.col_code as collection_code ',
    //                     'record.catalog_number',
    //                     'record.related_catalog_item',
    //                     'ref.name_th as ref',
    //                     'ref.ref_code',
    //                     'record.page',
    //                     'record.no_species',
    //                     'record.no_locality',
    //                     'record.related_reference_item',
    //                     'record.individual_count',
    //                     'record.verbatim_latitude',
    //                     'record.latitude',
    //                     'record.start_latitude',
    //                     'record.end_latitude',
    //                     'record.verbatim_longitude',
    //                     'record.longitude',
    //                     'record.start_longitude',
    //                     'record.end_longitude',
    //                     'country.country_th',
    //                     'province.province_th',
    //                     'district.district_th',
    //                     'county.county_th',
    //                     'record.locality',
    //                     'w_ocean.name_th as ocean_sea_lake',
    //                     'w_habitat.name_th as habitat',
    //                     'w_type_status.name_th as type_status',
    //                     'w_sex.name_th as sex',
    //                     'record.size',
    //                     'w_life_stage.name_th as life_stage',
    //                     'w_donated_from.name_th as donated_from',
    //                     'w_deposited_at.name_th as deposited_at',
    //                     'w_gear_method.name_th as gear_method',
    //                     'record.depth_start',
    //                     'record.depth_end',
    //                     'record.collector',
    //                     'record.collected_date',
    //                     'record.collected_year',
    //                     'record.collected_month',
    //                     'record.collected_day',
    //                     'record.identifier',
    //                     'record.identified_date',
    //                     'record.identified_year',
    //                     'record.identified_month',
    //                     'record.identified_day',
    //                     'record.previous_identifier',
    //                     'record.previous_identified_date',
    //                     'record.note_collector',
    //                     'w_preparation_type.name_th as preparation_type',
    //                     'w_expedition.name_th as expedition',
    //                     'record.gene_bank_number',
    //                     'record.local_name',
    //                     'record.vernacular_name',
    //                     'record.common_name',
    //                     'record.variety_name',
    //                     'record.diagnosis',
    //                     'record.description',
    //                     'w_team_exploration_code.name_th as team_exploration_code',
    //                     'w_area_exploration.name_th as area_exploration',
    //                     'record.village_no',
    //                     'w_area_direction.name_th as area_direction',
    //                     'record.area',
    //                     'w_utilization.name_th as utilization',
    //                     'record.folk_wisdom',
    //                     'w_recorder.name_th as recorder',
    //                     'record.knowledge_remarks',
    //                     'record.soil_temperature',
    //                     'record.soil_character',
    //                     'record.soil_ph',
    //                     'record.water_temperature',
    //                     'record.transparency',
    //                     'record.water_ph',
    //                     'record.dissolve_oxygen',
    //                     'record.suspended_solid',
    //                     'record.salinity',
    //                     'record.specimen_collection',
    //                     'record.specimen_photograph',
    //                     'record.sighting_no',
    //                     'record.exploration_remark',
    //                     'record.sighting_time',
    //                     'record.food',
    //                     'record.water_place',
    //                     'record.tree_place',
    //                     'record.soil_earth_place',
    //                     'record.ground_earth_place',
    //                     'record.coast_place',
    //                     'record.solo_living',
    //                     'record.group_living',
    //                     'w_plant_type.name_th as plant_type',
    //                     'w_animal_type1.name_th as animal_type1',
    //                     'w_animal_type2.name_th as animal_type2',
    //                     'w_animal_type3.name_th as animal_type3',
    //                     'w_protection_type.name_th as protection_type',
    //                     'record.reproduction',
    //                     'record.picture_name',
    //                     'record.picture_remark',
    //                     'pic.path_pic1',
    //                     'pic.caption1',
    //                     'pic.photographer1',
    //                     'pic.path_pic2',
    //                     'pic.caption2',
    //                     'pic.photographer2',
    //                     'pic.path_pic3',
    //                     'pic.caption3',
    //                     'pic.photographer3',
    //                     'pic.path_pic4',
    //                     'pic.caption4',
    //                     'pic.photographer4',
    //                     'pic.path_pic5',
    //                     'pic.caption5',
    //                     'pic.photographer5',
    //                     'pic.path_pic6',
    //                     'pic.caption6',
    //                     'pic.photographer6',
    //                     'record.migration_data as record_migration_data',
    //                     'record.created_at as record_created_at',
    //                     'record.updated_at as record_updated_at'
    //                 ])->get();
    //                 $data['message'] = 'Successful';
    //                 $data['status'] = '200';
    //                 if ( sizeof($results) ) $data['data'] = $results;
    //                 else $data['data'] = null;
    //             }
    //             else {
    //                 $data['message'] = 'Error Language';
    //     			$data['status'] = '404';
    //     			$data['data'] = null;
    //             }
    //         } else {
    //             $data['message'] = 'Error Key';
    // 			$data['status'] = '404';
    // 			$data['data'] = null;
    //         }
    //
    //     } else {
    //         $data['message'] = 'Error Authentication';
	// 		$data['status'] = '404';
	// 		$data['data'] = null;
    //     }
    //
    //     // save export log : 0 is excel, 1 is pdf, 2 is api
    //     if ( $language == 1 ) $language_name = 'en';
    //     else $language_name = 'th';
    //     $end_date = date('Y-m-d', strtotime( $end_date ) );
    //     $note = 'PGCP_API_'.$language_name.'_'.$start_date.'_'.$end_date;
    //     ExportLog::saveExportLog( 2, $note );
    //
    //     return Response::json($data);
    //
    // }
}
