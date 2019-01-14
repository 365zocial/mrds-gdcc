@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
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
        $breadcump['View Record']   = url( 'staff/viewRecord', base64_encode( base64_encode( base64_encode( $record->id ))) );
        $breadcump['Edit Record']   = url( 'staff/editRecordForm/1/'.base64_encode( base64_encode( base64_encode( $record->id ))), base64_encode( base64_encode( base64_encode( $record->id ))) );
    ?>
@endsection

@section('script')
	<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
	<script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}">//for select2 script</script>

    <script type="text/javascript">
        $(document).ready(function() {
        	/* parsley */
        	$('#form').parsley();
    		$("#team_exploration_code").attr("required", "true");
    		$("#team_exploration_code").attr("data-parsley-focus", "first");

    		/* back button in browser */
    		history.pushState(null, null, 'editRecordFormTH');
    		window.addEventListener('popstate', function(event) {
    			history.pushState(null, null, 'editRecordFormTH');
    		});

            $('#soil_temperature').change(function(){
                var valueToParse = parseFloatOne1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#soil_ph').change(function(){
                var valueToParse = parseFloatTwo1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#water_temperature').change(function(){
                var valueToParse = parseFloatOne1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#transparency').change(function(){
                var valueToParse = parseFloatOne1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#water_ph').change(function(){
                var valueToParse = parseFloatTwo1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#dissolve_oxygen').change(function(){
                var valueToParse = parseFloatTwo1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#suspended_solid').change(function(){
                var valueToParse = parseFloatOne1place($(this).val());
                $(this).val(valueToParse);
            });

            $('#salinity').change(function(){
                var valueToParse = parseFloatOne1place($(this).val());
                $(this).val(valueToParse);
            });
        });

        /* select2 */
	    $(document).ready(function() {
            $(".select2").select2();
	    });

        function parseFloatTwo1place(input){
            return parseFloat(input).toFixed(2);
        }

        function parseFloatOne1place(input){
            return parseFloat(input).toFixed(1);
        }


    </script>
@endsection

@section('contain')
	<?php
		use App\Model\AllMean;
		use App\Model\Wording;
		use App\Model\Country;
		use App\Model\County;
		use App\Model\District;
		use App\Model\Province;
        use App\Model\Collection;
        $can_change_class = true;
	?>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <img class="image-progress-bar" src="{{ url('assets/images/progress_bar_edit/edit_step2.png') }}" />
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header">Edit Record <span style="text-transform:none;">(Thai Version)</span></p>
            <p class="content-help-text font-thai-resize">ช่องที่ไม่มีภาษาไทยสามารถกรอกเป็นภาษาอังกฤษได้ <span class="english-in-thai">(</span>ควรหลีกเลี่ยงเครื่องหมายเหล่านี้ <span class="english-in-thai">&, *, #, <, >, ", ', .)</span></p>

            <form id="form" action="{{ url('staff/doEditRecordFormTH') }}" method="post">
                @csrf
                <input type="hidden" name="classification_id" value="{{ $classification->id }}">

                <p class="search-report-dropdown-header font-thai-resize">ชื่อวิทยาศาสตร์ และข้อมูลต่างๆ</p>
                @include('staff.record.scientific_name_description')

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Marine Center</p>
                        <input type="text" class="form-control" id="marine_center" placeholder="{{ $marinecenter }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">กลุ่มสิ่งมีชีวิต</p>
                        <input type="text" class="form-control font-thai-resize" id="collection_code" placeholder="{{ Collection::getCollectionByID($record->collection_code)->name_th }}" readonly>
                    </div>
                    @if($record->source == 1)
                        <div class="col-md-4" id="specimen_part">
                            <p class="search-report-dropdown-header">Catalog Number</p>
                            <input type="text" class="form-control" id="catalog_number" placeholder="@if ($record->catalog_number != 0 && $record->catalog_number != null ) {{ $record->catalog_number }} @else - @endif" readonly >
                        </div>
                    @endif
                </div>

                @if($record->source == 2)
                    <div class="row row-inform">
                        <div class="col-md-12" id="publication_part">
                            <p class="search-report-dropdown-header font-thai-resize">เอกสาร</p>
                            <input type="text" class="form-control font-thai-resize" id="reference" placeholder="@if ($record->reference != 0 && $record->reference != null ) {{ Wording::getWording($record->reference)->name_th }} @else - @endif" readonly>
                        </div>
                    </div>
                    <div class="row row-inform">
                        <div class="col-md-4">
                            <p class="search-report-dropdown-header font-thai-resize">หน้า</p>
                            <input type="text" class="form-control" id="page" placeholder="@if ( $record->page != 0 && $record->page != null ) {{ $record->page }} @else - @endif" readonly>
                        </div>
                        <div class="col-md-4">
                            <p class="search-report-dropdown-header">No. Species</p>
                            <input type="text" class="form-control" id="no_species" placeholder="@if ( $record->no_species != 0 && $record->no_species != null ) {{ $record->no_species }} @else - @endif" readonly>
                        </div>
                        <div class="col-md-4">
                            <p class="search-report-dropdown-header">No. Locality</p>
                            <input type="text" class="form-control" id="no_locality" placeholder="@if ( $record->no_locality != 0 && $record->no_locality != null ) {{ $record->no_locality }} @else - @endif" readonly>
                        </div>
                    </div>
                @endif

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">Variety Name</p>
                        <input type="text" class="form-control" id="variety_name" name="variety_name" placeholder="Text Input" @if ( $record->variety_name != null && $record->variety_name != '' ) value="{{ $record->variety_name }}" @endif >
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header">Type Status</p>
                        <input type="text" class="form-control font-thai-resize" id="type_status" placeholder="@if ( $record->type_status != 0 && $record->type_status != null ){{ Wording::getWording($record->type_status)->name_th }}@else - @endif" readonly>
                    </div>
                    <div class="col-md-8">
                        <p class="search-report-dropdown-header font-thai-resize">จำนวนตัวอย่างที่เก็บ</p>
                        <input type="number" class="form-control" id="individual_count" placeholder=" @if ( $record->individual_count != 0 && $record->individual_count != null ) {{ $record->individual_count }} @else - @endif " readonly>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">เพศ</p>
                        <input type="text" class="form-control font-thai-resize" id="sex" placeholder=" @if ( $record->sex != 0 && $record->sex != null ) {{ Wording::getWording($record->sex)->name_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-8">
                        <p class="search-report-dropdown-header font-thai-resize">ขนาดที่พบ</p>
                        <input type="text" step="any" class="form-control" name="size" id="size" placeholder="Text Input" @if ( $record->size != 0 && $record->size != null ) value="{{ $record->size }}" @endif>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ระยะการเจริญเติบโตที่พบ</p>
                        <input type="text" class="form-control font-thai-resize" id="life_stage" placeholder=" @if ( $record->life_stage != 0 && $record->life_stage != null ) {{ Wording::getWording($record->life_stage)->name_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">มหาสมุทร <span class="english-in-thai">/</span> ทะเล <span class="english-in-thai">/</span> ทะเลสาบ</p>
                        <input type="text" class="form-control font-thai-resize" id="ocean_sea_lake" placeholder=" @if ( $record->ocean_sea_lake != 0 && $record->ocean_sea_lake != null ) {{ Wording::getWording($record->ocean_sea_lake)->name_th }} @else - @endif " readonly>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ประเทศ</p>
                        <input type="text" class="form-control font-thai-resize" id="country" placeholder=" @if ( $record->country != 0 && $record->country != null ) {{ Country::getCountryWording($record->country)->country_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">จังหวัด</p>
                        <input type="text" class="form-control font-thai-resize" id="province" placeholder=" @if ( $record->province != 0 && $record->province != null ) {{ Province::getProvinceWording($record->province)->province_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">อำเภอ</p>
                        <input type="text" class="form-control font-thai-resize" id="district" placeholder=" @if ( $record->district != 0 && $record->district != null ) {{ District::getDistrictWording($record->district)->district_th }} @else - @endif " readonly>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ตำบล</p>
                        <input type="text" class="form-control font-thai-resize" id="county" placeholder=" @if ( $record->county != 0 && $record->county != null ) {{ County::getCountyWording($record->county)->county_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-8">
                        <p class="search-report-dropdown-header font-thai-resize">สถานที่</p>
                        <input type="text" class="form-control" id="locality" name="locality" placeholder="Text Input" value="{{ $record->locality }}">
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <div class="panel panel-primary panel-custom">
                            <div class="panel-heading font-thai-resize">
                                <p class="panel-title font-thai-resize">พิกัด ตำแหน่ง ที่พบ</p>
                            </div>
                            <div class="panel-body">

                                <div class="row row-inform">
                                    <div class="col-md-6">
                                        <p class="search-report-dropdown-header font-thai-resize">ละติจูด</p>
                                        <input type="text" class="form-control" id="lat" placeholder=" @if ( $record->latitude != null ) {{ $record->latitude }} @else - @endif " readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="search-report-dropdown-header font-thai-resize">ลองจิจูด</p>
                                        <input type="text" class="form-control" id="long" placeholder=" @if ( $record->longitude != null ) {{ $record->longitude }} @else - @endif " readonly>
                                    </div>
                                </div>

                                <hr class="view-record-line manage-record">

                                <div class="row row-inform">
                                    <div class="col-md-6">
                                        <p class="search-report-dropdown-header font-thai-resize">ละติจูดเริ่มต้น</p>
                                        <input type="text" class="form-control" id="start_lat" placeholder=" @if ( $record->start_latitude != null ) {{ $record->start_latitude }} @else - @endif " readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="search-report-dropdown-header font-thai-resize">ละติจูดสิ้นสุด</p>
                                        <input type="text" class="form-control" id="end_lat" placeholder=" @if ( $record->end_latitude != null ) {{ $record->end_latitude }} @else - @endif " readonly>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-6">
                                        <p class="search-report-dropdown-header font-thai-resize">ลองจิจูดเร่ิมต้น</p>
                                        <input type="text" class="form-control" id="start_long" placeholder=" @if ( $record->start_longitude != null ) {{ $record->start_longitude }} @else - @endif " readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="search-report-dropdown-header font-thai-resize">ลองจิจูดสิ้นสุด</p>
                                        <input type="text" class="form-control" id="end_long" placeholder=" @if ( $record->end_longitude != null ) {{ $record->end_longitude }} @else - @endif " readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ระบบนิเวศที่อาศัย</p>
                        <input type="text" class="form-control font-thai-resize" id="habitat" placeholder=" @if ( $record->habitat != 0 && $record->habitat != null ) {{ Wording::getWording($record->habitat)->name_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ความลึก (ความลึกเร่ิมต้น)</p>
                        <input type="text" class="form-control" id="depth" placeholder=" @if ( $record->depth_start != 0 && $record->depth_start != null ) {{ $record->depth_start }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ความลึกสุดท้าย</p>
                        <input type="text" class="form-control" id="depth_end" placeholder=" @if ( $record->depth_end != 0 && $record->depth_end != null ) {{ $record->depth_end }} @else - @endif " readonly>
                    </div>
                </div>

                <!-- ในภาษาไทย ทางผู้พัฒนาไม่ได้ทำฟอร์มไว้ ซึ่งฟอร์มนี้อ้างอิงจากภาษาอังกฤษ
                <div class="row row-inform">
                <div class="col-md-8">
                <p class="search-report-dropdown-header font-thai-resize">ผู้เก็บตัวอย่าง</p>
                <input type="text" class="form-control" id="collector" name="collector" maxlength="255" placeholder="Name" @if ( $record->collector != null ) value="{{ $record->collector }}" @endif readonly>
                </div>
                <div class="col-md-4">
                <p class="search-report-dropdown-header font-thai-resize">วันที่เก็บตัวอย่าง</p>
                <input type="text" class="form-control" id="collected_date" name="collected_date" placeholder="Calendar" @if ( $record->collected_date != null ) value="{{ Allmean::ReplaceNullWithDefaultDate( $record->collected_date ) }}" @endif readonly>
                </div>
                </div>

                <div class="row row-inform">
                <div class="col-md-8">
                <p class="search-report-dropdown-header font-thai-resize">ผู้จำแนกชนิด</p>
                <input type="text" class="form-control" id="cur_identifier" name="cur_identifier" maxlength="255" placeholder="Name" @if ( $record->identifier != null ) value="{{ $record->identifier }}" @endif readonly>
                </div>
                <div class="col-md-4">
                <p class="search-report-dropdown-header font-thai-resize">วันที่จำแนกชนิด</p>
                <input type="text" class="form-control" id="cur_identified_date" name="cur_identified_date" placeholder="Calendar" @if ( $record->identified_date != null ) value="{{ Allmean::ReplaceNullWithDefaultDate( $record->identified_date ) }}" @endif readonly>
                </div>
                </div>

                <div class="row row-inform">
                <div class="col-md-8">
                <p class="search-report-dropdown-header font-thai-resize">ผู้ที่จำแนกชนิดก่อนหน้านี้</p>
                <input type="text" class="form-control" id="prev_identifier" name="prev_identifier" maxlength="255" placeholder="Name" @if ( $record->previous_identifier != null ) value="{{ $record->previous_identifier }}" @endif readonly>
                </div>
                <div class="col-md-4">
                <p class="search-report-dropdown-header font-thai-resize">วันที่จำแนกชนิดก่อนหน้านี้</p>
                <input type="text" class="form-control" id="prev_identified_date" name="prev_identified_date" placeholder="Calendar" @if ( $record->previous_identified_date != null ) value="{{ Allmean::ReplaceNullWithDefaultDate( $record->previous_identified_date ) }}" @endif readonly>
                </div>
                </div>
                -->

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">อุปกรณ์ / วิธีการ</p>
                        <input type="text" class="form-control" id="gear_method" placeholder=" @if ( $record->gear_method != 0 && $record->gear_method != null ) {{ Wording::getWording($record->gear_method)->name_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                    <p class="search-report-dropdown-header font-thai-resize">วิธีเก็บรักษา</p>
                        <input type="text" class="form-control font-thai-resize" id="preparation_type" placeholder=" @if ( $record->preparation_type != 0 && $record->preparation_type != null ) {{ Wording::getWording($record->preparation_type)->name_th }} @else - @endif " readonly>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">โครงการสำรวจหรือวิจัย</p>
                        <input type="text" class="form-control font-thai-resize" id="expedition" placeholder=" @if ( $record->expedition != 0 && $record->expedition != null ) {{ Wording::getWording($record->expedition)->name_th }} @else - @endif " readonly>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">หมายเลขทะเบียนใน <span style="font-size: 16px;">GeneBank</span></p>
                        <input type="text" class="form-control" name="gene_bank_number" id="gene_bank_number" placeholder="Text Input" @if ( $record->gene_bank_number != null ) value="{{ $record->gene_bank_number }}" @endif>
                    </div>
                    <div class="col-md-8">
                        <p class="search-report-dropdown-header font-thai-resize">ลักษณะเด่นหรือคุณสมบัติพิเศษ</p>
                        <input type="text" class="form-control" name="diagnosis" id="diagnosis" placeholder="Text Input" @if ( $record->diagnosis != null ) value="{{ $record->diagnosis }}" @endif>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header font-thai-resize">คุณลักษณะอื่นๆ</p>
                        <textarea class="form-control" name="description" id="description" rows="10" placeholder="Text Input">@if ( $record->description != null ){{ $record->description }}@endif</textarea>
                    </div>
                </div>

                <hr class="view-record-line manage-record thai-page">

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ชื่อพื้นเมือง</p>
                        <input type="text" class="form-control" id="local_name" name="local_name" placeholder="Text Input" @if ( $record->local_name != null ) value="{{ $record->local_name }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ชื่อท้องถิ่น (ชื่อพื้นบ้าน)</p>
                        <input type="text" class="form-control" id="vernacular_name" name="vernacular_name" placeholder="Text Input" @if ( $record->vernacular_name != null ) value="{{ $record->vernacular_name }}" @endif>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">รหัสทีมสำรวจ <span class="required font-thai-resize">*จำเป็นต้องกรอก</span></p>
                        <select class="form-control search-report-select select2" id="team_exploration_code" name="team_exploration_code" required>
                            @if( count($team_exploration_codes) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($team_exploration_codes as $team_exploration_code)
                                    <option value="{{ $team_exploration_code->id }}" @if( $record->team_exploration_code == $team_exploration_code->id ){{ "selected" }}@endif >{{ $team_exploration_code->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-8">
                        <p class="search-report-dropdown-header font-thai-resize">พื้นที่สำรวจ</p>
                        <select class="form-control search-report-select select2" id="area_exploration" name="area_exploration">
                        @if( count($area_explorations) !== 0 )
                            <option value="" selected disabled>Select</option>
                            @foreach($area_explorations as $area_exploration)
                                <option value="{{ $area_exploration->id }}" @if( $record->area_exploration == $area_exploration->id ){{ "selected" }}@endif >{{ $area_exploration->name_th }}</option>
                            @endforeach
                        @else
                            <option value="" selected>No list in select</option>
                        @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">หมู่บ้าน (หมู่ที่...)</p>
                        <input type="number" class="form-control" id="village_no" name="village_no" placeholder="Number Input" @if ( $record->village_no != null ) value="{{ $record->village_no }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">สถานที่พบอยู่ทางทิศ</p>
                        <select class="form-control search-report-select select2" id="area_direction" name="area_direction">
                            @if( count($area_directions) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($area_directions as $area_direction)
                                    <option value="{{ $area_direction->id }}" @if( $record->area_direction == $area_direction->id ){{ "selected" }}@endif >{{ $area_direction->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ของสถานที่ <span style="font-size: 16px;">(Area)</span></p>
                        <input type="text" class="form-control" id="area" name="area" placeholder="Text Input" @if ( $record->area != null ) value="{{ $record->area }}" @endif>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header font-thai-resize">การใช้ประโยชน์</p>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="1" @if(in_array(1,$utilizations)){{ "checked" }}@endif> ความเพลิดเพลิน
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="2" @if(in_array(2,$utilizations)){{ "checked" }}@endif> การค้่า
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="3" @if(in_array(3,$utilizations)){{ "checked" }}@endif> ใช้แรงงาน
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="4" @if(in_array(4,$utilizations)){{ "checked" }}@endif> อาหาร
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="5" @if(in_array(5,$utilizations)){{ "checked" }}@endif> ยา
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="6" @if(in_array(6,$utilizations)){{ "checked" }}@endif> ศึกษาวิจัย
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="7" @if(in_array(7,$utilizations)){{ "checked" }}@endif> เครื่องนุ่งห่ม
                        </label>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="utilization" name="utilization[]" value="8" @if(in_array(8,$utilizations)){{ "checked" }}@endif> สวยงาม
                        </label>

                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header font-thai-resize">ผู้ให้ข้อมูล</p>
                        <input type="text" class="form-control" id="recorder" name="recorder" placeholder="Text Input" value="{{ $record->recorder }}">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header font-thai-resize">ภูมิปัญญาชาวบ้าน</p>
                        <textarea class="form-control" id="folk_wisdom" name="folk_wisdom" rows="10" placeholder="Text Input">@if ( $record->folk_wisdom != null ){{ $record->folk_wisdom }}@endif</textarea>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header font-thai-resize">หมายเหตุของภูมิปัญญา</p>
                        <textarea class="form-control" id="knowledge_remarks" name="knowledge_remarks" rows="10" placeholder="Text Input">@if ( $record->knowledge_remarks != null ){{ $record->knowledge_remarks }}@endif</textarea>
                    </div>
                </div>

                <hr class="view-record-line manage-record thai-page">

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">อุณหภูมิ น้ำ <span style="font-size: 16px;">(</span>องศา <span style="font-size: 16px;">C)</span></p>
                        <input type="number" step="0.1" class="form-control 1placedecumal" id="water_temperature" maxlength="255" name="water_temperature" placeholder="Number" @if ( $record->water_temperature != null ) value="{{ $record->water_temperature }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ความโปร่งแสงของน้ำ <span style="font-size: 16px;">(m/cm)</span></p>
                        <input type="number" step="0.1" class="form-control 1placedecumal" id="transparency" maxlength="255" name="transparency" placeholder="Number" @if ( $record->transparency != null ) value="{{ $record->transparency }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ความเป็นกรด-ด่าง น้ำ <span style="font-size: 16px;">(pH)</span></p>
                        <input type="number" step="0.01" class="form-control 2placedecumal" id="water_ph" maxlength="255" name="water_ph" placeholder="Number" @if ( $record->water_ph != null ) value="{{ $record->water_ph }}" @endif>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize double-line">ปริมาณออกซิเจนละลายน้ำ <span style="font-size: 16px;">(mg/L)</span></p>
                        <input type="number" step="0.01" class="form-control 2placedecumal" id="dissolve_oxygen" maxlength="255" name="dissolve_oxygen" placeholder="Number" @if ( $record->dissolve_oxygen != null ) value="{{ $record->dissolve_oxygen }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize double-line">ปริมาณของแข็งแขวนลอย <span style="font-size: 16px;">(mg/L)</span></p>
                        <input type="number" step="0.1" class="form-control 1placedecumal" id="suspended_solid" name="suspended_solid" maxlength="255" placeholder="Number" @if ( $record->suspended_solid != null ) value="{{ $record->suspended_solid }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ค่าความเค็ม <span style="font-size: 16px;">(ppt)</span></p>
                        <input type="number" step="0.1" class="form-control 1placedecumal" id="salinity" name="salinity" maxlength="255" placeholder="Number" @if ( $record->salinity != null ) value="{{ $record->salinity }}" @endif>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" id="specimen_collection" name="specimen_collection" value="1" @if ( $record->specimen_collection != 0 && $record->specimen_collection != null ) checked @endif> การเก็บตัวอย่าง
                        </label>
                        <label class="checkbox-inline font-thai-resize">
                            <input class="font-thai-resize" type="checkbox" id="specimen_photograph" name="specimen_photograph" value="1" @if ( $record->specimen_photograph != 0 && $record->specimen_photograph != null ) checked @endif> การบันทึกภาพ
                        </label>
                        </p>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header font-thai-resize">ถิ่นอาศัยที่พบ</p>
                        <p class="search-report-dropdown-header">
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="1" @if(in_array(1,$places)){{ "checked" }}@endif> น้ำจืด
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="2" @if(in_array(2,$places)){{ "checked" }}@endif> น้ำกร่อย
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="3" @if(in_array(3,$places)){{ "checked" }}@endif> ทะเล
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="4" @if(in_array(4,$places)){{ "checked" }}@endif> ภูเขา
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="5" @if(in_array(5,$places)){{ "checked" }}@endif> บนต้นไม้
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="6" @if(in_array(6,$places)){{ "checked" }}@endif> หน้าดิน
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="7" @if(in_array(7,$places)){{ "checked" }}@endif> ในดิน
                            </label>
                            <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                                <input class="font-thai-resize" type="checkbox" id="place" name="place[]" value="8" @if(in_array(8,$places)){{ "checked" }}@endif> บนบก
                            </label>
                        </p>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ประเภทของพืช</p>
                        <select class="form-control search-report-select select2" id="plant_type" name="plant_type">
                            @if( count($plant_types) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($plant_types as $plant_type)
                                    <option value="{{ $plant_type->id }}" @if( $record->plant_type == $plant_type->id ){{ "selected" }}@endif >{{ $plant_type->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ประเภทของสัตว์ <span style="font-size: 16px;">(Type1)</span></p>
                        <select class="form-control search-report-select select2" id="animal_type1" name="animal_type1">
                            @if( count($animal_type1s) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($animal_type1s as $animal_type1)
                                    <option value="{{ $animal_type1->id }}" @if( $record->animal_type1 == $animal_type1->id ){{ "selected" }}@endif >{{ $animal_type1->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ประเภทของสัตว์ <span style="font-size: 16px;">(Type2)</span></p>
                        <select class="form-control search-report-select select2" id="animal_type2" name="animal_type2">
                            @if( count($animal_type2s) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($animal_type2s as $animal_type2)
                                    <option value="{{ $animal_type2->id }}" @if( $record->animal_type2 == $animal_type2->id ){{ "selected" }}@endif >{{ $animal_type2->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">ประเภทของสัตว์ <span style="font-size: 16px;">(Type3)</span></p>
                        <select class="form-control search-report-select select2" id="animal_type3" name="animal_type3">
                            @if( count($animal_type3s) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($animal_type3s as $animal_type3)
                                    <option value="{{ $animal_type3->id }}" @if( $record->animal_type3 == $animal_type3->id ){{ "selected" }}@endif >{{ $animal_type3->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <p class="search-report-dropdown-header font-thai-resize">การสืบพันธุ์</p>
                        <label class="checkbox-inline font-thai-resize" style="margin-left: 0px !important;">
                            <input class="font-thai-resize" type="checkbox" name="sexual" value="1" @if(strpos($record->reproduction, "1") !== false){{ "checked" }} @endif> อาศัยเพศ
                        </label>
                        <label class="checkbox-inline font-thai-resize">
                            <input class="font-thai-resize" type="checkbox" name="asexual" value="2" @if(strpos($record->reproduction, "2") !== false){{ "checked" }} @endif> ไม่อาศัยเพศ
                        </label>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header font-thai-resize">ความคุ้มครอง <span style="font-size: 16px;">(ตามกฎหมายไทย)</span></p>
                        <select class="form-control search-report-select select2" id="protection_type" name="protection_type">
                            @if( count($protection_types) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($protection_types as $protection_type)
                                    <option value="{{ $protection_type->id }}" @if( $record->protection_type == $protection_type->id ){{ "selected" }}@endif >{{ $protection_type->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <p class="search-report-dropdown-header font-thai-resize">ความคุ้มครอง <span style="font-size: 16px;">(IUCN)</span></p>
                        <select class="form-control search-report-select select2" id="protection_type_iucn" name="protection_type_iucn">
                            @if( count($protection_type_iucns) !== 0 )
                                <option value="" selected disabled>Select</option>
                                @foreach($protection_type_iucns as $protection_type_iucn)
                                    <option value="{{ $protection_type_iucn->id }}" @if( $record->protection_type_iucn == $protection_type_iucn->id ){{ "selected" }}@endif >{{ $protection_type_iucn->name_th }}</option>
                                @endforeach
                            @else
                                <option value="" selected>No list in select</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 search-report-button" style="text-align: center">
                        <button type="submit" class="btn btn-default btn-gold" style="font-size: 16px;">Save Thai Record</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
