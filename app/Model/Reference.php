<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;

class Reference extends Model
{
    protected $table = 'reference';

    public static function getReference(){
         $query = Reference::orderBy('marinecenter_id', 'asc')->orderBy('ref_code','asc');
         if(Auth::check() && Auth::user()->role_id == 3){
             $query = $query->where('marinecenter_id',Auth::user()->marinecenter_id);
         }
        //  else if(Auth::user()->role_id == 2){
        //      $query = $query->where('marinecenter_id', 1);
        //  }

        return $query->get();
    }

    public static function getReferenceByID($id) {
        return Reference::where('id', $id)->first();
    }

    public static function addReference( $marinecenter_id, $add_reference_code, $add_reference_en, $add_reference_th ){
        $db                         =   new Reference;
        $db->marinecenter_id        =   $marinecenter_id;
        $db->ref_code               =   $add_reference_code;
        $db->name_en                =   $add_reference_en;
        $db->name_th                =   $add_reference_th;
        $db->status     =   2;
        $db->created_by =   Auth::user()->id;
        $db->updated_by =   Auth::user()->id;

        return CatchException::catcherAdd($db);
    }

    public static function updateReference($reference_id, $reference_en, $reference_th, $status) {
        $db 					=	Reference::find($reference_id);
        System_Log::setOldData($db->toArray());
        $db->name_en                =   $reference_en;
        $db->name_th                =   $reference_th;
        $db->status                 =   $status;
        $db->updated_by             =   Auth::user()->id;

        return CatchException::catcherEdit($db);
    }
}
