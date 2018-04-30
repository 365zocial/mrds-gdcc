@extends('layouts.app')

@section('css')
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" media="screen" title="no title" charset="utf-8"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/wording.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('contain')

<div class="row">
    <div class="col-md-12">
        <form action="{{ url('staff/searchname') }}" class="form" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select name="typename" id="" class="form-control">
                        <option value="" selected disabled>ค้นหาจาก</option>
                        <option value="localname">Local Name</option>
                        <option value="vernacularname">Vernacular Name</option>
                        <option value="commonname">Common Name</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-block btn-success">ค้นหา</button>
                </div>
            </div>
        </form>

        @if(Auth::user()->role_id == 3)
            <!-- Role : Manager -->
            <div class="row" style="margin-bottom: 30px; margin-top: 10%;">

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/export_label/form') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/export_label.png") }}' />
                        </div>
                        <p class="menu-text">Export Label<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/checkClassificationForm') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/add_record.png") }}' />
                        </div>
                        <p class="menu-text">Add Record<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/approveRecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/approve_and_edit.png") }}' />
                        </div>
                        <p class="menu-text">Approve and Edit<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/manageRecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/manage_record.png") }}' />
                        </div>
                        <p class="menu-text">Manage Record<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

            </div>

            <div class="row row-centered">

                <div class="col-md-3 menu-box col-centered">
                  <a class="box-link" href="{{ url('staff/searchCategory/dashboard') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_category.png") }}' />
                        </div>
                        <p class="menu-text">Search Category<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box col-centered">
                  <a class="box-link" href="{{ url('staff/loan/dashboard') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/loan_specimen.png") }}' />
                        </div>
                        <p class="menu-text">Loan Specimen<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box col-centered">
                  <a class="box-link" href="{{ url('staff/searchReport/dashboard') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_report.png") }}' />
                        </div>
                        <p class="menu-text">Search Report<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

            </div>

        @elseif(Auth::user()->role_id == 2) <!-- Role : Administrator -->
            <div class="row" style="margin-top: 5%; margin-bottom: 30px;">

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/manageClassification') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/manage_classification.png") }}' />
                        </div>
                        <p class="menu-text">Manage<br>Classification</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/checkClassificationForm') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/add_record.png") }}' />
                        </div>
                        <p class="menu-text">Add Record<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/approveRecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/approve_and_edit.png") }}' />
                        </div>
                        <p class="menu-text">Approve and Edit<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/manageRecord') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/manage_record.png") }}' />
                        </div>
                        <p class="menu-text">Manage Record<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

            </div>

            <div class="row" style="margin-bottom: 30px;">

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/mainWording') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/word_in_system.png") }}' />
                        </div>
                        <p class="menu-text">Word in System<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/searchCategory/searchDashboard') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_category.png") }}' />
                        </div>
                        <p class="menu-text">Search Category<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/permission/view') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/group_permission.png") }}' />
                        </div>
                        <p class="menu-text">Group Permission<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/list') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/manage_user.png") }}' />
                        </div>
                        <p class="menu-text">Manage User<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

            </div>

            <div class="row" style="margin-bottom: 30px;">

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/mailbox/dashboard') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/mailbox.png") }}' />
                        </div>
                        <p class="menu-text">Mailbox<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/export_label/form') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/export_label.png") }}' />
                        </div>
                        <p class="menu-text">Export Label<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/searchReport/dashboard') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_report.png") }}' />
                        </div>
                        <p class="menu-text">Search Report<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

                <div class="col-md-3 menu-box">
                  <a class="box-link" href="{{ url('staff/systemlog/search') }}">
                    <div class="menu-icon-box">
                        <div class="icon-box">
                            <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/system_log.png") }}' />
                        </div>
                        <p class="menu-text">System Log<br>&nbsp;</p>
                    </div>
                  </a>
                </div>

            </div>
        @elseif(Auth::user()->role_id == 4) <!-- Role : Board -->
            <div class="row row-centered" style="margin-top: 10%;">
                <div class="col-md-3 menu-box col-centered">
                    <a class="box-link" href="{{ url('staff/searchReport/dashboard') }}">
                        <div class="menu-icon-box">
                            <div class="icon-box">
                                <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_report.png") }}' />
                            </div>
                            <p class="menu-text">Search Report<br>&nbsp;</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 menu-box col-centered">
                    <a class="box-link" href="{{ url('staff/searchCategory/searchDashboard') }}">
                        <div class="menu-icon-box">
                            <div class="icon-box">
                                <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_category.png") }}' />
                            </div>
                            <p class="menu-text">Search Category<br>&nbsp;</p>
                        </div>
                    </a>
                </div>
            </div>
        @elseif(Auth::user()->role_id == 6) <!-- Role : PGCP -->
            <div class="row row-centered" style="margin-top: 10%;">
                <div class="col-md-3 menu-box col-centered">
                    <a class="box-link" href="{{ url('staff/exportRecord') }}">
                        <div class="menu-icon-box">
                            <div class="icon-box">
                                <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/export_record.png") }}' />
                            </div>
                            <p class="menu-text">Export CSV<br>&nbsp;</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 menu-box col-centered">
                    <a class="box-link" href="{{ url('staff/exportRecordSQL') }}">
                        <div class="menu-icon-box">
                            <div class="icon-box">
                                <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/export_record.png") }}' />
                            </div>
                            <p class="menu-text">Export SQL<br>&nbsp;</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 menu-box col-centered">
                    <a class="box-link" href="{{ url('staff/searchCategory/dashboard') }}">
                        <div class="menu-icon-box">
                            <div class="icon-box">
                                <img class="icon" src='{{ URL::asset("assets/images/icon_dashboard_manager/search_category.png") }}' />
                            </div>
                            <p class="menu-text">Search Category<br>&nbsp;</p>
                        </div>
                    </a>
                </div>
            </div>
        @endif

    </div> <!-- /.col-md-12 -->
</div> <!-- /.col-md-12 -->

@endsection
