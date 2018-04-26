@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
    <style media="screen">
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
	    	$('#add_taxonomy_modal_form').parsley();
	    	$("#header_taxonomy").attr("required", "true");
			$("#header_taxonomy").attr("data-parsley-focus", "first");
			$("#taxonomy").attr("required", "true");
			$("#taxonomy").attr("data-parsley-focus", "first");

            $('#edit_taxonomy_modal_form').parsley();
            $("#edit_header_taxonomy").attr("required", "true");
            $("#edit_header_taxonomy").attr("data-parsley-focus", "first");
            $("#edit_taxonomy").attr("required", "true");
            $("#edit_taxonomy").attr("data-parsley-focus", "first");

			editModal();

            $( "#add_taxonomy_modal_form" ).submit(function() {
                disableSumitButton(1);
            });

            $( "#edit_taxonomy_modal_form" ).submit(function() {
                disableSumitButton(2);
            });

            $(".select2").select2();

		} );


		function editModal() {
			$(document.body).on('click', '#edit_button', function(){
				$.ajax({
					url: "<?php echo url('staff/wording/getTaxonomyWording'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						taxonomy_wording_id: $(this).data('id')
					},
					success: function( data ) {
						$('#edit_header_taxonomy').prepend( $('<option></option>').attr('value', data.taxonomy.header_taxonomy_id).attr('selected', 'selected').text(data.header_taxonomy));

						taxonomy = '<input type="text" class="form-control" id="edit_taxonomy" name="edit_taxonomy" maxlength="255" placeholder="Wording" value="'+ data.taxonomy.name +'" required>';
						$('#old_taxonomy').html(taxonomy);

						hidden_taxonomy_wording_id = '<input type="hidden" name="taxonomy_wording_id" value="'+ data.taxonomy.id +'">';
						$('#hidden_wording_id').html(hidden_taxonomy_wording_id);

                        if(data.taxonomy.status == 2){
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
        use App\Model\Header_Taxonomy;
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
        $breadcump['Taxonomy'] = url('staff/wording/taxonomyList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Taxonomy";
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_taxonomy_modal';
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
				<th class="th-padding-left">Wording</th>
				<th class="th-padding-left">Taxonomy</th>
				<th class="th-padding-left">Status</th>
				<th class="th-padding-left" style="text-align: center;">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;?>
			@foreach($taxonomys as $taxonomy)
				<tr @if( $taxonomy->status == 1 ) id="disable_data" @endif >
					<td>{{ $no }}</td>
					<td>{{ $taxonomy->name }}</td>
					<td>{{ Header_Taxonomy::getHeaderTaxonomy($taxonomy->header_taxonomy_id) }}</td>
					<td>{{ AllMean::ConvertStatusName($taxonomy->status) }}</td>
					<td class="tools" style="text-align: center;">
						<a href="#" id="edit_button" data-id="{{ $taxonomy->id }}"  data-toggle="modal" data-target="#edit_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
					</td>
				</tr>
			<?php ++$no;?>
			@endforeach
		</tbody>
	</table> <!-- /.table -->
</div> <!-- /.row -->

<!-- Model: Add Taxonomy Part -->
<div class="modal fade" id="add_taxonomy_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Add Taxonomy</h4>
			</div>

			<form action="{{ url('staff/wording/addTaxonomy') }}" method="post" id="add_taxonomy_modal_form">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Taxonomy Type</p>
                <select class="form-control search-report-select select2" id="add_header_taxonomy" name="add_header_taxonomy" required>
                @if( count($header_taxonomys) !== 0 )
                    <option value="" selected disabled>Select</option>
                    @foreach ( $header_taxonomys as $header_taxonomy )
                        <option value="{{ $header_taxonomy->id }}">{{ $header_taxonomy->name }}</option>
                    @endforeach
                @else
                    <option value="" selected>No list in select</option>
                @endif
                </select>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Taxonomy Name</p>
                <input type="text" class="form-control" id="add_taxonomy" name="add_taxonomy" maxlength="255" placeholder="Wording" required>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12 search-report-button" style="text-align: right; margin-top: 15px;">
                  <button type="button" class="btn btn-default btn-gold btn-gray" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default btn-gold" id="submit_button" style="margin-left: 10px;">Save</button>
              </div>
          </div>

				</div>

			</form>
		</div>
	</div>
</div>

<!-- Model: Edit Taxonomy Part -->
<div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Taxonomy</h4>
			</div>
			<form action="{{ url('staff/wording/editTaxonomy') }}" method="post" id="edit_taxonomy_modal_form">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div id="hidden_wording_id"></div>

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Status</p>
                <input id="status_swtich" name="status_switch" class="status_switching" type="checkbox" data-statustaxonomyid="{{ $taxonomy->id }}" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" checked>
            </div>
          </div>

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Taxonomy Type</p>
                <select class="form-control search-report-select select2" id="edit_header_taxonomy" name="edit_header_taxonomy" required>
                @if( count($header_taxonomys) !== 0 )
                    <option value="" selected disabled>Select</option>
                    @foreach ( $header_taxonomys as $header_taxonomy )
                        <option value="{{ $header_taxonomy->id }}">{{ $header_taxonomy->name }}</option>
                    @endforeach
                @else
                    <option value="" selected>No list in select</option>
                @endif
                </select>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Taxonomy Name</p>
                <div id="old_taxonomy"></div>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12 search-report-button" style="text-align: right; margin-top: 15px;">
                  <button type="button" class="btn btn-default btn-gold btn-gray" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-default btn-gold" id="submit_button_edit" style="margin-left: 10px;">Save</button>
              </div>
          </div>

				</div>
			</form>
		</div>
	</div>
</div>
@endsection
