@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">
        $('form').submit(function(e){

            e.preventDefault();
            e.returnValue = false;

            var password = $('input[name="password"]').val();
            var confirm_password = $('input[name="confirm_password"]').val();

            if(password != confirm_password){
                alert("Password not match!!!");
                $('input[name="confirm_password"]').focus();
            }else{
                $('form').off('submit');
                $('form').submit();
            }
        });
    </script>
@endsection

@section('header')
    <?php
        $headerName = "View Profile";
        $iconFileName = "icon_dashboard_manager/manage_user.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $link = array(  5 => 'user/dashboard', 1 => 'staff/dashboard', 2 => 'staff/dashboard',
                        3 => 'staff/dashboard', 4 => 'staff/dashboard', 6 => 'staff/dashboard'
                    );
        $breadcump['Dashboard'] = url($link[Auth::user()->role_id]);
        $breadcump['View Profile'] = url('profile');
        $breadcump['Change Password'] = url('editpassword');
    ?>
@endsection

@section('contain')

@include('alert')

<div class="row">
    <div class="col-md-12">
        <div class="row row-with-margin">
            <div class="col-md-offset-2 col-md-8">
                <div class="content-box">
                    <p class="content-header">@if(Session::get('language') == 2){{"เปลี่ยนรหัสผ่าน"}}@else{{"Change Password"}}@endif</p>
                    <p class="content-help-text">
                        @if(Session::get('language') == 2)
                            กรุณากรอกรหัสผ่านเดิมเพื่อยืนยันและตั้งรหัสผ่านใหม่ด้านล่างนี้
                        @else
                            In the fields below, please enter your new password.
                        @endif
                    </p>

                    <form class="register-input" action="{{ url('editpassword') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <p class="search-report-dropdown-header">
                                    @if(Session::get('language') == 2)
                                        รหัสผ่านเดิม <span class="required">*จำเป็นต้องกรอก</span>
                                    @else
                                        Current Password <span class="required">*Required</span>
                                    @endif
                                </p>
                                @if( $set_new_pass )<span style="color:red">* Incorrect Current Password</span>@endif
                                <input class="form-control login-field" type="password" name="current_password" required="" minlength="6" maxlength="20" @if( $set_new_pass ){{ "autofocus" }}@endif >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p class="search-report-dropdown-header">
                                    @if(Session::get('language') == 2)
                                        รหัสผ่านใหม่ <span class="required">*จำเป็นต้องกรอก</span>
                                    @else
                                        New Password <span class="required">*Required</span>
                                    @endif
                                </p>
                                <input class="form-control login-field" type="password" name="password" minlength="6" maxlength="20" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p class="search-report-dropdown-header">
                                    @if(Session::get('language') == 2)
                                        กรอกรหัสผ่านใหม่อีกครั้ง <span class="required">*จำเป็นต้องกรอก</span>
                                    @else
                                        Confirm New Password <span class="required">*Required</span>
                                    @endif
                                </p>
                                <input class="form-control login-field" type="password" name="confirm_password" minlength="6" maxlength="20" required="">
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 0px;">
                            <div class="col-md-12" style="text-align: center; padding-top: 10px;">
                                <button type="submit" class="btn btn-default btn-gold">@if(Session::get('language') == 2){{"เปลี่ยนรหัสผ่าน"}}@else{{"Change Password"}}@endif</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
