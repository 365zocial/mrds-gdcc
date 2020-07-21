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
    </style>
@endsection

@section('script')
    @include('base_wording_js')

    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>
    <script src="{{ URL::asset('assets/script/name_record_script.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        function getCurrentParam(){
            return {
                _token: "{{ csrf_token() }}",
                name_record_type: $('#name_record_type').val(),
                local_name: $('.dd_filter_name_record_sub.local_name > select').val(),
                vernacular_name: $('.dd_filter_name_record_sub.vernacular_name > select').val(),
                common_name: $('.dd_filter_name_record_sub.common_name > select').val(),
                name_type: $('#name_type').val(),
                identifier: $('.dd_filter_name_sub.identifier > select').val(),
                collector: $('.dd_filter_name_sub.collector > select').val(),
            }
        }
        $(document).ready(function() {

            // Loader
            $('.loader').show();
            window.setTimeout(function(){
                $('.loader').fadeOut(750);
            },500);

            /* select2 */
            $(".select2").select2();

            // ajax get result
            $('#form').submit(function(e){
                e.preventDefault();
                e.returnValue = false;
                $('.loader').show();

                $.ajax({
                    method: "POST",
                    url: "<?php echo url('search/doNameRecord'); ?>",
                    data: {
                        way: 1, // 1 is search, 2 is ajax
                        ...getCurrentParam()
                    }
                }).done(function( data ) {
                    $('.table_result').slideDown();
                    tb.clear().draw();
                    $count = 1;

                    @if(false)
                    $.each(data['results'], function(i, data){
                        tb.row.add( [
                            $count,
                            (typeof data['related_catalog_item'] === "string") ? data['related_catalog_item'] : ""  + (typeof data['related_reference_item'] === "string") ? data['related_reference_item'] : "",
                            data['current_scientific_name_format']
                        ] ).draw();
                        $count++;

                    });
                    @endif

                    name_result = data['name_type'] + ' : ' + data['search'];
                    name_record_result = data['name_record_type'] + ' : ' + data['search_record'];

                    // $('.source_result').html(source);
                    $('.name_result').html(name_result);
                    $('.name_record_result').html(name_record_result);
                    

                    $('.loader').hide();
                    initDatatable()
                });
            });
        });

        var table = $('#recordDataTable').DataTable({});;
        function initDatatable(){
            table.destroy();
            table = $('#recordDataTable').DataTable({
                // order: [2, 'asc'],
                // bFilter: true,
                // bLengthChange: true,
                // "paging": true,
                // pagingType: "full_numbers",
                processing: true,
                serverSide: true,
                ajax: {
                method: "POST",
                url: '{!! route('typec.record.datatable') !!}',
                data: getCurrentParam()
                },
                columns: [
                    { data: 'DT_Row_Index', orderable: false, searchable: false },   
                    { data: 'cate_ref', orderable: false, searchable: false },
                    { data: 'current_scientific_name_format', name: 'classification.current_scientific_name_format'},
                    { data: 'local_name', name: 'record.local_name'},
                    { data: 'vernacular_name', name: 'record.vernacular_name'},
                    { data: 'common_name', name: 'classification.common_name'},
                    { data: 'showpic', orderable: false, searchable: false },   
                    
                ],
            });
        }

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "<?php echo url('search/doNameRecord'); ?>",
                data: {
                    way: 2, // 1 is search, 2 is ajax
                    ...getCurrentParam()
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = "<?php echo '/export_result_record'; ?>"  + '/' + data;

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
            $breadcump['สืบค้นรายการจากชื่อ'] = url('search/searchByNameRecord');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Search By Name Record'] = url('search/searchByNameRecord');
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

    <?php
    $name_filters = [
        [$collector,'collector'],
        [$identifier,'identifier'],
    ];

    $name_record_filters = [
        [$local_name,'local_name'],
        [$vernacular_name,'vernacular_name'],
        [$common_name,'common_name'],
    ];

    
    ?>


        
<div class="row row-with-margin search-category-pages">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">@if($lang == 2){{'สืบค้นรายการจากชื่อ'}}@else{{'Search by Name Record'}}@endif </p>
            <p class="content-help-text">@if($lang == 2){{'คุณสามารถสืบค้นข้อมูลสิ่งมีชีวิตทั้งหมดได้ด้วยหน้าฟอร์มนี้'}}@else{{'You can search all record by these form.'}}@endif</p>

            <form action="#" method="post" id="form" name="form">
                @csrf

                <!-- Search by name Record -->
                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาด้วยข้อมูลตาราง'}}@else{{'Name Record'}}@endif</p>
                        <select class="form-control select2" id="name_record_type" name="name_record_type">
                            <option value="local_name">@if($lang == 2){{'ชื่อพื้นเมือง'}}@else{{'Local Name'}}@endif</option>
                            <option value="vernacular_name">@if($lang == 2){{'ชื่อท้องถิ่น (ชื่อพื้นบ้าน)'}}@else{{'Vernacular Name'}}@endif</option>
                            <option value="common_name">@if($lang == 2){{'ชื่อสามัญ'}}@else{{'Common Name'}}@endif</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        @foreach($name_record_filters as $arr_filter)
                        <div class="dd_filter_name_record_sub {{ $arr_filter[1] }}" style="display:none;">
                            <p class="search-report-dropdown-header">&nbsp;</p>
                            <select class="form-control select2" name="{{ $arr_filter[1] }}" id="">
                                <option selected disabled="" value="0">Select</option>
                                @foreach( $arr_filter[0] as $value )
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        {{-- <input type="text" class="form-control" id="search" name="search" placeholder="@if($lang == 2){{'ชื่อที่ต้องการค้นหา'}}@else{{'Input Text'}}@endif" required> --}}
                    </div>
                </div>
                <!-- /.Search by name Record -->


                <!-- Search by name  -->
                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ค้นหาด้วยข้อมูลบุคคล'}}@else{{'Name'}}@endif</p>
                        <select class="form-control select2" id="name_type" name="name_type">
                            <option value="collector">@if($lang == 2){{'ผู้เก็บตัวอย่าง'}}@else{{'Collector'}}@endif</option>
                            <option value="identifier">@if($lang == 2){{'ผู้ตรวจสอบ'}}@else{{'Identifier'}}@endif</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        @foreach($name_filters as $arr_filter)
                        <div class="dd_filter_name_sub {{ $arr_filter[1] }}" style="display:none;">
                            <p class="search-report-dropdown-header">&nbsp;</p>
                            <select class="form-control select2" name="{{ $arr_filter[1] }}" id="">
                                <option selected disabled="" value="0">Select</option>
                                @foreach( $arr_filter[0] as $value )
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        {{-- <input type="text" class="form-control" id="search" name="search" placeholder="@if($lang == 2){{'ชื่อที่ต้องการค้นหา'}}@else{{'Input Text'}}@endif" required> --}}
                    </div>
                </div>
                <!-- /.Search by name -->

                <!-- Submit Button -->
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-12" style="text-align: center; padding-top: 15px;">
                        <button id="submit_button" type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">@if($lang == 2){{'ค้นหา'}}@else{{'Search Data'}}@endif</button>
                    </div>
                </div>
                <!-- /.Submit Button -->


            </form>

        </div>
    </div>
</div>

<div id="print-area">

    <div class="row table_result" style="display: none;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <p class="content-header search-result">Search Result</p>
                    <p class="record-label search-result">
                        Name: <span class="record-data" style="margin-right: 30px;"><span class="name_result"></span></span><br>
                        Name Record: <span class="record-data" style="margin-right: 30px;"><span class="name_record_result"></span></span><br>
                    </p>
                </div>
                <div id="remove-when-print" class="col-md-4" style="text-align: right;">
                    <button id="print-table" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="printContent('{{ url()->current() }}')"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
                    <button id="export_button" class="btn btn-default btn-gold" style="font-size: 16px;" onclick="exportRecord()">Export All File to CSV</button>
                    <p class="content-help-text" style="margin-bottom: 0px; margin-top: 5px;">*CSV file can be open to Microsoft Excel.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row table_result" style="display: none;">
        <div class="col-md-12">
            <table id="recordDataTable" class="display" cellspacing="0">
                <thead>
                        <th>No.</th>
                        <th>IDCatalog</th>
                        <th>Scientific Name</th>
                        <th>Local Name</th>
                        <th>Vernacular Name</th>
                        <th>Common Name</th>
                        <th>Picture</th>
                        
                </thead>
            </table>
        </div>
    </div>

</div>

<script type="text/javascript">
function printContent(redirect){

    $('#print-area div.table_result div table#result.display.dataTable.no-footer thead tr th:last-child').remove();
    $('#print-area div.table_result div table#result.display.dataTable.no-footer tbody tr td:last-child').remove();
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
