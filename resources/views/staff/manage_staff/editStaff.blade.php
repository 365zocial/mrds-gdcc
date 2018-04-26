@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
@endsection

@section('script')
    @include('base_wording_js')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $(".select2").select2();

            $('.password-form').hide();

            $('#-role').change(function(){
                if( $(this).val() == 4 || $(this).val() == 5 || $(this).val() == 6){
                    $('.marinecenter-form').attr("disabled","disabled");
                    $('.marinecenter-form').hide();
                    $('#-marinecenter').removeAttr('required');
                }else{
                    $('.marinecenter-form').show();
                    $('#-marinecenter').attr('required',true);
                }

                if ( $(this).val() == 2 || $(this).val() == 3 ) {
                    $('.approve-form').show();
                } else {
                    $('#-approve').prop("checked", false);
                    $('.approve-form').hide();
                }
            });

            $('input[name="inp-changepassword"]').change(function(){
                if(this.checked) {
                    $('.password-field').attr('minlength', 6);
                    $('.password-field').attr('maxlength', 20);

                    $('.password-form').show();
                }else{
                    $('.password-field').removeAttr('minlength', 'maxlength');
                    $('.password-field').val('');

                    $('.password-form').hide();
                }
            });

            $('#user-form').submit(function() {
                if( $('#-password').val() && $('#-repassword').val() ) {
                    if( $('#-password').val() != $('#-repassword').val() ) {
                        alert("Your Password and Confirm Password is not match.");
                        $('#-password').val('').focus();
                        $('#-repassword').val('');
                        return false;
                    }
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
        $breadcump['Edit User'] = url('staff/edit', $id_users);
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Edit User</p>
            <p class="content-help-text">Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>

            @foreach($data_users as $users)
            <form id="user-form" class="form-horizontal search-report-form" method="POST" action="{{ url('staff/edit', $id_users)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row row-inform">

                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Role <span class="required">*Required</span></p>
                        <select class="form-control search-report-select select2" id="-role" name="inp-roleid" required>
                        @if( count($roles) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach ( $roles as $role )
                                <option value="{{ $role->id }}" @if($users->role_id == $role->id) {{ "selected" }} @endif>{{ $role->role }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>

                    <div class="col-md-4 marinecenter-form" style="display:@if($users->role_id == 5){{ "none;" }}@endif">
                        <p class="search-report-dropdown-header">Marine Center <span class="required">*Required</span></p>
                        <select class="form-control search-report-select select2" id="-marinecenter" name="inp-marinecenter" @if($users->role_id != 5){{ "required" }}@endif>
                        @if( count($marinecenters) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($marinecenters as $marinecenter)
                                <option value="{{ $marinecenter['id'] }}" @if($users->marinecenter_id == $marinecenter['id']){{ "selected" }} @endif>{{ $marinecenter['marinecenter_code'] }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>

                    <div class="col-md-4 approve-form" style="display:@if($users->role_id == 5){{ "none;" }}@endif">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <label class="checkbox">
                          <input type="checkbox" id="-approve" name="inp-approve_permission" @if($users->approve_permission == 1){{ "checked" }}@endif > Approve Permission
                        </label>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Username <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-username" name="inp-username" value="{{ $users->name }}" placeholder="Enter Username" required>
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Email <span class="required">*Required</span></p>
                        <input type="email" class="form-control" id="-email" name="inp-email" value="{{ $users->email }}" placeholder="Enter Email" required>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-4 changepassword-form">
                        <label class="checkbox" style="margin-left: 20px;">
                          <input type="checkbox" name="inp-changepassword" type="checkbox" value="1" > Change Password
                        </label>
                    </div>

                </div>

                <div class="row row-inform password-form">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Password</p>
                        <input type="password" class="form-control password-field" id="-password" name="inp-password" placeholder="Enter Password">
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Confirm Password</p>
                        <input type="password" class="form-control password-field" id="-repassword" name="inp-repassword" placeholder="Enter Password">
                    </div>

                </div>

                <hr class="search-report">

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">First Name <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-fname" name="inp-first_name" value="{{ $users->first_name }}" placeholder="Enter First Name" required>
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Last Name <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-lname" name="inp-last_name" value="{{ $users->last_name }}" placeholder="Enter Last Name" required>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Gender <span class="required">*Required</span></p>
                        <select class="form-control search-report-select select2" id="-gender" name="inp-gender" required>
                            <option value="f" @if($users->gender == "f") {{ "selected" }} @endif>Female</option>
                            <option value="m" @if($users->gender == "m") {{ "selected" }} @endif>Male</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Telephone <span class="required">*Required</span></p>
                        <input type="text" class="form-control" id="-telephone" name="inp-telephone" value="{{ $users->telephone }}" placeholder="0912345678" required>
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Company</p>
                        <input type="text" class="form-control" id="-company" name="inp-company" value="{{ $users->company }}" placeholder="Enter Company">
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Position</p>
                        <input type="text" class="form-control" id="-position" name="inp-position" value="{{ $users->position }}" placeholder="Enter Position">
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">Address</p>
                        <input type="text" class="form-control" id="-address" name="inp-address" value="{{ $users->address }}" placeholder="Enter Address">
                    </div>

                </div>

                <div class="row row-inform">

                    <div class="col-md-4">
                        <label class="checkbox" style="margin-left: 20px;">
                          <input type="checkbox" name="status_switch" type="checkbox" @if( $users->status == 2 ) checked @endif > Enable Status
                        </label>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 search-report-button">
                        <button type="submit" class="btn btn-default btn-gold">Submit</button>
                    </div>
                </div>

            </form>
            @endforeach

        </div>
    </div>
</div>

<!-- OLD DATA -->

<!--     <div class="col-md-12">
        <h2>Manager : Edit</h2>
        <ol class="breadcrumb">
            <li><a href="{{ url('staff/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ url('staff/list') }}">Manage Staff</a></li>
            <li class="active">Edit Staff</li>
        </ol>
    </div>
    <div class="col-md-12">
        @foreach($data_users as $users)
            <form class="form-horizontal" role="form" method="post" action="{{ url('staff/edit',$id_users)}}">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-gender">Role:</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="-role" name="inp-roleid">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($users->role_id == $role->id) {{ "selected" }} @endif>{{ $role->role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-username">Username:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-username" name="inp-username" value="{{ $users->name }}" placeholder="Enter Username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Change Password * :</label>
                    <div class="col-sm-4">
                        <input  name="inp-changepassword" type="checkbox" value="1">
                    </div>
                </div>
                <div class="form-group password" style="display: none;">
                    <label class="control-label col-sm-4" for="-username">Password :</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="-password" name="inp-password" minlength="6" maxlength="20" placeholder="Enter Password">
                    </div>
                </div>
                <div class="form-group password" style="display: none;">
                    <label class="control-label col-sm-4" for="-username">Confirm Password :</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="-repassword" name="inp-repassword" minlength="6" maxlength="20" placeholder="Re Enter Password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-fname">Firstname:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-fname" name="inp-first_name" value="{{ $users->first_name }}" placeholder="Enter First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-lname">Lastname:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-lname" name="inp-last_name" value="{{ $users->last_name }}" placeholder="Enter Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-gender">Gender:</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="-gender" name="inp-gender">
                            <option value="f" @if($users->gender == "f") {{ "selected" }} @endif >Female</option>
                            <option value="m" @if($users->gender == "m") {{ "selected" }} @endif>Male</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-gender">Email:</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" id="-email" name="inp-email" value="{{ $users->email }}" placeholder="ABC@DEF.com">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="_telephone">Telephone:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-telephone" name="inp-telephone" value="{{ $users->telephone }}" placeholder="0811111111">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-position">Position:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-position" name="inp-position" value="{{ $users->position }}" placeholder="Enter Position">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-company">Company:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-company" name="inp-company" value="{{ $users->company }}" placeholder="Enter company">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="-address">Address:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="-address" name="inp-address" value="{{ $users->address }}" placeholder="Enter Address">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="">Approve Permission:</label>
                    <div class="col-sm-4">
                        <input id="status_swtich_approve" class="status_switching" name="inp-approve_permission" type="checkbox"  data-toggle="toggle" data-width="100" data-on="ON" data-off="OFF" @if($users->approve_permission == 1){{ "checked" }} @endif>
                    </div>
                </div>

                <div class="form-group marinecenter-form"  style="display:@if($users->role_id == 5){{ "none" }}@endif;">
                    <label class="control-label col-sm-4" for="-marinecenter">Marine Center:</label>
                    <div class="col-sm-2">
                        <select class="form-control" id="-marinecenter" name="inp-marinecenter" required>
                            @foreach($marinecenters as $marinecenter)
                                <option value="{{ $marinecenter['id'] }}" @if($users->marinecenter_id == $marinecenter['id']){{ "selected" }} @endif>{{ $marinecenter['marinecenter_code'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if( Auth::user()->id != $users->id )
                <div class="form-group">
                    <label class="control-label col-sm-4" for="">Status</label>
                    <div class="col-sm-4">
                        <input id="status_swtich" class="status_switching" name="status_switch" type="checkbox"  data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if( $users->status == 2 ) checked @endif >
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        @endforeach
    </div> -->
@endsection
