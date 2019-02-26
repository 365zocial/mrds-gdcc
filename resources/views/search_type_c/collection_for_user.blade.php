@extends('layouts.app_user')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
@endsection

@section('script')
    @include('base_wording_js')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>
@endsection

@section('use_setup')
@endsection

@section('header')
    <?php
        if($lang == 2){
            $headerName = "กลุ่มสิ่งมีชีวิต";
        }else{
            $headerName = "Collection Code";
        }
        $iconFileName = "icon_dashboard_manager/word_in_system.png";
     ?>
@endsection

@section('breadcump')
    <?php
        if($lang == 2){
            $breadcump['หน้าควบคุม'] = url('/');
            $breadcump['ความหมายของชื่อ'] = url('abbreviation');
            $breadcump['กลุ่มสิ่งมีชีวิต'] = url('abbreviation/collectionCode');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Abbreviation'] = url('abbreviation');
            $breadcump['Collection Code'] = url('abbreviation/collectionCode');
        }
    ?>
@endsection

@section('button-on-header')
@endsection

@section('contain')

@include('alert')

<!-- Categories Part -->
<div class="container-infuild">
    <table id="result" class="display" cellspacing="0">
    	<thead>
    		<tr>
    			<th>No.</th>
    			<th class="th-padding-left">Collection Code</th>
    			<th class="th-padding-left">Wording EN</th>
    			<th class="th-padding-left">Wording TH</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php $no = 1;?>
    	@foreach($collections as $collection)
    		<tr>
    			<td>{{ $no }}</td>
    			<td>{{ $collection->col_code }}</td>
    			<td>{{ $collection->name_en }}</td>
    			<td style="text-align: left;">{{ $collection->name_th }}</td>
    		</tr>
    	<?php ++$no; ?>
    	@endforeach
    	</tbody>
    </table> <!-- /.table -->
</div>

@endsection
