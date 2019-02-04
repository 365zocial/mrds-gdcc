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
        var useAjax = true;
    </script>
    <script src="{{ URL::asset('assets/script/search_script.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(".select2").select2();

        function getDataAjax(){

            var chk_taxa = "";
            var chk_locality = "";
            var chk_expedition = "";

            if( $('#taxa_chkbox').is(":checked") ){
                chk_taxa        = $('#taxa_chkbox').val();
            }
            if( $('#local_chkbox').is(":checked") ){
                chk_locality    = $('#local_chkbox').val();
            }
            if( $('#expan_chkbox').is(":checked") ){
                chk_expedition  = $('#expan_chkbox').val();
            }

            $.ajax({
                method: "POST",
                url: "<?php echo url('search/searchdata'); ?>",
                data: {
                        _token: "{{ csrf_token() }}",
                        header_taxonomy: $('#taxa_header_id').val(),
                        domain: $('#domain').val(),
                        kingdom: $('#kingdom').val(),
                        phylum: $('#phylum').val(),
                        subphylum: $('#subphylum').val(),
                        class: $('#class').val(),
                        order: $('#order').val(),
                        suborder: $('#suborder').val(),
                        infraorder: $('#infraorder').val(),
                        family: $('#family').val(),

                        chk_taxa: chk_taxa,
                        chk_locality: chk_locality,
                        chk_expedition: chk_expedition,

                        locality_type: $('#dd_locality').val(),
                        locality_country: $('#locality_country').val(),
                        locality_province: $('#locality_province').val(),
                        locality_district: $('#locality_district').val(),
                        locality_county: $('#locality_county').val(),

                        expan_id : $('#expan_id').val(),
                    }
            }).done(function( data ) {

                $('.loader').fadeOut();
                $('.table_result').slideDown();
                tb.clear().draw();

                var province = "";
                var country = "";
                var expedition = "";
                var ocean_sea_lake = "";

                var lang = data['lang_table'];

                $.each(data['result_searchs'], function(i, data){
                    if(lang == 2){
                        province = data['province_th'];
                        country = data['country_th'];
                        expedition = data['expedition_th'];
                        ocean_sea_lake = data['ocean_sea_lake_th'];
                    }else{
                        province = data['province_en'];
                        country = data['country_en'];
                        expedition = data['expedition_en'];
                        ocean_sea_lake = data['ocean_sea_lake_en'];
                    }
                    tb.row.add( [
                        @if($group_permission_a == 2)
                            // data['domain'],
                            // data['kingdom'],
                            data['phylum'],
                            data['subphylum'],
                            data['class'],
                            data['order_o'],
                            data['suborder'],
                            data['infraorder'],
                            data['family'],
                        @endif
                            data['current_scientific_name_format'],
                        @if($group_permission_b == 2)
                            ocean_sea_lake,
                            country,
                            province,
                        @endif
                            expedition,
                   ] ).draw();
                });

                $('.locality_search').html(data['locality']);
                $('.taxa_search').html(data['taxa']);
                $('.expedition_search').html(data['expedition']);

            });
        }

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "<?php echo url('search/exportSearchTypeA'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: 'Diversity_Search',
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo "/export_result_record" ?>'+ '/' + data;

                    // // delete file
                    // $.ajax({
                    //     method: "POST",
                    //     url: "<?php //echo url('deleteFileForExcelRecord'); ?>",
                    //     data: {
                    //         name_file: data
                    //     }
                    // });
                }
                $('.loader').hide();
            });
        }

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
            $breadcump['สืบค้นข้อมูลความหลากหลาย'] = url('diversity');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Diversity Search'] = url('diversity');
        }

    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">
                @if($lang == 2)
                    สืบค้นข้อมูลความหลากหลาย
                @else
                    Diversity Search
                @endif
                <a class="btn btn-sm btn-link" href="{{ url('referenceLoan') }}">Reference list</a>
            </p>
            <!-- <p class="content-help-text">Enter counting criteria here. Numbers of matches are shown below.</p> -->

            <form class="" id="form" action="" method="post">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ค้นหาโดย
                            @else
                                Search By
                            @endif
                        </p>
                        <p class="search-report-dropdown-header">
                            @if($group_permission_a == 2)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="taxa_chkbox" value="1">
                                    @if($lang == 2)
                                        หมวดหมู่
                                    @else
                                        Taxon
                                    @endif
                                </label>
                            @endif

                            @if($group_permission_b == 2)
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="local_chkbox" value="1">
                                    @if($lang == 2)
                                        เชิงพื้นที่
                                    @else
                                        Locality
                                    @endif
                                </label>
                            @endif
                            <label class="checkbox-inline">
                                <input type="checkbox" id="expan_chkbox" value="1">
                                @if($lang == 2)
                                    การสำรวจ
                                @else
                                    Expedition
                                @endif
                            </label>
                        </p>
                    </div>
                </div>

                <?php $arr_taxos = [    [$domains,'domain'], [$kingdoms,'kingdom'], [$phylums,'phylum'], [$subphylums,'subphylum'], [$classes,'class'],
                                        [$orders,'order'], [$suborders,'suborder'], [$infraorders,'infraorder'], [$families,'family']   ]; ?>

                <hr class="search-category-pages hr_search" style="display:none;">
                <div class="row row-inform taxa_select" style="display:none;">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ค้นหาด้วยหมวดหมู่
                            @else
                                Search by Taxon
                            @endif
                        </p>
                        <select class="form-control search-report-select select2" name="header_taxonomy" id="taxa_header_id">
                            <option selected disabled="" value="0">Select</option>
                            <option value="domain">Domain</option>
                            <option value="kingdom">Kingdom</option>
                            <option value="phylum">Phylum</option>
                            <option value="subphylum">Subphylum</option>
                            <option value="class">Class / Clade</option>
                            <option value="order">Order / Clade</option>
                            <option value="suborder">Suborder / Clade</option>
                            <option value="infraorder">Infraorder / Clade</option>
                            <option value="family">Family / Clade</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <div class="dd_taxa_sub" style="display:none;">
                            <select class="form-control select2" name="taxa_b" value="0" id="">
                                <option selected value="0">Select</option>
                            </select>
                        </div>
                        @foreach($arr_taxos as $arr_taxo)
                            <div class="dd_taxa_sub" style="display:none;">
                                <select class="form-control select2" name="taxa" id="{{ $arr_taxo[1] }}">
                                    <option selected value="0">Select</option>
                                    @foreach( $arr_taxo[0] as $value )
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row row-inform local_select" style="display:none;">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ค้นหาเชิงพื้นที่
                            @else
                                Search by Locality
                            @endif
                        </p>
                        <select class="form-control select2" name="locality_type" id="dd_locality">
                            <option selected disabled="" value="0">Select</option>
                            <option id="dd_country" value="country" >Country / ประเทศ</option>
                            <option id="dd_province" value="province" >Province / จังหวัด</option>
                            <option id="dd_district" value="district" >District / อำเภอ</option>
                            <option id="dd_county" value="county" >County / ตำบล</option>
                        </select>
                    </div>
                    <div class="col-md-4">
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
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ค้นหาตามการสำรวจ
                            @else
                                Search by Expendition
                            @endif
                        </p>
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

                <div class="row submit_select" style="display:none;">
                    <div class="col-md-12 btn-action-box">
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">
                            @if($lang == 2)
                                ค้นหา
                            @else
                                Search Diversity
                            @endif
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<div id="print-area">

    <div class="row table_result" style="display:none;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <p class="content-header search-result">
                        @if($lang == 2)
                        ผลการค้นหา
                        @else
                        Search Result
                        @endif
                    </p>
                    <p class="record-label search-result">
                        @if($group_permission_a == 2)
                            @if($lang == 2)
                                ค้นหาด้วยหมวดหมู่:
                            @else
                                Taxon:
                            @endif
                            <span class="record-data" style="margin-right: 30px;"><span class="taxa_search"></span></span>
                        @endif
                        @if($group_permission_b == 2)
                            @if($lang == 2)
                                ค้นหาเชิงพื้นที่:
                            @else
                                Locality:
                            @endif
                            <span class="record-data"><span class="locality_search"></span></span>
                        @endif
                    </p>
                </div>
                <div id="remove-when-print" class="col-md-6" style="text-align: right;">
                    <button id="print-table" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="printContent('{{ url()->current() }}')"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
                    <button class="btn btn-default btn-gold" style="font-size: 16px;" onclick="exportRecord()">
                        @if($lang == 2)
                            ส่งออกข้อมูลทั้งหมดไปเป็นไฟล์ CSV
                        @else
                            Export All File to CSV
                        @endif
                    </button>
                    <p class="content-help-text" style="margin-bottom: 0px; margin-top: 5px;">
                        @if($lang == 2)
                            ไฟล์ CSV สามารถใช้งานกับ Microsoft Excel ได้
                        @else
                            *CSV file can be open to Microsoft Excel.
                        @endif
                    </p>
                </div>
                <div class="col-md-12">
                    <p class="record-label search-result">
                        @if($lang == 2)
                            การสำรวจ:
                        @else
                            Expedition:
                        @endif
                        <span class="record-data" style="margin-right: 30px;"><span class="expedition_search"></span></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-inform table_result" style="display:none;">
        <div class="col-md-12">
            <table id="result" class="display" cellspacing="0">
                <thead>
                    <tr>
                        @if($group_permission_a == 2)
                            <!-- <th>Domain</th>
                            <th>Kingdom</th> -->
                            <th>Phylum</th>
                            <th>Subphylum</th>
                            <th>Class (Clade)</th>
                            <th>Order (Clade)</th>
                            <th>Suborder (Clade)</th>
                            <th>Infraorder (Clade)</th>
                            <th>Family (Clade)</th>
                        @endif
                        <th>Current Name</th>
                        @if($group_permission_b == 2)
                            <th>Ocean/Sea/Lake</th>
                            <th>Country</th>
                            <th>Province</th>
                        @endif
                        <th>Expendition</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>


<script type="text/javascript">
function printContent(redirect){

    $('#remove-when-print').remove();

    var html = $('#print-area').html();
    var style = '<style media="screen"> table#result.display.dataTable.no-footer thead tr th:last-child , table#result.display.dataTable.no-footer tbody tr td:last-child { text-align: left; } </style>';
    var printcontent = html + style;

    document.body.innerHTML = printcontent;
    window.print();
    window.location.href = redirect;

}
</script>

@endsection
