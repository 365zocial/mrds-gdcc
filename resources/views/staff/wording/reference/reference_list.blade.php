@extends('layouts.app')

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

        function editModal() {
			$(document.body).on('click', '#edit_button', function(){
				$.ajax({
					url: "<?php echo url('staff/wording/getReference'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						reference_id: $(this).data('id')
					},
					success: function( data ) {
                        // console.log(data);
                        $('#edit_reference_code').val(data.reference.ref_code);
						$('#edit_reference_en').val(data.reference.name_en);
                        $('#edit_reference_th').val(data.reference.name_th);
						$('#hidden_wording_id').children().val(data.reference.id);

                        if(data.reference.status == 2){
                            // $('#status_swtich').attr('checked','checked');
                            $('#status_swtich').parent().removeClass('off');
                        }else{
                            $('#status_swtich').parent().addClass('off');
                            $('#status_swtich').removeAttr('checked');
                        }
					}
				});
			});
		}

        function disableSumitButton(way){
            if( way == 1 )  //submit
                $("#submit_button").prop('disabled', true);
            else
                $("#submit_button_edit").prop('disabled', true);
        }
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
        $headerName = "Word in System";
        $iconFileName = "icon_dashboard_manager/word_in_system.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Word in System'] = url('staff/mainWording');
        $breadcump['Reference'] = url('staff/wording/referenceList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Reference";
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_reference_modal';
    ?>
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
			<th class="th-padding-left">Status</th>
			<th class="th-padding-left" style="text-align: center;">Action</th>
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
	    <td>{{ AllMean::ConvertStatusName($reference->status) }}</td>
	    <td class="tools" style="text-align: center;">
				<a href="#" id="edit_button" data-id="{{ $reference->id }}"  data-toggle="modal" data-target="#edit_reference_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
			</td>
		</tr>
		<?php ++$no; ?>
		@endforeach
	</tbody>
</table>
</div>

<!-- Model: Add reference Part -->
<div class="modal fade" id="add_reference_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Reference</h4>
			</div>
			<form action="{{ url('staff/wording/addReference') }}" method="post" id="add_modal_form">
				@csrf

				<div class="modal-body">

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Marine Center</p>
                            <select class="form-control search-report-select select2" id="marinecenter" name="marinecenter" required>
                            @if( count($marinecenters) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach ( $marinecenters as $marinecenter )
                                    <option value="{{ $marinecenter->id }}">{{ $marinecenter->marinecenter }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                            </select>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Reference Code</p>
                            <input type="text" class="form-control" id="add_reference_code" name="add_reference_code" maxlength="255" placeholder="Code" required>
                        </div>
                    </div>

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">English Name</p>
                            <input type="text" class="form-control" id="add_reference_en" name="add_reference_en" placeholder="Wording English" required>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Thai Name</p>
                            <input type="text" class="form-control" id="add_reference_th" name="add_reference_th" placeholder="Wording Thai" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 search-report-button modal-button">
                            <button type="button" class="btn btn-default btn-gold btn-gray" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-default btn-gold btn-right" id="submit_button" style="">Save</button>
                        </div>
                    </div>

				</div>

			</form>
		</div>
	</div>
</div>

<!-- Model: Edit reference Part -->
<div class="modal fade" id="edit_reference_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Reference</h4>
			</div>
			<form action="{{ url('staff/wording/editReference') }}" method="post" id="edit_modal_form">
				@csrf
				<div id="hidden_wording_id"><input type="hidden" name="reference_id" value=""></div>

				<div class="modal-body">

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Status</p>
                            <input id="status_swtich" class="status_switching" name="status_switch" type="checkbox" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" checked>
                        </div>
                    </div>

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">English Name</p>
                            <input type="text" class="form-control" id="edit_reference_en" name="edit_reference_en" placeholder="Wording English" required>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Thai Name</p>
                            <input type="text" class="form-control" id="edit_reference_th" name="edit_reference_th" placeholder="Wording Thai" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 search-report-button modal-button">
                            <button type="button" class="btn btn-default btn-gold btn-gray" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-default btn-gold btn-right" id="submit_button_edit" style="">Save</button>
                        </div>
                    </div>

				</div>

			</form>
		</div>
	</div>
</div>

@endsection
