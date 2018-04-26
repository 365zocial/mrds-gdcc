<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Mailbox extends Model
{
    protected $table = 'mailbox';

    public static function showMailbox() {
        return Mailbox::leftjoin('users as user','mailbox.user_id', '=', 'user.id')
                ->leftjoin('marinecenter as marine','mailbox.marinecenter_id', '=', 'marine.id')
                ->select('mailbox.id as id','user.first_name','user.last_name','mailbox.type','marine.marinecenter_code','mailbox.subject')
                ->get();
    }

    public static function showMailboxByUserID() {
        return Mailbox::leftjoin('users as user','mailbox.user_id', '=', 'user.id')
                ->leftjoin('marinecenter as marine','mailbox.marinecenter_id', '=', 'marine.id')
                ->where('mailbox.user_id', Auth::user()->id)->get();
    }

    public static function detailMailbox( $id ) {
        return Mailbox::leftjoin('users as user','mailbox.user_id', '=', 'user.id')
                ->leftjoin('marinecenter as marine','mailbox.marinecenter_id', '=', 'marine.id')
                ->select('mailbox.id as id','user.first_name','user.last_name','mailbox.type','marine.marinecenter','marine.marinecenter_code','mailbox.subject','user.email','mailbox.text')
                ->where('mailbox.id', $id)->get();
    }

    public static function detailMailboxByUserID( $id ) {
        return Mailbox::leftjoin('users as user','mailbox.user_id', '=', 'user.id')
                ->leftjoin('marinecenter as marine','mailbox.marinecenter_id', '=', 'marine.id')
                ->where('mailbox.id', $id)
                ->where('mailbox.user_id', Auth::user()->id)->first();
    }

    public static function typeMailbox( $mailbox_id ) {
        if ( $mailbox_id == 1 ) $wording = 'Comment';
        else $wording = 'Question';
        return $wording;
    }

    public static function addMailbox($mrct, $user_id, $contact_type, $topic, $message){

        $db                     = new Mailbox;
        $db->marinecenter_id    = $mrct;
        $db->user_id            = $user_id;
        $db->type               = $contact_type;
        $db->subject            = $topic;
        $db->text               = $message;

        $db->save();

        return $db->id;
    }

}
