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
      div.loan-block{
          border: none;
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
        $headerName = "Export SQL";
        $iconFileName = "icon_dashboard_manager/export_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Export SQL'] = url('staff/exportRecord');
    ?>
@endsection

@section('contain')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="content-box">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dump SQL Database</h2>
                        <hr>
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <form action="{{ url('staff/doExportRecordSQL') }}" method="post" id="form" name="form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit">
                                    <div class="loan-block">
                                    <img class="icon" src="{{ URL::asset('assets/images/icon_dashboard_manager/export_record.png') }}" />
                                    <p class="loan-header">Download</p>
                                    </div>
                                </button>
                            </form>
                        </center>
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
            </div>
        </div> <!-- /.col-md-6 -->
    </div> <!-- /.row -->

@endsection
