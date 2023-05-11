@extends('layouts.app')

@section('css')

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('header')
    <?php
        $headerName = "Search Report";
        $iconFileName = "icon_search_report.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Report'] = url('staff/searchReport/dashboard');
    ?>
@endsection

@section('contain')
    <div class="row row-with-margin">
        <div class="col-md-12">
            <p class="content-header">Choose Report Type</p>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-3 menu-box">
          <a class="box-link" href="{{ url('/staff/searchReport/record_count_chart') }}">
            <div class="menu-icon-box">
                <div class="icon-box">
                    <img class="icon" src='{{ URL::asset("assets/images/icon_taxonomy_count_chart.png") }}' />
                </div>
                <p class="menu-text">Record<br>Count Chart</p>
            </div>
          </a>
        </div>

        <div class="col-md-3 menu-box">
          <a class="box-link" href="{{ url('/staff/searchReport/biogeography') }}">
            <div class="menu-icon-box">
                <div class="icon-box">
                    <img class="icon" src='{{ URL::asset("assets/images/icon_biogeography.png") }}' />
                </div>
                <p class="menu-text">Biogeography<br>&nbsp;</p>
            </div>
          </a>
        </div>

        <div class="col-md-3 menu-box">
          <a class="box-link" href="{{ url('/staff/searchReport/diversity') }}">
            <div class="menu-icon-box">
                <div class="icon-box">
                    <img class="icon" src='{{ URL::asset("assets/images/icon_diversity.png") }}' />
                </div>
                <p class="menu-text">Diversity<br>&nbsp;</p>
            </div>
          </a>
        </div>

        <div class="col-md-3 menu-box">
          <a class="box-link" href="{{ url('/staff/searchReport/count_by_place') }}">
            <div class="menu-icon-box">
                <div class="icon-box">
                    <img class="icon" src='{{ URL::asset("assets/images/icon_count_by_place.png") }}' />
                </div>
                <p class="menu-text">Count By Place<br>&nbsp;</p>
            </div>
          </a>
        </div>
    </div>
    @if(Auth::user()->role_id == 2)
    <div class="row" style="margin-bottom: 30px;">
      <div class="col-md-3 menu-box">
          <a class="box-link" href="{{ url('/staff/searchReport/admin_report') }}">
            <div class="menu-icon-box">
                <div class="icon-box">
                    <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/export-all-data.png") }}' />
                </div>
                <p class="menu-text">Download<br>Admin Report</p>
            </div>
          </a>
      </div>
    </div>
    @endif
@endsection
