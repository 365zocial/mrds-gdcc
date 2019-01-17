@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        html , body {
            font-family: Roboto, THSarabun, Serif;
        }
    </style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/bootstrap-filestyle.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

        	/* parsley */
        	$('#form').parsley();
        	$("#collection_code").attr("required", "true");
    		$("#collection_code").attr("data-parsley-focus", "first");
        	$("#country").attr("required", "true");
    		$("#country").attr("data-parsley-focus", "first");
    		$("#preparation_type").attr("required", "true");
    		$("#preparation_type").attr("data-parsley-focus", "first");

    		/* back button in browser */
    		history.pushState(null, null, 'addRecordPicture');
    		window.addEventListener('popstate', function(event) {
    			history.pushState(null, null, 'addRecordPicture');
    		});

            $('#clearinput').click(function(){
                $(this).parents().children(":file").filestyle('clear');
            });

    		chooseSpecimenOrPublication();

            $(":file").filestyle({buttonText: "Select file to upload"});

            var _URL = window.URL || window.webkitURL;
            $(":file").change(function(e) {
                var inp_file = $(this);
                var file, img;
                var fix_mib = 1.1;
                var fixbyte = fix_mib*1024*1024;
                var byte_file, byte_file_kib, byte_file_mib;

                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function() {

                        byte_file = file.size;

                        if(Number(byte_file) > Number(fixbyte) ){
                            alert("Your image is over than 2 MiB. Please select new image or resize image before upload again.");
                            inp_file.filestyle('clear');
                        }

                        if(this.width <= this.height){
                            alert("Your picture should be Horizontal");
                            inp_file.filestyle('clear');
                        }

                    };
                    img.onerror = function() {
                        alert( "not a valid file: " + file.type);
                    };
                    img.src = _URL.createObjectURL(file);
                }
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
        $breadcump['Add Image'] = url('staff/checkClassificationForm');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_add/add_step5.png') }}" />
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Add Image</p>

            <p class="search-report-dropdown-header">Scientific Name and Description</p>
            @include('staff.record.scientific_name_description')

            <div class="row row-inform">
                <div class="col-md-12">
                    <p class="search-report-dropdown-header font-thai-resize">คำแนะนำในการ <span class="english-in-thai">Upload</span> รูปภาพ</p>
                    <ul class="font-thai-resize">
                        <li> <span class="english-in-thai">-</span> สัดส่วนของรูปภาพควรจะเป็น <span class="english-in-thai">(Ratio) 4:3</span></li>
                        <li> <span class="english-in-thai">-</span> เพื่อความรวดเร็วในการ <span class="english-in-thai">upload</span> และเรียกดูขนาดรูปภาพที่เหมาะสมไม่ควรเกิน <span class="english-in-thai">1.1 MiB</span></li>
                        <li> <span class="english-in-thai">-</span> ไฟล์รูปภาพที่ใช้ ควรเป็นไฟล์นามสกุล <span class="english-in-thai">JPG</span> หรือ <span class="english-in-thai">JPEG</span> เท่านั้น</li>
                        <li> <span class="english-in-thai">-</span> ความละเอียดในการแสดงผลของภาพ <span class="english-in-thai">(Dpi)</span> ควรเป็น <span class="english-in-thai">72dpi</span></li>
                    </ul>
                </div>
            </div>

            <form id="form" action="{{ url('staff/doAddRecordPicture') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            @for($i = 0; $i < 6; $i++)
                                <div class="panel panel-default">
                                    <div class="panel-heading heading_collapse_{{ $i }}" role="tab" id="headingOne" @if($i == 0) style='border-bottom-color: none'; @endif>
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $i }}" aria-expanded="true" aria-controls="collapse_{{ $i }}">
                                              Image {{ $i+1 }} <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" style="float: right; line-height: 25px;"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_{{ $i }}" class="panel-collapse collapse @if($i == 0){{ "in" }}@endif" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">

                                            <div class="row row-inform">
                                                <div class="col-md-12">
                                                    <p class="search-report-dropdown-header">Upload New Image</p>
                                                    <input type="file" class="form-control col-md-11" id="picture_{{ $i }}" name="picture[]" placeholder="Name" accept="image/jpeg, image/jpg">
                                                </div>
                                            </div>

                                            <div class="row row-inform">
                                                <div class="col-md-12">
                                                    <p class="search-report-dropdown-header">Photographer</p>
                                                    <input type="text" class="form-control upload-image-form" id="photographer" name="photographer_{{ $i }}" value="@if( isset($pictures[$i]) ){{ $pictures[$i]->photographer }}@endif" placeholder="Name">
                                                </div>
                                            </div>

                                            <div class="row row-inform">
                                                <div class="col-md-12">
                                                    <p class="search-report-dropdown-header">Caption</p>
                                                    <textarea class="form-control upload-image-form" rows="4" id="comment" name="caption_{{ $i }}" placeholder="Text">@if( isset($pictures[$i]) ){{ $pictures[$i]->caption }}@endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px; text-align: center;">
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Upload Image</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
