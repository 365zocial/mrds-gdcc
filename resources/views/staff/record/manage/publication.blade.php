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

        $('input[type="search"]').attr('placeholder', 'Collection Code, Reference...');
        
        $(function() {
            $('#result1').DataTable({
                order: [1, 'desc'],
                // bFilter: true,
                // bLengthChange: true,
                // "paging": true,
                // pagingType: "full_numbers",
                processing: true,
                serverSide: true,
                ajax: '{!! route('list.manage.record', ['source' => 2]) !!}',
                columns: [
                    { data: 'DT_Row_Index', orderable: false, searchable: false },                    
                    { data: 'id', name: 'id'},                    
                    { data: 'related_reference_item', name: 'related_reference_item' },
                    { data: 'current_scientific_name_format', name: 'current_scientific_name_format' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                "columnDefs": [
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                }
            ],
            });
        });
    </script>
@endsection

@section('header')
    <?php
        $headerName = "Manage Publication";
        $iconFileName = "icon_dashboard_manager/manage_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage Record'] = url('staff/manageRecord');
        $breadcump['Publication'] = url('staff/manageRecordPublication');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Add Record";
        $button['link'] = url('staff/checkClassificationForm');
    ?>
@endsection

@section('contain')

<table id="result1" class="display" cellspacing="0">
    <thead>
        <th>No</th>
        <th class="th-padding-left">IDRef</th>
        <th class="th-padding-left">IDCatalog</th>
        <th class="th-padding-left">Scientific Name</th>
        <th class="th-padding-left" style="text-align:center; width: 150px;">Action</th>
    </thead>
</table>

@endsection
