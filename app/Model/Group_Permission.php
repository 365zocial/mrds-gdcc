<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group_Permission extends Model
{
    //
    protected $table = 'group_permission';

    public static function getGroup_PermissionById($id){
        return Group_Permission::where('id', $id)->get();
    }

    public static function set_Status_Group_Permission($id,$status){
        $db             =   Group_Permission::find($id);
        $db->status     =   $status;
        $db->save();

        return $db->id;
    }

}
