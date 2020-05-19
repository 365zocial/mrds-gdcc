<?php

#
#
# Type A: Date Search, Distribution Search, ID Search, Keyword Search, Locality Search, Name Search and Taxonomy Search
# Role: Admin and Board
#
#

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\ExportRecordController;

use Session;
use Auth;
use Response;
use App\Model\Record;
use App\Model\Marinecenter;
use App\Model\Classification;
use App\Model\Header_Taxonomy;
use App\Model\Taxonomy;
use App\Model\Wording;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Users;
use App\Model\Picture;
use App\Model\Group_Permission;
use App\Model\Extra_Field;
use App\Model\Extra_Info;
use App\Model\RecordPlace;
use App\Model\RecordUtilization;

class SearchTypeBController extends Controller
{

    public $group_permission_a_manager;
    public $group_permission_a_user;
    public $group_permission_a_board;
    public $group_permission_b_manager;
    public $group_permission_b_user;
    public $group_permission_b_board;
    public $group_permission_c;

    public function __construct()
    {
        $this->group_permission_a_manager   = Group_Permission::getGroup_PermissionById(1)[0]->status_manager;
        $this->group_permission_a_user      = Group_Permission::getGroup_PermissionById(1)[0]->status_user;
        $this->group_permission_a_board     = Group_Permission::getGroup_PermissionById(1)[0]->status_board;

        $this->group_permission_b_manager   = Group_Permission::getGroup_PermissionById(2)[0]->status_manager;
        $this->group_permission_b_user      = Group_Permission::getGroup_PermissionById(2)[0]->status_user;
        $this->group_permission_b_board     = Group_Permission::getGroup_PermissionById(2)[0]->status_board;
    }

    //Sorawit
    //Created : 11-6-59
    //Modified : -
    public function searchBDashboard()
    {
        return view('search_type_b.dashboard_search');
    }

    //Sorawit
    //Created : 16-6-59
    //Modified : -
    # for search date form
    public function searchByDate()
    {
        return view('search_type_b.search_by_date');
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 16-6-59
    # for search date
    public function doSearchDate(Request $input)
    {
        // get value from form
        $way = $input->way;
        $source = $input->source;
        $from_date = $input->from_date;
        $to_date = $input->to_date;
        $date_type = $input->date_type;

        if ($way == 1) {   // search
            $from_date_format = date('Y-m-d', strtotime($from_date));
            $to_date_format = date('Y-m-d', strtotime($to_date));

            // get DB
            // set end_date format
            $end_time = date_create('23:59:59');
            $end_time = date_format($end_time, 'H:i:s');
            $to_date_format = date('Y-m-d H:i:s', strtotime($to_date_format . ' ' . $end_time));

            // check condition
            if ($date_type == 1) { // Collected Date
                $date_type_name = 'record.collected_date';
            } else { // Identified Date
                $date_type_name = 'record.identified_date';
            }

            // query db
            $db = new Record;
            $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
            $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->whereBetween($date_type_name, [$from_date_format, $to_date_format])->orderBy('record.id', 'asc');
            if ($from_date != null && $to_date != null) {
                $data['results'] = $db->select(
                    'c.current_scientific_name_format',
                    'record.id',
                    'record.related_catalog_item',
                    'record.related_reference_item'
                )->get();
            } else {
                $data['results'] = null;
            }
            // ------

            $data['source'] = $source;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['date_type'] = $date_type;

            return Response::json($data);
        } else {    //ajax
            // export excel
            ExportRecordController::exportSearchByDate($source, $from_date, $to_date, $date_type);
        }
    }

    //Sorawit
    //Created : 30-6-59
    //Modified : -
    # for search distribution form
    public function searchByDistribution()
    {
        $data['lang']               = 1;
        $data['expeditions']        =   Wording::getWordingByWordingTypeForForm(6);
        $data['countries']          =   json_decode(Country::getCountryListForFormEN());
        $data['provinces']          =   json_decode(Province::getProvinceListForFormEN());
        $data['districts']          =   json_decode(District::getDistrictListForFormEN());
        $data['counties']           =   json_decode(County::getCountyListForFormEN());

        $data['domains']             =   Taxonomy::getDomain();
        $data['kingdoms']            =   Taxonomy::getKingdom();
        $data['phylums']             =   Taxonomy::getPhylum();
        $data['subphylums']          =   Taxonomy::getSubphylum();
        $data['classes']              =   Taxonomy::getClass();
        $data['orders']              =   Taxonomy::getOrder();
        $data['suborders']           =   Taxonomy::getSuborder();
        $data['infraorders']         =   Taxonomy::getInfraorder();
        $data['families']             =   Taxonomy::getFamily();
        $data['group_permission_a_manager']         =   $this->group_permission_a_manager;
        $data['group_permission_a_user']            =   $this->group_permission_a_user;
        $data['group_permission_a_board']           =   $this->group_permission_a_board;
        $data['group_permission_b_manager']         =   $this->group_permission_b_manager;
        $data['group_permission_b_user']            =   $this->group_permission_b_user;
        $data['group_permission_b_board']           =   $this->group_permission_b_board;

        return view('search_type_b.search_by_distribution', $data);
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 16-6-59
    # for search distribution
    public function doSearchDistribution(Request $input)
    {
        $lang = Session::get('language');

        $header_taxonomy        = $input->header_taxonomy;
        $domain                 = $input->domain;
        $kingdom                = $input->kingdom;
        $phylum                 = $input->phylum;
        $subphylum              = $input->subphylum;
        $class                  = $input->class;
        $order                  = $input->order;
        $suborder               = $input->suborder;
        $infraorder             = $input->infraorder;
        $family                 = $input->family;
        $locality_type          = $input->locality_type;
        $locality_country       = $input->locality_country;
        $locality_province      = $input->locality_province;
        $locality_district      = $input->locality_district;
        $locality_county        = $input->locality_county;
        $expan_id               = $input->expan_id;
        $chk_taxa               = $input->taxa_chkbox;
        $chk_locality           = $input->local_chkbox;
        $chk_expedition         = $input->expan_chkbox;
        $map_type               = $input->map_type;

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
        $db = $db->leftjoin('wording as w1', 'r.expedition', '=', 'w1.id');
        $db = $db->leftjoin('wording as w2', 'r.type_status', '=', 'w2.id');
        $db = $db->leftjoin('wording as w3', 'r.habitat', '=', 'w3.id');
        $db = $db->leftjoin('picture as pic', 'r.unique_record', '=', 'pic.unique_record');

        // dd($header_taxonomy);
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
        $data['lang']                           = 1;

        $data_export['expedition']              = $expedition;
        $data_export['locality']                = $locality;
        $data_export['taxa']                    = $taxa;
        $data_export['result_searchs']          = $data['result_searchs'];

        // permission
        $data['group_permission_a_manager']         =   $this->group_permission_a_manager;
        $data['group_permission_a_user']            =   $this->group_permission_a_user;
        $data['group_permission_a_board']           =   $this->group_permission_a_board;
        $data['group_permission_b_manager']         =   $this->group_permission_b_manager;
        $data['group_permission_b_user']            =   $this->group_permission_b_user;
        $data['group_permission_b_board']           =   $this->group_permission_b_board;

        Session::put('search_result_a', json_encode($data_export));

        $data['is_map_show']            =   true;
        //if search locality but not in thailand
        if ($input['locality_type'] && !$is_in_thailand) {
            $data['is_map_show'] = false;
        }

        return view('search_type_b.result_distribute', $data);
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
            't1.name as domain',
            't2.name as kingdom',
            't3.name as phylum',
            't4.name as subphylum',
            't5.name as class',
            't6.name as order_o',
            't7.name as suborder',
            't8.name as infraorder',
            't9.name as family',
            'r.locality',
            'r.identifier',
            'w2.name_en as type_status_en',
            'w2.name_th as type_status_th',
            'w3.name_en as habitat_en',
            'w3.name_th as habitat_th',
            'w1.name_en as expedition_en',
            'w1.name_th as expedition_th',
            'pic.path_pic',
            'r.unique_record'
        ])->get();

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

    //Sorawit
    //Created : 16-6-59
    //Modified : -
    # for search id (catalog and ref) form
    public function searchByID()
    {
        return view('search_type_b.search_by_id');
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 16-6-59
    # for search id (catalog and ref)
    public function doSearchID(Request $input)
    {
        // get value from form
        $way = $input->way;
        $source = $input->source;
        $related_id = $input->related_id;

        if ($way == 1) {   // search
            // get DB
            // check condition
            if ($source == 1) { // 1 is specimens
                $source_name = 'record.related_catalog_item';
            } else {  // 2 is publication
                $source_name = 'record.related_reference_item';
            }

            // query db
            $db = new Record;
            $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
            $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->where($source_name, 'like', '%' . $related_id . '%')->orderBy('record.id', 'asc');
            if ($related_id != null) {
                $data['results'] = $db->select(
                    'c.current_scientific_name_format',
                    'record.id',
                    'record.related_catalog_item',
                    'record.related_reference_item'
                )->get();
            } else {
                $data['results'] = null;
            }
            // ------

            $data['source'] = $source;
            $data['related_id'] = $related_id;

            return Response::json($data);
        } else {    //ajax
            // export excel
            ExportRecordController::exportSearchByID($source, $related_id);
        }
    }

    //Sorawit
    //Created : 16-6-59
    //Modified : -
    # for search keyword form
    public function searchByKeyword()
    {
        return view('search_type_b.search_by_keyword');
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 28-7-59
    # for search keyword
    public function doSearchKeyword(Request $input)
    {
        $way = $input->way;

        if ($way == 1) {   // search
            $db = new Record;
            $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
            $db = $db->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $input->source)->orderBy('record.id', 'asc')->groupBy('unique_record');

            if ($input->keyword1 !== "") {
                $db = $db->where('record.note_collector', 'LIKE', "%$input->keyword1%");
                $db = $db->orWhere('record.description', 'LIKE', "%$input->keyword1%");
            }

            if ($input->keyword2 !== "") {
                $db = $db->where('record.note_collector', 'LIKE', "%$input->keyword2%");
                $db = $db->orWhere('record.description', 'LIKE', "%$input->keyword2%");
            }

            if ($input->keyword3 !== "") {
                $db = $db->where('record.note_collector', 'LIKE', "%$input->keyword3%");
                $db = $db->orWhere('record.description', 'LIKE', "%$input->keyword3%");
            }

            $data['results'] = $db->select(
                'c.current_scientific_name_format',
                'record.id',
                'record.related_catalog_item',
                'record.related_reference_item'
            )->get();

            $data['source'] = $input->source;
            $data['keyword1'] = $input->keyword1;
            $data['keyword2'] = $input->keyword2;
            $data['keyword3'] = $input->keyword3;

            return Response::json($data);
        } else {
            // export excel
            ExportRecordController::exportSearchByKeyword($input->source, $input->keyword1, $input->keyword2, $input->keyword3);
        }
    }

    //Sorawit
    //Created : 16-6-59
    //Modified : -
    # for search locality form
    public function searchByLocality()
    {
        $data['ocean_sea_lakes'] = Wording::getWordingByWordingTypeForForm(3);
        $data['countrys'] = Country::getCountryListOrderByEn();
        $data['provinces'] = Province::getProvinceListOrderByEn();
        $data['districts'] = District::getDistrictListOrderByEn();
        $data['countys'] = County::getCountyListOrderByEn();

        return view('search_type_b.search_by_locality', $data);
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 16-6-59
    # for search locality
    public function doSearchLocality(Request $input)
    {
        // get value from form
        $way = $input->way;
        $source = $input->source;
        $locality_type = $input->locality_type;

        // get value from taxonomy_id
        $arr = [
            'ocean_sea_lake_id',
            'country_id',
            'province_id',
            'district_id',
            'county_id',
            'locality_text',
        ];
        $locality_value = $input->{$arr[$locality_type - 1]};

        if ($way == 1) {   // search
            // get DB
            // query db
            $db = new Record;
            $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
            $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->orderBy('record.id', 'asc');

            // check condition
            if ($locality_type == 1) {    // ocean_sea_lake
                $db = $db->where('record.ocean_sea_lake', $locality_value);
                $wording = Wording::getWording($locality_value);
                $data['content_result'] = $wording->name_en . '/' . $wording->name_th;
            } elseif ($locality_type == 2) {  // country
                $db = $db->where('record.country', $locality_value);
                $wording = Country::getCountryWording($locality_value);
                $data['content_result'] = $wording->country_en . '/' . $wording->country_th;
            } elseif ($locality_type == 3) {  // province
                $db = $db->where('record.province', $locality_value);
                $wording = Province::getProvinceWording($locality_value);
                $data['content_result'] = $wording->province_en . '/' . $wording->province_th;
            } elseif ($locality_type == 4) {  // district
                $db = $db->where('record.district', $locality_value);
                $wording = District::getDistrictWording($locality_value);
                $data['content_result'] = $wording->district_en . '/' . $wording->district_th;
            } elseif ($locality_type == 5) {  // county
                $db = $db->where('record.county', $locality_value);
                $wording = County::getCountyWording($locality_value);
                $data['content_result'] = $wording->county_en . '/' . $wording->county_th;
            } else {    // locality
                $db = $db->where('record.locality', 'like', '%' . $locality_value . '%');
                $data['content_result'] = $locality_value;
            }

            if (!empty($locality_value) && $locality_value != ' ') {
                $data['results'] = $db->select(
                    'c.current_scientific_name_format',
                    'record.id',
                    'record.related_catalog_item',
                    'record.related_reference_item',
                    'record.locality'
                )->get();
            } else {
                $data['results'] = null;
            }
            // ------

            $data['source'] = $source;
            $data['locality_type'] = $locality_type;

            return Response::json($data);
        } else {    //ajax
            // export excel
            ExportRecordController::exportSearchByLocality($source, $locality_type, $locality_value);
        }
    }

    //Sorawit
    //Created : 16-6-59
    //Modified : -
    # for search name form
    public function searchByName()
    {
        return view('search_type_b.search_by_name');
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 16-6-59
    # for search name
    public function doSearchName(Request $input)
    {
        // get value from form
        $way = $input->way;
        $source = $input->source;
        $name_type = $input->name_type;
        $name_people = $input->name_people;

        if ($way == 1) {   // search
            // get DB
            // check condition
            if ($name_type == 1) { // 1 is Collector
                $name_type_format = 'record.collector';
            } else { // 2 is Identifier
                $name_type_format = 'record.identifier';
            }

            // query db
            $db = new Record;
            $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
            $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->where($name_type_format, 'like', '%' . $name_people . '%')->orderBy('record.id', 'asc');
            if ($name_people != null && $name_people != ' ') {
                $data['results'] = $db->select(
                    'c.current_scientific_name_format',
                    'record.id',
                    'record.related_catalog_item',
                    'record.related_reference_item'
                )->get();
            } else {
                $data['results'] = null;
            }
            // ------

            $data['source'] = $source;
            $data['name_type'] = $name_type;
            $data['name_people'] = $name_people;

            return Response::json($data);
        } else {    //ajax
            // export excel
            ExportRecordController::exportSearchByName($source, $name_type, $name_people);
        }
    }

    //Sorawit
    //Created : 16-6-59
    //Modified : -
    # for search taxonomy form
    public function searchByTaxonomy()
    {
        $data['header_taxonomys'] = Header_Taxonomy::getHeaderTaxonomyListOrderByLevel();
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
        return view('search_type_b.search_by_taxonomy', $data);
    }

    //Sorawit
    //Created : 13-6-59
    //Modified : 16-6-59
    # for search taxonomy
    public function doSearchTaxonomy(Request $input)
    {
        // get value from form
        $way = $input->way;
        $source = $input->source;
        $header_taxonomy_id = $input->header_taxonomy_id;

        // get value from taxonomy_id
        $arr = [
            'domain_id',
            'kingdom_id',
            'subkingdom_id',
            'infrakingdom_id',
            'phylum_id',
            'subphylum_id',
            'infraphylum_id',
            'superclass_id',
            'class_id',
            'subclass_id',
            'infraclass_id',
            'superorder_id',
            'order_id',
            'suborder_id',
            'infraorder_id',
            'superfamily_id',
            'family_id',
            'subfamily_id',
            'genus_id',
            'subgenus_id',
            'species_id',
            'subspecies_id'
        ];
        $taxonomy_id = $input->{$arr[$header_taxonomy_id - 1]};

        if ($way == 1) {   // search
            // get DB
            // get header taxonomy
            $header_taxonomy = Header_Taxonomy::getHeaderTaxonomy($header_taxonomy_id);
            // convert small word
            $header_taxonomy = strtolower($header_taxonomy);
            // change order to order_o for column search
            if ($header_taxonomy == 'order') $header_taxonomy = 'order_o';

            // query db
            $db = new Classification;
            $db = $db->leftjoin('record as r', 'classification.id', '=', 'r.classification_id');
            $db = $db->where('r.language_id', 1)->where('r.status', 2)->where('r.approve_status', 1)->where('r.source', $source);
            if ($taxonomy_id != 0) {
                $db = $db->where('classification.' . $header_taxonomy, $taxonomy_id);
                $data['results'] = $db->select(
                    'classification.current_scientific_name_format',
                    'r.id',
                    'r.related_catalog_item',
                    'r.related_reference_item'
                )->get();
                $taxonomy = Taxonomy::getTaxonomyWording($taxonomy_id)->name;
                $data['taxonomy'] = $taxonomy;
            } else {
                $data['results'] = null;
                $data['taxonomy'] = '-';
            }
            // ------

            $data['source'] = $source;
            $data['header_taxonomy'] = Header_Taxonomy::getHeaderTaxonomy($header_taxonomy_id); // get header taxonomy for display
            $data['header_taxonomy_id'] = $header_taxonomy_id;
            $data['taxonomy_id'] = $taxonomy_id;

            return Response::json($data);
        } else {    //ajax
            // export excel
            ExportRecordController::exportSearchByTaxanomy($source, $header_taxonomy_id, $taxonomy_id);
        }
    }

    //Sorawit
    //Created : 29-3-59
    //Modified : -
    # show detail record
    public function viewRecord($id = "")
    {
        if ($id != "") {
            $id_decode = base64_decode(base64_decode(base64_decode($id)));
        } else {
            echo 'Error';
            exit;
        }

        if (!isset($id_decode)) {
            return redirect('staff/manageRecord');
        }

        $data['record']                =    Record::getFullRecord($id_decode);
        $data['marinecenter']        =    Marinecenter::getMarineCenterCode($data['record'][0]->marinecenter_id);
        $data['classification']     =     Classification::getClassification($data['record'][0]->classification_id);
        $data['country']            =    Country::getCountryWording($data['record'][0]->country);
        $data['province']            =    Province::getProvinceWording($data['record'][0]->province);
        $data['district']            =    District::getDistrictWording($data['record'][0]->district);
        $data['county']                =    County::getCountyWording($data['record'][0]->county);
        $data['users_approve']        =    Users::getUserById($data['record'][0]->approve_by);
        $data['users_add']            =    Users::getUserById($data['record'][0]->created_by);
        $data['last_update_time']    =    Record::where('unique_record', $data['record'][0]->unique_record)->max('updated_at');

        $util_list                     =    ['ความเพลิดเพลิน', 'การค้า', 'ใช้แรงงาน', 'อาหาร', 'ยา', 'ศึกษาวิจัย', 'เครื่องนุ่งห่ม', 'สวยงาม'];
        $record_util                 =     RecordUtilization::where('record_unique_id', $data['record'][0]->unique_record)->get();
        $data['record_utilizations'] =     [];
        foreach ($record_util as $value) {
            $data['record_utilizations'][] = $util_list[$value->utilization_id - 1];
        }

        $place_list                    =    ['น้ำจืด', 'น้ำกร่อย', 'ทะเล', 'ภูเขา', 'บนต้นไม้', 'หน้าดิน', 'ในดิน', 'บนบก'];
        $record_place                =    RecordPlace::where('record_unique_id', $data['record'][0]->unique_record)->get();
        $data['record_places']        =    [];
        foreach ($record_place as $value) {
            $data['record_places'][]    =    $place_list[$value->place_id - 1];
        }

        // get user for last updated record
        $users_update                =    Record::select('updated_by')
            ->where('unique_record', $data['record'][0]->unique_record)
            ->orderBy('updated_at', 'desc')
            ->first();
        $data['users_update']         =    Users::getUserById($users_update->updated_by);

        // get taxonomy wording
        $arr_taxonomy_id             =    [
            $data['classification']->domain,
            $data['classification']->kingdom,
            $data['classification']->subkingdom,
            $data['classification']->infrakingdom,
            $data['classification']->phylum,
            $data['classification']->subphylum,
            $data['classification']->infraphylum,
            $data['classification']->superclass,
            $data['classification']->class,
            $data['classification']->subclass,
            $data['classification']->infraclass,
            $data['classification']->superorder,
            $data['classification']->order,
            $data['classification']->suborder,
            $data['classification']->infraorder,
            $data['classification']->superfamily,
            $data['classification']->family,
            $data['classification']->subfamily,
            $data['classification']->genus,
            $data['classification']->subgenus,
            $data['classification']->species,
            $data['classification']->subspecies
        ];
        $data['taxonomy']            =    Taxonomy::getMultipleTaxonmyWording($arr_taxonomy_id);

        $data['pictures']            =    Picture::getPictureByRecordId($data['record'][0]->unique_record);
        $data['group_permission_a_manager']         =   $this->group_permission_a_manager;
        $data['group_permission_a_user']            =   $this->group_permission_a_user;
        $data['group_permission_a_board']           =   $this->group_permission_a_board;
        $data['group_permission_b_manager']         =   $this->group_permission_b_manager;
        $data['group_permission_b_user']            =   $this->group_permission_b_user;
        $data['group_permission_b_board']           =   $this->group_permission_b_board;

        // get extra information
        $data['extra_info'] = Extra_Info::getExtraInfo($data['record'][0]->unique_record);
        if (sizeof((array) $data['extra_info'])) {    // check have or not have
            $data['extra_fields'] = Extra_Field::getExtraFieldNameList(); // get extra field
        } else {
            $data['extra_info'] = null;
        }

        return view('search_type_b.view_record', $data);
    }

    //Chaloemphon
    //Created : 11-6-61
    //Modified : 11-6-61
    # for search name form
    public function searchByNameRecord()
    {
        return view('search_type_b.search_by_name_record');
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
