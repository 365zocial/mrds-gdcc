@extends('layouts.app_user')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
    <style>
        #disable_data {
            color: red;
        }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>
    <script type="text/javascript">
		$(document).ready(function() {

			/* parsley */
	    	$('#add_modal_form').parsley();
            $("#add_reference_en").attr("required", "true");
	    	$("#add_reference_th").attr("required", "true");

            $('#edit_modal_form').parsley();
            $("#edit_reference_en").attr("required", "true");
	    	$("#edit_reference_th").attr("required", "true");

            editModal();

            $( "#add_modal_form" ).submit(function() {
                disableSumitButton(1);
            });

            $( "#edit_modal_form" ).submit(function() {
                disableSumitButton(2);
            });

            $(".select2").select2();

		} );

    </script>
@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\AllMean;
        use App\Model\Marinecenter;

    ?>
@endsection

@section('header')
    <?php
        $headerName = "References";
        $iconFileName = "icon_dashboard_manager/word_in_system.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('/');
        $breadcump['Refereneces'] = url('referenceLoan');
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
			<th class="th-padding-left">Marine Center</th>
			<th class="th-padding-left">Reference Code</th>
			<th class="th-padding-left">Wording EN</th>
			<th class="th-padding-left">Wording TH</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;?>
		@foreach($references as $reference)
		<tr @if( $reference->status == 1 ) id="disable_data" @endif >
            <td>{{ $no }}</td>
                <td>{{ Marinecenter::getMarineCenter( $reference->marinecenter_id )->marinecenter_code }}</td>
            <td>{{ $reference->ref_code }}</td>
            <td>{{ $reference->name_en }}</td>
            <td>{{ $reference->name_th }}</td>
		</tr>
		<?php ++$no; ?>
		@endforeach
	</tbody>
</table>
</div>

@endsection
