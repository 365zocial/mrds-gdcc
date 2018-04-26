<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login_Log extends Model
{
	protected $table = 'login_log';

    public static function addLogInLog($user_id) {
    	$db = new Login_Log;
		$db->user_id = $user_id;
		return $db->save();
    }
}
