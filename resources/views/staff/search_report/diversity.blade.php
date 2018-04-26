@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
@endsection

@section('script')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">

    $(document).ready(function() {

        $(".select2").select2();

        // $('#province-content').hide();
        // $('#district-content').hide();
        // $('#county-content').hide();

        //--------- display form ---------//
        $("#div_domain_id").siblings().hide();
        $("#div_domain_id").show();
        $("#div_ocean_sea_lake").siblings().hide();
        $("#div_ocean_sea_lake").show();
        //--------- ------------ ---------//

        checkHeaderTaxonomyChange();
        checkSelectLocality();

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

        function checkSelectLocality(){
            $('#locality_type').change(function(){
                // $('.loader').show();
                var locality_type = $(this).val();
                // alert(locality_type);
                if(locality_type == "ocean_sea_lake"){
                    $("#div_ocean_sea_lake").parent().children().hide();
                    $('#div_ocean_sea_lake').show();
                }else if(locality_type == "country"){
                    $("#div_ocean_sea_lake").parent().children().hide();
                    $('#div_country').show();
                }else if(locality_type == "province"){
                    $("#div_ocean_sea_lake").parent().children().hide();
                    $('#div_province').show();
                }else if(locality_type == "district"){
                    $("#div_ocean_sea_lake").parent().children().hide();
                    $('#div_district').show();
                }else if(locality_type == "county"){
                    $("#div_ocean_sea_lake").parent().children().hide();
                    $('#div_county').show();
                }else if(locality_type == "locality"){
                    $("#div_ocean_sea_lake").parent().children().hide();
                    $('#div_locality').show();
                }

                // $('.loader').fadeOut(50);

            });
        }


        // $(document.body).on('change', '#country', function() {
        //     $('#province-content').hide();
        //     $('#district-content').hide();
        //     $('#county-content').hide();
        //     if( $(this).val() != '' ) {
        //         $('#province-content').show();
        //         $.get( "{{ url('staff/searchReport/diversity/get_location/') }}" + "/1_" + $(this).val() , function( data ) {
        //             if(data != null) {
        //                 var html = '<option value="" selected>Select</option>';
        //                 $.each( data, function(i, item) {
        //                     html += "<option value='" + item.id + "'>" + item.province_en + '/' + item.province_th + "</option>";
        //                 });
        //
        //                 $('#province').html(html).focus();
        //             } else {
        //                 $('#province').html('<option value="" selected>No province list.</option>');
        //             }
        //         });
        //     }
        // });

        // $(document.body).on('change', '#province', function() {
        //     $('#district-content').hide();
        //     $('#county-content').hide();
        //     if( $(this).val() != '' ) {
        //         $.get( "{{ url('staff/searchReport/diversity/get_location/') }}" + "/2_" + $(this).val() , function( data ) {
        //             $('#district-content').show();
        //             if(data != null) {
        //                 var html = '<option value="" selected>Select</option>';
        //                 $.each( data, function(i, item) {
        //                     html += "<option value='" + item.id + "'>" + item.district_en + '/' + item.district_th + "</option>";
        //                 });
        //                 $('#district').html(html).focus();
        //             } else {
        //                 $('#district').html('<option value="" selected>No district list.</option>');
        //             }
        //         });
        //     }
        // });
        //
        // $(document.body).on('change', '#district', function() {
        //     $('#county-content').hide();
        //     if( $(this).val() != '' ) {
        //         $.get( "{{ url('staff/searchReport/diversity/get_location/') }}" + "/3_" + $(this).val() , function( data ) {
        //             $('#county-content').show();
        //             if(data != null) {
        //                 var html = '<option value="" selected>Select</option>';
        //                 $.each( data, function(i, item) {
        //                     html += "<option value='" + item.id + "'>" + item.county_en + '/' + item.county_th + "</option>";
        //                 });
        //                 $('#county').html(html).show().focus();
        //             } else {
        //                 $('#county').html('<option value="" selected>No county list.</option>');
        //             }
        //         });
        //     }
        // });

    });

</script>

@endsection

@section('header')
    <?php
        $headerName = "Search Report";
        $iconFileName = "icon_search_report.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Search Report'] = url('staff/searchReport/dashboard');
        $breadcump['Diversity'] = url('staff/searchReport/diversity');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Diversity</p>
            <p class="content-help-text">Enter counting criteria here. Numbers of matches are shown below.</p>

            <form class="form-horizontal search-report-form" method="POST" action="{{ url('staff/searchReport/diversity') }}">
                @csrf

                <div class="row row-inform">

                    <?php
                        $arr = [
                            ['div_domain_id','domain'],                      // 0
                            ['div_kingdom_id', 'kingdom'],                   // 1
                            ['div_subkingdom_id', 'subkingdom'],             // 2
                            ['div_infrakingdom_id', 'infrakingdom'],         // 3
                            ['div_phylum_id', 'phylum'],                     // 4
                            ['div_subphylum_id', 'subphylum'],               // 5
                            ['div_infraphylum_id', 'infraphylum'],           // 6
                            ['div_superclass_id', 'superclass'],             // 7
                            ['div_class_id', 'class'],                       // 8
                            ['div_subclass_id', 'subclass'],                 // 9
                            ['div_infraclass_id', 'infraclass'],             // 10
                            ['div_superorder_id', 'superorder'],             // 11
                            ['div_order_id', 'order'],                       // 12
                            ['div_suborder_id', 'suborder'],                 // 13
                            ['div_infraorder_id', 'infraorder'],             // 14
                            ['div_superfamily_id', 'superfamily'],           // 15
                            ['div_family_id', 'family'],                     // 16
                            ['div_subfamily_id', 'subfamily'],               // 17
                            ['div_genus_id', 'genus'],                       // 18
                            ['div_subgenus_id', 'subgenus'],                 // 19
                            ['div_species_id', 'species'],                   // 20
                            ['div_subspecies_id', 'subspecies']              // 21
                        ];
                    ?>

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

                    <div class="col-md-6">
                        <!-- <p class="search-report-dropdown-header"></p> -->
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
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    @elseif ($i == 19 && $subgenuses != null )
                                        <option value="0">Select</option>
                                        @foreach ( $subgenuses as $data )
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    @elseif ($i == 20 && $specieses != null )
                                        <option value="0">Select</option>
                                        @foreach ( $specieses as $data )
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    @elseif ($i == 21 && $subspecieses != null )
                                        <option value="0">Select</option>
                                        @foreach ( $subspecieses as $data )
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="0">Select</option>
                                    @endif

                                </select>
                            </div> <!-- /.{{ $arr[$i][0] }} -->
                        @endfor

                    </div>


                </div>

                <hr class="search-report">

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Locality</p>
                        <select class="form-control select2" id="locality_type" name="locality_type">
                            <option value="ocean_sea_lake">Ocean/Sea/Lake</option>
                            <option value="country">Country</option>
                            <option value="province">Province</option>
                            <option value="district">District</option>
                            <option value="county">County</option>
                            <option value="locality">Locality</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <p class="search-report-dropdown-header"></p>
                        <div class="" id="div_ocean_sea_lake" style="padding-top: 27px;">
                            <select class="form-control search-report-select select2" name="ocean_sea_lake" >
                                @if( count($ocean_sea_lake) !== 0 )
                                <option value="" selected>Select</option>
                                @foreach ( $ocean_sea_lake as $get )
                                <option value="{{ $get->id }}">{{ $get->name_en }}</option>
                                @endforeach
                                @else
                                <option value="" selected disabled>No list in select</option>
                                @endif
                            </select>
                        </div>

                        <div class="" id="div_country" style="padding-top: 27px;">
                            <select id="country" class="form-control search-report-select select2" name="country" >
                                @if( count($country) !== 0 )
                                    <option value="" selected>Select</option>
                                    @foreach ( $country as $get )
                                        <option value="{{ $get->id }}">{{ $get->country_en }}/{{ $get->country_th }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected disabled>No list in select</option>
                                @endif
                            </select>
                        </div>

                        <div class="" id="div_province" style="padding-top: 27px;">
                            <select id="province" class="form-control search-report-select select2" name="province" >
                                @if( !empty($province) )
                                    <option value="" selected>Select</option>
                                    @foreach ( $province as $get )
                                        <option value="{{ $get->id }}">{{ $get->province_en }}/{{ $get->province_th }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected disabled>Select Country Before</option>
                                @endif
                            </select>
                        </div>

                        <div class="" id="div_district" style="padding-top: 27px;">
                            <select id="district" class="form-control search-report-select select2" name="district" >
                                @if( !empty($district) )
                                    <option value="" selected>Select</option>
                                    @foreach ( $district as $get )
                                        <option value="{{ $get->id }}">{{ $get->district_en }}/{{ $get->district_th }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected disabled>Select Province Before</option>
                                @endif
                            </select>
                        </div>

                        <div class="" id="div_county" style="padding-top: 27px;">
                            <select id="county" class="form-control search-report-select select2" name="county" >
                                @if( !empty($county) )
                                    <option value="" selected>Select</option>
                                    @foreach ( $county as $get )
                                        <option value="{{ $get->id }}">{{ $get->county_en }}/{{ $get->county_th }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected disabled>Select District Before</option>
                                @endif
                            </select>
                        </div>

                        <div class="" id="div_locality" style="padding-top: 27px;">
                            <input type="text" class="form-control" name="locality" value="" placeholder="Text Input" style="font-size: 16px;">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 search-report-button">
                            <button type="submit" class="btn btn-default btn-gold">Start Counting</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
