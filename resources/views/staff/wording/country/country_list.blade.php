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
	    	$('#add_modal_form').parsley();
            $("#add_country_en").attr("required", "true");
	    	$("#add_country_th").attr("required", "true");

            $('#edit_modal_form').parsley();
            $("#edit_country_en").attr("required", "true");
	    	$("#edit_country_th").attr("required", "true");

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
					url: "<?php echo url('staff/wording/getCountryWording'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						country_wording_id: $(this).data('id')
					},
					success: function( data ) {

						$('#edit_country_en').val(data.country.country_en);
                        $('#edit_country_th').val(data.country.country_th);
						$('#hidden_wording_id').children().val(data.country.id);

                        if(data.country.status == 2){
                            $('#status_swtich').attr('checked','checked');
                            $('#status_swtich').parent().removeClass('off');
                        }else{
                            $('#status_swtich').parent().addClass('off');
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
        $breadcump['Country'] = url('staff/wording/countryList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Country";
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_country_modal';
    ?>
@endsection

@section('contain')

@include('alert')

<div class="container-infuild">
<table id="result" class="display" cellspacing="0">
	<thead>
		<tr>
			<th class="th-padding-left">No.</th>
			<th class="th-padding-left">Wording EN</th>
			<th class="th-padding-left">Wording TH</th>
			<th class="th-padding-left">Status</th>
			<th class="th-padding-left" style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php $no = 1;?>
	@foreach($countrys as $country)
		<tr @if( $country->status == 1 ) id="disable_data" @endif >
			<td> {{ $no }} </td>
			<td> {{ $country->country_en }} </td>
			<td> {{ $country->country_th }} </td>
			<td> {{ AllMean::ConvertStatusName($country->status) }} </td>
			<td class="tools" style="text-align: center;">
				<a href="#" id="edit_button" data-id="{{ $country->id }}"  data-toggle="modal" data-target="#edit_country_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
			</td>
		</tr>
	<?php ++$no; ?>
	@endforeach
	</tbody>
</table>
</div>

<!-- Model: Add Country Part -->
<div class="modal fade" id="add_country_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Country</h4>
			</div>
			<form action="{{ url('staff/wording/addCountry') }}" method="post" id="add_modal_form">
				@csrf

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">English Name</p>
                <input type="text" class="form-control" id="add_country_en" name="add_country_en" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Thai Name</p>
                <input type="text" class="form-control" id="add_country_th" name="add_country_th" maxlength="255" placeholder="Wording Thai" required>
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
<div class="modal fade" id="edit_country_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Country</h4>
			</div>
			<form action="{{ url('staff/wording/editCountry') }}" method="post" id="edit_modal_form">
				@csrf
				<div id="hidden_wording_id"><input type="hidden" name="country_wording_id" value=""></div>

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Status</p>
                <input id="status_swtich" class="status_switching" name="status_switch" type="checkbox" data-statuscountryid="{{ $country->id }}" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if( $country->status == 2 ) checked @endif >
            </div>
          </div>

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">English Name</p>
                <input type="text" class="form-control" id="edit_country_en" name="edit_country_en" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Thai Name</p>
                <input type="text" class="form-control" id="edit_country_th" name="edit_country_th" maxlength="255" placeholder="Wording Thai" required>
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
