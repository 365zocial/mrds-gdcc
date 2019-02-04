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
            ocean_sea_lake = '<?php echo json_encode( $result['ocean_sea_lake']['list'] ); ?>';
            country = '<?php echo json_encode( $result['country']['list'] ); ?>';
            province = '<?php echo json_encode( $result['province']['list'] ); ?>';
            district = '<?php echo json_encode( $result['district']['list'] ); ?>';
            county = '<?php echo json_encode( $result['county']['list'] ); ?>';
            locality = '<?php echo json_encode( $result['locality']['list'] ); ?>';
            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/searchReport/exportBiogeography'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    way: way, // 0 is view Ocean Sea, 1 is view Country, 2 is view Province, 3 is view District, 4 is view County, 5 is view Locality
                    data_search: data_search,
                    ocean_sea_lake: ocean_sea_lake,
                    country: country,
                    province: province,
                    district: district,
                    county: county,
                    locality: locality
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

<div class="row row-header">
    <div class="col-md-12">
        <p class="content-header">Your Biogeography Filter</p>
    </div>
</div>


<div class="row row-body">
    <div class="col-md-4 col-md-offset-4">
        <div class="content-box">
            <?php $arr_disable_click = []; ?>
            @if ( count($reinput) > 0 )
                @foreach ( $reinput as $key => $inputs )
                    @foreach ( $inputs as $label => $input )
                        <?php $arr_disable_click[] = strtolower($label); ?>
                        @if ($key%3 === 0) <div class="row filter"> @endif
                            <div class="col-md-12" style="text-align:center;">
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
        <p class="content-header">View Report</p>
    </div>
</div>

<div class="row row-body row-centered">
<!-- onclick="window.location.href = '{{ url('staff/checkClassificationForm') }}';" -->
    <div class="col-md-2 col-centered @if( !in_array('phylum',$arr_disable_click)) {{ 'hide-click' }} @endif" @if( in_array('phylum',$arr_disable_click)) onclick="window.location.href = '<?php echo url("staff/searchReport/reportBio/phylum") ?>'" @else title="Phylum does't select"  @endif >
        <div class="view-report">
            <p class="report-name">Phylum<br>Report</p>
        </div>
    </div>

    <div class="col-md-2 col-centered @if( !in_array('class',$arr_disable_click)) {{ 'hide-click' }} @endif" @if( in_array('class',$arr_disable_click)) onclick="window.location.href = '<?php echo url("staff/searchReport/reportBio/class") ?>'" @else title="Class does't select" @endif >
        <div class="view-report">
            <p class="report-name">Class<br>Report</p>
        </div>
    </div>

    <div class="col-md-2 col-centered @if( !in_array('order',$arr_disable_click)) {{ 'hide-click' }} @endif" @if( in_array('order',$arr_disable_click)) onclick="window.location.href = '<?php echo url("staff/searchReport/reportBio/order") ?>'" @else title="Order does't select"  @endif >
        <div class="view-report">
            <p class="report-name">Order<br>Report</p>
        </div>
    </div>

    <div class="col-md-2 col-centered @if( !in_array('family',$arr_disable_click)) {{ 'hide-click' }} @endif" @if( in_array('family',$arr_disable_click)) onclick="window.location.href = '<?php echo url("staff/searchReport/reportBio/family") ?>'" @else title="Family does't select"  @endif >
        <div class="view-report">
            <p class="report-name">Family<br>Report</p>
        </div>
    </div>

    <div class="col-md-2 col-centered @if( !in_array('species',$arr_disable_click)) {{ 'hide-click' }} @endif" @if( in_array('species',$arr_disable_click)) onclick="window.location.href = '<?php echo url("staff/searchReport/reportBio/species") ?>'" @else title="Species does't select"  @endif >
        <div class="view-report">
            <p class="report-name">Species<br>Report</p>
        </div>
    </div>

</div>

<div class="row row-header">
    <div class="col-md-12">
        <p class="content-header">View Biogeography Result</p>
    </div>
</div>

@if( !empty($result) )

<?php $i=0; $c=0; ?>
@foreach( $result as $key => $get )
    @if( $i%3 === 0 && $c === 1 ) </div> <?php $c = 0; ?> @endif
    @if( $i%3 === 0 ) <div class="row row-body"> <?php $c = 1; ?> @endif
        <div class="col-md-4">
            <div class="content-box">

                <form class="form-horizontal" method="POST" action="{{ url('staff/searchReport/biogeography') }}">
                    @csrf

                    <div class="row row-form">
                        <div class="col-md-12">
                            <span class="count-header">{{ $get['name'] }}</span>
                            <input type="text" class="form-control form-control-custom" name="{{ $key }}_count" value="{{ $get['count'] }}" size="6" readonly>
                        </div>
                    </div>

                    <div class="row row-form">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header count-header">{{ $get['name'] }} List</p>
                            <textarea class="form-control" name="{{ $key }}_list" rows="7" readonly>@if( count($get['list']) !== 0 )@foreach($get['list'] as $k => $list)@if($k > 0){!!"\n"!!}@endif{!! $list->name !!}/@if($list->name != ' '){!! $list->name_th !!}@endif @endforeach @else{{"No data."}} @endif</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-button">
                            <button type="button" class="btn btn-default btn-gold" onclick="exportReport({{$i}});">View {{ $get['name'] }} List</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    <?php $i+=1; ?>
@endforeach
</div>
@endif

@endsection
