@extends('layouts.app_login')

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

@section('contain')

    @include('alert')
    <div class="row row-first">
        <div class="col-md-12">
            <p>Reset Password</p>
            <p>Welcome back</p>
            <p>In the fields below enter your new password.</p>
        </div>
    </div>

    <form class="register-input" action="{{ url('resetpassword') }}" method="post">

        <div class="row">
            <div class="col-md-12">
                <label for="">New Password</label>
                <input class="form-control login-field" type="password" name="password" placeholder="New Password" required="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Confirm New Password</label>
                <input class="form-control login-field" type="password" name="confirm_password" placeholder="Confirm New Password" required="">
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <center>
                <button type="submit" class="btn btn-default" name="button">Change Password</button>
            </center>
        </div>

    </form>

@endsection
