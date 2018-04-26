<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;


class Province extends Model
{
    protected $table = 'province';

    public static function getProvinceList() {
    	return Province::orderBy('id', 'asc')->get();
    }

    public static function getProvinceListForFormEN() {
        return Province::where('status', 2)->orderBy('province_en', 'asc')->get();
    }

    public static function addProvince($country_province, $add_province_en, $add_province_th) {
        $db                     =   new Province;
        $db->country_id         =   $country_province;
        $db->province_en        =   $add_province_en;
        $db->province_th        =   $add_province_th;
        $db->status             =   2;
        $db->created_by         =   Auth::user()->id;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherAdd($db);
    }

    public static function getProvinceWording($province_wording_id) {
        return Province::where('id', $province_wording_id)->first();
    }

    public static function getProvinceWordingByCode($province_wording_id){
        return Province::where('id', $province_wording_id)->first();
    }

    public static function updateProvince($province_wording_id, $country_province, $edit_province_en , $edit_province_th, $status) {
        $db 					=	Province::find($province_wording_id);
        System_Log::setOldData($db->toArray());
        $db->country_id         =   $country_province;
        $db->province_en        =   $edit_province_en;
        $db->province_th        =   $edit_province_th;
        $db->status             =   $status;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherEdit($db);
    }

    public static function getProvinceEnableInCountry($country_id){
        return Province::where('country_id', $country_id)->where('status', 2)->orderBy('province_en')->get();
    }

    public static function getProvinceEnableInCountry_TH($country_id){
        return Province::where('country_id', $country_id)->where('status', 2)->orderBy('province_th')->get();
    }

    public static function getProvinceEnable($province_id){
        return Province::where('id', $province_id)->where('status', 2)->first();
    }

    public static function getProvinceListOrderByEn() {
        return Province::where('status', 2)->orderBy('province_en', 'asc')->get();
    }

}
