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
    </style>
@endsection

@section('script')
  @include('base_wording_js')

	<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>

    <script type="text/javascript">
        $('.nav-pills a').click(function(e){
            e.preventDefault();
            $(this).tab('show');
        })
    </script>
@endsection

@section('use_setup')
    <?php
        //for setup
        use App\Model\AllMean;
        use App\Model\Reference;
        use App\Model\Collection;
        use App\Model\Wording;
    ?>
@endsection

@section('header')
    <?php
        $headerName = "View Record";
        $iconFileName = "icon_dashboard_manager/manage_record.png";
     ?>
@endsection

@section('breadcump')
    <?php
        $breadcump['Dashboard'] = url('staff/dashboard');
        $breadcump['Approve and Edit'] = url('staff/approveRecord');
        $breadcump['View Record'] = url('staff/approveViewRecord/id');
    ?>
@endsection

@section('button-on-header')
    <?php
        $button['name'] = "Edit Record";
        $button['link'] = url('staff/editRecordForm').'/1/'.base64_encode( base64_encode( base64_encode( $record[0]->id ))).'/'.base64_encode( base64_encode( base64_encode( '3' )));
    ?>
@endsection

@section('contain')
<div class="row">
  <div class="col-md-12 view-record">
    <p class="record-name">{!! AllMean::ReplaceNullWithDash($classification->current_scientific_name_format) !!}</p>
    <p class="record-catalog">
      @if( $record[0]->source == 1 )
        {{ AllMean::ReplaceNullWithDash($record[0]->related_catalog_item) }}
      @else
        {{ AllMean::ReplaceNullWithDash($record[0]->related_reference_item) }}
      @endif
    </p>
  </div>
</div>

<div class="row">
  <div class="col-md-6 view-record-image">
    @if(sizeof($pictures) > 0)
        <img class="record-image" src="{{ "/mrds_file/uploads/images" }}/{{ $pictures[0]->path_pic }}" alt="Specimen" />
    @else
        <img class="record-image" src="{{ url('assets/images/placeholder-image.png') }}" alt="Place Holder Image" />
    @endif
  </div>
  <div class="col-md-6 view-record-taxonomy">
    <p class="record-label">Previous Scientific Name:
      <span class="record-data">{!! AllMean::ReplaceNullWithDash($classification->previous_scientific_name_format) !!}</span>
    </p>

    <hr class="view-record-line">

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Domain:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[0]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Kingdom:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[1]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Subkingdom:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[2]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Infrakingdom:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[3]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Phylum:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[4]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Subphylum:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[5]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Infraphylum:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[6]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Superclass:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[7]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Class (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[8]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Subclass (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[9]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Infraclass (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[10]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Superorder (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[11]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Order (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[12]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Suborder (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[13]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Infraorder (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[14]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Superfamily (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[15]['name']) }}</span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Family (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[16]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Subfamily (Clade):
          <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[17]['name']) }}</span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Genus:
          <span class="record-data"><i>{{ ucfirst(  AllMean::ReplaceNullWithDash($taxonomy[18]['name']) ) }}</i></span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Subgenus:
          <span class="record-data"><i>{{ ucfirst(  AllMean::ReplaceNullWithDash($taxonomy[19]['name']) ) }}</i></span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p class="record-label">Species:
          <span class="record-data"><i>{{ strtolower( AllMean::ReplaceNullWithDash($taxonomy[20]['name']) ) }}</i></span>
        </p>
      </div>
      <div class="col-md-6">
        <p class="record-label">Subspecies:
          <span class="record-data"><i>{{ strtolower( AllMean::ReplaceNullWithDash($taxonomy[21]['name']) ) }}</i></span>
        </p>
      </div>
    </div>

    <hr class="view-record-line">

    <div class="row">
      <div class="col-md-12">
        <p class="record-label">Common Name:
          <span class="record-data">{{ AllMean::ReplaceNullWithDash( $classification->common_name ) }}</span>
        </p>
      </div>
    </div>

    <hr class="view-record-line">

    <div class="row">
        <div class="col-md-12">
          <p class="record-label">Protection Thai Law:
            <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_thai_law ), "name_th" ) }}</span>
          </p>
        </div>
        <div class="col-md-12">
          <p class="record-label">Protection IUCN:
            <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_iucn ), "name_en" ) }} @if( $classification->protection_iucn != null ) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_iucn ), "name_th" ) }}) @endif</span>
          </p>
        </div>
        <div class="col-md-12">
          <p class="record-label">Protection CITES:
            <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_cites ), "name_en" ) }} @if ($classification->protection_cites != null) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_cites ), "name_th" ) }}) @endif</span>
          </p>
        </div>
    </div>

  </div>
</div>

<hr class="view-record-line">

<div class="row">
  <div class="col-md-12 record-detail-list">
    <div class="">
      <ul class="nav nav-pills list-inline">
          <li><p class="record-detail-header">Record Detail</p></li>
          <li class="active"><a href="#eng">ENG</a></li>
          <li><a href="#thai">THAI</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="tab-content">

      <div role="tabpanel" class="tab-pane active" id="eng">

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Marine Center:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($marinecenter[0]) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Collection Code:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Collection::getCollectionByID( $record[0]->collection_code )->name_en ) }}</span>
            </p>
          </div>
          @if($record[0]->source == "1")
            <div class="col-md-4">
              <p class="record-label">Catalog Number:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->catalog_number) }}</span>
              </p>
            </div>
          @endif
        </div>

        @if($record[0]->source == "2")
          <div class="row">
            <div class="col-md-8">
              <p class="record-label">Reference:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash( Reference::getReferenceByID( $record[0]->reference )->ref_code ) }} / {{ AllMean::ReplaceNullWithDash( Reference::getReferenceByID( $record[0]->reference )->name_en ) }}</span>
              </p>
            </div>
            <div class="col-md-4">
              <p class="record-label">Page:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->page) }}</span>
              </p>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="col-md-12">
            <p class="record-label">Variety Name:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[0]->variety_name ) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Donate from:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->donated_from ,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Deposite at:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->deposited_at ,"name_en" )) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Type Status:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash(Wording::getWordingWithAttr( $record[0]->type_status,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-8">
            <p class="record-label">Individual Count:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->individual_count) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Sex:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->sex,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-8">
            <p class="record-label">Size:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->size) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Life Stage:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->life_stage,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Ocean / Sea / Lake:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->ocean_sea_lake,"name_en" )) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Country:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($country,'country_en') }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Province:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($province,'province_en') }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">District:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($district,'district_en') }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-4">
            <p class="record-label">County:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($county,'county_en') }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Locality:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->locality) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">Verbatim Latitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->verbatim_latitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">Verbatim Longitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->verbatim_longitude) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">Latitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->latitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">Longitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->longitude) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">Start Latitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->start_latitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">End Latitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->end_latitude) }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">Start Longitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->start_longitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">End Longitude:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->end_longitude) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">Habitat:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->habitat,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-3">
            <p class="record-label">Depth:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->depth_start) }}</span>
            </p>
          </div>
          <div class="col-md-3">
            <p class="record-label">End Depth:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->depth_end) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">Collector:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->collector) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">Collected Date:
              <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate( $record[0]->collected_date)  }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">Current Identifier:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->identifier) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">Current Identifier Date:
              <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate( $record[0]->identified_date)  }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">Previous Identifier:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->previous_identifier) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">Previous Identifier Date:
              <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate( $record[0]->previous_identified_date)  }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Gear Method:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->gear_method,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Preparation Type:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->preparation_type,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Expedition:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[0]->expedition,"name_en" )) }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-4">
            <p class="record-label">Gene Bank Number:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->gene_bank_number) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">Diagnosis:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->diagnosis) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">Description:</p>
            <p class="record-description">{!! AllMean::ReplaceNullWithDash($record[0]->description) !!}</p>
          </div>
          <div class="col-md-6">
            <p class="record-label">Note:</p>
            <p class="record-description">{!! AllMean::ReplaceNullWithDash($record[0]->note_collector) !!}</p>
          </div>
        </div>

      </div>

      <div role="tabpanel" class="tab-pane" id="thai">

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Marine Center:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($marinecenter[0]) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">กลุ่มสิ่งมีชีวิต:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Collection::getCollectionByID( $record[1]->collection_code )->name_th ) }}</span>
            </p>
          </div>
          @if($record[1]->source == "1")
            <div class="col-md-4">
              <p class="record-label">หมายเลขทะเบียนอ้างอิง:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->catalog_number) }}</span>
              </p>
            </div>
          @endif
        </div>

        @if($record[1]->source == "2")
          <div class="row">
            <div class="col-md-8">
              <p class="record-label">ชื่อเอกสารอ้างอิง:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash( Reference::getReferenceByID( $record[1]->reference )->ref_code ) }} / {{ AllMean::ReplaceNullWithDash( Reference::getReferenceByID( $record[1]->reference )->name_th ) }}</span>
              </p>
            </div>
            <div class="col-md-4">
              <p class="record-label">หน้า:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->page) }}</span>
              </p>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="col-md-12">
            <p class="record-label">Variey Name:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->variety_name ) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">Type Status:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->type_status ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-8">
            <p class="record-label">จำนวนตัวอย่างที่เก็บ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->individual_count) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">เพศ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->sex ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-8">
            <p class="record-label">ขนาดที่เก็บ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->size) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">ระยะการเจริญเติบโตที่พบ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->life_stage ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">มหาสมุทร / ทะเล / ทะเลสาบ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->ocean_sea_lake ,"name_th" )) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">ประเทศ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($country,'country_th') }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">จังหวัด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($province,'province_th') }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">อำเภอ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($district,'district_th') }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-4">
            <p class="record-label">ตำบล:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($county,'county_th') }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">สถานที่:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->locality) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">ละติจูด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->latitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">ลองจิจูด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->longitude) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">ละติจูดเริ่มต้น:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->start_latitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">ละติจูดสิ้นสุด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->end_latitude) }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">ลองจิจูดเริ่มต้น:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->start_longitude) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">ลองจิจูดสิ้นสุด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->end_longitude) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">ระบบนิเวศที่อาศัย:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->habitat ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-3">
            <p class="record-label">ความลึก (ความลึกเริ่มต้น):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->depth_start) }} เมตร</span>
            </p>
          </div>
          <div class="col-md-3">
            <p class="record-label">ความลึกสุดท้าย:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->depth_end) }} เมตร</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">ผู้เก็บ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->collector) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">วันที่เก็บ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate( $record[0]->collected_date)  }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">ผู้จำแนกชนิด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->identifier) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">วันที่จำแนกชนิด:
              <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate( $record[0]->identified_date)  }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">ผู้จำแนกชนิดก่อนหน้านี้:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[0]->previous_identifier) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">วันที่จำแนกชนิดก่อนหน้านี้:
              <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate( $record[0]->previous_identified_date)  }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">อุปกรณ์ / วิธีการ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->gear_method ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">วิธีเก็บรักษา:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->preparation_type ,"name_th" )) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">โครงการสำรวจหรือวิจัย:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->expedition ,"name_en" )) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">หมายเลขทะเบียนใน Gene Bank:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash($record[1]->gene_bank_number) }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">คุณลักษณะเด่นหรือคุณสมบัติพิเศษ:</p>
            <p class="record-description">{{ $record[1]->diagnosis }}</p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">คุณลักษณะอื่นๆ:</p>
            <p class="record-description">{{ $record[1]->description }}</p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">ชื่อพื้นเมือง:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->local_name ) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ชื่อท้องถิ่น (ชื่อพื้นบ้าน):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->vernacular_name ) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">รหัสทีมสำรวจ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->team_exploration_code ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-8">
            <p class="record-label">พื้นที่สำรวจ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->area_exploration ,"name_th" )) }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-4">
            <p class="record-label">หมู่บ้าน (หมู่ที่):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->village_no ) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">สถานที่พบที่ทางทิศ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->area_direction ,"name_th" )) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ของสถานที่ (Area):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->area ) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-6">
            <p class="record-label">การใช้ประโยชน์:
              @forelse($record_utilizations as $record_utilization)
                <span class="record-data">{{ $record_utilization }}</span>
                @if($record_utilization != end($record_utilizations))
                ,
                @endif
              @empty
               -
              @endforelse
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">ผู้ให้ข้อมูล:
              <span class="record-data">{{ $record[1]->recorder }}</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-6">
            <p class="record-label">ภูมิปัญญาชาวบ้าน:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->folk_wisdom ) }}</span>
            </p>
          </div>
          <div class="col-md-6">
            <p class="record-label">หมายเหตุของภูมิปัญญา:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->knowledge_remarks ) }}</span>
            </p>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">อุณภูมิของน้ำ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->water_temperature ) }} องศา C</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ความโปร่งแสงของน้ำ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->transparency ) }} เมตร</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ความเป็นกรด-ด่างของน้ำ (pH):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->water_ph ) }} pH</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">ปริมาณออกซิเจนละลายน้ำ:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->dissolve_oxygen ) }} mg/L</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ปริมาณของแขวนลอย:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->suspended_solid ) }} mg/L</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ค่าความเค็ม:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( $record[1]->salinity ) }} ppt</span>
            </p>
          </div>
        </div>

        <div class="row row-before-line">
          <div class="col-md-12">
            <div class="checkbox view-record-checkbox">
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" @if( $record[1]->specimen_collection == 1 ) checked @endif disabled> การเก็บตัวอย่าง
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox2" @if( $record[1]->specimen_photograph == 1 ) checked @endif disabled> การบันทึกภาพ
                </label>
            </div>
          </div>
        </div>

        <hr class="view-record-line">

        <div class="row">
            <div class="col-md-12">
              <p class="record-label">คุณค่าทางเศรษฐกิจ:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->economic_value,"name_th" ) ) }}</span>
              </p>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <p class="record-label">ถิ่นอาศัยที่พบ:
              <span class="record-data">
                  @forelse($record_places as $record_place)
                    <span class="record-data">{{ $record_place }}</span>
                    @if($record_place != end($record_places))
                    ,
                    @endif
                  @empty
                   -
                  @endforelse
              </span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">ประเภทของพืช:
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->plant_type,"name_th" ) ) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ประเภทของสัตว์ (Type1):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->animal_type1,"name_th" ) ) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">ประเภทของสัตว์ (Type2):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->animal_type2,"name_th" ) ) }}</span>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="record-label">ประเภทของสัตว์ (Type3):
              <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::getWordingWithAttr( $record[1]->animal_type3,"name_th" ) ) }}</span>
            </p>
          </div>
          <div class="col-md-4">
            <p class="record-label">การสืบพันธุ์:
              <span class="record-data">
                @if(strpos($record[1]->reproduction, "1") !== false)
                  {{ "อาศัยเพศ" }}
                @endif
                @if($record[1]->reproduction === "0")
                  {{ "-" }}
                @elseif($record[1]->reproduction === "1_2" )
                  {{ "," }}
                @endif
                @if(strpos($record[1]->reproduction, "2") !== false)
                  {{ "ไม่อาศัยเพศ" }}
                @endif
              </span>
            </p>
          </div>
        </div>
      </div>

      @if ( !is_null( $extra_info ) )
      <div class="container row" style="padding-top: 10px;">
          <div class="panel panel-primary panel-custom">
              <div class="panel-heading" role="tab" id="extra_header">
                  <p class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#extra_info" aria-expanded="false" aria-controls="extra_header">Extra Information <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" style="float: right; line-height: 25px;"></span></a>
                </p>
              </div>

              <div id="extra_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="extra_info">
                  <div class="panel-body">

                    <div class="row">
                        <?php $i = 0; ?>
                        @foreach ( $extra_fields as $extra_field )
                            <div class="col-md-6" @if ( $extra_field->status == 1 ) style="display: none;" @endif >
                              <p class="search-report-dropdown-header">
                                  <b>{{ $extra_field->name }}</b> :
                                  @if ( !empty( $extra_info->{'extra'.($i+1)} ) )
                                    {{ $extra_info->{'extra'.($i+1)} }}
                                  @else
                                    -
                                  @endif
                              </p>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                    </div>

                  </div>
              </div>
          </div>
      </div>
      @endif

    </div>

    <hr class="view-record-line">

    <div class="row">
      <div class="col-md-12">
        <p class="record-label">Image</p>
        <div class="row">
          @if(sizeof($pictures) > 0)
            @foreach($pictures as $picture)
              <div class="col-md-4 view-record-images">
                <div class="crop-image">
                  <img class="image-record" src="{{ "/mrds_file/uploads/images" }}/{{ $picture->path_pic }}" alt="" />
                </div>
                <p class="record-label">Photographer:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( $picture->photographer) }}</span>
                </p>
                <p class="record-label">Caption:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( $picture->caption ) }}</span>
                </p>
              </div>
            @endforeach
          @else
            <div class="col-md-4">
                <img class="no-image" src="{{ url('assets/images/placeholder-image.png') }}" alt="No image" />
            </div>
          @endif
        </div>
      </div>
    </div>

    <hr class="view-record-line">

    <div class="row" style="display:@if(Auth::user()->approve_permission != 1) {{ "none" }} @endif;">
      <div class="col-md-12 view-record-button-box">
        <button class="btn btn-default btn-gold" onclick="window.location.href='{{ url('staff/editRecordForm').'/1/'.base64_encode( base64_encode( base64_encode( $record[0]->id ))).'/'.base64_encode( base64_encode( base64_encode( '3' ))) }}';"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit Record</button>
        <button class="btn btn-default btn-gold" onclick="window.location.href='{{ url('staff/doApproveRecord').'/'.base64_encode( base64_encode( base64_encode( $record[0]->id ))) }}';" style="margin-left:20px;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Approve Record</button>
      </div>
    </div>

    @if( Auth::user()->role_id <= 2 )
      <div class="row">
        <div class="col-md-4">
          <p class="record-label">Add Record:
            <span class="record-data">{{ $users_add[0]->first_name." ".$users_add[0]->last_name }}</span>
          </p>
        </div>
        <div class="col-md-4">
          <p class="record-label">Add Record Date:
            <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate($record[0]->created_at) }} {{ AllMean::ReplaceNullWithDefaultTime2($record[0]->created_at) }}</span>
          </p>
        </div>
        <div class="col-md-4">
          <p class="record-label">Migrate Data:
            <span class="record-data">@if($record[0]->migration_data){{"Yes"}}@else{{"No"}}@endif</span>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <p class="record-label">Edit Record:
            <span class="record-data">{{ $users_update[0]->first_name." ".$users_update[0]->last_name }}</span>
          </p>
        </div>
        <div class="col-md-4">
          <p class="record-label">Edit Record Date:
            <span class="record-data">{{ AllMean::ReplaceNullWithDefaultDate($last_update_time) }} {{ AllMean::ReplaceNullWithDefaultTime2($last_update_time) }}</span>
          </p>
        </div>
        @if( $record[0]->approve_status != 0 )
        <div class="col-md-4">
          <p class="record-label">Approve By:
            <span class="record-data">{{ $users_approve[0]->first_name." ".$users_approve[0]->last_name }}</span>
          </p>
        </div>
        @endif
      </div>
    @endif

  </div>
</div>

@endsection
