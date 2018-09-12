@extends('layouts.app')

@section('css')
    @include('base_wording_css')

    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
    <style media="screen">
        input.date_picker_search.form-control {
            border: 1px solid #cbcbcb;
            border-right: none;
            background-color: transparent !important;
        }
    </style>
@endsection

@section('script')
  @include('base_wording_js')
	<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
  <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>

    <script type="text/javascript">
        $(document).ready(function() {

        	/* parsley */
        $('#form').parsley();
        $("#marine_center").attr("required", "true");
    		$("#marine_center").attr("data-parsley-focus", "first");
        $("#collection_code").attr("required", "true");
    		$("#collection_code").attr("data-parsley-focus", "first");
        $("#country").attr("required", "true");
    		$("#country").attr("data-parsley-focus", "first");

            $('#collected_date').datepicker({
                format: 'dd-mm-yyyy',
                clearBtn: true,
            });
            $('#cur_identified_date').datepicker({
                format: 'dd-mm-yyyy',
                clearBtn: true,
            });
            $('#prev_identified_date').datepicker({
                format: 'dd-mm-yyyy',
                clearBtn: true,
            });
    		// chooseSpecimenOrPublication();

            // $('#status_swtich').change(function(){
                // $('.loader').show();
                // if($(this).is(':checked')){
                //     $.post("{{ url('staff/changeStatus') }}",{ id_en:{{ $record->id }}, status: 2 });
                // }else{
                //     $.post("{{ url('staff/changeStatus') }}",{ id_en:{{ $record->id }}, status: 1 });
                // }
                // setTimeout(function () {
                //     window.location = "{{ url('staff/manageRecord') }}"; //will redirect to your blog page (an ex: blog.html)
                // }, 1500); //will call the function after 2 secs.
            // });

            init_location();

            // check_specimen_or_publication();

            $('#country').change(function(){
                $('#province').html("<option value='0' selected>Select</option>");
                $('#district').html("<option value='0' selected>Select</option>");
                $('#county').html("<option value='0' selected>Select</option>");

                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/wording/getProvinceInCountry'); ?>",
                    data: { _token: "{{ csrf_token() }}",id: $(this).val() }
                })
                .done(function( data ) {
                    var no = 0;
                    $.each(data, function(){
                        $('#province').append("<option value="+data[no].id+">"+data[no].province_en+"/"+data[no].province_th+"</option>")
                        no++;
                    });
                });
            });

            $('#province').change(function(){
                $('#district').html("<option value='0' selected>Select</option>");
                $('#county').html("<option value='0' selected>Select</option>");

                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/wording/getDistrictInProvince'); ?>",
                    data: { _token: "{{ csrf_token() }}",id: $(this).val() }
                })
                .done(function( data ) {
                    var no = 0;
                    $.each(data, function(){
                        // console.log(data[no].district_code);
                        $('#district').append("<option value="+data[no].id+">"+data[no].district_en+"/"+data[no].district_th+"</option>")
                        no++;
                    });
                });
            });

            $('#district').change(function(){
                $('#county').html("<option value='0' selected>Select</option>");
                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/wording/getCountyInDistrict'); ?>",
                    data: { _token: "{{ csrf_token() }}",id: $(this).val() }
                })
                .done(function( data ) {
                    var no = 0;
                    $.each(data, function(){
                        // console.log(data[no]);
                        $('#county').append("<option value="+data[no].id+">"+data[no].county_en+"/"+data[no].county_th+"</option>")
                        no++;
                    });
                });
            });

            $('#reference').change(function(){
                if($(this).val() != ""){
                    $('#page').removeAttr('disabled');
                }
            });

            $('#page').change(function(){
                if($(this).val() > 0){
                    $('#no_species').removeAttr('disabled');
                }else{
                    $('#no_species').attr('disabled',true);
                }
            });

        } );

        function init_location(){
            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/wording/getProvinceInCountry'); ?>",
                data: { _token: "{{ csrf_token() }}",id: $('#country').val() }
            })
            .done(function( data ) {
                var no = 0;
                $.each(data, function(){
                    $('#province').append("<option value="+data[no].id+">"+data[no].province_en+"</option>")
                    no++;
                });
            });
        }

        $(document).ready(function() {
          $(".select2").select2();
        });

        // set status record
        var x = 1;
        function setStatus(name_element){
            if(x != 1){
                x = 1;
                return false;
            }
            var element = $(name_element);
            if(!confirm("Confirm to change Group !")){
                x = x + 1;
                if( element.prop('checked') ){
                    element.off('change');
                    element.bootstrapToggle('toggle');
                    element.on('change');

                }else{
                    element.bootstrapToggle('toggle');
                }

            }else{
                var id      = element.data('id');
                var status  = "";
                if( element.prop('checked') ){
                    var status  = "on";
                }
                $('.loader').show();
                if( $(this).is(':checked') ) {
                    $.post("{{ url('staff/changeStatus') }}",{ _token : '{{ csrf_token() }}' ,id_en: '{{ $record->id }}', status: 2 });
                } else {
                    $.post("{{ url('staff/changeStatus') }}",{ _token : '{{ csrf_token() }}' ,id_en: '{{ $record->id }}', status: 1 });
                }
                setTimeout( function () {
                    window.location = "{{ url('staff/manageRecord') }}"; //will redirect to your blog page (an ex: blog.html)
                }, 1500); //will call the function after 2 secs.
            }
        }

    </script>
@endsection

@section('header')
    <?php
        $headerName = "Manage Record";
        $iconFileName = "icon_dashboard_manager/manage_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard']     = url( 'staff/dashboard' );
        $breadcump['Manage Record'] = url( 'staff/manageRecord' );
        $breadcump['View Record']   = url( 'staff/viewRecord', base64_encode( base64_encode( base64_encode( $record->id ))) );
        $breadcump['Edit Record']   = url( 'staff/editRecordForm/1/'.base64_encode( base64_encode( base64_encode( $record->id ))), base64_encode( base64_encode( base64_encode( $record->id ))) );
    ?>
@endsection

@section('contain')
	<?php
    use App\Model\AllMean;
		use App\Model\Wording;
		use App\Model\Country;
		use App\Model\Province;
		use App\Model\District;
		use App\Model\County;

        $can_change_class = true;
	?>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_edit/edit_step1.png') }}" />
    </div>
</div>

<div class="row row-with-margin">
  <div class="col-md-8 col-md-offset-2">
    <div class="content-box">
        <p class="content-header">Edit Record</p>
        <p class="content-help-text">Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>

        @if( Auth::user()->role_id == 2 && $record->approve_status == 1 )
          <div class="enable-box">
            <p class="search-report-dropdown-header">Status</p>
            <input id="status_swtich" name="status_switch" class="status_switching" type="checkbox" onchange="setStatus('#status_swtich')" data-statusid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($record->status == 2){ {{ "checked" }} } @endif >
          </div>
        @endif

        @if( (Auth::user()->role_id == 3) && ($record->approve_status == 1) && (Auth::user()->marinecenter_id) == $record->marinecenter_id) )
          <div class="enable-box">
            <p class="search-report-dropdown-header">Status</p>
            <input id="status_swtich" name="status_switch" class="status_switching" type="checkbox" onchange="setStatus('#status_swtich')" data-statusid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($record->status == 2){ {{ "checked" }} } @endif >
          </div>
        @endif

        <form id="form" action="{{ url('staff/doEditRecordForm') }}" method="post">
          @csrf
          <input type="hidden" name="classification_id" value="{{ $classification->id }}">

          <p class="search-report-dropdown-header">Scientific Name and Description</p>
          @include('staff.record.scientific_name_description')

          <div class="row row-inform">
            <div class="col-md-12">
              <p class="record-label">Source:
                <span class="record-data">@if($record->source == 1){{ "Specimen" }}@elseif($record->source == 2){{ "Publication" }}@endif</span>
              </p>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Marine Center <span class="required">*Required</span></p>
              <input type="text" id="marine_center_show" class="form-control" name="marine_center_show" placeholder="{{ $marinecenter }}" readonly>
              <input type="hidden" id="marine_center" name="marine_center" value="{{ Auth::user()->marinecenter_id }}">
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Collection Code <span class="required">*Required</span></p>
              <select class="form-control search-report-select select2" id="collection_code" name="collection_code" required>
                  <option value="0" disabled selected>Select</option>
                  @foreach ( $collection_codes as $collection_code )
                      <option value="{{ $collection_code->id }}" @if( $collection_code->id == $record->collection_code ) {{ "selected" }} @endif>{{ $collection_code->name_en }}</option>
                  @endforeach
              </select>
            </div>
            @if($record->source == 1)
              <div class="col-md-4" id="specimen_part">
                <p class="search-report-dropdown-header" style="margin-bottom: 1px;">Catalog Number <span class="required">*Required</span></p>
                <input type="text" class="form-control" id="catalog_number" name="catalog_number" maxlength="10" placeholder="@if ( $record->catalog_number != null ) {{ $record->catalog_number }} @else Generate by System. @endif" readonly style="width: 80%; display: inline-block;"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style="font-size: 30px; color: #52d45c; top: 9px; left: 10px;"></span>
              </div>
            @endif
          </div>

          @if($record->source == 2)
          <div class="row row-inform">
            <div class="col-md-12" id="publication_part">
              <p class="search-report-dropdown-header">Reference</p>
              <input type="text" class="form-control" name="reference" placeholder="@if ( $references  != null ) {{ $references->ref_code }} / {{ substr($references->name_en , 0 , strpos( $references->name_en , ".", strpos( $references->name_en , ".") + strlen(".") ) ) }} @endif" readonly>
            </div>
          </div>
          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Page</p>
              <input type="text" class="form-control" name="page" placeholder="@if ( $record->page != null ) {{ $record->page }} @endif" readonly>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">No. Species</p>
              <input type="text" class="form-control" id="no_species" name="no_species" placeholder="@if ( $record->no_species != null ) {{ $record->no_species }} @endif" readonly>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">No. Locality</p>
              <input type="text" class="form-control" id="no_locality" name="no_locality" placeholder="@if ( $record->no_locality != null ) {{ $record->no_locality }} @endif" readonly>
            </div>
          </div>
          @endif

          <div class="row row-inform">
            <div class="col-md-6">
              <p class="search-report-dropdown-header">Variety Name</p>
              <input type="text" class="form-control" id="variety_name" name="variety_name" placeholder="Text Input" value="{{ $record->variety_name }}">
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-6">
              <p class="search-report-dropdown-header">Donated From</p>
              <select class="form-control search-report-select select2" id="donated_from" name="donated_from">
              @if( count($donated_froms) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($donated_froms as $donated_from)
                  <option value="{{ $donated_from->id }}" @if( $record->donated_from == $donated_from->id ){{ "selected" }}@endif >{{ $donated_from->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-6">
              <p class="search-report-dropdown-header">Deposited At</p>
              <select class="form-control search-report-select select2" id="deposited_at" name="deposited_at">
              @if( count($deposited_ats) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($deposited_ats as $deposited_at)
                  <option value="{{ $deposited_at->id }}" @if( $record->deposited_at == $deposited_at->id ){{ "selected" }}@endif >{{ $deposited_at->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Type Status</p>
              <select class="form-control search-report-select select2" id="type_status" name="type_status">
              @if( count($type_statuses) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($type_statuses as $type_status)
                  <option value="{{ $type_status->id }}" @if( $record->type_status == $type_status->id ){{ "selected" }}@endif >{{ $type_status->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-8">
              <p class="search-report-dropdown-header">Individual Count</p>
              <input type="text" class="form-control" id="individual_count" name="individual_count" placeholder="Text Input"  @if ( $record->individual_count != null ) value="{{ $record->individual_count }}" @endif >
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Sex</p>
              <select class="form-control search-report-select select2" id="sex" name="sex">
              @if( count($sexs) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($sexs as $sex)
                  <option value="{{ $sex->id }}" @if( $record->sex == $sex->id ){{ "selected" }}@endif >{{ $sex->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Size</p>
              <input type="text" class="form-control" id="size" name="size" placeholder="Text Input"  @if ( $record->size != null ) value="{{ $record->size }}" @endif>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Life Stage</p>
              <select class="form-control search-report-select select2" id="life_stage" name="life_stage">
              @if( count($life_stages) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($life_stages as $life_stage)
                  <option value="{{ $life_stage->id }}" @if( $record->life_stage == $life_stage->id ){{ "selected" }}@endif >{{ $life_stage->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Ocean / Sea / Lake</p>
              <select class="form-control search-report-select select2" id="ocean_sea_lake" name="ocean_sea_lake">
              @if( count($ocean_sea_lakes) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($ocean_sea_lakes as $ocean_sea_lake)
                  <option value="{{ $ocean_sea_lake->id }}" @if( $record->ocean_sea_lake == $ocean_sea_lake->id ){{ "selected" }}@endif >{{ $ocean_sea_lake->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Islands / Island</p>
              <input type="text" class="form-control" id="island" name="island" placeholder="Text Input" disabled>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Country <span class="required">*Required</span></p>
              <select class="form-control search-report-select select2" id="country" name="country" required>
              @if( count($countries) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($countries as $country)
                  <option value="{{ $country->id }}" @if( $record->country == $country->id ){{ "selected" }}@endif >{{ $country->country_en }} / {{ $country->country_th }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-4 province">
              <p class="search-report-dropdown-header">Province</p>
              <select class="form-control search-report-select select2" id="province" name="province">
                @if ( $record->province != null && $record->province != 0 )
                    <option value="" selected disabled>Select</option>
                      @foreach($provinces as $province)
                        <option value="{{ $province->id }}" @if( $record->province == $province->id ){{ "selected" }}@endif >{{ $province->province_en }} / {{ $province->province_th }}</option>
                      @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-4 district">
              <p class="search-report-dropdown-header">District</p>
              <select class="form-control search-report-select select2" id="district" name="district">
              @if( count($districts) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($districts as $district)
                  <option value="{{ $district->id }}" @if( $record->district == $district->id ){{ "selected" }}@endif >{{ $district->district_en }} / {{ $district->district_th }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4 county">
              <p class="search-report-dropdown-header">County</p>
              <select class="form-control search-report-select select2" id="county" name="county">
              @if( count($counties) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($counties as $countie)
                  <option value="{{ $countie->id }}" @if( $record->county == $countie->id ){{ "selected" }}@endif >{{ $countie->county_en }} / {{ $countie->county_th }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-8">
              <p class="search-report-dropdown-header">Locality</p>
              <input type="text" class="form-control" id="locality" name="locality" placeholder="Text Input" @if ( $record->locality != null ) value="{{ $record->locality }}" @endif>
            </div>
          </div>

          <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
              <div class="panel panel-primary panel-custom">
                <div class="panel-heading">
                  <p class="panel-title">Found Location</p>
                </div>
                <div class="panel-body">

                  <div class="row row-inform">
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">Verbatim Latitude</p>
                      <input type="text" class="form-control" id="verbatim_lat" name="verbatim_lat" maxlength="255" placeholder="Number" @if ( $record->verbatim_latitude != null ) value="{{ $record->verbatim_latitude }}" @endif>
                    </div>
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">Verbatim Longitude</p>
                      <input type="text" class="form-control" id="verbatim_long" name="verbatim_long" maxlength="255" placeholder="Number" @if ( $record->verbatim_longitude != null ) value="{{ $record->verbatim_longitude }}" @endif>
                    </div>
                  </div>

                  <hr class="view-record-line manage-record">

                  <div class="row row-inform">
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">Latitude</p>
                      <input type="number" step="any" class="form-control" id="lat" name="lat" maxlength="255" placeholder="Number" @if ( $record->latitude != null ) value="{{ $record->latitude }}" @endif>
                    </div>
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">Longitude</p>
                      <input type="number" step="any" class="form-control" id="long" name="long" maxlength="255" placeholder="Number" @if ( $record->longitude != null ) value="{{ $record->longitude }}" @endif>
                    </div>
                  </div>

                  <hr class="view-record-line manage-record">

                  <div class="row row-inform">
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">Start Latitude</p>
                      <input type="number" step="any" class="form-control" id="start_lat" name="start_lat" maxlength="255" placeholder="Number" @if ( $record->start_latitude != null ) value="{{ $record->start_latitude }}" @endif>
                    </div>
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">End Latitude</p>
                      <input type="number" step="any" class="form-control" id="end_lat" name="end_lat" maxlength="255" placeholder="Number" @if ( $record->end_latitude != null ) value="{{ $record->end_latitude }}" @endif>
                    </div>
                  </div>

                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">Start Longitude</p>
                      <input type="number" step="any" class="form-control" id="start_long" name="start_long" maxlength="255" placeholder="Number" @if ( $record->start_longitude != null ) value="{{ $record->start_longitude }}" @endif>
                    </div>
                    <div class="col-md-6">
                      <p class="search-report-dropdown-header">End Longitude</p>
                      <input type="number" step="any" class="form-control" id="end_long" name="end_long" maxlength="255" placeholder="Number" @if ( $record->end_longitude != null ) value="{{ $record->end_longitude }}" @endif>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Habitat</p>
              <select class="form-control search-report-select select2" id="habitat" name="habitat">
              @if( count($habitats) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($habitats as $habitat)
                  <option value="{{ $habitat->id }}" @if( $record->habitat == $habitat->id ){{ "selected" }}@endif >{{ $habitat->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Depth Start</p>
              <div class="row">
                <div class="col-md-6">
                  <input type="number" step="any" class="form-control" id="depth" name="depth" maxlength="255" placeholder="Number" @if ( $record->depth_start != null ) value="{{ $record->depth_start }}" @endif>
                </div>
                <div class="dash-between-input">-</div>
                <div class="col-md-6">
                  <select class="form-control search-report-select select2" id="depth_unit" name="depth_unit">
                    <option value="1" selected>meter</option>
                    <option value="2">ft.</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Depth End</p>
              <div class="row">
                <div class="col-md-6">
                  <input type="number" step="any" class="form-control" id="depth_end" name="depth_end" maxlength="255" placeholder="Number" @if ( $record->depth_end != null ) value="{{ $record->depth_end }}" @endif>
                </div>
                <div class="dash-between-input">-</div>
                <div class="col-md-6">
                  <select class="form-control search-report-select select2" id="depth_end_unit" name="depth_end_unit">
                    <option value="1" selected>meter</option>
                    <option value="2">ft.</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-8">
              <p class="search-report-dropdown-header">Collector</p>
              <input type="text" class="form-control" id="collector" name="collector" maxlength="255" placeholder="Name" @if ( $record->collector != null ) value="{{ $record->collector }}" @endif>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Collected Date</p>
              <div class='input-group'>
                  <input type="text" class="form-control date_picker_search" id="collected_date" name="collected_date" placeholder="Calendar" @if ( $record->collected_date != null ) value="{{ Allmean::ReplaceNullWithDefaultDate( $record->collected_date ) }}" @endif readonly>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-8">
              <p class="search-report-dropdown-header">Current Identifier</p>
              <input type="text" class="form-control" id="cur_identifier" name="cur_identifier" maxlength="255" placeholder="Name" @if ( $record->identifier != null ) value="{{ $record->identifier }}" @endif>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Current Idenified Date</p>
              <div class='input-group'>
                  <input type="text" class="form-control date_picker_search" id="cur_identified_date" name="cur_identified_date" placeholder="Calendar" @if ( $record->identified_date != null ) value="{{ Allmean::ReplaceNullWithDefaultDate( $record->identified_date ) }}" @endif readonly>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-8">
              <p class="search-report-dropdown-header">Previous Identifier</p>
              <input type="text" class="form-control" id="prev_identifier" name="prev_identifier" maxlength="255" placeholder="Name" @if ( $record->previous_identifier != null ) value="{{ $record->previous_identifier }}" @endif>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Previous Idenified Date</p>
              <div class='input-group'>
                  <input type="text" class="form-control date_picker_search" id="prev_identified_date" name="prev_identified_date" placeholder="Calendar" @if ( $record->previous_identified_date != null ) value="{{ Allmean::ReplaceNullWithDefaultDate( $record->previous_identified_date ) }}" @endif readonly>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Gear Method</p>
              <select class="form-control search-report-select select2" id="gear_method" name="gear_method">
              @if( count($gear_methods) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($gear_methods as $gear_method)
                  <option value="{{ $gear_method->id }}" @if( $record->gear_method == $gear_method->id ){{ "selected" }}@endif >{{ $gear_method->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Preparation Type</p>
              <select class="form-control search-report-select select2" id="preparation_type" name="preparation_type">
              @if( count($preparation_types) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($preparation_types as $preparation_type)
                  <option value="{{ $preparation_type->id }}" @if( $record->preparation_type == $preparation_type->id ){{ "selected" }}@endif >{{ $preparation_type->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Expedition</p>
              <select class="form-control search-report-select select2" id="expedition" name="expedition">
              @if( count($expeditions) !== 0 )
                <option value="" selected disabled>Select</option>
                @foreach($expeditions as $expedition)
                  <option value="{{ $expedition->id }}" @if( $record->expedition == $expedition->id ){{ "selected" }}@endif >{{ $expedition->name_en }}</option>
                @endforeach
              @else
                <option value="" selected>No list in select</option>
              @endif
              </select>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-4">
              <p class="search-report-dropdown-header">Gene Bank Number</p>
              <input type="text" class="form-control" id="gene_bank_number" name="gene_bank_number" maxlength="255" placeholder="Text Input" @if ( $record->gene_bank_number != null ) value="{{ $record->gene_bank_number }}" @endif>
            </div>
            <div class="col-md-8">
              <p class="search-report-dropdown-header">Diagnosis</p>
              <input type="text" class="form-control" id="diagnosis" name="diagnosis" placeholder="Text Input" @if ( $record->diagnosis != null ) value="{{ $record->diagnosis }}" @endif>
            </div>
          </div>

          <div class="row row-inform">
            <div class="col-md-6">
              <p class="search-report-dropdown-header">Description</p>
              <textarea class="form-control" id="description" name="description" rows="10" placeholder="Text Input">@if( $record->description != null ){{ $record->description }}@endif</textarea>
            </div>
            <div class="col-md-6">
              <p class="search-report-dropdown-header">Notes</p>
              <textarea class="form-control" id="note_collector" name="note_collector" rows="10" placeholder="Text Input">@if( $record->note_collector != null ){{ $record->note_collector }}@endif</textarea>
            </div>
          </div>

          <div class="panel panel-primary panel-custom">
              <div class="panel-heading" role="tab" id="extra_header">
                  <p class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#extra_info" aria-expanded="false" aria-controls="extra_header">Extra Information <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" style="float: right; line-height: 25px;"></span></a>
                </p>
              </div>

              <div id="extra_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="extra_info">
                  <div class="panel-body">

                    <div class="row">
                        <?php $i = 0; ?>
                        @foreach ( $extra_fields as $extra_field )
                            <div class="col-md-6" @if ( $extra_field->status == 1 ) style="display: none;" @endif >
                              <p class="search-report-dropdown-header">{{ $extra_field->name }}</p>
                              <input type="text" class="form-control" id="extra_info[{{ $i }}]" name="extra_info[{{ $i }}]" @if ( !is_null( $extra_info ) ) value="{{ $extra_info->{'extra'.($i+1)} }}" @endif placeholder="Text Input">
                            </div>
                            <?php $i++; ?>
                        @endforeach
                    </div>

                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-6 search-report-button" style="text-align: left">
                  <button type="button" class="btn btn-default btn-gold btn-gray" onclick="window.location.href='{{ url('staff').'/'.$back_page }}'" style="font-size: 16px;">Back</button>
              </div>
              <div class="col-md-6 search-report-button" style="text-align: right">
                  <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Save Record</button>
              </div>
          </div>

        </form>

    </div>
  </div>
</div>

@endsection
