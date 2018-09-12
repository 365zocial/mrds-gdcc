<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use App\Http\Requests;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Extra_Field;

trait T_ExtraField {
    //Sorawit
    //Created : 3-8-59
    //Modified : -
    public function extraFieldList(){
      $data['action']         =   Session::get('action');
      $data['extra_fields']     =   Extra_Field::getExtraFieldNameList();
      Session::forget('action');

      return view('staff.wording.extra_field.extra_field_list', $data);
    }

    //Sorawit
    //Created : 3-8-59
    //Modified : -
    public function getExtraField(Request $input){
        $data['extra_field']        =   Extra_Field::getExtraFieldName($input->extra_field_id);
        return Response::json( $data );
    }

    //Sorawit
    //Created : 3-8-59
    //Modified : -
    public function editExtraField(Request $input){
      $old_info = Extra_Field::getExtraFieldName( $input->hidden_extra_field_id );
      if ( Extra_Field::updateExtraFieldName( $input->hidden_extra_field_id, $input->edit_extra_field_name, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

          $new_info = Extra_Field::getExtraFieldName( $input->hidden_extra_field_id );

          System_Log::Loging( 'extra_field',  // table_name
                              $input->hidden_extra_field_id, // row_id
                              AllMean::defineEdit(), // action
                              $old_info->toArray(), // old_data
                              $new_info->toArray() ); // new_data

          $action = AllMean::defineEditAlertSuccess();
      } else {
          $action = AllMean::defineEditAlertFail();
      }

      Session::put('action', $action);
      return redirect('staff/wording/extraFieldList');

    }
}