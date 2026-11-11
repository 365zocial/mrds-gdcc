@extends('layouts.app')

@section('css')
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

        button[disabled].btn-gold {
            color: #c4c4c4;
            background-color: #e4e4e4;
            border-color: #e4e4e4;
        }

        button[disabled].btn-gold:hover {
            color: #c4c4c4;
            background-color: #e4e4e4;
            border-color: #e4e4e4;
        }
    </style>

    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">

@endsection

@section('script')

    <script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/script/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#form').parsley();

        if ( $('#classification_id').val() != null ) {
            $("#new_classification_button").attr("disabled");
        } else {
            $("#new_record_button").attr("disabled");
        }
        $('.loader').show();
        window.setTimeout(function(){
            $('.loader').fadeOut(750);
        },3000);

        //autoComplete();
        //checkAddRecord();

        /* select2 */
        $(".select2").select2();
    });

    function autoComplete() {
        var classifications_data = <?php echo json_encode($classifications); ?>;
        var classifications = [];
        $.each(classifications_data, function( index, value ) {
            classifications.push(value.current_scientific_name)
        });

        $("#cur_sci_name").change(function(){
            $("#cur_sci_name").autocomplete('option', 'source', classifications);
        });

        //autocomplete
        $( "#cur_sci_name" ).autocomplete({
            open: function(e) {
                valid = false;
            },
            select: function(e){
                valid = true;
            },
            close: function(e){
                cur_sci_name = $('#cur_sci_name').val();
                for($i=0; $i < classifications.length ; $i++){
                    if(cur_sci_name == classifications_data[$i].current_scientific_name) {
                        $("#classification_id").val(classifications_data[$i].id);
                        $("#new_classification_button").attr("disabled", "disabled");
                        $("#new_record_button").removeAttr("disabled");
                    }
                }
            },
            // source: classifications,
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(classifications, request.term);

                response(results.slice(0, 10));
            },
            open: function() {
                $('#cur_sci_name').autocomplete('widget').addClass('boxAutocomplete');
            }
        });

        $("#cur_sci_name").change(function(){
            if (classifications.indexOf($(this).val()) == -1){
                $("#classification_id").val('');
                $("#new_classification_button").removeAttr("disabled");
                $("#new_record_button").attr("disabled", "disabled");
            }
        });
    }

    function checkAddRecord() {
        $('#cur_sci_name').val('');
        $('#classification_id').val('');
    }

    //check classification for display button
    function checkClassfication(select_id) {
        if( select_id == 0 ) {
            $("#new_classification_button").removeAttr("disabled");
            $("#new_record_button").attr("disabled", "disabled");
        } else {
            $("#new_classification_button").attr("disabled", "disabled");
            $("#new_record_button").removeAttr("disabled");
        }
    }

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
        $breadcump['Add Classification'] = url('staff/checkClassificationForm');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_add/add_step1.png') }}" />
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
            <p class="content-header">Add Classification</p>
            <p class="content-help-text">Please use English characters only (avoid using characters such as &, *, #, <, >, ", ', .)</p>

            <form action="{{ url('staff/addClassificationForm') }}" method="post" id="form">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">Current Scientific Name</p>
                        <select class="form-control search-report-select select2" id="classification_id" name="classification_id" onchange="checkClassfication(this.value);">
                        @if( count($classifications) !== 0 )
                          <option value="" selected>Search Scientific Name</option>
                          @foreach($classifications as $classification)
                            <option
                                                value="{{ $classification->id }}"
                                                data-search="{{
                                                    trim(
                                                        preg_replace(
                                                            '/\s+/u', ' ',
                                                            str_replace(
                                                                ['&nbsp;', chr(0xC2).chr(0xA0)],
                                                                ' ',
                                                                html_entity_decode(
                                                                    strip_tags((string) $classification->current_scientific_name_format),
                                                                    ENT_QUOTES | ENT_HTML5,
                                                                    'UTF-8'
                                                                )
                                                            )
                                                        )
                                                    )
                                                }}"
                                                @if(($record->classification_id ?? null) == $classification->id) selected @endif
                                                {!! $classification->current_scientific_name_format !!}
                                            </option>
                          @endforeach
                        @else
                          <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align: center; margin-top: 10px;">
                        <button id="new_record_button" type="submit" class="btn btn-default btn-gold" style="font-size: 16px;" disabled>Add New Record</button>
                        <button id="new_classification_button" type="submit" class="btn btn-default btn-gold" style="margin-left: 10px; font-size: 16px;">Add New Classification</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
   $('#classification_id').select2({
    matcher: function(params, data) {
        if ($.trim(params.term) === '') {
            return data;
        }

        function normalize(str) {
            return (str || '')
                .toLowerCase()
                .replace(/\./g, '')
                .replace(/\s+/g, ' ')
                .trim();
        }

        var term = normalize(params.term);

        var textFromOption = $(data.element).data('search') || data.text;
        var text = normalize(textFromOption);
        var isFound = text.indexOf(term) > -1;

        if (isFound) {
            return data;
        }
        
        return null;
    }
   });
});
</script>
