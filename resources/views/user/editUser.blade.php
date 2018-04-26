@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">
    <style media="screen">
        p.search-report-dropdown-header.radio {
            height: 40px;
            line-height: 40px;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        p.search-report-dropdown-header.radio label.radio-inline {
            height: 40px;
            line-height: 40px;
        }

        p.search-report-dropdown-header.radio label.radio-inline input[type="radio"] {
            margin-top: 12px;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">

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
        $breadcump['Edit Profile'] = url('user/editprofile');
    ?>
@endsection

@section('contain')

@include('alert')

<div class="row row-with-margin">
    <div class="col-md-offset-2 col-md-8">
        <div class="content-box">
            <p class="content-header">Edit Profile Form</p>
            <p class="content-help-text">
                @if(Session::get('language') == 2)
                    กรุณาใส่ข้อมูลของท่านให้ครบถ้วน โดยเฉพาะอย่างยิ่งช่องที่มีเครื่องหมาย (*) กรุณาใช้ตัวอักษรภาษาอังกฤษเท่านั้น และไม่อนุญาติให้ใช้เครื่องหมายหรือสัญลักษณ์อื่น เช่น &, *, #, <, >, ", ', .
                @else
                    Please complete your details. All fields marked with an asterisk (*) are mandatory. Please use English characters only, avoid using characters such as &, *, #, <, >, ", ', .
                @endif
            </p>

            <form class="register-input" action="{{ url('editprofile') }}" method="post">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">
                            @if(Session::get('language') == 2)
                                ชื่อ <span class="required">*จำเป็นต้องกรอก</span>
                            @else
                                First Name <span class="required">*Required</span>
                            @endif
                        </p>
                        <input class="form-control login-field" type="text" name="firstname" required="" value="{{ $users[0]->first_name }}">
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">
                            @if(Session::get('language') == 2)
                                นามสกุล <span class="required">*จำเป็นต้องกรอก</span>
                            @else
                                Last Name <span class="required">*Required</span>
                            @endif
                        </p>
                        <input class="form-control login-field" type="text" name="lastname" required="" value="{{ $users[0]->last_name }}">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <p class="search-report-dropdown-header radio">
                            @if(Session::get('language') == 2){{"เพศ"}}@else{{"Gender"}}@endif
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="m" required="" @if( $users[0]->gender == "m" ){{ "checked" }}@endif> @if(Session::get('language') == 2){{"ชาย"}}@else{{"Male"}}@endif
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="f" required="" @if( $users[0]->gender == "f" ){{ "checked" }}@endif> @if(Session::get('language') == 2){{"หญิง"}}@else{{"Female"}}@endif
                            </label>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">
                            @if(Session::get('language') == 2)
                                หมายเลขโทรศัพท์ <span class="required">*จำเป็นต้องกรอก</span>
                            @else
                                Telephone Number <span class="required">*Required</span>
                            @endif
                        </p>
                        <input class="form-control login-field" type="text" name="telephone" maxlength="12" required="" value="{{ $users[0]->telephone }}">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">@if(Session::get('language') == 2){{"ที่อยู่"}}@else{{"Address"}}@endif</p>
                        <input class="form-control login-field" type="text" name="address" value="{{ $users[0]->address }}">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">@if(Session::get('language') == 2){{"บริษัท"}}@else{{"Company Name"}}@endif</p>
                        <input class="form-control login-field" type="text" name="companyname" value="{{ $users[0]->company }}">
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">@if(Session::get('language') == 2){{"ตำแหน่ง"}}@else{{"Position"}}@endif</p>
                        <input class="form-control login-field" type="text" name="position" placeholder="Position" value="{{ $users[0]->position }}">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">@if(Session::get('language') == 2){{"อีเมล"}}@else{{"Email Address"}}@endif</p>
                        <input class="form-control login-field" type="email" name="email" placeholder="name@email.com" value="{{ $users[0]->email }}">
                    </div>
                </div>

                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-12" style="text-align: center; padding-top: 10px;">
                        <button type="submit" class="btn btn-default btn-gold">@if(Session::get('language') == 2){{"บันทึกข้อมูลส่วนตัว"}}@else{{"Save Profile"}}@endif</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
