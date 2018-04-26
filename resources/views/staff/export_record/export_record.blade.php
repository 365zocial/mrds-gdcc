@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
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
      input.date_picker_search.form-control {
          border: 1px solid #cbcbcb;
          border-right: none;
          background-color: transparent !important;
      }
    </style>
@endsection

@section('script')
    @include('base_wording_js')

    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>

    <script type="text/javascript">
        $(document).ready(function() {

            // for date input
            $('#start_date').datepicker({
                format: 'dd-mm-yyyy',
                clearBtn: true,
            });
            $('#end_date').datepicker({
                format: 'dd-mm-yyyy',
                clearBtn: true,
            });

        });

    </script>
@endsection

@section('header')
    <?php
        $headerName = "Export CSV";
        $iconFileName = "icon_dashboard_manager/export_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Export CSV'] = url('staff/exportRecord');
    ?>
@endsection

@section('contain')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="content-box">
                <div class="row">
                    <div class="col-md-12">
                        <h2>SELECT TABLE AND DATE</h2>
                        <p>
                            You can search for your required information by these topics.
                        </p>
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->

                <div class="row">
                    <form action="{{ url('staff/doExportRecord') }}" method="post" id="form" name="form">
                        <?php
                            $arr = [
                                ['1', 'classification'],        // 0
                                ['2', 'collection'],            // 1
                                ['3', 'country'],               // 2
                                ['4', 'county'],                // 3
                                ['5', 'district'],              // 4
                                ['6', 'header_taxonomy'],       // 5
                                ['7', 'institution'],           // 6
                                ['8', 'language'],              // 7
                                ['9', 'marinecenter'],          // 8
                                ['10', 'picture'],              // 9
                                ['11', 'province'],             // 10
                                ['12', 'record'],               // 11
                                ['13', 'reference'],            // 12
                                ['14', 'taxonomy'],             // 13
                                ['15', 'wording'],              // 14
                                ['16', 'wording_type'],         // 15
                            ];
                        ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="language">DB.Table</label>
                                <select class="form-control" id="db_table" name="db_table">
                                    @for( $i=0 ; $i < sizeof($arr) ; $i++ )
                                        <option value="{{ $arr[$i][1] }}">table.{{ $arr[$i][1] }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div> <!-- /.col-md-6 -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <div class='input-group'>
                                    <input type="text" class="form-control date_picker_search" id="start_date" name="start_date" placeholder="Calendar" readonly required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> <!-- /.col-md-6 -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <div class='input-group'>
                                    <input type="text" class="form-control date_picker_search" id="end_date" name="end_date" placeholder="Calendar" readonly required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> <!-- /.col-md-6 -->

                        <!-- Submit Button -->
                        <div class="row submit_select" style="text-align:center;">
                            <div class="col-md-12 btn-action-box">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">
                                    Export Files
                                </button>
                            </div>
                        </div>
                        <!-- /.Submit Button -->

                    </form> <!-- /.form -->
                </div> <!-- /.row -->
            </div>
        </div> <!-- /.col-md-6 -->
    </div> <!-- /.row -->

    <br><br>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>หมายเหตุการใช้งาน</h3>
            <p>สามารถเปิดได้ด้วย Text-Editor, Google Sheet และ Number (on Mac)</p>
            <p>หากต้องการแสดงผลด้วย Excel จะต้องทำการเปิด excel ขึ้นมา<br>
                กด file ที่ Menubar/เลือก Import/เลือก csv file/เลือกไฟล์ที่ download มาจากระบบ/<br>
                ทำการเลือก Delimited และ File Origin เป็น Unicode (UTF-8) ดังภาพ/กด Finish</p>
            <img class="img-responsive img-rounded" src="{{ url('assets/images/explain_export_csv.jpg') }}"><br>
            <p>ค่าที่ได้จากไฟล์ หากมีค่าเป็น <font color="red">\N</font> หมายถึง Field นั้นมีค่าเป็น Null<br>
                แต่ถ้าค่าที่ได้จากไฟล์ค่าเป็น <font color="red">""</font> หมายถึง Field นั้นไม่ได้เก็บค่าอะไรไว้</p>
        </div> <!-- /.col-md-6 -->
    </div> <!-- /.row -->
@endsection
