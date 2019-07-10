<?php

namespace App\Model;

use Auth;

use App\Model\System_Log;
use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;


class Wording extends Model
{
    protected $table = 'wording';
    protected $fillable = ['wording_type_id', 'name_en', 'name_th', 'status'];

    public static function getWordingByWordingType($wording_type_id){
        return Wording::where('wording_type_id','=',$wording_type_id)->get();
    }

    public static function getWordingByWordingTypeForForm($wording_type_id) {
        return Wording::where('wording_type_id', '=', $wording_type_id)->where('status', 2)->get();
    }

    public static function getWordingByWordingTypeForFormSortByLang($wording_type_id, $language) {
        if ( $language == 2) { // ภาษาไทย
            return Wording::where('wording_type_id', '=', $wording_type_id)->where('status', 2)->orderBy('name_th', 'asc')->get();
        } else {    // ภาษาอังกฤษ
            return Wording::where('wording_type_id', '=', $wording_type_id)->where('status', 2)->orderBy('name_en', 'asc')->get();
        }
    }

    public static function getWordingByID($id) {
        return Wording::where('id', $id)->first();
    }

    public static function addWording( $wording_type, $add_wording_en, $add_wording_th ){
        $db                     =   new Wording;
        $db->wording_type_id    =   $wording_type;
        $db->name_en            =   $add_wording_en;
        $db->name_th            =   $add_wording_th;
        $db->status             =   2;

        if (Auth::check()) {
            $db->created_by         =   Auth::user()->id;
            $db->updated_by         =   Auth::user()->id;
        }else{
            $db->created_by         =   1;
            $db->updated_by         =   1;
        }

        return CatchException::catcherAdd($db);

    }

    public static function getWording($wording_id) {
        // dd($wording_id);
        if(is_null($wording_id) || $wording_id == "0" || $wording_id == 0 || $wording_id == "-" ){
            // dd($wording_id);
            return null;

        }else{
            return Wording::where('id', $wording_id)->first();
        }
    }

    public static function getWordingWithAttr($wording_id, $attr = ""){
        // dd($wording_id);
        // dd($attr);
        $wording = Wording::where('id', $wording_id)->first();
        if( $wording == null ){
            return null;
        }else{
            // dd($wording);
            if($attr != ""){
                return $wording->$attr;
            }else{
                return $wording;
            }
        }

    }

    public static function updateWording($wording_wording_id, $edit_wording_en, $edit_wording_th, $status) {
        $db                     =   Wording::find($wording_wording_id);
        System_Log::setOldData($db->toArray());

        $db->name_en            =   $edit_wording_en;
        $db->name_th            =   $edit_wording_th;
        $db->status             =   $status;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherEdit($db);
    }

}
