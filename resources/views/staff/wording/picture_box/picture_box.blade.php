@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        .bottom-pad-box {
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">
		$(document).ready(function() {



		} );
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
        $breadcump['Picture Box'] = url('staff/wording/pictureBox');
    ?>
@endsection

@section('contain')

@include('alert')

<div class="row row-with-margin">

    <div class="col-md-8 col-md-offset-2 bottom-pad-box">
        <div class="content-box">
            <label class="content-help-text" style="color: red;">
                หมายเหตุ: Function นี้มีไว้สำหรับแก้ไขภาพแรกในหน้า Login ด้านล่าง 3 ภาพ
                โดย #1 Picture Box จะเป็นภาพทางด้านซ้าย, #2 Picture Box จะเป็นภาพตรงกลาง
                และ #3 Picture Box จะเป็นภาพทางด้านขวา
            </label>
        </div>
    </div>

    @if(session('success'))
        <div class="col-md-12">
            <center>
                <div class="alert alert-success">
                    <p>{!! session('success') !!}</p>
                </div>
            </center>
        </div>
    @endif

    <div class="col-md-8 col-md-offset-2 bottom-pad-box">
        <div class="content-box">
            <p class="content-header">#1 Picture Box</p>
            <p class="content-help-text">ภาพที่แสดงจะเป็นภาพที่เกี่ยวข้องกับรายละเอียดของ Record</p>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('staff/wording/doUpdatePictureBox/1') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="picture_file">File input</label>
                            <input type="file" name="picture_file">
                            <p class="help-block">รองรับ jpg file ในอัตราส่วน 4:3 เช่น 720 x 540 px</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default btn-gold">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-responsive img-rounded" src="{{ url('assets/images/first_page_record',$data[0]->pic) }}" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-md-offset-2 bottom-pad-box">
        <div class="content-box">
            <p class="content-header">#2 Picture Box</p>
            <p class="content-help-text">ภาพที่แสดงจะเป็นภาพตัวอย่างของ Specimens</p>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('staff/wording/doUpdatePictureBox/2') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="picture_file">File input</label>
                            <input type="file" name="picture_file">
                            <p class="help-block">รองรับ jpg file ในอัตราส่วน 4:3 เช่น 720 x 540 px</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default btn-gold">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-responsive img-rounded" src="{{ url('assets/images/first_page_record',$data[1]->pic) }}" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-md-offset-2 bottom-pad-box">
        <div class="content-box">
            <p class="content-header">#3 Picture Box</p>
            <p class="content-help-text">ภาพที่แสดงจะเป็นตารางที่ได้รับจากการสืบค้น</p>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('staff/wording/doUpdatePictureBox/3') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="picture_file">File input</label>
                            <input type="file" name="picture_file">
                            <p class="help-block">รองรับ jpg file ในอัตราส่วน 4:3 เช่น 720 x 540 px</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default btn-gold">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-responsive img-rounded" src="{{ url('assets/images/first_page_record',$data[2]->pic) }}" />
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
