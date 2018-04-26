<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wording_type extends Model
{
    protected $table = 'wording_type';

    public static function getAllWording_type(){
        return Wording_type::where('name', '!=', 'utilization')
                ->where('name', '!=', 'recorder')
                ->orderBy('id', 'asc')->get();
    }

    public static function getIdWording_type($name){
        return Wording_type::where('name','LIKE', '%'.$name.'%')->first();
    }

}
