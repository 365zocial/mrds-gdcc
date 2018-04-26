@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        html , body {
            font-family: Roboto, THSarabun, Serif;
        }
    </style>
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
        $breadcump['View Record']   = url( 'staff/viewRecord', base64_encode( base64_encode( base64_encode( Session::get('record_id_edit_th') ))) );
        $breadcump['Edit Record']   = url( 'staff/editRecordForm/1/'.base64_encode( base64_encode( base64_encode( Session::get('record_id_edit_th') ))), base64_encode( base64_encode( base64_encode( Session::get('record_id_edit_th') ))) );
    ?>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/bootstrap-filestyle.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // CSS Style
            $('.collapse').on('shown.bs.collapse', function () {
                $('div.panel.panel-default div.panel-heading').css( 'border-bottom' , '1px solid #3dabf9' );
                $('.heading_' + $(this).attr('id')).css( 'border-bottom' , 'none' );
            });

        	/* parsley */
        	$('#form').parsley();
        	$("#collection_code").attr("required", "true");
    		$("#collection_code").attr("data-parsley-focus", "first");
        	$("#country").attr("required", "true");
    		$("#country").attr("data-parsley-focus", "first");
    		$("#preparation_type").attr("required", "true");
    		$("#preparation_type").attr("data-parsley-focus", "first");

    		/* back button in browser */
    		history.pushState(null, null, 'editRecordPicture');
    		window.addEventListener('popstate', function(event) {
    			history.pushState(null, null, 'editRecordPicture');
    		});

    		chooseSpecimenOrPublication();

            $('.clearinput').click(function(){
                $(this).parents().parents().children().children(":file").filestyle('clear');
            });

            $(":file").filestyle({buttonText: "Browse Image"});

            $('.del-btn').click(function(){
                var del_id_pic = $(this).attr('data');
                //{{ url('assets/images/placeholder-image.png') }}
                // $(this).parent().prev().children("img").attr("src","http://www.linkjuice.co.il/components/com_easyblog/themes/wireframe/images/placeholder-image.png");
                $(this).parent().prev().children("img").removeAttr("src");
                $(this).parent().prev().children("img").attr("src","<?php echo url('/') ?>/assets/images/placeholder-image.png");
                $(this).prev().val(del_id_pic);

            });

            $(":file").change(function(){
                var id_del = $(this).attr("serie-id");
                $('input[name="del_'+id_del+'"]').val("");
            });

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
        $can_change_class = true;
    ?>
@endsection


@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_edit/edit_step3.png') }}" />
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Edit Image</p>

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

            <form id="form" action="{{ url('staff/doEditRecordPicture') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="classification_id" value="{{ $classification->id }}">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            @for($i = 0; $i < 6; $i++)
                                <div class="panel panel-default">
                                    <div class="panel-heading heading_collapse_{{ $i }}" role="tab" id="headingOne" @if($i == 0) style='border-bottom: none'; @endif>
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $i }}" aria-expanded="true" aria-controls="collapse_{{ $i }}">
                                              Image {{ $i+1 }} <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" style="float: right; line-height: 25px;"></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_{{ $i }}" class="panel-collapse collapse @if($i == 0){{ "in" }}@endif" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">

                                            @if(isset($pictures[$i]))
                                                <div class="row row-inform">
                                                    <div class="oldpic col-md-12">
                                                        <p class="search-report-dropdown-header">Old Image</p>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <img width="100%" src="{{ url('uploads/images') }}/{{ $pictures[$i]->path_pic }}" alt="Image Responsive" />
                                                                <input type="hidden" name="oldpicture[]" value="{{ $pictures[$i]->path_pic }}">
                                                                <input type="hidden" name="oldid_{{ $i }}" value="{{ $pictures[$i]->id }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="hidden" name="del_{{ $i }}" value="">
                                                                <button type="button" class="btn-delete del-btn" name="button" data="{{ $pictures[$i]->id }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete Image</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row row-inform">
                                                <div class="col-md-12">
                                                    <p class="search-report-dropdown-header">Upload New Image</p>
                                                    <input type="file" class="form-control col-md-11" id="picture_{{ $i }}" serie-id="{{ $i }}" name="picture[]" placeholder="Name" accept="image/jpeg, image/jpg">
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
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Update Image</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<!--
=======
    <div class="row" style="padding-bottom: 10px;">
        <center><img class="img-responsive" src="{{ url('assets/images/progress_bar_edit/edit_step3.png') }}" /></center>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="border: 1px solid; border-color: #337ab7;">
            <div class="row">
	            <div class="col-md-12">
	                <h2>EDIT IMAGES</h2>
	            </div>
                <div class="col-md-12 form-group">
                    <label for="collection_code">Scientific Name and Description</label>
                    <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTop" aria-expanded="false" aria-controls="collapseTop"> Scientific Name and Description
                            </a>
                            </h4>
                        </div>
                        <div id="collapseTop" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <label for="">Scientific Name:</label> {!! $classification->current_scientific_name_format !!} <br>
                                <label for="">Identification Qualifie:</label> {{ AllMean::ReplaceNullWithDash($iq) }}<br>
                                <label for="">Previous Scientific Name:</label> {!! AllMean::ReplaceNullWithDash($classification->previous_scientific_name_format) !!}<br>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Domain:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[0]['name']) }}<br>
                                        <label for="">Subkingdom:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[2]['name']) }}<br>
                                        <label for="">Phylum:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[4]['name']) }}<br>
                                        <label for="">Infraphylum:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[6]['name']) }}<br>
                                        <label for="">Superclass:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[7]['name']) }}<br>
                                        <label for="">Subclass (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[9]['name']) }}<br>
                                        <label for="">Superorder (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[11]['name']) }}<br>
                                        <label for="">Suborder (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[13]['name']) }}<br>
                                        <label for="">Superfamily (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[15]['name']) }}<br>
                                        <label for="">Subfamily (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[17]['name']) }}<br>
                                        <label for="">Genus:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[18]['name']) }}<br>
                                        <label for="">Species:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[20]['name']) }}<br>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Kingdom:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[1]['name']) }}<br>
                                        <label for="">Infrakingdom:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[3]['name']) }}<br>
                                        <label for="">Subphylum:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[5]['name']) }}<br>
                                        <label for="">&nbsp;</label><br>
                                        <label for="">Class (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[8]['name']) }}<br>
                                        <label for="">Infraclass (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[10]['name']) }}<br>
                                        <label for="">Order (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[12]['name']) }}<br>
                                        <label for="">Infraorder (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[14]['name']) }}<br>
                                        <label for="">Family (Clade):</label> {{ AllMean::ReplaceNullWithDash($taxonomy[16]['name']) }}<br>
                                        <label for="">&nbsp;</label><br>
                                        <label for="">Subgenus:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[19]['name']) }}<br>
                                        <label for="">Subspecies:</label> {{ AllMean::ReplaceNullWithDash($taxonomy[21]['name']) }}<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div><hr></div>

            <div class="row">
                <form id="form" action="{{ url('staff/doEditRecordPicture') }}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                คำแนะนำในการ Upload รูปภาพ
                            </p>
                            <ul>
                                <li>สัดส่วนของรูปภาพควรจะเป็น (Ratio) 4:3</li>
                                <li>เพื่อความรวเเร็วในการ uplod และเรียกดูขนาดร๔ปภาพที่เหมาะสมไม่ควรเกิน 1.1 MB</li>
                                <li>ไฟล์รูปภาพที่ใช้เ็นไฟล์ JPG หรือ JPEG เท่านั้ัน</li>
                                <li>ความละเเอียดในการแสดงผลของภาพ (Dpi) ควรเป็น 72dpi</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                @for($i = 0; $i < 6; $i++)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $i }}" aria-expanded="true" aria-controls="collapse_{{ $i }}">
                                                  Image {{ $i+1 }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_{{ $i }}" class="panel-collapse collapse @if($i == 0){{ "in" }} @endif" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                /// Comment //// <div class="col-md-12" style='background-color: #B7F9FF; height: 300px; display: table;'>
                                                    <div class="dropDiv" style="display: table-cell; text-align: center; vertical-align: middle;">
                                                        <h2><span style="color: #0EA1B1;">Drag & Drop a Images</span></h2>
                                                        <h4>or Click button below</h4>
                                                        <input type="file" class="inputfile" name="file1" title="Select file to Upload"  value="" accept="image/jpeg, image/jpg">
                                                    </div>
                                                </div> /// End Comment ////
                                                @if(isset($pictures[$i]))
                                                <div class="row">
                                                    <div class="oldpic col-md-12">
                                                        <label for="">Old Picture</label><br>
                                                        <img style="width:50%;height:50%;" src="{{ url('uploads/images') }}/{{ $pictures[$i]->path_pic }}" alt="" />
                                                        <input type="hidden" name="oldpicture[]" value="{{ $pictures[$i]->path_pic }}">
                                                        <input type="hidden" name="oldid_{{ $i }}" value="{{ $pictures[$i]->id }}">
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="form-group col-md-10">
                                                        <label for="picture_{{ $i }}">Picture</label>
                            							<input type="file" class="form-control col-md-11" id="picture_{{ $i }}" name="picture[]" placeholder="Name" accept="image/jpeg, image/jpg">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h2>
                                                            <button type="button" style="display: block; width: 100%;" class="btn btn-danger clearinput" name="button">Clear Select</button>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                            							<label for="catalog_number">Photographer</label>
                            							<input type="text" class="form-control" id="photographer" name="photographer_{{ $i }}" value="@if( isset($pictures[$i]) ){{ $pictures[$i]->photographer }}@endif" placeholder="Name">
                            						</div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                            							<label for="caption">Caption</label>
                            							<textarea class="form-control" rows="5" id="comment" name="caption_{{ $i }}" placeholder="Text">@if( isset($pictures[$i]) ){{ $pictures[$i]->caption }}@endif</textarea>
                            						</div>
                                                </div>

                                                @if(isset($pictures[$i]))
                                                    <div class="row">
                                                        <div class="">
                                                            <label for="">Delete this picture: </label>
                                                            <input type="hidden" name="del_{{ $i }}" value="">
                                                            <button class="btn btn-danger del-btn" type="button" name="button" data="{{ $pictures[$i]->id }}">Delete</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                            </div>
                        </div>



                    </div>
                    <div class="row" style="padding-top: 10px; padding-bottom: 20px;">
                        <div class="col-md-12">
                            <center>
                                <button type="submit" class="btn btn-default" name="button">Save Picture</button>
                            </center>
                        </div>
                    </div>
    	        </form>

            </div>

        </div>
    </div> -->
@endsection
