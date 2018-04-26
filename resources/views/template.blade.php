<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="{{ URL::asset('assets/css/reset.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ URL::asset('assets/css/header.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/footer.css') }}" media="screen" title="no title" charset="utf-8">

        <link rel="stylesheet" href="{{ URL::asset('assets/css/staff.css') }}" media="screen" title="no title" charset="utf-8">

        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300ita‌​lic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>

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
        @include('header')

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
