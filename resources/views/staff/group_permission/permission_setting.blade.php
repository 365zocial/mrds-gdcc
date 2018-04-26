@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style media="screen">
        .custom-switch > .btn{
            width: 98px !important;
            margin-left: 3px;
            margin-right: 25px;
        }


    </style>
@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript">

        var x = 1;
        function setStatus(name_element){
            if(x != 1){
                x = 1;
                return false;
            }

            var element = $(name_element);
            if(!confirm("Confirm to change Group !")){
                x = x + 1;
                if( element.prop('checked') ){
                    element.off('change');
                    element.bootstrapToggle('toggle');
                    element.on('change');

                }else{
                    element.bootstrapToggle('toggle');
                }

            }else{
                var id      = element.data('id');
                var status  = "";
                var role    = element.data('role');;
                if( element.prop('checked') ){
                    var status  = "on";
                }

                // console.log(id+" "+role+" "+status);
                setStatus_Permission(id, role, status);

            }
        }

        function setStatus_Permission(id, role, status){
            $.ajax({
                method: "POST",
                url: "<?php echo url('staff/permission/doUpdatePermission'); ?>",
                data: {
                    _token: "{{ csrf_token() }}",
                    id      : id,
                    role    : role,
                    status  : status,
                    }
            }).done(function( data ) {
                console.log(data);
            });
        }
    </script>
@endsection

@section('header')
    <?php
        $headerName = "GROUP PERMISSION";
        $iconFileName = "icon_dashboard_manager/mailbox.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Group Permission'] = "";
    ?>
@endsection

@section('button-on-header')

@endsection

@section('contain')
<div class="row">
    <div class="row row-with-margin">
        <div class="col-md-8 col-md-offset-2">
            <div class="content-box">
                <div class="">

                </div>
                <p class="content-header">PERMISSION SETTING</p>
                <p class="content-help-text" style="color:red;">*Warning Please make sure before confirm button.</p>

                <div class="row">
                    <div class="col-md-12">
                        <div style="display:inline-block; vertical-align:middle;"><strong>Taxonomy Group</strong></div>
                    </div>
                    <div class="col-md-6 line-height">
                        <p> - Domain</p>
                        <p> - Kingdom, Subkingdom, Infrakingdom</p>
                        <p> - Phylumm Subphylum, Infraphylum</p>
                        <p> - Superclass, Class, Subclass, Infraclass</p>
                    </div>
                    <div class="col-md-6 line-height">
                        <p> - Superorder, Order, Suborder, Infraorder</p>
                        <p> - Superfamily, Family, Subfamily</p>
                        <p> - Genus, Subgenus</p>
                        <p> - Species, Subspecies</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding-top: 5px; display:inline-block; vertical-align:middle;"><strong>Permission</strong></div>
                    </div>
                    <ul style="padding-top: 20px;padding-left: 20px;">
                        <li style="display:inline-block;">
                            <span for="">Manager - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_A1" name="status_switch" onchange="setStatus('#status_swtich_A1')" class="status_switching" type="checkbox" data-id='1' data-role="manager" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[0]->status_manager == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                        <li style="display:inline-block;">
                            <span for="">User - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_A2" name="status_switch" onchange="setStatus('#status_swtich_A2')" class="status_switching" type="checkbox" data-id='1' data-role="user" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[0]->status_user == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                        <li style="display:inline-block;">
                            <span for="">Board - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_A3" name="status_switch" onchange="setStatus('#status_swtich_A3')" class="status_switching" type="checkbox" data-id='1' data-role="board" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[0]->status_board == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                        <li style="display:inline-block;">
                            <span for="">PGCP - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_A4" name="status_switch" onchange="setStatus('#status_swtich_A4')" class="status_switching" type="checkbox" data-id='1' data-role="pgcp" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[0]->status_pgcp == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                    </ul>

                </div>
                <hr class="search-report">

                <div class="row">
                    <div class="col-md-12">
                        <div style="display:inline-block; vertical-align:middle;"><strong>Locality Group</strong></div>
                    </div>
                    <div class="col-md-4 line-height">
                        <p> - Ocean / Sea / Lake</p>
                        <p> - Country</p>
                    </div>
                    <div class="col-md-4 line-height">
                        <p> - Province</p>
                        <p> - District</p>
                    </div>
                    <div class="col-md-4 line-height">
                        <p> - County</p>
                        <p> - Locality</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding-top: 5px; display:inline-block; vertical-align:middle;"><strong>Permission</strong></div>
                    </div>
                    <ul style="padding-top: 20px;padding-left: 20px;">
                        <li style="display:inline-block;">
                            <span for="">Manager - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_B1" name="status_switch" onchange="setStatus('#status_swtich_B1')" class="status_switching" type="checkbox" data-id='2' data-role="manager" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[1]->status_manager == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                        <li style="display:inline-block;">
                            <span for="">User - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_B2" name="status_switch" onchange="setStatus('#status_swtich_B2')" class="status_switching" type="checkbox" data-id='2' data-role="user" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[1]->status_user == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                        <li style="display:inline-block;">
                            <span for="">Board - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_B3" name="status_switch" onchange="setStatus('#status_swtich_B3')" class="status_switching" type="checkbox" data-id='2' data-role="board" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled" @if($permission[1]->status_board == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                        <li style="display:inline-block;">
                            <span for="">PGCP - </span>
                            <div class="custom-switch" style="display:inline-block;">
                                <input id="status_swtich_B4" name="status_switch" onchange="setStatus('#status_swtich_B4')" class="status_switching" type="checkbox" data-id='2' data-role="pgcp" data-statuswordingid="" data-toggle="toggle" data-width="100" data-on="Enabled" data-off="Disabled"  @if($permission[1]->status_pgcp == 2){{ 'checked' }}@endif>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
