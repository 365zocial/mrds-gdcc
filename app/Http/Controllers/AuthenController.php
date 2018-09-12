<?php
/*********************************************
    Project: MRDS
    Developer: fluke
    fucntion:   login logout 3/3/2016
*********************************************/

namespace App\Http\Controllers;

use App\Model\Users;
use App\Model\Login_Log;
use App\Model\System_Log;
use App\Model\AllMean;
use Mail;
use Config;


use Session;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Request;
use App\Http\Controllers\Controller;
use App\Model\PictureBox;


class AuthenController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function __construct(){

    }

    public function login(){

        if( !is_null(Auth::user()) ){
            return redirect('staff/dashboard');
        }

        if(Session::has('language'))
            $data['lang'] = Session::get('language');
        else{
            $data['lang'] = 1;
        }

        $data['data'] = PictureBox::get();

        return view('authentication.login', $data);
    }

    public function authenticate(Request $request){
        $name             =   $request->input('inp-name');
        $password         =   $request->input('inp-password');

        if (Auth::attempt(['name' => strtolower($name), 'password' => $password])) {

            if($this->authorization_check_LoggedIn() && $this->authorization_check_status(Auth::user()->status)){
                //-------login log
                    Login_Log::addLogInLog(Auth::user()->id);
                //-------
                return redirect($this->authorization_check_role_id(Auth::user()->role_id));
            }else{
                echo "Your account is disable";
            }

        }else{
            Session::put('authen', 1);
            return redirect('login');
        }
    }

    public function authorization_check_LoggedIn(){
      if(Auth::check()){
        return true;
      }else{
        return false;
      }
    }

    public function authorization_check_status($status = ""){
      if($status == 2){
        return true;
      }else{
        return false;
      }
    }

    public function authorization_check_role_id($role_id = ""){
      if($role_id == 5){
        return "user/dashboard";
    }elseif(in_array($role_id,[1,2,3,4,6])){
        return "staff/dashboard";
      }else{
        return false;
      }
      // 1 = Super Admin
      // 2 = Administrator
      // 3 = Manager
      // 4 = Board
      // 5 = User
      // 6 = PGCP
    }

    public function logout(){
        Auth::logout();
        Session::flush(); // destroy all session
        return redirect('login');

    }

    public function setLanguageTH(){
        Session::put('language', 2);
        return redirect()->back();
    }

    public function setLanguageEN(){
        Session::put('language', 1);
        return redirect()->back();
    }

    public function register()
    {
      $data['action'] = Session::get('action');
      Session::forget('action');
      return view('authentication.register', $data);
    }

    public function doRegister(Request $input){
        $action = "";
        $username               = $input->input('username');
        $password               = $input->input('password');
        $confirm_password       = $input->input('confirm_password');
        $firstname              = $input->input('firstname');
        $lastname               = $input->input('lastname');
        $gender                 = $input->input('gender');
        $address                = $input->input('address');
        $companyname            = $input->input('companyname');
        $position               = $input->input('position');
        $email                  = $input->input('email');
        $telephone              = $input->input('telephone');
        $role_id                = 5;

        $password_hash = Hash::make($password);

        $lastId     =   Users::addUser($role_id, strtolower($username), $password_hash, $firstname, $lastname, $gender, $email, $telephone, $position, $companyname, $address, 0 , null);

        if ($lastId) {
            return redirect('login');
        } else {

            $action = AllMean::defineAddAlertFail();
            Session::put('action', $action);

            return back();

        }

    }

    public function forgetpass(){
        return view('authentication.forgetpass');
    }

    public function doforgetpass(Request $input){
        $email      =   $input->email;
        $user_data  =   Users::where('email', $email)->get();

        if( sizeof($user_data) == 1){
            $data               = [];
            $email_for_send[0]  = $user_data[0]->email;

            $data['firstname']  = $user_data[0]->first_name;
            $data['lastname']   = $user_data[0]->last_name;
            $data['url']        = url('resetpassword')."/".encrypt($user_data[0]->id);

            Mail::send('emails.auth.forgetpassword', $data, function ($message) use ($email_for_send) {
                $message->to($email_for_send)->subject('MRDS - Password Reset Instruction');
            });
        }

        return redirect('login');
    }

    public function resetPassword($id){

        Session::put('id_user_reset_pass', decrpyt( $id ) );
        return view('authentication.resetpassword');
    }

    public function doResetPassword(Request $input){
        if($input->password == $input->confirm_password){

            // $lastId = Users::editpassword(Session::get('id_user_reset_pass'), $input->password);
            Users::editpassword(Session::get('id_user_reset_pass'), Hash::make($input->password));

            // if ( $lastId ) {
            //     System_Log::Loging( 'users',  // table_name
            //                         $lastId, // row_id
            //                         AllMean::defineEdit(), // action
            //                         System_Log::getOldData(), // old_data
            //                         Users::getUserById($lastId)[0]->toArray() ); // new_data
            // }


        }

        return redirect('login');
    }

}
