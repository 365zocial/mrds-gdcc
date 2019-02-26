<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use Illuminate\Http\Request;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Marinecenter;

trait T_Marinecenter {
  // Sorawit
  // Created : 26-2-62
  // Modified : -
  public function MarineCenterForUser(){
    $data['lang']           =   Session::get('language');
    $data['action']         =   Session::get('action');
    $data['marinecenters']    =   Marinecenter::getMarineCenterForEnable();
    Session::forget('action');

    return view('search_type_c.marinecenter_for_user', $data);
  }

}
