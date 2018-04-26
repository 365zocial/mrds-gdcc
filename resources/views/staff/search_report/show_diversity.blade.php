@extends('layouts.app')

@section('css')
<style media="screen">
    div.content-box div.filter:last-child div p.record-label {
        margin-bottom: 0px;
    }
</style>
@endsection

@section('script')

    <script type="text/javascript">
        function exportReport( way ) {
            $('.loader').show();
            data_search = '<?php echo $reinputJson; ?>';
            class_form = '<?php echo json_encode( $result['class']['list'] ); ?>';
            order_form = '<?php echo json_encode( $result['order']['list'] ); ?>';
            family_form = '<?php echo json_encode( $result['family']['list'] ); ?>';
            species_form = '<?php echo json_encode( $result['species']['list'] ); ?>';
            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/searchReport/exportDiversity'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: way, // 1 is view class, 2 is view order, 3 is view family, 4 is view species and 5 is view long species
                    data_search: data_search,
                    class: class_form,
                    order: order_form,
                    family: family_form,
                    species: species_form,
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

<div class="row row-header">
    <div class="col-md-12">
        <p class="content-header">Your Diversity Filter</p>
    </div>
</div>

<div class="row row-body">
    <div class="col-md-10 col-md-offset-1">
        <div class="content-box">
            @if ( count($reinput) > 0 )
                @foreach ( $reinput as $key => $inputs )
                    @foreach ( $inputs as $label => $input )
                        @if ($key%3 === 0) <div class="row filter"> @endif
                            <div class="col-md-4">
                                <p class="record-label">{{ $label }}:
                                  <span class="record-data">{!! $input !!}</span>
                                </p>
                            </div>
                        @if (($key+1)%3 === 0) </div> @endif
                    @endforeach
                @endforeach
                @if ( count($reinput)%3 !== 0 ) </div> @endif
            @else
                <p style="text-align: center; font-size: 16px; margin-bottom: 0px;">{!! "No input filter." !!}</p>
            @endif
        </div>
    </div>
</div>

<div class="row row-header">
    <div class="col-md-12">
        <p class="content-header">View Diversity Result</p>
    </div>
</div>

<div class="row row-body row-centered">
    <div class="col-md-3 col-centered">
        <div class="content-box">
            <span class="count-header">Phylum</span>
            <input type="text" class="form-control form-control-custom" name="phylum_count" value="{{ $result['phylum']['count'] }}" size="4" readonly>
        </div>
    </div>

</div>

<div class="row row-body">

    <div class="col-md-4 col-md-offset-2">
        <div class="content-box">
            <form class="form-horizontal" method="POST" action="{{ url('staff/searchReport/biogeography') }}">
                @csrf

                <div class="row row-form">
                    <div class="col-md-12">
                        <span class="count-header">Class</span>
                        <input type="text" class="form-control form-control-custom" name="class_count" value="{{ $result['class']['count'] }}" size="4" readonly>
                    </div>
                </div>

                <div class="row row-form">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header count-header">Class List</p>
                        <textarea class="form-control" name="class_list" rows="7" readonly>@if( count($result['class']['list']) !== 0 )@foreach($result['class']['list'] as $k => $list)@if($k > 0){!!"\n"!!}@endif{{ $list->name }}@endforeach @else{{"No data."}}@endif</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-button">
                        <button type="button" class="btn btn-default btn-gold" onclick="exportReport(1);">View Class List</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="content-box">
            <form class="form-horizontal" method="POST" action="/staff/searchReport/diversity">
                @csrf

                <div class="row row-form">
                    <div class="col-md-12">
                        <span class="count-header">Order</span>
                        <input type="text" class="form-control form-control-custom" name="order_count" value="{{ $result['order']['count'] }}" size="6" readonly>
                    </div>
                </div>

                <div class="row row-form">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header count-header">Order List</p>
                        <textarea class="form-control" name="order_list" rows="7" readonly>@if( count($result['order']['list']) !== 0 )@foreach($result['order']['list'] as $k => $list)@if($k > 0){!!"\n"!!}@endif{{ $list->name }}@endforeach @else{{"No data."}}@endif</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-button">
                        <button type="button" class="btn btn-default btn-gold" onclick="exportReport(2);">View Order List</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="row row-body">
    <div class="col-md-4 col-md-offset-2">
        <div class="content-box">
            <form class="form-horizontal" method="POST" action="/staff/searchReport/diversity">
                @csrf

                <div class="row row-form">
                    <div class="col-md-12">
                        <span class="count-header">Family</span>
                        <input type="text" class="form-control form-control-custom" name="family_count" value="{{ $result['family']['count'] }}" size="6" readonly>
                    </div>
                </div>

                <div class="row row-form">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header count-header">Family List</p>
                        <textarea class="form-control" name="family_list" rows="7" readonly>@if( count($result['family']['list']) !== 0 )@foreach($result['family']['list'] as $k => $list)@if($k > 0){!!"\n"!!}@endif{{ $list->name }}@endforeach @else{{"No data."}}@endif</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-button">
                        <button type="button" class="btn btn-default btn-gold" onclick="exportReport(3);">View Family List</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="content-box">
            <form class="form-horizontal" method="POST" action="/staff/searchReport/diversity">
                @csrf

                <div class="row row-form">
                    <div class="col-md-12" style="text-align: left;">
                        <span class="count-header">Species</span>
                        <input type="text" class="form-control form-control-custom" name="species_count" value="{{ $result['species']['count'] }}" size="6" readonly>
                    </div>
                </div>

                <div class="row row-form">
                    <div class="col-md-12" style="text-align: left;">
                        <p class="search-report-dropdown-header count-header" >Species List</p>
                        <textarea class="form-control" name="species_list" rows="7" readonly>@if( count($result['species']['list']) !== 0 )@foreach($result['species']['list'] as $k => $list)@if($k > 0){!!"\n"!!}@endif{{ $list->name }}@endforeach @else{{"No data."}}@endif</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-button">
                        <button type="button" class="btn btn-default btn-gold" onclick="exportReport(4);">View Species List</button>
                        <button type="button" class="btn btn-default btn-gold" onclick="window.location.href = '<?php echo url("staff/searchReport/reportDiversity") ?>'" style="margin-top: 20px;">View Long List</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
