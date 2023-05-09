<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;
use Auth;
use DB;
use Response;
use Session;
use Config;
use App\Model\Classification;
use App\Model\Header_Taxonomy;
use App\Model\Taxonomy;
use App\Model\Marinecenter;
use App\Model\Record;
use App\Model\Wording;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\ExportLog;
use App\Model\Group_Permission;

class ExportReportController extends Controller
{

    //Sorawit
	//Created : 21-7-59
	//Modified : -
    # Search Report (Diversity) for export excel
    # way = 1 is view class.
    # way = 2 is view order.
    # way = 3 is view family.
    # way = 4 is view species.
    # way = 5 is view long species.
    public function exportDiversity( Request $input ) {
        // get data from ajax
        $way = $input->way;
        $data_search = json_decode( $input->data_search );
        $class = json_decode( $input->class );
        $order = json_decode( $input->order );
        $family = json_decode( $input->family );
        $species = json_decode( $input->species );

        // created export date
        $date = date_create();
        $date_export = date_format( $date, "d-m-Y H:i:s" );
        $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );

        // set way
        if ( $way == 1 ) {
            $way_name = 'Class_Listing';
            $type_name = 'Class';

            //---- make file excel ----
            $name_file = 'Excel_Report_Diversity_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $class, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $class, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Diversity ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $class ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $class as $data ) {
                                $sheet->row( $row_number, array(
                                    $data->name
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof($class)
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 2 ) {
            $way_name = 'Order_Listing';
            $type_name = 'Order';

            //---- make file excel ----
            $name_file = 'Excel_Report_Diversity_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $order, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $order, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Diversity ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $order ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $order as $data ) {
                                $sheet->row( $row_number, array(
                                    $data->name
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof($order)
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 3 ) {
            $way_name = 'Family_Listing';
            $type_name = 'Family';

            //---- make file excel ----
            $name_file = 'Excel_Report_Diversity_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $family, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $family, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Diversity ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $family ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $family as $data ) {
                                $sheet->row( $row_number, array(
                                    $data->name
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof($family)
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 4 ) {
            $way_name = 'Species_Listing';
            $type_name = 'Species';

            //---- make file excel ----
            $name_file = 'Excel_Report_Diversity_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $species, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $species, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Diversity ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $species ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $species as $data ) {
                                $sheet->row( $row_number, array(
                                    $data->name
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof($species)
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } else {
            $way_name = 'Long_Species_Listing';
            $type_name = 'Long Species';
        }

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog( 0, $name_file );

        // sent name_file for download
        echo $name_file.'.xlsx';
    }

    //Sorawit
	//Created : 22-7-59
	//Modified : -
    # Search Report (Biogeography) for export excel
    # way = 0 is view Ocean Sea.
    # way = 1 is view Country.
    # way = 2 is view Province.
    # way = 3 is view District.
    # way = 4 is view County.
    # way = 5 is view Locality.
    public function exportBiogeography( Request $input ) {
        // get data from ajax
        $way = $input->way;

        $data_search = json_decode( $input->data_search );
        $ocean_sea_lake = json_decode( $input->ocean_sea_lake );
        $country = json_decode( $input->country );
        $province = json_decode( $input->province );
        $district = json_decode( $input->district );
        $county = json_decode( $input->county );
        $locality = json_decode( $input->locality );

        // created export date
        $date = date_create();
        $date_export = date_format( $date, "d-m-Y H:i:s" );
        $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );

        // set way
        if ( $way == 0 ) {
            // set data
            $way_name = 'Ocean_Sea_Lake';
            $type_name = 'Ocean Sea Lake';
            $data = $ocean_sea_lake;

            //---- make file excel ----
            $name_file = 'Excel_Report_Biogeography_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Biogeography ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Header Table Part ---
                        $start_header = $start_header+1;
                        $sheet->row( $start_header, array(
         					'English Language', 'Thai Language'
         				));
                        $sheet->row( $start_header, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                    //--- ----------------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $data ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $data as $info ) {
                                $sheet->row( $row_number, array(
                                    $info->name, $info->name_th
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof( $data )
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 1 ) {
            // set data
            $way_name = 'Country';
            $type_name = 'Country';
            $data = $country;

            //---- make file excel ----
            $name_file = 'Excel_Report_Biogeography_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Biogeography ('.$way_name.')' ) );
                        $start_header = 8;
                    //--- ----------- ---

                    //--- Header Table Part ---
                        $start_header = $start_header+1;
                        $sheet->row( $start_header, array(
         					'English Language', 'Thai Language'
         				));
                        $sheet->row( $start_header, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                    //--- ----------------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $data ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $data as $info ) {
                                $sheet->row( $row_number, array(
                                    $info->name, $info->name_th
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof( $data )
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 2 ) {
            // set data
            $way_name = 'Province';
            $type_name = 'Province';
            $data = $province;

            //---- make file excel ----
            $name_file = 'Excel_Report_Biogeography_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Biogeography ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Header Table Part ---
                        $start_header = $start_header+1;
                        $sheet->row( $start_header, array(
         					'English Language', 'Thai Language'
         				));
                        $sheet->row( $start_header, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                    //--- ----------------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $data ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $data as $info ) {
                                $sheet->row( $row_number, array(
                                    $info->name, $info->name_th
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof( $data )
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 3 ) {
            // set data
            $way_name = 'District';
            $type_name = 'District';
            $data = $district;

            //---- make file excel ----
            $name_file = 'Excel_Report_Biogeography_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Biogeography ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Header Table Part ---
                        $start_header = $start_header+1;
                        $sheet->row( $start_header, array(
         					'English Language', 'Thai Language'
         				));
                        $sheet->row( $start_header, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                    //--- ----------------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $data ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $data as $info ) {
                                $sheet->row( $row_number, array(
                                    $info->name, $info->name_th
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof( $data )
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } elseif ( $way == 4 ) {
            // set data
            $way_name = 'County';
            $type_name = 'County';
            $data = $county;

            //---- make file excel ----
            $name_file = 'Excel_Report_Biogeography_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Biogeography ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Header Table Part ---
                        $start_header = $start_header+1;
                        $sheet->row( $start_header, array(
         					'English Language', 'Thai Language'
         				));
                        $sheet->row( $start_header, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                    //--- ----------------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $data ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $data as $info ) {
                                $sheet->row( $row_number, array(
                                    $info->name, $info->name_th
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof( $data )
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        } else {
            // set data
            $way_name = 'Locality';
            $type_name = 'Locality';
            $data = $locality;

            //---- make file excel ----
            $name_file = 'Excel_Report_Biogeography_'.$way_name.'_'.$date_export_file_name;
            Excel::create( $name_file, function( $excel ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {
                $excel->sheet( 'Data', function( $sheet ) use ( $way, $data_search, $way_name, $type_name, $data, $date_export ) {

                    //--- Set Parameter ---
                        $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
                    //--- ------------- ---

                    //--- Set Layout and Style ---
                        $sheet->mergeCells( 'A2:D2' );
                        $sheet->mergeCells( 'A3:D3' );
                        $sheet->mergeCells( 'A4:D4' );
                        $sheet->mergeCells( 'A5:D5' );
                        $sheet->mergeCells( 'A6:D6' );
                        $sheet->mergeCells( 'A7:D7' );

                        $sheet->setHeight( 2, 30 );
                        $sheet->setHeight( 6, 30 );

                        $sheet->row( 2, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                        $sheet->row( 6, function( $row ) {
                            $row->setBackground('#FE9529');
                        });

                        $sheet->cell( 'A2:D2', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });
                        $sheet->cell( 'A6:D6', function( $cells ) {
                            $cells->setFontSize( 20 );
                        });

                        $sheet->cells( 'A2:D2', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });
                        $sheet->cells( 'A6:D6', function( $cells ) {
                            $cells->setFontWeight( 'bold' );
                        });

                    //--- -------------------- ---

                    //--- Header Part ---
                        $sheet->row( 2, array( 'Export Information' ) );
                        $sheet->row( 3, array( 'Export By: '.$user_name ) );
                        $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                        $sheet->row( 6, array( 'Data Information' ) );
                        $sheet->row( 7, array( 'Search Report Type: Biogeography ('.$way_name.')' ) );
                        $start_header = 8;

                        if ( isset( $data_search ) ) {
                            foreach ( $data_search as $info_search ) {
                                $sheet->row( $start_header, array(
                                    $info_search
                                ));
                                $start_header++;
                            }
                        }
                    //--- ----------- ---

                    //--- Header Table Part ---
                        $start_header = $start_header+1;
                        $sheet->row( $start_header, array(
         					'English Language', 'Thai Language'
         				));
                        $sheet->row( $start_header, function( $row ) {
                            $row->setBackground( '#FE9529' );
                        });
                    //--- ----------------- ---

                    //--- Content Part ---
                        // display data
                        if ( !is_null( $data ) ) {
                            $row_number = $start_header+1;   // start line
                            foreach ( $data as $info ) {
                                $sheet->row( $row_number, array(
                                    $info->name, $info->name_th
                                ));
                                $row_number++;
                            }
                            $sheet->row( $row_number+1, array(
                                'Number of '.$type_name.' Printed: '.sizeof( $data )
                            ));
                        }
                    //--- ------------ ---
                });
            })->store('xlsx', Config::get('path.export_record_file_path'));
        }

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog( 0, $name_file );

        // sent name_file for download
        echo $name_file.'.xlsx';
    }

    //Sorawit
	//Created : 25-7-59
	//Modified : -
    # Search Report (Record Count) for export excel
    public function exportRecordCount( Request $input ) {
        // get data from ajax
        $year = $input->year;

        // created export date
        $date = date_create();
        $date_export = date_format( $date, "d-m-Y H:i:s" );
        $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );

        //---- make file excel ----
        $name_file = 'Excel_Report_RecordCount_'.$date_export_file_name;
        Excel::create( $name_file, function( $excel ) use ( $year, $date_export ) {
            $excel->sheet( 'Data', function( $sheet ) use ( $year, $date_export ) {

                //--- Set Parameter ---
                    $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';

                    $records = Record::select('id');
                    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    $data = array();

                    // get Data
                    if ( Auth::user()->role_id == 3 ) { //manager
                        // get marine center
                        $marinecenter_id = Auth::user()->marinecenter_id;
                        foreach ($months as $i => $month) {
                            $monthID = $i+1;
                            if(strlen($monthID)===1) $monthID = '0'.$monthID;
                            $data[] = [$month, count(Record::where('collected_year', $year)->where('collected_month', $monthID)->where('record.marinecenter_id', $marinecenter_id)->where('approve_status', 1)->where('status', 2)->groupBy('unique_record')->get())];
                        }
                    } else {    //admin and board
                        foreach ($months as $i => $month) {
                            $monthID = $i+1;
                            if(strlen($monthID)===1) $monthID = '0'.$monthID;
                            $data[] = [$month, count(Record::where('collected_year', $year)->where('collected_month', $monthID)->where('approve_status', 1)->where('status', 2)->groupBy('unique_record')->get())];
                        }
                    }
                //--- ------------- ---

                //--- Set Layout and Style ---
                    $sheet->mergeCells( 'A2:D2' );
                    $sheet->mergeCells( 'A3:D3' );
                    $sheet->mergeCells( 'A4:D4' );
                    $sheet->mergeCells( 'A5:D5' );
                    $sheet->mergeCells( 'A6:D6' );
                    $sheet->mergeCells( 'A7:D7' );

                    $sheet->setHeight( 2, 30 );
                    $sheet->setHeight( 6, 30 );

                    $sheet->row( 2, function( $row ) {
                        $row->setBackground( '#FE9529' );
                    });
                    $sheet->row( 6, function( $row ) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell( 'A2:D2', function( $cells ) {
                        $cells->setFontSize( 20 );
                    });
                    $sheet->cell( 'A6:D6', function( $cells ) {
                        $cells->setFontSize( 20 );
                    });

                    $sheet->cells( 'A2:D2', function( $cells ) {
                        $cells->setFontWeight( 'bold' );
                    });
                    $sheet->cells( 'A6:D6', function( $cells ) {
                        $cells->setFontWeight( 'bold' );
                    });
                    $sheet->cells( 'A9:B9', function( $cells ) {
                        $cells->setFontWeight( 'bold' );
                    });

                    $sheet->setBorder('A9:B9', 'thin');
                    $sheet->cells( 'A9:B9', function( $cells ) {
                        $cells->setBackground('#FE9529');
                    });
                //--- -------------------- ---

                //--- Header Part ---
                    $sheet->row( 2, array( 'Export Information' ) );
                    $sheet->row( 3, array( 'Export By: '.$user_name ) );
                    $sheet->row( 4, array( 'Date Export: '.$date_export ) );
                    $sheet->row( 6, array( 'Data Information' ) );
                    $sheet->row( 7, array( 'Search Report Type: Record count over a year by collector date.' ) );

                    $sheet->row( 9, array(
                        'Month', 'Amount Records'
                    ));
                //--- ----------- ---

                //--- Content Part ---
                    // display data
                    if ( !is_null( $data ) ) {
                        $row_number = 10;   // start line
                        $total_record = 0;
                        foreach ( $data as $info ) {
                            $info[0];
                            $sheet->row( $row_number, array(
                                $info[0], $info[1]
                            ));

                            //--- Set Layout and Style ---
                                $sheet->setBorder('A'.$row_number.':B'.$row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $total_record += $info[1];
                        }
                    }

                    $sheet->row( $row_number, array(
                        'Total: ', $total_record
                    ));
                    $sheet->setBorder('A'.$row_number.':B'.$row_number, 'thin');
                    $sheet->cells( 'A'.$row_number, function( $cells ) {
                        $cells->setBackground('#FE9529');
                    });
                //--- ------------ ---
            });
        })->store('xlsx', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog( 0, $name_file );

        // sent name_file for download
        echo $name_file.'.xlsx';
    }

    //Nuttawoot
	//Created : 4-5-66
    # Download Admin Report
    public function downloadAdminReport() {

        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");
        $name_file = 'Admin_Report_' . $date_export_file_name;

        $sql = "SELECT
        r.related_catalog_item,
        r.related_reference_item,
        t5.name AS phylum,
        t6.name AS subphylum,
        t9.name AS class,
        t13.name AS order_o,
        t14.name AS suborder,
        t15.name AS infraorder,
        t17.name AS family,
        
        /*
        
       &amp; = 639 -> &
       &egrave; = 97 -> è
       &iacute; = 1  -> í
       &ouml; = 83 -> ö
       &rsquo; = 6 -> ’
       &uuml; = 155 -> ü
       &aring; = 106 -> å
       &eacute; = 52 -> é
       &oacute; = 5 -> ó
       &ecirc; = 1 -> ê
       &aacute; = 1 -> á
       &oslash; = 7 -> ø
       
       */
        
        
       REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.current_scientific_name, '&amp;', '&'), '&egrave;', 'è'), '&iacute;', 'í'), '&ouml;', 'ö'), '&rsquo;', '’'), '&uuml;', 'ü') , '&aring;', 'å'), '&eacute;', 'é'), '&oacute;', 'ó'), '&ecirc;', 'ê'), '&aacute;', 'á'), '&oslash;', 'ø') as current_scientific_name,
       
       REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.previous_scientific_name, '&amp;', '&'), '&egrave;', 'è'), '&iacute;', 'í'), '&ouml;', 'ö'), '&rsquo;', '’'), '&uuml;', 'ü') , '&aring;', 'å'), '&eacute;', 'é'), '&oacute;', 'ó'), '&ecirc;', 'ê'), '&aacute;', 'á'), '&oslash;', 'ø') as previous_scientific_name,
       
       
       
        w1.name_en AS type_status_en,
        r.identifier,
        r.previous_identifier,
        w2.name_en AS ocean_sea_lake_en,
        country.country_en,
        province.province_en,
        w3.name_en AS expendition_en,
        r.locality,
        r.individual_count,
        r.depth_start,
        r.depth_end,
        r.latitude,
        r.longitude
         
       FROM record as r
       
       LEFT JOIN classification as c on r.classification_id = c.id
       LEFT JOIN taxonomy AS t5 ON c.phylum = t5.id
       LEFT JOIN taxonomy AS t6 ON c.subphylum = t6.id
       LEFT JOIN taxonomy AS t9 ON c.class = t9.id
       LEFT JOIN taxonomy AS t13 ON c.order_o = t13.id
       LEFT JOIN taxonomy AS t14 ON c.suborder = t14.id
       LEFT JOIN taxonomy AS t15 ON c.infraorder = t15.id
       LEFT JOIN taxonomy AS t17 ON c.family = t17.id
       LEFT JOIN wording AS w1 ON r.type_status = w1.id
       LEFT JOIN wording AS w2 ON r.ocean_sea_lake = w2.id
       LEFT JOIN country ON r.country = country.id
       LEFT JOIN province ON r.province = province.id
       LEFT JOIN wording AS w3 ON r.expedition = w3.id
       
       WHERE r.language_id = 1 AND r.status = 2  AND r.approve_status = 1
       ORDER BY r.related_catalog_item, r.related_reference_item limit 0,10000";

        $data = DB::select($sql);
        
        Excel::create($name_file, function ($excel) use($data) {
            $excel->sheet('Record Data', function ($sheet) use($data) {
                //header
                $sheet->row(1, array(
                    'related_catalog_item',
                    'related_reference_item',
                    'phylum',
                    'subphylum',
                    'class',
                    'order_o',
                    'suborder',
                    'infraorder',
                    'family',
                    'current_scientific_name',
                    'previous_scientific_name',
                    'type_status_en',
                    'identifier',
                    'previous_identifier',
                    'ocean_sea_lake_en',
                    'country_en',
                    'province_en',
                    'expendition_en',
                    'locality',
                    'individual_count',
                    'depth_start',
                    'depth_end',
                    'latitude',
                    'longitude'
                   )); 
                   $row_n = 2;
                   foreach ($data as $info) {
                       $sheet->row($row_n, array(
                        ($info->related_catalog_item)?$info->related_catalog_item:"",
                        ($info->related_reference_item)?$info->related_reference_item:"",
                        ($info->phylum)?$info->phylum:"",
                        ($info->subphylum)?$info->subphylum:"",
                        ($info->class)?$info->class:"",
                        ($info->order_o)?$info->order_o:"",
                        ($info->suborder)?$info->suborder:"",
                        ($info->infraorder)?$info->infraorder:"",
                        ($info->family)?$info->family:"",
                        ($info->current_scientific_name)?$info->current_scientific_name:"",
                        ($info->previous_scientific_name)?$info->previous_scientific_name:"",
                        ($info->type_status_en)?$info->type_status_en:"",
                        ($info->identifier)?$info->identifier:"",
                        ($info->previous_identifier)?$info->previous_identifier:"",
                        ($info->ocean_sea_lake_en)?$info->ocean_sea_lake_en:"",
                        ($info->country_en)?$info->country_en:"",
                        ($info->province_en)?$info->province_en:"",
                        ($info->expendition_en)?$info->expendition_en:"",
                        ($info->locality)?$info->locality:"",
                        ($info->individual_count)?$info->individual_count:"",
                        ($info->depth_start)?$info->depth_start:"",
                        ($info->depth_end)?$info->depth_end:"",
                        ($info->latitude)?$info->latitude:"",
                        ($info->longitude)?$info->longitude:""
                       ));
                       $row_n++;
                   }     
            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }
}
