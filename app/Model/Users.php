<?php

namespace App\model;

use Auth;
use App\Model\System_Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Model\CatchException;
// use Illuminate\Auth\Authenticatable;

class Users extends Model implements Authenticatable
{
    protected $table = 'users';

    public function getAuthIdentifierName(){

    }

    public function getAuthIdentifier(){

    }

    public function getAuthPassword(){

    }

    public function getRememberToken(){
        return $this->remember_token;
    }

    public function setRememberToken($value){
        $this->remember_token = $value;
    }

    public function getRememberTokenName(){
        return 'remember_token';
    }

    public static function getUserById($id){
        return Users::where('id','=',$id)->get();
    }

    public static function addUser($role_id, $name, $password, $first_name, $last_name, $gender, $email, $telephone, $position, $company, $address, $approve, $marinecenter_id){
        $user_obj                   =   new Users;

        $user_obj->role_id          =   $role_id;
        $user_obj->name             =   $name;
        $user_obj->password         =   $password;
        $user_obj->first_name       =   $first_name;
        $user_obj->last_name        =   $last_name;
        $user_obj->gender           =   $gender;
        $user_obj->email            =   $email;
        $user_obj->telephone        =   $telephone;
        $user_obj->position         =   $position;
        $user_obj->company          =   $company;
        $user_obj->address          =   $address;
        $user_obj->approve_permission       =   $approve;
        $user_obj->marinecenter_id  =   $marinecenter_id;
        $user_obj->status           =   2;
        $user_obj->created_by       =   1;
        $user_obj->updated_by       =   1;

        return CatchException::catcherAdd($user_obj);
    }

    public static function editUser($id, $role_id, $name, $changepassword, $password, $first_name, $last_name, $gender, $email, $telephone, $position, $company, $address, $approve, $marinecenter_id, $status){
        $user_obj                   =   Users::find($id);

        System_Log::setOldData($user_obj->toArray());

        $user_obj->role_id          =   $role_id;
        $user_obj->name             =   $name;
        if($changepassword == 1){
            $user_obj->password         =   $password;
        }
        $user_obj->first_name       =   $first_name;
        $user_obj->last_name        =   $last_name;
        $user_obj->gender           =   $gender;
        $user_obj->email            =   $email;
        $user_obj->telephone        =   $telephone;
        $user_obj->position         =   $position;
        $user_obj->company          =   $company;
        $user_obj->address          =   $address;
        $user_obj->approve_permission       =   $approve;
        $user_obj->marinecenter_id  =   $marinecenter_id;
        $user_obj->status           =   $status;
        $user_obj->updated_by       =   Auth::user()->id;

        return CatchException::catcherEdit($user_obj);


    }

    public static function editUser_by_self($firstname, $lastname, $gender, $telephone, $address, $companyname, $position, $email){

        $db                 = Users::find( Auth::user()->id );

        System_Log::setOldData($db->toArray());

        $db->first_name     = $firstname;
        $db->last_name      = $lastname;
        $db->gender         = $gender;
        $db->telephone      = $telephone;
        $db->address        = $address;
        $db->company        = $companyname;
        $db->position       = $position;
        $db->email          = $email;

        return CatchException::catcherEdit($db);
    }

    public static function editpassword($id, $password){

        $db                         = Users::find( $id );
        System_Log::setOldData($db->toArray());

        $db->password               = $password;

        $db_system_log              = new System_Log;
        $db_system_log->table_name  = "users";
        $db_system_log->column_name = "password";
        $db_system_log->row_id      = $id;
        $db_system_log->action      = 2;
        $db_system_log->old_value   = "-";
        $db_system_log->new_value   = $password;
        $db_system_log->created_by  = $id;

        if($db_system_log->save()){
            $db->save();
            return $db->id;
        }

    }


}
