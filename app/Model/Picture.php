<?php

namespace App\Model;

use Auth;

use Illuminate\Database\Eloquent\Model;
use App\Model\CatchException;


class Picture extends Model
{

    protected $table = 'picture';

    public static function addPictureRecord($record_id, $path_pic, $caption, $photographer, $selected_picture, $level){

        $db                     =   new Picture;

        $db->unique_record      =   $record_id;
        $db->path_pic           =   $path_pic;
        $db->caption            =   $caption;
        $db->photographer       =   $photographer;
        $db->selected_picture   =   $selected_picture;
        $db->level              =   $level;
        $db->created_by         =   Auth::user()->id;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherAdd($db);
    }

    public static function getPicture($picture_id) {
        return Picture::where('id', $picture_id)->first();
    }

    public static function getPictureByRecordId($unique_record){
        return Picture::where('unique_record', $unique_record)->get();
    }

    public static function getPictureByRecordId_Two($unique_record){
        return Picture::where('unique_record', $unique_record)->skip(0)->take(2)->get();
    }


    public static function editPictureRecord($record_id, $path_pic, $caption, $photographer, $selected_picture, $level){

        $db                     =   Picture::find($record_id);
        System_Log::setOldData($db->toArray());

        $db->path_pic           =   $path_pic;
        $db->caption            =   $caption;
        $db->photographer       =   $photographer;
        $db->selected_picture   =   $selected_picture;
        $db->level              =   $level;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherEdit($db);
    }

    public static function editPictureTextRecord($record_id, $caption, $photographer){

        $db                     =   Picture::find($record_id);
        System_Log::setOldData($db->toArray());

        $db->caption            =   $caption;
        $db->photographer       =   $photographer;
        $db->updated_by         =   Auth::user()->id;

        return CatchException::catcherEdit($db);

    }

    public static function deletePictureRecord($id_picture){

        $db         =   Picture::find($id_picture);
        return CatchException::catcherDelete($db);

    }
}
