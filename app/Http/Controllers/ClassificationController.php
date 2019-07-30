<?php

/*********************************************
    Project:	MRDS
    Developer:	Sorawit
    fucntion:	Add Classification 7/3/2016
*********************************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Hash;
use Redirect;
use Session;
use Auth;
use App\Model\Users;
use App\Model\Classification;
use App\Model\Taxonomy;
use App\Model\Marinecenter;
use App\Model\Record;
use App\Model\Language;
use App\Model\Wording;
use App\Model\System_Log;
use App\Model\AllMean;
use App\Model\CatchException;
use Yajra\Datatables\Datatables;


class ClassificationController extends Controller
{
	/**
	* Show the profile for the given user.
	*
	* @param  int  $id
	* @return Response
	*/

	//Sorawit
	//Created : 7-3-59
	//Modified : -
	public function checkClassificationForm(){
		$data['classifications'] = Classification::getNameAndIDClassification();

		//for check error
		$data['action'] = Session::get('action');
		Session::forget('action');

		Session::forget('classification_id_form_add');
		Session::forget('record_id_add_en');
		Session::forget('record_id_add_th');
		return view('staff.classification.check_classification_form', $data);
	}

	//Sorawit
	//Created : 7-3-59
	//Modified : 18-3-59
	public function addClassificationForm(Request $input) {
		$classification_id = $input->classification_id;

		//if ($classification_id != '') {	//for autocomplete
		if ($classification_id != 0) {
			if ( Classification::getClassification($classification_id) ) {
				Session::put('classification_id_form_add', $classification_id);
				return redirect('staff/addRecordForm/');
			} else {
				//error by hack
				return redirect('staff/checkClassificationForm');
			}
		} else {
			$data['cur_sci_name'] = $input->cur_sci_name;
			$data['domains'] = Taxonomy::getDomain();
			$data['kingdoms'] = Taxonomy::getKingdom();
			$data['subkingdoms'] = Taxonomy::getSubkingdom();
			$data['infrakingdoms'] = Taxonomy::getInfrakingdom();
			$data['phylums'] = Taxonomy::getPhylum();
			$data['subphylums'] = Taxonomy::getSubphylum();
			$data['infraphylums'] = Taxonomy::getInfraphylum();
			$data['superclasses'] = Taxonomy::getSuperclass();
			$data['classes'] = Taxonomy::getClass();
			$data['subclasses'] = Taxonomy::getSubclass();
			$data['infraclasses'] = Taxonomy::getInfraclass();
			$data['superorders'] = Taxonomy::getSuperorder();
			$data['orders'] = Taxonomy::getOrder();
			$data['suborders'] = Taxonomy::getSuborder();
			$data['infraorders'] = Taxonomy::getInfraorder();
			$data['superfamilys'] = Taxonomy::getSuperfamily();
			$data['familys'] = Taxonomy::getFamily();
			$data['subfamilys'] = Taxonomy::getSubfamily();
			$data['genuses'] = Taxonomy::getGenus();
			$data['subgenuses'] = Taxonomy::getSubgenus();
			$data['specieses'] = Taxonomy::getSpecies();
			$data['subspecieses'] = Taxonomy::getSubspecies();
			$data['identification_qualifiers'] = Wording::getWordingByWordingType(1); // 1 is mean identification_qualifiers
			$data['protection_iucn_2019s'] 	= Wording::getWordingByWordingTypeForForm(12);
			$data['protection_thai_laws'] 	= Wording::getWordingByWordingTypeForForm(22);
			$data['protection_citeses'] 	= Wording::getWordingByWordingTypeForForm(23);
			$data['invasive_species'] 	= Wording::getWordingByWordingTypeForForm(26);
			$data['livings'] 	= Wording::getWordingByWordingTypeForForm(27);

			return view('staff.classification.add.add_classification_form', $data);
		}
	}

	//Chaloemphon
	//Created : 22-3-59
	//Modified : 19-4-61
	public function manageClassification(){
		$data['action']			=	Session::get('action');
		Session::forget('action');
		return view('staff.classification.classification_list', $data);
	}

	//Chaloemphon
	//Created : 19-4-61
	//Modified : -
	public function getClassificationDataTable(){
		$query = Classification::query();
		$btn = '';
            return Datatables::of($query)
                        ->editColumn('status', '{{ $status == 1 ? "Disabled" : "Enabled" }}')
                        ->addColumn('action', function ($query) use ($btn) {
                            $btn .= '<a href="'.url('staff/viewClassification', base64_encode( base64_encode( base64_encode( $query->id ))) ).'">
										<span class="glyphicon glyphicon-eye-open"></span> View
									</a>
									<span class="between-tools"> | </span>
									<a href="'.url('staff/editClassificationForm' , [$query->id]).'" id="edit_button">
										<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
									</a>';

                            return $btn;
						})
                        ->rawColumns(['current_scientific_name_format','action'])
                        ->addIndexColumn()
                        ->make(true);
	}

	//Chaloemphon
	//Created : 22-3-59
	//Modified : -
	public function editClassificationForm($classification_id){

		$data['domains'] = Taxonomy::getDomain();
		$data['kingdoms'] = Taxonomy::getKingdom();
		$data['subkingdoms'] = Taxonomy::getSubkingdom();
		$data['infrakingdoms'] = Taxonomy::getInfrakingdom();
		$data['phylums'] = Taxonomy::getPhylum();
		$data['subphylums'] = Taxonomy::getSubphylum();
		$data['infraphylums'] = Taxonomy::getInfraphylum();
		$data['superclasses'] = Taxonomy::getSuperclass();
		$data['classes'] = Taxonomy::getClass();
		$data['subclasses'] = Taxonomy::getSubclass();
		$data['infraclasses'] = Taxonomy::getInfraclass();
		$data['superorders'] = Taxonomy::getSuperorder();
		$data['orders'] = Taxonomy::getOrder();
		$data['suborders'] = Taxonomy::getSuborder();
		$data['infraorders'] = Taxonomy::getInfraorder();
		$data['superfamilys'] = Taxonomy::getSuperfamily();
		$data['familys'] = Taxonomy::getFamily();
		$data['subfamilys'] = Taxonomy::getSubfamily();
		$data['genuses'] = Taxonomy::getGenus();
		$data['subgenuses'] = Taxonomy::getSubgenus();
		$data['specieses'] = Taxonomy::getSpecies();
		$data['subspecieses'] = Taxonomy::getSubspecies();
		$data['identification_qualifiers'] = Wording::getWordingByWordingType(1); // 2 is mean identification_qualifiers
		$data['classifications'] = Classification::getClassification($classification_id);
		$data['protection_iucn_2019s'] 	= Wording::getWordingByWordingTypeForForm(12);
		$data['protection_thai_laws'] 	= Wording::getWordingByWordingTypeForForm(22);
		$data['protection_citeses'] 	= Wording::getWordingByWordingTypeForForm(23);
		$data['invasive_species'] 	= Wording::getWordingByWordingTypeForForm(26);
		$data['livings'] 	= Wording::getWordingByWordingTypeForForm(27);

		return view('staff.classification.edit.edit_classification_form', $data);
	}

	//Sorawit
	//Created : 9-3-59
	//Modified : -
	public function doAddClassification(Request $input) {
		$iq 				= $input->iq;
		$pre_sci_name 		= $input->pre_sci_name;

		$domain 			= 	$input->domain;
		$kingdom 			= 	$input->kingdom;
		$subkingdom 		= 	$input->subkingdom;
		$infrakingdom 		= 	$input->infrakingdom;
		$phylum 			= 	$input->phylum;
		$subphylum 			= 	$input->subphylum;
		$infraphylum 		= 	$input->infraphylum;
		$superclass 		= 	$input->superclass;
		$class 				= 	$input->class;
		$subclass 			= 	$input->subclass;
		$infraclass 		= 	$input->infraclass;
		$superorder 		= 	$input->superorder;
		$order 				= 	$input->order;
		$suborder 			= 	$input->suborder;
		$infraorder 		= 	$input->infraorder;
		$superfamily 		= 	$input->superfamily;
		$family 			= 	$input->family;
		$subfamily 			= 	$input->subfamily;
		$genus 				= 	$input->genus;
		$subgenus 			= 	$input->subgenus;
		$species 			= 	$input->species;
		$subspecies 		= 	$input->subspecies;
		$cur_sci_name 		= 	$input->cur_sci_name;
		$common_name 		=	$input->common_name;
		$protection_thai_law	=	$input->protection_thai_law;
		$protection_iucn_2019	=	$input->protection_iucn_2019;
		$protection_cites	=	$input->protection_cites;
		$invasive_species	=	$input->invasive_species;
		$living			=	$input->living;

		$lastId 		= Classification::addClassification($cur_sci_name, $iq, $pre_sci_name,
						$domain, $kingdom, $subkingdom, $infrakingdom, $phylum, $subphylum, $infraphylum, $superclass, $class, $subclass, $infraclass,
						$superorder, $order, $suborder, $infraorder, $superfamily, $family, $subfamily,
						$genus, $subgenus, $species, $subspecies, $common_name, $protection_thai_law, $protection_iucn_2019, $protection_cites, $invasive_species, $living);

		if ( $lastId ) {
			System_Log::Loging(
				'classification', // table_name
				$lastId, // row_id
				AllMean::defineAdd(),  // action
				"", // old_data
				Classification::getClassification($lastId)->toArray()// new_data
			);

			$classification_id = $lastId;
			Session::put('classification_id_form_add', $classification_id);
			return redirect('staff/addRecordForm/');
		} else {
			$action = AllMean::defineAddAlertFail();
		}
		Session::put('action', $action);
        return redirect('staff/checkClassificationForm');
	}

	//Chaloemphon
	//Created : 22-3-59
	//Modified : -
	public function doEditClassification(Request $input) {
		$classification_id 	= 	$input->classification_id;
		$cur_sci_name 		= 	$input->cur_sci_name;
		$iq 				= 	$input->iq;
		$pre_sci_name 		= 	$input->pre_sci_name;

		$domain 			= 	$input->domain;
		$kingdom 			= 	$input->kingdom;
		$subkingdom 		= 	$input->subkingdom;
		$infrakingdom 		= 	$input->infrakingdom;
		$phylum 			= 	$input->phylum;
		$subphylum 			= 	$input->subphylum;
		$infraphylum 		= 	$input->infraphylum;
		$superclass 		= 	$input->superclass;
		$class 				= 	$input->class;
		$subclass 			= 	$input->subclass;
		$infraclass 		= 	$input->infraclass;
		$superorder 		= 	$input->superorder;
		$order 				= 	$input->order;
		$suborder 			= 	$input->suborder;
		$infraorder 		= 	$input->infraorder;
		$superfamily 		= 	$input->superfamily;
		$family 			=	$input->family;
		$subfamily 			=	$input->subfamily;
		$genus 				=	$input->genus;
		$subgenus 			=	$input->subgenus;
		$species 			=	$input->species;
		$subspecies 		=	$input->subspecies;
		$status 			=	$input->status_switch;
		$common_name 		=	$input->common_name;
		$protection_thai_law	=	$input->protection_thai_law;
		$protection_iucn_2019	=	$input->protection_iucn_2019;
		$protection_cites	=	$input->protection_cites;
		$invasive_species	=	$input->invasive_species;
		$living				=	$input->living;

		if (Classification::updateClassification($classification_id, $cur_sci_name, $iq, $pre_sci_name,
							$domain, $kingdom, $subkingdom, $infrakingdom, $phylum, $subphylum, $infraphylum, $superclass, $class, $subclass, $infraclass,
						 	$superorder, $order, $suborder, $infraorder, $superfamily, $family, $subfamily,
							$genus, $subgenus, $species, $subspecies , AllMean::ConvertSwitchStatus($status), $common_name, $protection_thai_law, $protection_iucn_2019, $protection_cites,
							$invasive_species, $living) ) {

			System_Log::Loging( 'classification',  // table_name
								$input->classification_id, // row_id
								AllMean::defineEdit(), // action
								System_Log::getOldData(), // old_data
								Classification::getClassification($input->classification_id)->toArray() ); // new_data

			$action = AllMean::defineEditAlertSuccess();
		} else {
			$action = AllMean::defineEditAlertFail();
		}
		Session::put('action', $action);

		return redirect('staff/manageClassification');
	}

	//Sorawit
	//Created : 31-3-59
	//Modified : -
	public function changeClassification($record_id, $classification_id){
		$data['record_id'] = base64_decode(base64_decode(base64_decode($record_id)));
		$data['classification_id'] = base64_decode(base64_decode(base64_decode($classification_id)));
		$data['record'] = Record::getRecord($data['record_id']);
		$data['classification'] = Classification::getClassification($data['classification_id']);

		$data['iq'] = Wording::getWording($data['classification']->identification_qualifier);
		if(is_null($data['iq'])){
			$data['iq'] = null;
		}else{
			$data['iq']->name_en;
		}

		$data['domain'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->domain);
		$data['phylum'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->phylum);
		$data['class'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->class);
		$data['infraclass'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->infraclass);
		$data['superorder'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->superorder);
		$data['suborder'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->suborder);
		$data['superfamily'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->superfamily);
		$data['subfamily'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->subfamily);
		$data['genus'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->genus);
		$data['species'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->species);
		$data['kingdom'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->kingdom);
		$data['subphylum'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->subphylum);
		$data['subclass'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->subclass);
		$data['order'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->order);
		$data['infraorder'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->infraorder);
		$data['family'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->family);
		$data['subgenus'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->subgenus);
		$data['subspecies'] = AllMean::checkNullOrZeroReturnTaxonomy($data['classification']->subspecies);

		if ( $data['classification'] != null && $data['record'] != null ) {
			$back_page = $data['record']->source;
			if ( $back_page == 1) {
				$data['back_page'] = 'editRecordForm/1/'.base64_encode(base64_encode(base64_encode($data['record_id'])));
			} else {
				$data['back_page'] = 'editRecordForm/2/'.base64_encode(base64_encode(base64_encode($data['record_id'])));
			}
			$data['classifications'] = Classification::getNameAndIDClassification();
			return view('staff.classification.change.change_classification', $data);
		} else {
			return redirect('staff/manageRecord');
		}
	}

	//Sorawit
	//Created : 31-3-59
	//Modified : -
	public function doChangeClassification(Request $input){
		$data['record'] = Record::getRecord($input->record_id);
		$data['classification'] = Classification::getClassification($input->cur_sci_name);
		if ( $data['classification'] != null && $data['record'] != null ) {
			$back_page = $data['record']->source;
			if ( $back_page == 1) {
				$data['back_page'] = 'manageRecordSpecimens';
			} else {
				$data['back_page'] = 'manageRecordPublication';
			}

			//change classification for record
			$records = Record::getFullRecord($data['record']->id);
			foreach( $records as $record ) {
				$db = Record::find($record->id);
				$db->classification_id = $input->cur_sci_name;
				$lastId = CatchException::catcherEdit($db);
				//log setting
				if ( $lastId ) {

				} else {
					$action = AllMean::defineAddAlertFail();
					Session::put('action', $action);
		        	return redirect('staff/managerRecord');
				}
			}
			return redirect('staff'.'/'.$data['back_page']);
		} else {
			return redirect('staff/manageRecord');
		}
	}

	public function CreateScientificName($genus, $subgenus, $iq1, $species, $iq2 ,$subspecies, $authorname, $year, $revision){
		$str = $genus;
		if($subgenus != ""){
			$str .= " (".$subgenus.")";
		}

		if($iq1 != ""){
			$str .= " ".$iq1;
		}

		$str .= $species;

		if($iq2 != ""){
			$str .= " ".$iq2;
		}

		if($subspecies != ""){
			$str .= " (".$subspecies.")";
		}

		if($revision != ""){
			$str .= " (".$authorname.",".$year.")";
		}else{
			$str .= " ".$authorname.",".$year;
		}

		return $str;

	}

	//Sorawit
	//Created : 7-6-59
	//Modified : 9-6-59
	# show detail for Classification
	public function viewClassification($classification_id) {
		$classification_id = base64_decode( base64_decode( base64_decode( $classification_id ) ) );
		$data['classification'] = Classification::getClassification($classification_id);
		$data['users_add'] =	Users::getUserById( $data['classification']->created_by );
		$data['users_update'] =	Users::getUserById( $data['classification']->updated_by );
		return view('staff.classification.view_classification', $data);
	}


}
