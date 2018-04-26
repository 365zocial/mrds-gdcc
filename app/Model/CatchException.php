<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Session;

class CatchException extends Model
{
    public static function catcherAdd($db_obj){
        try{
            $db_obj->save();
            return $db_obj->id;
        }catch (\Illuminate\Database\QueryException $e){
            Session::put('exception_catcher',$e->errorInfo[2]);
            return false;
        }
    }

    public static function catcherEdit($db_obj){

        try{
            $db_obj->save();
            return true;
        }catch (\Illuminate\Database\QueryException $e){
            Session::put('exception_catcher',$e->errorInfo[2]);
            return false;
        }
    }

    public static function catcherDelete($db_obj){
        try{
            $db_obj->delete();
            return true;
        }catch (\Illuminate\Database\QueryException $e){
            Session::put('exception_catcher',$e->errorInfo[2]);
            return false;
        }
    }
}
