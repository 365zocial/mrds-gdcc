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
            $('#add_modal_form').parsley();
            $("#add_district_county").attr("required", "true");
            $("#add_district_county").attr("data-parsley-focus", "first");
            $("#add_county_code").attr("required", "true");
            $("#add_county_en").attr("required", "true");
            $("#add_county_th").attr("required", "true");

            $('#edit_modal_form').parsley();
            $("#edit_district_county").attr("required", "true");
            $("#edit_district_county").attr("data-parsley-focus", "first");
            $("#edit_county_code").attr("required", "true");
            $("#edit_county_en").attr("required", "true");
            $("#edit_county_th").attr("required", "true");

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
					url: "<?php echo url('staff/wording/getCountyWording'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						county_wording_id: $(this).data('id')
					},
					success: function( data ) {
                        // console.log(data);
                        $('#edit_district_county')
                            .prepend( $('<option id="selectedOpt"></option>')
                                .attr('value', data.county.district_id)
                                .attr('selected', 'selected')
                                .text(data.districts.district_en+" / "+data.districts.district_th)
                            );

						$('#edit_county_en').val(data.county.county_en);
                        $('#edit_county_th').val(data.county.county_th);
						$('#hidden_wording_id').children().val(data.county.id);

                        if(data.county.status == 2){
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

        $(function() {
            $('#result1').DataTable({
                order: [1, 'desc'],
                // bFilter: true,
                // bLengthChange: true,
                // "paging": true,
                // pagingType: "full_numbers",
                processing: true,
                serverSide: true,
                ajax: '{!! route('list.county.datatable') !!}',
                columns: [
                    { data: 'DT_Row_Index', orderable: false, searchable: false },                    
                    { data: 'id', name: 'id'},                    
                    { data: 'county_en', name: 'county_en' },
                    { data: 'county_th', name: 'county_th' },
                    { data: 'status', name: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                "columnDefs": [
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                }
            ],
            });
        });

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
        $breadcump['County'] = url('staff/wording/countyList');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add County";
        $button['link'] = '';
        $button['tag'] = 'data-toggle=modal data-target=#add_county_modal';
    ?>
@endsection

@section('contain')

@include('alert')

<!-- Categories Part -->
<div class="container-infuild">
<table id="result1" class="display" cellspacing="0">
	<thead>
		<tr>
			<th>No.</th>
			<th class="th-padding-left">Wording EN</th>
			<th class="th-padding-left">ID</th>
			<th class="th-padding-left">Wording TH</th>
			<th class="th-padding-left">Status</th>
			<th class="th-padding-left" style="text-align: center;">Action</th>
		</tr>
	</thead>
</table>
</div>

<!-- Model: Add County Part -->
<div class="modal fade" id="add_county_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add County</h4>
			</div>

			<form action="{{ url('staff/wording/addCounty') }}" method="post" id="add_modal_form">
				@csrf

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">District</p>
                <select class="form-control search-report-select select2" id="add_district_county" name="add_district_county" required>
                @if( count($districts) !== 0 )
                    <option value="" selected disabled>Select</option>
                    @foreach ( $districts as $district )
                        <option value="{{ $district->id }}">{{ $district->district_en }} / {{ $district->district_th }}</option>
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
                <input type="text" class="form-control" id="add_county_en" name="add_county_en" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Thai Name</p>
                <input type="text" class="form-control" id="add_county_th" name="add_county_th" maxlength="255" placeholder="Wording Thai" required>
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

<!-- Model: Edit County Part -->
<div class="modal fade" id="edit_county_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit County </h4>
			</div>

			<form action="{{ url('staff/wording/editCounty') }}" method="post" id="edit_modal_form">
				@csrf
				<div id="hidden_wording_id"><input type="hidden" name="county_wording_id" value=""></div>

				<div class="modal-body">

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Status</p>
                <input id="status_swtich" name="status_switch" class="status_switching" type="checkbox" data-statusid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" checked>
            </div>
          </div>

					<div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">District</p>
                <select class="form-control search-report-select select2" id="edit_district_county" name="edit_district_county" required>
                @if( count($districts) !== 0 )
                    <option value="" selected disabled>Select</option>
                    @foreach ( $districts as $district )
                        <option value="{{ $district->id }}">{{ $district->district_en }} / {{ $district->district_th }}</option>
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
                <input type="text" class="form-control" id="edit_county_en" name="edit_county_en" maxlength="255" placeholder="Wording English" required>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-12">
                <p class="search-report-dropdown-header">Thai Name</p>
                <input type="text" class="form-control" id="edit_county_th" name="edit_county_th" maxlength="255" placeholder="Wording Thai" required>
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
