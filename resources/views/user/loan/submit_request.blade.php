@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/loan.css') }}" media="screen" title="no title" charset="utf-8">
    <style media="screen">
      label.btn.btn-default {
        margin-left: -1px;
        height: 40px;
        line-height: 30px;
      }

      div.bootstrap-filestyle.input-group input[type="text"].form-control {
          height: 40px !important;
          border-color: #cbcbcb;
      }
      div.bootstrap-filestyle.input-group span.group-span-filestyle.input-group-btn label {
          background-color: #cbcbcb;
          border-color: #cbcbcb;
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

@section('header')
    <?php $lang = Session::get('language'); ?>
    <?php
        if($lang == 2){
            $headerName = "แบบฟอรมขอตัวอย่าง";
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
            $breadcump['แบบฟอรมขอตัวอย่าง'] = url('user/loan/dashboard');
            $breadcump['ส่งแบบฟอร์ม'] = url('user/loan/submit_request');
        }else{
            $breadcump['Dashboard'] = url('user/dashboard');
            $breadcump['Loan Specimen Form'] = url('user/loan/dashboard');
            $breadcump['Submit Request'] = url('user/loan/submit_request');
        }



    ?>
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript" src="{{ url('assets/script/bootstrap-filestyle.min.js') }}"></script>
    <script type="text/javascript">

        @if($lang == 2)
            $(":file").filestyle({buttonText: " ค้นหาไฟล์ PDF"});
        @else
            $(":file").filestyle({buttonText: " Browse PDF"});
        @endif

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $date = $('#loan_date').datepicker({
            format : 'dd-mm-yyyy',
            clearBtn: true,

            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        });

        $("form").submit(function(e) {
          var ref = $(this).find("[required]");
          $(ref).each(function(){
            if ( $(this).val() == '' ) {
              alert("Required field should not be blank.");
              $(this).focus();
              e.preventDefault();
              return false;
            }
          });
          $('#myModal').modal('show');
          return true;
        });

    </script>
@endsection

@section('contain')

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @if($lang == 2)
                    <div class="modal-body">
                        <h2 style="width:inherit;text-align:center;">ขอบคุณ</h2>
                        <div style="width:100%;text-align:center;">ทางกรมฯ ได้รับคำร้องขอยืมตัวอย่างเป็นที่เรียบร้อย</div>
                        <div style="width:100%;text-align:center;">คุณสามารถตรวจสอบสถานะล่าสุดของคำร้องได้ที่</div>
                        <div style="width:100%;text-align:center;">หน้าแบบฟอร์มขอยืมตัวอย่าง หรือ หน้าประวัติการขอยืม</div>
                        <div class="center" style="width:100%;">
                            <button type="button" class="btn btn-ton-gold" data-dismiss="modal">ดำเนินการต่อ</button>
                        </div>
                    </div>
                @else
                    <div class="modal-body">
                        <h2 style="width:inherit;text-align:center;">THANK YOU</h2>
                        <div style="width:100%;text-align:center;">The form was submitted successfully</div>
                        <div style="width:100%;text-align:center;">You can view the status update from Loan Specimen or History page</div>
                        <div class="center" style="width:100%;">
                            <button type="button" class="btn btn-ton-gold" data-dismiss="modal">Continue</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
    <div class="row">
        <div class="col-md-offset-3 col-md-6 ">
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

    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="submit-request-block">

                <p class="submit-request-header">
                    @if($lang == 2)
                        ส่งแบบฟอร์มขอยืมตัวอย่าง
                    @else
                        Submit Request
                    @endif
                </p>

                <form class="form-horizontal" method="post" action="{{ url('user/loan/submit_request') }}" enctype="multipart/form-data" >

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <p class="submit-request-sub-header">
                        @if($lang == 2)
                            กรุณาเลือกศูนย์วิจัยที่ต้องการยืมตัวอย่าง
                        @else
                            Marine Center
                        @endif
                    </p>
                    @if(!empty($marineList))
                        @foreach($marineList as $marine)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="marine" value="{{ $marine->id }}" required/>
                                    @if($lang == 2)
                                        {{ $marine->marinecenter_th }} ( {{ $marine->marinecenter_code }} )
                                    @else
                                        {{ $marine->marinecenter }}
                                    @endif

                                </label>
                            </div>
                        @endforeach
                    @else
                    <p class="submit-request-sub-header">No marine center list. Please, contact administrator.</p>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <p class="submit-request-sub-header">
                                @if($lang == 2)
                                    วันที่เริ่มยืม
                                @else
                                    Start Date
                                @endif
                            </p>
                            <div class='input-group'>
                                <input type='text' id='loan_date' class="form-control" name="loan_date" placeholder="Calendar" readonly required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <p class="submit-request-sub-header">
                                @if($lang == 2)
                                    จำนวนวันที่ยืม
                                @else
                                    Days
                                @endif
                            </p>
                            <input class="form-control" type="number" name="loan_days" placeholder="00" min="1" required />
                        </div>
                        <div class="col-md-6">
                            @if($lang == 2)
                                <p class="submit-request-sub-header">แนบไฟล์ PDF <span class="submit-request-sub-header-small">(ขนาดไม่เกิน 25 MiB)</span></p>
                            @else
                                <p class="submit-request-sub-header">Upload Request Form <span class="submit-request-sub-header-small">(PDF only, 25MiB)</span></p>
                            @endif
                            <input type="file" name="loan_file" accept="application/pdf" required />
                        </div>
                    </div>

                    <div class="row row-btn">
                        <div class="col-md-12 center">
                            <button type="submit" class="btn-ton-gold" id="submit-request"> <!-- data-toggle='modal' data-target='#myModal' -->
                                @if($lang == 2)
                                    ส่งข้อความ
                                @else
                                    Submit Request
                                @endif
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
