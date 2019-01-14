<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Country;

trait T_Country {
  //Chaloemphon
  //Created : 11-3-59
  //Modified : 15-3-59
  public function countryList(){
    $data['action']     =   Session::get('action');
    $data['countrys']   =   Country::getCountryList();
    Session::forget('action');

    return view('staff.wording.country.country_list', $data);

}

//Chaloemphon
//Created : 14-3-59
//Modified : 15-3-59
public function addCountry(Request $input) {
    $lastId     =   Country::addCountry($input->add_country_en, $input->add_country_th);
    if ( $lastId ) {

        System_Log::Loging( 'country', // table_name
                            $lastId, // row_id
                            AllMean::defineAdd(),  // action
                            "", // old_data
                            Country::getCountryWording($lastId)->toArray() ); // new_data

        $action = AllMean::defineAddAlertSuccess();
    } else {
        $action = AllMean::defineAddAlertFail();
    }
    Session::put('action', $action);

    return redirect('staff/wording/countryList');
}

//Chaloemphon
//Created : 18-3-59
//Comment : AJAX
//Modified : -
public function getCountryWording(Request $input) {
    $data['country']           =   Country::getCountryWording($input->country_wording_id);
    return Response::json( $data );
}

//ChaloemphonChaloemphon
//Created : 15-3-59
//Modified : -
public function editCountry(Request $input) {
    if ( Country::updateCountry( $input->country_wording_id, $input->edit_country_en , $input->edit_country_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

        System_Log::Loging( 'country',  // table_name
                            $input->country_wording_id, // row_id
                            AllMean::defineEdit(), // action
                            System_Log::getOldData(), // old_data
                            Country::getCountryWording($input->country_wording_id)->toArray() ); // new_data

        $action = AllMean::defineEditAlertSuccess();
    } else {
        $action = AllMean::defineEditAlertFail();
    }
    Session::put('action', $action);

    return redirect('staff/wording/countryList');
}
}