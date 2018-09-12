<?php

namespace App\Http\Controllers\Wording;

use Auth;
use Response;
use Session;
use App\Http\Requests;

use App\Model\AllMean;
use App\Model\System_Log;

use App\Model\Taxonomy;
use App\Model\Header_Taxonomy;
use Yajra\Datatables\Datatables;

trait T_Taxonomy {
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
}