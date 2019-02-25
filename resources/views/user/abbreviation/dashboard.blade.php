@extends('layouts.app_user')

@section('css')
    @include('base_wording_css')
    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
    <link rel="stylesheet" href="{{ asset('assets/css/search-category.css') }}" media="screen" title="no title" charset="utf-8">

@endsection

@section('script')
    @include('base_wording_js')

    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>

    <script type="text/javascript">
        var useAjax = false;
    </script>
    <script src="{{ URL::asset('assets/script/search_script.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(".select2").select2();

    </script>

@endsection

@section('header')
    <?php
        if($lang == 2){
            $headerName = "ความหมายของชื่อ";
        }else{
            $headerName = "Abbreviation";
        }
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        if($lang == 2){
            $breadcump['หน้าควบคุม'] = url('/');
            $breadcump['ความหมายของชื่อ'] = url('abbreviation');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Abbreviation'] = url('abbreviation');
        }
    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-10 col-md-offset-1" style="padding: 0 30px;">
        <div class="content-box">
            <p class="content-header" style="text-transform: none;">
                @if($lang == 2)
                    ID กรณีอ้างอิงจากตัวอย่าง
                @else
                    ID, refer to specimen
                @endif
            </p>
            <p class="content-header" style="text-transform: none; padding: 0px 30px;">
                @if($lang == 2)
                    ID = ศูนย์วิจัย-1-กลุ่มสิ่งมีชีวิต-หมายเลขทะเบียนอ้างอิง
                @else
                    ID = MarineCenter-1-CollectionCode-CatalogNumber
                @endif
            </p>
            <p class="content-header" style="text-transform: none;">
                @if($lang == 2)
                    ID กรณีอ้างอิงจากเอกสาร
                @else
                    ID, refer to publication
                @endif
            </p>
            <p class="content-header" style="text-transform: none; padding: 0px 30px;">
                @if($lang == 2)
                    ID = ศูนย์วิจัย-2-กลุ่มสิ่งมีชีวิต-เอกสารอ้างอิง-เลขหน้า-ลำดับที่ของตัวอย่าง-ลำดับที่ของสถานที่
                @else
                    ID = MarineCenter-2-CollectionCode-Reference-Page-No of species-No of locality
                @endif
            </p>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1" style="padding-top: 30px;">
        <div class="col-md-4">
            <a class="box-link" href="{{ url('search/recentrecord') }}">
                <div class="menu-icon-box">
                    <div>
                        <img class="icon img-responsive" src='{{ URL::asset("assets/images/icon_dashboard_user/marine_center.png") }}' />
                    </div>
                    <p class="menu-text" style="text-transform: none;">
                        @if( $lang == 2)
                            ศูนย์วิจัย
                            <br>&nbsp;
                        @else
                            MarineCenter
                        @endif
                        <br>&nbsp;
                    </p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="box-link" href="{{ url('search/recentrecord') }}">
                <div class="menu-icon-box">
                    <div>
                        <img class="icon img-responsive" src='{{ URL::asset("assets/images/icon_dashboard_user/collection_code.png") }}' />
                    </div>
                    <p class="menu-text" style="text-transform: none;">
                        @if( $lang == 2)
                            กลุ่มสิ่งมีชีวิต
                            <br>&nbsp;
                        @else
                            CollectionCode
                        @endif
                        <br>&nbsp;
                    </p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="box-link" href="{{ url('abbreviation/referenceLoan') }}">
                <div class="menu-icon-box">
                    <div>
                        <img class="icon img-responsive" src='{{ URL::asset("assets/images/icon_dashboard_user/references.jpg") }}' />
                    </div>
                    <p class="menu-text">
                        @if( $lang == 2)
                            รายชื่อหนังสือและเอกสารอ้างอิง
                            <br>&nbsp;
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
@endsection
