@extends('layouts.app')

@section('css')
    @include('base_wording_css')

    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">

    <style>
        .padding_inform {
            padding-left: 15px;
            padding-right: 15px;
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
            window.setTimeout( function() {
                $('.loader').fadeOut(750);
            }, 500);

            // use loader for click
            $('#search_by_taxonomy').click( function() {
                $('.loader').show();
            });
        });

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
    ?>
@endsection

@section('contain')

    <div class="row">
        <div class="col-md-12">
            <p class="content-header">Select Search Type</p>
            <p class="content-help-text" style="text-align: center; margin-bottom: 0px;">You can search for your required information by these topics.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByDate') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Date</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByDistribution') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Distribution</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByID') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">IDCatalog / IDRef</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3">
            <!-- <a href="{{ url('staff/searchCategory/searchByKeyword') }}" class="wording-link"> -->
            <a href="{{ url('staff/searchCategory/searchByKeyword') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Keyword</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->
    </div>

    <div class="row">
        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByLocality') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Locality</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByName') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Name</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByTaxonomy') }}" id="search_by_taxonomy" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Taxonomy</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

        <div class="col-md-3">
            <a href="{{ url('staff/searchCategory/searchByNameRecord') }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">Name Record</p>
                </div>
            </a>
        </div> <!-- /.col-md-3 -->

    </div> <!-- /.row -->
@endsection
