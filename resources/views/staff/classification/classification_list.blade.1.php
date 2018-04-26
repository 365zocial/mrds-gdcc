@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
      input[type="search"] {
        width: 300px !important;
      }
      #disable_data {
          color: red;
      }
    </style>
@endsection

@section('script')
	@include('base_wording_js')
    <script type="text/javascript">
		$(document).ready(function() {

      $('input[type="search"]').attr('placeholder', 'Scientific Name...');

            /* parsley */
            $('#add_modal_form').parsley();
            $("#add_province_district").attr("required", "true");
            $("#add_province_district").attr("data-parsley-focus", "first");
            $("#add_district_code").attr("required", "true");
            $("#add_district_en").attr("required", "true");
            $("#add_district_th").attr("required", "true");

            $('#edit_modal_form').parsley();
            $("#edit_province_district").attr("required", "true");
            $("#edit_province_district").attr("data-parsley-focus", "first");
            $("#edit_district_code").attr("required", "true");
            $("#edit_district_en").attr("required", "true");
            $("#edit_district_th").attr("required", "true");


            $('.loader').show();
            window.setTimeout(function(){
                $('.loader').fadeOut(750);
            },3500);


            editModal();

		} );

        function editModal() {
			$(document.body).on('click', '#edit_button', function(){
				$.ajax({
					url: "<?php echo url('staff/wording/getDistrictWording'); ?>",
					method: "post",
					data: {
                        _token: "{{ csrf_token() }}",
						'district_wording_id': $(this).data('id')
					},
					success: function( data ) {

                        $('#edit_province_district').prepend( $('<option></option>').attr('value', data.district.province_code).attr('selected', 'selected').text(data.province.province_en));

						$('#edit_district_en').val(data.district.district_en);
                        $('#edit_district_th').val(data.district.district_th);
                        $('#edit_district_code').val(data.district.district_code);
						$('#hidden_wording_id').children().val(data.district.id);

                        if(data.district.status == 2){
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
    ?>
@endsection

@section('header')
    <?php
        $headerName = "Manage Classification";
        $iconFileName = "icon_dashboard_manager/manage_classification.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage Classification'] = url('staff/manageClassification');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Classification";
        $button['link'] = url('staff/checkClassificationForm');
    ?>
@endsection

@section('contain')

@include('alert')

<table id="result" class="display" cellspacing="0">
  <thead>
    <tr>
      <th>No.</th>
      <th class="th-padding-left">Scientific Name</th>
      <th class="th-padding-left">Status</th>
      <th class="th-padding-left" style="text-align:center; width: 150px;">Action</th>
    </tr>
  </thead>
<tbody>
  <?php $no = 1;?>
  @foreach($classifications as $classification)
    <tr @if( $classification->status == 1 ) id="disable_data" @endif >
      <td> {{ $no }} </td>
      <td> {!! $classification->current_scientific_name_format !!} </td>
      <td> {{ AllMean::ConvertStatusName($classification->status) }} </td>
      <td class="tools" style="text-align:center;">
        <a href="{{ url('staff/viewClassification', base64_encode( base64_encode( base64_encode( $classification->id ))) ) }}">
        <span class="glyphicon glyphicon-eye-open"></span> View
        </a>
        <span class="between-tools"> | </span>
        <a href="{{ url('staff/editClassificationForm' , [$classification->id]) }}" id="edit_button">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
        </a>
      </td>
    </tr>
  <?php ++$no; ?>
  @endforeach
</tbody>
</table>

@endsection
