<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Request;
use App\Model\Mailbox;
use App\Model\Marinecenter;
use Session;
use Auth;
use Config;
use Mail;
use App\Mail\ContactLoanSpecimen;

class MailboxController extends Controller
{

    //Sorawit
	//Created : 30-6-59
	//Modified : -
    public function dashboard() {
        $data['mailboxs'] = Mailbox::showMailbox();
    	return view('staff.mailbox.mailbox', $data);
    }

    //Sorawit
	//Created : 30-6-59
	//Modified : -
    public function detailMailboxStaff( $mailbox_id ) {
        $id = base64_decode( base64_decode( base64_decode( $mailbox_id ) ) );
        $data['mailbox'] = Mailbox::detailMailbox( $id );
        return view('staff.mailbox.detail_mailbox', $data);
    }

    //Sorawit
	//Created : 1-7-59
	//Modified : Chaloemphon 1-7-59
    public function contactForm() {
        // check session language and return
        $data['lang']   = Session::get('language');
        $data['name']   = Auth::user()->first_name." ".Auth::user()->last_name;
        $data['mrcts']  = Marinecenter::getMarineCenterList();

        return view('user.contact.form_en', $data);
    }

    //Chaloemphon
    //Create : 1-7-59
    //Modified
    public function docontactForm(Request $input){

        $contact_type       = "";
        $mrct               = $input->mrct;
        $topic              = $input->topic;
        $user               = $input->user;
        $message_email      = $input->message;
        $lang               = $input->lang;



        if( $input->contact_type == 1 ){
            $contact_type = "Comment";
        }elseif( $input->contact_type == 2 ){
            $contact_type = "Question";
        }

        $data['contact']        = $contact_type;
        $data['user']           = $user;
        $data['topic']          = $topic;
        $data['message_email']  = $message_email;

        // TODO:
        if($mrct == 1){
            $email_for_mbds = "";
        }elseif($mrct == 2){
            $email_for_mbds = "";
        }elseif($mrct == 3){
            $email_for_mbds = "";
        }elseif($mrct == 4){
            $email_for_mbds = "";
        }elseif($mrct == 5){
            $email_for_mbds = "";
        }

        $email_for_mbds     = Config::get('api.email');
        $email_for_user     = $email_for_mbds;

        $lastId                 = Mailbox::addMailbox($mrct, Auth::user()->id, $input->contact_type, $topic, $message_email);
        $data['url']            = 'staff/mailbox/detailMailboxStaff/'.base64_encode(base64_encode(base64_encode($lastId)));

        // #------ Send to MBDS -------#

        Mail::send('emails.contact.contact_mail_mbds_admin', $data, function ($message) use ($email_for_mbds) {
            $message->to($email_for_mbds)->subject('MBDS - Password Reset Instruction');
        });
        Mail::send('emails.contact.contact_mail_mbds_manager', $data, function ($message) use ($email_for_mbds) {
            $message->to($email_for_mbds)->subject('MBDS - Password Reset Instruction');
        });

        #------ Send to sender ------#
        if($lang == "en"){
            Mail::send('emails.contact.contact_mail_sender_en', $data, function ($message) use ($email_for_user) {
                $message->to($email_for_user)->subject('MBDS - Password Reset Instruction');
            });
        }elseif($lang == "th"){
            Mail::send('emails.contact.contact_mail_sender_th', $data, function ($message) use ($email_for_user) {
                $message->to($email_for_user)->subject('MBDS - Password Reset Instruction');
            });
        }


        return redirect('user/dashboard');
    }

    public function sendEmailToAdmin( Request $input ) {
        // Check ภาษา
        $lang = "en";
        if( Session::get('language' ) == 2 ) {
            $lang = "th";
        } else {
            $lang = "en";
        }

        $data['from_email']        = $input->from_email;
        $data['name']               = $input->name;
        $data['info']           = $input->message;

        $email_for_mrds     = Config::get('api.email');
        $email_for_user     = $data['from_email'];

        // #------ Send to MRDS -------#
        // return (new ContactLoanSpecimen($data, "admin"))->render(); // show detail mail
        Mail::to($email_for_mrds)->send(new ContactLoanSpecimen($data, "admin"));

        #------ Send to sender ------#
        Mail::to($email_for_user)->send(new ContactLoanSpecimen($data, $lang));

        return redirect('/');
    }

}
