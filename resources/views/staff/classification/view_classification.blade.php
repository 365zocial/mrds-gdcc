@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style>
	.checkbox {
		padding-top: 20px;
	}
    img.picture_record {
        width: 100%;
    }
    p{
        word-wrap: break-word;
    }
    #disable_data {
        color: red;
    }
    </style>
@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\AllMean;
        use App\Model\Reference;
        use App\Model\Collection;
        use App\Model\Wording;
        use App\Model\Users;
        use App\Model\Taxonomy;
    ?>
@endsection

@section('header')
    <?php
        $headerName = "Manage Classification";
        $iconFileName = "icon_dashboard_manager/manage_classification.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Manage Classification'] = url('staff/manageClassification');
        $breadcump['View Classification'] = url('staff/viewClassification' , [$classification->id]);
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Edit Classification";
        $button['link'] = url('staff/editClassificationForm' , [$classification->id]);
    ?>
@endsection

@section('contain')

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">
        <div class="content-box">
            <p class="content-header" style="text-transform: none;" @if ($classification->status == 1) id="disable_data" @endif>{!! AllMean::ReplaceNullWithDash($classification->current_scientific_name_format) !!}</p>

            <div class="row">
              <div class="col-md-12">
                <p class="record-label">Identification Qualifier:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash(Wording::getWordingByID( $classification->identification_qualifier ), "name_th") }}</span>
                </p>
              </div>
            </div>

            <div class="row row-before-line">
              <div class="col-md-12">
                <p class="record-label">Previous Scientific Name:
                  <span class="record-data">{!! AllMean::ReplaceNullWithDash($classification->previous_scientific_name_format) !!}</span>
                </p>
              </div>
            </div>

            <hr class="view-record-line">

            <div class="row">
              <div class="col-md-12">
                <p class="record-label">Domain:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->domain ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Kingdom:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->kingdom ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Subkingdom:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->subkingdom ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <p class="record-label">Infrakingdom:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->infrakingdom ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Phylum:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->phylum ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Subphylum:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->subphylum ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <p class="record-label">Infraphylum:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->infraphylum ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Superclass:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->superclass ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Class (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->class ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Subclass:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->subclass ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Infraclass (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->infraclass ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Superorder (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->superorder ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Order (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->order_o ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Suborder (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->suborder ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Infraorder (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->infraorder ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Superfamily (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->superfamily ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Family (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->family ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <p class="record-label">Subfamily (Clade):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->subfamily ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="record-label">Genus:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->genus ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Subgenus:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->subgenus ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row row-before-line">
              <div class="col-md-6">
                <p class="record-label">Species:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->species ), "name" ) }}</span>
                </p>
              </div>
              <div class="col-md-6">
                <p class="record-label">Subspecies:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Taxonomy::getTaxonomyWording( $classification->subspecies ), "name" ) }}</span>
                </p>
              </div>
            </div>

            <hr>

            <div class="row row-before-line">
              <div class="col-md-12">
                <p class="record-label">Common Name:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( $classification->common_name ) }}</span>
                </p>
              </div>
            </div>

            <div class="row row-before-line">
              <div class="col-md-12">
                <p class="record-label">Protection Thai Law:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_thai_law ), "name_th" ) }}</span>
                </p>
              </div>
            </div>

            <div class="row row-before-line">
                <div class="col-md-12">
                  <p class="record-label">Protection IUCN 2019:
                    <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_iucn_2019 ), "name_en" ) }} @if( $classification->protection_iucn_2019 != null ) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_iucn_2019 ), "name_th" ) }}) @endif</span>
                  </p>
                </div>
            </div>

            <div class="row row-before-line">
              <div class="col-md-12">
                <p class="record-label">Protection CITES:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_cites ), "name_en" ) }} @if ($classification->protection_cites != null) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_cites ), "name_th" ) }}) @endif</span>
                </p>
              </div>
            </div>

            <div class="row row-before-line">
              <div class="col-md-12">
                <p class="record-label">Thai Red List:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->thai_red_list ), "name_en" ) }} @if ($classification->thai_red_list != null) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->thai_red_list ), "name_th" ) }}) @endif</span>
                </p>
              </div>
            </div>

            <hr>

            <div class="row row-before-line">
                <div class="col-md-6">
                  <p class="record-label">Invasive Species (ชนิดพันธุ์ต่างถิ่น):
                    <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->invasive_species ), "name_th" ) }}</span>
                  </p>
                </div>
              <div class="col-md-6">
                <p class="record-label">Living (กลุ่มชนิดพันธุ์):
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->living ), "name_th" ) }}</span>
                </p>
              </div>
            </div>

        </div>
    </div>
</div>

<div class="row row-with-margin">
    <div class="col-md-8 col-md-offset-2">

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Add Classification:
          <span class="record-data">{{ $users_add[0]->first_name." ".$users_add[0]->last_name }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Add Classification Date:
          <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate($classification->created_at) }} {{ AllMean::ReplaceNullWithDefaultTime2($classification->created_at) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Edit Classification:
          <span class="record-data">{{ $users_update[0]->first_name." ".$users_update[0]->last_name }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Edit Classification Date:
          <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate($classification->updated_at) }} {{ AllMean::ReplaceNullWithDefaultTime2($classification->updated_at) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Migrate Data:
          <span class="record-data">@if ($classification->migration_data) Yes @else No @endif</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Status:
          <span class="record-data">@if ($classification->status == 2) Enable @else <font color="red">Disable</font> @endif</span>
        </p>
      </div>
    </div>

  </div>
</div>

@endsection
