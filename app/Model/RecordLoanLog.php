<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RecordLoanLog extends Model
{
    protected $table = 'record_loan_log';

    public static function insertRecordLoanLog($action, $recordLoanID, $oldData, $newData, $userID)
    {
        $recordLoanLog = new RecordLoanLog;
        $recordLoanLog->action          = $action;
        $recordLoanLog->record_loan_id  = $recordLoanID;
        $recordLoanLog->old_data        = $oldData;
        $recordLoanLog->new_data        = $newData;
        $recordLoanLog->user_id         = $userID;
        $recordLoanLog->save();
    }

    public static function reclaimEmailSuccess($recordLoanID, $email, $data)
    {
        $recordLoanLog = new RecordLoanLog;
        $recordLoanLog->action          = "Sent Email Reclaim Success";
        $recordLoanLog->record_loan_id  = $recordLoanID;
        $recordLoanLog->old_data        = $data;
        $recordLoanLog->new_data        = $email;
        $recordLoanLog->user_id         = 0;
        $recordLoanLog->save();
    }

    public static function reclaimEmailFailure($recordLoanID, $email, $data)
    {
        $recordLoanLog = new RecordLoanLog;
        $recordLoanLog->action          = "Sent Email Reclaim Failure";
        $recordLoanLog->record_loan_id  = $recordLoanID;
        $recordLoanLog->old_data        = $data;
        $recordLoanLog->new_data        = $email;
        $recordLoanLog->user_id         = 0;
        $recordLoanLog->save();
    }
}
