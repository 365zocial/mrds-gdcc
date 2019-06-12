<?php
  use App\Model\Wording;
?>

<div class="panel panel-primary panel-custom">

    <div class="panel-heading" role="tab" id="headingTwo">
        <p class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">{!! $classification->current_scientific_name_format !!} <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" style="float: right; line-height: 25px;"></span></a>
      </p>
    </div>

    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">

          <div class="row">
            <div class="col-md-12">
              <p class="record-label">Scientific Name:
                <span class="record-data">{!! $classification->current_scientific_name_format !!}</span>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <p class="record-label">Identification Qualifier:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($iq) }}</span>
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

          <hr class="view-record-line manage-record">

          <div class="row">
            <div class="col-md-6">
              <p class="record-label">Domain:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[0]['name']) }}</span>
              </p>
            </div>
            <div class="col-md-6">
              <p class="record-label">Kingdom:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[1]['name']) }}</span>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <p class="record-label">Subkingdom:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[2]['name']) }}</span>
              </p>
            </div>
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
            <div class="col-md-12">
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
            <div class="col-md-12">
              <p class="record-label">Subfamily (Clade):
                <span class="record-data">{{ AllMean::ReplaceNullWithDash($taxonomy[17]['name']) }}</span>
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <p class="record-label">Genus:
                <span class="record-data"><i>{{ ucfirst( AllMean::ReplaceNullWithDash($taxonomy[18]['name']) ) }}</i></span>
              </p>
            </div>
            <div class="col-md-6">
              <p class="record-label">Subgenus:
                <span class="record-data"><i>{{ ucfirst( AllMean::ReplaceNullWithDash($taxonomy[19]['name']) ) }}</i></span>
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

          <hr class="view-record-line manage-record">

          <div class="row">
            <div class="col-md-12">
              <p class="record-label">Common Name:
                <span class="record-data">{{ AllMean::ReplaceNullWithDash( $classification->common_name ) }}</span>
              </p>
            </div>
          </div>

          <hr class="view-record-line manage-record">

          <div class="row">
              <div class="col-md-12">
                <p class="record-label">Protection Thai Law:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_thai_law ), "name_th" ) }}</span>
                </p>
              </div>
              <div class="col-md-12">
                <p class="record-label">Protection IUCN/ONEP:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_iucn_onep ), "name_en" ) }} @if( $classification->protection_iucn_onep != null ) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_iucn_onep ), "name_th" ) }}) @endif</span>
                </p>
              </div>
              <div class="col-md-12">
                <p class="record-label">Protection CITES:
                  <span class="record-data">{{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_cites ), "name_en" ) }} @if ($classification->protection_cites != null) ({{ AllMean::ReplaceNullWithDash( Wording::find($classification->protection_cites ), "name_th" ) }}) @endif</span>
                </p>
              </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                  @if($can_change_class)
                    <a href="{{ url('staff/changeClassification'.'/'.base64_encode(base64_encode(base64_encode($record->id))).'/'.base64_encode(base64_encode(base64_encode($record->classification_id))) ) }}" class="btn btn-default">Change Classification</a>
                  @endif
              </div>
          </div>

        </div>
    </div>
</div>
