<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;

class Country extends Model
{
    //
    protected $table = 'country';

    public static function getCountryList() {
    	return Country::orderBy('id', 'asc')->get();
    }

    public static function getCountryListForFormEN() {
        return Country::where('status', 2)->orderBy('country_en', 'asc')->get();
    }

    public static function getCountryList_Enable_Only() {
        return Country::where('status',2)
                        ->orderBy('id', 'asc')
                        ->get();
    }

    public static function addCountry($add_country_en, $add_country_th) {
        $db = new Country;
        $db->country_en =   $add_country_en;
        $db->country_th =   $add_country_th;
        $db->status     =   2;
        $db->created_by =   Auth::user()->id;
        $db->updated_by =   Auth::user()->id;

        return CatchException::catcherAdd($db);
    }


    public static function getCountryWording($country_wording_id) {
        return Country::where('id', $country_wording_id)->first();
    }

    public static function updateCountry($country_wording_id, $country_en , $country_th, $status) {
    	$db 					=	Country::find($country_wording_id);
		System_Log::setOldData($db->toArray());
		$db->country_en       =   $country_en;
		$db->country_th       =   $country_th;
		$db->status           =   $status;
		$db->updated_by       =   Auth::user()->id;

		return CatchException::catcherEdit($db);
    }

    public static function getCountryEnable($country_id){
        return Country::where('id', $country_id)->where('status', 2)->first();

    }

    public static function getCountryListOrderByEn() {
        return Country::where('status', 2)->orderBy('country_en', 'asc')->get();
    }

}
