<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Excel;
use App\Model\ExportLog;
use App\Model\Marinecenter;
use App\Model\RecordLoan;
use Session;

class ExportLoanController extends Controller
{

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

    //Sorawit
	//Created : 29-7-59
	//Modified : -
    # export loan list csv for manager
    public function exportLoanManager() {
        // Get marinecenter_id
        $marinecenter_id = Auth::user()->marinecenter_id;

        // Get All Record Loan From Database Follow .
        $loanList = RecordLoan::select(   'marinecenter_code' , 'record_loan.id as id',
                                          'start_date'        , 'end_date',
                                          'credit'            , 'record_loan.status as status' )
                      ->where('record_loan.marinecenter_id',$marinecenter_id)
                      ->orderBy('record_loan.updated_at', 'DESC')
                      ->join('marinecenter', 'record_loan.marinecenter_id', '=', 'marinecenter.id')
                      ->get();

        // Get All Loan Status Name.
        $loanStatus = $this->getLoanStatusList();

        // created export date
        $date = date_create();
        $date_export = date_format( $date, "d-m-Y H:i:s" );
        $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );

        //---- make file excel ----
        $name_file = 'Export_Loan_Manager_'.$date_export_file_name;
        Excel::create( $name_file, function( $excel ) use ( $loanList, $loanStatus, $date_export ) {
            $excel->sheet( 'Record Data', function( $sheet ) use ( $loanList, $loanStatus, $date_export ) {

               //--- Set Parameter ---
                   $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';

                   if ( !is_null( $loanList ) ) {

                       //--- -------------------- ---

                       //--- Header Part ---
                           $sheet->row( 2, array( 'Export Information' ) );
                           $sheet->row( 3, array( 'Export By: '.$user_name ) );
                           $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                           $sheet->row( 6, array( 'Data Information' ) );
                           $sheet->row( 7, array( 'Loan List' ) );
                       //--- ----------- ---

                       //--- Header Table Part ---
                           $sheet->row(9, array(
                               'MarineCenter Code', 'ID Request', 'Start Date', 'End Date', 'Days', 'Status'
                           ));
                       //--- ----------------- ---

                       //--- Content Part ---
                           // display data
                               $row_number = 10;   // start line
                               foreach ( $loanList as $data ) {
                                   $loanID = $data->id; for ($i=strlen($data->id); $i < 6; $i++) { $loanID = '0'.$loanID; }


                                    $sheet->row( $row_number, array(
                                        $data->marinecenter_code, $loanID, date('d-m-Y', strtotime( $data->start_date ) ), date('d-m-Y', strtotime( $data->end_date ) ), $data->credit, $loanStatus[$data->status]
                                       ));
                                   $row_number++;
                               }
                       //--- ------------ ---

                   }
               //--- ------------- ---
           });
       })->store('csv', public_path("export_loan"));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog( 0, $name_file );

        return redirect('export_loan/'.$name_file.'.csv');
    }

    //Sorawit
	//Created : 1-8-59
	//Modified : -
    # export loan list csv for user
    public function exportLoanUser() {
        // Get marinecenter_id
        $user_id = Auth::user()->id;

        // Get All Record Loan From Database Follow .
        $loanList = RecordLoan::select(   'marinecenter_code' , 'record_loan.id as id',
                                          'start_date'        , 'end_date',
                                          'credit'            , 'record_loan.status as status' )
                      ->where('record_loan.user_id',$user_id)
                      ->orderBy('record_loan.updated_at', 'DESC')
                      ->join('marinecenter', 'record_loan.marinecenter_id', '=', 'marinecenter.id')
                      ->get();

        // Get All Loan Status Name.
        $loanStatus = $this->getLoanStatusList();

        // created export date
        $date = date_create();
        $date_export = date_format( $date, "d-m-Y H:i:s" );
        $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );

        //---- make file excel ----
        $name_file = 'Export_Loan_User_'.$date_export_file_name;
        Excel::create( $name_file, function( $excel ) use ( $loanList, $loanStatus, $date_export ) {
            $excel->sheet( 'Record Data', function( $sheet ) use ( $loanList, $loanStatus, $date_export ) {

               //--- Set Parameter ---
                   $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';

                   if ( !is_null( $loanList ) ) {

                       //--- -------------------- ---

                       //--- Header Part ---
                           $sheet->row( 2, array( 'Export Information' ) );
                           $sheet->row( 3, array( 'Export By: '.$user_name ) );
                           $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                           $sheet->row( 6, array( 'Data Information' ) );
                           $sheet->row( 7, array( 'Loan List' ) );
                       //--- ----------- ---

                       //--- Header Table Part ---
                           $sheet->row(9, array(
                               'MarineCenter Code', 'ID Request', 'Start Date', 'End Date', 'Days', 'Status'
                           ));
                       //--- ----------------- ---

                       //--- Content Part ---
                           // display data
                               $row_number = 10;   // start line
                               foreach ( $loanList as $data ) {
                                   $loanID = $data->id; for ($i=strlen($data->id); $i < 6; $i++) { $loanID = '0'.$loanID; }


                                    $sheet->row( $row_number, array(
                                        $data->marinecenter_code, $loanID, date('d-m-Y', strtotime( $data->start_date ) ), date('d-m-Y', strtotime( $data->end_date ) ), $data->credit, $loanStatus[$data->status]
                                       ));
                                   $row_number++;
                               }
                       //--- ------------ ---

                   }
               //--- ------------- ---
           });
       })->store('csv', public_path("export_loan"));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog( 0, $name_file );

        return redirect('export_loan/'.$name_file.'.csv');
    }
}
