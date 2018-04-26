@extends('layouts.app_login')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('contain')

<div class="row row-with-margin" style="margin-top: 40px;">
    <div class="col-md-offset-3 col-md-6">
        <div class="content-box">
            <p class="content-header">@if(Session::get('language') == 2){{"ลืมรหัสผ่าน"}}@else{{"Forgot Password"}}@endif</p>
            <p class="content-help-text">
                @if(Session::get('language') == 2)
                    กรุณากรอกที่อยู่อีเมลที่สมัครสมาชิกไว้ และเราจะส่งวิธีการตั้งรหัสผ่านให้ทางอีเมล
                @else
                    Please enter your email address, and we'll send you a password reset to email.
                @endif
            </p>

            <form class="" action="forgetpassword" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row" style="margin-bottom: 0px; margin-top: 15px;">
                    <div class="col-md-7">
                        <input type="email" class="form-control col-md-10" name="email" value="" placeholder="name@example.com" style="height: 42px !important;">
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-default btn-gold" style="width: 100%;">@if(Session::get('language') == 2){{"ตั้งค่ารหัสผ่านใหม่"}}@else{{"Reset Password"}}@endif</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!--
    <div class="row row-first">
        <div class="col-md-offset-3 col-md-6">
            <h4>
                @if(Session::get('language') == 2)
                    ลืมรหัสผ่าน
                @else
                    Forgot Password
                @endif
            </h4>
            <label for="">
                @if(Session::get('language') == 2)
                    กรุณากรอกที่อยู่อีเมลที่สมัครสมาชิกไว้ และเราจะส่งวิธีการตั้งรหัสผ่านให้ทางอีเมล
                @else
                    Please enter your email address, and we'll send you a password reset to email
                @endif
            </label>
            <form class="" action="forgetpassword" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="" placeholder="name@example.com">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-default"  name="" >

                            @if(Session::get('language') == 2)
                                กำหนดรหัสผ่านใหม่
                            @else
                                RESET PASSWORD
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->
@endsection
