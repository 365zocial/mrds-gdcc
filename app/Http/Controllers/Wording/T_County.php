<?php


namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\District;
use App\Model\County;

trait T_County {
    //Chaloemphon
    //Created : 14-3-59
    //Modified : -
    public function countyList(){
      $data['action']     =   Session::get('action');
      $data['districts']  =   District::getDistrictList();

      Session::forget('action');

      return view('staff.wording.county.county_list', $data);
    }

    public function getCountyDataTable(){

      $query = County::query();
      $btn = '';
      return Datatables::of($query)
                  ->editColumn('status', '{{ $status == 1 ? "Disabled" : "Enabled" }}')
                  ->addColumn('action', function ($query) use ($btn) {
                      $btn .= '<a href="#" id="edit_button" data-id="'.$query->id.'"  data-toggle="modal" data-target="#edit_county_modal">
                                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                              </a>';

                      return $btn;
                  })
                  ->rawColumns(['action'])
                  ->addIndexColumn()
                  ->make(true);
    }

    //Chaloemphon
    //Created : 14-3-59
    //Modified : -
    public function addCounty(Request $input) {
      $lastId     =   County::addCounty($input->add_district_county, $input->add_county_en, $input->add_county_th);
      if ( $lastId ) {

          System_Log::Loging( 'county', // table_name
                              $lastId, // row_id
                              AllMean::defineAdd(),  // action
                              "", // old_data
                              County::getCountyWording($lastId)->toArray() ); // new_data

          $action = AllMean::defineAddAlertSuccess();
      } else {
          $action = AllMean::defineAddAlertFail();
      }
      Session::put('action', $action);

      return redirect('staff/wording/countyList');
    }

    //Chaloemphon
    //Created : 18-3-59
    //Comment : AJAX
    //Modified : -
    public function getCountyWording(Request $input) {
      $data['county']             =   County::getCountyWording($input->county_wording_id);
      $data['districts']           =   District::getDistrictWordingByCode($data['county']->district_id);

      return Response::json( $data );
    }

    //ChaloemphonChaloemphon
    //Created : 18-3-59
    //Modified : -
    public function editCounty(Request $input) {
      if ( County::updateCounty( $input->county_wording_id, $input->edit_district_county, $input->edit_county_en, $input->edit_county_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

          System_Log::Loging( 'county',  // table_name
                              $input->county_wording_id, // row_id
                              AllMean::defineEdit(), // action
                              System_Log::getOldData(), // old_data
                              County::getCountyWording($input->county_wording_id)->toArray() ); // new_data

          $action = AllMean::defineEditAlertSuccess();
      } else {
          $action = AllMean::defineEditAlertFail();
      }
      Session::put('action', $action);

      return redirect('staff/wording/countyList');
    }
}