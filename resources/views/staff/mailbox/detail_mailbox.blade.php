@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
      input[type="search"] {
        width: 300px !important;
      }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
@endsection

@section('header')
    <?php
        $headerName = "Mailbox";
        $iconFileName = "icon_dashboard_manager/mailbox.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Mailbox'] = url('staff/mailbox/dashboard');
        $breadcump['Detail'] = '';
    ?>
@endsection

@section('button-on-header')

@endsection

@section('contain')

<?php
    use App\Model\Mailbox;
?>

<div class="row row-with-margin">
    <div class="col-md-offset-2 col-md-8" style="text-align: right;">
        <button type="button" class="btn btn-default btn-gold" onclick="window.location.href='{{ url('staff/mailbox/dashboard') }}';" style="font-size: 16px;">View All Mailbox List</button>
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-offset-2 col-md-8">
        <div class="content-box">
            <p class="content-header">{{ Mailbox::typeMailbox( $mailbox[0]->type ) }}</p>

            <div class="row">
                <div class="col-md-6">
                    <p class="record-label">Name:
                      <span class="record-data">{{ $mailbox[0]->first_name }} {{ $mailbox[0]->last_name }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="record-label">Email:
                      <span class="record-data">{{ $mailbox[0]->email }}</span>
                    </p>
                </div>
            </div>

            <hr style="margin-top: 10px; margin-bottom: 15px;">

            <div class="row">
                <div class="col-md-12">
                    <p class="record-label">{{ $mailbox[0]->subject }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p class="record-label" style="margin-bottom: 0px;">
                        <span class="record-data">{{ $mailbox[0]->text }}</span>
                    </p>
                </div>
            </div>


        </div>
    </div>
</div>


    <!-- <div class="row">
        <div class="col-md-6 col-md-offset-3" style="text-transform: uppercase; padding-bottom: 20px; text-align: right;">
            <a href="{{ url('staff/mailbox/dashboard') }}" class="btn btn-warning">View All Mailbox List</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="border: 1px solid; border-color: #337ab7;">

            <div class="row">
                <div class="col-md-12" style="text-transform: uppercase;">
                    <h3>{{ Mailbox::typeMailbox( $mailbox[0]->type ) }}</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    Name: {{ $mailbox[0]->first_name }} {{ $mailbox[0]->last_name }}
                </div>
                <div class="col-md-6">
                    Email: {{ $mailbox[0]->email }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    Marine Center: {{ $mailbox[0]->marinecenter_code }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <b>{{ $mailbox[0]->subject }}</b>
                </div>
            </div>

            <div class="row" style="padding-bottom: 20px;">
                <div class="col-md-12">
                    {{ $mailbox[0]->text }}
                </div>
            </div>

        </div>
    </div>  -->

@endsection
