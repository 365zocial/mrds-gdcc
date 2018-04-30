@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/loan.css') }}" media="screen" title="no title" charset="utf-8">
    <style media="screen">
        div.bootstrap-filestyle.input-group input[type="text"].form-control {
            height: 40px !important;
            border-color: #cbcbcb;
        }
        div.bootstrap-filestyle.input-group span.group-span-filestyle.input-group-btn label {
            background-color: #cbcbcb;
            border-color: #cbcbcb;
            border-bottom-width: 0px;
            color: #797979;
            padding-top: 5px;
            padding-left: 30px;
            padding-right: 30px;
        }
        span.input-group-addon {
            background-color: transparent;
            color: #cbcbcb;
        }
        input#loan_date.form-control {
            border: 1px solid #cbcbcb;
            border-right: none;
            background-color: transparent !important;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('assets/script/bootstrap-filestyle.min.js') }}"></script>

    <script type="text/javascript">
        $(":file").filestyle({buttonText: " Browse PDF"});

        $("form").submit(function(e) {
          var ref = $(this).find("[required]");
          $(ref).each(function(){
            if ( $(this).val() == '' ) {
              alert("Required field should not be blank.");
              $(this).focus();
              e.preventDefault();
              return false;
            }
          }); return true;
        });
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
            $breadcump['ดูรายละเอียดการขอยืม'] = url('user/loan/view_request');
        }else{
            $breadcump['Dashboard'] = url('user/dashboard');
            $breadcump['Loan Specimen Form'] = url('user/loan/dashboard');
            $breadcump['View Request'] = url('user/loan/view_request');
        }


    ?>
@endsection

@section('contain')

    @if (Session::has('success'))
    <div class="row row-centered">
        <div class=" col-md-7 col-centered">
            <div class="alert alert-success alert-dismissible loan-alert-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Successfully!</strong> {{ Session::get('success') }}
                {{ Session::forget('success') }}
            </div>
        </div>
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="row row-centered">
        <div class="col-md-7 col-centered">
            <div class="alert alert-danger alert-dismissible loan-alert-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="row row-centered">
        <div class="col-md-9 col-centered">
            <div class="lastest-loan-post">
                <div class="row row-btn">
                    <div class="col-md-12">
                        <p class="main-text">
                            <strong>
                                @if($lang == 2)
                                    ศูนย์วิจัย
                                @else
                                    Marine Center:
                                @endif
                            </strong> {{ $marineCenter }}
                        </p>
                    </div>
                </div>
                <div class="row row-btn">
                    <div class="col-md-5">
                        <p class="sub-text">
                            <strong>
                                @if($lang == 2)
                                    หมายเลขการร้องขอ
                                @else
                                    ID Request:
                                @endif
                            </strong> {{ $recordLoanID }}
                        </p>
                    </div>
                    <div class="col-md-5">
                        <p class="sub-text">
                            <strong>
                                @if($lang == 2)
                                    สถานะ
                                @else
                                    Status:
                                @endif
                            </strong>
                        <span class="@if($recordLoan->status===4) loan-status-approve @elseif($recordLoan->status===7) loan-status-reject @endif">{{ $loanStatus[$recordLoan->status] }}</span></p>
                    </div>
                </div>
                <div class="row row-btn">
                    <div class="col-md-5">
                        <p class="sub-text">
                            <strong>
                                @if($lang == 2)
                                    วันที่เริ่มต้น:
                                @else
                                    Start Date:
                                @endif
                            </strong>
                            {{ AllMean::ReplaceNullWithDefaultDate($recordLoan->start_date) }}
                        </p>
                    </div>
                    <div class="col-md-5">
                        <p class="sub-text">
                            <strong>
                                @if($lang == 2)
                                    วันสิ้นสุด:
                                @else
                                    End Date:
                                @endif
                            </strong>
                            {{ AllMean::ReplaceNullWithDefaultDate($recordLoan->end_date) }}
                        </p>
                    </div>
                    <div class="col-md-2">
                        <p class="sub-text">
                            <strong>
                                @if($lang == 2)
                                    ระยะเวลา:
                                @else
                                    Days:
                                @endif
                            </strong>
                            {{ $recordLoan->credit }}
                        </p>
                    </div>
                </div>
                <div class="row row-btn">
                    <div class="col-md-12">
                        <p class="sub-text">
                            <strong>
                                <a class="link-view-pdf" href="{{ "/mrds_file/uploads/loan_pdf/".$lastRecordLoanFile }}" target="_BLANK">
                                    @if($lang == 2)
                                        เรียกดูไฟล์ PDF
                                    @else
                                        View PDF File
                                    @endif
                                </a>
                            </strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-btn">
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <p class="comment-form-header">
                        @if($lang == 2)
                            รายละเอียดการติดต่อ
                        @else
                            Comment Form
                        @endif
                    </p>
                </div>
            </div>

            @if($recordLoanPostList->isEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <p>No comment.</p>
                    </div>
                </div>
            @else
                @foreach($recordLoanPostList as $recordLoanPost)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="loan-content @if($recordLoanPost->role_id===5) user-content @else admin-content @endif">
                                <p class="header">{{ $recordLoanPost->first_name }} {{ $recordLoanPost->last_name }}</p>
                                <p class="date">
                                    @if($lang == 2)
                                        วันที่:
                                    @else
                                        Date:
                                    @endif
                                    {{ AllMean::ReplaceNullWithDefaultDate($recordLoanPost->created_at) }}
                                    @if($lang == 2)
                                        เวลา:
                                    @else
                                        Time:
                                    @endif
                                    {{ AllMean::ReplaceNullWithDefaultTime($recordLoanPost->created_at) }}</p>
                                <p class="comment">{!! nl2br($recordLoanPost->comment) !!}</p>
                                @if(!empty($recordLoanPost->file_path))
                                  <p class="link">
                                      <strong>
                                          <a class="link-view-pdf" href="{{ "/mrds_file/uploads/loan_pdf/".$recordLoanPost->file_path }}" target="_BLANK">
                                              @if($lang == 2)
                                                  กดเพื่อดูไฟล์แนบ PDF
                                              @else
                                                  View PDF File
                                              @endif
                                          </a>
                                      </strong>
                                  </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            @if($recordLoan->status<=3)
            <div class="row row-comment">
                <div class="col-md-12">
                    <form class="form-horizontal" method="post" action="/user/loan/view_request/{{ $recordLoanID }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <p class="view-request-input-header">
                                    @if($lang == 2)
                                        ข้อเสนอแนะ
                                    @else
                                        Comment
                                    @endif
                                </p>
                                <textarea class="form-control" name="loan_comment" rows="6" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p class="view-request-input-header">
                                    @if($lang == 2)
                                        แนบไฟล์ PDF (ขนาดไม่เกิน 25 MiB)
                                    @else
                                        Upload PDF file
                                    @endif
                                </p>
                                <input type="file" name="loan_file" accept="application/pdf" />
                            </div>
                        </div>

                        <div class="row row-btn">
                            <div class="col-md-12 center">
                                <button type="submit" class="btn-ton-gold btn-view-request" style="font-size: 16px; padding: 10px 40px;">
                                    @if($lang == 2)
                                        ส่งข้อความ
                                    @else
                                        Send Comment
                                    @endif
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>


@endsection
