@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        #disable_data {
            color: red;
        }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">
		$(document).ready(function() {

			/* parsley */
	    	$('#add_taxonomy_modal_form').parsley();
	    	$("#hearder_taxonomy").attr("required", "true");
			$("#hearder_taxonomy").attr("data-parsley-focus", "first");
			$("#taxonomy").attr("required", "true");
			$("#taxonomy").attr("data-parsley-focus", "first");

            editModal();

            $( "#add_wording_modal_form" ).submit(function() {
                disableSumitButton(1);
            });

            $( "#edit_wording_modal_form" ).submit(function() {
                disableSumitButton(2);
            });
		} );

        function editModal() {
			$(document.body).on('click', '#edit_button', function(){
				$.ajax({
					url: "<?php echo url('staff/wording/getWording'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						wording_id: $(this).data('id')
					},
					success: function( data ) {
						$('#edit_wording_en').val(data.wording.name_en);
                        $('#edit_wording_th').val(data.wording.name_th);
						$('#hidden_wording_id').children().val(data.wording.id);

                        if(data.wording.status == 2){
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
        $breadcump[ucwords( str_replace("_", " ", $name_wording_type ) )] = url('staff/wording/wordingList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add ".ucwords( str_replace("_", " ", $name_wording_type ) );
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_wording_modal';
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
			<th class="th-padding-left">Wording EN</th>
			<th class="th-padding-left">Wording TH</th>
			<th class="th-padding-left">Status</th>
			<th class="th-padding-left" style="text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;?>
		@foreach($wordings as $wording)
		<tr @if( $wording->status == 1 ) id="disable_data" @endif >
			<td>{{ $no }}</td>
			<td>{{ $wording->name_en }}</td>
			<td>{{ $wording->name_th }}</td>
			<td>{{ AllMean::ConvertStatusName($wording->status) }}</td>
			<td class="tools" style="text-align:center;">
				<a href="#" id="edit_button" data-id="{{ $wording->id }}"  data-toggle="modal" data-target="#edit_wording_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
			</td>
		</tr>
		<?php ++$no; ?>
		@endforeach
	</tbody>
</table>
</div>

<!-- Model: Add Country Part -->
<div class="modal fade" id="add_wording_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Wording</h4>
			</div>

			<form action="{{ url('staff/wording/addWording') }}" method="post" id="add_wording_modal_form">
				<input type="hidden" name="wording_type" value="{{ $wordings_type_id->id }}">
                <input type="hidden" name="name_wording_type" value="{{ $name_wording_type }}">
				@csrf

				<div class="modal-body">

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">English Name</p>
                            <input type="text" class="form-control" id="add_wording_en" name="add_wording_en" maxlength="255" placeholder="Wording English" required>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Thai Name</p>
                            <input type="text" class="form-control" id="add_wording_th" name="add_wording_th" maxlength="255" placeholder="Wording Thai" required>
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

<!-- Model: Edit Country Part -->
<div class="modal fade" id="edit_wording_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Wording</h4>
			</div>

			<form action="{{ url('staff/wording/editWording') }}" method="post" id="edit_wording_modal_form">
				<div id="hidden_wording_id"><input type="hidden" name="wording_wording_id" value=""></div>
				<input type="hidden" name="wording_type" value="{{ $wordings_type_id->id }}">
                <input type="hidden" name="name_wording_type" value="{{ $name_wording_type }}">
                @csrf

				<div class="modal-body">

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Status</p>
                            <input id="status_swtich" name="status_switch" class="status_switching" type="checkbox" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" checked>
                        </div>
                    </div>

                                <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">English Name</p>
                            <input type="text" class="form-control" id="edit_wording_en" name="edit_wording_en" maxlength="255" placeholder="Wording English" required>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Thai Name</p>
                            <input type="text" class="form-control" id="edit_wording_th" name="edit_wording_th" maxlength="255" placeholder="Wording Thai" required>
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
