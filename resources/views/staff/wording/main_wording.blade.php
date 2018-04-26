@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/wording.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\AllMean;
    ?>
@endsection

@section('header')
    <?php
        $headerName = "Word in System";
        $iconFileName = "icon_dashboard_manager/word_in_system.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Word in System'] = url('staff/mainWording');
    ?>
@endsection

@section('contain')

<div class="row">

    <div class="col-md-3">
        <a href="{{ url('staff/wording/taxonomyList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Taxonomy</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/countryList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Country</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/provinceList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Province</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/districtList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">District</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/countyList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">County</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/collectionList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Collection</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/referenceList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Reference</p>
            </div>
        </a>
    </div>

    @foreach($wording_types as $wording_type)
        <div class="col-md-3">
            <a href="{{ url('staff/wording/wordingList', [$wording_type->name]) }}" class="wording-link">
                <div class="wording-outline">
                    <p class="wording-text">{{ ucwords( str_replace("_"," ",$wording_type->name) ) }}</p>
                </div>
            </a>
        </div>
    @endforeach

    <div class="col-md-3">
        <a href="{{ url('staff/wording/extraFieldList') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Extra Field</p>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ url('staff/wording/pictureBox') }}" class="wording-link">
            <div class="wording-outline">
                <p class="wording-text">Picture Box</p>
            </div>
        </a>
    </div>

</div>

@endsection
