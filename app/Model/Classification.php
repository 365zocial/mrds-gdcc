<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Auth;
use Session;

use App\Model\AllMean;
use App\Model\System_Log;
use App\Model\CatchException;
use App\Model\Header_Taxonomy;

class Classification extends Model
{
	protected $table = 'classification';

	public static function addClassification($cur_sci_name, $iq, $pre_sci_name, $domain, $kingdom, $subkingdom, $infrakingdom, $phylum, $subphylum, $infraphylum, $superclass, $class, $subclass, $infraclass, $superorder, $order_o, $suborder, $infraorder, $superfamily, $family, $subfamily, $genus, $subgenus, $species, $subspecies, $common_name, $protection_thai_law, $protection_iucn, $protection_cites, $migrate = false) {

		//get $created_by
		$count_classduplicate = Classification::where('current_scientific_name', AllMean::checkAndCutForNoneBackSpace( strip_tags($cur_sci_name) ) )
						->count();

		if($count_classduplicate == 0){
			$db = new Classification;
			$db->current_scientific_name 			= 	AllMean::checkAndCutForNoneBackSpace( strip_tags($cur_sci_name) );
			$db->current_scientific_name_format 	= 	$cur_sci_name;
			$db->previous_scientific_name 			= 	AllMean::checkAndCutForNoneBackSpace( strip_tags($pre_sci_name) );
			$db->previous_scientific_name_format 	= 	$pre_sci_name;
			$db->domain 							= 	$domain;
			$db->kingdom 							= 	$kingdom;
			$db->subkingdom							= 	$subkingdom;
			$db->infrakingdom						= 	$infrakingdom;
			$db->phylum								= 	$phylum;
			$db->subphylum							= 	$subphylum;
			$db->infraphylum						= 	$infraphylum;
			$db->superclass 						= 	$superclass;
			$db->class 								= 	$class;
			$db->subclass 							= 	$subclass;
			$db->infraclass 						= 	$infraclass;
			$db->superorder 						= 	$superorder;
			$db->order_o 							= 	$order_o;
			$db->suborder 							= 	$suborder;
			$db->infraorder 						= 	$infraorder;
			$db->superfamily 						= 	$superfamily;
			$db->family 							= 	$family;
			$db->subfamily 							= 	$subfamily;
			$db->genus 								= 	$genus;
			$db->subgenus 							= 	$subgenus;
			$db->species 							= 	$species;
			$db->subspecies 						= 	$subspecies;
			$db->identification_qualifier 			= 	$iq;
			$db->protection_thai_law				=	$protection_thai_law;
			$db->protection_iucn					=	$protection_iucn;
			$db->protection_cites					=	$protection_cites;
			$db->common_name						=	$common_name;

			$db->status 							= 	2;
			$db->migration_data 					= 	$migrate;

			if (Auth::check()) {
				$db->created_by         =   Auth::user()->id;
				$db->updated_by         =   Auth::user()->id;
			}else{
				$db->created_by         =   1;
				$db->updated_by         =   1;
			}

			return CatchException::catcherAdd($db);
		}else{
			Session::put('exception_catcher','Classification '.$cur_sci_name.' is Duplicate. Please check this classification in Manage Classification list');
            return false;
		}

    }

	public static function updateClassification($id, $cur_sci_name, $iq, $pre_sci_name, $domain, $kingdom, $subkingdom, $infrakingdom, $phylum, $subphylum, $infraphylum, $superclass, $class, $subclass, $infraclass, $superorder, $order_o, $suborder, $infraorder, $superfamily, $family, $subfamily, $genus, $subgenus, $species, $subspecies, $status, $common_name, $protection_thai_law, $protection_iucn, $protection_cites){

		//get $created_by
    	$created_by 					=	Auth::user()->id;

		// ตรวจสอบว่าชื่อซ้ำและไม่ใช่ id ตัวเองหรือไม่ ถ้ามี จะแก้ไข classification ไม่ได้
		$count_classduplicate = Classification::where('current_scientific_name', AllMean::checkAndCutForNoneBackSpace( strip_tags( $cur_sci_name ) ) )->where('id', '!=', $id)->count();

		if ( $count_classduplicate == 0 ) {
	    	$db 							=	Classification::find($id);
			System_Log::setOldData($db->toArray());

			$db->current_scientific_name 			= AllMean::checkAndCutForNoneBackSpace( strip_tags($cur_sci_name) );
			$db->current_scientific_name_format 	= $cur_sci_name;
			$db->previous_scientific_name 			= AllMean::checkAndCutForNoneBackSpace(strip_tags($pre_sci_name) );
			$db->previous_scientific_name_format 	= $pre_sci_name;
			$db->domain 							= 	$domain;
			$db->kingdom 							= 	$kingdom;
			$db->subkingdom							= 	$subkingdom;
			$db->infrakingdom						= 	$infrakingdom;
			$db->phylum								= 	$phylum;
			$db->subphylum							= 	$subphylum;
			$db->infraphylum						= 	$infraphylum;
			$db->superclass 						= 	$superclass;
			$db->class 								= 	$class;
			$db->subclass 							= 	$subclass;
			$db->infraclass 						= 	$infraclass;
			$db->superorder 						= 	$superorder;
			$db->order_o 							= 	$order_o;
			$db->suborder 							= 	$suborder;
			$db->infraorder 						= 	$infraorder;
			$db->superfamily 						= 	$superfamily;
			$db->family 							= 	$family;
			$db->subfamily 							= 	$subfamily;
			$db->genus 								= 	$genus;
			$db->subgenus 							= 	$subgenus;
			$db->species 							= 	$species;
			$db->subspecies 						= 	$subspecies;
			$db->identification_qualifier 			= 	$iq;
			$db->status 							= 	$status;
			$db->protection_thai_law				=	$protection_thai_law;
			$db->protection_iucn					=	$protection_iucn;
			$db->protection_cites					=	$protection_cites;
			$db->common_name						=	$common_name;
			$db->created_by 						= 	$created_by;
			$db->updated_by 						= 	$created_by;
		} else {
			Session::put('exception_catcher','Classification is Dupliicate. Please check this classification in Manage Classification list');
			return false;
		}

		return CatchException::catcherEdit($db);
	}

    //for autocomplete
    public static function getNameAndIDClassification() {
    	return Classification::select('id', 'current_scientific_name', 'current_scientific_name_format')->where('status', 2)->get();
    }

    public static function getClassification($classification_id) {
    	return Classification::where('id', $classification_id)->first();
    }

	public static function getClassificationList(){
		return Classification::orderBy('id', 'asc')->get();
	}

	public static function getClassificationListEnableSearchReport(){
		return Classification::select('id', 'current_scientific_name as name')->where('status', 2)->orderBy('id', 'asc')->get();
	}

	public static function getClassificationByHeaderTaxonomy(){

	}

	public static function getWithRecord()
	{
		return Classification::join('record', 'classification.id', '=', 'record.classification_id');
	}

	public static function CheckDuplicateClassification($class_name)
	{

		return Classification::where('current_scientific_name' ,str_replace("_","",$class_name))->first();
	}

	public static function getClassificationByTaxonomy( $header_taxonomy_id, $taxonomy_id ) {
		$header_taxonomy = Header_Taxonomy::getHeaderTaxonomy($header_taxonomy_id);

		// convert small word
		$header_taxonomy = strtolower($header_taxonomy);

		// change order to order_o for column search
		if( $header_taxonomy == 'order' ) $header_taxonomy = 'order_o';

		return Classification::where('status', 2)->where($header_taxonomy, $taxonomy_id)->get();
	}

}
