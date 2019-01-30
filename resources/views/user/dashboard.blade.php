@extends('layouts.app_user')

@section('css')
    @include('base_wording_css')
    <link href="<?php echo url('assets/fonts/THSarabunNew/THSarabunNew.ttf'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo url('assets/fonts/THSarabunNew/THSarabunNewBold.ttf'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo url('assets/fonts/THSarabunNew/THSarabunNewBoldItalic.ttf'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo url('assets/fonts/THSarabunNew/THSarabunNewItalic.ttf'); ?>" rel="stylesheet" type="text/css">
    <style media="screen">
        .font-th-header {
            font-size: 24px !important;
            font-family: THSarabunNewBold;
            font-weight: 600 !important;
            color: #636363;
            opacity: 0.8;
        }
        .font-th-content {
            font-size: 26px !important;
            font-family: THSarabunNew;
            color: #636363;
            opacity: 0.6;
            line-height: 1.75 !important;
            text-align: justify;
        }
        @media (max-width: 768px) {
            .font-th-header, .font-th-content {
                padding: 0 15px;
            }
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        })
    </script>
@endsection

@section('contain')

<div class="row">
    <div class="col-md-12">

        <div class="row row-with-margin" style="padding-top: 20px;">
            <div class="col-md-12">
                <p class="content-header" style="font-size: 24px !important;">
                    @if( $lang == 2)
                        ระบบฐานข้อมูลสิ่งมีชีวิตทางทะเล
                    @else
                        Marine Resource Database System
                    @endif
                </p>
                <p class="content-help-text" style="text-align: center; font-size: 18px !important;">
                    @if( $lang == 2)
                        คุณสามารถสืบค้นข้อมูลที่คุณต้องการจากหัวข้อเหล่านี้
                    @else
                        You can search for your required information by these topics.
                    @endif
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="col-12">
                <center>
                    <div class="alert alert-success">
                        <p>{!! session('success') !!}</p>
                    </div>
                </center>
            </div>
        @endif
        @if(session('failure'))
            <div class="col-12">
                <center>
                    <div class="alert alert-danger">
                        <p>{!! session('failure') !!}</p>
                    </div>
                </center>
            </div>
        @endif

        <div class="row" style="margin-top: 5%; margin-bottom: 30px;">

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/diversity') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/diversity_search.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นข้อมูลความหลากหลาย
                            @else
                                Diversity Search
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/distribution') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/distribution_search.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นการกระจายของสิ่งมีชีวิต
                            @else
                                Distribution Search
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/recentrecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/recent_record.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นรายการลงทะเบียน
                                <br>&nbsp;
                            @else
                                Recent Record
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('search/NameRecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/name_search.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if( $lang == 2)
                                สืบค้นรายการจากชื่อ
                                <br>&nbsp;
                            @else
                                Name Record
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

        </div>

        <div class="row" style="margin-top: 5%; margin-bottom: 30px;">

            <div class="col-md-3 menu-box">
                <a class="box-link" href="{{ url('referenceLoan') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/word_in_system.png") }}' />
                        </div>
                        <p class="menu-text">
                            @if($lang == 2)
                                รายชื่อหนังสือ และเอกสารอ้างอิง
                            @else
                                References
                            @endif
                            <br>&nbsp;
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 menu-box">
              <a class="box-link" href="#" data-toggle="modal" data-target="#myModal">
                <div class="menu-icon-box">
                    <div class="icon-box">
                        <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/loan_specimen.png") }}' />
                    </div>
                    <p class="menu-text">
                        @if(Session::get('language') == 2)
                            การขอยืมตัวอย่าง
                            <br>&nbsp;
                        @else
                            Loan Specimen
                        @endif
                        <br>&nbsp;
                    </p>
                </div>
              </a>
            </div>

        </div>

        <div class="row row-with-margin" style="padding-top: 30px;">
                <p class="content-header font-th-header" style="text-align: left;">
                    @if(Session::get('language') == 2)
                        ระบบฐานข้อมูลสิ่งมีชีวิตทางทะเล (Marine Resource Database System - MRDS)
                    @else
                        Marine Resource Database System (MRDS)
                    @endif
                </p>
                <p class="menu-text font-th-content">
                    @if(Session::get('language') == 2)
                        เป็นระบบสารสนเทศของข้อมูลตัวอย่างสิ่งมีชีวิตทางทะเล
                        ทั้งที่มีตัวอย่างอ้างอิงและที่อ้างอิงจากผลงานตีพิมพ์
                        ของสถาบันวิจัยและพัฒนาทรัพยากรทางทะเล ชายฝั่งทะเล และป่าชายเลน
                        ซึ่งประกอบด้วยข้อมูลของศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทั้ง ๕ ศูนย์
                        ได้แก่ ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยฝั่งตะวันออก (ศวทอ.)
                        ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนบน (ศวทบ.)
                        ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนกลาง (ศวทก.)
                        ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนล่าง (ศวทล.)
                        และศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทะเลอันดามัน (ศวทม.)
                        ระบบจะทำการบันทึกข้อมูลจากทุกศูนย์ มาจัดเก็บและจัดทำเป็นฐานข้อมูลเดียวกัน
                        เพื่อนำไปใช้ประโยชน์ร่วมกันทั้งในด้านการวิจัยและเพื่อการศึกษา
                        และเพื่อให้สามารถเชื่อมโยงฐานข้อมูลดังกล่าวกับศูนย์ข้อมูลพันธุกรรมพืช
                        โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริ สมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี (อพ.สธ.) ได้
                    @else
                        เป็นระบบสารสนเทศของข้อมูลตัวอย่างสิ่งมีชีวิตทางทะเล
                        ทั้งที่มีตัวอย่างอ้างอิงและที่อ้างอิงจากผลงานตีพิมพ์
                        ของสถาบันวิจัยและพัฒนาทรัพยากรทางทะเล ชายฝั่งทะเล และป่าชายเลน
                        ซึ่งประกอบด้วยข้อมูลของศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทั้ง ๕ ศูนย์
                        ได้แก่ ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยฝั่งตะวันออก (ศวทอ.)
                        ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนบน (ศวทบ.)
                        ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนกลาง (ศวทก.)
                        ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนล่าง (ศวทล.)
                        และศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทะเลอันดามัน (ศวทม.)
                        ระบบจะทำการบันทึกข้อมูลจากทุกศูนย์ มาจัดเก็บและจัดทำเป็นฐานข้อมูลเดียวกัน
                        เพื่อนำไปใช้ประโยชน์ร่วมกันทั้งในด้านการวิจัยและเพื่อการศึกษา
                        และเพื่อให้สามารถเชื่อมโยงฐานข้อมูลดังกล่าวกับศูนย์ข้อมูลพันธุกรรมพืช
                        โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริ สมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี (อพ.สธ.) ได้
                    @endif
                </p>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    @if(Session::get('language') == 2)
                        การขอยืมตัวอย่าง
                    @else
                        Loan Specimen
                    @endif
                </h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12" style="padding-bottom: 10px;">
                    @if(Session::get('language') == 2)
                        <p style="font-size: 16px;">กรุณากรอกรายละเอียดเพื่อติดต่อขอยืมตัวอย่าง เจ้าหน้าที่จะติดต่อกลับอย่างเร็วที่สุด</p>
                    @else
                        <p style="font-size: 16px;">Please complete this form for borrow our example. Our team will be get in touch as soon as possible.</p>
                    @endif
                </div>
                <form class="form-horizontal" role="form" method="post" action="{{ url('sendEmailToAdmin') }}">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="-gender">@if(Session::get('language') == 2) จากอีเมล* @else From Email* @endif:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="from_email" maxlength="255" placeholder="@if(Session::get('language') == 2) กรุณากรอกอีเมลเพื่อติดต่อกลับ @else Enter your email @endif" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="-gender">@if(Session::get('language') == 2) ชื่อผู้ติดต่อ* @else Name* @endif:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" maxlength="255" placeholder="@if(Session::get('language') == 2) กรุณากรอกชื่อ @else Enter your name @endif" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="-address">@if(Session::get('language') == 2) ข้อความ* @else Message* @endif:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="message" rows="10" placeholder="@if(Session::get('language') == 2) กรุณากรอกข้อความ @else Enter your message @endif" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-default">@if(Session::get('language') == 2) ยืนยัน @else Submit @endif</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
