@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <!-- For Select2 Script -->
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
    @include('googlemap')

    <script type="text/javascript">
        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "<?php echo url('exportSearchTypeA'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: 'Distribution_Search',
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('api.google_map') }}&callback=initMap"></script>

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
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Category'] = url('staff/searchCategory/searchDashboard');
        $breadcump['Distribution Search'] = url('staff/searchCategory/searchByDistribution');
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
                        @if(Auth::user()->role_id == 4)
                            @if($group_permission_a_board == 2)
                                @if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Taxon'}}@endif:
                                <span class="record-data taxa_search" style="margin-right: 20px;">{{ $taxa }}</span>
                            @endif
                            @if($group_permission_b_board == 2)
                                @if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Locality'}}@endif:
                                <span class="record-data locality_search">{{ $locality }}</span>
                            @endif
                        @endif
                        @if(Auth::user()->role_id == 2)
                                @if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Taxon'}}@endif:
                                <span class="record-data taxa_search" style="margin-right: 20px;">{{ $taxa }}</span>
                                @if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Locality'}}@endif:
                                <span class="record-data locality_search">{{ $locality }}</span>
                        @endif
                    </p>

                    <p class="record-label">
                        @if($lang == 2){{'การสำรวจ'}}@else{{'Expendition'}}@endif:
                            <span class="record-data expedition_search">{{ $expedition }}</span>
                    </p>

                </div>
            </div>

            <div class="row table_result">
                <div class="col-md-12">
                    <div id="map" style="height:500px"></div>
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
                        @if(Auth::user()->role_id == 4)
                            @if($group_permission_a_board == 2)
                                @if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Taxon'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="taxa_search">{{$taxa}}</span></span>
                            @endif
                            @if($group_permission_b_board == 2)
                                @if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Locality'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="locality_search">{{$locality}}</span></span>
                            @endif
                        @endif
                        @if(Auth::user()->role_id == 2)
                            @if($lang == 2){{'ค้นหาด้วยหมวดหมู่'}}@else{{'Taxon'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="taxa_search">{{$taxa}}</span></span>
                            @if($lang == 2){{'ค้นหาเชิงพื้นที่'}}@else{{'Locality'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="locality_search">{{$locality}}</span></span>
                        @endif
                    </p>
                    <p class="record-label search-result">
                        @if($lang == 2){{'การสำรวจ'}}@else{{'Expendition'}}@endif: <span class="record-data" style="margin-right: 30px;"><span class="expedition_search">{{$expedition}}</span></span>
                    </p>
                </div>
                <div id="remove-when-print" class="col-md-4" style="text-align: right;">
                    <button id="print-table" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="printContent('{{ url('staff/searchCategory/searchByDistribution') }}')"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
                    <button id="export_button" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="exportRecord()">@if($lang == 2){{'ส่งออกข้อมูลทั้งหมดไปเป็นไฟล์ CSV'}}@else{{'Export All File to CSV'}}@endif</button>
                    <p class="content-help-text" style="margin-bottom: 0px; margin-top: 5px;">@if($lang == 2){{'ไฟล์ CSV สามารถใช้งานกับ Microsoft Excel ได้'}}@else{{'*CSV file can be open to Microsoft Excel.'}}@endif</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="result" class="display" cellspacing="0">
                        <thead>
                            <th>IDCatalog/ IDRef</th>
                            @if(Auth::user()->role_id == 4)
                                @if($group_permission_a_board == 2)
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
                            @endif
                            @if(Auth::user()->role_id == 2)
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
                            <th>Previous Name</th>
                            <th>Type</th>
                            <th>Habitat</th>
                            @if(Auth::user()->role_id == 4)
                                @if($group_permission_b_board == 2)
                                    <th>Locality</th>
                                @endif
                            @endif
                            @if(Auth::user()->role_id == 2)
                                <th>Locality</th>
                            @endif
                            <th>Picture</th>
                        </thead>
                        <tbody>
                            @foreach( $result_searchs as $value)
                                <tr>
                                    <td>{{ $value->related_catalog_item."".$value->related_reference_item }}</td>
                                    @if(Auth::user()->role_id == 4)
                                        @if($group_permission_a_board == 2)
                                            <!-- <td>{{ $value->domain }}</td>
                                            <td>{{ $value->kingdom }}</td> -->
                                            <td>{{ $value->phylum }}</td>
                                            <td>{{ $value->subphylum }}</td>
                                            <td>{{ $value->class }}</td>
                                            <td>{{ $value->order_o }}</td>
                                            <td>{{ $value->suborder }}</td>
                                            <td>{{ $value->infraorder }}</td>
                                            <td>{{ $value->family }}</td>
                                        @endif
                                    @endif
                                    @if(Auth::user()->role_id == 2)
                                        <!-- <td>{{ $value->domain }}</td>
                                        <td>{{ $value->kingdom }}</td> -->
                                        <td>{{ $value->phylum }}</td>
                                        <td>{{ $value->subphylum }}</td>
                                        <td>{{ $value->class }}</td>
                                        <td>{{ $value->order_o }}</td>
                                        <td>{{ $value->suborder }}</td>
                                        <td>{{ $value->infraorder }}</td>
                                        <td>{{ $value->family }}</td>
                                    @endif
                                    <td>{!! $value->current_scientific_name_format !!}</td>
                                    <td>{!! $value->previous_scientific_name_format !!}</td>
                                    <td>{{ $value->type_status_en }}</td>
                                    @if($lang == 2)
                                        <td>{{ $value->habitat_th }}</td>
                                    @else
                                        <td>{{ $value->habitat_en }}</td>
                                    @endif
                                    @if(Auth::user()->role_id == 4)
                                        @if($group_permission_b_board == 2)
                                            <td>{{ $value->locality }}</td>
                                        @endif
                                    @endif
                                    @if(Auth::user()->role_id == 2)
                                        <td>{{ $value->locality }}</td>
                                    @endif
                                    <td><a href='#' class='showPic' data-toggle='modal' data-target='#myModal' data-uniqueid='{{  $value->unique_record }}'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'> View image</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript">
function printContent(redirect){

    $('table#result.display.dataTable.no-footer thead tr th:last-child').remove();
    $('table#result.display.dataTable.no-footer tbody tr td:last-child').remove();
    $('#remove-when-print').remove();

    var html = $('#print-area').html();
    var style = '<style media="print"> @page { size: landscape; } table#result.display.dataTable.no-footer thead tr th:last-child , table#result.display.dataTable.no-footer tbody tr td:last-child { text-align: left; } </style>';
    var printcontent = html + style;

    document.body.innerHTML = printcontent;
    window.print();
    window.location.href = redirect;

}
</script>

@endsection
