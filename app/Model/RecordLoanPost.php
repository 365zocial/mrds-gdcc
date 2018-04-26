<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RecordLoanPost extends Model
{

    protected $table = 'record_loan_post';

    public static function UseInsert($userID, $recordLoanID, $comment, $filePath)
    {
        $recordLoanPost = new RecordLoanPost;
        $recordLoanPost->user_id        = $userID;
        $recordLoanPost->record_loan_id = $recordLoanID;
        $recordLoanPost->comment        = $comment;
        $recordLoanPost->file_path      = $filePath;
        $recordLoanPost->save();

        # Return ID.
        return RecordLoanPost::where('user_id', $userID)->where('record_loan_id', $recordLoanID)->orderBy('id', 'DESC')->first()->id;
    }

    # Not use.
    public function UseUpdate($recordLoanPostID, $userID, $recordLoanID, $comment, $filePath)
    {
        $recordLoanPost = RecordLoanPost::find($recordLoanPostID);
        $recordLoanPost->user_id        = $userID;
        $recordLoanPost->record_loan_id = $recordLoanID;
        $recordLoanPost->comment        = $comment;
        $recordLoanPost->file_path      = $filePath;
        $recordLoanPost->save();
    }

}
