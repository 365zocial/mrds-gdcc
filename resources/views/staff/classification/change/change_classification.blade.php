@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
    <style type="text/css">
        .ui-helper-hidden-accessible { display:none; }
        .ui-corner-all { color: #000; }
        .ui-autocomplete .ui-front .ui-menu .ui-widget .ui-widget-content {
            position: relative;
            z-index: 9999;
        }
        .boxAutocomplete {
            background-color: #FFF;
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            width: 500px;
        }
        .ui-autocomplete { width: 500px; }
    </style>
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/script/jquery-ui.min.js') }}"></script>

    <script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>
    <script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
        $('#form').parsley();
        $("#cur_sci_name").attr("required", "true");
    	$("#cur_sci_name").attr("data-parsley-focus", "first");

        $('#cur_sci_name').change(function(){
            var classID = $(this).val();
            getInfoClassification(classID);
        });
    });

    function getInfoClassification(classID) {
    	$.ajax({
			url: "<?php echo url('staff/getInfoClassification'); ?>",
			method: 'POST',
			data: {
                _token: "{{ csrf_token() }}",
				classification_id: classID,
				// 'classification_id': classID,
				// '_token': "<?php echo csrf_token(); ?>"
			},
			success: function( reponse ){
				$('#current_scientific_name').html(reponse.current_scientific_name);
                $('#identification_qualifier').html(reponse.identification_qualifier);
                $('#previous_scientific_name').html(reponse.previous_scientific_name);
                $('#domain').html(reponse.domain);
                $('#phylum').html(reponse.phylum);
                $('#class').html(reponse.class);
                $('#infraclass').html(reponse.infraclass);
                $('#superorder').html(reponse.superorder);
                $('#suborder').html(reponse.suborder);
                $('#superfamily').html(reponse.superfamily);
                $('#subfamily').html(reponse.subfamily);
                $('#genus').html(reponse.genus);
                $('#species').html(reponse.species);
                $('#kingdom').html(reponse.kingdom);
                $('#subphylum').html(reponse.subphylum);
                $('#subclass').html(reponse.subclass);
                $('#order').html(reponse.order);
                $('#infraorder').html(reponse.infraorder);
                $('#family').html(reponse.family);
                $('#subgenus').html(reponse.subgenus);
                $('#subspecies').html(reponse.subspecies);
			},
		});
    }

    </script>
@endsection

@section('contain')

    <?php
        use App\Model\AllMean;
    	use App\Model\Wording;
    	use App\Model\Taxonomy;
        use App\Model\Marinecenter;
    ?>

    <!-- Error Part -->
    <center>
        <div class="col-md-8 col-md-offset-2">
            @include('alert')
        </div> <!-- /.col-md-8 -->
    </center>

    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="border: 1px solid; border-color: #337ab7;">
            <div class="row">
                <div class="col-md-12">
                    <h2>CHANGE CLASSIFICATION</h2>
                    <p>
                        @if ( $record->source == 1 )
                            {{ $record->related_catalog_item }}
                        @elseif ( $record->source == 2 )
                            {{ $record->related_reference_item }}
                        @else
                            Error
                        @endif
                    </p>
                </div> <!-- /.col-md-12 -->
            </div> <!-- /.row -->

            <div class="row">
                <form action="{{ url('staff/doChangeClassification') }}" method="post" id="form">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cur_sci_name">Current Scientific Name</label>

                            <div class="row row-inform">
                                <div class="col-md-12">
                                    <p class="search-report-dropdown-header">Current Scientific Name</p>
                                    <select class="form-control search-report-select select2" id="cur_sci_name" name="cur_sci_name">
                                    @if( count($classifications) !== 0 )
                                      <option value="" selected>Search Scientific Name</option>
                                      @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}" @if($record->classification_id == $classification->id){{ "selected" }}@endif>{!! $classification->current_scientific_name_format !!}</option>
                                      @endforeach
                                    @else
                                      <option value="" selected>No list in select</option>
                                    @endif
                                    </select>
                                </div>
                            </div>

                            <!-- <input type="text" class="form-control" id="cur_sci_name" name="cur_sci_name" placeholder="Search Scintific Name" value="{{ $classification->current_scientific_name }}" required> -->

                            <input type="hidden" id="classification_id" name="classification_id" value="{{ $classification->id }}">
                            <input type="hidden" id="record_id" name="record_id" value="{{ $record->id }}">
                        </div>
                        <div class="form-group" style="text-align: center;">
                        	<a href="{{ url('staff').'/'.$back_page }}" class="btn btn-default">Back</a>
                            <button id="save_button" type="submit" class="btn btn-default">Save</button>
                        </div>
                    </div> <!-- /.col-md-12 -->
                </form> <!-- /.form -->
            </div> <!-- /.row -->
            <div class="panel-body">
            	<label for="">Scientific Name:</label> <div style="display: inline-block;" id="current_scientific_name">{{ $classification->current_scientific_name }}</div><br>
				<label for="">Identification Qualifie:</label> <div style="display: inline-block;" id="identification_qualifier"> {{ AllMean::ReplaceNullWithDash($iq) }}</div><br>
				<label for="">Previous Scientific Name:</label> <div style="display: inline-block;" id="previous_scientific_name"> {{ AllMean::ReplaceNullWithDash($classification->previous_scientific_name) }}</div><br>
				<hr>
				<div class="row">
				    <div class="col-md-6">
				        <label for="">Domain:</label> <div style="display: inline-block;" id="domain"> {{ AllMean::ReplaceNullWithDash($domain) }}</div><br>
				        <label for="">Phylum:</label> <div style="display: inline-block;" id="phylum"> {{ AllMean::ReplaceNullWithDash($phylum) }}</div><br>
				        <label for="">Class  (Clade):</label> <div style="display: inline-block;" id="class"> {{ AllMean::ReplaceNullWithDash($class) }}</div><br>
				        <label for="">Infraclass (Clade):</label> <div style="display: inline-block;" id="infraclass"> {{ AllMean::ReplaceNullWithDash($infraclass) }}</div><br>
				        <label for="">Superorder (Clade):</label> <div style="display: inline-block;" id="superorder"> {{ AllMean::ReplaceNullWithDash($superorder) }}</div><br>
				        <label for="">Suborder (Clade):</label> <div style="display: inline-block;" id="suborder"> {{ AllMean::ReplaceNullWithDash($suborder) }}</div><br>
				        <label for="">Superfamily (Clade):</label> <div style="display: inline-block;" id="superfamily"> {{ AllMean::ReplaceNullWithDash($superfamily) }}</div><br>
				        <label for="">Subfamily (Clade):</label> <div style="display: inline-block;" id="subfamily"> {{ AllMean::ReplaceNullWithDash($subfamily) }}</div><br>
				        <label for="">Genus:</label> <div style="display: inline-block; font-style: italic;" id="genus"> {{ AllMean::ReplaceNullWithDash($genus) }}</div><br>
				        <label for="">Species:</label> <div style="display: inline-block; font-style: italic;" id="species"> {{ AllMean::ReplaceNullWithDash($species) }}</div><br>
				    </div>
				    <div class="col-md-6">
				        <label for="">Kingdom:</label> <div style="display: inline-block;" id="kingdom"> {{ AllMean::ReplaceNullWithDash($kingdom) }}</div><br>
				        <label for="">Subphylum:</label> <div style="display: inline-block;" id="subphylum"> {{ AllMean::ReplaceNullWithDash($subphylum)}}</div><br>
				        <label for="">Subclass (Clade):</label> <div style="display: inline-block;" id="subclass"> {{ AllMean::ReplaceNullWithDash($subclass) }}</div><br>
				        <label for="">&nbsp;</label><br>
				        <label for="">Order (Clade):</label> <div style="display: inline-block;" id="order"> {{ AllMean::ReplaceNullWithDash($order) }}</div><br>
				        <label for="">Infraorder (Clade):</label> <div style="display: inline-block;" id="infraorder"> {{ AllMean::ReplaceNullWithDash($infraorder) }}</div><br>
				        <label for="">Family (Clade):</label> <div style="display: inline-block;" id="family"> {{ AllMean::ReplaceNullWithDash($family) }}</div><br>
				        <label for="">&nbsp;</label><br>
				        <label for="">Subgenus:</label> <div style="display: inline-block; font-style: italic;" id="subgenus"> {{ AllMean::ReplaceNullWithDash($subgenus) }}</div><br>
				        <label for="">Subspecies:</label> <div style="display: inline-block; font-style: italic;" id="subspecies"> {{ AllMean::ReplaceNullWithDash($subspecies) }}</div><br>
				    </div>
				</div><!-- /.row -->
            </div><!-- /.row -->
        </div> <!-- /.col-md-8 -->
    </div> <!-- /.row -->
@endsection
