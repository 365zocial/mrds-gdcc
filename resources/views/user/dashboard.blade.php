@extends('layouts.app_user')

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

        <div class="row row-with-margin" style="padding-top: 20px;">
            <div class="col-md-12">
                <p class="content-header">
                    @if( $lang == 2)
                        ระบบการจัดการฐานข้อมูลสิ่งมีชีวิตทางทะเล
                    @else
                        Marine Resources Database System
                    @endif
                </p>
                <p class="content-help-text" style="text-align: center;">
                    @if( $lang == 2)
                        คุณสามารถสืบค้นข้อมูลที่คุณต้องการจากหัวข้อเหล่านี้
                    @else
                        You can search for your required information by these topics.
                    @endif
                </p>
            </div>
        </div>

        <div class="row" style="margin-top: 5%; margin-bottom: 30px;">

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/diversity') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/diversity_search.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นข้อมูลความหลากหลาย
                            @else
                                Diversity Search
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/distribution') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/distribution_search.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นการกระจายของสิ่งมีชีวิต
                            @else
                                Distribution Search
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/recentrecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/recent_record.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นรายการลงทะเบียน
                                <br>&nbsp;
                            @else
                                Recent Record
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/NameRecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/name_search.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นจากชื่อ
                                <br>&nbsp;
                            @else
                                Name Record
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

        </div>

        <div class="row" style="margin-top: 5%; margin-bottom: 30px;">

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('referenceLoan') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/word_in_system.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if($lang == 2)
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
