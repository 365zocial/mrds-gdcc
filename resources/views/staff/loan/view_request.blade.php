@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/css/loan.css') }}" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
@endsection

@section('script')

    <!-- <script type="text/javascript">
      $("form").submit(function(e) {
        var ref = $(this).find("[required]");
        $(ref).each(function(){
          if ( $(this).val() == '' ) {
            alert("Required field should not be blank.");
            $(this).focus();
            e.preventDefault();
            return false;
          }
        }); return true;
      });
    </script> -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#reclaim-specimen').click(function() {
                if ( confirm('Are you sure to reclaim specimen?') ) {
                    // console.log($(this).data('rel'));
                    $.post('/staff/loan/reclaim/loan_specimen' , { id: $(this).data('rel') }, function(data) {
                        console.log(data);
                    });
                }
            });

        });
    </script>
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
        $breadcump['View Request'] = url('staff/loan/view_request/id');
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

<div class="row row-centered">
    <div class="col-md-7 col-centered" style="padding-top: 30px;">
        <div class="lastest-loan-post">
            <div class="row row-btn">
                <div class="col-md-12">
                    <p class="main-text"><strong>Marine Center:</strong> {{ $recordLoan->marinecenter_code }}</p>
                </div>
            </div>
            <div class="row row-btn">
                <div class="col-md-4">
                    <p class="sub-text"><strong>ID Request:</strong> {{ $recordLoanID }}</p>
                </div>
                <div class="col-md-8">
                    <p class="sub-text"><strong>Status:</strong> <span class="@if($recordLoan->status==4) loan-status-approve @elseif($recordLoan->status==7) loan-status-reject @endif">{{ $loanStatus[$recordLoan->status] }}</span></p>
                </div>
            </div>
            <div class="row row-btn">
                <div class="col-md-4">
                    <p class="sub-text"><strong>Start Date:</strong> {{ AllMean::ReplaceNullWithDefaultDate($recordLoan->start_date) }}</p>
                </div>
                <div class="col-md-4">
                    <p class="sub-text"><strong>End Date:</strong> {{ AllMean::ReplaceNullWithDefaultDate($recordLoan->end_date) }}</p>
                </div>
                <div class="col-md-4">
                    <p class="sub-text"><strong>Days:</strong> {{ $recordLoan->credit }}</p>
                </div>
            </div>
            <div class="row row-of-pdf-link">
                <div class="col-md-12">
                    <p class="sub-text"><strong><a class="link-view-pdf" href="{{ url('uploads/loan_pdf', $lastRecordLoanFile) }}" target="_BLANK">View PDF File</a></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!($recordLoan->status==6 || $recordLoan->status==7))
<div class="row row-btn row-centered">
    <div class="col-md-7 col-centered">
        <form class="form-horizontal" method="post" action="{{ url('staff/loan/update_status', $recordLoanID) }}">
            @csrf
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-8">
                    <p class="view-request-input-header-small">Status Approve</p>
                    <select class="form-control" name="loan_status" style="height: 45px" required>
                        <option value="" disabled selected>Select</option>
                        @if($recordLoan->status==4)
                            <option value="5">{{ $loanStatus[5] }}</option>
                        @elseif($recordLoan->status==5)
                            <option value="6">{{ $loanStatus[6] }}</option>
                        @else
                            <option value="4">{{ $loanStatus[4] }}</option>
                            <option value="7">{{ $loanStatus[7] }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <p class="view-request-input-header-small">&nbsp;</p>
                    <button type="submit" class="btn btn-default btn-gold add-status">Add Status</button>
                </div>
            </div>

        </form>

        @if($recordLoan->status==5)
            <div class="row row-centered">
                <div class="col-md-12 col-centered">
                    <button type="button" class="btn btn-default btn-gold" id="reclaim-specimen" data-rel="{{ $recordLoan->id }}" >Reclaim Specimen</button>
                </div>
            </div>
        @endif

    </div>
</div>
@endif

<div class="row row-btn">
    <div class="col-md-12">
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="row">
            <div class="col-md-12">
                <p class="comment-form-header">Comment Form</p>
            </div>
        </div>

        @if($recordLoanPostList->isEmpty())
            <div class="row">
                <div class="col-md-12">
                    <p>No comment.</p>
                </div>
            </div>
        @else
            @foreach($recordLoanPostList as $recordLoanPost)
                <div class="row">
                    <div class="col-md-12">
                        <div class="loan-content @if($recordLoanPost->role_id===5) user-content @else admin-content @endif">
                            <p class="header">{{ $recordLoanPost->first_name }} {{ $recordLoanPost->last_name }}</p>
                            <p class="date">Date: {{ AllMean::ReplaceNullWithDefaultDate($recordLoanPost->created_at) }} Time: {{ AllMean::ReplaceNullWithDefaultTime($recordLoanPost->created_at) }}</p>
                            <p class="comment">{!! nl2br($recordLoanPost->comment) !!}</p>
                            @if(!empty($recordLoanPost->file_path))
                              <p class="link"><strong><a class="link-view-pdf" href="{{ url('uploads/loan_pdf', $recordLoanPost->file_path) }}" target="_BLANK">View PDF File</a></strong></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @if($recordLoan->status<=3)
        <div class="row row-comment">
            <div class="col-md-12">
                <form class="form-horizontal" method="post" action="/staff/loan/view_request/{{ $recordLoanID }}" >
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <p class="view-request-input-header-small">Comment Box</p>
                            <textarea class="form-control" name="loan_comment" rows="6" required></textarea>
                        </div>
                    </div>

                    <div class="row row-btn">
                        <div class="col-md-12 center" style="padding-top: 10px;">
                            <button type="submit" class="btn btn-default btn-gold">Sent Comment</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
