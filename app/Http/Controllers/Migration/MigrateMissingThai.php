<?php

namespace App\Http\Controllers\Migration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Record;
use App\Model\RecordPlace;

class MigrateMissingThai extends Controller
{
    public function index() {
        $file = "migrate_thai.csv";

        if (($handle = fopen($file, "r")) !== FALSE) {
            $line = 1;
            $record_id = 8140;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $num = count($data);
                // $row = 1;
                // echo "<p> $num fields in line $row: <br /></p>\n";
                // $row++;
                echo $line." ";
                // for ($c=0; $c < 150; $c++) {
                //         // echo $data[$c].", ";
                        $db = Record::find($record_id);
                        $db->variety_name 				= $data[50]; //variety_name_th
                        $db->locality					= $data[75]; //locality_th

                        $db->local_name 				= $data[109]; //local_name
                        $db->vernacular_name 			= $data[110]; //vernacular_name
                        $db->common_name 				= $data[111]; //common_name
                        $db->team_exploration_code 		= $data[112]; //team_exploration_code  /////
                        $db->area_exploration 			= $data[113]; //area_exploration  /////
                        $db->village_no 				= $data[114]; //village_no
                        $db->area_direction 			= $data[116]; //area_direction
                        $db->area 						= $data[117]; //area
                        // $db->utilization 				= $data[118]; //utilization
                        $db->folk_wisdom 				= $data[119]; //folk_wisdom
                        $db->recorder 					= $data[120]; //recorder
                        $db->knowledge_remarks 			= $data[121]; //knowledge_remarks
                        $db->water_temperature 			= $data[125]; //water_temperature
                        $db->transparency 				= $data[126]; //transparency
                        $db->water_ph 					= $data[127]; //water_ph
                        $db->dissolve_oxygen 			= $data[128]; //dissolve_oxygen
                        $db->suspended_solid 			= $data[129]; //suspended_solid
                        $db->salinity 					= $data[130]; //salinity
                        $db->specimen_collection 		= $data[131]; //specimen_collection
                        $db->specimen_photograph 		= $data[132]; //specimen_photograph
                        // $db->water_place 				= $data[137]; //water_place   /////
                        // $db->tree_place 				= $data[137]; //tree_place   /////
                        // $db->soil_earth_place 			= $data[137]; //soil_earth_place   /////
                        // $db->ground_earth_place 		= $data[137]; //ground_earth_place   /////
                        // $db->coast_place 				= $data[137]; //coast_place   /////
                        $db->plant_type 				= $data[137]; //plant_type   /////
                        $db->animal_type1 				= 41; //animal_type1    /////
                        // $db->animal_type2 				= $data[142]; //animal_type2    /////
                        // $db->animal_type3 				= $data[142]; //animal_type3   /////
                        $db->protection_type 			= $data[142]; //protection_type   /////
                        $db->reproduction 				= $data[144]; //reproduction
                        $db->save();

                        $place                      = new RecordPlace;
                        $place->record_unique_id    = $db->unique_record;
                        $place->place_id            = 3;
                        $place->save();

                // }
                $line++;
                echo "<br><br>";
                ++$record_id;
            }
            fclose($handle);
        }
    }
}
