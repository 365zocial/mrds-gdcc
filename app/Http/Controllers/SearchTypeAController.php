<?php

#
#
# Type A: Diviersity Search, Distribution Search and Recent Record
# Role: Manager, User and PGCP
#
#

namespace App\Http\Controllers;

use Response;

use Illuminate\Http\Request;
use Session;
use App\Model\Header_Taxonomy;
use App\Model\Taxonomy;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Wording;
use App\Model\Record;
use App\Model\Classification;
use Auth;
use App\Model\Group_Permission;

class SearchTypeAController extends Controller
{
    public $group_permission_a;
    public $group_permission_b;
    public $group_permission_c;

    public function __construct()
    {
    }

    private function getPermission()
    {
        if (Auth::user()->role_id == 3) { // manager
            $this->group_permission_a       = Group_Permission::getGroup_PermissionById(1)[0]->status_manager;
            $this->group_permission_b       = Group_Permission::getGroup_PermissionById(2)[0]->status_manager;
        } elseif (Auth::user()->role_id == 4) { // board
            $this->group_permission_a       = Group_Permission::getGroup_PermissionById(1)[0]->status_board;
            $this->group_permission_b       = Group_Permission::getGroup_PermissionById(2)[0]->status_board;
        } elseif (Auth::user()->role_id == 6) { // pgcp
            $this->group_permission_a       = Group_Permission::getGroup_PermissionById(1)[0]->status_pgcp;
            $this->group_permission_b       = Group_Permission::getGroup_PermissionById(2)[0]->status_pgcp;
        } else { // user
            $this->group_permission_a       = Group_Permission::getGroup_PermissionById(1)[0]->status_user;
            $this->group_permission_b       = Group_Permission::getGroup_PermissionById(2)[0]->status_user;
        }
    }

    #------------------ En Zone ------------------
    public function searchADashboard()
    {
        $data['lang']   = Session::get('language');
        return view('search_type_a.dashboardsearch', $data);
    }

    public function searchDistribution()
    {
        $this->getPermission();

        $data['lang']   = Session::get('language');
        $data['expeditions']            =   Wording::getWordingByWordingTypeForForm(6);
        $data['countries']              =   json_decode(Country::getCountryListForFormEN());
        $data['provinces']              =   json_decode(Province::getProvinceListForFormEN());
        $data['districts']              =   json_decode(District::getDistrictListForFormEN());
        $data['counties']               =   json_decode(County::getCountyListForFormEN());

        $data['domains']                =   Taxonomy::getDomain();
        $data['kingdoms']               =   Taxonomy::getKingdom();
        $data['phylums']                =   Taxonomy::getPhylum();
        $data['subphylums']             =   Taxonomy::getSubphylum();
        $data['classes']                =   Taxonomy::getClass();
        $data['orders']                 =   Taxonomy::getOrder();
        $data['suborders']              =   Taxonomy::getSuborder();
        $data['infraorders']            =   Taxonomy::getInfraorder();
        $data['families']               =   Taxonomy::getFamily();
        $data['group_permission_a']     =   $this->group_permission_a;
        $data['group_permission_b']     =   $this->group_permission_b;

        return view('search_type_a.distribution', $data);
    }

    public function searchDiversity()
    {
        $this->getPermission();

        $data['lang']   = Session::get('language');
        $data['expeditions']            =   Wording::getWordingByWordingTypeForForm(6);

        $data['countries']              =   json_decode(Country::getCountryListForFormEN());
        $data['provinces']              =   json_decode(Province::getProvinceListForFormEN());
        $data['districts']              =   json_decode(District::getDistrictListForFormEN());
        $data['counties']               =   json_decode(County::getCountyListForFormEN());

        $data['domains']                =   Taxonomy::getDomain();
        $data['kingdoms']               =   Taxonomy::getKingdom();
        $data['phylums']                =   Taxonomy::getPhylum();
        $data['subphylums']             =   Taxonomy::getSubphylum();
        $data['classes']                =   Taxonomy::getClass();
        $data['orders']                 =   Taxonomy::getOrder();
        $data['suborders']              =   Taxonomy::getSuborder();
        $data['infraorders']            =   Taxonomy::getInfraorder();
        $data['families']               =   Taxonomy::getFamily();
        $data['group_permission_a']     =   $this->group_permission_a;
        $data['group_permission_b']     =   $this->group_permission_b;
        return view('search_type_a.diversity', $data);
    }

    public function searchRecent()
    {
        $this->getPermission();

        $data['lang']   = Session::get('language');
        $data['expeditions']            =   Wording::getWordingByWordingTypeForForm(6);
        $data['countries']              =   json_decode(Country::getCountryListForFormEN());
        $data['provinces']              =   json_decode(Province::getProvinceListForFormEN());
        $data['districts']              =   json_decode(District::getDistrictListForFormEN());
        $data['counties']               =   json_decode(County::getCountyListForFormEN());

        $data['domains']                =   Taxonomy::getDomain();
        $data['kingdoms']               =   Taxonomy::getKingdom();
        $data['phylums']                =   Taxonomy::getPhylum();
        $data['subphylums']             =   Taxonomy::getSubphylum();
        $data['classes']                =   Taxonomy::getClass();
        $data['orders']                 =   Taxonomy::getOrder();
        $data['suborders']              =   Taxonomy::getSuborder();
        $data['infraorders']            =   Taxonomy::getInfraorder();
        $data['families']               =   Taxonomy::getFamily();
        $data['group_permission_a']     =   $this->group_permission_a;
        $data['group_permission_b']     =   $this->group_permission_b;
        return view('search_type_a.recentrecord', $data);
    }

    public function search(Request $input)
    {
        $data = $this->search_base($input->chk_taxa, $input->chk_locality, $input->chk_expedition, $input->header_taxonomy, $input->domain, $input->kingdom, $input->phylum, $input->subphylum, $input->class, $input->order, $input->suborder, $input->infraorder, $input->family, $input->locality_type, $input->locality_country, $input->locality_province, $input->locality_district, $input->locality_county, $input->expan_id);
        return Response::json($data);
    }

    public function getDistribution(Request $input)
    {
        $this->getPermission();

        $data                           =   $this->search_base($input->chk_taxa, $input->chk_locality, $input->chk_expedition, $input->header_taxonomy, $input->domain, $input->kingdom, $input->phylum, $input->subphylum, $input->class, $input->order, $input->suborder, $input->infraorder, $input->family, $input->locality_type, $input->locality_country, $input->locality_province, $input->locality_district, $input->locality_county, $input->expedition, $input->map_type);
        $data['lang']                   =   $data['lang_table'];
        $data['group_permission_a']     =   $this->group_permission_a;
        $data['group_permission_b']     =   $this->group_permission_b;
        //show map or not in change request#4 No1
        $data['is_map_show']            =   true;
        //if search locality but not in thailand
        if ($input['locality_type'] && !$data['is_in_thailand']) {
            $data['is_map_show'] = false;
        }
        return view('search_type_a.result_distribute', $data);
    }

    public function search_base($chk_taxa, $chk_locality, $chk_expedition, $header_taxonomy, $domain, $kingdom, $phylum, $subphylum, $class, $order, $suborder, $infraorder, $family, $locality_type, $locality_country, $locality_province, $locality_district, $locality_county, $expan_id, $map_type = "")
    {
        $lang = Session::get('language');
        $db = new Classification;
        $db = $db->leftjoin('record as r', 'classification.id', '=', 'r.classification_id');
        $db = $db->leftjoin('taxonomy as t1', 'classification.domain', '=', 't1.id');
        $db = $db->leftjoin('taxonomy as t2', 'classification.kingdom', '=', 't2.id');
        $db = $db->leftjoin('taxonomy as t3', 'classification.phylum', '=', 't3.id');
        $db = $db->leftjoin('taxonomy as t4', 'classification.subphylum', '=', 't4.id');
        $db = $db->leftjoin('taxonomy as t5', 'classification.class', '=', 't5.id');
        $db = $db->leftjoin('taxonomy as t6', 'classification.order_o', '=', 't6.id');
        $db = $db->leftjoin('taxonomy as t7', 'classification.suborder', '=', 't7.id');
        $db = $db->leftjoin('taxonomy as t8', 'classification.infraorder', '=', 't8.id');
        $db = $db->leftjoin('taxonomy as t9', 'classification.family', '=', 't9.id');
        $db = $db->leftjoin('province as p', 'r.province', '=', 'p.id');
        $db = $db->leftjoin('country as country', 'r.country', '=', 'country.id');
        $db = $db->leftjoin('wording as w1', 'r.expedition', '=', 'w1.id');
        $db = $db->leftjoin('wording as w2', 'r.type_status', '=', 'w2.id');
        $db = $db->leftjoin('wording as w3', 'r.habitat', '=', 'w3.id');
        $db = $db->leftjoin('wording as w4', 'r.ocean_sea_lake', '=', 'w4.id');
        $db = $db->leftjoin('picture as pic', 'r.unique_record', '=', 'pic.unique_record');

        $id_taxa = 0;
        if ($header_taxonomy == "domain" && $domain != "") {
            $id_taxa        = $domain;
            $db             = $db->where('classification.domain', $domain);
        } else if ($header_taxonomy == "kingdom" && $kingdom != "") {
            $id_taxa        = $kingdom;
            $db             = $db->where('classification.kingdom', $kingdom);
        } else if ($header_taxonomy == "phylum" && $phylum != "") {
            $id_taxa        = $phylum;
            $db             = $db->where('classification.phylum', $phylum);
        } else if ($header_taxonomy == "subphylum" && $subphylum != "") {
            $id_taxa        = $subphylum;
            $db             = $db->where('classification.subphylum', $subphylum);
        } else if ($header_taxonomy == "class" && $class != "") {
            $id_taxa        = $class;
            $db             = $db->where('classification.class', $class);
        } else if ($header_taxonomy == "order" && $order != "") {
            $id_taxa        = $order;
            $db             = $db->where('classification.order_o', $order);
        } else if ($header_taxonomy == "suborder" && $suborder != "") {
            $id_taxa        = $suborder;
            $db             = $db->where('classification.suborder', $suborder);
        } else if ($header_taxonomy == "infraorder" && $infraorder != "") {
            $id_taxa        = $infraorder;
            $db             = $db->where('classification.infraorder', $infraorder);
        } else if ($header_taxonomy == "family" && $family != "") {
            $id_taxa        = $family;
            $db             = $db->where('classification.family', $family);
        }

        if ($header_taxonomy != "" && $id_taxa != 0) {
            $taxa_full          = Taxonomy::getTaxonomyWording($id_taxa);
            $taxa               = ucfirst($header_taxonomy) . " - " . $taxa_full->name;
        } else {
            $taxa               = "-";
        }

        #-----------------------------------------------------------#

        if ($locality_type == "country" && $locality_country != "") {
            $locality_full  = Country::getCountryWording($locality_country);
            $is_in_thailand = $locality_full->country_id == 1;
            $locality       = ucfirst($locality_type) . " - " . $locality_full->country_en . " (" . $locality_full->country_th . ")";
            $db             = $db->where('r.country', $locality_country);
        } else if ($locality_type == "province" && $locality_province != "") {
            $locality_full  = Province::getProvinceWording($locality_province);
            $is_in_thailand = $locality_full->country_id == 1;
            $locality       = ucfirst($locality_type) . " - " . $locality_full->province_en . " (" . $locality_full->province_th . ")";
            $db             = $db->where('r.province', $locality_province);
        } elseif ($locality_type == "district" && $locality_district != "") {
            $locality_full  = District::getDistrictWording($locality_district);
            $is_in_thailand = $locality_full->country_id == 1;
            $locality       = ucfirst($locality_type) . " - " . $locality_full->district_en . " (" . $locality_full->district_th . ")";
            $db             = $db->where('r.county', $locality_district);
        } elseif ($locality_type == "county" && $locality_county != "") {
            $locality_full  = County::getCountyWording($locality_county);
            $is_in_thailand = $locality_full->country_id == 1;
            $locality       = ucfirst($locality_type) . " - " . $locality_full->county_en . " (" . $locality_full->county_th . ")";
            $db             = $db->where('r.county', $locality_county);
        } else {
            $locality       = "-";
            $is_in_thailand = false;
        }

        if ($expan_id != "") {
            $expedition = Wording::getWording($expan_id)->name_en . " (" . Wording::getWording($expan_id)->name_th . ")";
            $db = $db->where('r.expedition', $expan_id);
        } else {
            $expedition = "-";
        }


        if ($lang == 2) {
            $db = $db->where('r.language_id', 2);
        } else {
            $db = $db->where('r.language_id', 1);
        }

        if (Auth::user()->role_id == 3) {
            $db = $db->where('r.marinecenter_id', Auth::user()->marinecenter_id);
        }

        $db = $db->where('approve_status', 1);
        $db = $db->where('r.status', 2);

        $checkGetSearch = true;
        if ($chk_taxa == 1) {
            if ($domain == "" && $kingdom == "" && $phylum == "" && $subphylum == "" && $class == "" && $order == "" && $infraorder == "" && $family == "") {
                $data['result_searchs']             = null;
                $data['map']                        = null;
                $checkGetSearch                     = $checkGetSearch && false;
            }
        }
        if ($chk_locality == 1) {
            if ($locality_country == "" && $locality_province == "" && $locality_district == "" && $locality_county == "") {
                $data['result_searchs']             = null;
                $data['map']                        = null;
                $checkGetSearch                     = $checkGetSearch && false;
            }
        }
        if ($chk_expedition == 1) {
            if ($expan_id == "") {
                $data['result_searchs']             = null;
                $data['map']                        = null;
                $checkGetSearch                     = $checkGetSearch && false;
            }
        }

        if ($checkGetSearch) {
            $data['result_searchs']             = $this->Data_searchResult($db);
            $data['map']                        = $this->Data_searchMap($db);
        }

        $data['map']                            = json_encode($data['map']);
        $data['lang_table']                     = $lang;
        $data['expedition']                     = $expedition;
        $data['locality']                       = $locality;
        $data['taxa']                           = $taxa;
        $data['map_type']                       = $map_type;
        $data['is_in_thailand']                 = $is_in_thailand;

        $data_export['expedition']              = $expedition;
        $data_export['locality']                = $locality;
        $data_export['taxa']                    = $taxa;
        $data_export['result_searchs']          = $data['result_searchs'];

        Session::put('search_result_a', json_encode($data_export));
        return $data;
    }

    public function Data_searchResult($db)
    {
        $data               = $db->select([
            'classification.current_scientific_name_format',
            'classification.current_scientific_name',
            'classification.previous_scientific_name_format',
            'classification.previous_scientific_name',
            'r.related_catalog_item',
            'r.related_reference_item',
            'p.province_en',
            'p.province_th',
            'country.country_en',
            'country.country_th',
            't1.name as domain',
            't2.name as kingdom',
            't3.name as phylum',
            't4.name as subphylum',
            't5.name as class',
            't6.name as order_o',
            't7.name as suborder',
            't8.name as infraorder',
            't9.name as family',
            'r.id as record_id',
            'r.locality',
            'r.identifier',
            'r.previous_identifier',
            'w2.name_en as type_status_en',
            'w2.name_th as type_status_th',
            'w3.name_en as habitat_en',
            'w3.name_th as habitat_th',
            'w1.name_en as expedition_en',
            'w1.name_th as expedition_th',
            'w4.name_en as ocean_sea_lake_en',
            'w4.name_th as ocean_sea_lake_th',
            'pic.path_pic',
            'r.unique_record'
        ])->groupBy('r.unique_record')->get();
        return $data;
    }

    public function Data_searchMap($db)
    {

        $data       = $db->select([
            'r.related_catalog_item',
            'r.related_reference_item',
            'r.latitude',
            'r.longitude',
            'r.start_latitude',
            'r.end_latitude',
            'r.start_longitude',
            'r.end_longitude'
        ])->get();

        return $data;
    }

    //Chaloemphon
    //Created : 11-6-61
    //Modified : 11-6-61
    # for search name form
    public function searchByNameRecord()
    {
        $data['lang']   = Session::get('language');
        return view('search_type_a.search_by_name_record', $data);
    }

    //Chaloemphon
    //Created : 11-6-61
    //Modified : 11-6-61
    # for search name
    public function doSearchNameRecord(Request $input)
    {
        // get value from form
        $way = $input->way;

        $name_type = $input->name_type;
        $search = $input->search;

        if ($way == 1) {   // search
            // get DB
            if ($input->name_type == 'localname') {
                $data['results'] = \App\Model\Record::leftjoin('classification', 'record.classification_id', 'classification.id')->where('record.local_name', 'like', '%' . $input->search . '%')->get();
            } elseif ($input->name_type == 'vernacularname') {
                $data['results'] = \App\Model\Record::leftjoin('classification', 'record.classification_id', 'classification.id')->where('record.vernacular_name', 'like', '%' . $input->search . '%')->get();
            } elseif ($input->name_type == 'commonname') {
                $data['results'] = \App\Model\Record::leftjoin('classification', 'record.classification_id', 'classification.id')->where('classification.common_name', 'like', '%' . $input->search . '%')->get();
            }
            // ------

            $data['name_type'] = ucfirst($name_type);
            $data['search'] = $search;

            return Response::json($data);
        } else {    //ajax
            // export excel
            ExportRecordController::exportSearchByNameRecord($name_type, $search);
        }
    }
}
