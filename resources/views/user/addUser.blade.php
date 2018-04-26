@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('contain')
    <div class="col-md-12">
        <h2>User : Add</h2>
    </div>
    <div class="col-md-12">
        <form class="form-horizontal" role="form" method="post" action="{{ url('user/add')}}">
            @csrf
            <div class="form-group">
                <label class="control-label col-sm-2" for="-username">Username:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-username" name="inp-username" maxlength="255" placeholder="Enter Username">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-username">Password:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="-password" name="inp-password" placeholder="Enter Password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-username">Confirm Password:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="-repassword" name="inp-repassword" placeholder="Re Enter Password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-fname">First Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-fname" name="inp-first_name" maxlength="100" placeholder="Enter First Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-lname">Last Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-lname" name="inp-last_name" maxlength="100" placeholder="Enter Last Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-gender">Gender:</label>
                <div class="col-sm-2">
                    <select class="form-control" id="-gender" name="inp-gender">
                        <option value="f">Female</option>
                        <option value="m">Male</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-gender">Email:</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" id="-email" name="inp-email" maxlength="255" placeholder="ABC@DEF.com">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="_telephone">Telephone:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-telephone" name="inp-telephone"maxlength="12" placeholder="0811111111">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-position">Position:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-position" name="inp-position" maxlength="255" placeholder="Enter Position">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-company">Company:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-company" name="inp-company" maxlength="255" placeholder="Enter company">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="-address">Address:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="-address" name="inp-address" placeholder="Enter Address">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>

    </div>
@endsection
