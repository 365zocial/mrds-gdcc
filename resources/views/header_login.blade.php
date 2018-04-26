<div class="navbar navbar-default navbar-fixed-side navbar-custom" role="navigation">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <div class="collapse navbar-collapse" id="myNavbar">
        <div class="container-fluid nav-cont-custom">
            <div class="row nav-row-custom">
                <div class="col-sm-12 nav-col-custom">

                    <ul class="nav navbar-nav navbar-right nav-custom">
                        <li>
                            <div class="nav-user">
                              <a href="{{ url('setLangThai') }}">Thai</a> <span>/</span>
                              <a href="{{ url('setLangEng') }}">English</a>
                            </div>
                        </li>
                    </ul>

                </div>

                <div class="navbar-header system-logo">
                    <img src="{{ url('assets/images/Logo.png') }}" alt="" />
                </div>

            </div>
        </div>

    </div>
</div>
<!-- <div class="navbar navbar-default navbar-fixed-side" role="navigation">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse" id="myNavbar">

        <div class="col-md-3">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{ url('staff/dashboard') }}">MENU</a></li>
            </ul>
        </div>

        <div class="col-md-6">
            <div class="navbar-header hidden-sm hidden-xs">
                <a class="navbar-brand" href="#">Brand</a>
            </div>
        </div>
        <div class="col-md-3">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('setLangThai') }}">Thai</a></li>
                <li><a href="{{ url('setLangEng') }}">English</a></li>
            </ul>

        </div>

    </div>
</div> -->

<!--
<nav>

</nav> -->
