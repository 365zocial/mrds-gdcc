<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Model\RecordLoan;
use App\Model\RecordLoanPost;
use App\Model\RecordLoanLog;
use App\Model\Marinecenter;
use App\Model\Users;

use App\Model\AllMean;

use Config;
use Validator;
use Auth;
use Session;
use Mail;

class LoanController extends Controller
{

    #-----------------------#
    # Loan Specimen By User #
    #-----------------------#

    # User - Dashboard
    public function dashboard()
    {
        // Get user_id
        $user_id = Auth::user()->id;

        // Get All Record Loan From Database Follow .
        $loanList = RecordLoan::select(   'marinecenter_code' , 'record_loan.id as id',
                                          'start_date'        , 'end_date',
                                          'credit'            , 'record_loan.status as status' )
                      ->where('record_loan.user_id', $user_id)
                      ->orderBy('record_loan.updated_at', 'DESC')
                      ->join('marinecenter', 'record_loan.marinecenter_id', '=', 'marinecenter.id')
                      ->get();

        // Get All Loan Status Name.
        $loanStatus = $this->getLoanStatusList();

        // Go to Dashboard Page.
        return view('user.loan.dashboard', compact('loanList', 'loanStatus'));

    }

    # User - Submit Request Page.
    public function submitRequest()
    {

        // Get All Maringcenter.
        $marineList = Marinecenter::whereIn('id', [1, 2])->get();

        // Go to Submit Request Page.
        return view('user.loan.submit_request', compact('marineList'));

    }

    # User - Insert Record Loan to Database.
    public function submitRequestInsert(Request $requests)
    {

        // Validate Form
        $validator = Validator::make($requests->all(), [
            'marine'    => 'required',
            'loan_date' => 'required',
            'loan_days' => 'required',
            'loan_file' => 'required|mimes:pdf|max:25000',
        ], [
            'marine.required'     => 'The Marinecenter field is required.',
            'loan_date.required'  => 'The Loan date field is required.',
            'loan_days.required'  => 'The Number of Days is required.',
            'loan_file.required'  => 'The PDF form is required.',
            'loan_file.mimes'     => 'Your upload file is not pdf file format.',
            'loan_file.max'       => 'Your upload file is more than 25 MB.',
        ]);

        // Validate Failure
        if ($validator->fails()) {
            return redirect('/user/loan/submit_request')
                      ->withErrors($validator)
                      ->withInput();
        }

        // Create End Date Variable.
        $EndDate = date('Y-m-d', strtotime('+ ' . $requests->input('loan_days') . ' days', strtotime($requests->input('loan_date'))));

        // Save Record Loan to Database.
        $recordLoan = new RecordLoan;
        $recordLoan->marinecenter_id  = $requests->input('marine');
        $recordLoan->user_id          = Auth::user()->id;
        $recordLoan->credit           = $requests->input('loan_days');
        $recordLoan->start_date       = date('Y-m-d', strtotime($requests->input('loan_date')));
        $recordLoan->end_date         = $EndDate;
        $recordLoan->status           = 1;
        $recordLoan->remark           = "";
        $recordLoan->save();

        // Get Newest ID.
        $recordLoanID = RecordLoan::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first()->id;

        // Save File on Website.
        $file             = $requests->file('loan_file'); // $originalFileName = $file->getClientOriginalName();
        $fileName         = $this->generateID($recordLoanID, 6).'_'.strtotime(date("Y-m-d H:i:s")).'.'.$file->getClientOriginalExtension();
        $destinationPath  = 'uploads/loan_pdf';
        $uploadStatus     = $requests->file('loan_file')->move($destinationPath, $fileName);

        // Insert Comment to Database.
        $recordLoanPost = new RecordLoanPost;
        $recordLoanPost->user_id        = Auth::user()->id;
        $recordLoanPost->record_loan_id = $recordLoanID;
        $recordLoanPost->comment        = "";
        $recordLoanPost->file_path      = $fileName;
        $recordLoanPost->save();

        $mailing = $this->emailSubmitRequest($recordLoanID);
        if($mailing) {
          // Add Session.
          Session::put('success', 'You sent loan specimen information is successfully, wait for administrator check your loan specimen information and callback.');
        } else {
          Session::put('failure', 'Your comment is sent. But email system is error. Please contact administrator.');
        }

        // Redirect to Dashboard Page.
        return redirect('user/loan/dashboard');

    }

    # User - View Request.
    public function viewRequest($recordLoanID)
    {

        // Decode Record Loan ID.
        $recordLoanID = base64_decode(base64_decode(base64_decode($recordLoanID)));

        // Get Record Loan Form Database.
        $recordLoan = RecordLoan::find($recordLoanID);
        $recordLoanPostList = RecordLoanPost::select('comment','file_path','record_loan_post.created_at', 'first_name', 'last_name', 'role_id')
                            ->join('users', 'record_loan_post.user_id', '=', 'users.id')
                            ->where('record_loan_id', $recordLoanID)
                            ->orderBy('record_loan_post.id')
                            ->get();

        // Generate ID From Record Loan ID. (Method in Controller)
        $recordLoanID = $this->generateID($recordLoanID, 6);

        // Get Loan Status Name (Method in Controller)
        $loanStatus = $this->getLoanStatusList();

        // Get Last PDF From Database.
        $lastRecordLoanFile = RecordLoanPost::join('users', 'record_loan_post.user_id', '=', 'users.id')
                                  ->where('file_path', '!=', '')
                                  ->where('record_loan_id', $recordLoanID)
                                  ->orderBy('record_loan_post.id', 'DESC')
                                  ->first()->file_path;

        $marineCenter = Marinecenter::find($recordLoan->marinecenter_id)->marinecenter_code;

        // Go to View Request Page.
        return view('user.loan.view_request', compact('recordLoan', 'recordLoanID', 'recordLoanPostList', 'loanStatus', 'lastRecordLoanFile', 'marineCenter'));
    }

    # User - Insert Comment to Database.
    public function viewRequestInsert(Request $requests, $recordLoanID)
    {

        // Transform String('000001') to Int(1) (Record Loan ID).
        $intRecordLoanID = intval($recordLoanID);

        // Validate Form
        $validator = Validator::make($requests->all(), [
            'loan_comment'    => 'required',
            // 'loan_file'       => 'required|mimes:pdf|max:25000',
        ], [
            'loan_comment.required' => 'The Marinecenter field is required.',
            // 'loan_file.required'    => 'The PDF form is required.',
            // 'loan_file.mimes'       => 'Your upload file is not pdf file format.',
            // 'loan_file.max'         => 'Your upload file is more than 25 MB.',
        ]);

        // Validate Failure
        if ($validator->fails()) {
            return redirect('/user/loan/view_request/'.base64_encode(base64_encode(base64_encode($intRecordLoanID))))
                      ->withErrors($validator)
                      ->withInput();
        }

        // Saved Comment.
        $recordLoanPost = new RecordLoanPost;
        $recordLoanPost->user_id        = Auth::user()->id;
        $recordLoanPost->record_loan_id = $intRecordLoanID;
        $recordLoanPost->comment        = $requests->loan_comment;
          // Save File on Website
          if( $requests->hasFile('loan_file') ) {
            $file             = $requests->file('loan_file');
            $fileName         = $recordLoanID.'_'.strtotime(date("Y-m-d H:i:s")).'.'.$file->getClientOriginalExtension();
            $destinationPath  = 'uploads/loan_pdf';
            $uploadStatus     = $requests->file('loan_file')->move($destinationPath, $fileName);
            $recordLoanPost->file_path      = $fileName;
          }
        $recordLoanPost->save();

        // Change Status
        $recordLoan = RecordLoan::find($intRecordLoanID);

          // Saved Status Log.
          $recordLoanLog = new RecordLoanLog;
          $recordLoanLog->action          = "Change Status.";
          $recordLoanLog->record_loan_id  = $intRecordLoanID;
          $recordLoanLog->old_data        = $recordLoan->status;
          $recordLoanLog->new_data        = 3;
          $recordLoanLog->user_id         = Auth::user()->id;
          $recordLoanLog->save();

        $recordLoan->status = 3;
        $recordLoan->save();

        $mailing = $this->emailComment($intRecordLoanID, 2);

        if($mailing) {
          // Add Session.
          Session::put('success', 'Your comment sent to administrator. The Administrator will callback when read your comment.');
        } else {
          Session::put('failure', 'Your comment is sent. But email system is error. Please contact administrator.');
        }

        // Redirect to View Request Page.
        return redirect('/user/loan/view_request/'.base64_encode(base64_encode(base64_encode($intRecordLoanID))));

    }
    #-----------------------#


    #--------------------------#
    # Loan Specimen By Manager #
    #--------------------------#

    # Manager - Dashboard Page
    public function managerDashboard()
    {

        // Get All Record Loan From Database Follow Marinecenter.
        $recordLoanList = RecordLoan::select(
                              'marinecenter_code' , 'record_loan.id as id',
                              'start_date'        , 'end_date',
                              'credit'            , 'record_loan.status as status' )
                      ->join('marinecenter', 'record_loan.marinecenter_id', '=', 'marinecenter.id')
                      ->where('marinecenter_id', Auth::user()->marinecenter_id)
                      ->orderBy('record_loan.updated_at', 'DESC')
                      ->get();

        // Get All Loan Status Name.
        $loanStatus = $this->getLoanStatusList();

        // Go to Dashboard Page.
        return view('staff.loan.dashboard', compact('recordLoanList', 'loanStatus'));
    }

    # Manager - View Request Page
    public function managerViewRequest($recordLoanID)
    {

        // Decode Record Loan ID.
        $recordLoanID = base64_decode(base64_decode(base64_decode($recordLoanID)));

        // Get Record Loan Data From Database.
        $recordLoan = RecordLoan::select('marinecenter_code', 'record_loan.id', 'record_loan.status', 'start_date', 'end_date', 'credit')
                          ->join('marinecenter', 'record_loan.marinecenter_id', '=', 'marinecenter.id')
                          ->where('record_loan.id', $recordLoanID)
                          ->where('marinecenter_id', Auth::user()->marinecenter_id)
                          ->first();

        // Check Empty Data.
        if(empty($recordLoan)) {
          Session::put('failure', 'Your Loan Record is not found.');
          return redirect('/staff/loan/dashboard');
        }

        // Get All Comment From Database.
        $recordLoanPostList = RecordLoanPost::select('comment','file_path','record_loan_post.created_at', 'first_name', 'last_name', 'role_id')
                            ->join('users', 'record_loan_post.user_id', '=', 'users.id')
                            ->where('record_loan_id', $recordLoanID)
                            ->orderBy('record_loan_post.id')
                            ->get();

        // Generate ID From Record Loan ID. (Method in Controller)
        $recordLoanID = $this->generateID($recordLoanID, 6);

        // Get Loan Status Name (Method in Controller)
        $loanStatus = $this->getLoanStatusList();

        // Get Last PDF File From Database.
        $lastRecordLoanFile = RecordLoanPost::join('users', 'record_loan_post.user_id', '=', 'users.id')
                                  ->where('file_path', '!=', '')
                                  ->where('record_loan_id', $recordLoanID)
                                  ->orderBy('record_loan_post.id', 'DESC')
                                  ->first()->file_path;

        // Go to View Request Page.
        return view('staff.loan.view_request', compact('recordLoan', 'recordLoanID', 'recordLoanPostList', 'loanStatus', 'lastRecordLoanFile'));

    }

    # Manager - Insert Comment to database
    public function managerViewRequestInsert(Request $requests, $recordLoanID)
    {

        // Transform String('000001') to Int(1) (Record Loan ID).
        $intRecordLoanID = intval($recordLoanID);

        // Validate Form.
        $validator = Validator::make($requests->all(), [
            'loan_comment' => 'required',
        ], [
            'loan_comment.required' => 'The Marinecenter field is required.',
        ]);

        // Validate Failure.
        if ($validator->fails()) {
            return redirect('/staff/loan/view_request/'.base64_encode(base64_encode(base64_encode($intRecordLoanID))))
                      ->withErrors($validator)
                      ->withInput();
        }

        // Saved Comment.
        $recordLoanPost = new RecordLoanPost;
        $recordLoanPost->user_id        = Auth::user()->id;
        $recordLoanPost->record_loan_id = $intRecordLoanID;
        $recordLoanPost->comment        = $requests->loan_comment;
        $recordLoanPost->file_path      = '';
        $recordLoanPost->save();

        // Change Status.
        $recordLoan = RecordLoan::find($intRecordLoanID);

          // Saved Status Log.
          $recordLoanLog = new RecordLoanLog;
          $recordLoanLog->action          = "Change Status.";
          $recordLoanLog->record_loan_id  = $intRecordLoanID;
          $recordLoanLog->old_data        = $recordLoan->status;
          $recordLoanLog->new_data        = 2;
          $recordLoanLog->user_id         = Auth::user()->id;
          $recordLoanLog->save();

        $recordLoan->status = 2;
        $recordLoan->save();

        $mailing = $this->emailComment($intRecordLoanID, 1);

        if($mailing) {
          // Add Session.
          Session::put('success', 'Your comment sent to User.');
        } else {
          Session::put('failure', 'Your comment is sent. But email system is error. Please contact administrator.');
        }

        // Redirect to View Request Page.
        return redirect('/staff/loan/view_request/'.base64_encode(base64_encode(base64_encode($intRecordLoanID))));
    }

    # Manager - Update Status.
    public function managerUpdateStatus(Request $requests, $recordLoanID)
    {

        // Transform String('000001') to Int(1) (Record Loan ID).
        $intRecordLoanID = intval($recordLoanID);

        // Validate Form.
        $validator = Validator::make($requests->all(), [
            'loan_status' => 'required',
        ], [
            'loan_status.required' => 'The Marinecenter field is required.',
        ]);

        // Validate Failure.
        if ($validator->fails()) {
            return redirect('/staff/loan/view_request/'.$intRecordLoanID)
                      ->withErrors($validator)
                      ->withInput();
        }

        // Changed Status.
        $recordLoan = RecordLoan::find($intRecordLoanID);

          // Saved Status Log.
          $recordLoanLog = new RecordLoanLog;
          $recordLoanLog->action          = "Change Status.";
          $recordLoanLog->record_loan_id  = $intRecordLoanID;
          $recordLoanLog->old_data        = $recordLoan->status;
          $recordLoanLog->new_data        = $requests->loan_status;
          $recordLoanLog->user_id         = Auth::user()->id;
          $recordLoanLog->save();

        $recordLoan->status = $requests->loan_status;
        $recordLoan->save();

        $mailing = $this->emailChangeStatus($intRecordLoanID);

        if($mailing) {
          // Add Session.
          Session::put('success', 'Your loan status is changed.');
        } else {
          Session::put('failure', 'Your loan status is changed. But email system is error. Please contact administrator.');
        }

        // Redirect to Dashboard Page.
        return redirect('/staff/loan/dashboard');
    }

    #--------------------------#

    # Generate ID ( Add String )
    public function generateID($ID, $number)
    {
        # $number is string of length.
        $newID = $ID;
        for ($i=strlen($ID); $i < $number; $i++) { $newID = '0'.$newID; }
        return $newID;
    }

    # Get All Loan Status Name.
    public function getLoanStatusList()
    {
        if(Session::get('language') == 2){
            return array( '1' => 'รอการอนุมัติ'    , '2' => 'เอกสารไม่สมบูรณ์',
            '3' => 'ยื่นเอกสารแล้ว'  , '4' => 'อนุมัติ',
            '5' => 'รับตัวอย่างแล้ว' , '6' => 'ส่งตัวอย่างคืนแล้ว',
            '7' => 'ปฎิเสธการอนุมัติ' );
        }else{
            return array( '1' => 'Waiting'    , '2' => 'Incomplete documentation',
            '3' => 'Submitted'  , '4' => 'Approved',
            '5' => 'Get Record' , '6' => 'Return Record',
            '7' => 'Rejected' );
        }
    }

    #------------------------------#
    # Sent Email For Loan Specimen #
    #------------------------------#

    # Email - Submit Request From User
    public function emailSubmitRequest($recordLoanID)
    {
        $recordLoan = RecordLoan::find($recordLoanID);
        $user = Users::find($recordLoan->user_id);
        $managers = Users::where('marinecenter_id', $recordLoan->marinecenter_id)
                        ->where('role_id', 3)
                        ->get();
        $marinecenter = Marinecenter::find($recordLoan->marinecenter_id)->marinecenter;

        # User Email
        $data = array(  'record_loan_id'  => $this->generateID($recordLoanID, 6),
                        'loan_status'     => "Pending",
                        'user_name'       => $user->first_name.' '.$user->last_name,
                        'comment'         => "Thank you for contact Marine Resources Database System - Loan Reference Collection. We got your request already and we will contact you back via email.",
                        'url'             => url('/').'/user/loan/view_request/'.base64_encode(base64_encode(base64_encode($recordLoanID))),
                        'link_name'       => "URL User",
                    );

        $emails = null;
        $emails[] = $user->email;

        // Sent Email User
        Mail::send('emails.loan.submit_request', $data, function ($message) use ($emails) {
            $message->to($emails)
                    ->subject('MRDS Loan Specimen Notification - Submit Request');
        });

        $emails = null;
        foreach ($managers as $manager) { $emails[] = $manager->email; }

        $data['user_name'] = "Manager ".$marinecenter;
        $data['comment'] = "You have a new contact Marine Resources Database System - Loan Reference Collection.";
        $data['url'] = url('/').'/staff/loan/view_request/'.base64_encode(base64_encode(base64_encode($recordLoanID)));
        $data['link_name'] = "URL Manager";

        // Sent Email Administrator
        Mail::send('emails.loan.submit_request', $data, function ($message) use ($emails) {
            $message->to($emails)
                    ->subject('MRDS Loan Specimen Notification - Submit Request');
        });

        // Check Error Email
        if( count(Mail::failures()) > 0 ) {
            // echo "There was one or more failures. They were: <br />";
            // foreach(Mail::failures as $email_address) {
            //   echo " - $email_address <br />";
            // }
            return false;
        } else {
            return true;
        }

    }

    # Email - Comment
    public function emailComment($recordLoanID, $method)
    {

        $recordLoan = RecordLoan::find($recordLoanID);
        $loanStatus = $this->getLoanStatusList();
        $marinecenter = Marinecenter::find($recordLoan->marinecenter_id)->marinecenter;

        $user = Users::find($recordLoan->user_id);
        $data = array(  'record_loan_id'  => $this->generateID($recordLoanID, 6),
                        'loan_status'     => $loanStatus[$recordLoan->status],
                        'user_name'       => $user->first_name.' '.$user->last_name,
                        'comment'        => RecordLoanPost::where('record_loan_id', $recordLoanID)->orderBy('id', 'DESC')->first()->comment,
                        'url'             => url('/').'/user/loan/view_request/'.base64_encode(base64_encode(base64_encode($recordLoanID))),
                        'link_name'       => "URL User",
                  );

        $emails = null;
        if($method === 1) { # 1 : Manager to User, 2 : User to Manager.
          $user = Users::find($recordLoan->user_id);
          $emails[] = $user->email;
        } else {
          $data['user_name'] = "Manager ".$marinecenter;
          $data['comment'] = RecordLoanPost::where('record_loan_id', $recordLoanID)->where('user_id', $recordLoan->user_id)->orderBy('id', 'DESC')->first()->comment;
          $data['url'] = url('/').'/staff/loan/view_request/'.base64_encode(base64_encode(base64_encode($recordLoanID)));
          $data['link_name'] = "URL Manager";

          $users = Users::where('marinecenter_id', $recordLoan->marinecenter_id)
                        ->where('role_id', 3)
                        ->get();
          foreach ($users as $user) { $emails[] = $user->email; }
        }

        // Sent Email
        Mail::send('emails.loan.comment', $data, function ($message) use ($emails) {
            $message->to($emails)
                    ->subject('MRDS Loan Specimen Notification - New Comment');
        });

        // Check Error Email
        if( count(Mail::failures()) > 0 ) {
            return false;
        } else {
            return true;
        }

    }

    # Email - Loan Specimen Change Status
    public function emailChangeStatus($recordLoanID)
    {

        $recordLoan = RecordLoan::find($recordLoanID);
        $user = Users::find($recordLoan->user_id);
        $emails[] = $user->email;

        // Get All Loan Status Name.
        $loanStatus = $this->getLoanStatusList();

        $user = Users::find($recordLoan->user_id);
        $data = array(  'record_loan_id'  => $this->generateID($recordLoanID, 6),
                        'loan_status'     => $loanStatus[$recordLoan->status],
                        'user_name'       => $user->first_name.' '.$user->last_name,
                        'comment'         => "Your loan specimen request have a new status.",
                        'url'             => url('/').'/user/loan/view_request/'.base64_encode(base64_encode(base64_encode($recordLoanID))),
                        'link_name'       => "URL User",
                  );

        // Sent Email
        Mail::send('emails.loan.change_status', $data, function ($message) use ($emails) {
            $message->to($emails)
                    ->subject('MRDS Loan Specimen Notification - Changed Status');
        });

        // Check Error Email
        if( count(Mail::failures()) > 0 ) {
            return false;
        } else {
            return true;
        }

    }

    # Reclaim Loan Specimen By Manager
    public function emailReclaim()
    {

        $recordLoanList = RecordLoan::where('status', 5)->get();
        if(!empty($recordLoanList)) {

            $getReclaimDate = RecordLoan::getReclaimDate();

            for ( $i=0; $i < count($getReclaimDate); $i++ ) {
                $recordLoanList = RecordLoan::select('record_loan.id', 'first_name', 'last_name', 'record_loan.marinecenter_id', 'email', 'start_date', 'end_date')
                                        ->join('users', 'record_loan.user_id', '=', 'users.id')
                                        ->where('record_loan.status', 5)
                                        ->where('end_date', $getReclaimDate[$i]['condition'], $getReclaimDate[$i]['date'])
                                        ->get();


                if(!empty($recordLoanList)) {
                    $data['reclaim_name'] = $getReclaimDate[$i]['name'];

                    foreach ($recordLoanList as $recordLoan) {
                        $data['user_name']            = $recordLoan->first_name." ".$recordLoan->last_name;
                        $data['request_id']           = $this->generateID($recordLoan->id, 6);
                        $data['start_date']           = date('d M Y', strtotime($recordLoan->start_date));
                        $data['end_date']             = date('d M Y', strtotime($recordLoan->end_date));
                        $data['marinecenter']         = Marinecenter::find($recordLoan->marinecenter_id)->marinecenter;
                        $data['marinecenter_address'] = Marinecenter::find($recordLoan->marinecenter_id)->address;
                        $data['email']                = $recordLoan->email;

                        // Sent Email Function
                        Mail::send('emails.loan.reclaim', $data, function ($message) use ($data) {
                            $message->to($data['email'])
                                    ->subject('MRDS Loan Specimen Notification - Reclaim Specimen');
                        });

                        // Check Error Email
                        if( count(Mail::failures()) > 0 ) {
                            RecordLoanLog::reclaimEmailFailure($recordLoan->id, $data['email'], json_encode($data, true));
                        } else {
                            RecordLoanLog::reclaimEmailSuccess($recordLoan->id, $data['email'], json_encode($data, true));
                        }
                    }
                }
            }
        }

    }

    public function emailReclaimRecord(Request $request)
    {
        $recordLoan = RecordLoan::select('record_loan.id', 'first_name', 'last_name', 'record_loan.marinecenter_id', 'email', 'start_date', 'end_date')
                                ->join('users', 'record_loan.user_id', '=', 'users.id')
                                ->where('record_loan.status', 5)
                                ->first();

        if( !empty($recordLoan->id) ) {

            $data['user_name']            = $recordLoan->first_name." ".$recordLoan->last_name;
            $data['request_id']           = $this->generateID($recordLoan->id, 6);
            $data['marinecenter']         = Marinecenter::find($recordLoan->marinecenter_id)->marinecenter;
            $data['marinecenter_address'] = Marinecenter::find($recordLoan->marinecenter_id)->address;
            $data['email']                = $recordLoan->email;

            // Sent Email Function
            Mail::send('emails.loan.reclaim_manual', $data, function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject('MRDS Loan Specimen Notification - Reclaim Specimen');
            });

            // Check Error Email
            if( count(Mail::failures()) > 0 ) {
                RecordLoanLog::reclaimEmailFailure($recordLoan->id, $data['email'], json_encode($data, true));
            } else {
                RecordLoanLog::reclaimEmailSuccess($recordLoan->id, $data['email'], json_encode($data, true));
            }
            return 1;

        }

        return 0;

    }

    #------------------------------#

}
