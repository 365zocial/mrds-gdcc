<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Response;
use Session;

//model path
use App\Model\AllMean;
use App\Model\System_Log;

use App\Http\Controllers\Wording\T_Taxonomy as Taxonomy;
use App\Http\Controllers\Wording\T_Country as Country;
use App\Http\Controllers\Wording\T_Province as Province;
use App\Http\Controllers\Wording\T_District as District;
use App\Http\Controllers\Wording\T_County as County;
use App\Http\Controllers\Wording\T_Collection as Collection;
use App\Http\Controllers\Wording\T_Reference as Reference;
use App\Http\Controllers\Wording\T_ExtraField as Extra_Field;
use App\Http\Controllers\Wording\T_Picturebox as PictureBox;
use App\Http\Controllers\Wording\T_Marinecenter as Marinecenter;

use App\Model\Wording_type;
use App\Model\Wording;

class WordingController extends Controller
{
    use Taxonomy, Country, Province, District, County, Reference, Extra_Field, PictureBox, Collection, Marinecenter;
	//Sorawit
	//Created : 10-3-59
	//Modified : -
    public function mainWording() {
        $data['wording_types']       =   Wording_type::getAllWording_type();
    	return view('staff.wording.main_wording' , $data);
    }

    //Chaloemphon
    //Created : 21-3-59
    //Modified : -
    public function wordingList($name_wording_type = ""){
        $data['action']                 =   Session::get('action');
        if($name_wording_type == ""){
            $name_wording_type          =   Session::get('wording_type');
            // Session::forget('wording_type');
        }
        $data['name_wording_type']      =   $name_wording_type;
        $data['wordings_type_id']       =   Wording_type::getIdWording_type($name_wording_type);
        $data['wordings']               =   Wording::getWordingByWordingType( $data['wordings_type_id']->id);
        Session::forget('action');

        return view('staff.wording.wording.wording_list', $data);
    }

    //Chaloemphon
    //Created : 21-3-59
    //Modified : -
    public function addWording(Request $input){
        $lastId     =   Wording::addWording($input->wording_type, $input->add_wording_en, $input->add_wording_th );
        if ( $lastId ) {

            System_Log::Loging( 'wording', // table_name
                                $lastId, // row_id
                                AllMean::defineAdd(),  // action
                                "", // old_data
                                Wording::getWording($lastId)->toArray() ); // new_data

            $action = AllMean::defineAddAlertSuccess();
        } else {
            $action = AllMean::defineAddAlertFail();
        }
        Session::put('action', $action);
        Session::put('wording_type', $input->name_wording_type);

        return redirect('staff/wording/wordingList');

    }

    //Chaloemphon
    //Created : 21-3-59
    //Modified : -
    public function getWording(Request $input){
        $data['wording']        =   Wording::getWording($input->wording_id);
        return Response::json( $data );
    }

    //Chaloemphon
    //Created : 21-3-59
    //Modified : -
    public function editWording(Request $input){
        if ( Wording::updateWording($input->wording_wording_id, $input->edit_wording_en, $input->edit_wording_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

            System_Log::Loging( 'wording',  // table_name
                                $input->wording_wording_id, // row_id
                                AllMean::defineEdit(), // action
                                System_Log::getOldData(), // old_data
                                Wording::getWording($input->wording_wording_id)->toArray() ); // new_data

            $action = AllMean::defineEditAlertSuccess();
        } else {
            $action = AllMean::defineEditAlertFail();
        }
        Session::put('action', $action);
        Session::put('wording_type', $input->name_wording_type);

        return redirect('staff/wording/wordingList');
    }
}
