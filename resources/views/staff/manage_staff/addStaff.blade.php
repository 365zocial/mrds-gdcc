@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".select2").select2();

            $('form').parsley();
        	$("#-username").attr("required", "true");
    		$("#-username").attr("data-parsley-focus", "first");

        	$("#-password").attr("required", "true");
    		$("#-password").attr("data-parsley-focus", "first");

            $("#-repassword").attr("required", "true");
    		$("#-repassword").attr("data-parsley-focus", "first");

            $("#-fname").attr("required", "true");
    		$("#-fname").attr("data-parsley-focus", "first");

            $("#-lname").attr("required", "true");
    		$("#-lname").attr("data-parsley-focus", "first");

            $("#-gender").attr("required", "true");
    		$("#-gender").attr("data-parsley-focus", "first");

            $("#-email").attr("required", "true");
    		$("#-email").attr("data-parsley-focus", "first");

            $("#-telephone").attr("required", "true");
    		$("#-telephone").attr("data-parsley-focus", "first");

            $('#-role').change(function(){
                if ( $(this).val() == 4 ||  $(this).val() == 5 ||  $(this).val() == 6) {
                    $('.marinecenter-form').attr("disabled", "disabled");
                    $('.marinecenter-form').hide();
                    $('#-marinecenter').removeAttr('required');
                } else {
                    $('#-marinecenter').attr('required', true);
                    $('.marinecenter-form').show();
                }

                if ( $(this).val() == 2 || $(this).val() == 3 ) {
                    $('.approve-form').show();
                } else {
                    $('#-approve').prop("checked", false);
                    $('.approve-form').hide();
                }
            });

            $('#user-form').submit(function() {
                if( $('#-password').val() != $('#-repassword').val() ) {
                    alert("Your Password and Confirm Password is not match.");
                    $('#-password').val('').focus();
                    $('#-repassword').val('');
                    return false;
                }
            });

        });
    </script>
@endsection

@section('header')
    <?php
        $headerName = "Manage User";
        $iconFileName = "icon_dashboard_manager/manage_user.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage User'] = url('staff/list');
        $breadcump['Add User'] = url('staff/add');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Add User</p>
            <p class="content-help-text">Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>

            <form id="user-form" class="form-horizontal search-report-form" method="POST" action="{{ url('staff/add')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row row-inform">

                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Role <span class="required">*Required</span></p>
                        <select class="form-control search-report-select select2" id="-role" name="inp-roleid" required>
                        @if( count($roles) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach ( $roles as $role )
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>

                    <div class="col-md-4 marinecenter-form">
                        <p class="search-report-dropdown-header">Marine Center <span class="required">*Required</span></p>
                        <select class="form-control search-report-select select2" id="-marinecenter" name="inp-marinecenter" required>
                        @if( count($marinecenters) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($marinecenters as $marinecenter)
                                <option value="{{ $marinecenter['id'] }}" >{{ $marinecenter['marinecenter_code'] }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>

                    <div class="col-md-4 approve-form">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <label class="checkbox">
                          <input type="checkbox" id="-approve" name="inp-approve_permission"> Approve Permission
                        </label>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Username <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-username" name="inp-username" placeholder="Enter Username" required>
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Email <span class="required">*Required</span></p>
                        <input type="email" class="form-control" id="-email" name="inp-email" placeholder="Enter Email" required>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Password <span class="required">*Required</span></p>
                        <input type="password" class="form-control" id="-password" name="inp-password" minlength="6" maxlength="20" placeholder="Enter Password" required>
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Confirm Pass- <span class="required">*Required</span></p>
                        <input type="password" class="form-control" id="-repassword" name="inp-repassword" minlength="6" maxlength="20" placeholder="Enter Password" required>
                    </div>

                </div>

                <hr class="search-report">

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">First Name <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-fname" name="inp-first_name" placeholder="Enter First Name" required>
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Last Name <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-lname" name="inp-last_name" placeholder="Enter Last Name" required>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Gender <span class="required">*Required</span></p>
                        <select class="form-control search-report-select select2" id="-gender" name="inp-gender" required>
                            <option value="f" selected>Female</option>
                            <option value="m">Male</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Telephone <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-telephone" name="inp-telephone" placeholder="0912345678" required>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Company</p>
                        <input type="text" class="form-control" id="-company" name="inp-company" placeholder="Enter Company">
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Position</p>
                        <input type="text" class="form-control" id="-position" name="inp-position" placeholder="Enter Position">
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">Address</p>
                        <input type="text" class="form-control" id="-address" name="inp-address" placeholder="Enter Address">
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 search-report-button">
                        <button type="submit" class="btn btn-default btn-gold">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
