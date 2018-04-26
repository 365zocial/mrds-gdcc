@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/loan.css') }}" media="screen" title="no title" charset="utf-8">
    <style type="text/css">

    </style>
@endsection

@section('script')
    @include('base_wording_js')
@endsection

@section('header')
    <?php
        $headerName = "Loan Specimen";
        $iconFileName = "icon_dashboard_manager/loan_specimen.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Loan Specimen'] = url('staff/loan/dashboard');
    ?>
@endsection

@section('contain')

@if (Session::has('success'))
<div class="row">
    <div class="col-md-offset-3 col-md-6 ">
        <div class="alert alert-success alert-dismissible loan-alert-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Successfully!</strong> {{ Session::get('success') }}
            {{ Session::forget('success') }}
        </div>
    </div>
</div>
@endif

@if (Session::has('failure'))
<div class="row">
    <div class="col-md-offset-3 col-md-6 ">
        <div class="alert alert-danger alert-dismissible loan-alert-center" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Failure!</strong> {{ Session::get('failure') }}
            {{ Session::forget('failure') }}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <p class="loan-header">All submitted requests</p>
        <div class="container-infuild">
            <table id="result" class="display" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="th-padding-left">Marine Center Code</th>
                        <th class="th-padding-left">ID Request</th>
                        <th class="th-padding-left">Start Date</th>
                        <th class="th-padding-left">End Date</th>
                        <th class="th-padding-left">Days</th>
                        <th class="th-padding-left">Status</th>
                        <th class="th-padding-left" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($recordLoanList->isEmpty())
                @else
                    @foreach($recordLoanList as $i => $recordLoan)
                        <tr>
                            <td>{{ $i+=1 }}</td>
                            <td>{{ $recordLoan->marinecenter_code }}</td>
                            <td>
                              <?php $loanID = $recordLoan->id; for ($i=strlen($recordLoan->id); $i < 6; $i++) { $loanID = '0'.$loanID; } ?>
                              {{ $loanID }}
                            </td>
                            <td>{{ AllMean::ReplaceNullWithDefaultDate($recordLoan->start_date) }}</td>
                            <td>{{ AllMean::ReplaceNullWithDefaultDate($recordLoan->end_date) }}</td>
                            <td>{{ $recordLoan->credit }}</td>
                            <td><span class="@if($recordLoan->status===4) loan-status-approve @elseif($recordLoan->status===7) loan-status-reject @endif">{{ $loanStatus[$recordLoan->status] }}</span></td>
                            <td class="center col-manage tools" style="text-align: center;">
                                <a href="{{ url('staff/loan/view_request', base64_encode(base64_encode(base64_encode($recordLoan->id))) ) }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i> View Request
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    @if ( sizeof( $recordLoanList ) )
        <div class="col-md-12">
            <center><a href="{{ url('staff/loan/export_loan') }}"><button type="button" class="btn btn-default btn-gold">Export Loan</button></a></center>
        </div>
    @endif
</div>

@endsection
