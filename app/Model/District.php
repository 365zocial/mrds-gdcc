<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;


class District extends Model
{
    protected $table = 'district';

    public static function getDistrictList() {
        return District::orderBy('province_id','asc')
                    ->orderBy('id', 'asc')
                    ->get();
    }

    public static function getDistrictListForFormEN() {
        return District::where('status', 2)->orderBy('district_en', 'asc')->get();
    }

    public static function addDistrict($province_district, $add_district_en , $add_district_th) {

        $db                     =   new District;
        $db->province_id        =   $province_district;
        $db->district_en        =   $add_district_en;
        $db->district_th        =   $add_district_th;
        $db->status             =   2;
        $db->created_by         =   Auth::user()->id;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherAdd($db);
    }

    public static function getDistrictWording($district_wording_id) {
        return District::where('id', $district_wording_id)->first();
    }

    public static function getDistrictWordingByCode($district_wording_id){
        return District::where('id', $district_wording_id)->first();
    }

    public static function updateDistrict($district_wording_id, $province_district, $edit_district_en , $edit_district_th, $status) {
        $db 					=	District::find($district_wording_id);
        System_Log::setOldData($db->toArray());
        $db->province_id        =   $province_district;
        $db->district_en        =   $edit_district_en;
        $db->district_th        =   $edit_district_th;
        $db->status             =   $status;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherEdit($db);
    }


    public static function getDistrictEnableInProvince($province_id){
        return District::where('province_id', $province_id)->where('status', 2)->orderBy('district_en')->get();
    }

    public static function getDistrictEnableInProvince_TH($province_id){
        return District::where('province_id', $province_id)->where('status', 2)->orderBy('district_th')->get();
    }

    public static function getDistrictEnable($district_id){
        return District::where('id', $district_id)->where('status', 2)->first();
    }

    public static function getDistrictListOrderByEn() {
        return District::where('status', 2)->orderBy('district_en', 'asc')->get();
    }

}
