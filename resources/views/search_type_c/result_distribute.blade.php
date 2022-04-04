@extends('layouts.app_user')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/search-category.css') }}" media="screen" title="no title" charset="utf-8">
    @include('base_wording_css')
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
            $breadcump['สืบค้นการกระจายของสิ่งมีชีวิต'] = url('search/distribution');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Distribution Search'] = url('search/distribution');
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

<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="row">
            <div class="col-md-12">
                <p class="search-report-dropdown-header" style="margin-bottom: 10px;">@if($lang == 2){{'แผนที่'}}@else{{'MAP LOCATION'}}@endif</p>

                <p class="record-label">
                    @if($group_permission_a == 2)
                        @if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Taxon'}}@endif:
                        <span class="record-data taxa_search" style="margin-right: 20px;">{!! $taxa !!}</span>
                    @endif
                    @if($group_permission_b == 2)
                        @if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Locality'}}@endif:
                        <span class="record-data locality_search">{{ $locality }}</span>
                    @endif
                </p>

                <p class="record-label">
                    @if($lang == 2){{'การสำรวจ'}}@else{{'Expendition'}}@endif:
                        <span class="record-data expedition_search">{{ $expedition }}</span>
                </p>
                <p class="record-label">
                    @if($lang == 2){{'หน่วยงานย่อยภายใต้ ทช.'}}@else{{'Marine Center'}}@endif:
                        <span class="record-data expedition_search">{{ $marinecentertext }}</span>
                </p>
                <p class="record-label">
                    @if($lang == 2){{'ประเภทสถานะ'}}@else{{'Type Status'}}@endif:
                        <span class="record-data expedition_search">{{ $typestatustext }}</span>
                </p>

            </div>
        </div>

        <div class="row table_result">
            <div class="col-md-12">
                @if($is_map_show)
                <div id="map" style="height:500px"></div>
                @else
                <div class="alert alert-danger" role="alert">
                    Records not display in this map are following
                </div>
                @endif
            </div>
        </div>

        <hr>

    </div>
</div>

<div id="print-area">

    <div class="row">
        <div class="col-md-12">

            <div class="row table_result">
                <div class="col-md-8">
                    <p class="content-header search-result">Search Result</p>
                    <p class="record-label search-result">
                        @if($group_permission_a == 2)
                            @if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Taxon'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="taxa_search">{!! $taxa !!}</span></span>
                        @endif
                        @if($group_permission_b == 2)
                            @if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Locality'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="locality_search">{{$locality}}</span></span>
                        @endif
                    </p>
                    <p class="record-label search-result">
                        @if($lang == 2){{'การสำรวจ'}}@else{{'Expendition'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="expedition_search">{{$expedition}}</span></span>
                    </p>
                </div>
                <div id="remove-when-print" class="col-md-4" style="text-align: right;">
                    <button id="print-table" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="printContent('{{ url()->current() }}')"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
                    <button id="export_button" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="exportRecord()">@if($lang == 2){{'ส่งออกข้อมูลทั้งหมดไปเป็นไฟล์ CSV'}}@else{{'Export All File to CSV'}}@endif</button>
                    <p class="content-help-text" style="margin-bottom: 0px; margin-top: 5px;">@if($lang == 2){{'ไฟล์ CSV สามารถใช้งานกับ Microsoft Excel ได้'}}@else{{'*CSV file can be open to Microsoft Excel.'}}@endif</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="distributeDataTable" class="display" cellspacing="0">
                        <thead>
                            <th>No.</th>
                            <th>IDCatalog/IDRef</th>
                            <th>Family</th>
                            <th>Genus</th>
                            <th>Current Name</th>
                            <th>Ocean/Sea/Lake</th>
                            <th>Country</th>
                            <th>Province</th>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>


@if(false)
{{/*backup old datatable*/}}
<tbody>
    @foreach( $result_searchs as $value)
    <tr>
        <td>{{ $value->related_catalog_item."".$value->related_reference_item }}</td>
        <td>{{ $value->family }}</td>
        <td>{{ $value->genus }}</td>
        <td>{!! $value->current_scientific_name_format !!}</td>
        <td>{{ ($lang==2 ? $value->ocean_sea_lake_th : $value->ocean_sea_lake_en) }}</td>
        <td>{{ ($lang==2 ? $value->country_th : $value->country_en) }}</td>
        <td>{{ ($lang==2 ? $value->province_th  : $value->province_en)}}</td>
        @if(false)
        <td><a href='#' class='showPic' data-toggle='modal' data-target='#myModal' data-uniqueid='{{  $value->unique_record }}'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'> View image</a></td>
        <td><a href="{{ url('staff/searchCategory/viewCard') }}/{{ base64_encode( base64_encode( base64_encode( $value->record_id ))) }}" target="_blank"><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span> View Card</a></td>
        @endif
    </tr>
    @endforeach
</tbody>
@endif


@endsection


@section('script')
    @include('base_wording_js')
    @include('googlemap')

    <script>
        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "{{ url('search/exportDistributionSearch') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    ...{!! json_encode($request) !!},
                    way: 'Distribution_Search',
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo "/export_result_record" ?>'+ '/' + data;
                }
                $('.loader').hide();
            });
        }

    function printContent(redirect){
    
        $('table#result.display.dataTable.no-footer thead tr th:last-child').remove();
        $('table#result.display.dataTable.no-footer tbody tr td:last-child').remove();
        $('#remove-when-print').remove();
    
        var html = $('#print-area').html();
        var style = '<style media="screen"> @page { size: landscape; } table#result.display.dataTable.no-footer thead tr th:last-child , table#result.display.dataTable.no-footer tbody tr td:last-child { text-align: left; } </style>';
        var printcontent = html + style;
    
        document.body.innerHTML = printcontent;
        window.print();
        window.location.href = redirect;
    }

    $(function() {
        $('#distributeDataTable').DataTable({
                // order: [2, 'asc'],
                // bFilter: true,
                // bLengthChange: true,
                // "paging": true,
                // pagingType: "full_numbers",
                processing: true,
                serverSide: true,
                ajax: {
                method: "POST",
                url: '{!! route('distribution.datatable') !!}',
                data: {
                    ...{!! json_encode($request) !!},
                    _token: "{{ csrf_token() }}",
                }
                },
                columns: [
                    { data: 'DT_Row_Index', orderable: false, searchable: false },   
                    { data: 'cate_ref', name: 'cate_ref', searchable: false, sortable : false },
                    { data: 'family', name: 't9.name'},
                    { data: 'genus', name: 't11.name'},
                    { data: 'current_scientific_name_format', name: 'classification.current_scientific_name_format'},
                    { data: `{{ ($lang==2 ? 'ocean_sea_lake_th' : 'ocean_sea_lake_en') }}`, name: `{{ ($lang==2 ? 'w4.name_th' : 'w4.name_en') }}`},
                    { data: `{{ ($lang==2 ? 'country_th' : 'country_en') }}`, name: `{{ ($lang==2 ? 'country.country_th' : 'country.country_en') }}`},
                    { data: `{{ ($lang==2 ? 'province_th' : 'province_en') }}`, name: `{{ ($lang==2 ? 'p.province_th' : 'p.province_en') }}`},
                ]
            });
        });
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('api.google_map') }}&callback=initMap"></script>

@endsection