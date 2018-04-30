<?php
/*********************************************
    Project: MRDS
    Developer: fluke
    fucntion:   listUser editUserById editUserByIdAction 2/3/2016
                listUser editUserById editUserByIdAction 3/3/2016
*********************************************/

namespace App\Http\Controllers;

use App\Model\Users;
use App\Model\AllMean;
use App\Model\Role;
use App\Model\Marinecenter;
use Session;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\System_Log;


class StaffController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    //  protected $user;

    //  public function __construct(Users $users){
    //      $this->user = $users;
    //  }

    public function __construct(){
        Session::put('language', 1);
    }

    public function dashboard() {
        return view('staff.dashbaord');
    }

    public function listUser(){
        $data['action']     =   Session::get('action');
        $user               =   Users::where('role_id','>','1')
                                        ->orderBy('role_id', 'asc')
                                        ->orderBy('name', 'asc')
                                        ->get();
        Session::forget('action');

        $data['data_users'] =   $user;
        return view('staff.manage_staff.listStaff', $data);
    }

    public function addStaff(){
        $data['roles']              =   Role::getAllRole();
        $data['marinecenters']      =   Marinecenter::getMarineCenterList();
        return view('staff.manage_staff.addStaff' ,$data);
    }

    public function addStaffAction(Request $request){


        if($request->input('inp-password') != $request->input('inp-repassword')){
            echo "password not match";
        }else{

            $password = Hash::make($request->input('inp-password'));

            $role_id            =   $request->input('inp-roleid');
            $name               =   $request->input('inp-username');
            $password           =   $password;
            $first_name         =   $request->input('inp-first_name');
            $last_name          =   $request->input('inp-last_name');
            $gender             =   $request->input('inp-gender');
            $email              =   $request->input('inp-email');
            $telephone          =   $request->input('inp-telephone');
            $position           =   $request->input('inp-position');
            $company            =   $request->input('inp-company');
            $address            =   $request->input('inp-address');
            $approve            =   $request->input('inp-approve_permission');

            if($request->input('inp-roleid') != 5){
                $marinecenter_id    =   $request->input('inp-marinecenter');
            }else{
                $marinecenter_id    =   NULL;
            }

            $lastId     =   Users::addUser($role_id, $name, $password, $first_name, $last_name, $gender, $email, $telephone, $position, $company, $address, AllMean::ConvertStatusBoolean($approve) , $marinecenter_id);


            if ($lastId) {
                System_Log::Loging( 'users', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Users::getUserById($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/list');
        }

    }

    public function editStaffById($id){
        $user = Users::getUserById($id);
        $data['roles']              =   Role::getAllRole();

        $data['marinecenters']       =   Marinecenter::getMarineCenterList();
        $data['data_users'] =   $user;
        $data['id_users'] = $id;

        return view('staff.manage_staff.editStaff', $data);
    }

    public function editStaffByIdAction($id,Request $request){
        $user_obj                       =   Users::find($id);

        if($request->input('inp-password') != $request->input('inp-repassword')){
            echo "password not match";
        }else{

            $password = Hash::make($request->input('inp-password'));

            $role_id          =   $request->input('inp-roleid');
            $name             =   $request->input('inp-username');
            $changepassword   =   $request->input('inp-changepassword');
            $password         =   $password;
            $first_name       =   $request->input('inp-first_name');
            $last_name        =   $request->input('inp-last_name');
            $gender           =   $request->input('inp-gender');
            $email            =   $request->input('inp-email');
            $telephone        =   $request->input('inp-telephone');
            $position         =   $request->input('inp-position');
            $company          =   $request->input('inp-company');
            $address          =   $request->input('inp-address');
            $approve          =   $request->input('inp-approve_permission');
            $status           =   $request->input('status_switch');

            if($request->input('inp-roleid') != 5){
                $marinecenter_id    =   $request->input('inp-marinecenter');
            }else{
                $marinecenter_id    =   NULL;
            }

            if ( Users::editUser($id, $role_id, $name, $changepassword, $password, $first_name, $last_name, $gender, $email, $telephone, $position, $company, $address, AllMean::ConvertStatusBoolean($approve), $marinecenter_id,  AllMean::ConvertSwitchStatus($status)) ) {
                System_Log::Loging( 'users',  // table_name
                                    $id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Users::getUserById($id)[0]->toArray() ); // new_data


                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/list');

        }
    }

    public function resumeUserById($id){
        $user               = Users::find($id);
        $user->status           =   2;
        $user->save();

        return redirect('staff/list');
    }

    public function deleteUserById($id){
        $user               = Users::find($id);
        $user->status           =   1;
        $user->save();

        return redirect('staff/list');
    }

    public function searchByName(Request $request){
        
        if($request->typename == 'localname'){
            $data['datas'] = \App\Model\Record::leftjoin('classification', 'record.classification_id', 'classification.id')->where('record.local_name', 'like', '%'.$request->search.'%')->get();
        }elseif($request->typename == 'vernacularname'){
            $data['datas'] = \App\Model\Record::leftjoin('classification', 'record.classification_id', 'classification.id')->where('record.vernacular_name', 'like', '%'.$request->search.'%')->get();
        }elseif($request->typename == 'commonname'){
            $data['datas'] = \App\Model\Record::leftjoin('classification', 'record.classification_id', 'classification.id')->where('classification.common_name', 'like', '%'.$request->search.'%')->get();
        }
    
        return view('staff/searchByName', $data);
    }

}
