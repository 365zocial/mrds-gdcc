<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Marine Resources Database System</title>
        <link rel="stylesheet" href="{{ URL::asset('assets/css/reset.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/header.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/footer.css') }}" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/staff.css') }}" media="screen" title="no title" charset="utf-8">
        @yield('css')
    </head>
    <body>
        @include('header_login')

        <div class="container login-container">
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
            @yield('contain')
        </div>

        @include('footer')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="{{ URL::asset('assets/script/alertQuery.js') }}"></script>

        @yield('script')

        <script type="text/javascript">
           var mybrowser=navigator.userAgent;
        //    console.log(mybrowser);
           if(mybrowser.indexOf('Chrome/52.0.2743.116')>0){
               $('ul.nav.navbar-nav li.dropdown div.text').css('padding-left', '30px');
           }
        </script>

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
    </body>

</html>
