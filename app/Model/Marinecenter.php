<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Marinecenter extends Model
{
    protected $table = 'marinecenter';

    public static function getMarineCenter($marinecenter_id) {
    	return Marinecenter::where('id', $marinecenter_id)->first();
    }

    public static function getMarineCenterCode($marinecenter_id) {
    	return Marinecenter::where('id', $marinecenter_id)->pluck('marinecenter_code');
    }

    public static function getMarineCenterList() {
    	return Marinecenter::get();
    }
}
