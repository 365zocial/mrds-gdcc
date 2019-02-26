<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Collection;

trait T_Collection {
  //Chaloemphon
  //Created : 5-4-59
  //Modified : -
  public function collectionList(){
      $data['action']     =   Session::get('action');
      $data['collections']    =   Collection::getCollection();
      Session::forget('action');

      return view('staff.wording.collection.collection_list', $data);
  }

  //Chaloemphon
  //Created : 5-4-59
  //Modified : -
  public function addCollection(Request $input){
      $lastId     =   Collection::addCollection(strtoupper($input->add_collection_code), $input->add_collection_en, $input->add_collection_th );
      if ( $lastId ) {

          System_Log::Loging( 'collection', // table_name
                              $lastId, // row_id
                              AllMean::defineAdd(),  // action
                              "", // old_data
                              Collection::getCollectionByID($lastId)->toArray() ); // new_data

          $action = AllMean::defineAddAlertSuccess();
      } else {
          $action = AllMean::defineAddAlertFail();
      }
      Session::put('action', $action);

      return redirect('staff/wording/collectionList');

  }

  //Chaloemphon
  //Created : 5-4-59
  //Modified : -
  public function getCollection(Request $input){
      $data['collection']        =   Collection::getCollectionByID($input->collection_id);
      return Response::json( $data );
  }

  //Chaloemphon
  //Created : 5-4-59
  //Modified : -
  public function editCollection(Request $input){
      // dd($input);
      if ( Collection::updateCollection( $input->collection_id, $input->edit_collection_en, $input->edit_collection_th,  AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

          System_Log::Loging( 'collection',  // table_name
                              $input->collection_id, // row_id
                              AllMean::defineEdit(), // action
                              System_Log::getOldData(), // old_data
                              Collection::getCollectionByID($input->collection_id)->toArray() ); // new_data

          $action = AllMean::defineEditAlertSuccess();
      } else {
          $action = AllMean::defineEditAlertFail();
      }

      Session::put('action', $action);
      return redirect('staff/wording/collectionList');

  }

  // Sorawit
  // Created : 26-2-62
  // Modified : -
  public function collectionForUser(){
    $data['lang']           =   Session::get('language');
    $data['action']         =   Session::get('action');
    $data['collections']    =   Collection::getCollectionForEnable();
    Session::forget('action');

    return view('search_type_c.collection_for_user', $data);
  }

}
