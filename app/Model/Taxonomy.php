<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Auth;
use Session;
use App\Model\System_Log;
use App\Model\CatchException;


class Taxonomy extends Model
{
	protected $table = 'taxonomy';

    public static function getTaxonomyList() {
    	return Taxonomy::orderBy('header_taxonomy_id', 'asc')
					->orderBy('name', 'asc')
					->get();
    }

	public static function addTaxonomy($header_taxonomy, $taxonomy) {

		$check_same_taxo = Taxonomy::where('header_taxonomy_id', $header_taxonomy)->where('name', $taxonomy)->count();
		if($check_same_taxo > 0){
			Session::put('exception_catcher','Duplicate Taxonomy same header id as name : '.$taxonomy);
            return false;
		}

    	$db = new Taxonomy;

		if( in_array($header_taxonomy,[21,22]) ){
			$taxonomy = strtolower($taxonomy);
		}else{
			$taxonomy = ucfirst($taxonomy);
		}
		$db->name = $taxonomy;
		$db->header_taxonomy_id = $header_taxonomy;
		$db->status = 2;

		if (Auth::check()) {
				$db->created_by         =   Auth::user()->id;
				$db->updated_by         =   Auth::user()->id;
		}else{
				$db->created_by         =   1;
				$db->updated_by         =   1;
		}

		return CatchException::catcherAdd($db);
	}

	public static function getTaxonomyWording($taxonomy_wording_id) {
		return Taxonomy::where('id', $taxonomy_wording_id)->first();
	}

	public static function getMultipleTaxonmyWording($arr_taxonomy_id){
		$arr = [];
		foreach($arr_taxonomy_id as $value){
			if($value == 0){
				$arr[]['name']	=	"0";
			}else{
				$arr[]	=	Taxonomy::getTaxonomyWording($value)->toArray();
			}
		}
		return $arr;
	}

    public static function updateTaxonomy($taxonomy_wording_id, $wording, $header_taxonomy_id, $status) {

		$check_same_taxo = Taxonomy::where('header_taxonomy_id', $header_taxonomy_id)->where('name', $wording)->where('id', '!=', $taxonomy_wording_id)->count();
		if($check_same_taxo > 0){
			Session::put('exception_catcher','Duplicate Taxonomy same header id as name : '.$taxonomy);
            return false;
		}

    	$db 					=	Taxonomy::find($taxonomy_wording_id);
		System_Log::setOldData($db->toArray());

		if( in_array($header_taxonomy_id,[21,22]) ){
			$wording = strtolower($wording);
		}else{
			$wording = strtolower($wording);
			$wording = ucfirst($wording);
		}

		$db->name 				=	$wording;
		$db->header_taxonomy_id =	$header_taxonomy_id;
		$db->status 			=	$status;
		$db->updated_by 		=	Auth::user()->id;

		return CatchException::catcherEdit($db);
    }

	public static function getTaxonomyByHeader($type_id){
		return Taxonomy::where('header_taxonomy_id', $type_id)->where('status', 2)->get();
	}

    public static function getDomain() {
    	return Taxonomy::where('header_taxonomy_id', 1)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getKingdom() {
    	return Taxonomy::where('header_taxonomy_id', 2)->where('status', 2)->orderBy('name', 'asc')->get();
    }

	public static function getSubkingdom() {
		return Taxonomy::where('header_taxonomy_id', 3)->where('status', 2)->orderBy('name', 'asc')->get();
	}

	public static function getInfrakingdom() {
		return Taxonomy::where('header_taxonomy_id', 4)->where('status', 2)->orderBy('name', 'asc')->get();
	}

    public static function getPhylum() {
    	return Taxonomy::where('header_taxonomy_id', 5)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSubphylum() {
    	return Taxonomy::where('header_taxonomy_id', 6)->where('status', 2)->orderBy('name', 'asc')->get();
    }

	public static function getInfraphylum() {
    	return Taxonomy::where('header_taxonomy_id', 7)->where('status', 2)->orderBy('name', 'asc')->get();
    }

	public static function getSuperclass() {
    	return Taxonomy::where('header_taxonomy_id', 8)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getClass() {
    	return Taxonomy::where('header_taxonomy_id', 9)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSubclass() {
    	return Taxonomy::where('header_taxonomy_id', 10)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getInfraclass() {
    	return Taxonomy::where('header_taxonomy_id', 11)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSuperorder() {
    	return Taxonomy::where('header_taxonomy_id', 12)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getOrder() {
    	return Taxonomy::where('header_taxonomy_id', 13)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSuborder() {
    	return Taxonomy::where('header_taxonomy_id', 14)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getInfraorder() {
    	return Taxonomy::where('header_taxonomy_id', 15)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSuperfamily() {
    	return Taxonomy::where('header_taxonomy_id', 16)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getFamily() {
    	return Taxonomy::where('header_taxonomy_id', 17)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSubfamily() {
    	return Taxonomy::where('header_taxonomy_id', 18)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getGenus() {
    	return Taxonomy::where('header_taxonomy_id', 19)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSubgenus() {
    	return Taxonomy::where('header_taxonomy_id', 20)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSpecies() {
    	return Taxonomy::where('header_taxonomy_id', 21)->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public static function getSubspecies() {
    	return Taxonomy::where('header_taxonomy_id', 22)->where('status', 2)->orderBy('name', 'asc')->get();
    }

}
