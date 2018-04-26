@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style>
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
	    	$('#add_modal_form').parsley();
            $("#add_collection_en").attr("required", "true");
	    	$("#add_collection_th").attr("required", "true");

            $('#edit_modal_form').parsley();
            $("#edit_collection_en").attr("required", "true");
	    	$("#edit_collection_th").attr("required", "true");

            editModal();

            $( "#add_modal_form" ).submit(function() {
                disableSumitButton(1);
            });

            $( "#edit_modal_form" ).submit(function() {
                disableSumitButton(2);
            });

		} );

        function editModal() {
			$(document.body).on('click', '#edit_button', function(){
				$.ajax({
					url: "<?php echo url('staff/wording/getCollection'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						collection_id: $(this).data('id')
					},
					success: function( data ) {
                        // console.log(data);
                        $('#edit_collection_code').val(data.collection.col_code);
						$('#edit_collection_en').val(data.collection.name_en);
                        $('#edit_collection_th').val(data.collection.name_th);
						$('#hidden_wording_id').children().val(data.collection.id);

                        if(data.collection.status == 2){
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
        $breadcump['Collection'] = url('staff/wording/collectionList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Collection";
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_collection_modal';
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
			<th class="th-padding-left">Collection Code</th>
			<th class="th-padding-left">Wording EN</th>
			<th class="th-padding-left">Wording TH</th>
			<th class="th-padding-left">Status</th>
			<th class="th-padding-left" style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php $no = 1;?>
	@foreach($collections as $collection)
		<tr @if( $collection->status == 1 ) id="disable_data" @endif >
			<td>{{ $no }}</td>
			<td>{{ $collection->col_code }}</td>
			<td>{{ $collection->name_en }}</td>
			<td>{{ $collection->name_th }}</td>
			<td>{{ AllMean::ConvertStatusName($collection->status) }} </td>
			<td class="tools" style="text-align: center;">
				<a href="#" id="edit_button" data-id="{{ $collection->id }}"  data-toggle="modal" data-target="#edit_collection_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
			</td>
		</tr>
	<?php ++$no; ?>
	@endforeach
	</tbody>
</table> <!-- /.table -->
</div> <!-- /.row -->

<!-- Model: Add collection Part -->
<div class="modal fade" id="add_collection_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Collection</h4>
			</div>

			<form action="{{ url('staff/wording/addCollection') }}" method="post" id="add_modal_form">
				@csrf

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Collection Code</p>
                <input type="text" class="form-control" id="add_collection_code" name="add_collection_code" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">English Name</p>
                <input type="text" class="form-control" id="add_collection_en" name="add_collection_en" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Thai Name</p>
                <input type="text" class="form-control" id="add_collection_th" name="add_collection_th" maxlength="255" placeholder="Wording Thai" required>
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

<!-- Model: Edit collection Part -->
<div class="modal fade" id="edit_collection_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Collection</h4>
			</div>

			<form action="{{ url('staff/wording/editCollection') }}" method="post" id="edit_modal_form">
				@csrf
				<div id="hidden_wording_id"><input type="hidden" name="collection_id" value=""></div>
				<!-- <input type="hidden" name="edit_collection_code" value=""> -->

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
                <input type="text" class="form-control" id="edit_collection_en" name="edit_collection_en" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Thai Name</p>
                <input type="text" class="form-control" id="edit_collection_th" name="edit_collection_th" maxlength="255" placeholder="Wording Thai" required>
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
