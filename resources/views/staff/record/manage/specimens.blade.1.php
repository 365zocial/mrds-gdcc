@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
      input[type="search"] {
        width: 300px !important;
      }
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
        }, 3500);

        $('input[type="search"]').attr('placeholder', 'ID, Scientific Name...');

        $(function() {
            $('#result').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! url('list-manageRecord') !!}",
                columns: [
                    { data: 'DT_Row_Index', orderable: false, searchable: false },                    
                    { data: 'IDCatalog', name: 'IDCatalog' },
                    { data: 'Scientific Name', name: 'Scientific Name' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

@section('header')
    <?php
        $headerName = "Manage Specimen";
        $iconFileName = "icon_dashboard_manager/manage_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage Record'] = url('staff/manageRecord');
        $breadcump['Specimen'] = url('staff/manageRecordSpecimens');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Record";
        $button['link'] = url('staff/checkClassificationForm');
    ?>
@endsection

@section('contain')

<table id="result" class="display" cellspacing="0">
    <thead>
        <th>No</th>
        <th class="th-padding-left">IDCatalog</th>
        <th class="th-padding-left">Scientific Name</th>
        <th class="th-padding-left" style="text-align:center; width: 150px;">Action</th>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        {{-- @foreach($records as $record)
            <tr @if( $record->status == 1 ) id="disable_data" @endif >
                <td>{{ $no }}</td>
                <td>{{ $record->related_catalog_item }}</td>
                <td>{!! $record->current_scientific_name_format !!}</td>
                <td class="tools" style="text-align:center;">
                    <a href="{{ url('staff/viewRecord', base64_encode( base64_encode( base64_encode( $record->id ))) ) }}">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                    <span class="between-tools"> | </span>
                    <a href="{{ url('staff/editRecordForm').'/1/'.base64_encode( base64_encode( base64_encode( $record->id ))).'/'.base64_encode( base64_encode( base64_encode( '1' ))) }}">
                        <span class="glyphicon glyphicon-pencil"></span> Edit
                    </a>
                </td>
            </tr>
            <?php $no++ ?>
        @endforeach --}}
    </tbody>
</table>

@endsection
