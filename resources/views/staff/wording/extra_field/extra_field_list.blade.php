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
            $('#edit_modal_form').parsley();
            $("#edit_extra_field_name").attr("required", "true");

            editModal();

            $(".select2").select2();

		} );

        function editModal() {
			$(document.body).on('click', '#edit_button', function(){
				$.ajax({
					url: "<?php echo url('staff/wording/getExtraField'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						extra_field_id: $(this).data('id')
					},
					success: function( data ) {
                        $('#edit_extra_field_name').val(data.extra_field.name);
						$('#hidden_extra_field_id').children().val(data.extra_field.id);

                        if(data.extra_field.status == 2){
                            $('#status_swtich').attr('checked','checked');
                            $('#status_swtich').parent().removeClass('off');
                        }else{
                            $('#status_swtich').parent().addClass('off');
                        }
					}
				});
			});
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
        $breadcump['Extra Field'] = url('staff/wording/extraFieldList');
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
    			<th class="th-padding-left">Extra Field Name</th>
                <th class="th-padding-left">Status</th>
    			<th class="th-padding-left" style="text-align: center;">Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach( $extra_fields as $extra_field )
                <tr @if( $extra_field->status == 1 ) id="disable_data" @endif>
                    <td>{{ $extra_field->id }}</td>
            	    <td>{{ $extra_field->name }}</td>
                    <td> {{ AllMean::ConvertStatusName($extra_field->status) }} </td>
            	    <td class="tools" style="text-align: center;">
        				<a href="#" id="edit_button" data-id="{{ $extra_field->id }}"  data-toggle="modal" data-target="#edit_extra_field_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
        			</td>
        		</tr>
    		@endforeach
    	</tbody>
    </table>
</div>

<!-- Model: Edit reference Part -->
<div class="modal fade" id="edit_extra_field_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Extra Field Name</h4>
			</div>
			<form action="{{ url('staff/wording/editExtraField') }}" method="post" id="edit_modal_form">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div id="hidden_extra_field_id"><input type="hidden" name="hidden_extra_field_id" value=""></div>

				<div class="modal-body">

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Status</p>
                            <input id="status_swtich" class="status_switching" name="status_switch" type="checkbox" data-statusextrafieldid="{{ $extra_field->id }}" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if( $extra_field->status == 2 ) checked @endif >
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Extra Field Name</p>
                            <input type="text" class="form-control" id="edit_extra_field_name" name="edit_extra_field_name" placeholder="Extra Field Name" required>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12 search-report-button modal-button">
                          <button type="button" class="btn btn-default btn-gold btn-gray" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-default btn-gold btn-right" style="">Save</button>
                      </div>
                    </div>

				</div>

			</form>
		</div>
	</div>
</div>

@endsection
