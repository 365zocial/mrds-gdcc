<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Reference;
use App\Model\Marinecenter;

trait T_Reference {
    //Chaloemphon
    //Created : 5-4-59
    //Modified : -
    public function referenceList(){
      $data['action']         =   Session::get('action');
      $data['references']     =   Reference::getReference();
      $data['marinecenters']  =   Marinecenter::getMarineCenterList();
      // dd($data['references']);
      Session::forget('action');

      return view('staff.wording.reference.reference_list', $data);
    }

    //Chaloemphon
    //Created : 6-4-59
    //Modified : -
    public function addReference(Request $input){
      $lastId     =   Reference::addReference($input->marinecenter,strtoupper($input->add_reference_code), $input->add_reference_en, $input->add_reference_th );
      if ( $lastId ) {

          System_Log::Loging( 'reference', // table_name
                              $lastId, // row_id
                              AllMean::defineAdd(),  // action
                              "", // old_data
                              Reference::getReferenceByID($lastId)->toArray() ); // new_data

          $action = AllMean::defineAddAlertSuccess();
      } else {
          $action = AllMean::defineAddAlertFail();
      }
      Session::put('action', $action);

      return redirect('staff/wording/referenceList');
    }

    //Chaloemphon
    //Created : 6-4-59
    //Modified : -
    public function getReference(Request $input){
      $data['reference']        =   Reference::getReferenceByID($input->reference_id);
      return Response::json( $data );
    }

    //Chaloemphon
    //Created : 6-4-59
    //Modified : -
    public function editReference(Request $input){
      if ( Reference::updateReference( $input->reference_id, $input->edit_reference_en, $input->edit_reference_th,  AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

          System_Log::Loging( 'reference',  // table_name
                              $input->reference_id, // row_id
                              AllMean::defineEdit(), // action
                              System_Log::getOldData(), // old_data
                              Reference::getReferenceByID($input->reference_id)->toArray() ); // new_data

          $action = AllMean::defineEditAlertSuccess();
      } else {
          $action = AllMean::defineEditAlertFail();
      }

      Session::put('action', $action);
      return redirect('staff/wording/referenceList');
    }

    //Chaloemphon
    //Created : 5-4-59
    //Modified : -
    public function referenceLoan(){
      $data['lang']           =   Session::get('language');
      $data['action']         =   Session::get('action');
      $data['references']     =   Reference::getReference();
      $data['marinecenters']  =   Marinecenter::getMarineCenterList();
      Session::forget('action');

      return view('search_type_c.reference_loan', $data);
    }
}
