<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use DB;

use App\Http\Controllers\SearchTypeAController;

use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Classification;
use App\Model\Taxonomy;
use App\Model\Header_Taxonomy;
use App\Model\Record;
use App\Model\Picture;
use App\Model\AllMean;
use App\Model\Reference;
use App\Model\Wording;


class AjaxController extends Controller
{
    public function getProvinceInCountry(Request $input)
    {
        $data['country']    =   Country::getCountryEnable($input->id);

        if (Session::get('language') == 1) {
            $data['provinces']  =   Province::getProvinceEnableInCountry($data['country']->id);
        } else {
            $data['provinces']  =   Province::getProvinceEnableInCountry_TH($data['country']->id);
        }

        return Response::json($data['provinces']);
    }

    public function getDistrictInProvince(Request $input)
    {
        $data['province']   =   Province::getProvinceEnable($input->id);
        if (Session::get('language') == 1) {
            $data['districts']  =   District::getDistrictEnableInProvince($data['province']->id);
        } else {
            $data['districts']  =   District::getDistrictEnableInProvince_TH($data['province']->id);
        }

        return Response::json($data['districts']);
    }

    public function getCountyInDistrict(Request $input)
    {
        $data['district']   =   District::getDistrictEnable($input->id);

        if (Session::get('language') == 1) {
            $data['countys']    =   County::getCountyEnableInDistrict($data['district']->id);
        } else {
            $data['countys']    =   County::getCountyEnableInDistrict_TH($data['district']->id);
        }

        return Response::json($data['countys']);
    }

    public function getInfoClassification(Request $input)
    {
        $classification = Classification::getClassification($input->classification_id);
        $data['current_scientific_name'] = $classification->current_scientific_name;
        $data['identification_qualifier'] = $classification->identification_qualifier;
        $data['previous_scientific_name'] = $classification->previous_scientific_name;

        $data['domain'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->domain);
        $data['phylum'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->phylum);
        $data['class'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->class);
        $data['infraclass'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->infraclass);
        $data['superorder'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->superorder);
        $data['suborder'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->suborder);
        $data['superfamily'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->superfamily);
        $data['subfamily'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->subfamily);
        $data['genus'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->genus);
        $data['species'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->species);
        $data['kingdom'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->kingdom);
        $data['subphylum'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->subphylum);
        $data['subclass'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->subclass);
        $data['order'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->order);
        $data['infraorder'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->infraorder);
        $data['family'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->family);
        $data['subgenus'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->subgenus);
        $data['subspecies'] = AllMean::checkNullOrZeroReturnTaxonomy($classification->subspecies);
        //
        // $data['domain'] = Taxonomy::getTaxonomyWording($classification->domain)->name;
        // $data['phylum'] = Taxonomy::getTaxonomyWording($classification->phylum)->name;
        // $data['class'] = Taxonomy::getTaxonomyWording($classification->class)->name;
        // $data['infraclass'] = Taxonomy::getTaxonomyWording($classification->infraclass)->name;
        // $data['superorder'] = Taxonomy::getTaxonomyWording($classification->superorder)->name;
        // $data['suborder'] = Taxonomy::getTaxonomyWording($classification->suborder)->name;
        // $data['superfamily'] = Taxonomy::getTaxonomyWording($classification->superfamily)->name;
        // $data['subfamily'] = Taxonomy::getTaxonomyWording($classification->subfamily)->name;
        // $data['genus'] = Taxonomy::getTaxonomyWording($classification->genus)->name;
        // $data['species'] = Taxonomy::getTaxonomyWording($classification->species)->name;
        // $data['kingdom'] = Taxonomy::getTaxonomyWording($classification->kingdom)->name;
        // $data['subphylum'] = Taxonomy::getTaxonomyWording($classification->subphylum)->name;
        // $data['subclass'] = Taxonomy::getTaxonomyWording($classification->subclass)->name;
        // $data['order'] = Taxonomy::getTaxonomyWording($classification->order)->name;
        // $data['infraorder'] = Taxonomy::getTaxonomyWording($classification->infraorder)->name;
        // $data['family'] = Taxonomy::getTaxonomyWording($classification->family)->name;
        // $data['subgenus'] = Taxonomy::getTaxonomyWording($classification->subgenus)->name;
        // $data['subspecies'] = Taxonomy::getTaxonomyWording($classification->subspecies)->name;
        return response()->json($data);
    }


    public function getTaxonomyByHeader_Taxonomy(Request $input)
    {
        $data['taxonomy']   =   Taxonomy::getTaxonomyByHeader($input->id_header);
        return Response::json($data);
    }

    public function getLastDuplicationPublication(Request $input)
    {

        $data['recordduplicate'] = Record::getLastDuplicationPublicationNoSpecies($input->marinecenter_id, $input->collection_id, $input->reference, $input->page, $input->no_species);
        return Response::json($data);
    }

    public function getTaxonomyName(Request $input)
    {
        $data['taxonomyname'] = Taxonomy::where('id', $input->id)->first();
        return Response::json($data);
    }

    //Sorawit
    //Created : 14-6-59
    //Modified : -
    public function getTaxonomyFromHeaderTaxonomy(Request $input)
    {
        $data['taxonomys'] = Taxonomy::getTaxonomyByHeader($input->header_taxonomy_id);
        return Response::json($data['taxonomys']);
    }

    //Sorawit
    //Created : 15-6-59
    //Modified : -
    public function getDataLocalityBySearch(Request $input)
    {
        $data = null;
        $content = "";

        $locality_type = $input->locality_type;
        $data['locality_type'] = $locality_type;

        if ($locality_type == 1) { // Ocean/Sea/Lake
            $data['datas'] = Wording::getWordingByWordingTypeForForm(3);
        } elseif ($locality_type == 2) {   // Country
            $data['datas'] = Country::getCountryListOrderByEn();
        } elseif ($locality_type == 3) {   // Province
            $data['datas'] = Province::getProvinceListOrderByEn();
        } elseif ($locality_type == 4) {   // District
            $data['datas'] = District::getDistrictListOrderByEn();
        } elseif ($locality_type == 5) {   // County
            $data['datas'] = County::getCountyListOrderByEn();

            // $datas = County::getCountyListOrderByEn();
            // foreach ( $datas as $data ) {
            //     $content .= "<option value=".$data->id.">".$data->county_en."/".$data->county_th."</option>";
            // }
            // $data['datas'] = $content;

        } else {    // Locality
            $data['datas'] = null;
        }

        return Response::json($data);
    }

    public function HeadcheckCatalogIsEmpty(Request $input)
    {
        $mrct = $input->marinecenter_id;
        $cat = $input->catalog_no;
        $results = DB::select("select * from record r, marinecenter m where m.id = r.marinecenter_id and r.catalog_number = '$cat' and m.id = '$mrct' ");
        if (sizeof($results) == 0) {
            // echo "true ";
            return Response::json(true);
        } else {
            // echo "false ";
            return Response::json(false);
        }
    }

    public function getRecordPicture(Request $input)
    {
        return Response::json(Picture::getPictureByRecordId_Two($input->unique_record));
    }

    public function getReferenceByMarineCenterID(Request $input)
    {
        $marine_id = $input->marinecenter_id;
        return Response::json(Reference::where('marinecenter_id', $marine_id)->get());
    }
}
