@extends('layouts.app')

@section('css')
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">
@endsection

@section('script')
    <script src="{{ URL::asset('assets/script/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
@endsection

@section('header')
    <?php
        $headerName = "Contact Admin";
        $iconFileName = "icon_dashboard_manager/contact_admin.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('user/dashboard');
        $breadcump['Contact Admin'] = url('user/contact/contactForm');
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-offset-2 col-md-8">
        <div class="content-box">
            <p class="content-header">
                @if($lang == 2)
                    ติดต่อเรา
                @else
                    Contact US
                @endif
            </p>
            <p class="content-help-text">
                @if($lang == 2)
                    กรุณาใช้แบบฟอร์มนี้ถ้าหากคุณต้องการแสดงความคิดเห็น หรือมีข้อสอบถามเราจะดำเนินการติดต่อคุณกลับอย่างเร็วที่สุด
                @else
                    Please use this form if you have any comment or question. We'll get back with your email very soon.
                @endif
            </p>

            <form class="" action="{{ url('user/contact/contactForm') }}" method="post">
                @csrf

                <div class="row row-inform">
                    <div class="col-md-12">
                        <!-- <p class="search-report-dropdown-header">&nbsp;</p> -->
                        <p class="search-report-dropdown-header radio">
                            @if($lang == 2)
                                ประเภทการติดต่อ
                            @else
                                Select Type
                            @endif

                            <label class="radio-inline">
                                <input type="radio" name="contact_type" value="1" required="" checked>
                                @if($lang == 2)
                                    แสดงความคิดเห็น
                                @else
                                    Comment
                                @endif

                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="contact_type" value="2" required="" >
                                @if($lang == 2)
                                    ติดต่อสอบถาม
                                @else
                                    Question?
                                @endif

                            </label>
                        </p>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">
                            Marine Center
                        </p>
                        <select class="form-control search-report-select select2" name="mrct">
                            @foreach($mrcts as $mrct)
                                <option value="{{ $mrct->id }}"> {{ $mrct->marinecenter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                หัวข้อที่จะติดต่อ
                            @else
                                Subject Name
                            @endif

                        </p>
                        <input type="text" class="form-control" name="topic" value="">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                            @if($lang == 2)
                                ชื่อผู้ติดต่อ
                            @else
                                Name
                            @endif

                        </p>
                        <input type="text" class="form-control" name="user" value="{{ $name }}" readonly="">
                    </div>
                </div>

                <div class="row row-inform">
                    <div class="col-md-12">
                        <p class="search-report-dropdown-header">
                            @if($lang == 2)
                                ข้อความ
                            @else
                                Message
                            @endif

                        </p>
                        <textarea class="form-control" name="message" rows="8"></textarea>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-md-12" style="text-align: center; padding-top: 10px;">
                        <button type="submit" class="btn btn-default btn-gold">
                            @if($lang == 2)
                                ส่งข้อความ
                            @else
                                Sent Message
                            @endif
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
