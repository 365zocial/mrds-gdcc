@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style> .checkbox { padding-top: 20px; } </style>
@endsection

@section('script')
	<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
@endsection

@section('header')
    <?php
        $headerName = "Manage Record";
        $iconFileName = "icon_dashboard_manager/manage_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage Record'] = url('staff/manageRecord');
    ?>
@endsection

@section('contain')

  <div class="row row-with-margin">
      <div class="col-md-12">
          <p class="content-header">Choose Record Type</p>
      </div>
  </div>

  <div class="row row-centered">

      <div class="col-md-3 menu-box col-centered">
        <a class="box-link" href="{{ url('staff/manageRecordSpecimens') }}">
          <div class="menu-icon-box">
              <div class="icon-box">
                  <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/specimen.png") }}' alt="Specimen Icon" />
              </div>
              <p class="menu-text">Specimen<br>&nbsp;</p>
          </div>
        </a>
      </div>

      <div class="col-md-3 menu-box col-centered">
        <a class="box-link" href="{{ url('staff/manageRecordPublication') }}">
          <div class="menu-icon-box">
              <div class="icon-box">
                  <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/publication.png") }}' alt="Publication Icon" />
              </div>
              <p class="menu-text">Publication<br>&nbsp;</p>
          </div>
        </a>
      </div>

  </div>

@endsection
