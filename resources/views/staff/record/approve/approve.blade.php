@extends('layouts.app')

@section('css')
    @include('base_wording_css')
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">
        $('.loader').show();
        window.setTimeout(function(){
            $('.loader').fadeOut(750);
        },1000);

        $('.th-padding-left').eq(1).css('width', '400px');
    </script>
@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\Classification;
        use App\Model\Users;
    ?>
@endsection

@section('header')
    <?php
        $headerName = "Approve and Edit";
        $iconFileName = "icon_dashboard_manager/approve_and_edit.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Approve and Edit'] = url('staff/approveRecord');
    ?>
@endsection

@section('contain')
<table id="result" class="display" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th class="th-padding-left">ID</th>
            <th class="th-padding-left">Scientific Name</th>
            <th class="th-padding-left">Update By</th>
            <th class="th-padding-left">Update Date</th>
            <th class="th-padding-left" style="text-align:center;">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; ?>
    @foreach($records as $record)
        <tr>
            <td>{{ $no }}</td>
            <td>@if($record->source == 1){{ $record->related_catalog_item }}@else{{ $record->related_reference_item }} @endif</td>
            <td>{!! Classification::getClassification($record->classification_id)->current_scientific_name_format !!}</td>
            <td>{{ Users::getUserById($record->updated_by)[0]->first_name }}</td>
            <td>{{ $record->updated_at }}</td>

            <td class="tools" style="text-align:center;">
                <a href="{{ url('staff/approveViewRecord', base64_encode( base64_encode( base64_encode( $record->id ))) ) }}">
                    <span class="glyphicon glyphicon-eye-open"></span> View
                </a>
                <span class="between-tools"> | </span>
                <a href="{{ url('staff/editRecordForm').'/1/'.base64_encode( base64_encode( base64_encode( $record->id ))).'/'.base64_encode( base64_encode( base64_encode( '3' ))) }}">
                    <span class="glyphicon glyphicon-pencil"></span> Edit
                </a>
            </td>
        </tr>
        <?php $no++ ?>
    @endforeach

    </tbody>
</table>
@endsection
