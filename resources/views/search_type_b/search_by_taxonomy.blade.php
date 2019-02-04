@extends('layouts.app')

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
            },3000);

            /* select2 */
            $(".select2").select2();

            //--------- display form ---------//
            $("#div_domain_id").siblings().hide();
            $("#div_domain_id").show();
            //--------- ------------ ---------//

            checkHeaderTaxonomyChange();

            // ajax get result
            $('#form').submit(function(e){
                e.preventDefault();
                e.returnValue = false;
                $('.loader').show();
                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/searchCategory/doSearchTaxonomy'); ?>",
                    data: {
                        _token: "{{ csrf_token() }}",
                        way: 1, // 1 is search, 2 is ajax
                        source: $("input[name=source]:checked").val(),
                        header_taxonomy_id: $('#header_taxonomy_id').val(),
                        domain_id: $('#domain_id').val(),
                        kingdom_id: $('#kingdom_id').val(),
                        subkingdom_id: $('#subkingdom_id').val(),
                        infrakingdom_id: $('#infrakingdom_id').val(),
                        phylum_id: $('#phylum_id').val(),
                        subphylum_id: $('#subphylum_id').val(),
                        infraphylum_id: $('#infraphylum_id').val(),
                        superclass_id: $('#superclass_id').val(),
                        class_id: $('#class_id').val(),
                        subclass_id: $('#subclass_id').val(),
                        infraclass_id: $('#infraclass_id').val(),
                        superorder_id: $('#superorder_id').val(),
                        order_id: $('#order_id').val(),
                        suborder_id: $('#suborder_id').val(),
                        infraorder_id: $('#infraorder_id').val(),
                        superfamily_id: $('#superfamily_id').val(),
                        family_id: $('#family_id').val(),
                        subfamily_id: $('#subfamily_id').val(),
                        genus_id: $('#genus_id').val(),
                        subgenus_id: $('#subgenus_id').val(),
                        species_id: $('#species_id').val(),
                        subspecies_id: $('#subspecies_id').val(),
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

                    if( data['header_taxonomy'] == "Species" || data['header_taxonomy'] == "Subspecies" ){
                        data['taxonomy'] = "<i>"+data['taxonomy'].toLowerCase()+"<i>";
                    }else{
                        data['taxonomy'] = capitalizeFirstLetter(data['taxonomy']);
                    }

                    taxonomy_result = data['header_taxonomy'] + ' - ' + data['taxonomy'];

                    $('.source_result').html(source);
                    $('.taxonomy_result').html(taxonomy_result);

                    $('.loader').hide();
                });
            });

        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function checkHeaderTaxonomyChange() {
            var div_name = ['#div_domain_id','#div_kingdom_id','#div_subkingdom_id','#div_infrakingdom_id','#div_phylum_id','#div_subphylum_id','#div_infraphylum_id','#div_superclass_id','#div_class_id','#div_subclass_id','#div_infraclass_id','#div_superorder_id','#div_order_id','#div_suborder_id','#div_infraorder_id','#div_superfamily_id','#div_family_id','#div_subfamily_id','#div_genus_id','#div_subgenus_id','#div_species_id','#div_subspecies_id'];

            $("#header_taxonomy_id").change(function(){
                $('.loader').show();
                header_taxonomy_id = $('#header_taxonomy_id').val();
                $(div_name[header_taxonomy_id-1]).siblings().hide();
                $(div_name[header_taxonomy_id-1]).show();
                $('.loader').fadeOut(750);
            });
        }

        function CreateView( id ) {
            var view = "<a href=<?php echo url("staff/searchCategory/viewCard"); ?>" + '/' + window.btoa( window.btoa( window.btoa( id ))) + " target='_blank'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span> View Card</a>";
            return view;
        }

        function CreateLink( id ) {
            var link = "<a href=<?php echo url("staff/searchCategory/viewRecord"); ?>" + '/' + window.btoa( window.btoa( window.btoa( id ))) + " target='_blank'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> View Detail</a>";
            return link;
        }

        // export record from result
        function exportRecord() {
            $('.loader').show();
            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/searchCategory/doSearchTaxonomy'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: 2, // 1 is search, 2 is ajax
                    source: $("input[name=source]:checked").val(),
                    header_taxonomy_id: $('#header_taxonomy_id').val(),
                    domain_id: $('#domain_id').val(),
                    kingdom_id: $('#kingdom_id').val(),
                    subkingdom_id: $('#subkingdom_id').val(),
                    infrakingdom_id: $('#infrakingdom_id').val(),
                    phylum_id: $('#phylum_id').val(),
                    subphylum_id: $('#subphylum_id').val(),
                    infraphylum_id: $('#infraphylum_id').val(),
                    superclass_id: $('#superclass_id').val(),
                    class_id: $('#class_id').val(),
                    subclass_id: $('#subclass_id').val(),
                    infraclass_id: $('#infraclass_id').val(),
                    superorder_id: $('#superorder_id').val(),
                    order_id: $('#order_id').val(),
                    suborder_id: $('#suborder_id').val(),
                    infraorder_id: $('#infraorder_id').val(),
                    superfamily_id: $('#superfamily_id').val(),
                    family_id: $('#family_id').val(),
                    subfamily_id: $('#subfamily_id').val(),
                    genus_id: $('#genus_id').val(),
                    subgenus_id: $('#subgenus_id').val(),
                    species_id: $('#species_id').val(),
                    subspecies_id: $('#subspecies_id').val(),
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
        $headerName = "Search Category";
        $iconFileName = "icon_dashboard_manager/search_category.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Category'] = url('staff/searchCategory/searchDashboard');
        $breadcump['Search By Taxonomy'] = url('staff/searchCategory/searchByTaxonomy');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin search-category-pages">
    <div class="col-md-6 col-md-offset-3">
        <div class="content-box">
            <p class="content-header">Search by Taxonomy</p>
            <p class="content-help-text">You can search all record by these form.</p>

            <form action="#" method="post" id="form" name="form">
                @csrf

                <?php
                    $arr = [
                        ['div_domain_id','domain_id'],                      // 0
                        ['div_kingdom_id', 'kingdom_id'],                   // 1
                        ['div_subkingdom_id', 'subkingdom_id'],             // 2
                        ['div_infrakingdom_id', 'infrakingdom_id'],         // 3
                        ['div_phylum_id', 'phylum_id'],                     // 4
                        ['div_subphylum_id', 'subphylum_id'],               // 5
                        ['div_infraphylum_id', 'infraphylum_id'],           // 6
                        ['div_superclass_id', 'superclass_id'],             // 7
                        ['div_class_id', 'class_id'],                       // 8
                        ['div_subclass_id', 'subclass_id'],                 // 9
                        ['div_infraclass_id', 'infraclass_id'],             // 10
                        ['div_superorder_id', 'superorder_id'],             // 11
                        ['div_order_id', 'order_id'],                       // 12
                        ['div_suborder_id', 'suborder_id'],                 // 13
                        ['div_infraorder_id', 'infraorder_id'],             // 14
                        ['div_superfamily_id', 'superfamily_id'],           // 15
                        ['div_family_id', 'family_id'],                     // 16
                        ['div_subfamily_id', 'subfamily_id'],               // 17
                        ['div_genus_id', 'genus_id'],                       // 18
                        ['div_subgenus_id', 'subgenus_id'],                 // 19
                        ['div_species_id', 'species_id'],                   // 20
                        ['div_subspecies_id', 'subspecies_id']              // 21
                    ];
                ?>

                <!-- Choose Specimens or Publication -->
                <div class="row row-inform">
                    <div class="col-md-12" id="choose_source">
                        <p class="search-report-dropdown-header radio">
                            Source
                            <label class="radio-inline">
                                <input type="radio" name="source" value="1" checked> Specimens
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="source" value="2"> Publication
                            </label>
                        </p>
                    </div>
                </div>
                <!-- /.Choose Specimens or Publication -->

                <div class="row" id="choose_search_taxonomy">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Taxonomy</p>
                        <select class="form-control select2" id="header_taxonomy_id" name="header_taxonomy_id">
                            <?php $count = 0; ?>
                            @foreach( $header_taxonomys as $header_taxonomy )
                                <option value="{{ $header_taxonomy->id }}">{{ $header_taxonomy->name }}</option>
                                <?php $count++; ?>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">

                                @for( $i=0 ; $i < sizeof($arr) ; $i++ )
                                    <div id="{{ $arr[$i][0] }}" style="padding-top: 27px;">
                                        <select class="form-control select2" id="{{ $arr[$i][1] }}" name="{{ $arr[$i][1] }}">

                                            @if ( $i == 0 && $domains != null )
                                                <option value="0">Select</option>
                                                @foreach ( $domains as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 1 && $kingdoms != null )
                                                <option value="0">Select</option>
                                                @foreach ( $kingdoms as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 2 && $subkingdoms != null )
                                                <option value="0">Select</option>
                                                @foreach ( $subkingdoms as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 3 && $infrakingdoms != null )
                                                <option value="0">Select</option>
                                                @foreach ( $infrakingdoms as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 4 && $phylums != null )
                                                <option value="0">Select</option>
                                                @foreach ( $phylums as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 5 && $subphylums != null )
                                                <option value="0">Select</option>
                                                @foreach ( $subphylums as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 6 && $infraphylums != null )
                                                <option value="0">Select</option>
                                                @foreach ( $infraphylums as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 7 && $superclasses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $superclasses as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 8 && $classes != null )
                                                <option value="0">Select</option>
                                                @foreach ( $classes as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 9 && $subclasses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $subclasses as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 10 && $infraclasses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $infraclasses as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 11 && $superorders != null )
                                                <option value="0">Select</option>
                                                @foreach ( $superorders as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 12 && $orders != null )
                                                <option value="0">Select</option>
                                                @foreach ( $orders as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 13 && $suborders != null )
                                                <option value="0">Select</option>
                                                @foreach ( $suborders as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 14 && $infraorders != null )
                                                <option value="0">Select</option>
                                                @foreach ( $infraorders as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 15 && $superfamilys != null )
                                                <option value="0">Select</option>
                                                @foreach ( $superfamilys as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 16 && $familys != null )
                                                <option value="0">Select</option>
                                                @foreach ( $familys as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 17 && $subfamilys != null )
                                                <option value="0">Select</option>
                                                @foreach ( $subfamilys as $data )
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @elseif ($i == 18 && $genuses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $genuses as $data )
                                                    <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                                @endforeach
                                            @elseif ($i == 19 && $subgenuses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $subgenuses as $data )
                                                    <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                                @endforeach
                                            @elseif ($i == 20 && $specieses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $specieses as $data )
                                                    <option value="{{ $data->id }}">{{ strtolower($data->name) }}</option>
                                                @endforeach
                                            @elseif ($i == 21 && $subspecieses != null )
                                                <option value="0">Select</option>
                                                @foreach ( $subspecieses as $data )
                                                    <option value="{{ $data->id }}">{{ strtolower($data->name) }}</option>
                                                @endforeach
                                            @else
                                                <option value="0">Select</option>
                                            @endif

                                        </select>
                                    </div> <!-- /.{{ $arr[$i][0] }} -->
                                @endfor

                        </div>
                    </div> <!-- /.col-md-8 -->
                </div>
                <!-- /.Search by taxonomy -->

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
                        Taxanomy: <span class="record-data" style="margin-right: 30px;"><span class="taxonomy_result"></span></span>
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
