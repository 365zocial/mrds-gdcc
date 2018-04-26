<div class="navbar navbar-default navbar-fixed-side navbar-custom" role="navigation">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <div class="collapse navbar-collapse" id="myNavbar">
        <div class="container-fluid nav-cont-custom">
            <div class="row nav-row-custom">
                <div class="col-sm-12 nav-col-custom">

                    <ul class="nav navbar-nav navbar-left">
                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle dropdown-custom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="nav-menu">
                                    {{-- <div class="icon">
                                        <span class="glyphicon glyphicon-align-justify nav-menu-icon" aria-hidden="true"></span>
                                    </div> --}}
                                    <div class="text">
                                        @if(Session::get('language') == 2)
                                            เมนู
                                        @else
                                            Menu
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @if(Auth::user()->role_id == 3) <!-- Role : Manager -->
                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="{{ url('staff/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/dashboard.png') }}" alt="Dashboard Icon" />
                                            </div>
                                            <div class="menu-text">Dashboard</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/export_label/form') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/export_label.png') }}" alt="Export Label Icon" />
                                            </div>
                                            <div class="menu-text">Export Label</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/checkClassificationForm') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/add_record.png') }}" alt="Add Record Icon" />
                                            </div>
                                            <div class="menu-text">Add Record</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/approveRecord') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/approve_and_edit.png') }}" alt="Add Record Icon" />
                                            </div>
                                            <div class="menu-text">Approve and Edit</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/manageRecord') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/manage_record.png') }}" alt="Manage Record Icon" />
                                            </div>
                                            <div class="menu-text">Manage Record</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchCategory/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_category.png') }}" alt="Search Category Icon" />
                                            </div>
                                            <div class="menu-text">Search Category</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/loan/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/loan_specimen.png') }}" alt="Loan Specimen Icon" />
                                            </div>
                                            <div class="menu-text">Loan Specimen</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchReport/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_report.png') }}" alt="Search Report Icon" />
                                            </div>
                                            <div class="menu-text">Search Report</div>
                                        </a>
                                    </li>

                                </ul>
                            @elseif(Auth::user()->role_id == 2) <!-- Role : Administrator -->
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('staff/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/dashboard.png') }}" alt="Dashboard Icon" />
                                            </div>
                                            <div class="menu-text">Dashboard</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/manageClassification') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/manage_classification.png') }}" alt="Manage Classification Icon" />
                                            </div>
                                            <div class="menu-text">Manage Classification</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/checkClassificationForm') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/add_record.png') }}" alt="Add Record Icon" />
                                            </div>
                                            <div class="menu-text">Add Record</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/approveRecord') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/approve_and_edit.png') }}" alt="Add Record Icon" />
                                            </div>
                                            <div class="menu-text">Approve and Edit</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/manageRecord') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/manage_record.png') }}" alt="Manage Record Icon" />
                                            </div>
                                            <div class="menu-text">Manage Record</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/mainWording') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/word_in_system.png') }}" alt="Word in System Icon" />
                                            </div>
                                            <div class="menu-text">Word in System</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchCategory/searchDashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_category.png') }}" alt="Search Category Icon" />
                                            </div>
                                            <div class="menu-text">Search Category</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/permission/view') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/group_permission.png') }}" alt="Group Permission Icon" />
                                            </div>
                                            <div class="menu-text">Group Permission</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/list') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/manage_user.png') }}" alt="Manage User Icon" />
                                            </div>
                                            <div class="menu-text">Manage User</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/mailbox/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/mailbox.png') }}" alt="Mailbox Icon" />
                                            </div>
                                            <div class="menu-text">Mailbox</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/export_label/form') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/export_label.png') }}" alt="Export Label Icon" />
                                            </div>
                                            <div class="menu-text">Export Label</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchReport/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_report.png') }}" alt="Search Report Icon" />
                                            </div>
                                            <div class="menu-text">Search Report</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/systemlog/search') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/system_log.png') }}" alt="System Log Icon" />
                                            </div>
                                            <div class="menu-text">System Log</div>
                                        </a>
                                    </li>
                                </ul>

                            @elseif(Auth::user()->role_id == 4) <!-- Role : Board -->

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('staff/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/dashboard.png') }}" alt="Dashboard Icon" />
                                            </div>
                                            <div class="menu-text">Dashboard</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchReport/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_report.png') }}" alt="Search Report Icon" />
                                            </div>
                                            <div class="menu-text">Search Report</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchCategory/searchDashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_category.png') }}" alt="Search Category Icon" />
                                            </div>
                                            <div class="menu-text">Search Category</div>
                                        </a>
                                    </li>

                                </ul>

                            @elseif(Auth::user()->role_id == 6) <!-- Role : PGCP -->
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('staff/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/dashboard.png') }}" alt="Dashboard Icon" />
                                            </div>
                                            <div class="menu-text">Dashboard</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/exportRecord') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/export_record.png') }}" alt="Export Record Icon" />
                                            </div>
                                            <div class="menu-text">Export CSV</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/exportRecordSQL') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/export_record.png') }}" alt="Export Record Icon" />
                                            </div>
                                            <div class="menu-text">Export SQL</div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('staff/searchCategory/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_category.png') }}" alt="Search Category Icon" />
                                            </div>
                                            <div class="menu-text">Search Category</div>
                                        </a>
                                    </li>

                                </ul>


                            @elseif(Auth::user()->role_id == 5) <!-- Role : User -->
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('user/dashboard') }}">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/dashboard.png') }}" alt="Dashboard Icon" />
                                            </div>
                                            <div class="menu-text">
                                                @if(Session::get('language') == 2)
                                                    หน้าควบคุมหลัก
                                                @else
                                                    Dashbaord
                                                @endif

                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="@if( Session::get('language') == 2 ){{ url('user/th/search/dashboard') }}@else{{ url('user/search/dashboard') }}@endif">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/search_category.png') }}" alt="Manage Classification Icon" />
                                            </div>
                                            <div class="menu-text">
                                                @if(Session::get('language') == 2)
                                                    ค้นหาโดยประเภท
                                                @else
                                                    SEARCH CATEGORY
                                                @endif
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="@if( Session::get('language') == 2 ){{ url('user/loan/dashboard') }}@else{{ url('user/loan/dashboard') }}@endif">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/loan_specimen.png') }}" alt="Add Record Icon" />
                                            </div>
                                            <div class="menu-text">
                                                @if(Session::get('language') == 2)
                                                    แบบฟอร์มการขอยืมตัวอย่าง
                                                @else
                                                    LOAN SPECIMEN FORM
                                                @endif
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="@if( Session::get('language') == 2 ){{ url('user/loan/dashboard') }}@else{{ url('user/contact/contactForm') }}@endif">
                                            <div class="menu-icon">
                                                <img src="{{ url('assets/images/icon_menu/Icon-contact.png') }}" alt="Add Record Icon" />
                                            </div>
                                            <div class="menu-text">
                                                @if(Session::get('language') == 2)
                                                    แบบฟอร์มแสดงความคิดเห็น
                                                @else
                                                    CONTACT ADMIN
                                                @endif

                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right nav-custom">
                        <li><a class="a-user" href="#">
                            <div class="nav-user">
                                <a href="{{ url('profile') }}">
                                    <img src="{{ url('assets/images/user_icon.png') }}" alt="" />
                                    {{ Auth::user()->first_name }}
                                </a>
                            </div>
                            </a></li>
                        <li>
                            <a class="a-logout" href="{{ url('logout') }}">
                                <div class="nav-logout">
                                    @if(Session::get('language') == 2)
                                        ออกจากระบบ
                                    @else
                                        Log out
                                    @endif
                                </div>
                            </a>
                        </li>
                    </ul>

                </div>

                <div class="navbar-header hidden-sm hidden-xs system-logo">
                    @if(Session::get('language') == 2)
                        <img src="{{ url('assets/images/Logo_Thai.png') }}" alt="" />
                    @else
                        <img src="{{ url('assets/images/Logo.png') }}" alt="" />
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
