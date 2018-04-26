<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;

class County extends Model
{
    protected $table = 'county';

    public static function getCountyList() {
        return County::orderBy('district_id','asc')
                    ->orderBy('id', 'asc')
                    ->get();
    }

    public static function getCountyListForFormEN() {
        return County::where('status', 2)->orderBy('county_en', 'asc')->get();
    }

    public static function addCounty($add_district_county, $add_county_en, $add_county_th) {
        $db                     =   new County;
        $db->district_id        =   $add_district_county;
        $db->county_en          =   $add_county_en;
        $db->county_th          =   $add_county_th;
        $db->status             =   2;
        $db->created_by         =   1;
        $db->updated_by         =   1;
        return CatchException::catcherAdd($db);

    }

    public static function getCountyWording($county_wording_id) {
        return County::where('id', $county_wording_id)->first();
    }

    public static function updateCounty($county_wording_id, $edit_district_county, $edit_county_en, $edit_county_th, $status) {
        $db 					=	County::find($county_wording_id);
        System_Log::setOldData($db->toArray());
        $db->district_id        =   $edit_district_county;
        $db->county_en          =   $edit_county_en;
        $db->county_th          =   $edit_county_th;
        $db->status             =   $status;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherEdit($db);
    }

    public static function getCountyEnableInDistrict($district_id){
        return County::where('district_id', $district_id)->where('status', 2)->orderBy('county_en')->get();
    }

    public static function getCountyEnableInDistrict_TH($district_id){
        return County::where('district_id', $district_id)->where('status', 2)->orderBy('county_th')->get();
    }

    public static function getCountyListOrderByEn() {
        return County::where('status', 2)->orderBy('county_en', 'asc')->get();
    }


}
