<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RecordSex extends Model
{
    protected $table = 'record_sexes';

    public static function getRecordSexByUniqueId($record_unique_id)
    {
        return RecordSex::where('record_unique_id', $record_unique_id)->get();
    }
}
