<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Response;
use Session;
use App\Http\Requests;
//model path
use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Taxonomy;
use App\Model\Header_Taxonomy;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Wording_type;
use App\Model\Wording;
use App\Model\Collection;
use App\Model\Reference;
use App\Model\Marinecenter;
use App\Model\Extra_Field;
use App\Model\PictureBox;
use Yajra\Datatables\Datatables;

class WordingController extends Controller
{
	//Sorawit
	//Created : 10-3-59
	//Modified : -
    public function mainWording() {
        $data['wording_types']       =   Wording_type::getAllWording_type();
    	return view('staff.wording.main_wording' , $data);
    }

    //---------------- Taxonomy Part ----------------------

        //Sorawit
    	//Created : 11-3-59
    	//Modified : -
        public function taxonomyList() {
            $data['action']             =   Session::get('action');
        	// $data['taxonomys']          =   Taxonomy::getTaxonomyList();
            $data['header_taxonomys']   =   Header_Taxonomy::HeaderTaxonomyList();
            Session::forget('action');

        	return view('staff.wording.taxonomy.taxonomy_list', $data);
        }

        public function getTaxonomyDataTable(){

            $query = Taxonomy::select('taxonomy.id', 'taxonomy.name as name', 'header_taxonomy.name as header_taxonomy_name', 'header_taxonomy_id', 'status')
                            ->leftjoin('header_taxonomy', 'header_taxonomy.id' , 'taxonomy.header_taxonomy_id');
            $btn = '';
            return Datatables::of($query)
                        ->editColumn('status', '{{ $status == 1 ? "Disabled" : "Enabled" }}')
                        ->addColumn('action', function ($query) use ($btn) {
                            $btn .= '<a href="#" id="edit_button" data-id="'.$query->id.'"  data-toggle="modal" data-target="#edit_modal">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </a>';

                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->addIndexColumn()
                        ->make(true);
        }

        //Sorawit
        //Created : 11-3-59
        //Modified : -
        public function addTaxonomy(Request $input) {

            $lastId     =   Taxonomy::addTaxonomy($input->add_header_taxonomy, $input->add_taxonomy);
            if ($lastId) {
                System_Log::Loging( 'taxonomy', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Taxonomy::getTaxonomyWording($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/taxonomyList');
        }

        //Sorawit
        //Created : 14-3-59
        //Comment : AJAX
        //Modified : -
        public function getTaxonomyWording(Request $input) {
            $data['taxonomy']           =   Taxonomy::getTaxonomyWording($input->taxonomy_wording_id);
            $data['header_taxonomy']    =   Header_Taxonomy::getHeaderTaxonomy($data['taxonomy']->header_taxonomy_id);
            return Response::json( $data );
        }

        //Sorawit
        //Created : 14-3-59
        //Comment : AJAX
        //Modified : Chaloemphon 16-3-59
        //Comment : add input toggle switch
        public function editTaxonomy(Request $input) {

            if ( Taxonomy::updateTaxonomy($input->taxonomy_wording_id, $input->edit_taxonomy, $input->edit_header_taxonomy, AllMean::ConvertSwitchStatus($input->status_switch)) ) {
                System_Log::Loging( 'taxonomy',  // table_name
                                    $input->taxonomy_wording_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Taxonomy::getTaxonomyWording($input->taxonomy_wording_id)->toArray() ); // new_data


                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/taxonomyList');
        }
    //-------------------------------------------------


    //---------------- Country Part ----------------------

        //Chaloemphon
        //Created : 11-3-59
        //Modified : 15-3-59
        public function countryList(){
            $data['action']     =   Session::get('action');
            $data['countrys']   =   Country::getCountryList();
            Session::forget('action');

            return view('staff.wording.country.country_list', $data);

        }

        //Chaloemphon
        //Created : 14-3-59
        //Modified : 15-3-59
        public function addCountry(Request $input) {
            $lastId     =   Country::addCountry($input->add_country_en, $input->add_country_th);
            if ( $lastId ) {

                System_Log::Loging( 'country', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Country::getCountryWording($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/countryList');
        }

        //Chaloemphon
        //Created : 18-3-59
        //Comment : AJAX
        //Modified : -
        public function getCountryWording(Request $input) {
            $data['country']           =   Country::getCountryWording($input->country_wording_id);
            return Response::json( $data );
        }

        //ChaloemphonChaloemphon
        //Created : 15-3-59
        //Modified : -
        public function editCountry(Request $input) {
            if ( Country::updateCountry( $input->country_wording_id, $input->edit_country_en , $input->edit_country_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'country',  // table_name
                                    $input->country_wording_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Country::getCountryWording($input->country_wording_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/countryList');
        }

    //-------------------------------------------------

    //---------------- Province Part ----------------------

        //Chaloemphon
        //Created : 11-3-59
        //Modified : -
        public function provinceList(){
            $data['action']     =   Session::get('action');
            $data['countrys']   =   Country::getCountryList_Enable_Only();
            $data['provinces']  =   Province::getProvinceList();
            Session::forget('action');

        	return view('staff.wording.province.province_list', $data);
        }

        //Chaloemphon
        //Created : 14-3-59
        //Modified : -
        public function addProvince(Request $input) {

            $lastId     =   Province::addProvince($input->add_country_province,  $input->add_province_en, $input->add_province_th);

            if ( $lastId ) {

                System_Log::Loging( 'province', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Province::getProvinceWording($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/provinceList');
        }

        //Chaloemphon
        //Created : 18-3-59
        //Comment : AJAX
        //Modified : -
        public function getProvinceWording(Request $input) {
            $data['province']           =   Province::getProvinceWording($input->province_wording_id);
            $data['country']            =   Country::getCountryWording($data['province']->country_id);
            return Response::json( $data );
        }

        //ChaloemphonChaloemphon
        //Created : 18-3-59
        //Modified : -
        public function editProvince(Request $input) {
            if ( Province::updateProvince( $input->province_wording_id, $input->add_country_province, $input->edit_province_en , $input->edit_province_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'province',  // table_name
                                    $input->province_wording_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Province::getProvinceWording($input->province_wording_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/provinceList');
        }
    //-------------------------------------------------

    //---------------- District Part ----------------------

        //Chaloemphon
        //Created : 14-3-59
        //Modified : -
        public function districtList(){
            $data['action']     =   Session::get('action');
            $data['provinces']  =   Province::getProvinceList();
            $data['districts']  =   District::getDistrictList();
            Session::forget('action');

            return view('staff.wording.district.district_list', $data);
        }

        //Chaloemphon
        //Created : 14-3-59
        //Modified : -
        public function addDistrict(Request $input) {
            $lastId     =   District::addDistrict($input->add_province_district, $input->add_district_en, $input->add_district_th);
            if ( $lastId ) {

                System_Log::Loging( 'district', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    District::getDistrictWording($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/districtList');
        }

        //Chaloemphon
        //Created : 18-3-59
        //Comment : AJAX
        //Modified : -
        public function getDistrictWording(Request $input) {

            $data['district']           =   District::getDistrictWording($input->district_wording_id);
            $data['province']           =   Province::getProvinceWordingByCode($data['district']->province_id);

            return Response::json( $data );
        }

        //ChaloemphonChaloemphon
        //Created : 18-3-59
        //Modified : -
        public function editDistrict(Request $input) {
            if ( District::updateDistrict( $input->district_wording_id, $input->edit_province_district, $input->edit_district_en, $input->edit_district_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'district',  // table_name
                                    $input->district_wording_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    District::getDistrictWording($input->district_wording_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/districtList');
        }

    //-------------------------------------------------


    //---------------- County Part ----------------------

        //Chaloemphon
        //Created : 14-3-59
        //Modified : -
        public function countyList(){
            $data['action']     =   Session::get('action');
            $data['districts']  =   District::getDistrictList();
            
            Session::forget('action');

            return view('staff.wording.county.county_list', $data);
        }

        public function getCountyDataTable(){

            $query = County::query();
            $btn = '';
            return Datatables::of($query)
                        ->editColumn('status', '{{ $status == 1 ? "Disabled" : "Enabled" }}')
                        ->addColumn('action', function ($query) use ($btn) {
                            $btn .= '<a href="#" id="edit_button" data-id="'.$query->id.'"  data-toggle="modal" data-target="#edit_county_modal">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                    </a>';

                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->addIndexColumn()
                        ->make(true);
        }

        //Chaloemphon
        //Created : 14-3-59
        //Modified : -
        public function addCounty(Request $input) {
            $lastId     =   County::addCounty($input->add_district_county, $input->add_county_en, $input->add_county_th);
            if ( $lastId ) {

                System_Log::Loging( 'county', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    County::getCountyWording($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/countyList');
        }

        //Chaloemphon
        //Created : 18-3-59
        //Comment : AJAX
        //Modified : -
        public function getCountyWording(Request $input) {
            $data['county']             =   County::getCountyWording($input->county_wording_id);
            $data['districts']           =   District::getDistrictWordingByCode($data['county']->district_id);

            return Response::json( $data );
        }

        //ChaloemphonChaloemphon
        //Created : 18-3-59
        //Modified : -
        public function editCounty(Request $input) {
            if ( County::updateCounty( $input->county_wording_id, $input->edit_district_county, $input->edit_county_en, $input->edit_county_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'county',  // table_name
                                    $input->county_wording_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    County::getCountyWording($input->county_wording_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/countyList');
        }


    //-------------------------------------------------

    //----------------- Reference ---------------------
        //Chaloemphon
        //Created : 21-3-59
        //Modified : -
        public function wordingList($name_wording_type = ""){
            $data['action']                 =   Session::get('action');
            if($name_wording_type == ""){
                $name_wording_type          =   Session::get('wording_type');
                // Session::forget('wording_type');
            }
            $data['name_wording_type']      =   $name_wording_type;
            $data['wordings_type_id']       =   Wording_type::getIdWording_type($name_wording_type);
            $data['wordings']               =   Wording::getWordingByWordingType( $data['wordings_type_id']->id);
            Session::forget('action');

            return view('staff.wording.wording.wording_list', $data);
        }

        //Chaloemphon
        //Created : 21-3-59
        //Modified : -
        public function addWording(Request $input){
            $lastId     =   Wording::addWording($input->wording_type, $input->add_wording_en, $input->add_wording_th );
            if ( $lastId ) {

                System_Log::Loging( 'wording', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Wording::getWording($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);
            Session::put('wording_type', $input->name_wording_type);

            return redirect('staff/wording/wordingList');

        }

        //Chaloemphon
        //Created : 21-3-59
        //Modified : -
        public function getWording(Request $input){
            $data['wording']        =   Wording::getWording($input->wording_id);
            return Response::json( $data );
        }

        //Chaloemphon
        //Created : 21-3-59
        //Modified : -
        public function editWording(Request $input){
            if ( Wording::updateWording($input->wording_wording_id, $input->edit_wording_en, $input->edit_wording_th, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'wording',  // table_name
                                    $input->wording_wording_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Wording::getWording($input->wording_wording_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }
            Session::put('action', $action);
            Session::put('wording_type', $input->name_wording_type);

            return redirect('staff/wording/wordingList');
        }

        //Chaloemphon
        //Created : 5-4-59
        //Modified : -
        public function collectionList(){
            $data['action']     =   Session::get('action');
            $data['collections']    =   Collection::getCollection();
            Session::forget('action');

            return view('staff.wording.collection.collection_list', $data);
        }

        //Chaloemphon
        //Created : 5-4-59
        //Modified : -
        public function addCollection(Request $input){
            $lastId     =   Collection::addCollection(strtoupper($input->add_collection_code), $input->add_collection_en, $input->add_collection_th );
            if ( $lastId ) {

                System_Log::Loging( 'collection', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Collection::getCollectionByID($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/collectionList');

        }

        //Chaloemphon
        //Created : 5-4-59
        //Modified : -
        public function getCollection(Request $input){
            $data['collection']        =   Collection::getCollectionByID($input->collection_id);
            return Response::json( $data );
        }

        //Chaloemphon
        //Created : 5-4-59
        //Modified : -
        public function editCollection(Request $input){
            // dd($input);
            if ( Collection::updateCollection( $input->collection_id, $input->edit_collection_en, $input->edit_collection_th,  AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'collection',  // table_name
                                    $input->collection_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Collection::getCollectionByID($input->collection_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }

            Session::put('action', $action);
            return redirect('staff/wording/collectionList');

        }

        //Chaloemphon
        //Created : 5-4-59
        //Modified : -
        public function referenceList(){
            $data['action']         =   Session::get('action');
            $data['references']     =   Reference::getReference();
            $data['marinecenters']  =   Marinecenter::getMarineCenterList();
            // dd($data['references']);
            Session::forget('action');

            return view('staff.wording.reference.reference_list', $data);
        }

        //Chaloemphon
        //Created : 6-4-59
        //Modified : -
        public function addReference(Request $input){
            $lastId     =   Reference::addReference($input->marinecenter,strtoupper($input->add_reference_code), $input->add_reference_en, $input->add_reference_th );
            if ( $lastId ) {

                System_Log::Loging( 'reference', // table_name
                                    $lastId, // row_id
                                    AllMean::defineAdd(),  // action
                                    "", // old_data
                                    Reference::getReferenceByID($lastId)->toArray() ); // new_data

                $action = AllMean::defineAddAlertSuccess();
            } else {
                $action = AllMean::defineAddAlertFail();
            }
            Session::put('action', $action);

            return redirect('staff/wording/referenceList');
        }

        //Chaloemphon
        //Created : 6-4-59
        //Modified : -
        public function getReference(Request $input){
            $data['reference']        =   Reference::getReferenceByID($input->reference_id);
            return Response::json( $data );
        }

        //Chaloemphon
        //Created : 6-4-59
        //Modified : -
        public function editReference(Request $input){
            if ( Reference::updateReference( $input->reference_id, $input->edit_reference_en, $input->edit_reference_th,  AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                System_Log::Loging( 'reference',  // table_name
                                    $input->reference_id, // row_id
                                    AllMean::defineEdit(), // action
                                    System_Log::getOldData(), // old_data
                                    Reference::getReferenceByID($input->reference_id)->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }

            Session::put('action', $action);
            return redirect('staff/wording/referenceList');

        }

    //-------------------------------------------------

    //---------------- Extra Field --------------------

        //Sorawit
        //Created : 3-8-59
        //Modified : -
        public function extraFieldList(){
            $data['action']         =   Session::get('action');
            $data['extra_fields']     =   Extra_Field::getExtraFieldNameList();
            Session::forget('action');

            return view('staff.wording.extra_field.extra_field_list', $data);
        }

        //Sorawit
        //Created : 3-8-59
        //Modified : -
        public function getExtraField(Request $input){
            $data['extra_field']        =   Extra_Field::getExtraFieldName($input->extra_field_id);
            return Response::json( $data );
        }

        //Sorawit
        //Created : 3-8-59
        //Modified : -
        public function editExtraField(Request $input){
            $old_info = Extra_Field::getExtraFieldName( $input->hidden_extra_field_id );
            if ( Extra_Field::updateExtraFieldName( $input->hidden_extra_field_id, $input->edit_extra_field_name, AllMean::ConvertSwitchStatus($input->status_switch) ) ) {

                $new_info = Extra_Field::getExtraFieldName( $input->hidden_extra_field_id );

                System_Log::Loging( 'extra_field',  // table_name
                                    $input->hidden_extra_field_id, // row_id
                                    AllMean::defineEdit(), // action
                                    $old_info->toArray(), // old_data
                                    $new_info->toArray() ); // new_data

                $action = AllMean::defineEditAlertSuccess();
            } else {
                $action = AllMean::defineEditAlertFail();
            }

            Session::put('action', $action);
            return redirect('staff/wording/extraFieldList');

        }

    //-------------------------------------------------

    //----------- Picture Box (Login Page) ------------

        //Sorawit
        //Created : 21-2-60
        //Modified : -
        public function pictureBox(){
            $data = PictureBox::get();

            return view('staff.wording.picture_box.picture_box', compact('data'));
        }

        //Sorawit
        //Created : 21-2-60
        //Modified : -
        public function doUpdatePictureBox( Request $request, $id ){
            if ( $request->hasFile('picture_file') ) {

                // get old data for log
                $old_data = PictureBox::where('id', $id)->first();

                $file = $request->picture_file;
                $destinationPath = 'assets/images/first_page_record/';
                $fileName = 'login_page_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $path_pic = $fileName;

                $lastId = PictureBox::doUpdatePictureBox( $id, $path_pic );

                // get new data for log
                $new_data = PictureBox::where('id', $lastId)->first();


                if ( $lastId ) {
                    System_Log::Loging( 'picture_boxes', // table_name
                                        $lastId, // row_id
                                        AllMean::defineEdit(),  // action
                                        $old_data->toArray(), // old_data
                                        $new_data->toArray() ); // new_data
                }
            }

            return redirect('staff/wording/pictureBox')->with('success', 'Update Success !!!');
        }

    //-------------------------------------------------

        //Chaloemphon
        //Created : 5-4-59
        //Modified : -
        public function referenceLoan(){
            $data['lang']           =   2;
            $data['action']         =   Session::get('action');
            $data['references']     =   Reference::getReference();
            $data['marinecenters']  =   Marinecenter::getMarineCenterList();
            Session::forget('action');

            return view('search_type_c.reference_loan', $data);
        }
}
