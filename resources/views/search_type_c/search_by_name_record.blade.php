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

    <script type="text/javascript">
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
                        _token: "{{ csrf_token() }}",
                        way: 1, // 1 is search, 2 is ajax
                        name_type: $('#name_type').val(),
                        search: $('#search').val()
                    }
                }).done(function( data ) {
                    $('.table_result').slideDown();
                    tb.clear().draw();
                    $count = 1;

                    $.each(data['results'], function(i, data){
                        tb.row.add( [
                            $count,
                            (typeof data['related_catalog_item'] === "string") ? data['related_catalog_item'] : ""  + (typeof data['related_reference_item'] === "string") ? data['related_reference_item'] : "",
                            data['current_scientific_name_format']
                        ] ).draw();
                        $count++;

                    });

                    name_result = data['name_type'] + ' : ' + data['search'];

                    // $('.source_result').html(source);
                    $('.name_result').html(name_result);

                    $('.loader').hide();
                });
            });
        });

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "<?php echo url('search/doNameRecord'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: 2, // 1 is search, 2 is ajax
                    name_type: $('#name_type').val(),
                    search: $('#search').val()
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = "<?php echo 'export_result_record'; ?>"  + '/' + data;

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

<div class="row row-with-margin search-category-pages">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">@if($lang == 2){{'สืบค้นรายการจากชื่อ'}}@else{{'Search by Name Record'}}@endif </p>
            <p class="content-help-text">@if($lang == 2){{'คุณสามารถสืบค้นข้อมูลสิ่งมีชีวิตทั้งหมดได้ด้วยหน้าฟอร์มนี้'}}@else{{'You can search all record by these form.'}}@endif</p>

            <form action="#" method="post" id="form" name="form">
                @csrf

                <!-- Search by name -->
                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">@if($lang == 2){{'ชื่อ'}}@else{{'Name'}}@endif</p>
                        <select class="form-control select2" id="name_type" name="name_type">
                            <option value="localname">@if($lang == 2){{'ชื่อพื้นเมือง'}}@else{{'Local Name'}}@endif</option>
                            <option value="vernacularname">@if($lang == 2){{'ชื่อท้องถิ่น (ชื่อพื้นบ้าน)'}}@else{{'Vernacular Name'}}@endif</option>
                            <!-- <option value="commonname">Common Name</option> -->
                        </select>
                    </div>
                    <div class="col-md-8">
                        <p class="search-report-dropdown-header">&nbsp;</p>
                        <input type="text" class="form-control" id="search" name="search" placeholder="@if($lang == 2){{'ชื่อที่ต้องการค้นหา'}}@else{{'Input Text'}}@endif" required>
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
                        Name: <span class="record-data" style="margin-right: 30px;"><span class="name_result"></span></span>
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
            <table id="result" class="display" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>IDCatalog / IDRef</th>
                        <th>Scientific Name</th>
                    </tr>
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
