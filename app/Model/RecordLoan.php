<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RecordLoan extends Model
{

    protected $table = 'record_loan';

    public static function Insert($marinecenterID, $userID, $days, $startDate, $endDate, $status, $remark)
    {
        $recordLoan = new RecordLoan;
        $recordLoan->marinecenter_id  = $marinecenterID;
        $recordLoan->user_id          = $userID;
        $recordLoan->credit           = $days;
        $recordLoan->start_date       = $startDate;
        $recordLoan->end_date         = $endDate;
        $recordLoan->status           = $status;
        $recordLoan->remark           = $remark;
        $recordLoan->save();

        # Return ID
        return RecordLoan::where('user_id', $userID)->orderBy('id', 'DESC')->first()->id;
    }

    public static function getReclaimDate()
    {
        $data[0]['date'] = date('Y-m-d', strtotime('-1 months'));
        $data[0]['condition'] = '=';
        $data[0]['name'] = "will expire within 1 month";
        
        $data[1]['date'] = date('Y-m-d', strtotime('-7 days'));
        $data[1]['condition'] = '=';
        $data[1]['name'] = "will expire within 7 days";

        $data[2]['date'] = date('Y-m-d');
        $data[2]['condition'] = '=';
        $data[2]['name'] = "will expire today";

        $data[3]['date'] = date('Y-m-d', strtotime('+7 days'));
        $data[3]['condition'] = '=';
        $data[3]['name'] = "was already expired";

        return $data;
    }

}
