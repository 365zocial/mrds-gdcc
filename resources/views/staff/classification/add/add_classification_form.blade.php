@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style>
	.checkbox {
		padding-top: 20px;
	}
    </style>

	<!-- For Select2 Script -->
	<link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">

@endsection

@section('script')
	@include('base_wording_js')

	<script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>

    <script type="text/javascript">
    	/* parsley */
    	$('#form').parsley();

		$("#domain").attr("required", "true");
		$("#domain").attr("data-parsley-focus", "first");
		$("#kingdom").attr("required", "true");
		$("#kingdom").attr("data-parsley-focus", "first");
		$("#phylum").attr("required", "true");
		$("#phylum").attr("data-parsley-focus", "first");
		$("#class").attr("required", "true");
		$("#class").attr("data-parsley-focus", "first");
		$("#order").attr("required", "true");
		$("#order").attr("data-parsley-focus", "first");
		$("#family").attr("required", "true");
		$("#family").attr("data-parsley-focus", "first");
		$("#genus").attr("required", "true");
		$("#genus").attr("data-parsley-focus", "first");
		$("#species").attr("required", "true");
		$("#species").attr("data-parsley-focus", "first");

        // $('.scientificname').sticky({
        //                         topSpacing:0,
        //                         zIndex:450,
        //                         widthFromWrapper: false
        //                     });

        tinymce.init({
          selector: 'textarea',
          height: 15,
          forced_root_block : "",
          toolbar: 'bold italic',
          content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css',
            '{{ url("assets/css/tinymce.css") }}'
          ]
        });

        /* select2 */
		$(document).ready(function() {
			$(".select2").select2();
            //Create By Sorawit
			// $(".select_domain").select2();
			// $(".select_kingdom").select2();
			// $(".select_subkingdom").select2();
			// $(".select_infrakingdom").select2();
			// $(".select_phylum").select2();
			// $(".select_subphylum").select2();
			// $(".select_infraphylum").select2();
			// $(".select_superclass").select2();
			// $(".select_class").select2();
			// $(".select_subclass").select2();
			// $(".select_infraclass").select2();
			// $(".select_superorder").select2();
			// $(".select_order").select2();
			// $(".select_suborder").select2();
			// $(".select_infraorder").select2();
			// $(".select_superfamily").select2();
			// $(".select_family").select2();
			// $(".select_subfamily").select2();
			// $(".select_genus").select2();
			// $(".select_subgenus").select2();
			// $(".select_species").select2();
			// $(".select_subspecies").select2();
		});

    </script>
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
        $breadcump['Create New Classification'] = url('staff/checkClassificationForm');
    ?>
@endsection


@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_add/add_step2.png') }}" />
    </div>
</div>

<center>
    <div class="col-md-8 col-md-offset-2">
        @include('alert')
    </div>
</center>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Create New Classification</p>
            <p class="content-help-text">Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>

            <form id="form" action="{{ url('staff/doAddClassification') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header" style="margin-bottom: 10px;">Scientific Name <span class="required">*Require</span></p>
                        <textarea class="form-control" id="cur_sci_name" name="cur_sci_name" placeholder="Name"></textarea>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4 marinecenter-form">
                        <p class="search-report-dropdown-header">Identification Qualifier</p>
                        <select class="form-control search-report-select select2" id="iq" name="iq">
                        @if( count($identification_qualifiers) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($identification_qualifiers as $identification_qualifier)
                                <option value="{{ $identification_qualifier->id }}">{{ $identification_qualifier->name_en }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header" style="margin-bottom: 10px;">Previous Scientific Name</p>
                        <textarea class="form-control" id="pre_sci_name" name="pre_sci_name" placeholder="Name"></textarea>
                    </div>
                </div>

                <hr class="search-report">

                <div class="row row-inform">
                    <div class="col-md-6 marinecenter-form">
                        <p class="search-report-dropdown-header">Domain <span class="required">*Require</span></p>
                        <select class="form-control search-report-select select2" id="domain" name="domain" required>
                        @if( count($domains) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($domains as $domain)
                                <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6 marinecenter-form">
                        <p class="search-report-dropdown-header">Kingdom <span class="required">*Require</span></p>
                        <select class="form-control search-report-select select2" id="kingdom" name="kingdom" required>
                        @if( count($kingdoms) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($kingdoms as $kingdom)
                                <option value="{{ $kingdom->id }}">{{ $kingdom->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-md-6 marinecenter-form">
                        <p class="search-report-dropdown-header">Subkingdom</p>
                        <select class="form-control search-report-select select2" id="subkingdom" name="subkingdom">
                        @if( count($subkingdoms) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($subkingdoms as $subkingdom)
                                <option value="{{ $subkingdom->id }}">{{ $subkingdom->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6 marinecenter-form">
                        <p class="search-report-dropdown-header">Infrakingdom</p>
                        <select class="form-control search-report-select select2" id="infrakingdom" name="infrakingdom">
                        @if( count($infrakingdoms) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($infrakingdoms as $infrakingdom)
                                <option value="{{ $infrakingdom->id }}">{{ $infrakingdom->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6 marinecenter-form">
                        <p class="search-report-dropdown-header">Phylum <span class="required">*Require</span></p>
                        <select class="form-control search-report-select select2" id="phylum" name="phylum" required>
                        @if( count($phylums) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($phylums as $phylum)
                                <option value="{{ $phylum->id }}">{{ $phylum->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                    <div class="col-md-6 marinecenter-form">
                        <p class="search-report-dropdown-header">Subphylum</p>
                        <select class="form-control search-report-select select2" id="subphylum" name="subphylum">
                        @if( count($subphylums) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($subphylums as $subphylum)
                                <option value="{{ $subphylum->id }}">{{ $subphylum->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Infraphylum</p>
                    <select class="form-control search-report-select select2" id="infraphylum" name="infraphylum">
                    @if( count($infraphylums) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($infraphylums as $infraphylum)
                        <option value="{{ $infraphylum->id }}">{{ $infraphylum->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Superclass</p>
                    <select class="form-control search-report-select select2" id="superclass" name="superclass">
                    @if( count($superclasses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($superclasses as $superclass)
                        <option value="{{ $superclass->id }}">{{ $superclass->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Class (Clade) <span class="required">*Require</span></p>
                    <select class="form-control search-report-select select2" id="class" name="class" required>
                    @if( count($classes) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Subclass (Clade)</p>
                    <select class="form-control search-report-select select2" id="subclass" name="subclass">
                    @if( count($subclasses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($subclasses as $subclass)
                        <option value="{{ $subclass->id }}">{{ $subclass->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Infraclass (Clade)</p>
                    <select class="form-control search-report-select select2" id="infraclass" name="infraclass">
                    @if( count($infraclasses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($infraclasses as $infraclass)
                        <option value="{{ $infraclass->id }}">{{ $infraclass->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Superorder (Clade)</p>
                    <select class="form-control search-report-select select2" id="superorder" name="superorder">
                    @if( count($superorders) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($superorders as $superorder)
                        <option value="{{ $superorder->id }}"> {{ $superorder->name }} </option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Order (Clade) <span class="required">*Require</span></p>
                    <select class="form-control search-report-select select2" id="order" name="order" required>
                    @if( count($orders) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Suborder (Clade)</p>
                    <select class="form-control search-report-select select2" id="suborder" name="suborder">
                    @if( count($suborders) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($suborders as $suborder)
                        <option value="{{ $suborder->id }}">{{ $suborder->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Infraorder (Clade)</p>
                    <select class="form-control search-report-select select2" id="infraorder" name="infraorder">
                    @if( count($infraorders) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($infraorders as $infraorder)
                        <option value="{{ $infraorder->id }}"> {{ $infraorder->name }} </option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Superfamily (Clade)</p>
                    <select class="form-control search-report-select select2" id="superfamily" name="superfamily">
                    @if( count($superfamilys) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($superfamilys as $superfamily)
                        <option value="{{ $superfamily->id }}">{{ $superfamily->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Family (Clade) <span class="required">*Require</span></p>
                    <select class="form-control search-report-select select2" id="family" name="family" required>
                    @if( count($familys) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($familys as $family)
                        <option value="{{ $family->id }}"> {{ $family->name }} </option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Subfamily (Clade)</p>
                    <select class="form-control search-report-select select2" id="subfamily" name="subfamily">
                    @if( count($subfamilys) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($subfamilys as $subfamily)
                        <option value="{{ $subfamily->id }}">{{ $subfamily->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Genus <span class="required">*Require</span></p>
                    <select class="form-control search-report-select select2" id="genus" name="genus" required>
                    @if( count($genuses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($genuses as $genus)
                        <option value="{{ $genus->id }}">{{ $genus->name }}</option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Subgenus</p>
                    <select class="form-control search-report-select select2" id="subgenus" name="subgenus">
                    @if( count($subgenuses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($subgenuses as $subgenus)
                        <option value="{{ $subgenus->id }}"> {{ $subgenus->name }} </option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>

                <div class="row row-inform">
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Species <span class="required">*Require</span></p>
                    <select class="form-control search-report-select select2" id="species" name="species" required>
                    @if( count($specieses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($specieses as $species)
                        <option value="{{ $species->id }}"> {{ $species->name }} </option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                  <div class="col-md-6 marinecenter-form">
                    <p class="search-report-dropdown-header">Subspecies</p>
                    <select class="form-control search-report-select select2" id="subspecies" name="subspecies">
                    @if( count($subspecieses) !== 0 )
                      <option value="" selected disabled>Select</option>
                      @foreach($subspecieses as $subspecies)
                        <option value="{{ $subspecies->id }}"> {{ $subspecies->name }} </option>
                      @endforeach
                    @else
                      <option value="" selected>No list in select</option>
                    @endif
                    </select>
                  </div>
                </div>
                
                <hr class="search-report">
                <div class="row">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Protection Type</p>
                        <select class="form-control search-report-select select2" id="protection_type" name="protection_type">
                            @if( count($protection_types) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($protection_types as $protection_type)
                                    <option value="{{ $protection_type->id }}" >{{ $protection_type->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header">Common Name</p>
                        <input type="text" class="form-control" id="common_name" name="common_name" placeholder="Text Input" >
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 search-report-button" style="text-align: left;">
                        <button type="button" class="btn btn-default btn-gold btn-gray" style="font-size: 16px;" onclick="window.location.href='{{ url('staff/checkClassificationForm') }}'">Back</button>
                    </div>
                    <div class="col-md-6 search-report-button" style="text-align: right;">
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Create New Classification</button>
                    </div>
                </div>

            </form>


        </div>
    </div>
</div>

    <!-- <div class="row" style="padding-bottom: 10px;">
        <center><img class="img-responsive" src="{{ url('assets/images/progress_bar_add/add_step2.png') }}" /></center>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="border: 1px solid; border-color: #337ab7;">

        	@include('alert')

            <div class="row">
	            <div class="col-md-12">
	                <h2>CREATE NEW CLASSIFICATION</h2>
	                <p>Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>
	            </div>
            </div>

			<form id="form" action="{{ url('staff/doAddClassification') }}" method="post">
	            <div class="row scientificname" style="background-color:#FFF;">
	                <div class="col-md-12 form-group" >
	                    <label for="cur_sci_name">Scientific Name *</label>
                        <textarea class="form-control" id="cur_sci_name" name="cur_sci_name" placeholder="Name"></textarea>
	                </div>
				</div>

				<div class="row">
                    <div class="col-md-4 form-group">
	                	<label for="iq">Identification Qualifier</label>
						<select id="iq" name="iq" class="form-control select_iq">
							<option value="0">Select</option>
                            @foreach($identification_qualifiers as $identification_qualifier)
                                <option value="{{ $identification_qualifier->id }}" > {{ $identification_qualifier->name_en }}</option>
                            @endforeach
						</select>
	                </div>
				</div>

                <div class="row">
	                <div class="col-md-12 form-group">
	                    <label for="pre_sci_name">Previous Scientific Name</label>
                        <textarea class="form-control" id="pre_sci_name" name="pre_sci_name" placeholder="Name"></textarea>
	                </div>
				</div>

				<div><hr></div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="domain">Domain *</label>
						<select id="domain" name="domain" class="form-control select_domain" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $domains as $domain )
								<option value="{{ $domain->id }}"> {{ $domain->name }} </option>
							@endforeach
						</select>
					</div>

				</div>

                <div class="row">
                    <div class="col-md-6 form-group">
						<label for="kingdom">Kingdom *</label>
						<select id="kingdom" name="kingdom" class="form-control select_kingdom" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $kingdoms as $kingdom )
								<option value="{{ $kingdom->id }}"> {{ $kingdom->name }} </option>
							@endforeach
						</select>
					</div>
                    <div class="col-md-6 form-group">
	                    <label for="subkingdom">Subkingdom</label>
						<select id="subkingdom" name="subkingdom" class="form-control select_subkingdom" required>
							<option value="0" selected>Select</option>
							@foreach( $subkingdoms as $subkingdom )
								<option value="{{ $subkingdom->id }}"> {{ $subkingdom->name }} </option>
							@endforeach
						</select>
					</div>
                    <div class="col-md-6 form-group">
	                    <label for="infrakingdom">Infrakingdom</label>
						<select id="infrakingdom" name="infrakingdom" class="form-control select_infrakingdom" required>
							<option value="0" selected>Select</option>
							@foreach( $infrakingdoms as $infrakingdom )
								<option value="{{ $infrakingdom->id }}"> {{ $infrakingdom->name }} </option>
							@endforeach
						</select>
					</div>
                </div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="phylum">Phylum *</label>
						<select id="phylum" name="phylum" class="form-control select_phylum" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $phylums as $phylum )
								<option value="{{ $phylum->id }}"> {{ $phylum->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="subphylum">Subphylum</label>
						<select id="subphylum" name="subphylum" class="form-control select_subphylum">
							<option value="0" selected>Select</option>
							@foreach( $subphylums as $subphylum )
								<option value="{{ $subphylum->id }}"> {{ $subphylum->name }} </option>
							@endforeach
						</select>
					</div>

                    <div class="col-md-6 form-group">
						<label for="infraphylum">Infraphylum</label>
						<select id="infraphylum" name="infraphylum" class="form-control select_infraphylum">
							<option value="0" selected>Select</option>
							@foreach( $infraphylums as $infraphylum )
								<option value="{{ $infraphylum->id }}"> {{ $infraphylum->name }} </option>
							@endforeach
						</select>
					</div>
				</div>


				<div class="row">
                    <div class="col-md-6 form-group">
	                    <label for="superclass">Superclass</label>
						<select id="superclass" name="superclass" class="form-control select_superclass">
							<option value="0" selected>Select</option>
							@foreach( $superclasses as $superclass )
								<option value="{{ $superclass->id }}"> {{ $superclass->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
	                    <label for="class">Class / Clade *</label>
						<select id="class" name="class" class="form-control select_class" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $classes as $class )
								<option value="{{ $class->id }}"> {{ $class->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="subclass">Subclass / Clade</label>
						<select id="subclass" name="subclass" class="form-control select_subclass">
							<option value="0" selected>Select</option>
							@foreach( $subclasses as $subclass )
								<option value="{{ $subclass->id }}"> {{ $subclass->name }} </option>
							@endforeach
						</select>
					</div>
                    <div class="col-md-6 form-group">
	                    <label for="infraclass">Infraclass / Clade</label>
						<select id="infraclass" name="infraclass" class="form-control select_infraclass">
							<option value="0" selected>Select</option>
							@foreach( $infraclasses as $infraclass )
								<option value="{{ $infraclass->id }}"> {{ $infraclass->name }} </option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="superorder">Superorder / Clade</label>
						<select id="superorder" name="superorder" class="form-control select_superorder">
							<option value="0" selected>Select</option>
							@foreach( $superorders as $superorder )
								<option value="{{ $superorder->id }}"> {{ $superorder->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="order">Order / Clade *</label>
						<select id="order" name="order" class="form-control select_order" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $orders as $order )
								<option value="{{ $order->id }}"> {{ $order->name }} </option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="suborder">Suborder / Clade</label>
						<select id="suborder" name="suborder" class="form-control select_suborder">
							<option value="0" selected>Select</option>
							@foreach( $suborders as $suborder )
								<option value="{{ $suborder->id }}"> {{ $suborder->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="infraorder">Infraorder / Clade </label>
						<select id="infraorder" name="infraorder" class="form-control select_infraorder">
							<option value="0" selected>Select</option>
							@foreach( $infraorders as $infraorder )
								<option value="{{ $infraorder->id }}"> {{ $infraorder->name }} </option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="superfamily">Superfamily</label>
						<select id="superfamily" name="superfamily" class="form-control select_superfamily">
							<option value="0" selected>Select</option>
							@foreach( $superfamilys as $superfamily )
								<option value="{{ $superfamily->id }}"> {{ $superfamily->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="family">Family / Clade *</label>
						<select id="family" name="family" class="form-control select_family" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $familys as $family )
								<option value="{{ $family->id }}"> {{ $family->name }} </option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="subfamily">Subfamily / Clade</label>
						<select id="subfamily" name="subfamily" class="form-control select_subfamily">
							<option value="0" selected>Select</option>
							@foreach( $subfamilys as $subfamily )
								<option value="{{ $subfamily->id }}"> {{ $subfamily->name }} </option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="genus">Genus *</label>
						<select id="genus" name="genus" class="form-control select_genus" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $genuses as $genus )
								<option value="{{ $genus->id }}"> {{ $genus->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="subgenus">Subgenus</label>
						<select id="subgenus" name="subgenus" class="form-control select_subgenus">
							<option value="0" selected>Select</option>
							@foreach( $subgenuses as $subgenus )
								<option value="{{ $subgenus->id }}"> {{ $subgenus->name }} </option>
							@endforeach
						</select>
					</div>

				</div>

				<div class="row">
					<div class="col-md-6 form-group">
	                    <label for="species">Species *</label>
						<select id="species" name="species" class="form-control select_species" required>
							<option value="0" disabled selected>Select</option>
							@foreach( $specieses as $species )
								<option value="{{ $species->id }}"> {{ $species->name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label for="subspecies">Subspecies</label>
						<select id="subspecies" name="subspecies" class="form-control select_subspecies">
							<option value="0" selected>Select</option>
							@foreach( $subspecieses as $subspecies )
								<option value="{{ $subspecies->id }}"> {{ $subspecies->name }} </option>
							@endforeach
						</select>
					</div>
				</div>

	            <div class="row" style="padding-top: 10px; padding-bottom: 20px;">
	            	<div class="col-md-12">
	                	<a href="{{ url('staff/checkClassificationForm') }}" class="btn btn-default">Back</a>
	                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                	<button type="submit" class="btn btn-default" style="float: right;">Create New Classification</button>
	                </div>
	            </div>

	        </form>

        </div>
    </div> -->
@endsection
