@extends('layouts.app')

@section('css')
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
    <style media="screen">
        html , body {
            font-family: Roboto, THSarabun, Serif;
        }
    </style>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-offset-2 col-md-8">
        <div class="content-box">
            <p class="content-header">ติดต่อเรา</p>
            <p class="content-help-text">กรุณาใช้แบบฟอร์มนี้ถ้าหากคุณต้องการแสดงความคิดเห็น หรือมีข้อสอบถามเราจะดำเนินการติดต่อคุณกลับอย่างเร็วที่สุด</p>

            <form class="" action="{{ url('user/contact/contactForm') }}" method="post">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header radio font-thai-resize">
                            ประเภทการติดต่อ
                            <label class="radio-inline font-thai-resize">
                                <input type="radio" name="contact_type" value="1" required="" > แสดงความคิดเห็น
                            </label>
                            <label class="radio-inline font-thai-resize">
                                <input type="radio" name="contact_type" value="2" required="" > ติดต่อสอบถาม
                            </label>
                        </p>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">Marine Center</p>
                        <select class="form-control search-report-select select2" name="mrct">
                            @foreach($mrcts as $mrct)
                                <option value="{{ $mrct->id }}"> {{ $mrct->marinecenter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header font-thai-resize">หัวข้อที่จะติดต่อ</p>
                        <input type="text" class="form-control font-thai-resize" name="topic" value="">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header font-thai-resize">ชื่อผู้ติดต่อ</p>
                        <input type="text" class="form-control font-thai-resize" name="user" value="{{ $name }}" readonly="">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header font-thai-resize">ข้อความ</p>
                        <textarea class="form-control font-thai-resize" name="message" rows="8"></textarea>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-12" style="text-align: center; padding-top: 10px;">
                        <button type="submit" class="btn btn-default btn-gold">ส่งข้อความ</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
