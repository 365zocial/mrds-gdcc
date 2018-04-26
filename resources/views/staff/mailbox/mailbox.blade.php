@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
      input[type="search"] {
        width: 300px !important;
      }
    </style>
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">
        $('.loader').show();
        window.setTimeout(function(){
            $('.loader').fadeOut(500);
        }, 1000);

        $('input[type="search"]').attr('placeholder', 'Name, Topic...');
    </script>
@endsection

@section('header')
    <?php
        $headerName = "Mailbox";
        $iconFileName = "icon_dashboard_manager/mailbox.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Mailbox'] = url('staff/mailbox');
    ?>
@endsection

@section('button-on-header')

@endsection

@section('contain')

<?php
    use App\Model\Mailbox;
?>

<table id="result" class="display" cellspacing="0">
    <thead>
        <th class="th-padding-left">No</th>
        <th class="th-padding-left">Name</th>
        <th class="th-padding-left">Type</th>
        <th class="th-padding-left">Marine Center</th>
        <th class="th-padding-left">Topic Name</th>
        <th class="th-padding-left" style="text-align:center;">Action</th>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        @foreach( $mailboxs as $mailbox )
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $mailbox->first_name }} {{ $mailbox->last_name }}</td>
                <td>{{ Mailbox::typeMailbox( $mailbox->type ) }}</td>
                <td>{{ $mailbox->marinecenter_code }}</td>
                <td>{{ $mailbox->subject }}</td>
                <td class="tools" style="text-align:center;">
                    <a href="{{ url('staff/mailbox/detailMailboxStaff').'/'.base64_encode( base64_encode( base64_encode( $mailbox->id ) ) ) }}">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                </td>
            </tr>
            <?php $no++ ?>
        @endforeach
    </tbody>
</table> <!-- /.table -->

@endsection
