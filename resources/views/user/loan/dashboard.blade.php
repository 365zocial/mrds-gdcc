@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/loan.css') }}" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">
        function download(file) { window.location=file; }
    </script>
@endsection

@section('header')
    <?php $lang = Session::get('language'); ?>
    <?php
        if($lang == 2){
            $headerName = "แบบฟอร์มขอตัวอย่าง";
        }else{
            $headerName = "Loan Specimen Form";
        }
        $iconFileName = "icon_dashboard_manager/loan_specimen.png";
     ?>
@endsection

@section('breadcump')
    <?php
        if($lang == 2){
            $breadcump['หน้าควบคุม'] = url('user/dashboard');
            $breadcump['แบบฟอร์มขอตัวอย่าง'] = url('user/loan/dashboard');
        }else{
            $breadcump['Dashboard'] = url('user/dashboard');
            $breadcump['Loan Specimen Form'] = url('user/loan/dashboard');
        }

    ?>
@endsection

@section('contain')

    @if (Session::has('success'))
    <div class="row">
        <div class="col-md-offset-3 col-md-6 ">
            <div class="alert alert-success alert-dismissible loan-alert-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Successfully!</strong> {{ Session::get('success') }}
                {{ Session::forget('success') }}
            </div>
        </div>
    </div>
    @endif

    @if (Session::has('failure'))
    <div class="row">
        <div class="col-md-offset-3 col-md-6 ">
            <div class="alert alert-danger alert-dismissible loan-alert-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Successfully!</strong> {{ Session::get('failure') }}
                {{ Session::forget('failure') }}
            </div>
        </div>
    </div>
    @endif

    <div class="row" style="padding-top: 10px;">
        <div class="col-md-12">
            <p class="loan-header">
                @if($lang == 2)
                    คำแนะนำ
                @else
                    Recommendations
                @endif
            </p>
            <p class="loan-sub-header">
                @if($lang == 2)
                    กรุณาดาวน์โหลดแบบฟอร์มการขอยืมตัวอย่างก่อนทำการยืม
                @else
                    RecommendationsPlease download the request from before submission.
                @endif

            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-0 col-md-3"></div>
        <div class="col-sm-6 col-md-3">
            <a class="box-link" href="{{ url('user/loan/submit_request') }}">
                <div class="loan-block">
                    <img class="big-icon" src="{{ URL::asset('assets/images/icon_submit_request.png') }}" />
                    <p class="loan-header">
                        @if($lang == 2)
                            ส่งแบบฟอร์มขอยืม
                        @else
                            Submit request
                        @endif
                    </p>
                    <p class="loan-sub-header">&nbsp;</p>
                </div>
            </a>
        </div>
        <?php //onclick="window.location = '/uploads/loan_pdf/000002_1461571676.pdf';" ?>
        <div class="col-sm-6 col-md-3">
            <a class="box-link" href="{{ url('uploads/specimen_invoice.zip') }}">
                <div class="loan-block">
                    <img class="big-icon" src="{{ URL::asset('assets/images/icon_download_file.png') }}" />
                    <p class="loan-header">
                        @if($lang == 2)
                            ดาวน์โหลดแบบฟอร์มตัวอย่าง
                        @else
                            Download form
                        @endif
                    </p>
                    <p class="loan-sub-header">
                        @if($lang == 2)

                        @else
                            to submit a request
                        @endif
                    </p>
                </div>
            </a>
        </div>
        <div class="col-sm-0 col-md-3"></div>
    </div>

    <div class="row" style="padding-top: 10px;">
        <div class="col-md-12">
            <p class="loan-header">
                @if($lang == 2)
                    ประวัติการติดตอขอยืมตัวอย่าง
                @else
                    All submitted requests
                @endif
            </p>
            <div class="table-responsive" style="margin-bottom: 20px;">
                <table id="result" class="table table-striped" padding="5">
                    <thead>
                        <tr>
                            @if($lang == 2)
                                <th>ลำดับที่</th>
                                <th>ศูนย์วิจัย</th>
                                <th>หมายเลขร้องขอ</th>
                                <th>วันที่เริ่มขอยืม</th>
                                <th>วันที่สิ้นสุดการยืม</th>
                                <th>จำนวนวัน</th>
                                <th>สถานะ</th>
                                <th class="center">ตัวเลือก</th>
                            @else
                                <th>No.</th>
                                <th>Marine Center Code</th>
                                <th>ID Request</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th class="center">Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                    @if($loanList->isEmpty())
                    @else
                        @foreach($loanList as $i => $loan)
                            <tr>
                                <td>{{ $i+=1 }}</td>
                                <td>{{ $loan->marinecenter_code }}</td>
                                <td>
                                  <?php $loanID = $loan->id; for ($i=strlen($loan->id); $i < 6; $i++) { $loanID = '0'.$loanID; } ?>
                                  {{ $loanID }}
                                </td>
                                <td>{{ AllMean::ReplaceNullWithDefaultDate($loan->start_date) }}</td>
                                <td>{{ AllMean::ReplaceNullWithDefaultDate($loan->end_date) }}</td>
                                <td>{{ $loan->credit }}</td>
                                <td><span class="@if($loan->status===4) loan-status-approve @elseif($loan->status===7) loan-status-reject @endif">{{ $loanStatus[$loan->status] }}</span></td>
                                <td class="center col-manage">
                                    <a href="{{ url('user/loan/view_request', base64_encode(base64_encode(base64_encode($loan->id)))) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        @if($lang == 2)
                                             ดูรายละเอียด
                                        @else
                                            View Request
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ( sizeof( $loanList ) )
            <div class="col-md-12">
                <center>
                    <a href="{{ url('user/loan/export_loan_user') }}"><button type="button" class="btn btn-default btn-gold">Export Loan</button></a>
                    <a href="{{ url('user/referenceLoan') }}"><button type="button" class="btn btn-default btn-gold">Reference List</button></a>
                </center>
            </div>
        @endif
    </div>
@endsection
