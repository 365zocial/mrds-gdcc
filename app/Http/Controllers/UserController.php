<?php
/*********************************************
    Project: MRDS
    Developer: fluke
    fucntion:   listUser editUserById editUserByIdAction 2/3/2016
                listUser editUserById editUserByIdAction 3/3/2016
*********************************************/

namespace App\Http\Controllers;

use Session;
use Auth;
use App\Model\Users;
use App\Model\AllMean;
use App\Model\System_Log;
use App\Model\Marinecenter;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */


    // protected $user;
    //
    // public function __construct(Users $users){
    //     $this->user = $users;
    // }

    public function dashboard(){
        $data['lang'] = Session::get('language');
        return view('user.dashboard', $data);
    }

    // public function addUser(){
    //     return view('user.addUser');
    // }
    //
    // public function addUserAction(Request $request){
    //     $user_obj   =   new Users;
    //
    //     if($request->input('inp-password') != $request->input('inp-repassword')){
    //         echo "password not match";
    //     }else{
    //
    //         $password = Hash::make($request->input('inp-password'));
    //
    //         $user_obj->name             =   $request->input('inp-username');
    //         $user_obj->password         =   $password;
    //         $user_obj->first_name       =   $request->input('inp-first_name');
    //         $user_obj->last_name        =   $request->input('inp-last_name');
    //         $user_obj->gender           =   $request->input('inp-gender');
    //         $user_obj->email            =   $request->input('inp-email');
    //         $user_obj->telephone        =   $request->input('inp-telephone');
    //         $user_obj->position         =   $request->input('inp-position');
    //         $user_obj->company          =   $request->input('inp-company');
    //         $user_obj->address          =   $request->input('inp-address');
    //         $user_obj->marinecenter_id  =   2;
    //         $user_obj->role_id          =   5;
    //         $user_obj->status           =   2;
    //         $user_obj->created_by       =   1;
    //         $user_obj->updated_by       =   1;
    //
    //         $user->save();
    //     }
    //     return redirect('user/list');
    // }

    // public function editUserById($id,$permission = ""){
    //     $user = Users::getUserById($id);
    //
    //
    //     return view('user.editUser')
    //             ->with('data_users',$user)
    //             ->with('permission',$permission)
    //             ->with('id_users',$id);
    // }
    //
    // public function editUserByIdAction($id,Request $request){
    //     $user_obj               =   Users::find($id);
    //
    //     $user_obj->name             =   $request->input('inp-username');
    //     $user_obj->first_name       =   $request->input('inp-first_name');
    //     $user_obj->last_name        =   $request->input('inp-last_name');
    //     $user_obj->gender           =   $request->input('inp-gender');
    //     $user_obj->email            =   $request->input('inp-email');
    //     $user_obj->telephone        =   $request->input('inp-telephone');
    //     $user_obj->position         =   $request->input('inp-position');
    //     $user_obj->company          =   $request->input('inp-company');
    //     $user_obj->address          =   $request->input('inp-address');
    //     $user_obj->status           =   $request->input('inp-status');
    //     $user_obj->updated_by       =   1;
    //
    //     $user_obj->save();
    //
    //     return redirect('user/list');
    //
    // }

    // public function deleteUserById($id){
    //     $user_obj       =   Users::find($id);
    //
    //     $user_obj->status           =   1;
    //
    //     $user_obj->save();
    //
    //     return redirect('user/list');
    //
    // }

    public function viewProfile(){
        $id = Auth::user()->id;
        $data['action'] = Session::get('action');
        Session::forget('action');
        $data['users'] = Users::where('id', $id)->get();

        if ( !empty($data['users'][0]->marinecenter_id) ) $data['marinecenter'] = Marinecenter::find($data['users'][0]->marinecenter_id)->marinecenter;
        return view('user.profile', $data);
    }

    public function editProfile(){
        $id = Auth::user()->id;
        $data['users'] = Users::where('id', $id)->get();
        return view('user.editUser', $data);
    }

    public function doEditProfile(Request $input){

        $first_name     = $input->firstname;
        $last_name      = $input->lastname;
        $gender         = $input->gender;
        $telephone      = $input->telephone;
        $address        = $input->address;
        $company        = $input->companyname;
        $position       = $input->position;
        $email          = $input->email;

        $lastId = Users::editUser_by_self($first_name, $last_name, $gender, $telephone, $address, $company, $position, $email);


        if ( $lastId ) {
            System_Log::Loging( 'users',  // table_name
                                $lastId, // row_id
                                AllMean::defineEdit(), // action
                                System_Log::getOldData(), // old_data
                                Users::getUserById($lastId)[0]->toArray() ); // new_data


            $action = AllMean::defineEditAlertSuccess();
        } else {
            $action = AllMean::defineEditAlertFail();
        }
        Session::put('action', $action);

        return redirect('profile');
    }

    public function editPassword(){
        $data['set_new_pass'] = Session::get('set_new_pass');
        Session::forget('set_new_pass');
        return view('user.password', $data);
    }

    public function doEditPassword(Request $input){

        $id = Auth::user()->id;

        $password_in_Db         = Users::where('id', $id)->get()[0]->password;

        if (Hash::check($input->current_password, $password_in_Db))
        {

            if($input->password == $input->confirm_password){
                $password_hash = Hash::make($input->password);
            }

            $lastId = Users::editpassword($id, $password_hash);
            if ( $lastId ) {
                System_Log::Loging( 'users',  // table_name
                                    $lastId, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Users::getUserById($lastId)[0]->toArray() ); // new_data
            }



        }else{

            Session::put('set_new_pass', true);
            return redirect('editpassword');

        }

        return redirect('profile');

    }

    public function dashboardAbbreviation() {
        $data['lang']   = Session::get('language');
        return view('user.abbreviation.dashboard', $data);
    }

}
