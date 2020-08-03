<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RecordSex extends Model
{
    protected $table = 'record_sexes';

    /*
    *   1 = Male,
    *   2 = Female,
    *   3 = Hermaphrodite,
    *   4 = Indeterminate,
    *   5 = Unknown,
    *   6 = Transitional,
    *   7 = Imposex
    */

    public static function getRecordSexByUniqueId($record_unique_id)
    {
        return RecordSex::where('record_unique_id', $record_unique_id)->get();
    }
}
