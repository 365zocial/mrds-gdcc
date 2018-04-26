<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SearchReport extends Model
{

    protected $table = 'record';

    public static function getRecordByCollectedYear($year)
    {
    	return SearchReport::where('collected_year', $year)->where('approve_status', 1)->groupBy('collected_month')->get();
    }

}
