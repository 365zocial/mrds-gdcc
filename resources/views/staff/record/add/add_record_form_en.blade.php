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

    		/* back button in browser */
    		history.pushState(null, null, 'addRecordForm');
    		window.addEventListener('popstate', function(event) {
    			history.pushState(null, null, 'addRecordForm');
    		});

    		chooseSpecimenOrPublication();

            $('#country').change(function(){
                $('#province').html("<option value='0' selected>Select</option>");
                $('#district').html("<option value='0' selected>Select</option>");
                $('#county').html("<option value='0' selected>Select</option>");

                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/wording/getProvinceInCountry'); ?>",
                    data: { 
                      _token: "{{ csrf_token() }}",
                      id: $(this).val() 
                    }
                })
                .done(function( data ) {
                    $('.province').show();
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
                    // console.log(data);
                    $('.district').show();
                    var no = 0;
                    $.each(data, function(){
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
                    $('.county').show();
                    var no = 0;
                    $.each(data, function(){
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
                    $('#no_species').val(1);
                }else{
                    $('#no_species').attr('disabled',true);
                }
            });

            /* select2 */
            $(".select2").select2();

            $('#form').submit(function(e){

                e.preventDefault();
                e.returnValue = false;

                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/checkCatalog'); ?>",
                    data: { _token: "{{ csrf_token() }}",
                            marinecenter_id: $('#marine_center').val(),
                            catalog_no: $('#catalog_number').val()
                        }
                })
                .done(function( data ) {
                    $('#check-catalog-number').css('visibility', 'visible');
                    if(data == false){
                        // alert("true");
                        $('#catalog_number').focus();
                        // $('#catalog_used').show();
                        $('#check-catalog-number').removeClass('glyphicon-ok-circle');
                        $('#check-catalog-number').addClass(' glyphicon-remove-circle');
                    }else{
                        $('#form').off('submit');
                        $('#form').submit();
                    }

                });

            });

            $('#marine_center').change(function(){
                $('#reference').html("");
                $.ajax({
                    method: "POST",
                    url: "<?php echo url('staff/wording/getReferenceByMarineCenterID'); ?>",
                    data: {
                            _token: "{{ csrf_token() }}", 
                            marinecenter_id: $(this).val()
                          }
                })
                .done(function( data ) {
                    var no = 0;
                    $.each(data, function(){
                        $('#reference').append("<option value="+data[no].id+">"+data[no].ref_code+"/"+data[no].name_th+"</option>");
                        no++;
                    });
                });
            });

        } );

		function chooseSpecimenOrPublication() {
			$("#publication_part").hide();
			$("#specimen_source").click(function(){
				$("#specimen_part").fadeIn(800);
				$("#publication_part").fadeOut(800);
				$("#reference").removeAttr("required");
				$("#reference").removeAttr("data-parsley-focus");
				$("#page").removeAttr("required", "true");
				$("#page").removeAttr("data-parsley-focus", "first");
			});
			$("#publication_source").click(function(){
				$("#specimen_part").fadeOut(800);
				$("#publication_part").fadeIn(800);
				$("#reference").attr("required", "true");
				$("#reference").attr("data-parsley-focus", "first");
				$("#page").attr("required", "true");
				$("#page").attr("data-parsley-focus", "first");
			});
		}

    </script>

@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\AllMean;
        $can_change_class = false;
    ?>
@endsection

@section('header')
    <?php
        $headerName = "Add Record";
        $iconFileName = "icon_dashboard_manager/add_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Add New Record'] = url('staff/checkClassificationForm');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_add/add_step3.png') }}" />
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Add New Record</p>
            <p class="content-help-text">Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>

            <form id="form" action="{{ url('staff/doAddRecord') }}" method="post">
                @csrf
                <input type="hidden" name="classification_id" value="{{ $classification->id }}">

                <p class="search-report-dropdown-header">Scientific Name and Description</p>
                @include('staff.record.scientific_name_description')

                <div class="row">
                  <div class="col-md-12">
                    <p class="search-report-dropdown-header">
                      Source
                      <label class="radio-inline">
                        <input type="radio" id="specimen_source" name="source" value="1" checked>Specimen
                      </label>
                      <label class="radio-inline">
                        <input type="radio" id="publication_source" name="source" value="2">Publication
                      </label>
                    </p>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Marine Center</p>
                    @if ( Auth::user()->role_id == 2 )
                        <select class="form-control search-report-select select2" id="marine_center" name="marine_center">
                            @foreach ( $marinecenter_list as $marinecenter )
                                <option value="{{ $marinecenter->id }}">{{ $marinecenter->marinecenter_code }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" id="marine_center_show" class="form-control" name="marine_center_show" placeholder="{{ $marinecenter }}" readonly>
                        <input type="hidden" id="marine_center" name="marine_center" value="{{ Auth::user()->marinecenter_id }}">
                    @endif
                  </div>
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Collection Code <span class="required">*Required</span></p>
                    <select class="form-control search-report-select select2" id="collection_code" name="collection_code" required>
                        <option value="0" disabled selected>Select</option>
                        @foreach ( $collection_codes as $collection_code )
                            <option value="{{ $collection_code->id }}">{{ $collection_code->name_en }}</option>
                        @endforeach
                    </select>
                  </div>
                    <div class="col-md-4" id="specimen_part">
                        <p class="search-report-dropdown-header" style="margin-bottom: 1px;">Catalog Number <span class="required">*Required</span></p>
                        <input type="number" class="form-control" id="catalog_number" name="catalog_number" maxlength="10" value="{{ $catalog_number_max }}" style="width: 80%; display: inline-block;"><span id="check-catalog-number" class="glyphicon glyphicon-ok-circle" aria-hidden="true" style="font-size: 30px; color: #52d45c; top: 9px; left: 10px; visibility:hidden;"></span>
                    </div>
                </div>

                <div id="publication_part">
                    <div class="row row-inform" >
                        <div class="col-md-12">
                            <p class="search-report-dropdown-header">Reference <span class="required">*Required</span></p>
                            <select class="form-control search-report-select select2" id="reference" name="reference" style="width:100%;">
                            @if( count($references) !== 0 )
                              <option value="" selected disabled>Select</option>
                              @foreach($references as $reference)
                                <option value="{{ $reference->id }}">
                                    {{ $reference->ref_code }} / {{ substr($reference->name_en , 0 , strpos( $reference->name_en , ".", strpos( $reference->name_en , ".") + strlen(".") ) ) }}
                                </option>
                              @endforeach
                            @else
                              <option value="" selected>No list in select</option>
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="row row-inform">
                      <div class="col-md-4">
                        <p class="search-report-dropdown-header">Page <span class="required">*Required</span></p>
                        <input type="number" class="form-control" id="page" name="page" placeholder="Page No." min="1">
                      </div>
                      <div class="col-md-4">
                        <p class="search-report-dropdown-header">No. Species</p>
                        <input type="number" class="form-control" id="no_species" name="no_species" placeholder="No Species" min="1" max="100">
                      </div>
                      <div class="col-md-4">
                        <p class="search-report-dropdown-header">No. Locality</p>
                        <input type="number" class="form-control" id="no_locality" name="no_locality" placeholder="Generate By System." readonly>
                      </div>
                    </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6">
                    <p class="search-report-dropdown-header">Variety Name</p>
                    <input type="text" class="form-control" id="variety_name" name="variety_name" placeholder="Text Input">
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6">
                    <p class="search-report-dropdown-header">Donated From</p>
                    <select class="form-control search-report-select select2" id="donated_from" name="donated_from">
                    @if( count($donated_froms) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($donated_froms as $donated_from)
                        <option value="{{ $donated_from->id }}">{{ $donated_from->name_en }}</option>
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
                        <option value="{{ $deposited_at->id }}">{{ $deposited_at->name_en }}</option>
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
                        <option value="{{ $type_status->id }}">{{ $type_status->name_en }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-8">
                    <p class="search-report-dropdown-header">Individual Count</p>
                    <input type="text" class="form-control" id="individual_count" name="individual_count" placeholder="Text Input">
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Sex</p>
                    <select class="form-control search-report-select select2" id="sex" name="sex">
                    @if( count($sexs) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($sexs as $sex)
                        <option value="{{ $sex->id }}">{{ $sex->name_en }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Size</p>
                    <input type="text" class="form-control" id="size" name="size" placeholder="Text Input">
                  </div>
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Life Stage</p>
                    <select class="form-control search-report-select select2" id="life_stage" name="life_stage">
                    @if( count($life_stages) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($life_stages as $life_stage)
                        <option value="{{ $life_stage->id }}">{{ $life_stage->name_en }}</option>
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
                        <option value="{{ $ocean_sea_lake->id }}">{{ $ocean_sea_lake->name_en }}</option>
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
                        <option value="0" selected disabled>Select</option>
                        @foreach ( $countries as $country )
                            <option value="{{ $country->id }}">{{ $country->country_en }}/{{ $country->country_th }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-md-4 province" style="display:none;">
                    <p class="search-report-dropdown-header">Province</p>
                    <select class="form-control search-report-select select2" id="province" name="province">
                        <option value="0" selected disabled>Select</option>
                    </select>
                  </div>
                  <div class="col-md-4 district" style="display:none;">
                    <p class="search-report-dropdown-header">District</p>
                    <select class="form-control search-report-select select2" id="district" name="district">
                        <option value="0" selected disabled>Select</option>
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-4 county" style="display:none;">
                    <p class="search-report-dropdown-header">County</p>
                    <select class="form-control search-report-select select2" id="county" name="county">
                        <option value="0" selected disabled>Select</option>
                    </select>
                  </div>
                  <div class="col-md-8">
                    <p class="search-report-dropdown-header">Locality</p>
                    <input type="text" class="form-control" id="locality" name="locality" placeholder="Text Input">
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
                            <input type="text" class="form-control" id="verbatim_lat" name="verbatim_lat" maxlength="255" placeholder="Number">
                          </div>
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">Verbatim Longitude</p>
                            <input type="text" class="form-control" id="verbatim_long" name="verbatim_long" maxlength="255" placeholder="Number">
                          </div>
                        </div>

                        <hr class="view-record-line manage-record">

                        <div class="row row-inform">
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">Latitude</p>
                            <input type="number" step="any" class="form-control" id="lat" name="lat" maxlength="255" placeholder="Number">
                          </div>
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">Longitude</p>
                            <input type="number" step="any" class="form-control" id="long" name="long" maxlength="255" placeholder="Number">
                          </div>
                        </div>

                        <hr class="view-record-line manage-record">

                        <div class="row row-inform">
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">Start Latitude</p>
                            <input type="number" step="any" class="form-control" id="start_lat" name="start_lat" maxlength="255" placeholder="Number">
                          </div>
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">End Latitude</p>
                            <input type="number" step="any" class="form-control" id="end_lat" name="end_lat" maxlength="255" placeholder="Number">
                          </div>
                        </div>

                        <div class="row" style="margin-bottom: 5px;">
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">Start Longitude</p>
                            <input type="number" step="any" class="form-control" id="start_long" name="start_long" maxlength="255" placeholder="Number">
                          </div>
                          <div class="col-md-6">
                            <p class="search-report-dropdown-header">End Longitude</p>
                            <input type="number" step="any" class="form-control" id="end_long" name="end_long" maxlength="255" placeholder="Number">
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
                        <option value="{{ $habitat->id }}">{{ $habitat->name_en }}</option>
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
                        <input type="number" step="any" class="form-control" id="depth" name="depth" maxlength="255" placeholder="Number">
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
                        <input type="number" step="any" class="form-control" id="depth_end" name="depth_end" maxlength="255" placeholder="Number">
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
                    <input type="text" class="form-control" id="collector" name="collector" maxlength="255" placeholder="Name">
                  </div>
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Collected Date</p>
                    <div class='input-group'>
                        <input type="text" class="form-control date_picker_search" id="collected_date" name="collected_date" placeholder="Calendar" readonly>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-8">
                    <p class="search-report-dropdown-header">Current Identifier</p>
                    <input type="text" class="form-control" id="cur_identifier" name="cur_identifier" maxlength="255" placeholder="Name">
                  </div>
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Current Idenified Date</p>
                    <div class='input-group'>
                        <input type="text" class="form-control date_picker_search" id="cur_identified_date" name="cur_identified_date" placeholder="Calendar" readonly>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-8">
                    <p class="search-report-dropdown-header">Previous Identifier</p>
                    <input type="text" class="form-control" id="prev_identifier" name="prev_identifier" maxlength="255" placeholder="Name">
                  </div>
                  <div class="col-md-4">
                    <p class="search-report-dropdown-header">Previous Idenified Date</p>
                    <div class='input-group'>
                        <input type="text" class="form-control date_picker_search" id="prev_identified_date" name="prev_identified_date" placeholder="Calendar" readonly>
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
                        <option value="{{ $gear_method->id }}">{{ $gear_method->name_en }}</option>
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
                        <option value="{{ $preparation_type->id }}">{{ $preparation_type->name_en }}</option>
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
                        <option value="{{ $expedition->id }}">{{ $expedition->name_en }}</option>
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
                    <input type="text" class="form-control" id="gene_bank_number" name="gene_bank_number" maxlength="255" placeholder="Text Input">
                  </div>
                  <div class="col-md-8">
                    <p class="search-report-dropdown-header">Diagnosis</p>
                    <input type="text" class="form-control" id="diagnosis" name="diagnosis" placeholder="Text Input">
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6">
                    <p class="search-report-dropdown-header">Description</p>
                    <textarea class="form-control" id="description" name="description" rows="10" placeholder="Text Input"></textarea>
                  </div>
                  <div class="col-md-6">
                    <p class="search-report-dropdown-header">Notes</p>
                    <textarea class="form-control" id="note_collector" name="note_collector" rows="10" placeholder="Text Input"></textarea>
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
                                    <input type="text" class="form-control" id="extra_info[{{$i}}]" name="extra_info[{{$i}}]" placeholder="Text Input">
                                  </div>
                                  <?php $i++; ?>
                              @endforeach
                          </div>

        				</div>
        			</div>
                </div>

                <div class="row">
                    <div class="col-md-6 search-report-button" style="text-align: left">
                        <button type="button" class="btn btn-default btn-gold btn-gray" onclick="window.location.href='{{ url('staff/checkClassificationForm') }}'" style="font-size: 16px;">Back</button>
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
