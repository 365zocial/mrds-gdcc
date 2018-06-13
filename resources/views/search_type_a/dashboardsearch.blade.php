@extends('layouts.app')

@section('css')
    @include('base_wording_css')

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('header')
    <?php
        if($lang == 2){
            $headerName = "การค้นหากลุ่มตัวอย่าง";
        }else{
            $headerName = "Search Category";
        }
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        if(Auth::user()->role_id == 5){
            if($lang == 2){
                $breadcump['หน้าควบคุม'] = url('user/dashboard');
                $breadcump['การค้นหากลุ่มตัวอย่าง'] = url('user/search/dashboard');
            }else{
                $breadcump['Dashboard'] = url('user/dashboard');
                $breadcump['Search Category'] = url('user/search/dashboard');
            }
        }elseif(in_array(Auth::user()->role_id,[3,6])){
            if($lang == 2){
                $breadcump['หน้าควบคุม'] = url('staff/dashboard');
                $breadcump['การค้นหากลุ่มตัวอย่าง'] = url('staff/searchCategory/dashboard');
            }else{
                $breadcump['Dashboard'] = url('staff/dashboard');
                $breadcump['Search Category'] = url('staff/searchCategory/dashboard');
            }

        }
    ?>
@endsection

@section('contain')


    <div class="row row-with-margin" style="padding-top: 20px;">
        <div class="col-md-12">
            <p class="content-header">
                @if( $lang == 2)
                    กรุณาเลือกประเภทที่ต้องการสืบค้น
                @else
                    Select Search Type
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

    <div class="row row-centered">

        <div class="col-md-3 menu-box">
            @if(Auth::user()->role_id == 5)
                <a class="box-link" href="{{ url('user/search/diversity') }}">
            @elseif( in_array(Auth::user()->role_id, [3,6]) )
                <a class="box-link" href="{{ url('staff/searchCategory/diversity') }}">
            @endif
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
            @if(Auth::user()->role_id == 5)
                <a class="box-link" href="{{ url('user/search/distribution') }}">
            @elseif( in_array(Auth::user()->role_id, [3,6]) )
                <a class="box-link" href="{{ url('staff/searchCategory/distribution') }}">
            @endif
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
            @if(Auth::user()->role_id == 5)
                <a class="box-link" href="{{ url('user/search/recentrecord') }}">
            @elseif( in_array(Auth::user()->role_id, [3,6]) )
                <a class="box-link" href="{{ url('staff/searchCategory/recentrecord') }}">
            @endif
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
            @if(Auth::user()->role_id == 5)
                <a class="box-link" href="{{ url('user/search/NameRecord') }}">
            @elseif( in_array(Auth::user()->role_id, [3,6]) )
                <a class="box-link" href="{{ url('staff/searchCategory/NameRecord') }}">
            @endif
            <div class="menu-icon-box">
                <div class="icon-box">
                    <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/name_search.png") }}' />
                </div>
                <p class="menu-text">
                    @if( $lang == 2)
                        สืบค้นรายการลงทะเบียน
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

@endsection
