<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Extra_Field extends Model
{
    protected $table = 'extra_field';

    public static function getExtraFieldNameList() {
        return Extra_Field::get();
    }

    public static function getExtraFieldName( $id ) {
        return Extra_Field::where('id', $id)->first();
    }

    public static function updateExtraFieldName( $id, $word, $status ) {
        $db 					 =	Extra_Field::find( $id );
        $db->name                =  $word;
        $db->status                =  $status;
        $db->updated_by          =  Auth::user()->id;

        return CatchException::catcherEdit($db);
    }
}
