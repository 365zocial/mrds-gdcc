@extends('layouts.app')

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
                $breadcump['สืบค้นการกระจายของสิ่งมีชีวิต'] = url('user/search/distribution');
            }else{
                $breadcump['Dashboard'] = url('user/dashboard');
                $breadcump['Search Category'] = url('user/search/dashboard');
                $breadcump['Distribution Search'] = url('user/search/distribution');
            }

        }elseif(in_array(Auth::user()->role_id,[3,6])){
            if($lang == 2){
                $breadcump['หน้าควบคุม'] = url('staff/dashboard');
                $breadcump['การค้นหากลุ่มตัวอย่าง'] = url('staff/searchCategory/dashboard');
                $breadcump['สืบค้นการกระจายของสิ่งมีชีวิต'] = url('staff/searchCategory/distribution');
            }else{
                $breadcump['Dashboard'] = url('staff/dashboard');
                $breadcump['Search Category'] = url('staff/searchCategory/dashboard');
                $breadcump['Distribution Search'] = url('staff/searchCategory/distribution');
            }

        }
    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">

            <p class="content-header">
                @if($lang == 2){{'สืบค้นการกระจายของสิ่งมีชีวิต'}}@else{{'Distribution Search'}}@endif
            </p>
            <p class="content-help-text">@if($lang == 2){{'คุณสามารถสืบค้นข้อมูลสิ่งมีชีวิตทั้งหมดได้ด้วยหน้าฟอร์มนี้'}}@else{{'You can search all record by these form.'}}@endif</p>

            @if(Auth::user()->role_id == 5)
                <form class="" id="form" action="{{ url('user/search/distribution') }}" method="post">
            @elseif(in_array(Auth::user()->role_id,[3,6]))
                <form class="" id="form" action="{{ url('staff/searchCategory/distribution') }}" method="post">
            @endif
                @csrf

                <div class="row row-inform">
                    <div class="col-md-12" id="choose_source">
                        <p class="search-report-dropdown-header radio">
                            @if($lang == 2){{'ค้นหาโดย'}}@else{{'Distribution By'}}@endif
                        </p>
                        <p class="search-report-dropdown-header radio">
                            @if($group_permission_a == 2)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="taxa_chkbox" name="chk_taxa" value="1">
                                    @if($lang == 2){{'หมวดหมู่'}}@else{{'Taxon'}}@endif
                                </label>
                            @endif
                            @if($group_permission_b == 2)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="local_chkbox" name="chk_locality" value="1">
                                    @if($lang == 2){{'เชิงพื้นที่'}}@else{{'Locality'}}@endif
                                </label>
                            @endif
                            <label class="checkbox-inline">
                                <input type="checkbox" id="expan_chkbox" name="chk_expedition" value="1">
                                @if($lang == 2){{'การสำรวจ'}}@else{{'Expedition'}}@endif
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="marinecenter_chkbox" name="chk_marinecenter" value="1">
                                @if($lang == 2){{'ศูนย์กลางทางทะเล'}}@else{{'Marine Center'}}@endif
                            </label>
                        </p>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'การแสดงพื้นที่ของแผนที่'}}@else{{'Set map type'}}@endif</p>
                        <select class="form-control select2" id="map_type" name="map_type">
                            <option value="point">Point</option>
                            <option value="area">Area</option>
                        </select>
                    </div>
                </div>
                {{-- 't1.name as domain',
            't2.name as kingdom',
            't3.name as phylum',
            't4.name as subphylum',
            't5.name as class',
            't6.name as order_o',
            't7.name as suborder',
            't8.name as infraorder',
            't9.name as family',
            't10.name as superfamily',
            't11.name as genus',
            't12.name as species', --}}

                <?php
                    $arr_taxos = [
                        [$domains,'domain'],
                        [$kingdoms,'kingdom'],
                        [$phylums,'phylum'],
                        [$subphylums,'subphylum'],
                        [$classes,'class'],
                        [$orders,'order'],
                        [$suborders,'suborder'],
                        [$infraorders,'infraorder'],
                        [$superfamilies,'superfamilies'],
                        [$families,'family'],
                        [$genuses,'genus'],
                        [$species,'species'],
                        [$classification,'classification']
                    ];

                ?>

                <div class="submit_select" style="display: none;"><hr></div>

                <div class="row row-inform taxa_select" style="display:none;">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Search by Taxon'}}@endif</p>
                        <select class="form-control select2" name="header_taxonomy" id="taxa_header_id">
                            <option selected disabled="" value="0">Select</option>
                            <option value="family">Family</option>
                            <option value="genus">Genus</option>
                            <option value="classification">Species</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <div class="dd_taxa_sub" style="display:none;">
                            <select class="form-control select2" name="taxa" id="">
                                <option selected disabled="" value="0">Select</option>
                            </select>
                        </div>
                        @foreach($arr_taxos as $arr_taxo)
                            <div class="dd_taxa_sub" style="display:none;">
                                <select class="form-control select2" name="{{ $arr_taxo[1] }}" id="">
                                    <option selected disabled="" value="0">Select</option>
                                    @foreach( $arr_taxo[0] as $value )
                                        <option value="{{ $value->id }}">{!! $value->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row row-inform local_select" style="display:none;">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Search by Locality'}}@endif</p>
                        <select class="form-control select2" name="locality_type" id="dd_locality">
                            <option selected disabled="" value="0">Select</option>
                            <option id="dd_country" value="country" >Country / ประเทศ</option>
                            <option id="dd_province" value="province" >Province / จังหวัด</option>
                            <option id="dd_district" value="district" >District / อำเภอ</option>
                            <option id="dd_county" value="county" >County / ตำบล</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <div class="dd_locality_sub" style="">
                            <select class="form-control select2" name="" id="">
                                <option selected disabled="" value="0">Select</option>
                            </select>
                        </div>
                        <div class="dd_locality_sub" style="display:none;">
                            <select class="form-control select2" name="locality_country" id="locality_country">
                                <option selected disabled="" value="0">Select</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_en." / ".$country->country_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dd_locality_sub" style="display:none;">
                            <select class="form-control select2" name="locality_province" id="locality_province">
                                <option selected disabled="" value="0">Select</option>
                                @foreach($provinces as $provicne)
                                    <option value="{{ $provicne->id }}">{{ $provicne->province_en." / ".$provicne->province_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dd_locality_sub" style="display:none;">
                            <select class="form-control select2" name="locality_district" id="locality_district">
                                <option selected disabled="" value="0">Select</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->district_en." / ".$district->district_th }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dd_locality_sub" style="display:none;">
                            <select class="form-control select2" name="locality_county" id="locality_county">
                                <option selected disabled="" value="0">Select</option>
                                @foreach($counties as $county)
                                    <option value="{{ $county->id }}">{{ $county->county_en." / ".$county->county_th }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row row-inform expan_select" style="display:none;">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาตามการสำรวจ'}}@else{{'Search by Expendition'}}@endif</p>
                        <select class="form-control select2" name="expedition" id="expan_id">
                            <option selected disabled="" value="0">Select</option>
                            @foreach ( $expeditions as $expedition )
                                @if($lang == 2)
                                    <option value="{{ $expedition->id }}">{{ $expedition->name_th }}</option>
                                @else
                                    <option value="{{ $expedition->id }}">{{ $expedition->name_en }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row row-inform marinecenter_select" style="display:none;">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาตามศูนย์กลางทางทะเล'}}@else{{'Search by Marine Center'}}@endif</p>
                        <select class="form-control select2" name="marinecenter_id" id="marinecenter_id">
                            <option selected disabled="" value="0">Select</option>
                            @foreach ( $marinecenters as $marinecenter )
                                @if($lang == 2)
                                    <option value="{{ $marinecenter->id }}">{{ $marinecenter->marinecenter_th }}</option>
                                @else
                                    <option value="{{ $marinecenter->id }}">{{ $marinecenter->marinecenter }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row submit_select" style="display:none; text-align:center;">
                    <div class="col-md-12 btn-action-box">
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">
                            @if($lang == 2){{'ค้นหา'}}@else{{'Search Distribution'}}@endif
                        </button>
                    </div>
                </div>

                <input type="hidden" name="lang" value="en">
            </form>
        </div>
    </div>
</div>
@endsection
