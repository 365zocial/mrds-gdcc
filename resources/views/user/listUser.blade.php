@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

@section('contain')
    <div class="row">
        <div class="col-md-10">
            <h2>User : List</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                    @foreach($data_users as $users)
                        <tr>
                            <td>{{ $users->id }}</td>
                            <td>{{ $users->name }}</td>
                            <td>{{ $users->first_name }}</td>
                            <td>{{ $users->last_name }}</td>
                            <td>@if( $users->gender == "f"){{ "Female" }} @else {{ "Male" }} @endif</td>
                            <td>{{ $users->email }}</td>
                            <td>{{ $users->status }}</td>
                            <td>
                                <a href="{{ url('user/edit', $users->id) }}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('user/delete', $users->id) }}">
                                    <span class="glyphicon glyphicon-remove-circle"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
