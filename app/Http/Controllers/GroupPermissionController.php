<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Model\System_Log;
use App\Model\AllMean;
use App\Model\CatchException;
use App\Model\Group_Permission;

class GroupPermissionController extends Controller
{
    public function viewGroup_Permission(){
        $data['exception_catcher']  = Session::get('exception_catcher');
        Session::forget('exception_catcher');
        $data['permission']          = Group_Permission::get();

        return view('staff.group_permission.permission_setting', $data);
    }

    public function updateGroup_Permission(Request $input){
        echo $input->id;
        $db         =   Group_Permission::find($input->id);
        System_Log::setOldData($db->toArray());

        if($input->role == "manager"){
            $db->status_manager =   AllMean::ConvertSwitchStatus($input->status);
        }else if($input->role == "user"){
            $db->status_user    =   AllMean::ConvertSwitchStatus($input->status);
        }else if($input->role == "board"){
            $db->status_board   =   AllMean::ConvertSwitchStatus($input->status);
        }else if($input->role == "pgcp"){
            $db->status_pgcp    =   AllMean::ConvertSwitchStatus($input->status);
        }

        CatchException::catcherEdit($db);

    }
}
