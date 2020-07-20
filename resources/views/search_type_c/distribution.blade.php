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
            $headerName = "การค้นหากลุ่มตัวอย่าง";
        }else{
            $headerName = "Search Category";
        }
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        if($lang == 2){
            $breadcump['หน้าควบคุม'] = url('/');
            $breadcump['สืบค้นการกระจายของสิ่งมีชีวิต'] = url('distribution');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Distribution Search'] = url('distribution');
        }
    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">

            <p class="content-header">
                @if($lang == 2){{'สืบค้นการกระจายของสิ่งมีชีวิต'}}@else{{'Distribution Search'}}@endif
                <a class="btn btn-sm btn-link" href="{{ url('abbreviation/referenceLoan') }}">Reference list</a>
            </p>
            <p class="content-help-text">@if($lang == 2){{'คุณสามารถสืบค้นข้อมูลสิ่งมีชีวิตทั้งหมดได้ด้วยหน้าฟอร์มนี้'}}@else{{'You can search all record by these form.'}}@endif</p>

            <form class="" id="form" action="{{ url('search/distribution') }}" method="post">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-12" id="choose_source">
                        <p class="search-report-dropdown-header radio">
                            @if($lang == 2){{'ค้นหาโดย'}}@else{{'Distribution By'}}@endif
                        </p>
                        <p class="search-report-dropdown-header radio">
                            @if($group_permission_a == 2)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="taxa_chkbox" value="1">
                                    @if($lang == 2){{'หมวดหมู่'}}@else{{'Taxon'}}@endif
                                </label>
                            @endif

                            @if($group_permission_b == 2)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="local_chkbox" value="1">
                                    @if($lang == 2){{'เชิงพื้นที่'}}@else{{'Locality'}}@endif
                                </label>
                            @endif
                            <label class="checkbox-inline">
                                <input type="checkbox" id="expan_chkbox" value="1">
                                @if($lang == 2){{'การสำรวจ'}}@else{{'Expedition'}}@endif
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
                        [$families,'family'],
                        [$genuses,'genus'],
                        [$species,'species']
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
                                <select class="form-control select2" name="{{$arr_taxo[1]}}" id="">
                                    <option selected disabled="" value="0">Select</option>
                                    @foreach( $arr_taxo[0] as $value )
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                        {{-- add classification  --}}
                        <div class="dd_taxa_sub" style="display:none;">
                            <select class="form-control select2" name="classification" id="">
                                <option selected disabled="" value="0">Select</option>
                                @foreach( $classification as $value )
                                    <option value="{{ $value->id }}">{!! $value->current_scientific_name !!}</option>
                                @endforeach
                            </select>
                        </div>
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
