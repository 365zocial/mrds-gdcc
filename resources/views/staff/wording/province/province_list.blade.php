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
            $("#add_country_province").attr("required", "true");
            $("#add_country_province").attr("data-parsley-focus", "first");
            $("#add_province_code").attr("required", "true");
            $("#add_province_en").attr("required", "true");
            $("#add_province_th").attr("required", "true");

            $('#edit_modal_form').parsley();
            $("#edit_country_province").attr("required", "true");
            $("#edit_country_province").attr("data-parsley-focus", "first");
            $("#edit_province_code").attr("required", "true");
            $("#edit_province_en").attr("required", "true");
            $("#edit_province_th").attr("required", "true");

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
                $('#selectedOpt').remove();
				$.ajax({
					url: "<?php echo url('staff/wording/getProvinceWording'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						province_wording_id: $(this).data('id')
					},
					success: function( data ) {
                        $('#edit_country_province')
                            .prepend( $('<option id="selectedOpt"></option>')
                                .attr('value', data.province.country_id)
                                .attr('selected', 'selected').text(data.country.country_en+" / "+data.country.country_th)
                            );

						$('#edit_province_en').val(data.province.province_en);
                        $('#edit_province_th').val(data.province.province_th);
                        $('#edit_province_code').val(data.province.province_code);
						$('#hidden_wording_id').children().val(data.province.id);

                        if(data.province.status == 2){
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
        $breadcump['Province'] = url('staff/wording/provinceList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Province";
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_province_modal';
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
			<th class="th-padding-left" style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;?>
		@foreach($provinces as $province)
		<tr @if( $province->status == 1 ) id="disable_data" @endif >
			<td>{{ $no }}</td>
			<td>{{ $province->province_en }}</td>
			<td>{{ $province->province_th }}</td>
			<td>{{ AllMean::ConvertStatusName($province->status) }}</td>
			<td class="tools" style="text-align: center;">
				<a href="#" id="edit_button" data-id="{{ $province->id }}"  data-toggle="modal" data-target="#edit_province_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
			</td>
		</tr>
		<?php ++$no; ?>
		@endforeach
	</tbody>
</table> <!-- /.table -->
</div> <!-- /.row -->


<!-- Model: Add province Part -->
<div class="modal fade" id="add_province_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Province</h4>
			</div>

			<form action="{{ url('staff/wording/addProvince') }}" method="post" id="add_modal_form">
				@csrf

				<div class="modal-body">

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Country</p>
                            <select class="form-control search-report-select select2" id="add_country_province" name="add_country_province" required>
                            @if( count($countrys) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach ( $countrys as $country )
                                    <option value="{{ $country->id }}">{{ $country->country_en }} / {{ $country->country_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                            </select>
                        </div>
                    </div>

					<div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">English Name</p>
                            <input type="text" class="form-control" id="add_province_en" name="add_province_en" maxlength="255" placeholder="Wording English" required>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Thai Name</p>
                            <input type="text" class="form-control" id="add_province_th" name="add_province_th" maxlength="255" placeholder="Wording Thai" required>
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

<!-- Model: Edit province Part -->
<div class="modal fade" id="edit_province_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Province</h4>
			</div>

            <form action="{{ url('staff/wording/editProvince') }}" method="post" id="edit_modal_form">
                @csrf
                <div id="hidden_wording_id"><input type="hidden" name="province_wording_id" value=""></div>

                <div class="modal-body">

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Status</p>
                            <input id="status_swtich" name="status_switch" class="status_switching" type="checkbox" data-statusid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" checked>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Country</p>
                            <select class="form-control search-report-select select2" id="edit_country_province" name="add_country_province" required>
                                @if( count($countrys) !== 0 )
                                    <option value="" selected disabled>Select</option>
                                @foreach ( $countrys as $country )
                                    <option value="{{ $country->id }}">{{ $country->country_en }} / {{ $country->country_th }}</option>
                                @endforeach
                                @else
                                    <option value="" selected>No list in select</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">English Name</p>
                            <input type="text" class="form-control" id="edit_province_en" name="edit_province_en" maxlength="255" placeholder="Wording English" required>
                        </div>
                    </div>

                    <div class="row row-inform">
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Thai Name</p>
                            <input type="text" class="form-control" id="edit_province_th" name="edit_province_th" maxlength="255" placeholder="Wording Thai" required>
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
