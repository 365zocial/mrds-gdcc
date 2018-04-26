@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        p.alert-text {
            text-align: center;
            color: red;
            font-size: 16px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
@endsection

@section('header')
    <?php
        $headerName = "Export Label";
        $iconFileName = "icon_dashboard_manager/export_label.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Export Label'] = url('staff/exportlabel/form');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-12">
        <p class="content-header">Choose Export Label Type</p>
        <center><a href="{{ url('assets/images/how_to_find_record_id.jpg') }}" target="_blank"><p class="content-help-text">How to find Record ID</p></a></center>
    </div>
</div>

@if ( Session::has('export_failure') )
    <div class="row">
        <div class="col-md-12">
            <p class="alert-text">{{Session::get('export_failure')}}</p>
            {{ Session::forget('export_failure') }}
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <form id="form" action="{{ url('staff/export_label/export') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @for ( $i=0; $i<12; $i++ )
                @if ( $i%3===0 ) <div class="row row-inform"> @endif
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Label {{ $i+1 }}</p>
                        <input type="text" class="form-control" name="record_id[]" maxlength="255" placeholder="Record ID">
                    </div>
                @if ( ($i+1)%3===0 ) </div> @endif
            @endfor
            @if ( $i%3 === 0 ) </div> @endif

            <div class="row">
                <div class="col-md-12 search-report-button" style="text-align: center">
                    <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Export Label</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
