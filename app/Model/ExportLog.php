<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ExportLog extends Model
{

    protected $table = 'export_log';

    public static function saveExportLog( $way, $note ) {
        $log = new ExportLog;
        $log->way = $way;   // 0 is excel, 1 is pdf, 2 is api
        $log->note = $note;
        $log->created_by = Auth::user()->id;
        $log->updated_by = Auth::user()->id;
        $log->save();
    }

}
