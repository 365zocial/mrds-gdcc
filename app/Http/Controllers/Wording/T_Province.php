<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Country;
use App\Model\Province;


trait T_Province {
  //Chaloemphon
  //Created : 11-3-59
  //Modified : -
  public function provinceList(){
    $data['action']     =   Session::get('action');
    $data['countrys']   =   Country::getCountryList_Enable_Only();
    $data['provinces']  =   Province::getProvinceList();
    Session::forget('action');

  return view('staff.wording.province.province_list', $data);
}

//Chaloemphon
//Created : 14-3-59
//Modified : -
public function addProvince(Request $input) {

    $lastId     =   Province::addProvince($input->add_country_province,  $input->add_province_en, $input->add_province_th);

    if ( $lastId ) {

        System_Log::Loging( 'province', // table_name
                            $lastId, // row_id
                            AllMean::defineAdd(),  // action
                            "", // old_data
                            Province::getProvinceWording($lastId)->toArray() ); // new_data

        $action = AllMean::defineAddAlertSuccess();
    } else {
        $action = AllMean::defineAddAlertFail();
    }
    Session::put('action', $action);

    return redirect('staff/wording/provinceList');
}

//Chaloemphon
//Created : 18-3-59
//Comment : AJAX
//Modified : -
public function getProvinceWording(Request $input) {
    $data['province']           =   Province::getProvinceWording($input->province_wording_id);
    $data['country']            =   Country::getCountryWording($data['province']->country_id);
    return Response::json( $data );
}

//ChaloemphonChaloemphon
//Created : 18-3-59
//Modified : -
public function editProvince(Request $input) {
    if ( Province::updateProvince( $input->province_wording_id, $input->add_country_province, $input->edit_province_en , $input->edit_province_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

        System_Log::Loging( 'province',  // table_name
                            $input->province_wording_id, // row_id
                            AllMean::defineEdit(), // action
                            System_Log::getOldData(), // old_data
                            Province::getProvinceWording($input->province_wording_id)->toArray() ); // new_data

        $action = AllMean::defineEditAlertSuccess();
    } else {
        $action = AllMean::defineEditAlertFail();
    }
    Session::put('action', $action);

    return redirect('staff/wording/provinceList');
}
}