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

        function getCurrentParam(){
            var chk_taxa = "";
            var chk_locality = "";
            var chk_expedition = "";
            var chk_marinecenter = "";
            var chk_typestatus = "";

            if( $('#taxa_chkbox').is(":checked") ){
                chk_taxa        = $('#taxa_chkbox').val();
            }
            if( $('#local_chkbox').is(":checked") ){
                chk_locality    = $('#local_chkbox').val();
            }
            if( $('#expan_chkbox').is(":checked") ){
                chk_expedition  = $('#expan_chkbox').val();
            }
            if( $('#marinecenter_chkbox').is(":checked") ){
                chk_marinecenter  = $('#marinecenter_chkbox').val();
            }
            if( $('#typestatus_chkbox').is(":checked") ){
                chk_typestatus  = $('#typestatus_chkbox').val();
            }
            return {
                _token: "{{ csrf_token() }}",
                header_taxonomy: $('#taxa_header_id').val(),
                domain: $('#domain').val(),
                kingdom: $('#kingdom').val(),
                phylum: $('#phylum').val(),
                subphylum: $('#subphylum').val(),
                class: $('#class').val(),
                order_o: $('#order_o').val(),
                suborder: $('#suborder').val(),
                infraorder: $('#infraorder').val(),
                superfamily: $('#superfamily').val(),
                family: $('#family').val(),
                genus: $('#genus').val(),
                classification: $('#classification').val(),

                chk_taxa: chk_taxa,
                chk_locality: chk_locality,
                chk_expedition: chk_expedition,
                chk_marinecenter: chk_marinecenter,
                chk_typestatus: chk_typestatus,

                locality_type: $('#dd_locality').val(),
                locality_country: $('#locality_country').val(),
                locality_province: $('#locality_province').val(),
                locality_district: $('#locality_district').val(),
                locality_county: $('#locality_county').val(),
                locality_ocean_sea_lake: $('#locality_ocean_sea_lake').val(),

                expan_id : $('#expan_id').val(),
                marinecenter_id: $('#marinecenter_id').val(),
                typestatus_id: $('#typestatus_id').val(),
            }
        }

        function getDataAjax(){
            $.ajax({
                method: "POST",
                url: "<?php echo url('search/searchUtilization'); ?>",
                data: getCurrentParam()
            }).done(function( data ) {

                $('.loader').fadeOut();
                $('.table_result').slideDown();
                tb.clear().draw();

                var province = "";
                var country = "";
                var expedition = "";
                var ocean_sea_lake = "";

                var lang = data['lang_table'];
                $('.locality_search').html(data['locality']);
                $('.taxa_search').html(data['taxa']);
                $('.expedition_search').html(data['expedition']);
                $('.marinecenter_search').html(data['marinecentertext']);
                $('.typestatus_search').html(data['typestatustext']);
                initDatatable(getCurrentParam());
            });
        }

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: '{!! route('typec.utilization.export') !!}',
                data: {
                    way: 'Utilization_Search',
                    ...getCurrentParam()
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo "/export_result_record" ?>'+ '/' + data;
                }
                $('.loader').hide();
            });
        }

        var table = $('#distributeDataTable').DataTable({});
        function initDatatable(params){
            table.destroy();
            table = $('#distributeDataTable').DataTable({
            order: [2, 'asc'],
            processing: true,
            serverSide: true,
            ajax: {
                method: "POST",
                url: '{!! route('typec.utilization.datatable') !!}',
                data: params
            },
            columns: [
                { data: 'cate_ref', orderable: false, searchable: false },
                { data: 'marinecenter_th', orderable: false, searchable: false },
                { data: 'current_scientific_name_format', name: 'classification.current_scientific_name_format'},
                { data: 'common_name', name: 'classification.common_name'},
                { data: 'local_name', name: 'r.local_name'},
                { data: 'utilization', orderable: false, searchable: false},
                { data: 'folk_wisdom', name: 'r.folk_wisdom'},
                { data: 'recorder', name: 'r.recorder'},
                { data: 'knowledge_remarks', name: 'r.knowledge_remarks'},
                { data: 'economic_value_th', orderable: false, searchable: false},
                { data: 'living_th', orderable: false, searchable: false},
                { data: 'protection_thai_law_th', orderable: false, searchable: false},
                { data: 'thai_red_list_th', orderable: false, searchable: false},
                { data: 'protection_iucn_2019_th', orderable: false, searchable: false},
                { data: 'protection_cites_th', orderable: false, searchable: false},
            ],
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
            $breadcump['สืบค้นข้อมูลการใช้ประโยชน์'] = url('utilization');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Utilization Search'] = url('utilization');
        }
    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">
                @if($lang == 2)
                    สืบค้นข้อมูลการใช้ประโยชน์
                @else
                    Utilization Search
                @endif
                <a class="btn btn-sm btn-link" href="{{ url('abbreviation/referenceLoan') }}">Reference list</a>
            </p>

            <form class="" id="form" action="" method="post">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ค้นหาโดย
                            @else
                                Search By
                            @endif
                        </p>
                        <p class="search-report-dropdown-header">
                            <div class="row">
                                @if($group_permission_a == 2)
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="taxa_chkbox" value="1">
                                            @if($lang == 2)
                                                หมวดหมู่
                                            @else
                                                Taxon
                                            @endif
                                        </label>
                                    </div>
                                @endif

                                @if($group_permission_b == 2)
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="local_chkbox" value="1">
                                            @if($lang == 2)
                                                เชิงพื้นที่
                                            @else
                                                Locality
                                            @endif
                                        </label>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="expan_chkbox" value="1">
                                        @if($lang == 2)
                                            การสำรวจ
                                        @else
                                            Expedition
                                        @endif
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="marinecenter_chkbox" name="chk_marinecenter" value="1">
                                        @if($lang == 2){{'หน่วยงานย่อยภายใต้ ทช.'}}@else{{'Marine Center'}}@endif
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="typestatus_chkbox" name="chk_typestatus" value="1">
                                        @if($lang == 2){{'ประเภทสถานะ'}}@else{{'Type Status'}}@endif
                                    </label>
                                </div>
                            </div>
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
                        [$orders,'order_o'],
                        [$suborders,'suborder'],
                        [$infraorders,'infraorder'],
                        [$superfamily,'superfamily'],
                        [$families,'family'],
                        [$genuses,'genus'],
                        [$species,'species'],
                        [$classification,'classification']
                    ]; 
                ?>

                <hr class="search-category-pages hr_search" style="display:none;">
                <div class="row row-inform taxa_select" style="display:none;">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ค้นหาด้วยหมวดหมู่
                            @else
                                Search by Taxon
                            @endif
                        </p>
                        <select class="form-control search-report-select select2" name="header_taxonomy" id="taxa_header_id">
                            <!-- <option selected disabled="" value="0">Select</option>
                            <option value="phylum">Phylum</option>
                            <option value="subphylum">Subphylum</option>
                            <option value="class">Class / Clade</option>
                            <option value="order_o">Order / Clade</option>
                            <option value="suborder">Suborder / Clade</option>
                            <option value="infraorder">Infraorder / Clade</option>
                            <option value="superfamily">Super Family / Clade</option>
                            <option value="family">Family / Clade</option>
                            <option value="genus">Genus</option> -->
                            <option selected disabled="" value="0">Select</option>
                            <option value="phylum">Phylum</option>
                            <option value="subphylum">Subphylum</option>
                            <option value="infraphylum">Infraphylum</option>
                            <option value="superclass">Superclass</option>
                            <option value="class">Class / Clade</option>
                            <option value="subclass">Subclass</option>
                            <option value="infraclass">Infraclass</option>
                            <option value="superorder">Superorder</option>
                            <option value="order_o">Order / Clade</option>
                            <option value="suborder">Suborder / Clade</option>
                            <option value="infraorder">Infraorder / Clade</option>
                            <option value="superfamily">Super Family / Clade</option>
                            <option value="family">Family / Clade</option>
                            <option value="genus">Genus</option>
                            <option value="classification">Species</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <div class="dd_taxa_sub" style="display:none;">
                            <select class="form-control select2" name="taxa_b" value="0" id="">
                                <option selected value="0">Select</option>
                            </select>
                        </div>
                        @foreach($arr_taxos as $arr_taxo)
                            <div class="dd_taxa_sub" style="display:none;">
                                <select class="form-control select2" name="{{ $arr_taxo[1] }}" id="{{ $arr_taxo[1] }}">
                                    <option selected value="0">Select</option>
                                    @foreach( $arr_taxo[0] as $value )
                                        <option value="{{ $value->id }}">{!! $value->name !!}</option>
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
                            <option id="dd_ocean_sea_lake" value="ocean_sea_lake" >Ocean Sea Lake / มหาสมุทร ทะเล ทะเลสาบ</option>
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
                        <div class="dd_locality_sub" style="display:none;">
                            <select class="form-control select2" name="locality_ocean_sea_lake" id="locality_ocean_sea_lake">
                                <option selected disabled="" value="0">Select</option>
                                @foreach($ocean_sea_lake as $o)
                                    <option value="{{ $o->id }}">{{ $o->name_en." / ".$o->name_th }}</option>
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

                <div class="row row-inform marinecenter_select" style="display:none;">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาตามหน่วยงานย่อยภายใต้ ทช.'}}@else{{'Search by Marine Center'}}@endif</p>
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

                <div class="row row-inform typestatus_select" style="display:none;">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาตามประเภทสถานะ'}}@else{{'Search by Type Status'}}@endif</p>
                        <select class="form-control select2" name="typestatus_id" id="typestatus_id">
                            <option selected disabled="" value="0">Select</option>
                            <option value="ALL">All</option>
                            @foreach ( $typestatuses as $typestatus )
                                @if($lang == 2)
                                    <option value="{{ $typestatus->id }}">{{ $typestatus->name_th }}</option>
                                @else
                                    <option value="{{ $typestatus->id }}">{{ $typestatus->name_en }}</option>
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
                                Search Utilization
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
                <div class="col-md-12">
                    <p class="record-label search-result">
                        @if($lang == 2)
                            หน่วยงานย่อยภายใต้ ทช.:
                        @else
                            Marine Center:
                        @endif
                        <span class="record-data" style="margin-right: 30px;"><span class="marinecenter_search"></span></span>
                    </p>
                </div>
                <div class="col-md-12">
                    <p class="record-label search-result">
                        @if($lang == 2)
                            ประเภทสถานะ:
                        @else
                            Type Status:
                        @endif
                        <span class="record-data" style="margin-right: 30px;"><span class="typestatus_search"></span></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-inform table_result" style="display:none;">
        <div class="col-md-12">
            <table id="distributeDataTable" class="display" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marine Center</th>
                        <th>Current Name</th>
                        <th>Common Name</th>
                        <th>Local Name</th>
                        <th>Utilization</th>
                        <th>Folk Wisdom</th>
                        <th>Recorder</th>
                        <th>Knowledge Remarks</th>
                        <th>Economic Value</th>
                        <th>Living</th>
                        <th>Protection Thai Law</th>
                        <th>Protection Thai RedList</th>
                        <th>Protection IUCN 2019</th>
                        <th>Protection CITES</th>
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
