@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
@endsection

@section('script')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();

            var header_taxonomy_id = 1;
            //--------- display form ---------//
            $("#div_domain_id").siblings().hide();
            $("#div_domain_id").show();
            //--------- ------------ ---------//

            checkHeaderTaxonomyChange();

            function checkHeaderTaxonomyChange() {
                var div_name = ['#div_domain_id','#div_kingdom_id','#div_subkingdom_id','#div_infrakingdom_id','#div_phylum_id','#div_subphylum_id','#div_infraphylum_id','#div_superclass_id','#div_class_id','#div_subclass_id','#div_infraclass_id','#div_superorder_id','#div_order_id','#div_suborder_id','#div_infraorder_id','#div_superfamily_id','#div_family_id','#div_subfamily_id','#div_genus_id','#div_subgenus_id','#div_species_id','#div_subspecies_id'];

                $("#header_taxonomy_id").change(function(){
                    $('.clear_require').removeAttr("required");
                    $('.loader').show();
                    header_taxonomy_id = $('#header_taxonomy_id').val();
                    $(div_name[header_taxonomy_id-1]).siblings().hide();
                    $(div_name[header_taxonomy_id-1]).show();
                    $(div_name[header_taxonomy_id-1]).children("select").attr("required", true);
                    $('.loader').fadeOut(750);
                });
            }

            $('form').submit(function(){
                if( $('.clear_require').eq(header_taxonomy_id-1).val() == 0 ){
                    $('.clear_require').eq(header_taxonomy_id-1).select2('open');
                    return false;
                }
            });

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
        $breadcump['Biogeography'] = url('staff/searchReport/biogeography');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Biogeography</p>
            <p class="content-help-text">Enter counting criteria here. Numbers of matches are shown below.</p>

            <form class="form-horizontal search-report-form" method="POST" action="{{ url('staff/searchReport/biogeography') }}">
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
                                <select class="form-control select2 clear_require" id="{{ $arr[$i][1] }}" name="{{ $arr[$i][1] }}" @if($i == 0) required  @endif>

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

                <div class="row">
                    <div class="col-md-12 search-report-button">
                        <button type="submit" class="btn btn-default btn-gold">Start Counting</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
