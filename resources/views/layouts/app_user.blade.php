<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Marine Resources Database System</title>
        <link rel="stylesheet" href="{{ URL::asset('assets/css/reset.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ URL::asset('assets/css/header.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/footer.css') }}" media="screen" title="no title" charset="utf-8">

        <link rel="stylesheet" href="{{ URL::asset('assets/css/staff.css') }}" media="screen" title="no title" charset="utf-8">

        <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300ita‌​lic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>

        @yield('css')
    </head>
    <body>
        <div class="loader" style="display:none;width:100%;height:100%;position:fixed;top:0;left:0;z-index:20;background-color:rgba(0,0,0,0.3);">
            <div  style="display: table; width: 100%;position:absolute; z-index:500; height:100%; opacity: 0.5;">
                <div class="" style="display: table-cell;vertical-align: middle;border-radius:5px; background-color:#000;text-align:center;">
                    <img src="{{ URL::asset('assets/images/ajax-loader.gif') }}" style="" alt="" />
                </div>
            </div>
        </div>
        <div class="navbar navbar-default navbar-fixed-side navbar-custom" role="navigation">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="myNavbar">
                <div class="container-fluid nav-cont-custom">
                    <div class="row nav-row-custom">
                        {{-- <div class="col-sm-12 nav-col-custom">

                            <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">

                                    <a href="#" class="dropdown-toggle dropdown-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <div class="nav-menu">
                                            <div class="text">
                                                @if(Session::get('language') == 2)
                                                    เมนู
                                                @else
                                                    Menu
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ url('user/dashboard') }}">
                                                <div class="menu-icon">
                                                    <img src="{{ url('assets/images/icon_menu/dashboard.png') }}" alt="Dashboard Icon" />
                                                </div>
                                                <div class="menu-text">
                                                    @if(Session::get('language') == 2)
                                                        หน้าควบคุมหลัก
                                                    @else
                                                        Dashbaord
                                                    @endif

                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ url('user/search/dashboard') }}">
                                                <div class="menu-icon">
                                                    <img src="{{ url('assets/images/icon_menu/search_category.png') }}" alt="Manage Classification Icon" />
                                                </div>
                                                <div class="menu-text">
                                                    @if(Session::get('language') == 2)
                                                        ค้นหาโดยประเภท
                                                    @else
                                                        SEARCH CATEGORY
                                                    @endif
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ url('user/loan/dashboard') }}">
                                                <div class="menu-icon">
                                                    <img src="{{ url('assets/images/icon_menu/loan_specimen.png') }}" alt="Add Record Icon" />
                                                </div>
                                                <div class="menu-text">
                                                    @if(Session::get('language') == 2)
                                                        แบบฟอร์มการขอยืมตัวอย่าง
                                                    @else
                                                        LOAN SPECIMEN FORM
                                                    @endif
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ url('user/contact/contactForm') }}">
                                                <div class="menu-icon">
                                                    <img src="{{ url('assets/images/icon_menu/Icon-contact.png') }}" alt="Add Record Icon" />
                                                </div>
                                                <div class="menu-text">
                                                    @if(Session::get('language') == 2)
                                                        แบบฟอร์มแสดงความคิดเห็น
                                                    @else
                                                        CONTACT ADMIN
                                                    @endif

                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ url('user/referenceLoan') }}">
                                                <div class="menu-icon">
                                                    <img src="{{ url('assets/images/icon_menu/word_in_system.png') }}" alt="Add Record Icon" />
                                                </div>
                                                <div class="menu-text">
                                                    @if(Session::get('language') == 2)
                                                        รายชื่อหนังสือ และเอกสารอ้างอิง
                                                    @else
                                                        REFERENCES
                                                    @endif

                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div> --}}

                        <ul class="nav navbar-nav navbar-right nav-custom">
                            <li>
                                <div class="nav-user">
                                  <a href="{{ url('setLangThai') }}">Thai</a> <span>/</span>
                                  <a href="{{ url('setLangEng') }}">English</a>
                                </div>
                            </li>
                            <li>
                                <a class="a-logout" href="{{ url('login') }}">
                                    <div class="nav-logout">
                                        @if($lang == 2)
                                            เข้าสู่ระบบ
                                        @else
                                            Log in
                                        @endif
                                    </div>
                                </a>
                            </li>
                        </ul>

                        <div class="navbar-header hidden-sm hidden-xs system-logo">
                            @if(Session::get('language') == 2)
                                <img src="{{ url('assets/images/Logo_Thai.png') }}" alt="" />
                            @else
                                <img src="{{ url('assets/images/Logo.png') }}" alt="" />
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="container main-container">
            @yield('header')
            @if(!empty($iconFileName))
                <div class="row header">
                    <div class="col-md-12">
                        <div class="box-header box-header-image">
                            <div class="image-round-border">
                                <img class="img-responsive img-icon" src='{{ URL::asset("assets/images/$iconFileName") }}' />
                            </div>
                        </div>
                        <div class="box-header box-header-text">
                            <p class="header">@if(!empty($iconFileName)){{ $headerName }}@endif</p>
                            @yield('breadcump')
                            @if(!empty($breadcump))
                                <p class="breadcump">
                                    <?php $i=0; ?>
                                    @foreach($breadcump as $name => $link)
                                        @if($i!==0)<span class="glyphicon glyphicon-play" aria-hidden="true"></span>@endif
                                        @if($i<count($breadcump)-1)
                                            <a href="{{ $link }}">{{ $name }}</a>
                                        @else
                                            {{ $name }}
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                        @yield('button-on-header')
                        @if(!empty($button))
                        <div class="button-on-header">
                            <button class="btn btn-default btn-gold"
                                @if(!empty($button['link'])) onclick="window.location.href='{{ $button['link'] }}';" @endif
                                @if(!empty($button['tag'])) {{ $button['tag'] }} @endif>{{ $button['name'] }}</button>
                        </div>
                        @endif
                    </div>
                </div>
            @endif

            @yield('use_setup')
            @yield('contain')

        </div>

        @include('footer')

        <script src="{{ URL::asset('assets/script/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('assets/script/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('assets/script/alertQuery.js') }}"></script>

        <script type="text/javascript"> $(".box-header-text").height($(".box-header-image").height()); </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("form").submit(function(e) {
                    // e.preventDefault();

                    var _return = true;

                    var ref = $(this).find("[required]");
                    $(ref).each(function(){
                        if ( $(this).val() == '' ) {
                            alert("Required field should not be blank.");
                            $(this).focus();
                            _return = false;
                            return false;
                        }
                    });
                    if(!_return) { return _return; }

                    var ref = $(this).find("[minlength]");
                    $(ref).each(function(){
                        if ( $(this).val().length < $(this).attr('minlength') ) {
                            alert("Minlength field should not lower " + $(this).attr('minlength') + " characters.");
                            $(this).focus();
                            _return = false;
                            return false;
                        }
                    });
                    if(!_return) { return _return; }

                    var ref = $(this).find("[maxlength]");
                    $(ref).each(function(){
                        if ( $(this).val().length > $(this).attr('maxlength') ) {
                            alert("Maxlength field should not more than " + $(this).attr('maxlength') + " characters.");
                            $(this).focus();
                            _return = false;
                            return false;
                        }
                    });
                    if(!_return) { return _return; }

                    // return true;
                });
            });
        </script>

        @yield('script')

        <script type="text/javascript">
           var mybrowser=navigator.userAgent;
        //    console.log(mybrowser);
           if(mybrowser.indexOf('Chrome/52.0.2743.116')>0 || mybrowser.indexOf('Chrome/54.0.2840.98')>0){
               $('ul.nav.navbar-nav li.dropdown div.text').css('padding-left', '30px');
           }
        </script>

    </body>

</html>
