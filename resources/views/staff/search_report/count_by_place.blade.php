@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">

<style type="text/css">

div.content-box.count-by-place {
    padding-bottom: 20px;
}

div.count-by-place-button {
    padding-left: 0px;
    margin-top: 26px;
}

div.count-by-place-button > button {
    width: 100%;
    font-size: 16px;
}

select.count-by-place-select , input.count-by-place-input {
    width: 100%;
    height: 43px;
}

hr.result {
    margin-top: 5px;
    margin-bottom: 10px;
    border-color: #cbcbcb;
}

p.result {
    font-size: 24px;
    font-weight: 500;
    margin-bottom: 0px;
}

p.result > span {
    font-weight: 300;
}

hr.search-report.count-by-place {
    margin-top: 20px;
}

span.select2-selection.select2-selection--single {
    height: 43px;
}

</style>
@endsection

@section('script')
<script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {

    $(".select2").select2();

    $(document.body).on('click', '.btn-count', function() {
        var type = $(this).data('type');

        if(type == 'locality') { var val_id = $('input[name="' + $(this).data('type') + '"]').val(); }
        else { var val_id = $('select[name="' + $(this).data('type') + '"]').val(); }

        if(val_id == '') val_id = 0;
        html = '';
        $.get( "{{ url('staff/searchReport/count_by_place/count') }}/" + $(this).data('type') + "/" + val_id , function( data ) {
            html =  '<div class="col-md-12">';
            html += '<hr class="result">';
            html += '<p class="result">Counted Result: <span>' + data + '</span></p>';
            html += '</div>';
            $('#show-result-' + type).show().html(html);
        });


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
        $breadcump['Count By Place'] = url('staff/searchReport/count_by_place');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-6 col-md-offset-3">
        <div class="content-box count-by-place">
            <p class="content-header">Count by Place</p>

            <div class="row row-inform">
                <div class="col-md-9">
                    <p class="search-report-dropdown-header">Ocean/Sea/Lake</p>
                    <select class="form-control search-report-select count-by-place-select select2" name="ocean_sea_lake">
                    @if( count($dropdown['ocean_sea_lake']) !== 0 )
                        <option value="" selected disabled>Select</option>
                        @foreach ( $dropdown['ocean_sea_lake'] as $get )
                            <option value="{{ $get->id }}">{{ $get->name_en }}/{{ $get->name_th }}</option>
                        @endforeach
                    @else
                        <option value="" selected disabled>No list in select</option>
                    @endif
                    </select>
                </div>

                <div class="col-md-3 search-report-button count-by-place-button">
                    <button class="btn btn-default btn-gold btn-count" data-type='ocean_sea_lake'>Count</button>
                </div>
            </div>

            <div class="row" id="show-result-ocean_sea_lake"></div>

            <hr class="search-report count-by-place">

            <div class="row row-inform">
                <div class="col-md-9">
                    <p class="search-report-dropdown-header">Country</p>
                    <select class="form-control search-report-select count-by-place-select select2" name="country">
                    @if( count($dropdown['country']) !== 0 )
                        <option value="" selected disabled>Select</option>
                        @foreach ( $dropdown['country'] as $get )
                            <option value="{{ $get->id }}">{{ $get->country_en }}/{{ $get->country_th }}</option>
                        @endforeach
                    @else
                        <option value="" selected disabled>No list in select</option>
                    @endif
                    </select>
                </div>

                <div class="col-md-3 search-report-button count-by-place-button">
                    <button class="btn btn-default btn-gold btn-count" data-type='country'>Count</button>
                </div>
            </div>

            <div class="row" id="show-result-country"></div>

            <hr class="search-report count-by-place">

            <div class="row row-inform">
                <div class="col-md-9">
                    <p class="search-report-dropdown-header">Province</p>
                    <select class="form-control search-report-select count-by-place-select select2" name="province">
                    @if( count($dropdown['province']) !== 0 )
                        <option value="" selected disabled>Select</option>
                        @foreach ( $dropdown['province'] as $get )
                            <option value="{{ $get->id }}">{{ $get->province_en }}/{{ $get->province_th }}</option>
                        @endforeach
                    @else
                        <option value="" selected disabled>No list in select</option>
                    @endif
                    </select>
                </div>

                <div class="col-md-3 search-report-button count-by-place-button">
                    <button class="btn btn-default btn-gold btn-count" data-type='province'>Count</button>
                </div>
            </div>

            <div class="row" id="show-result-province"></div>

            <hr class="search-report count-by-place">

            <div class="row row-inform">
                <div class="col-md-9">
                    <p class="search-report-dropdown-header">District</p>
                    <select class="form-control search-report-select count-by-place-select select2" name="district">
                    @if( count($dropdown['district']) !== 0 )
                        <option value="" selected disabled>Select</option>
                        @foreach ( $dropdown['district'] as $get )
                            <option value="{{ $get->id }}">{{ $get->district_en }}/{{ $get->district_th }}</option>
                        @endforeach
                    @else
                        <option value="" selected disabled>No list in select</option>
                    @endif
                    </select>
                </div>

                <div class="col-md-3 search-report-button count-by-place-button">
                    <button class="btn btn-default btn-gold btn-count" data-type='district'>Count</button>
                </div>
            </div>

            <div class="row" id="show-result-district"></div>

            <hr class="search-report count-by-place">

            <div class="row row-inform">
                <div class="col-md-9">
                    <p class="search-report-dropdown-header">County</p>
                    <select class="form-control search-report-select count-by-place-select select2" name="county">
                    @if( count($dropdown['county']) !== 0 )
                        <option value="" selected disabled>Select</option>
                        @foreach ( $dropdown['county'] as $get )
                            <option value="{{ $get->id }}">{{ $get->county_en }}/{{ $get->county_th }}</option>
                        @endforeach
                    @else
                        <option value="" selected disabled>No list in select</option>
                    @endif
                    </select>
                </div>

                <div class="col-md-3 search-report-button count-by-place-button">
                    <button class="btn btn-default btn-gold btn-count" data-type='county'>Count</button>
                </div>
            </div>

            <div class="row" id="show-result-county"></div>

            <hr class="search-report count-by-place">

            <div class="row row-inform">
                <div class="col-md-9">
                    <p class="search-report-dropdown-header">Locality</p>
                    <input type="text" class="form-control search-report-select count-by-place-input" name="locality" placeholder="Enter any text flagment">
                </div>

                <div class="col-md-3 search-report-button count-by-place-button">
                    <button class="btn btn-default btn-gold btn-count" data-type='locality'>Count</button>
                </div>
            </div>

            <div class="row" id="show-result-locality"></div>

        </div>
    </div>
</div>

@endsection
