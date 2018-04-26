<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';

    public static function getLanguage() {
    	return Language::where('status', 2)->get();
    }
}
