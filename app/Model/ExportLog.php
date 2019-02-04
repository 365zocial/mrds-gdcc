<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ExportLog extends Model
{

    protected $table = 'export_log';

    public static function saveExportLog( $way, $note ) {
        if ( Auth::check() ) {
            $user = Auth::user()->id;
        } else {
            $user = 0;
        }

        $log = new ExportLog;
        $log->way = $way;   // 0 is excel, 1 is pdf, 2 is api
        $log->note = $note;
        $log->created_by = $user;
        $log->updated_by = $user;
        $log->save();
    }

}
