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
        $(document).ready(function() {

            // Loader
            $('.loader').show();
            window.setTimeout(function(){
                $('.loader').fadeOut(750);
            },500);

            /* select2 */
            $(".select2").select2();

            function CreateView( id ) {
                var view = "<a href=<?php echo url("staff/searchCategory/viewCard"); ?>" + '/' + window.btoa( window.btoa( window.btoa( id ))) + " target='_blank'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span> View Card</a>";
                return view;
            }

            function CreateLink( id ) {
                var link = "<a href=<?php echo url("staff/searchCategory/viewRecord"); ?>" + '/' + window.btoa( window.btoa( window.btoa( id ))) + " target='_blank'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> View Detail</a>";
                return link;
            }

            // ajax get result
            $('#form').submit(function(e){
                e.preventDefault();
                e.returnValue = false;
                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/searchCategory/doSearchKeyword'); ?>",
                    data: {
                        _token: "{{ csrf_token() }}",
                        way: 1, // 1 is search, 2 is ajax
                        keyword1 : $('#keyword1').val(),
                        keyword2 : $('#keyword2').val(),
                        keyword3 : $('#keyword3').val(),
                        source: $("input[name=source]:checked").val(),
                    }
                }).done(function( data ) {
                    $('.table_result').slideDown();
                    tb.clear().draw();
                    $count = 1;
                    if ( data['source'] == 1 ) {    // specimens
                        $.each(data['results'], function(i, data){
                            tb.row.add( [
                                $count,
                                data['related_catalog_item'],
                                data['current_scientific_name_format'],
                                CreateView( data['id'] ) +
                                    '<span class="between"> | </span>' +
                                    CreateLink( data['id'] )
                            ] ).draw();
                            $count++;

                        });
                    } else {    // publication
                        $.each(data['results'], function(i, data){
                            tb.row.add( [
                                $count,
                                data['related_reference_item'],
                                data['current_scientific_name_format'],
                                CreateView( data['id'] ) +
                                    '<span class="between"> | </span>' +
                                    CreateLink( data['id'] )
                            ] ).draw();
                            $count++;
                        });
                    }

                    if ( data['source'] == 1 ) {
                        source = 'Specimens';
                    } else {
                        source = 'Publication';
                    }

                    $('.keyword1').html(data['keyword1']);
                    $('.keyword2').html(data['keyword2']);
                    $('.keyword3').html(data['keyword3']);
                    $('.source_result').html(source);

                });
            });

        });

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/searchCategory/doSearchKeyword'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: 2, // 1 is search, 2 is ajax
                    source: $("input[name=source]:checked").val(),
                    keyword1: $('#keyword1').val(),
                    keyword2: $('#keyword2').val(),
                    keyword3: $('#keyword3').val(),
                }
            }).done(function( data ) {
                if ( data ) {
                    window.location.href = '<?php echo url('export_result_record') ?>'+ '/' + data;

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
        $headerName = "Search Category";
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Category'] = url('staff/searchCategory/searchDashboard');
        $breadcump['Search By Keyword'] = url('staff/searchCategory/searchByKeyword');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-6 col-md-offset-3">
        <div class="content-box">
            <p class="content-header">Search by Keyword</p>
            <p class="content-help-text">You can search all record by these form.</p>

            <form action="#" method="post" id="form" name="form">
                @csrf

                <!-- Choose Specimens or Publication -->
                <div class="row row-inform">
                    <div class="col-md-12" id="choose_source">
                        <p class="search-report-dropdown-header radio">
                            Source
                            <label class="radio-inline">
                                <input type="radio" id="source1" name="source" value="1" checked> Specimens
                            </label>
                            <label class="radio-inline">
                                <input type="radio" id="source2" name="source" value="2"> Publication
                            </label>
                        </p>
                    </div>
                </div>
                <!-- /.Choose Specimens or Publication -->

                <!-- Search by keyword -->
                <div class="row row-inform" id="choose_search_keyword">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Keyword 1</p>
                        <input type="text" class="form-control" id="keyword1" name="keyword1" placeholder="Input Text" required>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Keyword 2</p>
                        <input type="text" class="form-control" id="keyword2" name="keyword2" placeholder="Input Text">
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Keyword 3</p>
                        <input type="text" class="form-control" id="keyword3" name="keyword3" placeholder="Input Text">
                    </div>
                </div>
                <!-- /.Search by keyword -->

                <!-- Submit Button -->
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-12" style="text-align: center; padding-top: 15px;">
                        <button id="submit_button" type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Search Data</button>
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
                        Source: <span class="record-data" style="margin-right: 30px;"><span class="source_result"></span></span>
                        Keyword 1: <span class="record-data" style="margin-right: 30px;"><span class="keyword1"></span></span>
                        Keyword 2: <span class="record-data" style="margin-right: 30px;"><span class="keyword2"></span></span>
                        Keyword 3: <span class="record-data" style="margin-right: 30px;"><span class="keyword3"></span></span>
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
                        <th style="text-align: center;">Action</th>
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
