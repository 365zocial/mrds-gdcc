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
            $headerName = "ศูนย์วิจัย";
        }else{
            $headerName = "Marine Center";
        }
        $iconFileName = "icon_dashboard_manager/word_in_system.png";
     ?>
@endsection

@section('breadcump')
    <?php
        if($lang == 2){
            $breadcump['หน้าควบคุม'] = url('/');
            $breadcump['ความหมายของชื่อ'] = url('abbreviation');
            $breadcump['ศูนย์วิจัย'] = url('abbreviation/MarineCenter');
        }else{
            $breadcump['Dashboard'] = url('/');
            $breadcump['Abbreviation'] = url('abbreviation');
            $breadcump['Marine Center'] = url('abbreviation/MarineCenter');
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
    			<th class="th-padding-left">MarineCenter Code</th>
    			<th class="th-padding-left">Wording EN</th>
    			<th class="th-padding-left">Wording TH</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php $no = 1;?>
        @foreach($marinecenters as $marinecenter)
    		<tr>
    			<td>{{ $no }}</td>
    			<td>{{ $marinecenter->marinecenter_code }}</td>
    			<td>{{ $marinecenter->marinecenter }}</td>
    			<td style="text-align: left;">{{ $marinecenter->marinecenter_th }}</td>
    		</tr>
    	<?php ++$no; ?>
    	@endforeach
    	</tbody>
    </table> <!-- /.table -->
</div>

@endsection
