<?php

namespace App\Http\Controllers\Migration;

use Illuminate\Http\Request;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Wording;
use App\Model\Marinecenter;
use App\Model\Collection;
use App\Model\Reference;

class Migrate_check extends Controller
{
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
    // private $warning = array();

    // private $ExcelData = array();
    // private $excel_count_row = 0;
    // private $excel_count_row_all = 0;
    private $header_taxo =   array('Domain','Kingdom','Subkingdom','Infrakingdom','Phylum',
                        'Subphylum','Infraphylum','Superclass','Class','Subclass',
                        'Infraclass','Superorder','Order','Suborder','Infraorder',
                        'Superfamily','Family','Subfamily','Genus','Subgenus',
                        'Species','Subspecies');

    private $fullname = true;
    private $warning = [];
    private $hasError = true;


    public function __construct(){

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
        $this->iq                   = Wording::getWordingByWordingType(1)->toArray();
        $this->type_status          = Wording::getWordingByWordingType(2)->toArray();
        $this->ocean_sea_lake       = Wording::getWordingByWordingType(3)->toArray();
        $this->gear_method          = Wording::getWordingByWordingType(4)->toArray();
        $this->sex                  = Wording::getWordingByWordingType(5)->toArray();
        $this->expendition          = Wording::getWordingByWordingType(6)->toArray();
        $this->preparation          = Wording::getWordingByWordingType(7)->toArray();
        $this->habitat              = Wording::getWordingByWordingType(8)->toArray();
        $this->lifestate            = Wording::getWordingByWordingType(9)->toArray();
        $this->donate_from          = Wording::getWordingByWordingType(10)->toArray();
        $this->deposite_at          = Wording::getWordingByWordingType(11)->toArray();
        $this->protection_type      = Wording::getWordingByWordingType(12)->toArray();
        $this->area_direction       = Wording::getWordingByWordingType(13)->toArray();
        $this->utility              = Wording::getWordingByWordingType(14)->toArray();
        $this->team_exploration     = Wording::getWordingByWordingType(15)->toArray();
        $this->area_exploration     = Wording::getWordingByWordingType(16)->toArray();
        $this->recorder             = Wording::getWordingByWordingType(17)->toArray();
        $this->animal1              = Wording::getWordingByWordingType(18)->toArray();
        $this->animal2              = Wording::getWordingByWordingType(19)->toArray();
        $this->animal3              = Wording::getWordingByWordingType(20)->toArray();
        $this->planttype            = Wording::getWordingByWordingType(21)->toArray();

        $this->place                = array('แหล่งน้ำ','บนต้นไม้','หน้าดิน','ในดิน','ทะเล');
        $this->reprodunction        = array('อาศัยเพศ','ไม่อาศัยเพศ');

        $this->column_name          = array('Locality','Marinecenter','Collecion','Identification Qualifier',
                                        'Type_Status','Gear Method','Sex','Expendition-โครงการสำรวจ','Preparation-การเก็บรักษา','Habitat-ระบบนิเวศที่อาศัย',
                                        'Lifestate','Donate_from','Deposite_at','Protection_Type-การคุ้มครองสัตว์','Area_direction-สถานที่พบอยู่ทางทิศ',
                                        'Utility-การใช้ประโยชน์','team_exploration','area_exploration','Animal1-ประเภทสัตว์1','Animal2-ประเภทสัตว์2','Animal3-ประเภทสัตว์3',
                                        'Plant_Type-ประเภทของพืช','Place-ถิ่นอศัยที่พบ','reproduction-การสืบพันธ์');
    }

    public function index() {
        // $file = "1Agnatha21112559.csv";
        // $file = "2Cephalochordata21112559.csv";
        // $file = "3Condrichthyes21112559.csv";
        // $file = "4Mammalia21112559.csv";
        // $file = "5Osteichthyes21112559.csv";
        // $file = "6Squamata21112559.csv";
        // $file = "7Testudines21112559.csv";
        // $file = "8Urochordata21112559.csv";
        // $file = "9Cephalopoda27012560.csv";
        $file = "10Cephalopoda01082560.csv";



        if (($handle = fopen($file, "r")) !== FALSE) {
            $line = 1;
            while (($data_original = fgetcsv($handle, 10000, ",")) !== FALSE) {
                if($line > 1){
                    echo ($line-2)."<br>";
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
                    // $_protection_type           = array_slice($data_original,143,1); //ย้ายไปไว้ที่ classification fluke - 19-4-2018
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
                    ////////////////////////////////////////////////////////////////////////////////////////

                    $collection_exist           = $this->HeadcheckCollection($_collection);

                    $collection_code_string     = Collection::getCollectionByID($collection_exist+1)->col_code;
                    $locality_exist             = $this->HeadcheckLocality($_locality_state);
                    $mrct_exist                 = $this->HeadcheckMarineCenter($_mrct_institution);
                    $mrct_code                  = Marinecenter::getMarineCenterCode($mrct_exist+1)->toArray();

                    // ###### USE #######
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

                    $place                      = $this->HeadcheckPlace( $_place )+1;
                    $reproduction               = $this->HeadcheckReproduction( $_reproduction )+1;

                    list($error_taxo, $data_taxo_check) = $this->HeadCheckTaxonomy_From_Excel( $_taxa );

                    if($error_taxo){
                        foreach ($data_taxo_check as $value) {
                            if($value['can_add'] == false){
                                echo json_encode($value);
                            }
                        }
                        echo " - Wrong taxonomy: ".$value['header_taxo_in_csv']." => ".$value['name_taxo']."  ****<br>";
                    }

                    if(ucfirst( $_soruce ) == "Specimen"){
                        if($_catalog_no === ""){
                            $this->hasError = $this->hasError && false;
                            echo " - Non defind Catalog : ".$_catalog_no." **** <br>";
                        }
                        $catalog_exist      = $this->HeadcheckCatalogNoIsEmpty($_mrct, $_catalog_no);

                        if($catalog_exist === true && $_catalog_no !== ""){ // size > 0
                            $this->hasError = $this->hasError && false;
                            echo " - Duplicate Catalog : ".$_catalog_no." **** <br>";
                        }elseif( $catalog_exist === false  && $_catalog_no !== ""){  // size = 0

                        }
                    }
                    elseif(ucfirst( $_soruce ) == "Publication"){
                        $reference_exist    = $this->HeadcheckReference( $_ref );

                        if($reference_exist === false){
                            $this->hasError = $this->hasError && false;
                            echo " - Don't have Reference book : ".$_catalog_no." in DB **** <br>";
                        }else{
                            $no_locality       = $this->HeadcheckNoLocalityIsEmpty($_mrct, $reference_exist+1, $_page, $_nospecies);
                            echo $no_locality;
                        }

                    }else{
                        $this->hasError = $this->hasError && false;
                        echo " - Wrong Source : ".ucfirst( $_soruce )."<br>";

                    }

                    if($locality_exist[0] === false){
                        $this->hasError = $this->hasError && false;
                        echo " - undefine country : ".$_locality_state[1]." ****<br>";
                    }

                    if($locality_exist[1] === false){
                        echo " - undefine province : ".$_locality_state[3]."<br>";
                    }

                    if($locality_exist[2] === false){
                        echo " - undefine district : ".$_locality_state[5]."<br>";
                    }

                    if($locality_exist[3] === false){
                        echo " - undefine county : ".$_locality_state[7]."<br>";
                    }

                    if($data_original[1] === false){
                        $this->hasError = $this->hasError && false;
                        echo " - undefine marine center : ".$data_original[1]." **** <br>";
                    }

                    if($collection_exist === false){
                        $this->hasError = $this->hasError && false;
                        echo " - undefine collection : ".$_collection."  **** <br>";
                    }


                }
                ++$line;

            }
        }
    }


    #---------------------- Wording Zone  ----------------------#
    private function HeadcheckLocality($locality){

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

    private function checkExistCountry($country_th){
        return array_search(trim($country_th), $this->country );
    }

    private function checkExistProvince($province_th){
        return array_search( trim($province_th), $this->province );
    }

    private function checkExistDistrict($district_th){
        return array_search( trim($district_th), $this->district );
    }

    private function checkExistCounty($county_th){
        return array_search( trim($county_th), $this->county );
    }

    private function HeadcheckMarineCenter($mrct){
        // dd(array_search( trim($mrct[2]), array_values($this->marinecenter) ));
        // echo in_array($mrct[2], array_values($this->marinecenter) ) ? 'true ' : 'false ';
        return array_search( trim($mrct[2]), array_values($this->marinecenter) );
    }

    private function HeadcheckSource($source){
        // echo in_array($source[0], array_values($this->source) ) ? 'true ' : 'false ';

        return in_array( trim($source[0]) , array_values($this->source) );
    }

    private function HeadcheckCollection($collection){
        // dd( array_search( trim($collection) , $this->collection ) );
        // echo in_array($collection[0], array_values($this->collection) ) ? 'true ' : 'false ';
        return array_search( trim($collection) , $this->collection );
    }

    private function HeadcheckReference($reference){
        // echo in_array($reference[0], array_values($this->reference) ) ? 'true ' : 'false ';
        return array_search( trim($reference[0]), $this->reference );
    }

    private function HeadcheckPlace($place){
        // echo in_array($place[0], array_values($this->place) ) ? 'true ' : 'false ';
        return array_search($place[0], array_values($this->place) );
    }

    private function HeadcheckReproduction($reproduction){
        // echo in_array($reproduction[0], array_values($this->reprodunction) ) ? 'true ' : 'false ';
        return array_search($reproduction[0], array_values($this->reprodunction) );
    }

    private function HeadcheckWording($wording,$lang,$dbdata){

        if($lang == 'en'){
            $index_wording = 0;
            $column = 'name_en';
        }elseif($lang == 'th'){
            $index_wording = 1;
            $column = 'name_th';
        }

        return in_array($wording[$index_wording], array_column( $dbdata, $column) );

    }

    private function HeadcheckCatalogNoIsEmpty($mrct, $cat){
        $results = DB::select("select * from record r, marinecenter m where m.id = r.marinecenter_id and r.catalog_number = '$cat' and m.marinecenter like '$mrct' " );
        if(sizeof($results) == 0){
            return false;
        }else{
            return true;
        }
    }

    private function HeadcheckNoLocalityIsEmpty($mrct, $reference, $page, $species){
        // $ref = Reference::getReferenceByID($reference)->ref_code;
        $results = DB::select("select * from record r, marinecenter m, reference rf where m.id = r.marinecenter_id and m.marinecenter like '$mrct' and rf.id = '$reference' and r.reference = rf.id and r.page = '$page' and r.no_species = '$species' order by r.created_by limit 0,1");
        // echo "select * from record r, marinecenter m, reference rf where m.id = r.marinecenter_id and m.marinecenter like '$mrct' and rf.id = '$reference' and r.reference = rf.id and r.page = '$page' and r.no_species = '$species' order by r.created_by limit 0,1";
        if(sizeof($results) == 0){
            return 1;
        }else{
            return $results[0]->no_locality+1;
        }
    }

    private function HeadCheckTaxonomy_From_Excel($taxonommy_name){

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

    private function HeadcheckWording_Can_Add($wording , $wording_type){
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

    private function checkTaxonomyInRowExcel_via_DB($map_pass_taxonomy){
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

    private function getExistTaxonomyName($UpperName, $header_taxo_id = ""){
        $sql = "select * from taxonomy where name = '$UpperName'";
        if($header_taxo_id != ""){
            $sql .= " and header_taxonomy_id = '$header_taxo_id'";
        }

        $results_check_exist_taxonomy = DB::select($sql);
        return array( sizeof($results_check_exist_taxonomy), $results_check_exist_taxonomy );

    }

    private function fullfillMissingTaxonomy($data_by_taxo_name){
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
    private function checkTaxonomyCanAdd($map_pass_taxonomy, $data_by_taxo_name){

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


    #--------------------------------------------------------#
}
