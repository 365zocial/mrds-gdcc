<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

use App\Model\AllMean;
use App\Model\CatchException;

class Role extends Model
{
    protected $table = 'role';

    public static function getAllRole(){
        return Role::where('id','>',1)->get();
    }

    public static function getRoleByID($role_id){
        return Role::where('id', $role_id)->first();
    }
}
