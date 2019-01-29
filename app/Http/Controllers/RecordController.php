<?php

/*********************************************
    Project:	MRDS
    Developer:	Sorawit
    fucntion:	Add Classification 7/3/2016
*********************************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Hash;
use Redirect;
use Session;
// use Input;
use Auth;

use Storage;
use App\Model\Users;
use App\Model\Classification;
use App\Model\Taxonomy;
use App\Model\Marinecenter;
use App\Model\RecordUtilization;
use App\Model\RecordPlace;
use App\Model\Record;
use App\Model\Language;
use App\Model\Wording;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Picture;
use App\Model\Collection;
use App\Model\Reference;
use App\Model\CatchException;
use App\Model\System_Log;
use App\Model\AllMean;
use App\Model\Extra_Field;
use App\Model\Extra_Info;
use Yajra\Datatables\Datatables;

class RecordController extends Controller
{
	/**
	* Show the profile for the given user.
	*
	* @param  int  $id
	* @return Response
	*/

	//Sorawit
	//Created : 7-3-59
	//Modified : 2-8-59(Sorawit)
	# form add record english
	public function addRecordForm() {
		if ( Session::has('classification_id_form_add') ) {
			$classification_id 			= 	Session::get('classification_id_form_add');
			$data['marinecenter'] 		= 	Marinecenter::getMarineCenter(Auth::user()->marinecenter_id)->marinecenter_code;
			$data['marinecenter_list'] = Marinecenter::getMarineCenterList();
			$data['classification'] 	= 	Classification::getClassification($classification_id);

			// get taxonomy wording
			$arr_taxonomy_id 			=	[$data['classification']->domain,
												$data['classification']->kingdom,
												$data['classification']->subkingdom,
												$data['classification']->infrakingdom,
												$data['classification']->phylum,
												$data['classification']->subphylum,
												$data['classification']->infraphylum,
												$data['classification']->superclass,
												$data['classification']->class,
												$data['classification']->subclass,
												$data['classification']->infraclass,
												$data['classification']->superorder,
												$data['classification']->order,
												$data['classification']->suborder,
												$data['classification']->infraorder,
												$data['classification']->superfamily,
												$data['classification']->family,
												$data['classification']->subfamily,
												$data['classification']->genus,
												$data['classification']->subgenus,
												$data['classification']->species,
												$data['classification']->subspecies];

			$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

			$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
			if(is_null($data['iq'])){
				$data['iq'] = null;
			}else{
				$data['iq'] = $data['iq']->name_en;
			}

			//get value for dropdown
			$data['collection_codes'] = Collection::getCollection();
			$data['references'] = Reference::getReference();
			$data['donated_froms'] = Wording::getWordingByWordingTypeForForm(10);
			$data['deposited_ats'] = Wording::getWordingByWordingTypeForForm(11);
			$data['type_statuses'] = Wording::getWordingByWordingTypeForForm(2);
			$data['sexs'] = Wording::getWordingByWordingTypeForForm(5);
			$data['life_stages'] = Wording::getWordingByWordingTypeForForm(9);
			$data['ocean_sea_lakes'] = Wording::getWordingByWordingTypeForForm(3);
			$data['sediment_types'] = Wording::getWordingByWordingTypeForForm(25);
			$data['countries'] = Country::getCountryListForFormEN();
			$data['provinces'] = Province::getProvinceListForFormEN();
			$data['districts'] = District::getDistrictListForFormEN();
			$data['counties'] = County::getCountyListForFormEN();
			$data['habitats'] = Wording::getWordingByWordingTypeForForm(8);
			$data['gear_methods'] = Wording::getWordingByWordingTypeForForm(4);
			$data['preparation_types'] = Wording::getWordingByWordingTypeForForm(7);
			$data['expeditions'] = Wording::getWordingByWordingTypeForForm(6);

			//get last catalog_number
			$data['catalog_number_max'] = $this->CreateNewCatalog(Auth::user()->marinecenter_id);

			// get extra field
			$data['extra_fields'] = Extra_Field::getExtraFieldNameList();

			return view('staff.record.add.add_record_form_en', $data);
		} else {
			return redirect('staff/checkClassificationForm');
		}
	}

	//Sorawit
	//Created : 7-3-59
	//Modified : 2-8-59(Sorawit)
	# do add record english in database
	public function doAddRecord(Request $input) {
		//get input and set value
		$classification_id = $input->classification_id;
		$marinecenter_id = Auth::user()->marinecenter_id;
		$collection_code = $input->collection_code;
		$source = $input->source;	//1 is specimens, 2 is publication

		//check specimen for get input and set value
		if( $source == 1 ) {
			$catalog_number = $input->catalog_number;
			//check catalog number in database
		}

		//check publication for get input and set value
		if( $source == 2 ) {
			$reference = $input->reference;
			$page = $input->page;
			$no_species = $input->no_species;

			//set no_locality
			$no_locality = Record::getLastNoLocality($marinecenter_id, $collection_code, $reference, $page, $no_species);
			if($no_locality == null){
				$no_locality = 1;
			}else{
				$no_locality = $no_locality->no_locality + 1;
			}
		}

		//get input and set value
		$variety_name = $input->variety_name;
		$donated_from = $input->donated_from;
		$deposited_at = $input->deposited_at;
		$type_status = $input->type_status;
		$individual_count = $input->individual_count;
		$sex = $input->sex;
		$size = $input->size;
		$life_stage = $input->life_stage;
		$ocean_sea_lake = $input->ocean_sea_lake;
		$islands_island = $input->islands_island;
		$country = $input->country;
		$province = $input->province;
		$district = $input->district;
		$county = $input->county;
		$locality = $input->locality;
		$verbatim_lat = $input->verbatim_lat;
		$verbatim_long = $input->verbatim_long;
		$lat = $input->lat;
		$long = $input->long;
		$start_lat = $input->start_lat;
		$end_lat = $input->end_lat;
		$start_long = $input->start_long;
		$end_long = $input->end_long;
		$habitat = $input->habitat;
		$sediment_type = $input->sediment_type;

		// 1 foot = 0.3048 m.
		if( $input->depth_unit == 2)
			$depth = $input->depth * 0.3048;
		else
			$depth = $input->depth;
		if( $input->depth_end_unit == 2 )
			$depth_end = $input->depth_end * 0.3048;
		else
			$depth_end = $input->depth_end;

		//get input and set value
		$collector = $input->collector;
		if ( $input->collected_date == null ) $input->collected_date = '0000-00-00';
		$collected_date = date('Y-m-d', strtotime($input->collected_date));
		$collected_year = date("Y", strtotime($collected_date));;
		$collected_month = date("m", strtotime($collected_date));;
		$collected_day = date("d", strtotime($collected_date));;
		$identifier = $input->cur_identifier;
		if ( $input->cur_identified_date == null ) $input->cur_identified_date = '0000-00-00';
		$identified_date = date('Y-m-d', strtotime($input->cur_identified_date));
		$identified_year = date("Y", strtotime($identified_date));;
		$identified_month = date("m", strtotime($identified_date));;
		$identified_day = date("d", strtotime($identified_date));;
		$prev_identifier = $input->prev_identifier;
		if ( $input->prev_identified_date == null ) $input->prev_identified_date = '0000-00-00';
		$prev_identified_date = date('Y-m-d', strtotime($input->prev_identified_date));
		$gear_method = $input->gear_method;
		$preparation_type = $input->preparation_type;
		$expedition = $input->expedition;
		$gene_bank_number = $input->gene_bank_number;
		$diagnosis = $input->diagnosis;
		$description = $input->description;
		$note_collector = $input->note_collector;

		$marinecenter_code = Marinecenter::getMarineCenterCode($marinecenter_id);
		$collection_code_string = Collection::getCollectionByID($collection_code)->col_code;

		if( $source == 1 ) {
			$related_catalog_item = $this->CreateRelatedCatalog($source, $marinecenter_code, $collection_code_string, $catalog_number);

		} else{
			$related_reference_item = $this->CreateRelatedReference($source, $marinecenter_code, $collection_code_string, $reference, $page, $no_species, $no_locality );
		}

		//----- find last unique_record
			$unique_records = Record::getLastUniqueRecord();

			if(is_null($unique_records)){
				$unique_record = 1;
			}else{
				$unique_record = $unique_records->unique_record+1;
			}
		//-----

		$languages = Language::getLanguage();

		//-----save in database
			$record_id = array();
			$i = 0;
			foreach ( $languages as $language ) {
				$db = new Record;
				$db->unique_record 				= $unique_record;
				$db->classification_id 			= $classification_id;
				$db->language_id 				= $language->id;
				$db->marinecenter_id 			= $marinecenter_id;
				$db->collection_code 			= $collection_code;
				$db->source 					= $source;
				if( $source == 1 ) {
					$db->catalog_number 			= $catalog_number;
					$db->related_catalog_item 		= $related_catalog_item;
				} else {
					$db->reference 					= $reference;
					$db->page 						= $page;
					$db->no_species 				= $no_species;
					$db->no_locality 				= $no_locality;
					$db->related_reference_item 	= $related_reference_item;
				}
				$db->variety_name					= $variety_name;
				$db->individual_count				= $individual_count;
				$db->latitude						= $lat;
				$db->verbatim_latitude				= $verbatim_lat;
				$db->start_latitude					= $start_lat;
				$db->end_latitude					= $end_lat;
				$db->longitude						= $long;
				$db->verbatim_longitude				= $verbatim_long;
				$db->start_longitude				= $start_long;
				$db->end_longitude					= $end_long;
				$db->country						= $country;
				$db->province						= $province;
				$db->district						= $district;
				$db->county						 	= $county;
				$db->locality						= $locality;
				$db->ocean_sea_lake					= $ocean_sea_lake;
				$db->islands_island					= $islands_island;
				$db->habitat						= $habitat;
				$db->sediment_type					= $sediment_type;
				$db->type_status					= $type_status;
				$db->sex						 	= $sex;
				$db->size						 	= $size;
				$db->life_stage						= $life_stage;
				$db->donated_from					= $donated_from;
				$db->deposited_at					= $deposited_at;
				$db->gear_method					= $gear_method;
				$db->depth_start					= $depth;
				$db->depth_end						= $depth_end;
				$db->collector						= $collector;
				$db->collected_date					= $collected_date;
				$db->collected_year					= $collected_year;
				$db->collected_month				= $collected_month;
				$db->collected_day					= $collected_day;
				$db->identifier						= $identifier;
				$db->identified_date				= $identified_date;
				$db->identified_year				= $identified_year;
				$db->identified_month				= $identified_month;
				$db->identified_day					= $identified_day;
				$db->previous_identifier			= $prev_identifier;
				$db->previous_identified_date		= $prev_identified_date;
				$db->note_collector					= $note_collector;
				$db->expedition						= $expedition;
				$db->preparation_type				= $preparation_type;
				$db->gene_bank_number				= $gene_bank_number;
				$db->description					= $description;
				$db->diagnosis						= $diagnosis;
				$db->migration_data					= false;
				$db->approve_status					= false;
				$db->status						 	= 2;
				$db->created_by						= Auth::user()->id;
				$db->updated_by						= Auth::user()->id;

				$lastId = CatchException::catcherAdd($db);

				//log setting
				if ( $lastId ) {
					System_Log::Loging(
						'record', // table_name
						$lastId, // row_id
						AllMean::defineAdd(),  // action
						"", // old_data
						Record::getRecord($lastId)->toArray()// new_data
					);
				} else {
					$action = AllMean::defineAddAlertFail();
					Session::put('action', $action);
		        	return redirect('staff/checkClassificationForm');
				}

				$record_id[$i] = $lastId;
				$i++;
			}

			// add extra information
			Extra_Info::addExtraInfo($input->extra_info, $unique_record);

		//-----

		//get id from language
		$record_id_add_en = $record_id[0];	//english
		Session::put('record_id_add_en', $record_id_add_en);
		$record_id_add_th = $record_id[1];	//thai
		Session::put('record_id_add_th', $record_id_add_th);

		return redirect('staff/addRecordFormTH');
	}

	//Sorawit
	//Created : 23-3-59
	//Modified : 1-6-59
	# form add record thailand
	public function addRecordFormTH() {

		if ( Session::has('record_id_add_en') && Session::has('record_id_add_th') ) {
			$record_id_add_th = Session::get('record_id_add_th');
			$record = Record::getRecordTH($record_id_add_th);

			$data['team_exploration_codes'] = Wording::getWordingByWordingTypeForForm(15);
			$data['area_explorations'] = Wording::getWordingByWordingTypeForForm(16);
			$data['area_directions'] = Wording::getWordingByWordingTypeForForm(13);
			$data['utilizations'] = Wording::getWordingByWordingTypeForForm(14);
			// $data['recorders'] = Wording::getWordingByWordingTypeForForm(17);
			$data['animal_type1s'] 		= Wording::getWordingByWordingTypeForForm(18);
			$data['animal_type2s'] 		= Wording::getWordingByWordingTypeForForm(19);
			$data['animal_type3s'] 		= Wording::getWordingByWordingTypeForForm(20);
			$data['plant_types'] 		= Wording::getWordingByWordingTypeForForm(21);
			$data['economic_values'] 		= Wording::getWordingByWordingTypeForForm(24);

			$data['record'] = $record;

			$data['classification'] = Classification::getClassification($record->classification_id);
			$data['marinecenter'] = Marinecenter::getMarineCenter($record->marinecenter_id)->marinecenter_code;

			// get taxonomy wording
			$arr_taxonomy_id 			=	[$data['classification']->domain,
												$data['classification']->kingdom,
												$data['classification']->subkingdom,
												$data['classification']->infrakingdom,
												$data['classification']->phylum,
												$data['classification']->subphylum,
												$data['classification']->infraphylum,
												$data['classification']->superclass,
												$data['classification']->class,
												$data['classification']->subclass,
												$data['classification']->infraclass,
												$data['classification']->superorder,
												$data['classification']->order,
												$data['classification']->suborder,
												$data['classification']->infraorder,
												$data['classification']->superfamily,
												$data['classification']->family,
												$data['classification']->subfamily,
												$data['classification']->genus,
												$data['classification']->subgenus,
												$data['classification']->species,
												$data['classification']->subspecies];
			$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

			$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
			if(is_null($data['iq'])){
				$data['iq'] = null;
			}else{
				$data['iq'] = $data['iq']->name_en;
			}

			return view('staff.record.add.add_record_form_th', $data);
		} else {
			return redirect('staff/checkClassificationForm');
		}

	}

	//Sorawit
	//Created : 24-3-59
	//Modified : 1-6-59
	# do add record thailand in database
	public function doAddRecordTH(Request $input) {
		// get session
		$record_id_add_th = Session::get('record_id_add_th');

		// get value
		$record_th 						= Record::getRecordTH($record_id_add_th);
		$marinecenter_code				= Marinecenter::getMarineCenterCode($record_th->marinecenter_id);
		$source 						= $record_th->source;
		$col_code						= Collection::getCollectionByID($record_th->collection_code)->col_code;

		// getinput
		$variety_name 					= $input->variety_name;
		$size 							= $input->size;
		$islands_island 				= $input->islands_island;
		$locality						= $input->locality;
		$gene_bank_number				= $input->gene_bank_number;
		$description					= $input->description;
		$diagnosis						= $input->diagnosis;
		$local_name 					= $input->local_name;
		$vernacular_name 				= $input->vernacular_name;
		$team_exploration_code			= $input->team_exploration_code;
		$area_exploration 				= $input->area_exploration;
		$village_no 					= $input->village_no;
		$area_direction 				= $input->area_direction;
		$area 							= $input->area;
		$utilization 					= $input->utilization;
		$recorder 						= $input->recorder;
		$folk_wisdom 					= $input->folk_wisdom;
		$knowledge_remarks 				= $input->knowledge_remarks;
		$water_temperature 				= $input->water_temperature;
		$transparency 					= $input->transparency;
		$water_ph 						= $input->water_ph;
		$dissolve_oxygen 				= $input->dissolve_oxygen;
		$suspended_solid 				= $input->suspended_solid;
		$salinity 						= $input->salinity;
		$specimen_collection 			= $input->specimen_collection;
		$specimen_photograph 			= $input->specimen_photograph;
		// $water_place 					= $input->water_place;
		// $tree_place 					= $input->tree_place;
		// $soil_earth_place 				= $input->soil_earth_place;
		// $ground_earth_place 			= $input->ground_earth_place;
		// $coast_place 					= $input->coast_place;
		$place							= $input->place;
		$plant_type 					= $input->plant_type;
		$economic_value 				= $input->economic_value;
		$animal_type1 					= $input->animal_type1;
		$animal_type2 					= $input->animal_type2;
		$animal_type3 					= $input->animal_type3;

		$reproduction  					= "";
		if($input->sexual == null && $input->asexual == null){
			$reproduction	=	"0";
		}else if($input->sexual != null && $input->asexual == null){
			$reproduction	=	"1";
		}else if($input->sexual == null && $input->asexual != null){
			$reproduction	=	"2";
		}else if($input->sexual != null && $input->asexual != null){
			$reproduction	=	"3";
		}

		//-----update in database (thai)
			$db 							= Record::find($record_id_add_th);
			$db->locality					= $locality;
			$db->size 						= $size;
			$db->islands_island				= $islands_island;
			$db->gene_bank_number			= $gene_bank_number;
			$db->description				= $description;
			$db->diagnosis					= $diagnosis;
			$db->local_name 				= $local_name;
			$db->vernacular_name 			= $vernacular_name;
			$db->variety_name 				= $variety_name;
			$db->team_exploration_code 		= $team_exploration_code;
			$db->area_exploration 			= $area_exploration;
			$db->village_no 				= $village_no;
			$db->area_direction 			= $area_direction;
			$db->area 						= $area;
			// $db->utilization 				= $utilization;
			$db->recorder 					= $recorder;
			$db->folk_wisdom 				= $folk_wisdom;
			$db->knowledge_remarks 			= $knowledge_remarks;
			$db->water_temperature 			= $water_temperature;
			$db->transparency 				= $transparency;
			$db->water_ph 					= $water_ph;
			$db->dissolve_oxygen 			= $dissolve_oxygen;
			$db->suspended_solid 			= $suspended_solid;
			$db->salinity 					= $salinity;
			$db->specimen_collection 		= $specimen_collection;
			$db->specimen_photograph 		= $specimen_photograph;
			// $db->water_place 				= $water_place;
			// $db->tree_place 				= $tree_place;
			// $db->soil_earth_place 			= $soil_earth_place;
			// $db->ground_earth_place 		= $ground_earth_place;
			// $db->coast_place 				= $coast_place;
			$db->plant_type 				= $plant_type;
			$db->economic_value 			= $economic_value;
			$db->animal_type1 				= $animal_type1;
			$db->animal_type2 				= $animal_type2;
			$db->animal_type3 				= $animal_type3;
			$db->reproduction 				= $reproduction;

			if(count((array)$utilization) > 0){
				foreach ($utilization as $value) {
					$recordutil = new RecordUtilization;
					$recordutil->record_unique_id = $db->unique_record;
					$recordutil->utilization_id = $value;
					$recordutil->save();
				}
			}

			if(count((array)$place) > 0){
				foreach ($place as $value) {
					$recordplace = new RecordPlace;
					$recordplace->record_unique_id = $db->unique_record;
					$recordplace->place_id = $value;
					$recordplace->save();
				}
			}

			$lastId = CatchException::catcherEdit($db);
			// dd(Session::get('exception_catcher'));

			//log setting
			if ( $lastId ) {
				return redirect('staff/addRecordPicture');
			} else {
				$action = AllMean::defineAddAlertFail();
				Session::put('action', $action);
	        	return redirect('staff/manageRecord');
			}

		//-----
	}

	public function addRecordPicture(){
		$classification_id 			= 	Session::get('classification_id_form_add');
		$data['classification'] 	= 	Classification::getClassification($classification_id);

		// get taxonomy wording
		$arr_taxonomy_id 			=	[$data['classification']->domain,
											$data['classification']->kingdom,
											$data['classification']->subkingdom,
											$data['classification']->infrakingdom,
											$data['classification']->phylum,
											$data['classification']->subphylum,
											$data['classification']->infraphylum,
											$data['classification']->superclass,
											$data['classification']->class,
											$data['classification']->subclass,
											$data['classification']->infraclass,
											$data['classification']->superorder,
											$data['classification']->order,
											$data['classification']->suborder,
											$data['classification']->infraorder,
											$data['classification']->superfamily,
											$data['classification']->family,
											$data['classification']->subfamily,
											$data['classification']->genus,
											$data['classification']->subgenus,
											$data['classification']->species,
											$data['classification']->subspecies];
		$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

		$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
		if(is_null($data['iq'])){
			$data['iq'] = null;
		}else{
			$data['iq'] = $data['iq']->name_en;
		}
		return view('staff.record.add.add_record_form_picture', $data);
	}

	public function doAddRecordPicture(Request $input){

		$picture 		= 	$input->file('picture');

		for ($i=0; $i < 6; $i++) {

			// $picture[]		=	$input->{'picture_'.$i};
			$caption[]		=	$input->{'caption_'.$i};
			$photographer[]	=	$input->{'photographer_'.$i};

		}

		$id_class 				=	Session::get('classification_id_form_add');
		$id_record				=	Session::get('record_id_add_en');
		$id_record_unique 		=	Record::where( 'id', Session::get('record_id_add_en') )->get();
		$id_record_unique		=	$id_record_unique[0]->unique_record;
		$pic 			=	1;

		foreach ((array)$picture as $value) {


			if(isset($value)){

				list($width_p,$height_p) = getimagesize($value);
				if($width_p <= $height_p){
					return redirect('staff/addRecordPicture');
				}


				$extention_type = $value->getClientOriginalExtension();
				$filename = $id_class."_".$id_record."_pic".$pic."_".strtotime(date("Y-m-d H:i:s"))."_".uniqid().'.'.$extention_type;
				// $destinationPath = 'uploads/images';
				$destinationPath = $_SERVER['DOCUMENT_ROOT']."/mrds_file/uploads/images";

				$successUplaod	=	$value->move($destinationPath, $filename);

				$lastId		=	Picture::addPictureRecord($id_record_unique, $filename, $caption[$pic-1], $photographer[$pic-1], 1, 1);

				if( $lastId && $successUplaod ){

					System_Log::Loging( 'picture', // table_name
	                                    $lastId, // row_id
	                                    AllMean::defineAdd(),  // action
	                                    "", // old_data
	                                    Picture::getPicture($lastId)->toArray() ); // new_data
					++$pic;

				}else{
					$action = AllMean::defineAddAlertFail();
					Session::put('action', $action);
		        	return redirect('staff/manageRecord');
				}

			}

		}

		// clear 3 red session;
		Session::forget('classification_id_form_add');
		Session::forget('record_id_add_th');
		return redirect('staff/approveViewRecord');
	}

	public function manageRecord(){
		return view('staff.record.manage.choose_type');
	}

	public function manageRecordPublication(){

		// $data['records']		=	Record::getRecordBySource(2); // 2 mean publication
		return view('staff.record.manage.publication');
	}

	public function manageRecordSpecimens(){
		// $data['records']		=	Record::getRecordBySource(1); // 1 mean  specimens
		return view('staff.record.manage.specimens');
	}

	public function getRecordDataTable($source){
		// dd(123);
		$query = Record::select('record.id','record.related_catalog_item','record.related_reference_item','classification.current_scientific_name_format','record.page','record.status','w1.name_en as ref_en','w2.name_en as collection_code','marinecenter.marinecenter_code')
					->join('classification', 'record.classification_id', '=', 'classification.id')
					->leftjoin('wording as w1', 'record.reference', '=', 'w1.id')
					->leftjoin('wording as w2', 'record.collection_code', '=', 'w2.id')
					->join('marinecenter', 'record.marinecenter_id', '=', 'marinecenter.id')
					->where('record.source', $source)
					->where('record.approve_status',1);

		if(Auth::user()->role_id == 3){
		$query = $query->where('record.marinecenter_id',Auth::user()->marinecenter_id)

						->where('record.status', 2);
		}

		$query = $query->groupby('record.marinecenter_id','record.collection_code','record.related_catalog_item','record.related_reference_item');
			// ->orderBy('record.id', 'desc');

		$btn = '';
		return Datatables::of($query)
					->addColumn('action', function ($query) use ($btn) {
						$btn .= '<a href="'.url('staff/viewRecord', base64_encode( base64_encode( base64_encode( $query->id ))) ).'">
							<span class="glyphicon glyphicon-eye-open"></span> View
						</a>
						<span class="between-tools"> | </span>
						<a href="'.url('staff/editRecordForm').'/1/'.base64_encode( base64_encode( base64_encode( $query->id ))).'/'.base64_encode( base64_encode( base64_encode( '1' ))).'">
							<span class="glyphicon glyphicon-pencil"></span> Edit
						</a>';

						return $btn;

					})
					->rawColumns(['current_scientific_name_format', 'action'])
					->addIndexColumn()
					->make(true);
	}

	//Sorawit
	//Created : 28-3-59
	//Modified : 4-6-59 by Chaloemphon
	public function editRecordForm($page, $record_id, $type_redirect) {
		//record_id = 14 is VFZSUlBRPT0=
		$record_id = base64_decode(base64_decode(base64_decode($record_id)));
		$type_redirect = base64_decode(base64_decode(base64_decode($type_redirect)));
		Session::put('edit_redirect_target', $type_redirect);

		//check page for back button : 1 is specimens, 2 is publication
		if ( $page == 1 ) {
			$data['back_page'] = 'manageRecordSpecimens';
		} elseif ($page == 2 ) {
			$data['back_page'] = 'manageRecordPublication';
		} else {
			return redirect('staff/manageRecord');
		}

		//admin can edit, status: disable (other cannot.)
		$record = Record::getFullRecord($record_id);

		$data['record'] = $record[0]; //englist record

		$data['marinecenter_list'] = Marinecenter::getMarineCenterList();

		$data['marinecenter'] 		= 	Marinecenter::getMarineCenter(Auth::user()->marinecenter_id)->marinecenter_code;
		$data['classification'] 	= 	Classification::getClassification($record[0]->classification_id);

		// get taxonomy wording
		$arr_taxonomy_id 			=	[$data['classification']->domain,
											$data['classification']->kingdom,
											$data['classification']->subkingdom,
											$data['classification']->infrakingdom,
											$data['classification']->phylum,
											$data['classification']->subphylum,
											$data['classification']->infraphylum,
											$data['classification']->superclass,
											$data['classification']->class,
											$data['classification']->subclass,
											$data['classification']->infraclass,
											$data['classification']->superorder,
											$data['classification']->order,
											$data['classification']->suborder,
											$data['classification']->infraorder,
											$data['classification']->superfamily,
											$data['classification']->family,
											$data['classification']->subfamily,
											$data['classification']->genus,
											$data['classification']->subgenus,
											$data['classification']->species,
											$data['classification']->subspecies];
		$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

		$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
		if(is_null($data['iq'])){
			$data['iq'] = null;
		}else{
			$data['iq'] = $data['iq']->name_en;
		}

		//get value for dropdown
		// $data['collection_codes'] = Wording::getWording($data['record']->collection_code);
		// $data['references'] = Wording::getWordingByWordingTypeForForm(1);
		$data['collection_codes'] 	= Collection::getCollection($record[0]->collection_code);
		$data['references'] 		= Reference::getReferenceByID($record[0]->reference);
		$data['donated_froms'] 		= Wording::getWordingByWordingTypeForForm(10);
		$data['deposited_ats'] 		= Wording::getWordingByWordingTypeForForm(11);
		$data['type_statuses'] 		= Wording::getWordingByWordingTypeForForm(2);
		$data['sexs'] 				= Wording::getWordingByWordingTypeForForm(5);
		$data['life_stages'] 		= Wording::getWordingByWordingTypeForForm(9);
		$data['ocean_sea_lakes'] 	= Wording::getWordingByWordingTypeForForm(3);
		$data['sediment_types'] 	= Wording::getWordingByWordingTypeForForm(25);
		$data['countries'] 			= Country::getCountryListForFormEN();
		$data['provinces'] 			= Province::getProvinceEnableInCountry($record[0]->country);
		$data['districts'] 			= District::getDistrictEnableInProvince($record[0]->province);
		$data['counties'] 			= County::getCountyEnableInDistrict($record[0]->district);
		$data['habitats'] 			= Wording::getWordingByWordingTypeForForm(8);
		$data['gear_methods'] 		= Wording::getWordingByWordingTypeForForm(4);
		$data['preparation_types'] 	= Wording::getWordingByWordingTypeForForm(7);
		$data['expeditions'] 		= Wording::getWordingByWordingTypeForForm(6);

		// get extra field
		$data['extra_fields'] = Extra_Field::getExtraFieldNameList();

		// get extra info
		$data['extra_info'] = Extra_Info::getExtraInfo( $data['record']->unique_record );

		//set up session
		Session::put('classification_id_form_edit', $record[0]->classification_id);
		Session::put('record_id_edit_en', $record[0]->id);
		Session::put('record_id_edit_th', $record[1]->id);

		return view('staff.record.edit.edit_record_form_en', $data);
	}

	//Sorawit
	//Created : 29-3-59
	//Modified : -
	public function doEditRecordForm(Request $input) {
		//get session
		$record_id_edit_en = Session::get('record_id_edit_en');
		$record_id_edit_th = Session::get('record_id_edit_th');
		$record_id_array = array($record_id_edit_en, $record_id_edit_th);

		//get old data record
		$old_record_en 			= Record::getRecord($record_id_edit_en);
		$old_record_th 			= Record::getRecord($record_id_edit_th);
		$old_record_array 		= array($old_record_en, $old_record_th);

		//get input and set value
		$collection_code 		= $input->collection_code;
		$variety_name 			= $input->variety_name;
		$donated_from 			= $input->donated_from;
		$deposited_at 			= $input->deposited_at;
		$type_status 			= $input->type_status;
		$individual_count 		= $input->individual_count;
		$sex 					= $input->sex;
		$size 					= $input->size;
		$life_stage 			= $input->life_stage;
		$ocean_sea_lake 		= $input->ocean_sea_lake;
		$islands_island			= $input->islands_island;
		$country 				= $input->country;
		$province 				= $input->province;
		$district 				= $input->district;
		$county 				= $input->county;
		$locality 				= $input->locality;
		$verbatim_lat 			= $input->verbatim_lat;
		$verbatim_long 			= $input->verbatim_long;
		$lat 					= $input->lat;
		$long 					= $input->long;
		$start_lat 				= $input->start_lat;
		$end_lat 				= $input->end_lat;
		$start_long 			= $input->start_long;
		$end_long 				= $input->end_long;
		$habitat 				= $input->habitat;
		$sediment_type 			= $input->sediment_type;

		// 1 foot = 0.3048 m.
		if( $input->depth_unit == 2)
			$depth = $input->depth * 0.3048;
		else
			$depth = $input->depth;
		if( $input->depth_end_unit == 2 )
			$depth_end = $input->depth_end * 0.3048;
		else
			$depth_end = $input->depth_end;

		//get input and set value
		$collector = $input->collector;
		if ( $input->collected_date == null ) $input->collected_date = '0000-00-00';
		$collected_date 			= date('Y-m-d', strtotime($input->collected_date));
		$collected_year 			= date("Y", strtotime($collected_date));;
		$collected_month 			= date("m", strtotime($collected_date));;
		$collected_day 				= date("d", strtotime($collected_date));;
		$identifier 				= $input->cur_identifier;
		if ( $input->cur_identified_date == null ) $input->cur_identified_date = '0000-00-00';
		$identified_date 			= date('Y-m-d', strtotime($input->cur_identified_date));
		$identified_year 			= date("Y", strtotime($identified_date));;
		$identified_month 			= date("m", strtotime($identified_date));;
		$identified_day 			= date("d", strtotime($identified_date));;
		$prev_identifier 			= $input->prev_identifier;
		if ( $input->prev_identified_date == null ) $input->prev_identified_date = '0000-00-00';
		$prev_identified_date 		= date('Y-m-d', strtotime($input->prev_identified_date));
		$gear_method 				= $input->gear_method;
		$preparation_type 			= $input->preparation_type;
		$expedition 				= $input->expedition;
		$gene_bank_number 			= $input->gene_bank_number;
		$diagnosis 					= $input->diagnosis;
		$description 				= $input->description;
		$note_collector 			= $input->note_collector;

		//-----save in database ****FOR English Only
			$db = Record::find($record_id_edit_en);
			$db->variety_name = $variety_name;
			$db->islands_island	= $islands_island;
			$db->locality = $locality;
			$db->gene_bank_number = $gene_bank_number;
			$db->description = $description;
			$db->diagnosis = $diagnosis;
			$db->updated_by = Auth::user()->id;

			$lastId = CatchException::catcherEdit($db);

			//log setting
			if ( $lastId ) {
				System_Log::Loging(
					'record', // table_name
					$record_id_edit_en, // row_id
					AllMean::defineEdit(),  // action
					$old_record_en->toArray(), // old_data
					Record::getRecord($record_id_edit_en)->toArray() // new_data
				);
			} else {
				$action = AllMean::defineAddAlertFail();
				Session::put('action', $action);
				if ( $source == 1 ) {
					return redirect('staff/manageRecordSpecimens');
				} else {
					return redirect('staff/manageRecordPublication');
				}
			}
		//-----

		$new_collections_code = Collection::find($collection_code)->col_code;


		//-----save in database ****FOR English and Thai
			for ( $i=0 ; $i<2 ; $i++) {
				$db 						= Record::find($record_id_array[$i]);

				$old_collection_code = Collection::find($db->collection_code)->col_code;

				if($new_collections_code != $old_collection_code){

					if($db->source == 1){
						$db->related_catalog_item = str_replace($old_collection_code, $new_collections_code, $db->related_catalog_item);
					}else{
						$db->related_reference_item = str_replace($old_collection_code, $new_collections_code, $db->related_reference_item);
					}
				}

				$db->collection_code 		= $collection_code;
				$db->individual_count 		= $individual_count;
				$db->latitude 				= $lat;
				$db->verbatim_latitude 		= $verbatim_lat;
				$db->start_latitude 		= $start_lat;
				$db->end_latitude 			= $end_lat;
				$db->longitude 				= $long;
				$db->verbatim_longitude 	= $verbatim_long;
				$db->start_longitude 		= $start_long;
				$db->end_longitude 			= $end_long;
				$db->country 				= $country;
				$db->province 				= $province;
				$db->district 				= $district;
				$db->county 				= $county;
				$db->ocean_sea_lake 		= $ocean_sea_lake;
				$db->habitat 				= $habitat;
				$db->sediment_type			= $sediment_type;
				$db->type_status 			= $type_status;
				$db->sex 					= $sex;
				$db->size 					= $size;
				$db->life_stage 			= $life_stage;
				$db->donated_from 			= $donated_from;
				$db->deposited_at 			= $deposited_at;
				$db->gear_method 			= $gear_method;
				$db->depth_start 			= $depth;
				$db->depth_end 				= $depth_end;
				$db->collector 				= $collector;
				$db->collected_date 		= $collected_date;
				$db->collected_year 		= $collected_year;
				$db->collected_month 		= $collected_month;
				$db->collected_day 			= $collected_day;
				$db->identifier 			= $identifier;
				$db->identified_date 		= $identified_date;
				$db->identified_year 		= $identified_year;
				$db->identified_month 		= $identified_month;
				$db->identified_day 		= $identified_day;
				$db->previous_identifier 	= $prev_identifier;
				$db->previous_identified_date = $prev_identified_date;
				$db->note_collector 		= $note_collector;
				$db->expedition 			= $expedition;
				$db->preparation_type 		= $preparation_type;
				$db->updated_by 			= Auth::user()->id;

				$lastId = CatchException::catcherEdit($db);

				//log setting
				if ( $lastId ) {
					System_Log::Loging(
						'record', // table_name
						$record_id_array[$i], // row_id
						AllMean::defineEdit(),  // action
						$old_record_array[$i]->toArray(), // old_data
						Record::getRecord($record_id_array[$i])->toArray()// new_data
					);
				} else {
					$action = AllMean::defineAddAlertFail();
					Session::put('action', $action);
					if ( $source == 1 ) {
						return redirect('staff/manageRecordSpecimens');
					} else {
						return redirect('staff/manageRecordPublication');
					}
				}
			}

			// set (add & edit) extra information
			if ( sizeof( (array)Extra_Info::getExtraInfo( $old_record_en->unique_record ) ) ) {	// check have or not have
				Extra_Info::updateExtraInfo( $input->extra_info, $old_record_en->unique_record );	// update
			} else {
				Extra_Info::addExtraInfo( $input->extra_info, $old_record_en->unique_record );	// add
			}

		//-----

		return redirect('staff/editRecordFormTH');
	}

	public function editRecordFormTH() {
		if ( Session::has('record_id_edit_en') && Session::has('record_id_edit_th') ) {
			$record_id_edit_th = Session::get('record_id_edit_th');
			$record = Record::getRecordTH($record_id_edit_th);

			$data['team_exploration_codes'] 	= Wording::getWordingByWordingTypeForForm(15);
			$data['area_explorations'] 			= Wording::getWordingByWordingTypeForForm(16);
			$data['area_directions'] 			= Wording::getWordingByWordingTypeForForm(13);

			$utilizations_unique_record = RecordUtilization::where('record_unique_id', $record->unique_record)->get();
			$util = [];
			foreach($utilizations_unique_record as $value){
				$util[] = $value->utilization_id;
			}
			$data['utilizations']				= $util;

			$places_unique_record = RecordPlace::where('record_unique_id', $record->unique_record)->get();
			$place = [];
			foreach($places_unique_record as $value){
				$place[] = $value->place_id;
			}

			$data['places']				= $place;


			// $data['recorders'] 					= Wording::getWordingByWordingTypeForForm(17);
			$data['animal_type1s'] 				= Wording::getWordingByWordingTypeForForm(18);
			$data['animal_type2s'] 				= Wording::getWordingByWordingTypeForForm(19);
			$data['animal_type3s'] 				= Wording::getWordingByWordingTypeForForm(20);
			$data['plant_types'] 				= Wording::getWordingByWordingTypeForForm(21);
			$data['economic_values'] 			= Wording::getWordingByWordingTypeForForm(24);

			// $data['utilizations_record'] 		= RecordUtilization::where('record_unique_id', $record->unique_record)->get();
			$data['classification'] 	= 	Classification::getClassification($record->classification_id);
			// get taxonomy wording
			$arr_taxonomy_id 			=	[$data['classification']->domain,
												$data['classification']->kingdom,
												$data['classification']->subkingdom,
												$data['classification']->infrakingdom,
												$data['classification']->phylum,
												$data['classification']->subphylum,
												$data['classification']->infraphylum,
												$data['classification']->superclass,
												$data['classification']->class,
												$data['classification']->subclass,
												$data['classification']->infraclass,
												$data['classification']->superorder,
												$data['classification']->order,
												$data['classification']->suborder,
												$data['classification']->infraorder,
												$data['classification']->superfamily,
												$data['classification']->family,
												$data['classification']->subfamily,
												$data['classification']->genus,
												$data['classification']->subgenus,
												$data['classification']->species,
												$data['classification']->subspecies];
			$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

			$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
			if(is_null($data['iq'])){
				$data['iq'] = null;
			}else{
				$data['iq'] = $data['iq']->name_en;
			}

			$data['record'] = $record;
			$data['classification'] = Classification::getClassification($record->classification_id);
			$data['marinecenter'] = Marinecenter::getMarineCenter($record->marinecenter_id)->marinecenter_code;
			return view('staff.record.edit.edit_record_form_th', $data);
		} else {
			return redirect('staff/managerRecord');
		}

	}

	//Sorawit
	//Created : 30-3-59
	//Modified : 2-6-59
	public function doEditRecordFormTH(Request $input){
		// get session and get record
		$record_id_edit_th = Session::get('record_id_edit_th');
		$old_record = Record::getRecord($record_id_edit_th);

		// get and set value from form
		$variety_name 			= $input->variety_name;
		$size 					= $input->size;
		$islands_island			= $input->islands_island;
		$locality 				= $input->locality;
		$gene_bank_number 		= $input->gene_bank_number;
		$description 			= $input->description;
		$diagnosis 				= $input->diagnosis;
		$local_name 			= $input->local_name;
		$vernacular_name 		= $input->vernacular_name;
		// $common_name 			= $input->common_name;
		$team_exploration_code 	= $input->team_exploration_code;
		$area_exploration 		= $input->area_exploration;
		$village_no 			= $input->village_no;
		$area_direction 		= $input->area_direction;
		$area 					= $input->area;
		$utilization 			= $input->utilization;
		$recorder 				= $input->recorder;
		$folk_wisdom 			= $input->folk_wisdom;
		$knowledge_remarks 		= $input->knowledge_remarks;
		$water_temperature 		= $input->water_temperature;
		$transparency 			= $input->transparency;
		$water_ph 				= $input->water_ph;
		$dissolve_oxygen 		= $input->dissolve_oxygen;
		$suspended_solid 		= $input->suspended_solid;
		$salinity 				= $input->salinity;
		$specimen_collection 	= $input->specimen_collection;
		$specimen_photograph 	= $input->specimen_photograph;
		// $water_place 			= $input->water_place;
		// $tree_place 			= $input->tree_place;
		// $soil_earth_place 		= $input->soil_earth_place;
		// $ground_earth_place 	= $input->ground_earth_place;
		// $coast_place 			= $input->coast_place;
		$place 					= $input->place;
		$plant_type 			= $input->plant_type;
		$economic_value 		= $input->economic_value;
		$animal_type1 			= $input->animal_type1;
		$animal_type2 			= $input->animal_type2;
		$animal_type3 			= $input->animal_type3;

		$reproduction  					= "";
		if($input->sexual == null && $input->asexual == null){
			$reproduction	=	"0";
		}else if($input->sexual != null && $input->asexual == null){
			$reproduction	=	"1";
		}else if($input->sexual == null && $input->asexual != null){
			$reproduction	=	"2";
		}else if($input->sexual != null && $input->asexual != null){
			$reproduction	=	"3";
		}

		//-----update in database (thai)
			$db 				= Record::find($record_id_edit_th);
			$db->variety_name 	= $variety_name;
			$db->size 			= $size;
			$db->islands_island	= $islands_island;
			$db->locality 		= $locality;
			$db->gene_bank_number = $gene_bank_number;
			$db->description 	= $description;
			$db->diagnosis 		= $diagnosis;
			$db->local_name 	= $local_name;
			$db->vernacular_name 	= $vernacular_name;
			// $db->common_name 	= $common_name;
			$db->team_exploration_code = $team_exploration_code;
			$db->area_exploration 	= $area_exploration;
			$db->village_no 	= $village_no;
			$db->area_direction = $area_direction;
			$db->area 			= $area;
			// $db->utilization 	= $utilization;
			$db->recorder 		= $recorder;
			$db->folk_wisdom 	= $folk_wisdom;
			$db->knowledge_remarks 	= $knowledge_remarks;
			$db->water_temperature 	= $water_temperature;
			$db->transparency 	= $transparency;
			$db->water_ph 		= $water_ph;
			$db->dissolve_oxygen 	= $dissolve_oxygen;
			$db->suspended_solid 	= $suspended_solid;
			$db->salinity 		= $salinity;
			$db->specimen_collection = $specimen_collection;
			$db->specimen_photograph = $specimen_photograph;
			// $db->water_place = $water_place;
			// $db->tree_place = $tree_place;
			// $db->soil_earth_place = $soil_earth_place;
			// $db->ground_earth_place = $ground_earth_place;
			// $db->coast_place = $coast_place;
			$db->plant_type = $plant_type;
			$db->economic_value = $economic_value;
			$db->animal_type1 = $animal_type1;
			$db->animal_type2 = $animal_type2;
			$db->animal_type3 = $animal_type3;
			$db->reproduction = $reproduction;

			RecordUtilization::where('record_unique_id', $db->unique_record)->delete();
			if(count((array)$utilization) > 0){
				foreach ($utilization as $value) {
					$recordutil = new RecordUtilization;
					$recordutil->record_unique_id = $db->unique_record;
					$recordutil->utilization_id = $value;
					$recordutil->save();
				}
			}

			RecordPlace::where('record_unique_id', $db->unique_record)->delete();
			if(count((array)$place) > 0){
				foreach ($place as $value) {
					$recordplace = new RecordPlace;
					$recordplace->record_unique_id = $db->unique_record;
					$recordplace->place_id = $value;
					$recordplace->save();
				}
			}


			$lastId = CatchException::catcherEdit($db);

			//log setting
			if ( $lastId ) {
				System_Log::Loging(
					'record',  // table_name
					$record_id_edit_th, // row_id
					AllMean::defineEdit(), // action
					$old_record->toArray(), // old_data
					Record::getRecord($record_id_edit_th)->toArray() ); // new_data
				// echo 'jub jub ja';
				// exit;
				return redirect('staff/editRecordPicture');
			} else {
				$action = AllMean::defineAddAlertFail();
				Session::put('action', $action);
	        	return redirect('staff/managerRecord');
			}
		//-----
	}

	//Chaloemphon
	//Created : 29-3-59
	//Modified : -
	public function viewRecord($id = ""){
		if($id != ""){
			$id_decode = base64_decode( base64_decode( base64_decode( $id ) ) );
		}elseif( Session::has('record_id_add_en') ){
			$id_decode = Session::get('record_id_add_en');
			Session::forget('record_id_add_en');

		}elseif( Session::has('record_id_edit_en') ){

			$id_decode = Session::get('record_id_edit_en');
			Session::forget('record_id_edit_en');


		}

		if(!isset($id_decode)){
			return redirect('staff/manageRecord');
		}


		$data['record']				=	Record::getFullRecord($id_decode);
		$data['marinecenter']		=	Marinecenter::getMarineCenterCode($data['record'][0]->marinecenter_id);
		$data['classification'] 	= 	Classification::getClassification($data['record'][0]->classification_id);
		$data['country']			=	Country::getCountryWording($data['record'][0]->country);
		$data['province']			=	Province::getProvinceWording($data['record'][0]->province);
		$data['district']			=	District::getDistrictWording($data['record'][0]->district);
		$data['county']				=	County::getCountyWording($data['record'][0]->county);
		$data['users_approve']		=	Users::getUserById($data['record'][0]->approve_by);
		$data['users_add']			=	Users::getUserById($data['record'][0]->created_by);
		$data['last_update_time']	=	Record::where('unique_record', $data['record'][0]->unique_record)->max('updated_at');

		$util_list 					=	['ความเพลิดเพลิน','การค้า','ใช้แรงงาน','อาหาร','ยา','ศึกษาวิจัย','เครื่องนุ่งห่ม','สวยงาม'];
		$record_util 				= 	RecordUtilization::where('record_unique_id', $data['record'][0]->unique_record)->get();
		$data['record_utilizations'] = 	[];
		foreach ($record_util as $value) {
			$data['record_utilizations'][] = $util_list[$value->utilization_id - 1];
		}


		$place_list					=	['น้ำจืด','น้ำกร่อย','ทะเล','ภูเขา','บนต้นไม้','หน้าดิน','ในดิน','บนบก'];
		$record_place				=	RecordPlace::where('record_unique_id', $data['record'][0]->unique_record)->get();
		$data['record_places']		=	[];
		foreach($record_place as $value){
			$data['record_places'][]	=	$place_list[$value->place_id - 1];
		}

		// get user for last updated record
		$users_update				=	Record::select('updated_by')
										->where('unique_record', $data['record'][0]->unique_record)
										->orderBy('updated_at', 'desc')
										->first();
		$data['users_update'] 		=	Users::getUserById( $users_update->updated_by );

		// get taxonomy wording
		$arr_taxonomy_id 			=	[$data['classification']->domain,
											$data['classification']->kingdom,
											$data['classification']->subkingdom,
											$data['classification']->infrakingdom,
											$data['classification']->phylum,
											$data['classification']->subphylum,
											$data['classification']->infraphylum,
											$data['classification']->superclass,
											$data['classification']->class,
											$data['classification']->subclass,
											$data['classification']->infraclass,
											$data['classification']->superorder,
											$data['classification']->order,
											$data['classification']->suborder,
											$data['classification']->infraorder,
											$data['classification']->superfamily,
											$data['classification']->family,
											$data['classification']->subfamily,
											$data['classification']->genus,
											$data['classification']->subgenus,
											$data['classification']->species,
											$data['classification']->subspecies];
		$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

		$this_record				=	Record::where('id', $id_decode)->get();
		$data['pictures']			=	Picture::getPictureByRecordId($this_record[0]->unique_record);

		// get extra information
		$data['extra_info'] = Extra_Info::getExtraInfo( $data['record'][0]->unique_record );
		if ( sizeof( (array)$data['extra_info'] ) ) {	// check have or not have
			$data['extra_fields'] = Extra_Field::getExtraFieldNameList(); // get extra field
		} else {
			$data['extra_info'] = null;
		}

		return view('staff.record.manage.view_record', $data);
	}

	public function editRecordPicture(){

		$record_id_edit_th = Session::get('record_id_edit_th');
		$data['record'] = Record::getRecordTH($record_id_edit_th);

		$classification_id 			= 	Session::get('classification_id_form_edit');
		$data['classification'] 	= 	Classification::getClassification($classification_id);

		// get taxonomy wording
		$arr_taxonomy_id 			=	[$data['classification']->domain,
											$data['classification']->kingdom,
											$data['classification']->subkingdom,
											$data['classification']->infrakingdom,
											$data['classification']->phylum,
											$data['classification']->subphylum,
											$data['classification']->infraphylum,
											$data['classification']->superclass,
											$data['classification']->class,
											$data['classification']->subclass,
											$data['classification']->infraclass,
											$data['classification']->superorder,
											$data['classification']->order,
											$data['classification']->suborder,
											$data['classification']->infraorder,
											$data['classification']->superfamily,
											$data['classification']->family,
											$data['classification']->subfamily,
											$data['classification']->genus,
											$data['classification']->subgenus,
											$data['classification']->species,
											$data['classification']->subspecies];
		$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

		$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
		if(is_null($data['iq'])){
			$data['iq'] = null;
		}else{
			$data['iq'] = $data['iq']->name_en;
		}


		$id_record_unique 		=	Record::where( 'id', Session::get('record_id_edit_en') )->get();
		$id_record_unique		=	$id_record_unique[0]->unique_record;
		$data['pictures']		=	Picture::getPictureByRecordId( $id_record_unique );
		return view('staff.record.edit.edit_record_form_picture', $data);

	}

	public function doEditRecordPicture(Request $input){
		$oldpicture		=	$input->oldpicture;
		$picture 		= 	$input->file('picture');

		for ($i=0; $i < 6; $i++) {

			$oldid[] 		= 	$input->{'oldid_'.$i};
			// $picture[]		=	$picture_upload[$i];
			$caption[]		=	$input->{'caption_'.$i};
			$photographer[]	=	$input->{'photographer_'.$i};
			$del[]			=	$input->{'del_'.$i};

		}

		$id_class 				=	Session::get('classification_id_form_edit');
		$id_record 				=	Session::get('record_id_edit_en');
		$id_record_unique 		=	Record::where( 'id', Session::get('record_id_edit_en') )->get();
		$id_record_unique		=	$id_record_unique[0]->unique_record;
		$pic 					=	1;
		for( $i = sizeof((array)$oldpicture); $i < 6; $i++ ){
			$oldpicture[] = "";
		}

		for($a = 0; $a < 6; $a++){

			if($del[$a] === '0' || empty($del[$a])){
				$del[$a] = null;
			}

			if(!isset($picture[$a]) && $oldpicture[$a] != "" && $oldid[$a] != "" && $del[$a] == "" && $caption[$a] != "" && $photographer[$a] != ""){
				//use old pic
				//update only text

				if( Picture::editPictureTextRecord($oldid[$a], $caption[$a], $photographer[$a]) ){
					System_Log::Loging( 'picture',  // table_name
										$oldid[$a], // row_id
										AllMean::defineEdit(), // action
										System_Log::getOldData(), // old_data
										Picture::getPicture($oldid[$a])->toArray() ); // new_data

					$action = AllMean::defineEditAlertSuccess();
				} else {
					$action = AllMean::defineEditAlertFail();
					Session::put('action', $action);
					if( Session::get('edit_redirect_target') == 1){
						return redirect('staff/manageRecordSpecimens');
					}elseif(Session::get('edit_redirect_target') == 2){
						return redirect('staff/manageRecordPublication');
					}else{
						return redirect('staff/approveViewRecord');
					}

				}

			}

			if(isset($picture[$a]) && $oldpicture[$a] == "" && $oldid[$a] == "" && $del[$a] == ""){
				// use new pic


				if(isset($picture[$a])){

					list($width_p,$height_p) = getimagesize($picture[$a]);
					if($width_p <= $height_p){
						return redirect('staff/editRecordPicture');
					}

					$extention_type = $picture[$a]->getClientOriginalExtension();
					$filename = $id_class."_".$id_record."_pic".$pic."_".strtotime(date("Y-m-d H:i:s"))."_".uniqid().'.'.$extention_type;
					// dd($filename);

					// $destinationPath = 'uploads/images';
					$destinationPath = $_SERVER['DOCUMENT_ROOT']."/mrds_file/uploads/images";

					$successUplaod	=	$picture[$a]->move($destinationPath, $filename);

					$lastId		=	Picture::addPictureRecord($id_record_unique, $filename, $caption[$a], $photographer[$a], 1, 1);

					if( $lastId && $successUplaod ){
						System_Log::Loging( 'picture', // table_name
		                                    $lastId, // row_id
		                                    AllMean::defineAdd(),  // action
		                                    "", // old_data
		                                    Picture::getPicture($lastId)->toArray() ); // new_data

					}else{
						$action = AllMean::defineAddAlertFail();
						Session::put('action', $action);
						if( Session::get('edit_redirect_target') == 1){
							return redirect('staff/manageRecordSpecimens');
						}elseif(Session::get('edit_redirect_target') == 2){
							return redirect('staff/manageRecordPublication');
						}else{
							return redirect('staff/approveViewRecord');
						}

					}

				}

			}

			if(isset($picture[$a]) && $oldpicture[$a] != "" && $oldid[$a] != ""){
				//replace new pic

				if(isset($picture[$a])){

					list($width_p,$height_p) = getimagesize($picture[$a]);
					if($width_p <= $height_p){
						return redirect('staff/editRecordPicture');
					}

					$filename = $id_class."_".$id_record."_pic".$pic."_".strtotime(date("Y-m-d H:i:s"))."_".uniqid();
					// $destinationPath = 'uploads/images';
					$destinationPath = $_SERVER['DOCUMENT_ROOT']."/mrds_file/uploads/images";
					$successUplaod	=	$picture[$a]->move($destinationPath, $filename);

					if( Picture::editPictureRecord($oldid[$a], $filename, $caption[$a], $photographer[$a], 1, 1) ){
						System_Log::Loging( 'picture',  // table_name
											$oldid[$a], // row_id
											AllMean::defineEdit(), // action
											System_Log::getOldData(), // old_data
											Picture::getPicture($oldid[$a])->toArray() ); // new_data


						$action = AllMean::defineEditAlertSuccess();
					} else {
						$action = AllMean::defineEditAlertFail();
						Session::put('action', $action);
						if( Session::get('edit_redirect_target') == 1){
							return redirect('staff/manageRecordSpecimens');
						}elseif(Session::get('edit_redirect_target') == 2){
							return redirect('staff/manageRecordPublication');
						}else{
							return redirect('staff/approveViewRecord');
						}

					}

				}

			}

			if($del[$a] != "" && $oldid[$a] != ""){
				//delete this pic with id
				$pic_name_for_del = Picture::find($del[$a])->path_pic;
				\File::delete('uploads/images/'.$pic_name_for_del);

				if( Picture::deletePictureRecord($del[$a]) ){

					System_Log::Loging( 'picture',  // table_name
										$oldid[$a], // row_id
										AllMean::defineDelete(), // action
										"", // old_data
										""); // new_data

					$action		=	AllMean::defineDeleteAlertSuccess();
				}else{
					$action		=	AllMean::defineDeleteAlertFail();
					Session::put('action', $action);
					if( Session::get('edit_redirect_target') == 1){
						return redirect('staff/manageRecordSpecimens');
					}elseif(Session::get('edit_redirect_target') == 2){
						return redirect('staff/manageRecordPublication');
					}else{
						return redirect('staff/approveViewRecord');
					}
				}

			}

		}


		// clear 3 red session;
		Session::forget('classification_id_form_edit');
		Session::forget('record_id_edit_th');

		if( Session::get('edit_redirect_target') == 1){
			return redirect('staff/manageRecordSpecimens');
		}elseif(Session::get('edit_redirect_target') == 2){
			return redirect('staff/manageRecordPublication');
		}else{
			return redirect('staff/approveViewRecord');
		}
	}


	public function CreateNewCatalog($marinecenter_id){
		//get last catalog_number
		$check_catalog_number = Record::getLastCatalogNumber($marinecenter_id);
		if($check_catalog_number == ""){
			$catalog_number = 1;
		}else{
			$catalog_number = $check_catalog_number->catalog_number + 1;
		}

		//$catalog_number = $check_catalog_number_new +1;
		//$catalog_number = sprintf("%05d", $catalog_number);

		return $catalog_number;
	}

	// public function CreateNewNoSpecies($marinecenter_id, $collection_code, $reference, $page){
	// 	$no_specie = Record::getLastDuplicationPublication($marinecenter_id, $collection_code, $reference, $page);
	// 	if(is_null($no_specie)){
	// 		$no_species = 1;
	// 	}else{
	// 		$no_species = $no_specie->no_species+1;
	// 	}
	//
	// 	return $no_species;
	// }

	public function CreateRelatedCatalog($source, $marinecenter_code, $collection_code_string, $catalog_number){

		$related_catalog_item = $marinecenter_code[0]."-".$source."-".$collection_code_string."-".$catalog_number;

		return $related_catalog_item;
	}

	public function CreateRelatedReference($source, $marinecenter_code, $collection_code_string, $reference, $page, $no_species, $no_locality){

		$reference_string = Reference::getReferenceByID($reference)->ref_code;
		$related_reference_item = $marinecenter_code[0]."-".$source."-".$collection_code_string."-".$reference_string."-".$page."-".$no_species."-".$no_locality;

		return $related_reference_item;
	}

	public function ChangeStatus(Request $input){
		try{
			$db = Record::find($input->id_en);
			$db->status = $input->status;
			$db->save();

			$db = Record::find($input->id_en+1);
			$db->status = $input->status;
			$db->save();
		}catch(\Exception $e){
			dd($e->getMessage());
		}

	}

	public function approveRecord(){
		$data['records'] = Record::getRecordPending();
		return view('staff.record.approve.approve' , $data);
	}

	public function doApproveRecord($id){
		$id_record = base64_decode(base64_decode(base64_decode($id)));
		$db = Record::find($id_record);
		$db->approve_status = true;
		$db->approve_by = Auth::user()->id;
		$db->save();

		$db = Record::find($id_record+1);
		$db->approve_status = true;
		$db->approve_by = Auth::user()->id;
		$db->save();

		return redirect('staff/manageRecord');

	}

	public function approveViewRecord($record_id = ""){
		if($record_id != ""){
			$id_decode = base64_decode( base64_decode( base64_decode( $record_id ) ) );
		}elseif( Session::has('record_id_add_en') ){
			$id_decode = Session::get('record_id_add_en');
			Session::forget('record_id_add_en');

		}elseif( Session::has('record_id_edit_en') ){

			$id_decode = Session::get('record_id_edit_en');
			Session::forget('record_id_edit_en');


		}

		if(!isset($id_decode)){
			return redirect('staff/manageRecord');
		}


		$data['record']				=	Record::getFullRecord($id_decode);
		$data['marinecenter']		=	Marinecenter::getMarineCenterCode($data['record'][0]->marinecenter_id);
		$data['classification'] 	= 	Classification::getClassification($data['record'][0]->classification_id);
		$data['country']			=	Country::getCountryWording($data['record'][0]->country);
		$data['province']			=	Province::getProvinceWording($data['record'][0]->province);
		$data['district']			=	District::getDistrictWording($data['record'][0]->district);
		$data['county']				=	County::getCountyWording($data['record'][0]->county);

		$data['users_approve']		=	Users::getUserById($data['record'][0]->approve_by);
		$data['users_add']			=	Users::getUserById($data['record'][0]->created_by);
		$data['last_update_time']	=	Record::where('unique_record', $data['record'][0]->unique_record)->max('updated_at');
		// get user for last updated record
		$users_update				=	Record::select('updated_by')
										->where('unique_record', $data['record'][0]->unique_record)
										->orderBy('updated_at', 'desc')
										->first();
		$data['users_update'] 		=	Users::getUserById( $users_update->updated_by );

		$util_list 					=	['ความเพลิดเพลิน','การค้า','ใช้แรงงาน','อาหาร','ยา','ศึกษาวิจัย','เครื่องนุ่งห่ม','สวยงาม'];
		$record_util 				= 	RecordUtilization::where('record_unique_id', $data['record'][0]->unique_record)->get();
		$data['record_utilizations'] = 	[];
		foreach ($record_util as $value) {
			$data['record_utilizations'][] = $util_list[$value->utilization_id - 1];
		}

		$place_list					=	['น้ำจืด','น้ำกร่อย','ทะเล','ภูเขา','บนต้นไม้','หน้าดิน','ในดิน','บนบก'];
		$record_place				=	RecordPlace::where('record_unique_id', $data['record'][0]->unique_record)->get();
		$data['record_places']		=	[];
		foreach($record_place as $value){
			$data['record_places'][]	=	$place_list[$value->place_id - 1];
		}

		// dd($data['record_utilizations'], $data['record_places']);

		// get taxonomy wording
		$arr_taxonomy_id 			=	[$data['classification']->domain,
											$data['classification']->kingdom,
											$data['classification']->subkingdom,
											$data['classification']->infrakingdom,
											$data['classification']->phylum,
											$data['classification']->subphylum,
											$data['classification']->infraphylum,
											$data['classification']->superclass,
											$data['classification']->class,
											$data['classification']->subclass,
											$data['classification']->infraclass,
											$data['classification']->superorder,
											$data['classification']->order,
											$data['classification']->suborder,
											$data['classification']->infraorder,
											$data['classification']->superfamily,
											$data['classification']->family,
											$data['classification']->subfamily,
											$data['classification']->genus,
											$data['classification']->subgenus,
											$data['classification']->species,
											$data['classification']->subspecies];
		$data['taxonomy']			=	Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

		$this_record				=	Record::where('id', $id_decode)->get();
		$data['pictures']			=	Picture::getPictureByRecordId($this_record[0]->unique_record);

		// get extra information
		$data['extra_info'] = Extra_Info::getExtraInfo( $data['record'][0]->unique_record );
		if ( sizeof( (array)$data['extra_info'] ) ) {	// check have or not have
			$data['extra_fields'] = Extra_Field::getExtraFieldNameList(); // get extra field
		} else {
			$data['extra_info'] = null;
		}

		return view('staff.record.approve.view_record', $data);
	}
}
