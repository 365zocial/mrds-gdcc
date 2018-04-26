<?php

namespace App\Http\Controllers\Migration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Hash;
use File;
use Session;

use App\Model\CatchException;
use App\Http\Requests;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Wording;
use App\Model\Marinecenter;
use App\Model\Collection;
use App\Model\Reference;
use App\Model\Classification;
use App\Model\Record;
use App\Model\Taxonomy;
use App\Model\AllMean;
use App\Model\File_Migrate_Log;


class Migrate_old_data extends Controller
{

    private $max_upload = 149;
    private $start_upload = 0;
    // private $start_upload = 150*5;
    private $end_upload = 0;
    private $fix_max = false;
    private $country = array();
    private $province = array();
    private $district = array();
    private $county = array();
    private $mrct = array();

    private $collection = array();
    private $reference = array();
    private $source = array();

    # wording table zone
    private $iq = array();
    private $type_status = array();
    private $ocean_sea_lake = array();
    private $gear_method = array();
    private $sex = array();
    private $expendition = array();
    private $preparation = array();
    private $habitat = array();
    private $lifestate = array();
    private $donate_from = array();
    private $deposite_at = array();
    private $protection_type = array();
    private $area_direction = array();
    private $utility = array();
    private $team_exploration = array();
    private $area_exploration = array();
    private $recorder = array();
    private $animal1 = array();
    private $animal2 = array();
    private $animal3 = array();
    private $planttype = array();

    #checkbox zone
    private $reproduction = array();
    private $place = array();
    private $column_name = array();

    private $mrct_id = 0;
    private $warning = array();

    private $ExcelData = array();
    private $excel_count_row = 0;
    private $excel_count_row_all = 0;
    private $header_taxo =   array('Domain','Kingdom','Subkingdom','Infrakingdom','Phylum',
                        'Subphylum','Infraphylum','Superclass','Class','Subclass',
                        'Infraclass','Superorder','Order','Suborder','Infraorder',
                        'Superfamily','Family','Subfamily','Genus','Subgenus',
                        'Species','Subspecies');

    private $error_catch_check_taxo = true;
    private $error_catch_check_collection = true;
    private $error_catch_check_class = true;
    private $error_catch_check_record = true;
    private $error_catch_check_migrate = false;
    private $allowAddRecord = true;
    private $allowAddClassification = true;
    private $fullname = true;
    private $checkErrorInFileCSV = true;

    public function __construct(){
        echo "<meta charset='UTF-8'>";
        $this->end_upload   = $this->max_upload + $this->start_upload;
        $this->country      = array_map( 'current', Country::all(['country_th'])->toArray() );
        $this->province     = array_map( 'current', Province::all(['province_th'])->toArray() );
        $this->district     = array_map( 'current', District::all(['district_th'])->toArray() );
        $this->county       = array_map( 'current', County::all(['county_th'])->toArray() );

        if($this->fullname){
            $this->marinecenter = array_map( 'current', Marinecenter::get(['marinecenter'])->toArray() );
            $this->collection   = array_map( 'current', Collection::get(['name_en','name_th'])->toArray() );
        }else{
            $this->marinecenter = array_map( 'current', Marinecenter::get(['marinecenter_code'])->toArray() );
            $this->collection   = array_map( 'current', Collection::get(['col_code','name_th'])->toArray() );
        }

        $this->reference    = array_map( 'current', Reference::all(['name_th'])->toArray() );

        $this->source       = array('Specimen','Publication');

        # wording table zone
        $this->iq           = Wording::getWordingByWordingType(1)->toArray();
        $this->type_status  = Wording::getWordingByWordingType(2)->toArray();
        $this->ocean_sea_lake = Wording::getWordingByWordingType(3)->toArray();
        $this->gear_method  = Wording::getWordingByWordingType(4)->toArray();
        $this->sex          = Wording::getWordingByWordingType(5)->toArray();
        $this->expendition  = Wording::getWordingByWordingType(6)->toArray();
        $this->preparation  = Wording::getWordingByWordingType(7)->toArray();
        $this->habitat      = Wording::getWordingByWordingType(8)->toArray();
        $this->lifestate    = Wording::getWordingByWordingType(9)->toArray();
        $this->donate_from  = Wording::getWordingByWordingType(10)->toArray();
        $this->deposite_at  = Wording::getWordingByWordingType(11)->toArray();
        $this->protection_type  = Wording::getWordingByWordingType(12)->toArray();
        $this->area_direction  = Wording::getWordingByWordingType(13)->toArray();
        $this->utility      = Wording::getWordingByWordingType(14)->toArray();
        $this->team_exploration  = Wording::getWordingByWordingType(15)->toArray();
        $this->area_exploration  = Wording::getWordingByWordingType(16)->toArray();
        $this->recorder     = Wording::getWordingByWordingType(17)->toArray();
        $this->animal1      = Wording::getWordingByWordingType(18)->toArray();
        $this->animal2      = Wording::getWordingByWordingType(19)->toArray();
        $this->animal3      = Wording::getWordingByWordingType(20)->toArray();
        $this->planttype    = Wording::getWordingByWordingType(21)->toArray();

        $this->place        = array('แหล่งน้ำ','บนต้นไม้','หน้าดิน','ในดิน','ทะเล');
        $this->reprodunction = array('อาศัยเพศ','ไม่อาศัยเพศ');

        $this->column_name = array('Locality','Marinecenter','Collecion','Identification Qualifier',
                            'Type_Status','Gear Method','Sex','Expendition-โครงการสำรวจ','Preparation-การเก็บรักษา','Habitat-ระบบนิเวศที่อาศัย',
                            'Lifestate','Donate_from','Deposite_at','Protection_Type-การคุ้มครองสัตว์','Area_direction-สถานที่พบอยู่ทางทิศ',
                            'Utility-การใช้ประโยชน์','team_exploration','area_exploration','Animal1-ประเภทสัตว์1','Animal2-ประเภทสัตว์2','Animal3-ประเภทสัตว์3',
                            'Plant_Type-ประเภทของพืช','Place-ถิ่นอศัยที่พบ','reproduction-การสืบพันธ์');


    }

    public function index(){
        return view('staff.migrate.upload');
    }

    public function getFile(Request $input){
        // dd($input);

        $csv 		= 	$input->file('csv_file');

        $filename = $csv->getClientOriginalName();

        $destinationPath = 'migrate_old_data__';

        $successUplaod	=	$csv->move($destinationPath, $filename);

        $this->migrate($filename);

    }

    public function migrate($filename){

        $this->path_file = $filename;
        $this->getDataFromCSV();

        if( ( $this->excel_count_row_all > $this->max_upload ) && $this->fix_max){
            echo "<h3>Your file have over limit row number for migration</h3>";
            exit;
        }

        echo "This Excel have data ".$this->excel_count_row." rows<br>";
        echo "##################################################################<br>";

        $this->getSourceData();

    }

    public function getDataFromCSV(){

        $file = fopen(url('migrate_old_data__/'.$this->path_file),"r");

        $this->excel_count_row_all = count(file( url('migrate_old_data__/'.$this->path_file) ));

        if($this->excel_count_row_all < $this->start_upload){
            $this->start_upload = 0;
        }

        $no_count = 0;

        while( ( $data_original = fgetcsv($file, 100000, ",") ) !== FALSE && ( $no_count <= $this->end_upload ) ){
            if($no_count != 0 && $no_count != 1 && $no_count >= $this->start_upload){ // 0 = E T // 1 = field name
                $this->ExcelData[] = $data_original;
            }
            ++$no_count;

        }
        $this->excel_count_row = $no_count-3;

    }

    public function getSourceData(){

        $catalog_exist      = array();
        $reference_exist    = array();
        $no_locality        = array();
        $checkAllWrong      = array();
        $locality_exist     = array();
        $mrct_exist         = array();
        $source             = array();
        $catalog_number     = array();

        $no = 0;
        foreach ($this->ExcelData as $data_original) {

            //create list warning;
            $this->warning[$no] = array(
                                    'undefind_no_catalog' => false,
                                    'dubplicate_no_catalog' => false,
                                    'unknown_reference' => "",
                                    'unknown_country' => "",
                                    'unknown_province' => "",
                                    'unknown_district' => "",
                                    'unknown_county' => "",
                                    'unknown_marine_center' => "",
                                    'unknown_collection' => "",
                                    'dubplicate_taxo' => "",
                                    'dubplicate_taxo_name' => "",
                                    'dubplicate_taxo_id_in_db' => "",
                                    );

            $_iq                        = array_slice($data_original,48,1);
            $_type_status               = array_slice($data_original,52,2);
            $_ocen_sea_lake             = array_slice($data_original,64,2);
            $_gear_method               = array_slice($data_original,86,2);
            $_sex                       = array_slice($data_original,59,1);
            $_expendition               = array_slice($data_original,105,2);
            $_preparation               = array_slice($data_original,103,2);
            $_habitat                   = array_slice($data_original,84,2);
            $_lifestate                 = array_slice($data_original,62,2);
            $_donate_from               = array_slice($data_original,21,1);
            $_deposite_at               = array_slice($data_original,22,1);
            $_protection_type           = array_slice($data_original,143,1);
            $_area_direction            = array_slice($data_original,115,2);
            $_utility                   = array_slice($data_original,118,1);
            $_team_exploration          = array_slice($data_original,112,1);
            $_area_exploration          = array_slice($data_original,113,1);
            $_recorder                  = array_slice($data_original,120,1);
            $_animal1                   = array_slice($data_original,140,1);
            $_animal2                   = array_slice($data_original,141,1);
            $_animal3                   = array_slice($data_original,142,1);
            $_planttype                 = array_slice($data_original,139,1);

            $_collection                = array_slice($data_original,6,1);
            $_locality_state            = array_slice($data_original,66,8);
            $_mrct_institution          = array_slice($data_original,1,4);
            $_place                     = array_slice($data_original,137,1);
            $_reproduction              = array_slice($data_original,144,1);
            $_taxa                      = array_slice($data_original,26,22);
            $_ref                       = array_slice($data_original,12,1);
            $_soruce                    = $data_original[5];
            $_catalog_no                = $data_original[8];
            $_collection                = $data_original[6];
            $_mrct                      = $_mrct_institution[2];
            $_author                    = $data_original[24];
            $_publishyear               = $data_original[25];
            $_page                      = $data_original[13];
            $_nospecies                 = $data_original[15];

            $_collectorDate             = $data_original[91];
            $_identifierDate            = $data_original[96];
            $_previousIdentified        = $data_original[101];
            $_currentScritificName      = $data_original[23];
            $_previousScientificName    = $data_original[51];
            $_individualCount           = $data_original[58];

            $_latitude                  = $data_original[77];
            $_verbatim_latitude         = $data_original[76];
            $_start_latitude            = $data_original[78];
            $_end_latitude              = $data_original[79];
            $_longitude                 = $data_original[81];
            $_verbatim_longitude        = $data_original[80];
            $_start_longitude           = $data_original[82];
            $_end_longitude             = $data_original[83];

            $_depth_start               = $data_original[88];
            $_depth_end                 = $data_original[89];
            $_collector                 = $data_original[90];
            $_identifier                = $data_original[95];
            $_previous_identifier       = $data_original[100];
            $_note_collector            = $data_original[102];
            $_description               = $data_original[56];
            $_description_th			= $data_original[57];
            $_variety_name              = $data_original[49];
            $_variety_name_th 			= $data_original[50];
            $_locality                  = $data_original[74];
            $_locality_th				= $data_original[75];
            $_size                      = $data_original[60];
            $_gene_bank_number          = $data_original[107];
            $_diagnosis                 = $data_original[54];

            $_local_name 				= $data_original[109];
            $_vernacular_name 		    = $data_original[110];
            // $_common_name 				= $data_original[111]; //ย้ายไปไว้ที่ classification fluke - 19-4-2018
            $_village_no 				= $data_original[114];
            $_area 						= $data_original[117];
            $_folk_wisdom 				= $data_original[119];
            $_knowledge_remarks 		= $data_original[121];
            $_water_temperature 		= $data_original[125];
            $_transparency 				= $data_original[126];
            $_water_ph 					= $data_original[127];
            $_dissolve_oxygen 			= $data_original[128];
            $_suspended_solid 			= $data_original[129];
            $_salinity 					= $data_original[130];
            $_specimen_collection 		= $data_original[131];
            $_specimen_photograph 		= $data_original[132];

            $collection_exist[$no]      = $this->HeadcheckCollection($_collection);

            $collection_code_string[$no]     = Collection::getCollectionByID($collection_exist[$no]+1)->col_code;

            $locality_exist[$no]        = $this->HeadcheckLocality($_locality_state);
            $mrct_exist[$no]            = $this->HeadcheckMarineCenter($_mrct_institution);
            $mrct_code[$no]             = Marinecenter::getMarineCenterCode($mrct_exist[$no]+1)->toArray();
            ###### USE #######
            $checkWrong[1]              = $this->HeadcheckWording_Can_Add($_iq,1); //iq
            $checkWrong[2]              = $this->HeadcheckWording_Can_Add($_type_status,2); //type_status
            $checkWrong[3]              = $this->HeadcheckWording_Can_Add($_ocen_sea_lake,3); //ocen_sea_lake
            $checkWrong[4]              = $this->HeadcheckWording_Can_Add($_gear_method,4); //gear_method
            $checkWrong[5]              = $this->HeadcheckWording_Can_Add($_sex,5); //sex
            $checkWrong[6]              = $this->HeadcheckWording_Can_Add($_expendition,6); //expendition
            $checkWrong[7]              = $this->HeadcheckWording_Can_Add($_preparation,7); //preparation
            $checkWrong[8]              = $this->HeadcheckWording_Can_Add($_habitat,8); //habitat
            $checkWrong[9]              = $this->HeadcheckWording_Can_Add($_lifestate,9); //lifestate
            $checkWrong[10]             = $this->HeadcheckWording_Can_Add($_donate_from,10); //donate_from
            $checkWrong[11]             = $this->HeadcheckWording_Can_Add($_deposite_at,11); //deposite_at
            $checkWrong[12]             = $this->HeadcheckWording_Can_Add($_protection_type,12); //protection_type
            $checkWrong[13]             = $this->HeadcheckWording_Can_Add($_area_direction,13); //area_direction
            $checkWrong[14]             = $this->HeadcheckWording_Can_Add($_utility,14); //utility
            $checkWrong[15]             = $this->HeadcheckWording_Can_Add($_team_exploration,15); //team_exploration
            $checkWrong[16]             = $this->HeadcheckWording_Can_Add($_area_exploration,16); //area_exploration
            $checkWrong[17]             = $this->HeadcheckWording_Can_Add($_recorder,17); //recorder
            $checkWrong[18]             = $this->HeadcheckWording_Can_Add($_animal1,18); //animal1
            $checkWrong[19]             = $this->HeadcheckWording_Can_Add($_animal2,19); //animal2
            $checkWrong[20]             = $this->HeadcheckWording_Can_Add($_animal3,20); //animal3
            $checkWrong[21]             = $this->HeadcheckWording_Can_Add($_planttype,21); //planttype

            $place[$no]                 = $this->HeadcheckPlace( $_place )+1;
            $reproduction[$no]          = $this->HeadcheckReproduction( $_reproduction )+1;

            list($error_taxo[$no], $data_taxo_check[$no]) = $this->HeadCheckTaxonomy_From_Excel( $_taxa );

            if(ucfirst( $_soruce ) == "Specimen"){
                if($_catalog_no === ""){
                    $this->warning[$no]['undefind_no_catalog'] = true;
                }
                $catalog_exist[$no]      = $this->HeadcheckCatalogNoIsEmpty($_mrct, $_catalog_no);

                if($catalog_exist[$no] === true && $_catalog_no !== ""){
                    $_no = $no+3;
                    $this->migrateLog($this->path_file, $this->excel_count_row, true); // Log
                    dd("Dubplicate Catalog No. in Excel at row : ".$_no);
                    $this->warning[$no]['dubplicate_no_catalog'] = true;
                }elseif( $catalog_exist[$no] === false  && $_catalog_no !== ""){
                    $catalog_number[$no]    = $_catalog_no;
                    $source[$no]            = 1;
                    $reference[$no]         = "";
                    $page[$no]              = "";
                    $no_species[$no]        = "";
                    $no_locality[$no]       = "";
                }


            }
            elseif(ucfirst( $_soruce ) == "Publication"){
                $reference_exist[$no]    = $this->HeadcheckReference( $_ref );
                if($reference_exist[$no] === false){
                    $_no = $no+3;
                    $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                    dd("Unknown Reference in Excel at row : ".$_no);
                    $this->warning[$no]['unknown_reference'] = $data_original[11];
                }else{
                    $catalog_number[$no]    = "";
                    $reference[$no]         = $reference_exist[$no]+1;
                    $source[$no]            = 2;
                    $page[$no]              = $_page;
                    $no_species[$no]        = $_nospecies;
                    $no_locality[$no]       = $this->HeadcheckNoLocalityIsEmpty($_mrct, $reference_exist[$no]+1, $_page, $_nospecies);
                }

            }else{
                $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                // echo "** Error : Wrong Source **".$no;
                // exit;

                $catalog_number[$no] = 1;
                $source[$no] = 1;
                $reference[$no] = "";

            }

            if($locality_exist[$no][0] === false){
                $this->warning[$no]['unknown_country']  = $_locality_state[1];
            }

            if($locality_exist[$no][1] === false){
                $this->warning[$no]['unknown_province'] = $_locality_state[3];
            }

            if($locality_exist[$no][2] === false){
                $this->warning[$no]['unknown_district'] = $_locality_state[5];
            }

            if($locality_exist[$no][3] === false){
                $this->warning[$no]['unknown_county']   = $_locality_state[7];
            }

            if($mrct_exist[$no][0]){
                $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                $this->warning[$no]['unknown_marine_center'] = $data_original[1];
            }

            if($collection_exist[$no] === false){
                $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                $this->error_catch_check_collection = $this->error_catch_check_collection && false;
                $this->warning[$no]['unknown_collection'] = $_collection;
            }


            $classification_data[$no] = array($_currentScritificName,   //current_scritific_name
                                        $checkWrong[1],             //
                                        $_previousScientificName,         //Previous Scientific_name
                                        $_author,         //scientific_name_auther
                                        $_publishyear);        //published_year

            $collector_date             = $this->convertData( $_collectorDate );
            $identifier_date            = $this->convertData( $_identifierDate );
            $previous_identified        = $this->convertData( $_previousIdentified );

            if($_latitude == ""){
		        $_latitude = $this->readVerbatim($_verbatim_latitude);
            }

            if($_latitude == ""){
                $_longitude = $this->readVerbatim($_verbatim_longitude);
            }


            for($lang_record = 1; $lang_record <= 2; $lang_record++){
                $record_data[$no][$lang_record] = array(
                    'id_class'              => "",
                    'language_id'           => $lang_record,
                    'marinecenter_id'       => $mrct_exist[$no]+1,
                    'collection_code'       => $collection_exist[$no]+1,
                    'source'                => $source[$no],
                    'catalog_number'        => $catalog_number[$no],
                    'related_catalog_item'  => "",
                    'reference'             => $reference[$no],
                    'page'                  => $page[$no],
                    'no_species'            => $no_species[$no],
                    'no_locality'           => $no_locality[$no],
                    'related_reference_item' => "",
                    'individual_count'      => $_individualCount,
                    'latitude'              => $_latitude,
                    'verbatim_latitude'     => $_verbatim_latitude,
                    'start_latitude'        => $_start_latitude,
                    'end_latitude'          => $_end_latitude,
                    'longitude'             => $_longitude,
                    'verbatim_longitude'    => $_verbatim_longitude,
                    'start_longitude'       => $_start_longitude,
                    'end_longitude'         => $_end_longitude,
                    'country'               => $locality_exist[$no][0],
                    'province'              => $locality_exist[$no][1],
                    'district'              => $locality_exist[$no][2],
                    'county'                => $locality_exist[$no][3],
                    'ocean_sea_lake'        => $checkWrong[3],
                    'habitat'               => $checkWrong[8],
                    'type_status'           => $checkWrong[2],
                    'sex'                   => $checkWrong[5],
                    'life_stage'            => $checkWrong[9],
                    'donated_from'          => $checkWrong[10],
                    'deposited_at'          => $checkWrong[11],
                    'gear_method'           => $checkWrong[4],
                    'depth_start'           => $_depth_start,
                    'depth_end'             => $_depth_end,
                    'collector'             => $_collector,
                    'collected_date'        => $collector_date[2]."-".$collector_date[0]."-".$collector_date[1],
                    'collected_year'        => $collector_date[2],
                    'collected_month'       => $collector_date[0],
                    'collected_day'         => $collector_date[1],
                    'identifier'            => $_identifier,
                    'identified_date'       => $identifier_date[2]."-".$identifier_date[0]."-".$identifier_date[1],
                    'identified_year'       => $identifier_date[2],
                    'identified_month'      => $identifier_date[0],
                    'identified_day'        => $identifier_date[1],
                    'previous_identifier'   => $_previous_identifier,
                    'previous_identified_date' => $previous_identified[2]."-".$previous_identified[0]."-".$previous_identified[1],
                    'note_collector'        => $_note_collector,
                    'expedition'            => $checkWrong[6],
                    'preparation_type'      => $checkWrong[7],
                    'description'           => $_description,
                    'description_th'		=> $_description_th,
                    'variety_name'          => $_variety_name,
                    'variety_name_th' 		=> $_variety_name_th,
                    'locality'              => $_locality,
                    'locality_th'	        => $_locality_th,
                    'size'                  => $_size,
                    'gene_bank_number'      => $_gene_bank_number,
                    'diagnosis'             => $_diagnosis,

                    'local_name' 				 => "",  //
                    'vernacular_name'            => "", //
                    // 'common_name' 		         => "", //
                    'team_exploration_code' 	 => "", //
                    'area_exploration' 			 => "", //
                    'village_no' 				 => "", //
                    'area_direction' 			 => "",
                    'area' 						 => "", //
                    'utilization' 				 => "", //
                    'recorder' 					 => "", //
                    'folk_wisdom' 				 => "", //
                    'knowledge_remarks' 		 => "", //
                    'water_temperature' 		 => "", //
                    'transparency' 				 => "", //
                    'water_ph' 					 => "", //
                    'dissolve_oxygen' 			 => "", //
                    'suspended_solid' 			 => "", //
                    'salinity' 					 => "", //
                    'specimen_collection' 		 => "", //
                    'specimen_photograph' 		 => "", //
                    'water_place' 				 => "", //
                    'tree_place' 				 => "", //
                    'soil_earth_place' 			 => "", //
                    'ground_earth_place' 		 => "", //
                    'coast_place' 				 => "", //
                    'plant_type' 				 => $checkWrong[21],
                    'animal_type1' 				 => $checkWrong[18],
                    'animal_type2' 				 => $checkWrong[19],
                    'animal_type3' 				 => $checkWrong[20],
                    'protection_type' 			 => "", //
                    'reproduction' 				 => "" //
                );

            }
            $no++;
        }

        $id_taxo_for_add_class = $this->addTaxoEvenThough($error_taxo, $data_taxo_check);

        $this->ShowError();

        if($this->error_catch_check_collection === false){
            $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
            $this->migrateLog($this->path_file, $this->excel_count_row, true); //Log
            echo "<h2><font style='color:red;'>Please check Collection in migration file ".$this->path_file."</font></h2>";
            echo "<br>";
            echo "<a href=".url('staff/migdata/addfile').">Back to Uploadfile</a>";
            exit;
        }

        if($this->error_catch_check_taxo  === false){
            $this->migrateLog($this->path_file, $this->excel_count_row, true); //Log
            echo "<h2><font style='color:red;'>Please check Taxonomy in migration file ".$this->path_file."</font></h2>";
            echo "<br>";
            echo "<a href=".url('staff/migdata/addfile').">Back to Uploadfile</a>";
            exit;
        }

        for($no_record = 0; $no_record < $no; $no_record++){
                if( isset($catalog_exist[$no_record]) && $this->allowAddClassification){
                    # if exist catalog

                    if( !$error_taxo[$no_record] && $collection_exist[$no_record]){
                        # add class
                        # get class id
                        # set related catalog
                        $id_class = $this->addClass($classification_data[$no_record], $mrct_exist[$no_record]+1, $catalog_exist[$no_record] , false ,$id_taxo_for_add_class[$no_record]);
                        $related_catalog_item = $this->CreateRelatedCatalog($source[$no_record], $mrct_code[$no_record][0], $collection_code_string[$no_record], $catalog_number[$no_record]);

                        $record_data[$no_record][1]['id_class'] = $id_class;
                        $record_data[$no_record][1]['related_catalog_item'] = $related_catalog_item;

                        $record_data[$no_record][2]['id_class'] = $id_class;
                        $record_data[$no_record][2]['related_catalog_item'] = $related_catalog_item;

                    }
                }elseif( isset($reference_exist[$no_record]) && $this->allowAddClassification){
                    # if exist reference
                    if( !$error_taxo[$no_record] && $collection_exist[$no_record]){

                        # add class
                        # get class id
                        # set related Ref
                        $id_class = $this->addClass($classification_data[$no_record], $mrct_exist[$no_record]+1, false , $reference_exist[$no_record] ,$id_taxo_for_add_class[$no_record]);
                        $related_reference_item = $this->CreateRelatedReference($source[$no_record], $mrct_code[$no_record][0], $collection_code_string[$no_record], $reference[$no_record], $page[$no_record], $no_species[$no_record], $no_locality[$no_record] );
                        $record_data[$no_record][1]['id_class'] = $id_class;
                        $record_data[$no_record][1]['related_reference_item'] = $related_reference_item;

                        $record_data[$no_record][2]['id_class'] = $id_class;
                        $record_data[$no_record][2]['related_reference_item'] = $related_reference_item;
                    }
                }else{
                    echo "<h3><font style='color:red;'>Migrate Add Classification Function was turn off !!.</font></h3>";

                }

        }

        $this->check_record_valid($record_data);

        if($this->error_catch_check_record){
            if ($this->allowAddRecord) {
                $this->addRecord( $record_data );
            }else{
                echo "<h3><font style='color:red;'>Migrate Add Record Function was turn off !!.</font></h3>";
            }
        }else{
            $this->migrateLog($this->path_file, $this->excel_count_row, true);
            echo "<h2><font style='color:red;'>Please check Classification in migration file ".$this->path_file."</font></h2>";
            exit;
        }

        $this->migrateLog($this->path_file, $this->excel_count_row, $this->error_catch_check_migrate);

    }

    #-------------- Taxonomy Zone -------------#
    public function addTaxoIfNotDuplicate($error_taxo, $data_taxo_check){
        $no_add_taxo = 0;
        foreach ($error_taxo as $error_taxos) {
            if($error_taxos){
                $no_taxo = 0;
                foreach ($data_taxo_check[$no_add_taxo] as $value) {
                    if( $value['can_add'] === false){
                        $this->error_catch_check_taxo = $this->error_catch_check_taxo && false;
                        $this->warning[$no_add_taxo]['dubplicate_taxo'] = $this->header_taxo[$no_taxo];
                        $this->warning[$no_add_taxo]['dubplicate_taxo_id_in_db'] = $this->header_taxo[ $value['header_taxo_in_db']-1 ];
                        $this->warning[$no_add_taxo]['dubplicate_taxo_name'] = $value['name_taxo'];
                        $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                    }
                    $no_taxo += 1;
                }
                $id_taxo_for_add_class[$no_add_taxo] = false;
            }else{
                $id_taxo_for_add_class[$no_add_taxo] = $this->addTaxo($data_taxo_check[$no_add_taxo], $no_add_taxo);
            }
            $no_add_taxo += 1;
        }

        return $id_taxo_for_add_class;
    }

    public function addTaxoEvenThough($error_taxo, $data_taxo_check){
        $no_add_taxo = 0;
        foreach ($error_taxo as $error_taxos) {
            $id_taxo_for_add_class[$no_add_taxo] = $this->addTaxo($data_taxo_check[$no_add_taxo], $no_add_taxo);
            $no_add_taxo += 1;
        }

        return $id_taxo_for_add_class;
    }

    public function HeadCheckTaxonomy_From_Excel($taxonommy_name){

        $id_taxonomy = array();
        $map_pass_taxonomy = array();
        $data_exists = array();

        //defind array for check
        $count_header_taxo = 0;
        foreach($taxonommy_name as $taxo_name){
            if( !in_array($count_header_taxo+1,[20,21,22]) ){
                $taxa_name = ucfirst($taxo_name);
            }

            $map_pass_taxonomy[] = array('name' => $taxo_name,
                                        'header_taxo' => $this->header_taxo[$count_header_taxo] ,
                                        'header_taxo_id' => $count_header_taxo+1
                                    );
            $count_header_taxo += 1;
        }

        list($map_pass_taxonomy, $data_by_taxo_name) = $this->checkTaxonomyInRowExcel_via_DB($map_pass_taxonomy);
        $data_by_taxo_name = $this->fullfillMissingTaxonomy($data_by_taxo_name);
        $data_by_taxo_name = json_decode(json_encode($data_by_taxo_name)); // convert attribute and index array
        $data_exists = $this->checkTaxonomyCanAdd($map_pass_taxonomy, $data_by_taxo_name);

        $import_check = in_array( false, array_column($data_exists, 'can_add'));

        return array($import_check, $data_exists);
    }

    public function checkTaxonomyInRowExcel_via_DB($map_pass_taxonomy){
        //check series taxonomy
        $count_taxo_series = 0;
        $data_by_taxo_name = "";
        foreach ($map_pass_taxonomy as $taxo_series) {
            if($taxo_series['name'] != ""){
                $map_pass_taxonomy[$count_taxo_series]['blank_data'] = false;
                list($size_data, $data_by_taxo_name[$count_taxo_series]) = $this->getExistTaxonomyName( $taxo_series['name'], $taxo_series['header_taxo_id'] );
            }

            $count_taxo_series += 1;
        }
        return array($map_pass_taxonomy, $data_by_taxo_name);
    }

    public function fullfillMissingTaxonomy($data_by_taxo_name){
        for( $i = 0; $i <= 21 ; $i++ ) {
            if(!isset($data_by_taxo_name[$i]) || sizeof($data_by_taxo_name[$i]) == 0){
                $data_by_taxo_name[$i] = array(
                                            array(
                                                    'id' => "0",
                                                    'name' => "",
                                                    'header_taxonomy_id' => "0",
                                                    'status' => "2",
                                                    'created_by' => "1",
                                                    'updated_by' => "1",
                                                    'created_at' => "0000-00-10 00:00:00",
                                                    'updated_at' => "0000-00-10 00:00:00"
                                            )
                                        );
            }
        }

        ksort($data_by_taxo_name);
        return $data_by_taxo_name;
    }

    // to check taxonomy header in db and excel it same or not ?
    // if same parameter can_add will be true
    // if not same can_add will be false at each taxo
    public function checkTaxonomyCanAdd($map_pass_taxonomy, $data_by_taxo_name){

        for( $count_taxo_series2 = 0; $count_taxo_series2 <= 21; $count_taxo_series2++ ){

            $taxo_list_get_from_excel = $map_pass_taxonomy[$count_taxo_series2]['header_taxo_id'];
            ///// Example Data that get from excel /////
            // "name" => "Curtipleon"
            // "header_taxo" => "Genus"
            // "header_taxo_id" => 19
            // "blank_data" => false

            $taxo_id_in_db = $data_by_taxo_name[$count_taxo_series2][0]->header_taxonomy_id;
            ///// Example Data that get from DB /////
            // +"id": 574
            // +"name": "crustacea"
            // +"header_taxonomy_id": 21
            // +"status": 2
            // +"created_by": 1
            // +"updated_by": 1
            // +"created_at": "2016-08-15 04:00:58"
            // +"updated_at": "2016-08-15 04:00:58"

            $header_taxo_csv_compare_db = ( $taxo_list_get_from_excel == intval( $taxo_id_in_db ) ) ? true : false;
            //check taxonomy's header taxo id in excel field is same in db
            //// Example ////
            // Arthropoda in excel is in field Phylum
            // Arthropoda in db have header Phylum
            // it's will be true

            $can_add = ( $header_taxo_csv_compare_db || ( $taxo_id_in_db == "0" ) ? true : false );
            // then check if $header_taxo_csv_compare_db is true or taxo in excel is a new taxo ( = 0) will be true
            // that mean if $header_taxo_csv_compare_db is false becoz header id in excel and db is diff can_add will be false

            $data_exists[] = array('name_taxo' => $map_pass_taxonomy[$count_taxo_series2]['name'],
                                'id_taxo' => $data_by_taxo_name[$count_taxo_series2][0]->id,
                                'header_taxo_in_csv' => $taxo_list_get_from_excel,
                                'header_taxo_in_db' => $taxo_id_in_db,
                                'header_taxo_csv_compare_db' => $header_taxo_csv_compare_db,
                                'can_add' => $can_add //true or false
                            );
        }

        return $data_exists;
    }

    public function getExistTaxonomyName($UpperName, $header_taxo_id = ""){
        $sql = "select * from taxonomy where name = '$UpperName'";
        if($header_taxo_id != ""){
            $sql .= " and header_taxonomy_id = '$header_taxo_id'";
        }

        $results_check_exist_taxonomy = DB::select($sql);
        return array( sizeof($results_check_exist_taxonomy), $results_check_exist_taxonomy );

    }

    #-------------------------------------------#


    #------------- Alert  Zone -----------------#
    public function TextAlert($str){
        return "<br><font style='color:red;'>".$str."</font> ";
    }

    public function TextWarning($str){
        return "<br><font style='color:#ffc34d;'>".$str."</font> ";
    }

    public function ShowError(){
        // dd($this->warning);
        $stop_migrate = false;
        echo "---------------------------------------------------------------------<br>";
        for($count_show_error = 0; $count_show_error < sizeof($this->warning); $count_show_error++){

            if($this->start_upload > 150){
                $realRowExcel = $count_show_error+$this->start_upload;
            }else{
                $realRowExcel = $count_show_error+3+$this->start_upload;
            }
            echo "Row in Excel : ".$realRowExcel."<br>";

            if($this->warning[$count_show_error]['undefind_no_catalog']){
                echo $this->TextAlert("** Error : Undefind Catalog No");
            }

            if($this->warning[$count_show_error]['dubplicate_no_catalog']){
                echo $this->TextAlert("** Error : Duplicate Catalog Number at row");
                $stop_migrate = $stop_migrate && true;
            }

            if($this->warning[$count_show_error]['unknown_reference'] !== ""){
                echo $this->TextAlert("** Error : Undefind Reference Name at row");
                $stop_migrate = $stop_migrate && true;
            }

            if($this->warning[$count_show_error]['unknown_country'] !== ""){
                echo $this->TextAlert("** Error : Undefind Country : ".$this->warning[$count_show_error]['unknown_country']);
            }

            if($this->warning[$count_show_error]['unknown_province'] !== ""){
                echo $this->TextWarning("** warning : Undefind Province : ".$this->warning[$count_show_error]['unknown_province']);
            }

            if($this->warning[$count_show_error]['unknown_district'] !== ""){
                echo $this->TextWarning("** warning : Undefind District : ".$this->warning[$count_show_error]['unknown_district']);
            }

            if($this->warning[$count_show_error]['unknown_county'] !== ""){
                echo $this->TextWarning("** warning : Undefind County : ".$this->warning[$count_show_error]['unknown_county']);
            }

            if($this->warning[$count_show_error]['unknown_marine_center'] !== ""){
                echo $this->TextAlert("** Error : Undefind Marine Center Name : ".$this->warning[$count_show_error]['unknown_marine_center']);
                $stop_migrate = $stop_migrate && true;
            }

            if($this->warning[$count_show_error]['unknown_collection'] !== ""){
                echo $this->TextAlert("** Error : Undefind Collection Name : ".$this->warning[$count_show_error]['unknown_collection']);
                $stop_migrate = $stop_migrate && true;
            }

            if($this->warning[$count_show_error]['dubplicate_taxo'] !== ""){
                echo $this->TextAlert("** Error : Duplicate Taxonomy in Column : ".$this->warning[$count_show_error]['dubplicate_taxo']."; because Taxonomy Name: [ ".$this->warning[$count_show_error]['dubplicate_taxo_name']." ] already in ".$this->warning[$count_show_error]['dubplicate_taxo_id_in_db']);
                $stop_migrate = $stop_migrate && true;
            }

            echo "<br><br>---------------------------------------------------------------------<br>";
        }

    }

    #-------------------------------------------#

    #-------------- Convert Zone ---------------#
    public function readVerbatim($verbatim){
        if($verbatim !== ""){
            $dms = explode(" ",$verbatim);
            $dms[0] = str_replace('°', '', $dms[0]);
            $dms[1] = substr($dms[1], 0, -1);
            $dms[2] = substr($dms[2], 0, -1);
            return AllMean::dmstodecimal($dms[0],$dms[1],$dms[2]);
        }else{
            return "";
        }
    }

    public function convertData($date){
        if(sizeof($date) != 0 && $date != ""){
            $new_date_format = explode("/",$date);
        }else{
            $new_date_format = explode("-","00-00-0000");
        }

        return $new_date_format;
    }

    public function convertUnderScore($string){
        $merge_string = "";
        $arr_string = explode(" ",$string);

        foreach ($arr_string as $value) {
            if( strpos($value,"_") !== false){
                $value = str_replace("_","<i>",$value);

                if( strpos($value,")") !== false ){
                    $value = rtrim($value, ")");
                    $value .= "</i>)";
                }else{
                    $value .= "</i>";
                }

            }
            $merge_string .= $value." ";
        }
        return $merge_string;
    }

    #-------------------------------------------#

    #--------------- Check Data before Add Zone --------#
    public function check_record_valid($record_data){
        $this->error_catch_check_record = true;
        foreach ($record_data as $value) {
            try{
                // dd($value[1]['id_class']);
                isset($value[1]['id_class']);
                $value[1]['marinecenter_id'];
                $value[1]['marinecenter_id'];
                $value[1]['collection_code'];
                $value[1]['source'];
                $value[1]['catalog_number'];
                $value[1]['related_catalog_item'];
                $value[1]['reference'];
                $value[1]['page'];
                $value[1]['no_species'];
                $value[1]['no_locality'];
                $value[1]['related_reference_item'];
                $value[1]['individual_count'];
                $value[1]['latitude'];
                $value[1]['verbatim_latitude'];
                $value[1]['start_latitude'];
                $value[1]['end_latitude'];
                $value[1]['longitude'];
                $value[1]['verbatim_longitude'];
                $value[1]['start_longitude'];
                $value[1]['end_longitude'];
                $value[1]['country'];
                $value[1]['province'];
                $value[1]['district'];
                $value[1]['county'];
                $value[1]['ocean_sea_lake'];
                $value[1]['habitat'];
                $value[1]['type_status'];
                $value[1]['sex'];
                $value[1]['life_stage'];
                $value[1]['donated_from'];
                $value[1]['deposited_at'];
                $value[1]['gear_method'];
                $value[1]['depth_start'];
                $value[1]['depth_end'];
                $value[1]['collector'];
                $value[1]['collected_date'];
                $value[1]['collected_year'];
                $value[1]['collected_month'];
                $value[1]['collected_day'];
                $value[1]['identifier'];
                $value[1]['identified_date'];
                $value[1]['identified_year'];
                $value[1]['identified_month'];
                $value[1]['identified_day'];
                $value[1]['previous_identifier'];
                $value[1]['previous_identified_date'];
                $value[1]['note_collector'];
                $value[1]['expedition'];
                $value[1]['preparation_type'];
                $value[1]['diagnosis'];
                $value[1]['variety_name']; ////
                $value[1]['variety_name_th']; /////
                $value[1]['description']; ///////
                $value[1]['description_th']; /////
                $value[1]['locality']; ////
                $value[1]['locality_th']; /////
                $value[1]['size']; ////
                $value[1]['gene_bank_number']; ///////

                $value[1]['local_name'];
                $value[1]['vernacular_name'];
                $value[1]['common_name'];
                $value[1]['team_exploration_code'];
                $value[1]['area_exploration'];
                $value[1]['village_no'];
                $value[1]['area_direction'];
                $value[1]['area'];
                $value[1]['utilization'];
                $value[1]['recorder'];
                $value[1]['folk_wisdom'];
                $value[1]['knowledge_remarks'];
                $value[1]['water_temperature'];
                $value[1]['transparency'];
                $value[1]['water_ph'];
                $value[1]['dissolve_oxygen'];
                $value[1]['suspended_solid'];
                $value[1]['salinity'];
                $value[1]['specimen_collection'];
                $value[1]['specimen_photograph'];
                $value[1]['water_place'];
                $value[1]['tree_place'];
                $value[1]['soil_earth_place'];
                $value[1]['ground_earth_place'];
                $value[1]['coast_place'];
                $value[1]['plant_type'];
                $value[1]['animal_type1'];
                $value[1]['animal_type2'];
                $value[1]['animal_type3'];
                $value[1]['protection_type'];
                $value[1]['reproduction'];
            }catch( \Exception $e ){
                $this->error_catch_check_record = false;
                echo "Caught exception on checking data record : <b>".$e->getMessage()."</b><br/>";
            }
        }

    }

    #---------------------- Wording Zone  ----------------------#
    public function HeadcheckLocality($locality){

        if($locality[5] == "เมือง"){
            $new_district_en = $locality[4]." ".$locality[2];
            $new_district_th = $locality[5]."".$locality[3];
            $locality[5] = $new_district_th;
        }

        $country    = $this->checkExistCountry($locality[1]);
        $province   = $this->checkExistProvince($locality[3]);
        $district   = $this->checkExistDistrict($locality[5]);
        $county     = $this->checkExistCounty($locality[7]);


        if($country !== false){
            $country += 1;
        }

        if($province !== false){
            $province += 1;
        }

        if($district !== false){
            $district += 1;
        }

        if($county !== false){
            $county += 1;
        }

        return array($country, $province, $district, $county);
    }

    public function checkExistCountry($country_th){
        return array_search(trim($country_th), $this->country );
    }
    public function checkExistProvince($province_th){
        return array_search( trim($province_th), $this->province );
    }

    public function checkExistDistrict($district_th){
        return array_search( trim($district_th), $this->district );
    }

    public function checkExistCounty($county_th){
        return array_search( trim($county_th), $this->county );
    }

    public function HeadcheckMarineCenter($mrct){
        // echo in_array($mrct[2], array_values($this->marinecenter) ) ? 'true ' : 'false ';
        return array_search( trim($mrct[2]), array_values($this->marinecenter) );
    }

    public function HeadcheckSource($source){
        // echo in_array($source[0], array_values($this->source) ) ? 'true ' : 'false ';

        return in_array( trim($source[0]) , array_values($this->source) );
    }

    public function HeadcheckCollection($collection){
        // dd( array_search( trim($collection) , $this->collection ) );
        // echo in_array($collection[0], array_values($this->collection) ) ? 'true ' : 'false ';
        return array_search( trim($collection) , $this->collection );
    }

    public function HeadcheckReference($reference){
        // echo in_array($reference[0], array_values($this->reference) ) ? 'true ' : 'false ';
        return array_search( trim($reference[0]), $this->reference );
    }

    public function HeadcheckPlace($place){
        // echo in_array($place[0], array_values($this->place) ) ? 'true ' : 'false ';
        return array_search($place[0], array_values($this->place) );
    }

    public function HeadcheckReproduction($reproduction){
        // echo in_array($reproduction[0], array_values($this->reprodunction) ) ? 'true ' : 'false ';
        return array_search($reproduction[0], array_values($this->reprodunction) );
    }

    public function HeadcheckWording($wording,$lang,$dbdata){

        if($lang == 'en'){
            $index_wording = 0;
            $column = 'name_en';
        }elseif($lang == 'th'){
            $index_wording = 1;
            $column = 'name_th';
        }

        return in_array($wording[$index_wording], array_column( $dbdata, $column) );

    }

    public function HeadcheckCatalogNoIsEmpty($mrct, $cat){
        $results = DB::select("select * from record r, marinecenter m where m.id = r.marinecenter_id and r.catalog_number = '$cat' and m.marinecenter like '$mrct' " );
        if(sizeof($results) == 0){
            return false;
        }else{
            return true;
        }
    }

    public function HeadcheckNoLocalityIsEmpty($mrct, $reference, $page, $species){
        // $ref = Reference::getReferenceByID($reference)->ref_code;
        $results = DB::select("select * from record r, marinecenter m, reference rf where m.id = r.marinecenter_id and m.marinecenter like '$mrct' and rf.id = '$reference' and r.reference = rf.id and r.page = '$page' and r.no_species = '$species' order by r.created_by limit 0,1");
        // echo "select * from record r, marinecenter m, reference rf where m.id = r.marinecenter_id and m.marinecenter like '$mrct' and rf.id = '$reference' and r.reference = rf.id and r.page = '$page' and r.no_species = '$species' order by r.created_by limit 0,1";
        if(sizeof($results) == 0){
            return 1;
        }else{
            return $results[0]->no_locality+1;
        }
    }

    #--------------------------------------------------------#

    #-------------------- Add Zone -------------------#
    public function HeadcheckWording_Can_Add($wording , $wording_type){
        $tmp_wording = array();
        if( $wording[0] !== "" ){

            if( sizeof($wording) == 1){
                $tmp_wording[0] = trim($wording[0]);
                $tmp_wording[1] = trim($wording[0]);
            }else{
                $tmp_wording[0] = trim($wording[0]);
                $tmp_wording[1] = trim($wording[1]);
            }

            $result_wording = DB::select("select * from wording where name_en = '$tmp_wording[0]' and name_th = '$tmp_wording[1]' and wording_type_id = '$wording_type'");
            if( sizeof($result_wording) == 0 ){
                // return "true";
                $last_id_Wording_Add = Wording::addWording($wording_type, $tmp_wording[0], $tmp_wording[1] );
                return $last_id_Wording_Add;
            }else{
                return $result_wording[0]->id;
            }

        }else{
            //case wording form excel dony' have text
            return 0;
        }

    }

    public function CreateRelatedCatalog($source, $marinecenter_code, $collection_code_string, $catalog_number){

        $related_catalog_item = $marinecenter_code."-".$source."-".$collection_code_string."-".$catalog_number;

        return $related_catalog_item;
    }

    public function CreateRelatedReference($source, $marinecenter_code, $collection_code_string, $reference, $page, $no_species, $no_locality){
        $reference_string = Reference::getReferenceByID($reference)->ref_code;
        $related_reference_item = $marinecenter_code."-".$source."-".$collection_code_string."-".$reference_string."-".$page."-".$no_species."-".$no_locality;

        return $related_reference_item;
    }

    public function addTaxo($data_taxo_check, $no_add_taxo){
        $allNewIdTaxo = array();
        $no_allNewIdTaxo = 0;
        foreach ($data_taxo_check as $value) {
            list($size_exist, $full_info) = $this->getExistTaxonomyName($value['name_taxo'], $value['header_taxo_in_csv']);

            if( $size_exist == 0 && $value['header_taxo_in_db'] == 0 && $value['id_taxo'] == 0 && $value['name_taxo'] != ""){

                $allNewIdTaxo[$no_allNewIdTaxo] = Taxonomy::addTaxonomy($value['header_taxo_in_csv'], $value['name_taxo']);
                Session::forget('exception_catcher');

            }elseif( $value['header_taxo_in_db'] != 0){

                $allNewIdTaxo[$no_allNewIdTaxo] = $value['id_taxo'];

            }elseif($value['name_taxo'] == ""){

                $allNewIdTaxo[$no_allNewIdTaxo] = 0;

            }elseif($size_exist != 0){

                // TODO:
                # 1. check taxonomy is same header_taxonomy
                # 1.1. if same header_taxonomy get id $full_info[0]->id
                # 1.2. if not same header_taxonomy exit;
                // dd($full_info[0]);
                if( $full_info[0]->header_taxonomy_id != $no_allNewIdTaxo+1 ){
                    $no_add_taxo += 3;
                    $this->migrateLog($this->path_file, $this->excel_count_row, true);
                    dd("Incorrect Header Taxonomy at row : ".$no_add_taxo." Column Taxa: ".($no_allNewIdTaxo+1)." Name: ".$full_info[0]->name);
                }else{
                    $allNewIdTaxo[$no_allNewIdTaxo] = $full_info[0]->id;
                }

            }
            $no_allNewIdTaxo += 1;
        }
        echo "- Taxonomy at <span style='color:blue;'>row ".($no_add_taxo+3)."</span> in excel was migrate.<br>";
        return $allNewIdTaxo;
    }

    public function addClass($classification_data, $mrct_exist, $catalog_exist = true, $reference_exist = true, $id_taxo_for_add_class){
        #classification add

        $id_class = "";
        $result_duplicate = Classification::CheckDuplicateClassification($classification_data[0]);

        if(sizeof($result_duplicate) === 0){
            if( $mrct_exist && ( !$catalog_exist || !$reference_exist ) ){

                // $cur_sci_name       = $classification_data[0];
                $cur_sci_name       = $this->convertUnderScore($classification_data[0]);
                $iq                 = $classification_data[1];
                $pre_sci_name       = $this->convertUnderScore($classification_data[2]);
                $pre_sci_name       = $classification_data[2];
                // $sci_name_author    = $classification_data[3];
                // $published_year     = $classification_data[4];
                $domain             = $id_taxo_for_add_class[0];
                $kingdom            = $id_taxo_for_add_class[1];
                $subkingdom         = $id_taxo_for_add_class[2];
                $infrakingdom       = $id_taxo_for_add_class[3];
                $phylum             = $id_taxo_for_add_class[4];
                $subphylum          = $id_taxo_for_add_class[5];
                $infraphylum        = $id_taxo_for_add_class[6];
                $superclass         = $id_taxo_for_add_class[7];
                $class              = $id_taxo_for_add_class[8];
                $subclass           = $id_taxo_for_add_class[9];
                $infraclass         = $id_taxo_for_add_class[10];
                $superorder         = $id_taxo_for_add_class[11];
                $order_o            = $id_taxo_for_add_class[12];
                $suborder           = $id_taxo_for_add_class[13];
                $infraorder         = $id_taxo_for_add_class[14];
                $superfamily        = $id_taxo_for_add_class[15];
                $family             = $id_taxo_for_add_class[16];
                $subfamily          = $id_taxo_for_add_class[17];
                $genus              = $id_taxo_for_add_class[18];
                $subgenus           = $id_taxo_for_add_class[19];
                $species            = $id_taxo_for_add_class[20];
                $subspecies         = $id_taxo_for_add_class[21];

                $last_class_id = Classification::addClassification($cur_sci_name, $iq, $pre_sci_name, $domain, $kingdom, $subkingdom, $infrakingdom,$phylum, $subphylum, $infraphylum, $superclass, $class, $subclass,$infraclass, $superorder, $order_o, $suborder, $infraorder, $superfamily,$family, $subfamily, $genus, $subgenus, $species, $subspecies, $common_name, $protection_type, true);
                $exception_add_class = Session::get('exception_catcher');
                Session::forget('exception_catcher');
                if($exception_add_class){
                    // echo "class step";
                    $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                    echo $exception_add_class;
                    exit;
                }
                $id_class = $last_class_id;
            }
        }else{
            $id_class = $result_duplicate->id;
        }
        return $id_class;
    }

    public function addRecord($array_add_record){

        foreach ($array_add_record as $record) {
            $unique_records = Record::getLastUniqueRecord();

            if(is_null($unique_records)){
                $unique_record = 1;
            }else{
                $unique_record = $unique_records->unique_record+1;
            }

            for($lang = 1; $lang <= 2; $lang++){
                // dd($record);

                try{
                    $db = new Record;
                    $db->unique_record              = $unique_record;
                    $db->classification_id          = $record[$lang]['id_class'];
                    $db->language_id                = $lang;
                    $db->marinecenter_id            = $record[$lang]['marinecenter_id'];
                    $db->collection_code            = $record[$lang]['collection_code'];
                    $db->source                     = $record[$lang]['source'];
                    if( $record[$lang]['source'] == 1 ) {
                        $db->catalog_number         = $record[$lang]['catalog_number'];
                        $db->related_catalog_item   = $record[$lang]['related_catalog_item'];
                    } else {
                        $db->reference              = $record[$lang]['reference'];
                        $db->page                   = $record[$lang]['page'];
                        $db->no_species             = $record[$lang]['no_species'];
                        $db->no_locality            = $record[$lang]['no_locality'];
                        $db->related_reference_item = $record[$lang]['related_reference_item'];
                    }
                    $db->individual_count           = $record[$lang]['individual_count'];
                    $db->latitude                   = $record[$lang]['latitude'];
                    $db->verbatim_latitude          = $record[$lang]['verbatim_latitude'];
                    $db->start_latitude             = $record[$lang]['start_latitude'];
                    $db->end_latitude               = $record[$lang]['end_latitude'];
                    $db->longitude                  = $record[$lang]['longitude'];
                    $db->verbatim_longitude         = $record[$lang]['verbatim_longitude'];
                    $db->start_longitude            = $record[$lang]['start_longitude'];
                    $db->end_longitude              = $record[$lang]['end_longitude'];
                    $db->country                    = $record[$lang]['country'];
                    $db->province                   = $record[$lang]['province'];
                    $db->district                   = $record[$lang]['district'];
                    $db->county                     = $record[$lang]['county'];
                    $db->ocean_sea_lake             = $record[$lang]['ocean_sea_lake'];
                    $db->habitat                    = $record[$lang]['habitat'];
                    $db->type_status                = $record[$lang]['type_status'];
                    $db->sex                        = $record[$lang]['sex'];
                    $db->life_stage                 = $record[$lang]['life_stage'];
                    $db->donated_from               = $record[$lang]['donated_from'];
                    $db->deposited_at               = $record[$lang]['deposited_at'];
                    $db->gear_method                = $record[$lang]['gear_method'];
                    $db->depth_start                = $record[$lang]['depth_start'];
                    $db->depth_end                  = $record[$lang]['depth_end'];
                    $db->collector                  = $record[$lang]['collector'];
                    $db->collected_date             = $record[$lang]['collected_date'];
                    $db->collected_year             = $record[$lang]['collected_year'];
                    $db->collected_month            = $record[$lang]['collected_month'];
                    $db->collected_day              = $record[$lang]['collected_day'];
                    $db->identifier                 = $record[$lang]['identifier'];
                    $db->identified_date            = $record[$lang]['identified_date'];
                    $db->identified_year            = $record[$lang]['identified_year'];
                    $db->identified_month           = $record[$lang]['identified_month'];
                    $db->identified_day             = $record[$lang]['identified_day'];
                    $db->previous_identifier        = $record[$lang]['previous_identifier'];
                    $db->previous_identified_date   = $record[$lang]['previous_identified_date'];
                    $db->note_collector             = $record[$lang]['note_collector'];
                    $db->expedition                 = $record[$lang]['expedition'];
                    $db->preparation_type           = $record[$lang]['preparation_type'];
                    $db->diagnosis                  = $record[$lang]['diagnosis'];
                    $db->size                       = $record[$lang]['size'];
                    $db->gene_bank_number           = $record[$lang]['gene_bank_number'];

                    if($lang == 1 ){
                        $db->variety_name               = $record[$lang]['variety_name']; ////
                        $db->locality                   = $record[$lang]['locality']; ////
                        $db->description                = $record[$lang]['description']; ///////
                    }else{
                        $db->variety_name 				= $record[$lang]['variety_name_th']; /////
                        $db->locality					= $record[$lang]['locality_th']; /////
                        $db->description				= $record[$lang]['description_th']; /////

                        $db->local_name 				= $record[$lang]['local_name'];
                        $db->vernacular_name 			= $record[$lang]['vernacular_name'];
                        $db->common_name 				= $record[$lang]['common_name'];
                        $db->team_exploration_code 		= $record[$lang]['team_exploration_code'];
                        $db->area_exploration 			= $record[$lang]['area_exploration'];
                        $db->village_no 				= $record[$lang]['village_no'];
                        $db->area_direction 			= $record[$lang]['area_direction'];
                        $db->area 						= $record[$lang]['area'];
                        $db->utilization 				= $record[$lang]['utilization'];
                        $db->recorder 					= $record[$lang]['recorder'];
                        $db->folk_wisdom 				= $record[$lang]['folk_wisdom'];
                        $db->knowledge_remarks 			= $record[$lang]['knowledge_remarks'];
                        $db->water_temperature 			= $record[$lang]['water_temperature'];
                        $db->transparency 				= $record[$lang]['transparency'];
                        $db->water_ph 					= $record[$lang]['water_ph'];
                        $db->dissolve_oxygen 			= $record[$lang]['dissolve_oxygen'];
                        $db->suspended_solid 			= $record[$lang]['suspended_solid'];
                        $db->salinity 					= $record[$lang]['salinity'];
                        $db->specimen_collection 		= $record[$lang]['specimen_collection'];
                        $db->specimen_photograph 		= $record[$lang]['specimen_photograph'];
                        $db->water_place 				= $record[$lang]['water_place'];
                        $db->tree_place 				= $record[$lang]['tree_place'];
                        $db->soil_earth_place 			= $record[$lang]['soil_earth_place'];
                        $db->ground_earth_place 		= $record[$lang]['ground_earth_place'];
                        $db->coast_place 				= $record[$lang]['coast_place'];
                        $db->plant_type 				= $record[$lang]['plant_type'];
                        $db->animal_type1 				= $record[$lang]['animal_type1'];
                        $db->animal_type2 				= $record[$lang]['animal_type2'];
                        $db->animal_type3 				= $record[$lang]['animal_type3'];
                        $db->protection_type 			= $record[$lang]['protection_type'];
                        $db->reproduction 				= $record[$lang]['reproduction'];

                    }

                    $db->migration_data             = true;
                    $db->approve_status             = true;
                    $db->approve_by                 = Auth::user()->id;
                    $db->status                     = 2;
                    $db->created_by                 = Auth::user()->id;
                    $db->updated_by                 = Auth::user()->id;

                    $lastId[$lang] = CatchException::catcherAdd($db);
                    // TODO: add picture
                }catch( \Exception $e ){
                    $this->error_catch_check_migrate = $this->error_catch_check_migrate || true; //Log
                    echo "Caught exception on inserting to Database : <b>".$e->getMessage()."</b><br/>";
                }

            }
        }

        if(!$this->error_catch_check_migrate){
            echo "<h2><font style='color:green;'>Migrate file ".$this->path_file." Success!!.</font></h2>";
        }else{
            echo "<h2><font style='color:red;'>Can't Migrate file ".$this->path_file."</font></h2>";
        }

        echo "<a href=".url('staff/migdata/addfile').">Back to Uploadfile</a>";

    }

    public function migrateLog($filename, $row, $have_error){
        $log_migrate = File_Migrate_Log::addMigrateLog($filename, $row, $have_error );
        // echo $log_migrate;
        if($have_error === true){
            File::move( 'migrate_old_data__/'.$filename , 'migrate_old_data__/fail/'.$filename );
        }else{
            File::move( 'migrate_old_data__/'.$filename , 'migrate_old_data__/success/'.$filename );

        }
    }

    public function mapUnique_record_picture_record(){
        $str = "select r.id as record_id,
                r.unique_record,
                r.catalog_number,
                pp.id as picture_id
                from record r
                left join
                (
                	select id, SUBSTRING(path_pic, LOCATE('_', path_pic)+1, LOCATE('D', path_pic)-2 - LOCATE('_', path_pic)+1 ) as picture_catalog from picture p
                ) as pp on r.catalog_number = pp.picture_catalog
                where r.catalog_number in (
                	select SUBSTRING(path_pic, LOCATE('_', path_pic)+1, LOCATE('D', path_pic)-2 - LOCATE('_', path_pic)+1 ) as picture_catalog
                    from picture
                )
                and r.language_id = 1
                order by r.catalog_number";

        // $str = "select id, CONVERT( SUBSTRING(path_pic, LOCATE('_', path_pic)+1, LOCATE('D', path_pic)-2 - LOCATE('_', path_pic)+1 ) ,UNSIGNED INTEGER ) as picture_catalog from picture order by picture_catalog";

        $result_uniquerecords   = DB::select($str);

        // dd($result_uniquerecords);

        foreach($result_uniquerecords as $value){
            DB::update("update picture set unique_record = ? where id = ?", [$value->unique_record, $value->picture_id]);
        }

        echo "finish";

    }

}
