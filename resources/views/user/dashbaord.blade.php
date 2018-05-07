@extends('layouts.app')

@section('css')
    @include('base_wording_css')
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('contain')

<div class="row">
    <div class="col-md-12">

        <div class="row" style="margin-bottom: 30px; margin-top: 10%;">

            <div class="col-md-3 menu-box">
              <a class="box-link" href="{{ url('user/search/dashboard') }}">
                <div class="menu-icon-box">
                    <div class="icon-box">
                        <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_category.png") }}' />
                    </div>
                    <p class="menu-text">
                        @if(Session::get('language') == 2)
                            ค้นหาโดยประเภท
                            <br>&nbsp;
                        @else
                            Search Category
                        @endif
                        <br>&nbsp;
                    </p>
                </div>
              </a>
            </div>

            <div class="col-md-3 menu-box">
              <a class="box-link" href="{{ url('user/loan/dashboard') }}">
                <div class="menu-icon-box">
                    <div class="icon-box">
                        <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/loan_specimen.png") }}' />
                    </div>
                    <p class="menu-text">
                        @if(Session::get('language') == 2)
                            แบบฟอร์มการขอยืมตัวอย่าง
                        @else
                            Loan Specimen Form
                        @endif
                        <br>&nbsp;
                    </p>
                </div>
              </a>
            </div>

            <div class="col-md-3 menu-box">
              <a class="box-link" href="{{ url('user/contact/contactForm') }}">
                <div class="menu-icon-box">
                    <div class="icon-box">
                        <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/contact_admin.png") }}' />
                    </div>
                    <p class="menu-text">
                        @if(Session::get('language') == 2)
                            แบบฟอร์มแสดงความคิดเห็น
                        @else
                            Contact Admin
                        @endif
                        <br>&nbsp;
                    </p>
                </div>
              </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('user/referenceLoan') }}">
                  <div class="menu-icon-box">
                      <div class="icon-box">
                          <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/word_in_system.png") }}' />
                      </div>
                      <p class="menu-text">
                          @if(Session::get('language') == 2)
                              รายชื่อหนังสือ และเอกสารอ้างอิง
                          @else
                              References
                          @endif
                          <br>&nbsp;
                      </p>
                  </div>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
