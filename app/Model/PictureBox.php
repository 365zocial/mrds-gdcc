<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PictureBox extends Model
{
    public static function doUpdatePictureBox( $id, $pic ) {
        $db = PictureBox::find( $id );
        $db->pic = $pic;
        $db->updated_by = Auth::user()->id;
        $db->save();

        return $db->id;
    }
}
