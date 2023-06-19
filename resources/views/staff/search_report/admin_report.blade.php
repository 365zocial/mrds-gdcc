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

        function getParam(){
            return {
                marine_center: $('#marine_center').val()
            }
        }

        function exportRecord() {
            $('.loader').show();
            $.ajax({
                url: "<?php echo url('staff/downloadAdminReport'); ?>",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    marine_center: $('#marine_center').val()
                },
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo "/export_result_record" ?>'+ '/' + data;
                }
                $('.loader').hide();
            });
        }

    </script>

@endsection

@section('header')
    <?php

        $headerName = "Admin Report";
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Report'] = url('staff/searchReport/dashboard');
        $breadcump['Admin Report'] = url('staff/searchReport/diversity');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-6 col-md-offset-3">
        <div class="content-box">
        @if(Auth::user()->role_id == 2)
            <p class="content-header">Download Files(CSV)</p>

            <div class="row row-inform">
                <div class="col-md-12">
                    <p class="search-report-dropdown-header">Select Marine Center</p>
                    <select class="form-control search-report-select select2" id="marine_center" name="marine_center">
                    <option value="ALL">All Marine Center</option>
                        @foreach ( $marinecenter_list as $marinecenter )
                            <option value="{{ $marinecenter->id }}">{{ $marinecenter->marinecenter_code }} - {{ $marinecenter->marinecenter }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- <hr> -->
            <div class="row submit_select" style="text-align:center; margin-bottom: 0px;">
                <div class="col-md-12 btn-action-box">
                    <button onclick="exportRecord()" class="btn btn-default btn-gold" style="font-size: 16px;">
                        Export Files
                    </button>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>

@endsection