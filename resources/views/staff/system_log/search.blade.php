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
        $(".select2").select2();

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $date = $('#start_date').datepicker({
            format : 'dd-mm-yyyy',
            clearBtn: true,

            // onRender: function(date) {
            //     return date.valueOf() < now.valueOf() ? 'disabled' : '';
            // }
        });

        $date = $('#end_date').datepicker({
            format : 'dd-mm-yyyy',
            clearBtn: true,

            // onRender: function(date) {
            //     return date.valueOf() < now.valueOf() ? 'disabled' : '';
            // }
        });

        $(document).ready(function() {
            $('form#form').submit(function() {
                // console.log('Submited');
                if ( !$('#start_date').val() ) {
                    $('#start_date').focus();
                    return false;
                } else if ( !$('#end_date').val() ) {
                    $('#end_date').focus();
                    return false;
                }
                return true;
            });
        });

    </script>

@endsection

@section('header')
    <?php

        $headerName = "SYSTEM LOG";
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['System Log'] = url('');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-6 col-md-offset-3">
        <div class="content-box">

            <p class="content-header">Export Log Files</p>
            <p class="content-help-text">You can search for your require information by these topic.</p>

            <form class="" id="form" action="{{ url('staff/systemlog/search') }}" method="post">
                @csrf
                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">Search By</p>
                        <select class="form-control select2" name="table_name" id="dd_table">
                            <option value="login_log">User Login log</option>
                            <option value="export_log">File Export log</option>
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6 form-group">
                        <div class='input-group'>
                            <input type='text' id='start_date' class="form-control date_picker_search" name="start_date" placeholder="Calendar" readonly required />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <div class='input-group'>
                            <input type='text' id='end_date' class="form-control date_picker_search" name="end_date" placeholder="Calendar" readonly required />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- <hr> -->
                <div class="row submit_select" style="text-align:center; margin-bottom: 0px;">
                    <div class="col-md-12 btn-action-box">
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">
                            Export Files
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
