<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;


class Collection extends Model
{
    protected $table = 'collection';

    public static function getCollection(){
        return Collection::orderBy('name_en', 'asc')->get();
    }

    public static function getCollectionForEnable(){
        return Collection::where('status', 2)->orderBy('name_en', 'asc')->get();
    }

    public static function getCollectionByID($id) {
        return Collection::where('id', $id)->first();
    }

    public static function addCollection( $add_collection_code, $add_collection_en, $add_collection_th ){
        $db                         =   new Collection;
        $db->col_code               =   $add_collection_code;
        $db->name_en                =   $add_collection_en;
        $db->name_th                =   $add_collection_th;
        $db->status     =   2;
        $db->created_by =   Auth::user()->id;
        $db->updated_by =   Auth::user()->id;

        return CatchException::catcherAdd($db);
    }

    public static function updateCollection($collection_id, $collection_en, $collection_th, $status) { //$collection_code,
        $db 					=	Collection::find($collection_id);
        System_Log::setOldData($db->toArray());
        // $db->col_code               =   $collection_code;
        $db->name_en                =   $collection_en;
        $db->name_th                =   $collection_th;
        $db->status                 =   $status;
        $db->updated_by             =   Auth::user()->id;

        // dd($db);
        return CatchException::catcherEdit($db);
    }
}
