@extends('layouts.app_user')

@section('css')
    @include('base_wording_css')
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
                <p class="content-header">
                    @if( $lang == 2)
                        ระบบฐานข้อมูลสิ่งมีชีวิตทางทะเล
                    @else
                        Marine Resource Database System
                    @endif
                </p>
                <p class="content-help-text" style="text-align: center;">
                    @if( $lang == 2)
                        คุณสามารถสืบค้นข้อมูลที่คุณต้องการจากหัวข้อเหล่านี้
                    @else
                        You can search for your required information by these topics.
                    @endif
                </p>
            </div>
        </div>

        <div class="row row-with-margin" style="padding-top: 20px;">
            <div class="col-md-12" style="text-align: center;">
                ระบบฐานข้อมูลสิ่งมีชีวิตทางทะเล (Marine Resource Database System - MRDS) <br>
                เป็นระบบสารสนเทศของข้อมูลตัวอย่างสิ่งมีชีวิตทางทะเล <br>
                ทั้งที่มีตัวอย่างอ้างอิงและที่อ้างอิงจากผลงานตีพิมพ์ <br>
                ของสถาบันวิจัยและพัฒนาทรัพยากรทางทะเล ชายฝั่งทะเล และป่าชายเลน <br>
                ซึ่งประกอบด้วยข้อมูลของศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทั้ง ๕ ศูนย์ <br>
                ได้แก่ ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยฝั่งตะวันออก (ศวทอ.) <br>
                ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนบน (ศวทบ.) <br>
                ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนกลาง (ศวทก.) <br>
                ศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งอ่าวไทยตอนล่าง (ศวทล.) <br>
                และศูนย์วิจัยและพัฒนาทรัพยากรทางทะเลและชายฝั่งทะเลอันดามัน (ศวทม.) <br>
                ระบบจะทำการบันทึกข้อมูลจากทุกศูนย์ มาจัดเก็บและจัดทำเป็นฐานข้อมูลเดียวกัน <br>
                เพื่อนำไปใช้ประโยชน์ร่วมกันทั้งในด้านการวิจัยและเพื่อการศึกษา <br>
                และเพื่อให้สามารถเชื่อมโยงฐานข้อมูลดังกล่าวกับศูนย์ข้อมูลพันธุกรรมพืช <br>
                โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริ สมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี (อพ.สธ.) ได้
            </div>
        </div>

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
                @if(Session::get('language') == 2)
                    หากต้องการยืมคืนตัวอย่าง ให้ทำการติดต่อที่... <br>
                    หมายเลข :
                @else
                    Contact :
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
