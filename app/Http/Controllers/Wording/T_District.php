<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use App\Http\Requests;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Province;
use App\Model\District;

trait T_District {
    //Chaloemphon
    //Created : 14-3-59
    //Modified : -
    public function districtList(){
      $data['action']     =   Session::get('action');
      $data['provinces']  =   Province::getProvinceList();
      $data['districts']  =   District::getDistrictList();
      Session::forget('action');

      return view('staff.wording.district.district_list', $data);
  }

  //Chaloemphon
  //Created : 14-3-59
  //Modified : -
  public function addDistrict(Request $input) {
      $lastId     =   District::addDistrict($input->add_province_district, $input->add_district_en, $input->add_district_th);
      if ( $lastId ) {

          System_Log::Loging( 'district', // table_name
                              $lastId, // row_id
                              AllMean::defineAdd(),  // action
                              "", // old_data
                              District::getDistrictWording($lastId)->toArray() ); // new_data

          $action = AllMean::defineAddAlertSuccess();
      } else {
          $action = AllMean::defineAddAlertFail();
      }
      Session::put('action', $action);

      return redirect('staff/wording/districtList');
  }

  //Chaloemphon
  //Created : 18-3-59
  //Comment : AJAX
  //Modified : -
  public function getDistrictWording(Request $input) {

      $data['district']           =   District::getDistrictWording($input->district_wording_id);
      $data['province']           =   Province::getProvinceWordingByCode($data['district']->province_id);

      return Response::json( $data );
  }

  //ChaloemphonChaloemphon
  //Created : 18-3-59
  //Modified : -
  public function editDistrict(Request $input) {
      if ( District::updateDistrict( $input->district_wording_id, $input->edit_province_district, $input->edit_district_en, $input->edit_district_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

          System_Log::Loging( 'district',  // table_name
                              $input->district_wording_id, // row_id
                              AllMean::defineEdit(), // action
                              System_Log::getOldData(), // old_data
                              District::getDistrictWording($input->district_wording_id)->toArray() ); // new_data

          $action = AllMean::defineEditAlertSuccess();
      } else {
          $action = AllMean::defineEditAlertFail();
      }
      Session::put('action', $action);

      return redirect('staff/wording/districtList');
  }

}