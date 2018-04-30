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

        // $(function() {
        //     $('#result1').DataTable({
        //         order: [1, 'desc'],
        //         // bFilter: true,
        //         // bLengthChange: true,
        //         // "paging": true,
        //         // pagingType: "full_numbers",
        //         processing: true,
        //         serverSide: true,
        //         ajax: '{!! route('list.manage.record', ['source' => 1]) !!}',
        //         columns: [
        //             { data: 'DT_Row_Index', orderable: false, searchable: false },                    
        //             { data: 'id', name: 'id'},                    
        //             { data: 'related_catalog_item', name: 'related_catalog_item' },
        //             { data: 'current_scientific_name_format', name: 'classification.current_scientific_name_format' },
        //             { data: 'action', orderable: false, searchable: false }
        //         ],
        //         "columnDefs": [
        //         {
        //             "targets": [1],
        //             "visible": false,
        //             "searchable": false
        //         }
        //     ],
        //     });
        // });
    </script>
@endsection

@section('header')
    <?php
        $headerName = "Search By Name";
        $iconFileName = "icon_dashboard_manager/manage_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage Record'] = url('staff/searchname');
    ?>
@endsection

@section('button-on-header')
    <?php
        // $button['name'] = "Add Record";
        // $button['link'] = url('staff/checkClassificationForm');
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
        @foreach($datas as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->related_catalog_item }} {{ $data->related_reference_item }}</td>
                <td>{!! $data->current_scientific_name_format !!}</td>
                <td class="tools" style="text-align:center;">
                    <a href="{{ url('staff/viewRecord', base64_encode( base64_encode( base64_encode( $data->id ))) ) }}">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                    <span class="between-tools"> | </span>
                    <a href="{{ url('staff/editRecordForm').'/1/'.base64_encode( base64_encode( base64_encode( $data->id ))).'/'.base64_encode( base64_encode( base64_encode( '1' ))) }}">
                        <span class="glyphicon glyphicon-pencil"></span> Edit
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
