@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        a.user-change-password {
            color: #3dabf9;
            margin-left: 20px;
        }

        a.user-change-password:hover {
            text-decoration: none;
            color: #337ab7;
        }

        p.record-label {
            margin-bottom: 5px;
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
    ?>
@endsection

@section('contain')

<div class="row">
    <div class="col-md-12">
        @include('alert')
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-offset-2 col-md-8">
        <div class="content-box">
            <p class="content-header">@if(Session::get('language') == 2){{"รายละเอียดข้อมูลผู้ใช้"}}@else{{"Profile"}}@endif</p>

            @foreach($users as $user)
                @if ( Auth::user()->role_id == 3 && !empty($marinecenter) )
                    <div class="row">
                        <div class="col-md-12">
                            <p class="record-label">@if(Session::get('language') == 2){{"ศุนย์วิจัย"}}@else{{"Marinecenter"}}@endif:
                              <span class="record-data">{{ $marinecenter }}</span>
                            </p>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <p class="record-label">@if(Session::get('language') == 2){{"ชื่อ"}}@else{{"Name"}}@endif:
                          <span class="record-data">{{ $user->first_name }} {{ $user->last_name }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="record-label">@if(Session::get('language') == 2){{"เพศ"}}@else{{"Gender"}}@endif:
                          <span class="record-data">@if($user->gender == "m"){{ "Male" }}@else{{ "Female" }}@endif</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="record-label">@if(Session::get('language') == 2){{"หมายเลขโทรศัพท์"}}@else{{"Phone Number"}}@endif:
                          <span class="record-data">{{ $user->telephone }}</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="record-label">@if(Session::get('language') == 2){{"ที่อยู่"}}@else{{"Address"}}@endif:
                          <span class="record-data">{!! $user->address !!}</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="record-label">@if(Session::get('language') == 2){{"บริษัท"}}@else{{"Company"}}@endif:
                          <span class="record-data">{{ $user->company }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="record-label">@if(Session::get('language') == 2){{"ตำแหน่ง"}}@else{{"Position"}}@endif:
                          <span class="record-data">{{ $user->position }}</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="record-label">@if(Session::get('language') == 2){{"ชื่อผู้ใช้"}}@else{{"Username"}}@endif:
                          <span class="record-data">{{ $user->name }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="record-label">@if(Session::get('language') == 2){{"รหัสผ่าน"}}@else{{"Password"}}@endif:
                          <span class="record-data">{{ "********" }}</span> <a class="user-change-password" href="{{ url('editpassword') }}">Change Password</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="record-label">@if(Session::get('language') == 2){{"อีเมล"}}@else{{"Email Address"}}@endif:
                          <span class="record-data">{{ $user->email }}</span>
                        </p>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12" style="text-align: center;">
                        <button type="button" class="btn btn-default btn-gold" onclick='window.location.href="{{ url('editprofile') }}";'>Edit Profile</button>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
</div>

    <!-- <div class="row row-first">
        <div class="col-md-12">
            <p>
                @if(Session::get('language') == 2)
                    รายละเอียดข้อมูลผู้ใช้
                @else
                    View Profile
                @endif
            </p>
        </div>
    </div>
    @foreach($users as $user)
        <div class="row">
            <div class="col-md-6">
                <p>
                    @if(Session::get('language') == 2)
                        ชื่อ
                    @else
                        Name
                    @endif
                    : {{ $user->first_name }} {{ $user->last_name }}
                </p>
            </div>

            <div class="col-md-6">
                <p>
                    @if(Session::get('language') == 2)
                        เพศ
                    @else
                        Gender
                    @endif
                    : @if($user->gender == "m"){{ "Male" }}@else{{ "Female" }}@endif
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>
                    @if(Session::get('language') == 2)
                        หมายเลขโทรศัพท์
                    @else
                        Phone Number
                    @endif
                    : {{ $user->telephone }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>
                    @if(Session::get('language') == 2)
                        ที่อยู่
                    @else
                        Address
                    @endif
                    : {{ $user->address }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>
                    @if(Session::get('language') == 2)
                        บริษัท
                    @else
                        Company
                    @endif
                    : {{ $user->company }}
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    @if(Session::get('language') == 2)
                        ตำแหน่ง
                    @else
                        Position
                    @endif
                    : {{ $user->position }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>
                    Username
                    : {{ $user->name }}
                </p>
            </div>
            <div class="col-md-3">
                <p>
                    password : ********
                </p>
            </div>
            <div class="col-md-3">
                <a href="{{ url('editpassword') }}">change password</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>
                    Email
                    : {{ $user->email }}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <center>
                    <a href="{{ url('editprofile') }}" class="btn btn-default">Edit Profile</a>
                </center>
            </div>
        </div>
    @endforeach -->

@endsection
