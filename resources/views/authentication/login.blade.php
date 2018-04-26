@extends('layouts.app_login')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();


        });
    </script>
@endsection

@section('contain')

<div class="row" style="margin-top: 20px;">
  <div class="col-md-12 col-login">
    <img src="{{ url('assets/images/logo_gom.png') }}" alt="Logo" />
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-login">
    <p class="login-label-header">
        @if($lang == 1){{ "Welcome to Marine Resources Database System" }}
        @else{{ "ยินดีต้อนรับสู่ระบบการจัดการฐานข้อมูลสิ่งมีชีวิตทางทะเล" }}
        @endif
    </p>
    <p class="login-label-subheader">
        @if($lang == 1){{ "If you don't have an account. Please register." }}
        @else{{ "หากท่านยังไม่มีบัญชีผู้ใช้ กรุณาลงทะเบียน" }}
        @endif
    </p>
  </div>
</div>
<div class="row row-centered">
    <div class="col-12-md">
        @if( Session::has('authen') )
        <h4 style="color:red;">
            Username or Password incorrect. <a href="{{ url('register') }}">Register</a> or <a href="{{ url('forgetpassword') }}">Forgot your password.</a>
        </h4>
        <?php Session::forget('authen')?>
        @endif
    </div>
</div>
<div class="row row-centered">
  <div class="col-md-8 col-centered col-login">
    <div class="row row-in-col">
      <div class="col-md-8 col-login">
        <div class="login-form">
          <div class="row row-in-col">

            <div class="col-md-5">
              <img class="image-icon" src="{{ url('assets/images/icon_dashboard_manager/login.png')}}" alt="Login Icon" />
              <p class="sub-icon">
                  @if($lang == 1){{ "User Login" }}
                  @else{{ "เข้าสู่บัญชีผู้ใช้งาน" }}
                  @endif
              </p>
            </div>

            <div class="col-md-7">
              <form action="{{ url('login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                  <div class="col-md-12">
                    <input class="form-control login-field" type="text" name="inp-name" placeholder="@if($lang == 1){{ 'Username' }}@else{{ 'ชื่อบัญชีผู้ใช้' }}@endif" required autofocus>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <input class="form-control login-field" type="password" name="inp-password" minlength="6" maxlength="20" placeholder="@if($lang == 1){{ 'Password' }}@else{{ 'รหัสผ่าน' }}@endif" required>
                  </div>
                </div>

                <div class="row" style="margin-bottom: -10px;">
                  <div class="col-md-12">
                    <button class="btn btn-default btn-gold login-button" type="submit">@if($lang == 1){{ 'Login' }}@else{{ 'เข้าสู่ระบบ' }}@endif</button>
                    <p class="sub-button"><a href="{{ url('forgetpassword') }}">@if($lang == 1){{ 'Forgot your password?' }}@else{{ 'ลืมรหัสผ่าน' }}@endif</a></p>
                  </div>
                </div>

              </form>
            </div>

          </div>

        </div>
      </div>

      <div class="col-md-4 col-login">
        <a class="box-link" href="{{ url('register')}}">
          <div class="register-button">
            <img class="image-icon" src="{{ url('assets/images/icon_dashboard_manager/register.png')}}" alt="Login Icon" />
            <p class="sub-icon">@if($lang == 1){{ 'Register' }}@else{{ 'สมัครสมาชิก' }}@endif</p>
          </div>
        </a>
      </div>

    </div>
  </div>

</div>


<div class="row">
    <div class="col-md-12">
        <a href="https://365zocial.freshdesk.com/support/solutions/12000000869" target="_blank"><p style="text-align: center;">(@if($lang == 1){{ 'User\'s manual online' }}@else{{ 'คู่มือการใช้งานออนไลน์' }}@endif)</p></a>
    </div> <!-- /.col-md-8 col-md-offset-2 -->
</div> <!-- /.row -->


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-4">
                <img class="img-responsive img-rounded" src="{{ url('assets/images/first_page_record',$data[0]->pic) }}" alt="Record Detail" data-toggle="tooltip" title="Record Detail" />
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <img class="img-responsive img-rounded" src="{{ url('assets/images/first_page_record',$data[1]->pic) }}" alt="Specimens" data-toggle="tooltip" title="Specimens" />
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <img class="img-responsive img-rounded" src="{{ url('assets/images/first_page_record',$data[2]->pic) }}" alt="Search Result" data-toggle="tooltip" title="Search Result" />
            </div> <!-- /.col-md-4 -->
        </div>
    </div> <!-- /.col-md-8 col-md-offset-2 -->
</div> <!-- /.row -->

@endsection
