<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File_Migrate_Log extends Model
{
    protected $table = 'file_migrate_log';
    //

    public static function addMigrateLog($file_name, $rows, $have_error ){
        $db                     =   new File_Migrate_Log;
        $db->file_name          =   $file_name;
        $db->row                =   $rows;
        $db->have_error         =   $have_error;
        $db->created_by         =   1;
        $db->updated_by         =   1;

        return CatchException::catcherAdd($db);

    }
}
