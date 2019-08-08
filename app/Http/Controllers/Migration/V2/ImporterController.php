<?php

/*
    วิธีการ migrate
    - ทำการ seed เฉพาะ AddTempTable ด้วย php artisan db:seed --class=AddTempTable
    - นำ file excel ไปแปลง csv ด้วย google แล้ว google จะสลับ "ว/ด/ป เป็น ด/ว/ป" ใน code ดักไว้แล้ว (สำหรับ file ที่เป็น date)
    - นำ file csv มาไว้ใน folder raw_data
    - กำหนดชื่อไฟล์ที่ต้องการจะ migrate ใน raw_data/list.txt โดยสามารถทำได้ทีละ 1 file (ประกอบไปด้วย 100 ตัว)
    - เรียก url http://localhost/mrds_v2/public/staff/migdata/v2/import
    - เปลี่ยนชื่อ file ไปเรื่อยๆ

*/

namespace App\Http\Controllers\Migration\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Migration\V2\WordingCheck;

use App\Http\Controllers\Controller;
use App\Model\TempData;
use App\Model\Taxonomy;
use App\Model\Classification;
use App\Model\Record;
use App\Model\Marinecenter;
use App\Model\Collection;
use App\Model\Reference;
use App\Model\AllMean;
use App\Model\Wording_type;
use App\Model\Wording;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;

class ImporterController extends Controller
{
    use WordingCheck;

    public $header_row_no = 1;
    public $csvFile;
    public $data = [];
    public $row = 1;
    private $class_id = [];
    private $header_taxonomy = [
        'domain',
        'kingdom',
        'subkingdom',
        'infrakingdom',
        'phylum',
        'subphylum',
        'infraphylum',
        'superclass',
        'class',
        'subclass',
        'infraclass',
        'superorder',
        'order_o',
        'suborder',
        'infraorder',
        'superfamily',
        'family',
        'subfamily',
        'genus',
        'subgenus',
        'species',
        'subspecies'
    ];

    public function index() {
        $files = [];
        $lists = file(base_path('raw_data/list.txt'));
        foreach ($lists as $line) {
            $files[] = $line;
        }

        foreach($files AS $file) {
            echo $file."\r\n";
            // select file
            $path_to_file = base_path('raw_data/'.$file);
            $this->importEachFile($path_to_file);
        }
    }

    private function importEachFile($path_to_file) {;
        $this->csvFile = file(str_replace("\n","",$path_to_file));

        // import to temp table
        $this->importDataToTemp();

        // insert data to classification and record
        $this->insertData();
    }

    private function importDataToTemp() {
        $this->importData();
        $this->storeData();
    }

    private function importData() {
        foreach ($this->csvFile as $line) {
            if($this->row > $this->header_row_no) {
                $this->data[] = str_getcsv($line);
            }
            $this->row++;
        }
    }

    public function getDatas() {
        return $this->data;
    }

    public function showData($row = 0) {
        if($row > 0) {
            print_r(array_splice($this->data, 0, $row));
        } else {
            print_r($this->data);
        }
    }

    private function storeData() {
        TempData::truncate();
        foreach($this->getDatas() AS $data) {
            $tmp = new TempData;
            $tmp->date = $data[0];
            $tmp->department = $data[1];
            $tmp->department_dup = $data[2];
            $tmp->marinecenter_code = $data[3];
            $tmp->marinecenter_thai_name = $data[4];
            $tmp->source = $data[5];
            $tmp->collection = $data[6];
            $tmp->collection_dup = $data[7];
            $tmp->catalog_number = $data[8];
            $tmp->IDCatalog = $data[9];
            $tmp->IDCatalog_dup = $data[10];
            $tmp->reference = $data[11];
            $tmp->reference_dup = $data[12];
            $tmp->page = $data[13];
            $tmp->page_dup = $data[14];
            $tmp->no_species = $data[15];
            $tmp->no_species_dup = $data[16];
            $tmp->no_locality = $data[17];
            $tmp->no_locality_dup = $data[18];
            $tmp->IDRef = $data[19];
            $tmp->IDRef_dup = $data[20];
            $tmp->donated_from = $data[21];
            $tmp->deposited_at = $data[22];
            $tmp->current_scientific_name = $data[23];
            $tmp->domain = $data[24];
            $tmp->kingdom = $data[25];
            $tmp->subkingdom = $data[26];
            $tmp->infrakingdom = $data[27];
            $tmp->phylum = $data[28];
            $tmp->subphylum = $data[29];
            $tmp->infraphylum = $data[30];
            $tmp->superclass = $data[31];
            $tmp->class = $data[32];
            $tmp->subclass = $data[33];
            $tmp->infraclass = $data[34];
            $tmp->superorder = $data[35];
            $tmp->order_o = $data[36];
            $tmp->suborder = $data[37];
            $tmp->infraorder = $data[38];
            $tmp->superfamily = $data[39];
            $tmp->family = $data[40];
            $tmp->subfamily = $data[41];
            $tmp->genus = $data[42];
            $tmp->subgenus = $data[43];
            $tmp->species = $data[44];
            $tmp->subspecies = $data[45];
            $tmp->identification_qualifier = $data[46];
            $tmp->variety_name = $data[47];
            $tmp->variety_name_dup = $data[48];
            $tmp->previous_scientific_name = $data[49];
            $tmp->type_status = $data[50];
            $tmp->type_status_dup = $data[51];
            $tmp->diagnosis = $data[52];
            $tmp->diagnosis_dup = $data[53];
            $tmp->description = $data[54];
            $tmp->description_dup = $data[55];
            $tmp->individual_count = $data[56];
            $tmp->sex = $data[57];
            $tmp->size = $data[58];
            $tmp->size_dup = $data[59];
            $tmp->life_stage = $data[60];
            $tmp->life_stage_dup = $data[61];
            $tmp->ocean_sea_lake = $data[62];
            $tmp->ocean_sea_lake_dup = $data[63];
            $tmp->islands_island = $data[64];
            $tmp->islands_island_dup = $data[65];
            $tmp->country = $data[66];
            $tmp->country_dup = $data[67];
            $tmp->province = $data[68];
            $tmp->province_dup = $data[69];
            $tmp->district = $data[70];
            $tmp->district_dup = $data[71];
            $tmp->county = $data[72];
            $tmp->county_dup = $data[73];
            $tmp->locality = $data[74];
            $tmp->locality_dup = $data[75];
            $tmp->verbatim_latitude = $data[76];
            $tmp->latitude = $data[77];
            $tmp->start_latitude = $data[78];
            $tmp->end_latitude = $data[79];
            $tmp->verbatim_longitude = $data[80];
            $tmp->longitude = $data[81];
            $tmp->start_longitude = $data[82];
            $tmp->end_longitude = $data[83];
            $tmp->habitat = $data[84];
            $tmp->habitat_dup = $data[85];
            $tmp->gear_method = $data[86];
            $tmp->gear_method_dup = $data[87];
            $tmp->depth_start = $data[88];
            $tmp->depth_end = $data[89];
            $tmp->sediment_type = $data[90];
            $tmp->sediment_type_dup = $data[91];
            $tmp->collector = $data[92];
            $tmp->collected_date = $data[93];
            $tmp->collected_year = $data[94];
            $tmp->collected_month = $data[95];
            $tmp->collected_day = $data[96];
            $tmp->identifier = $data[97];
            $tmp->identified_date = $data[98];
            $tmp->identified_year = $data[99];
            $tmp->identified_month = $data[100];
            $tmp->identified_day = $data[101];
            $tmp->previous_identifier = $data[102];
            $tmp->previous_identified_date = $data[103];
            $tmp->note_collector = $data[104];
            $tmp->preparation_type = $data[105];
            $tmp->preparation_type_dup = $data[106];
            $tmp->expedition = $data[107];
            $tmp->expedition_dup = $data[108];
            $tmp->gene_bank_number = $data[109];
            $tmp->imageurl = $data[110];
            $tmp->local_name = $data[111];
            $tmp->vernacular_name = $data[112];
            $tmp->common_name = $data[113];
            $tmp->team_exploration_code = $data[114];
            $tmp->area_exploration = $data[115];
            $tmp->village_no = $data[116];
            $tmp->area_direction = $data[117];
            $tmp->area_direction_dup = $data[118];
            $tmp->area = $data[119];
            $tmp->utilization = $data[120];
            $tmp->folk_wisdom = $data[121];
            $tmp->recorder = $data[122];
            $tmp->knowledge_remarks = $data[123];
            $tmp->soil_temperature = $data[124];
            $tmp->soil_character = $data[125];
            $tmp->soil_ph = $data[126];
            $tmp->water_temperature = $data[127];
            $tmp->transparency = $data[128];
            $tmp->water_ph = $data[129];
            $tmp->dissolve_oxygen = $data[130];
            $tmp->suspended_solid = $data[131];
            $tmp->salinity = $data[132];
            $tmp->specimen_collection = $data[133];
            $tmp->specimen_photograph = $data[134];
            $tmp->sighting_no = $data[135];
            $tmp->exploration_remark = $data[136];
            $tmp->economic_value = $data[137];
            $tmp->economic_value_dup = $data[138];
            $tmp->sighting_time = $data[139];
            $tmp->invasive_species = $data[140];
            $tmp->place = $data[141];
            $tmp->living = $data[142];
            $tmp->plant_type = $data[143];
            $tmp->animal_type1 = $data[144];
            $tmp->animal_type2 = $data[145];
            $tmp->animal_type3 = $data[146];
            $tmp->protection_thai_law = $data[147];
            $tmp->protection_iucn_2019 = $data[148];
            $tmp->protection_cites = $data[149];
            $tmp->reproduction = $data[150];
            $tmp->cd = $data[151];
            $tmp->describes = $data[152];
            $tmp->choose_image = $data[153];
            $tmp->shooter = $data[154];
            $tmp->remark_image = $data[155];
            $tmp->save();
        }
    }

    private function insertData() {
        // check toxonomy
        $this->upsertTaxonomy();

        // insert class
        $this->insertClass();

        // insert record
        $this->insertRecord();
    }

    private function upsertTaxonomy() {
        foreach($this->header_taxonomy as $index_header => $column) {
            $taxo_lists = TempData::get([$column]);
            foreach($taxo_lists as $taxo) {
                if($taxo->{$column} !== '' && !empty($taxo->{$column})){
                    Taxonomy::firstOrCreate(['header_taxonomy_id' => ($index_header+1), 'name' => $taxo->{$column}]);
                }
            }
        }
    }

    private function insertClass() {
        foreach(TempData::get() AS $temp) {
            //get taxo id for this class
            $arr_taxo_id = $this->getIdTaxonomy($temp);

            $check_class = Classification::where('domain', $arr_taxo_id['domain'])
                            ->where('kingdom', $arr_taxo_id['kingdom'])
                            ->where('subkingdom', $arr_taxo_id['subkingdom'])
                            ->where('infrakingdom', $arr_taxo_id['infrakingdom'])
                            ->where('phylum', $arr_taxo_id['phylum'])
                            ->where('subphylum', $arr_taxo_id['subphylum'])
                            ->where('infraphylum', $arr_taxo_id['infraphylum'])
                            ->where('superclass', $arr_taxo_id['superclass'])
                            ->where('class', $arr_taxo_id['class'])
                            ->where('subclass', $arr_taxo_id['subclass'])
                            ->where('infraclass', $arr_taxo_id['infraclass'])
                            ->where('superorder', $arr_taxo_id['superorder'])
                            ->where('order_o', $arr_taxo_id['order_o'])
                            ->where('suborder', $arr_taxo_id['suborder'])
                            ->where('infraorder', $arr_taxo_id['infraorder'])
                            ->where('superfamily', $arr_taxo_id['superfamily'])
                            ->where('family', $arr_taxo_id['family'])
                            ->where('subfamily', $arr_taxo_id['subfamily'])
                            ->where('genus', $arr_taxo_id['genus'])
                            ->where('subgenus', $arr_taxo_id['subgenus'])
                            ->where('species', $arr_taxo_id['species'])
                            ->where('subspecies', $arr_taxo_id['subspecies'])
                            ->first();

            if(is_null($check_class)) {
                $new_class = new Classification;
                $new_class->current_scientific_name = AllMean::checkAndCutForNoneBackSpace( strip_tags( $this->convertUnderScore( $temp->current_scientific_name) ) );
                $new_class->current_scientific_name_format = $this->convertUnderScore($temp->current_scientific_name);
                $new_class->previous_scientific_name = AllMean::checkAndCutForNoneBackSpace( strip_tags( $this->convertUnderScore( $temp->previous_scientific_name) ) );
                $new_class->previous_scientific_name_format = $this->convertUnderScore($temp->previous_scientific_name);
                $new_class->domain = $arr_taxo_id['domain'];
                $new_class->kingdom = $arr_taxo_id['kingdom'];
                $new_class->subkingdom = $arr_taxo_id['subkingdom'];
                $new_class->infrakingdom = $arr_taxo_id['infrakingdom'];
                $new_class->phylum = $arr_taxo_id['phylum'];
                $new_class->subphylum = $arr_taxo_id['subphylum'];
                $new_class->infraphylum = $arr_taxo_id['infraphylum'];
                $new_class->superclass = $arr_taxo_id['superclass'];
                $new_class->class = $arr_taxo_id['class'];
                $new_class->subclass = $arr_taxo_id['subclass'];
                $new_class->infraclass = $arr_taxo_id['infraclass'];
                $new_class->superorder = $arr_taxo_id['superorder'];
                $new_class->order_o = $arr_taxo_id['order_o'];
                $new_class->suborder = $arr_taxo_id['suborder'];
                $new_class->infraorder = $arr_taxo_id['infraorder'];
                $new_class->superfamily = $arr_taxo_id['superfamily'];
                $new_class->family = $arr_taxo_id['family'];
                $new_class->subfamily = $arr_taxo_id['subfamily'];
                $new_class->genus = $arr_taxo_id['genus'];
                $new_class->subgenus = $arr_taxo_id['subgenus'];
                $new_class->species = $arr_taxo_id['species'];
                $new_class->subspecies = $arr_taxo_id['subspecies'];
                $new_class->identification_qualifier = $this->wordingIdentificationQualifier($temp->identification_qualifier);
                $new_class->protection_thai_law = $this->wordingProtectionIUCN($temp->protection_thai_law);
                $new_class->protection_iucn_2019 = $this->wordingProtectionThaiLaw($temp->protection_iucn_2019);
                $new_class->protection_cites = $this->wordingProtecitonCITES($temp->protection_cites);
                $new_class->common_name = $temp->common_name;
                $new_class->status = 2;
                $new_class->migration_data = 1;
                $new_class->created_by = \Auth::user()->id;
                $new_class->updated_by = \Auth::user()->id;
                $new_class->save();
                $class = $new_class->id;
            }else {
                $class = $check_class->id;
            }

            //find classification
            //if exist get id
            //else create and get id
            // $class = Classification::firstOrCreate(
            // [
            //     // array for insert if not exist
            //     'current_scientific_name' => AllMean::checkAndCutForNoneBackSpace( strip_tags( $this->convertUnderScore( $temp->current_scientific_name) ) ),
            //     'current_scientific_name_format' => $this->convertUnderScore($temp->current_scientific_name),
            //     'previous_scientific_name' => AllMean::checkAndCutForNoneBackSpace( strip_tags( $this->convertUnderScore( $temp->previous_scientific_name) ) ),
            //     'previous_scientific_name_format' => $this->convertUnderScore($temp->previous_scientific_name),
            //     'domain' => $arr_taxo_id['domain'],
            //     'kingdom' => $arr_taxo_id['kingdom'],
            //     'subkingdom' => $arr_taxo_id['subkingdom'],
            //     'infrakingdom' => $arr_taxo_id['infrakingdom'],
            //     'phylum' => $arr_taxo_id['phylum'],
            //     'subphylum' => $arr_taxo_id['subphylum'],
            //     'infraphylum' => $arr_taxo_id['infraphylum'],
            //     'superclass' => $arr_taxo_id['superclass'],
            //     'class' => $arr_taxo_id['class'],
            //     'subclass' => $arr_taxo_id['subclass'],
            //     'infraclass' => $arr_taxo_id['infraclass'],
            //     'superorder' => $arr_taxo_id['superorder'],
            //     'order_o' => $arr_taxo_id['order_o'],
            //     'suborder' => $arr_taxo_id['suborder'],
            //     'infraorder' => $arr_taxo_id['infraorder'],
            //     'superfamily' => $arr_taxo_id['superfamily'],
            //     'family' => $arr_taxo_id['family'],
            //     'subfamily' => $arr_taxo_id['subfamily'],
            //     'genus' => $arr_taxo_id['genus'],
            //     'subgenus' => $arr_taxo_id['subgenus'],
            //     'species' => $arr_taxo_id['species'],
            //     'subspecies' => $arr_taxo_id['subspecies'],
            //     'identification_qualifier' => $this->wordingIdentificationQualifier($temp->identification_qualifier),
            //     'protection_thai_law' => $this->wordingProtectionIUCN($temp->protection_thai_law),
            //     'protection_iucn_2019' => $this->wordingProtectionThaiLaw($temp->protection_iucn_2019),
            //     'protection_cites' => $this->wordingProtecitonCITES($temp->protection_cites),
            //     'common_name' => $temp->common_name,
            //     'status' => '',
            //     'migration_data' => 1,
            // ],
            // [ // array for check exist
            //     'domain' => $arr_taxo_id['domain'],
            //     'kingdom' => $arr_taxo_id['kingdom'],
            //     'subkingdom' => $arr_taxo_id['subkingdom'],
            //     'infrakingdom' => $arr_taxo_id['infrakingdom'],
            //     'phylum' => $arr_taxo_id['phylum'],
            //     'subphylum' => $arr_taxo_id['subphylum'],
            //     'infraphylum' => $arr_taxo_id['infraphylum'],
            //     'superclass' => $arr_taxo_id['superclass'],
            //     'class' => $arr_taxo_id['class'],
            //     'subclass' => $arr_taxo_id['subclass'],
            //     'infraclass' => $arr_taxo_id['infraclass'],
            //     'superorder' => $arr_taxo_id['superorder'],
            //     'order_o' => $arr_taxo_id['order_o'],
            //     'suborder' => $arr_taxo_id['suborder'],
            //     'infraorder' => $arr_taxo_id['infraorder'],
            //     'superfamily' => $arr_taxo_id['superfamily'],
            //     'family' => $arr_taxo_id['family'],
            //     'subfamily' => $arr_taxo_id['subfamily'],
            //     'genus' => $arr_taxo_id['genus'],
            //     'subgenus' => $arr_taxo_id['subgenus'],
            //     'species' => $arr_taxo_id['species'],
            //     'subspecies' => $arr_taxo_id['subspecies'],
            // ]);

            // push class id to system
            $this->class_id[] = $class;
        }
    }

    private function insertRecord() {
        foreach(TempData::get() AS $index => $temp) {

            list($_uniq,
            $_marine_center,
            $_collection,
            $_catalog_number,
            $_source,
            $_reference,
            $_page,
            $_no_species,
            $_no_locality,
            $_related_catalog_item,
            $_related_reference_item,
            $_country,
            $_province,
            $_district,
            $_county,
            $_locality,
            $_variety_name,
            $_diagnosis,
            $_description,
            $_islands_island,
            $_size,
            $_verbatim_latitude,
            $_verbatim_longitude,
            $_collected_date,
            $_identified_date,
            $_old_date_temp) = $this->setPrepareRecord($temp);

            for($i_language = 1; $i_language <= 2 ; $i_language++) {
                $rc                                     = new Record;
                $rc->unique_record                      = $_uniq;
                $rc->classification_id                  = $this->class_id[$index]; // get each class id to mapping
                $rc->language_id                        = $i_language; //set language id 1 or 2
                $rc->marinecenter_id                    = $_marine_center;
                $rc->collection_code                    = $_collection;
                $rc->catalog_number                     = $_catalog_number;
                $rc->related_catalog_item               = $_related_catalog_item;
                $rc->source                             = $_source;
                $rc->reference                          = $_reference;
                $rc->page                               = $_page;
                $rc->no_species                         = $_no_species;
                $rc->no_locality                        = $_no_locality;
                $rc->related_reference_item             = $_related_reference_item;
                $rc->individual_count                   = $temp->individual_count;
                $rc->latitude                           = $temp->latitude;
                $rc->verbatim_latitude                  = $_verbatim_latitude;
                $rc->start_latitude                     = $temp->start_latitude;
                $rc->end_latitude                       = $temp->end_latitude;
                $rc->longitude                          = $temp->longitude;
                $rc->verbatim_longitude                 = $_verbatim_longitude;
                $rc->start_longitude                    = $temp->start_longitude;
                $rc->end_longitude                      = $temp->end_longitude;
                $rc->country                            = $_country;
                $rc->province                           = $_province;
                $rc->district                           = $_district;
                $rc->county                             = $_county;
                $rc->locality                           = $_locality[$i_language-1];
                $rc->ocean_sea_lake                     = $this->wordingOceanSeaLake($temp->ocean_sea_lake, $temp->ocean_sea_lake_dup);
                $rc->islands_island                     = $_islands_island[$i_language-1];
                $rc->habitat                            = $this->wordingHabitat($temp->habitat, $temp->habitat_dup);
                $rc->sediment_type                      = $temp->sediment_type;
                $rc->type_status                        = $this->wordingTypeStatus($temp->type_status, $temp->type_status_dup);
                $rc->sex                                = $this->wordingSex($temp->sex);
                $rc->size                               = $_size[$i_language-1];
                $rc->life_stage                         = $this->wordingLifeStage($temp->life_stage, $temp->life_stage_dup);
                $rc->donated_from                       = $this->wordingDonatedFrom($temp->donated_from);
                $rc->deposited_at                       = $this->wordingDepositedAt($temp->deposited_at);
                $rc->gear_method                        = $this->wordingGearMethod($temp->gear_method, $temp->gear_method_dup);
                $rc->depth_start                        = $temp->depth_start;
                $rc->depth_end                          = $temp->depth_end;
                $rc->collector                          = $temp->collector;
                $rc->collected_date                     = $_collected_date;
                $rc->collected_year                     = $temp->collected_year;
                $rc->collected_month                    = $temp->collected_month;
                $rc->collected_day                      = $temp->collected_day;
                $rc->identifier                         = $temp->identifier;
                $rc->identified_date                    = $_identified_date;
                $rc->identified_year                    = $temp->identified_year;
                $rc->identified_month                   = $temp->identified_month;
                $rc->identified_day                     = $temp->identified_day;
                $rc->previous_identifier                = $temp->previous_identifier;
                $rc->previous_identified_date           = $temp->previous_identified_date;
                $rc->note_collector                     = $temp->note_collector;
                $rc->expedition                         = $this->wordingExpedition($temp->expedition, $temp->expedition_dup);
                $rc->preparation_type                   = $this->wordingPreparationType($temp->preparation_type, $temp->preparation_type_dup);
                $rc->gene_bank_number                   = $temp->gene_bank_number;
                $rc->local_name                         = $temp->local_name;
                $rc->vernacular_name                    = $temp->vernacular_name;
                $rc->variety_name                       = $_variety_name[$i_language-1];
                $rc->diagnosis                          = $_diagnosis[$i_language-1];
                $rc->description                        = $_description[$i_language-1];
                $rc->team_exploration_code              = $temp->team_exploration_code;
                $rc->area_exploration                   = $temp->area_exploration;
                $rc->village_no                         = $temp->village_no;
                $rc->area_direction                     = $this->wordingAreaDirection($temp->area_direction, $temp->area_direction_dup);
                $rc->area                               = $temp->area;
                $rc->folk_wisdom                        = $temp->folk_wisdom;
                $rc->recorder                           = $temp->recorder;
                $rc->knowledge_remarks                  = $temp->knowledge_remarks;
                $rc->soil_temperature                   = $temp->soil_temperature;
                $rc->soil_character                     = $temp->soil_character;
                $rc->soil_ph                            = $temp->soil_ph;
                $rc->water_temperature                  = $temp->water_temperature;
                $rc->transparency                       = $temp->transparency;
                $rc->water_ph                           = $temp->water_ph;
                $rc->dissolve_oxygen                    = $temp->dissolve_oxygen;
                $rc->suspended_solid                    = $temp->suspended_solid;
                $rc->salinity                           = $temp->salinity;
                $rc->specimen_collection                = $temp->specimen_collection;
                $rc->specimen_photograph                = $temp->specimen_photograph;
                $rc->sighting_no                        = $temp->sighting_no;
                $rc->exploration_remark                 = $temp->exploration_remark;
                $rc->sighting_time                      = $temp->sighting_time;
                $rc->solo_living                        = '';
                $rc->group_living                       = '';
                $rc->animal_type1                       = $this->wordingAnimalType1($temp->animal_type1);
                $rc->animal_type2                       = $this->wordingAnimalType2($temp->animal_type2);
                $rc->animal_type3                       = $this->wordingAnimalType3($temp->animal_type3);
                $rc->economic_value                     = $this->wordingEconomicValue($temp->economic_value);
                if ( $temp->reproduction != null ) {
                    $rc->reproduction                   = 1;
                }
                $rc->plant_type                         = $this->wordingPlantType($temp->plant_type);
                $rc->picture_name                       = '';
                $rc->picture_remark                     = '';
                $rc->migration_data                     = 1;
                $rc->migration_old_created_date         = $_old_date_temp;
                $rc->approve_status                     = 1;
                $rc->approve_by                         = \Auth::user()->id;
                $rc->created_by                         = \Auth::user()->id;
                $rc->updated_by                         = \Auth::user()->id;
                $rc->status                             = 2;
                if ( $_old_date_temp != null ) {
                    $rc->updated_at                     = $_old_date_temp;
                }
                $rc->save();
            }
        }

    }

    // utility function
    public function createRelatedCatalog($marinecenter_code, $source, $collection_name, $catalog_number){

        $collection_code = Collection::where('name_en', $collection_name)->get()[0]->col_code;

        $related_catalog_item = $marinecenter_code."-".$source."-".$collection_code."-".$catalog_number;

        return $related_catalog_item;
    }

    public function createRelatedReference($marinecenter_code, $source, $collection_name, $reference_id, $page, $no_species, $no_locality){
        $collection_code = Collection::where('name_en', $collection_name)->get()[0]->col_code;
        $reference_code = Reference::find($reference_id)->ref_code;
        $related_reference_item = $marinecenter_code."-".$source."-".$collection_code."-".$reference_code."-".$page."-".$no_species."-".$no_locality;

        return $related_reference_item;
    }

    private function readVerbatim($verbatim){
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

    private function getIdTaxonomy($temp) {
        $arr_taxo_id = [];
        foreach($this->header_taxonomy as $index_header => $column) {
            $taxo = Taxonomy::where('name', $temp->{$column})->where('header_taxonomy_id', ($index_header+1))->first();
            $arr_taxo_id[$column] = !is_null($taxo) ? $taxo->id : null;
        }

        return $arr_taxo_id;
    }

    private function setPrepareRecord($temp) {
        $uniq = (Record::orderBy('id', 'desc')->limit(1)->get(['unique_record'])[0]->unique_record + 1);
        $marine_center = Marinecenter::where('marinecenter_code', $temp->marinecenter_code)->get()[0]->id;
        $collection = Collection::where('name_en', $temp->collection)->get()[0]->id;

        $country = Country::where('country_th', $temp->country_dup)->get();
        $country_id = $country->isNotEmpty() ? $country[0]->id : 0;

        $province = Province::where('province_th', $temp->province_dup)->where('country_id', $country_id)->get();
        $province_id = $province->isNotEmpty() ? $province[0]->id : 0;

        $district = District::where('district_th', $temp->district_dup)->where('province_id', $province_id)->get();
        $district_id = $district->isNotEmpty() ? $district[0]->id : 0;

        $county   = County::where('county_th', $temp->county_dup)->where('district_id', $district_id)->get();
        $county_id = $county->isNotEmpty() ? $county[0]->id : 0;

        $locality = [$temp->locality, $temp->locality_dup];
        $variety_name = [$temp->variety_name, $temp->variety_name_dup];
        $diagnosis = [$temp->diagnosis, $temp->diagnosis_dup];
        $description = [$temp->description, $temp->description_dup];
        $islands_island = [$temp->islands_island, $temp->islands_island_dup];
        $size = [$temp->size, $temp->size_dup];

        if($temp->collected_date !== "") {
            $collected_date_temp = explode("/",$temp->collected_date);
            $collected_date = $collected_date_temp[2]."-".$collected_date_temp[0]."-".$collected_date_temp[1];
        }else{
            $collected_date = null;
        }

        if($temp->identified_date !== "") {
            $identified_date_temp = explode("/",$temp->identified_date);
            $identified_date = $identified_date_temp[2]."-".$identified_date_temp[0]."-".$identified_date_temp[1];
        }else {
            $identified_date = null;
        }

        if($temp->date !== "") {
            $temp->date = trim($temp->date," ");
            $old_date_temp = explode("/",$temp->date);
            $old_date = $old_date_temp[2]."-".$old_date_temp[0]."-".$old_date_temp[1];
        }else {
            $old_date = null;
        }

        if($temp->source === 'Specimen') {
            $catalog_number     = $temp->catalog_number;
            $source             = 1;
            $reference          = "";
            $page               = "";
            $no_species         = "";
            $no_locality        = "";
            $related_catalog_item = $this->createRelatedCatalog($temp->marinecenter_code, $source, $temp->collection, $catalog_number);
            $related_reference_item = "";
        }elseif($temp->source === "Publication"){
            $catalog_number     = "";
            $source             = 2;
            $reference          = Reference::where('name_en', $temp->reference)->get()[0]->id;
            $page               = $temp->page;
            $no_species         = $temp->no_species;
            $no_locality        = $temp->no_locality;
            $related_catalog_item = "";
            $related_reference_item = $this->createRelatedReference($temp->marinecenter_code, $source, $temp->collection, $reference, $page, $no_species, $no_locality);
        }

        $verbatim_latitude = $this->readVerbatim($temp->verbatim_latitude);
        $verbatim_longitude = $this->readVerbatim($temp->verbatim_longitude);

        return [$uniq,
                $marine_center,
                $collection,
                $catalog_number,
                $source,
                $reference,
                $page,
                $no_species,
                $no_locality,
                $related_catalog_item,
                $related_reference_item,
                $country_id,
                $province_id,
                $district_id,
                $county_id,
                $locality,
                $variety_name,
                $diagnosis,
                $description,
                $islands_island,
                $size,
                $verbatim_latitude,
                $verbatim_longitude,
                $collected_date,
                $identified_date,
                $old_date];
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
    // utility function
}
