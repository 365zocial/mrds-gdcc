@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        #disable_data {
            color: red;
        }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">
        $('.loader').show();
        window.setTimeout(function(){
            $('.loader').fadeOut(750);
        },1000);
    </script>
@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\AllMean;
        use App\Model\Role;
        use App\Model\Marinecenter;

    ?>
@endsection

@section('header')
    <?php
        $headerName = "Manage User";
        $iconFileName = "icon_dashboard_manager/manage_user.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage User'] = url('staff/list');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add User";
        $button['link'] = url('staff/add');
    ?>
@endsection

@section('contain')

    @include('alert')


        <table id="result" class="display" cellspacing="0">
            <thead>
                <th>No</th>
                <th class="th-padding-left">Username</th>
                <th class="th-padding-left">Firstname</th>
                <th class="th-padding-left">Lastname</th>
                <th class="th-padding-left">Gender</th>
                <th class="th-padding-left">Email</th>
                <th class="th-padding-left">MarineCenter</th>
                <th class="th-padding-left">Role</th>
                <th class="th-padding-left" style="text-align: center;">Action</th>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            @foreach($data_users as $users)
                <tr @if( $users->status == 1 ) id="disable_data" @endif >
                    <td>{{ $no }}</td>
                    <td>{{ $users->name }}</td>
                    <td>{{ $users->first_name }}</td>
                    <td>{{ $users->last_name }}</td>
                    <td>@if( $users->gender == "f"){{ "Female" }} @else {{ "Male" }} @endif</td>
                    <td>{{ $users->email }}</td>
                    <td>@if( $users->marinecenter_id != 0 ){{ Marinecenter::getMarineCenterCode($users->marinecenter_id)[0] }} @else {{ "-" }} @endif</td>
                    <td>{{ Role::getRoleByID($users->role_id)->role }}</td>
                    <td class="tools" style="text-align: center;">
                        <a href="{{ url('staff/edit', $users->id) }}">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                    </td>

                </tr>
                <?php $no++ ?>
            @endforeach
            </tbody>
        </table>

@endsection
