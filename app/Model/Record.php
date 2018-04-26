<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Record extends Model
{
    protected $table = 'record';

    public static function getLastCatalogNumber($marinecenter_id) {
    	return Record::where('marinecenter_id', $marinecenter_id)->orderBy('catalog_number', 'desc')->first();
    }

    public static function getRecordTH($record_id) {
    	return Record::where('id', $record_id)->where('language_id', 2)->first();
    }

    public static function getRecord($record_id) {
    	return Record::where('id', $record_id)->first();
    }

    //use record_id english
    public static function getFullRecord($record_id_en) {
        $record = Record::getRecord($record_id_en);
        if ( $record == null ) {
            echo 'Error : get Record';
            exit();
        }

        return Record::where('unique_record', $record->unique_record)->get();
    }

    public static function getRecordBySource($source){
        $query = Record::select('record.id','record.related_catalog_item','record.related_reference_item','classification.current_scientific_name_format','record.page','record.status','w1.name_en as ref_en','w2.name_en as collection_code','marinecenter.marinecenter_code')
                    ->join('classification', 'record.classification_id', '=', 'classification.id')
                    ->leftjoin('wording as w1', 'record.reference', '=', 'w1.id')
                    ->leftjoin('wording as w2', 'record.collection_code', '=', 'w2.id')
                    ->join('marinecenter', 'record.marinecenter_id', '=', 'marinecenter.id')
                    ->where('record.source', $source)
                    ->where('record.approve_status',1);

        if(Auth::user()->role_id == 3){
             $query = $query->where('record.marinecenter_id',Auth::user()->marinecenter_id)

                            ->where('record.status', 2);
        }

        return $query->groupby('record.marinecenter_id','record.collection_code','record.related_catalog_item','record.related_reference_item')
                ->orderBy('record.id', 'desc')
                ->get();
    }

    public static function getLastUniqueRecord(){
        return Record::groupBy('unique_record')
                    ->orderBy('unique_record','desc')
                    ->first();
    }

    public static function getLastDuplicationPublication($marinecenter_id, $collection_id, $reference, $page){
        return Record::where('marinecenter_id', $marinecenter_id)
                    ->where('collection_code', $collection_id)
                    ->where('reference', $reference)
                    ->where('page', $page)
                    ->orderBy('no_species', 'desc')
                    ->first();
    }

    public static function getLastDuplicationPublicationNoSpecies($marinecenter_id, $collection_id, $reference, $page, $no_species){
        return Record::where('marinecenter_id', $marinecenter_id)
                    ->where('collection_code', $collection_id)
                    ->where('reference', $reference)
                    ->where('page', $page)
                    ->where('no_species', $no_species)
                    ->orderBy('no_species', 'desc')
                    ->first();
    }

    public static function getLastNoLocality($marinecenter_id, $collection_id, $reference, $page, $no_species){
        return Record::where('marinecenter_id', $marinecenter_id)
                    ->where('collection_code', $collection_id)
                    ->where('reference', $reference)
                    ->where('page', $page)
                    ->where('no_species', $no_species)
                    ->orderBy('no_locality', 'desc')
                    ->first();
    }

    public static function getRecordPending(){
        $query = Record::where('approve_status',0)
                        ->groupby('marinecenter_id','collection_code','related_catalog_item','related_reference_item');
        if(Auth::user()->role_id == 3){
            $query->where('marinecenter_id', Auth::user()->marinecenter_id);
        }
        return $query->get();

    }

    public function getRecordWithClassification()
    {
        $query = Record::where()->get();
    }

    public static function getMaxUniqueRecord() {
		return Record::max('unique_record');
	}

    #------------------------#
    # Search Category B Type #
    #------------------------#
        // public static function searchByIDCatalog( $source, $related_id ) {
        //     // check condition
        //     if( $source == 1 ) { // 1 is specimens
        //         $source_name = 'related_catalog_item';
        //     } else {  // 2 is publication
        //         $source_name = 'related_reference_item';
        //     }
        //
        //     // query db
        //     $data = Record::where('language_id', 1)->where('status', 2)->where('source', $source)->where($source_name, 'like', '%'.$related_id.'%')->get();
        //     return $data;
        // }
        //
        // public static function searchByDate( $source, $date_type, $start_date, $end_date ) {
        //     // set end_date format
        //     $end_time = date_create('23:59:59');
        //     $end_time = date_format($end_time,'H:i:s');
        //     $end_date = date('Y-m-d H:i:s', strtotime($end_date.' '.$end_time));
        //
        //     // check condition
        //     if( $date_type == 1 ) { // Collected Date
        //         $date_type_name = 'collected_date';
        //     } else { // Identified Date
        //         $date_type_name = 'identified_date';
        //     }
        //
        //     // query db
        //     $data = Record::where('language_id', 1)->where('status', 2)->where('source', $source)->whereBetween($date_type_name, [$start_date, $end_date])->get();
        //     return $data;
        // }
        //
        // public static function searchByName( $source, $name_type, $name ) {
        //     // check condition
        //     if( $name_type == 1 ) { // 1 is Collector
        //         $name_type = 'collector';
        //     } else { // 2 is Identifier
        //         $name_type = 'identifier';
        //     }
        //
        //     // query db
        //     $data = Record::where('language_id', 1)->where('status', 2)->where('source', $source)->where($name_type, 'like', '%'.$name.'%')->get();
        //     return $data;
        // }
        //
        // public static function searchByTaxonomy( $source, $classification_id_array ) {
        //     return Record::where('language_id', 1)->where('status', 2)->where('source', $source)->whereIn('classification_id', $classification_id_array)->get();
        // }
        //
        // public static function searchByOceanSeaLake( $ocean_sea_lake_id ) {
        //     return Record::where('language_id', 1)->where('status', 2)->where('ocean_sea_lake', $ocean_sea_lake_id)->get();
        // }
        //
        // public static function searchByCountry( $country_id ) {
        //     return Record::where('language_id', 1)->where('status', 2)->where('country', $country_id)->get();
        // }
        //
        // public static function searchByProvince( $province_id ) {
        //     return Record::where('language_id', 1)->where('status', 2)->where('province', $province_id)->get();
        // }
        //
        // public static function searchByDistrict( $district_id ) {
        //     return Record::where('language_id', 1)->where('status', 2)->where('district', $district_id)->get();
        // }
        //
        // public static function searchByCounty( $county_id ) {
        //     return Record::where('language_id', 1)->where('status', 2)->where('county', $county_id)->get();
        // }
        //
        // public static function searchByLocality( $locality ) {
        //     return Record::where('status', 2)->where('locality', 'like', '%'.$locality.'%')->get();
        // }
    #------------------------#


}
