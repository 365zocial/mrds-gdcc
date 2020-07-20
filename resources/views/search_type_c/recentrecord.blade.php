@extends('layouts.app_user')

@section('css')
    @include('base_wording_css')
    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">

    <link rel="stylesheet" href="{{ asset('assets/css/search-category.css') }}" media="screen" title="no title" charset="utf-8">

    <style media="screen">
        table#result.display tbody tr td:last-child {
            text-align: center;
        }
        table#result.display tbody tr td a {
            color: #636363;
        }
        table#result.display tbody tr td a:hover, table#result.display tbody tr td a:focus, table#result.display tbody tr td a:active {
            text-decoration: none;
            color: #000;
        }
        table#result.display tbody tr td span.between {
            text-align: center;
            margin-left: 10px;
            margin-right: 10px;
        }
        table#result.display tbody tr td span.glyphicon {
            display: block;
        }
    </style>

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

        function getCurrentParam(){
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

            return {
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
                        lang: 'en'
                    }
        }
        function getDataAjax(){
            $.ajax({
                method: "POST",
                url: "<?php echo url('search/searchdata'); ?>",
                data: getCurrentParam()
            }).done(function( data ) {
                $('.locality_search').html(data['locality']);
                $('.taxa_search').html(data['taxa']);
                $('.expedition_search').html(data['expedition']);

                $('.loader').fadeOut();
                $('.table_result').slideDown();
                tb.clear().draw();

                var province = "";
                var country = "";
                var expedition = "";
                var ocean_sea_lake = "";

                var lang = data['lang_table'];

                initDatatable(getCurrentParam())
                @if(false)
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
                    if(data['related_catalog_item'] != null){
                        re_cat_no = data['related_catalog_item'];
                    }else{
                        re_cat_no = "";
                    }
                    if(data['related_reference_item'] != null){
                        re_item_no = data['related_reference_item'];
                    }else{
                        re_item_no = "";
                    }

                    tb.row.add( [
                        re_cat_no+""+re_item_no,
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
                            data['previous_scientific_name_format'],
                            data['type_status_en'],
                            data['identifier'],
                            data['previous_identifier'],
                        @if($group_permission_b == 2)
                            ocean_sea_lake,
                            country,
                            province,
                        @endif
                            expedition,
                        "<a href='#' class='showPic' data-toggle='modal' data-target='#myModal' data-uniqueid='"+data['unique_record']+"' ><span class='glyphicon glyphicon-eye-open' aria-hidden='true'> View image</a>",
                    ] ).draw();
                });
                @endif

            });
        }

        var table = $('#distributeDataTable').DataTable({});;
        function initDatatable(params){
            table.destroy();


$('#distributeDataTable').DataTable({
    order: [2, 'asc'],
    // bFilter: true,
    // bLengthChange: true,
    // "paging": true,
    // pagingType: "full_numbers",
    processing: true,
    serverSide: true,
    ajax: {
    method: "POST",
    url: '{!! route('typec.recent.datatable') !!}',
    data: params
    },
    columns: [
        { data: 'cate_ref', orderable: false, searchable: false },
        @if($group_permission_a == 2)
                    { data: 'phylum', name: 't3.name'},
                    { data: 'subphylum', name: 't4.name'},
                    { data: 'class', name: 't5.name'},
                    { data: 'order_o', name: 't6.name'},
                    { data: 'suborder', name: 't7.name'},
                    { data: 'infraorder', name: 't8.name'},
                    { data: 'family', name: 't9.name'},
        @endif
                { data: 'current_scientific_name_format', name: 'classification.current_scientific_name_format'},
                { data: 'previous_scientific_name_format', name: 'classification.previous_scientific_name_format'},
                { data: 'type_status_en', name: 'w2.name_en'},
                { data: 'identifier', name: 'r.identifier'},
                { data: 'previous_identifier', name: 'r.previous_identifier'},
        @if($group_permission_b == 2)
                { data: `{{ ($lang==1 ? 'ocean_sea_lake_en' : 'ocean_sea_lake_th') }}`, name: `{{ ($lang==1 ? 'w4.name_en' : 'w4.name_th') }}`},
                { data: `{{ ($lang==1 ? 'country_en' : 'country_th') }}`, name: `{{ ($lang==1 ? 'country.country_en' : 'country.country_th') }}`},
                { data: `{{ ($lang==1 ? 'province_en' : 'province_th') }}`, name: `{{ ($lang==1 ? 'p.province_en' : 'p.province_th') }}`},
        @endif
        { data: `{{ ($lang==1 ? 'expedition_en' : 'expedition_th') }}`, name: `{{ ($lang==1 ? 'w1.name_en' : 'w1.name_th') }}`},
        { data: 'showpic', orderable: false, searchable: false },
    ],
    });
}

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: '{!! route('typec.distribution.export') !!}',
                data: {
                    way: 'Recent_Record',
                    ...getCurrentParam()
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo '/export_result_record' ?>'+ '/' + data;

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
            $breadcump['สืบค้นรายการลงทะเบียน'] = url('search/recentrecord');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Recent Record'] = url('search/recentrecord');
        }
    ?>
@endsection

@section('contain')
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Record Picture</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-with-margin search-category-pages">
        <div class="col-md-8 col-md-offset-2">
            <div class="content-box">
                <p class="content-header">
                    @if($lang == 2)
                        สืบค้นรายการลงทะเบียน
                    @else
                        RECENT RECORD
                    @endif
                    <a class="btn btn-sm btn-link" href="{{ url('abbreviation/referenceLoan') }}">Reference list</a>
                </p>

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
                            [$families,'family']
                        ];
                    ?>

                    <hr class="search-category-pages hr_search" style="display:none;">

                    <div class="row taxa_select" style="display:none;">
                        <div class="col-md-6 form-group">
                            <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Search by Taxon'}}@endif</p>
                            <select class="form-control select2" name="header_taxonomy" id="taxa_header_id">
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
                        <div class="col-md-6 form-group">
                            <p class="search-report-dropdown-header">&nbsp;</p>
                            <div class="dd_taxa_sub" style="display:none;">
                                <select class="form-control select2" name="taxa" id="">
                                    <option selected disabled="" value="0">Select</option>
                                </select>
                            </div>
                            @foreach($arr_taxos as $arr_taxo)
                                <div class="dd_taxa_sub" style="display:none;">
                                    <select class="form-control select2" name="taxa" id="{{ $arr_taxo[1] }}">
                                        <option selected disabled="" value="0">Select</option>
                                        @foreach( $arr_taxo[0] as $value )
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row local_select" style="display:none;">
                        <div class="col-md-6 form-group">
                            <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Search by Locality'}}@endif</p>
                            <select class="form-control select2" name="locality_type" id="dd_locality">
                                <option selected disabled="" value="0">Select</option>
                                <option id="dd_country" value="country" >Country / ประเทศ</option>
                                <option id="dd_province" value="province" >Province / จังหวัด</option>
                                <option id="dd_district" value="district" >District / อำเภอ</option>
                                <option id="dd_county" value="county" >County / ตำบล</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
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
                        <br>
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
                                @if($lang == 2){{'ค้นหา'}}@else{{'Search Record'}}@endif
                            </button>
                        </div>
                    </div>

                </form> <!-- /.form -->
            </div> <!-- /.content-box -->
        </div>
    </div> <!-- /.row -->

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
            <table id="distributeDataTable" class="display" cellspacing="0">
                <thead>
                    <th>ID</th>
                    @if($group_permission_a == 2)
                        <th>Phylum</th>
                        <th>Subphylum</th>
                        <th>Class (Clade)</th>
                        <th>Order (Clade)</th>
                        <th>Suborder (Clade)</th>
                        <th>Infraorder (Clade)</th>
                        <th>Family (Clade)</th>
                    @endif
                    <th>Current Name</th>
                    <th>Previous Name</th>
                    <th>Type</th>
                    <th>Current Indentifier</th>
                    <th>Previous Indentifier</th>
                    @if($group_permission_b == 2)
                        <th>Ocean/Sea/Lake</th>
                        <th>Country</th>
                        <th>Province</th>
                    @endif
                    <th>Expendition</th>
                    <th>Picture</th>
                </thead>
            </table>
        </div>
    </div>

</div>

<script type="text/javascript">
function printContent(redirect){

    $('table#result.display.dataTable.no-footer thead tr th:last-child').remove();
    $('table#result.display.dataTable.no-footer tbody tr td:last-child').remove();
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
