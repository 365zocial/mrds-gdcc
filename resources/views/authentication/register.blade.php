@extends('layouts.app_login')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">

    <style media="screen">
        div.row.row-inform {
            margin-bottom: 15px;
        }
    </style>
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

<div class="row" style="margin-top: 40px; margin-bottom:40px;">
  <div class="col-md-8 col-md-offset-2 col-login">
    <div class="content-box" style="text-align:left;">
        @include('alert')

        <p class="content-header" >@if(Session::get('language') == 2){{"แบบฟอร์มการสมัครสมาชิก"}}@else{{"Register Form"}}@endif</p>
        <p class="content-help-text">
            @if(Session::get('language') == 2)
                ยินดีต้อนรับสู่การสมัครสมาชิก กรุณาใส่ข้อมูลของท่านให้ครบถ้วน โดยเฉพาะอย่างยิ่งช่องที่มีเครื่องหมาย (*) กรุณาใช้ตัวอักษรภาษาอังกฤษเท่านั้น และไม่อนุญาติให้ใช้เครื่องหมายหรือสัญลักษณ์อื่น เช่น &, *, #, <, >, ", ', .
            @else
                Welcome to register form. Please complete your details. All fields marked with an asterisk (*) are mandatory. Please use English characters only, avoid using characters such as &, *, #, <, >, ", ', .
            @endif
          </p>

          <form class="register-input" action="{{ url('register') }}" method="post">
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
                        <input class="form-control login-field" type="text" name="firstname" required="">
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">
                            @if(Session::get('language') == 2)
                                นามสกุล <span class="required">*จำเป็นต้องกรอก</span>
                            @else
                                Last Name <span class="required">*Required</span>
                            @endif
                        </p>
                        <input class="form-control login-field" type="text" name="lastname" required="">
                    </div>
              </div>

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <p class="search-report-dropdown-header radio">
                            @if(Session::get('language') == 2){{"เพศ"}}@else{{"Gender"}}@endif
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="m" required=""> @if(Session::get('language') == 2){{"ชาย"}}@else{{"Male"}}@endif
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="f" required=""> @if(Session::get('language') == 2){{"หญิง"}}@else{{"Female"}}@endif
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
                        <input class="form-control login-field" type="text" name="telephone" maxlength="12" required="">
                    </div>
                </div>

              <div class="row row-inform">
                <div class="col-md-12">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            ที่อยู่
                        @else
                            Address
                        @endif
                    </p>
                  <input class="form-control login-field" type="text" name="address" >
                </div>
              </div>

              <div class="row row-inform">
                <div class="col-md-6">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            บริษัท
                        @else
                            Company Name
                        @endif
                    </p>
                  <input class="form-control login-field" type="text" name="companyname">
                </div>
                <div class="col-md-6">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            ตำแหน่ง
                        @else
                            Position
                        @endif
                    </p>
                  <input class="form-control login-field" type="text" name="position">
                </div>
              </div>

              <hr class="register-line">


                  <p class="content-help-text">
                      @if(Session::get('language') == 2)
                          กรุณาสร้างรหัสผ่านที่มีความยาวตั้งแต่ 6 - 20 ตัวอักษร รหัสผ่านเป็นส่วนที่สำคัญและผสมกันระหว่าง เลข 0-9 และตัวอักษร A - Z
                      @else
                          Please create password 6-20 characters in length. Password is case-sensitive and of any combination : 0-9, A-Z (For example : Test123)
                      @endif

                  </p>

              <div class="row row-inform">
                <div class="col-md-6">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            ชื่อผู้ใช้งาน <span class="required">*จำเป็นต้องกรอก</span>
                        @else
                            Username <span class="required">*Required</span>
                        @endif
                    </p>
                  <input class="form-control login-field" type="text" name="username" prequired="">
                </div>
                <div class="col-md-6">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            อีเมล <span class="required">*จำเป็นต้องกรอก</span>
                        @else
                            Email Address <span class="required">*Required</span>
                        @endif
                    </p>
                  <input class="form-control login-field" type="text" name="email" required="">
                </div>
              </div>

              <div class="row  row-inform">
                <div class="col-md-6">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            รหัสผ่าน <span class="required">*จำเป็นต้องกรอก</span>
                        @else
                            Password <span class="required">*Required</span>
                        @endif
                    </p>
                  <input class="form-control login-field" type="password" name="password" required="">
                </div>
                <div class="col-md-6">
                    <p class="search-report-dropdown-header">
                        @if(Session::get('language') == 2)
                            รหัสผ่านอีกครั้ง <span class="required">*จำเป็นต้องกรอก</span>
                        @else
                            Confirm Password <span class="required">*Required</span>
                        @endif
                    </p>
                  <input class="form-control login-field" type="password" name="confirm_password" required="">
                </div>
              </div>

              <div class="row" style="margin-bottom: 0px;">
                <div class="col-md-12" style="text-align: center; margin-top: 15px;">
                  <button class="btn btn-default btn-gold" type="submit">
                      @if(Session::get('language') == 2)
                          ยืนยันการสมัครสมาชิก
                      @else
                          Confirm Register
                      @endif
                  </button>
                </div>
              </div>

            </form>

        </div>
    </div>
</div>

@endsection
