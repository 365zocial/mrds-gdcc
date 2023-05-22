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
    public function downloadAdminReport(Request $input) {

        $conn = "";
        if ($input->marine_center != "ALL"){
            $conn = " and r.marinecenter_id = ".$input->marine_center;
        }

        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");
        $name_file = 'Admin_Report_' . $date_export_file_name;

        /*
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
       
       WHERE r.language_id = 1 AND r.status = 2  AND r.approve_status = 1 $conn
       ORDER BY r.related_catalog_item, r.related_reference_item";*/

       $sql ="SELECT r.marinecenter_id,
       m.marinecenter_code,
       r.collection_code,
       cc.col_code,
       r.catalog_number,
       r.related_catalog_item,
       CASE WHEN r.source = 1 THEN 'specimen' ELSE 'reference' END source,
       re.ref_code as reference,
       r.page,
       r.no_species,
       r.no_locality,
       r.related_reference_item,
       r.individual_count,
       r.latitude,
       r.start_latitude,
       r.end_latitude,
       r.verbatim_latitude,
       r.verbatim_longitude,
       r.longitude,
       r.start_longitude,
       r.end_longitude,
       cr.country_en as country,
       p.province_en as province,
       d.district_en as district,
       co.county_en as county,
       r.locality,
       w3.name_en as ocean_sea_lake,
       r.islands_island,
       w8.name_en as habitat,
       w25.name_en as sediment_type,
       CASE WHEN r.type_status = 1 THEN 'Holotype' WHEN r.type_status = 2 THEN 'Paratype' WHEN r.type_status = 3 THEN 'Neotype' WHEN r.type_status = 4 THEN 'Allotype' END AS type_status,
       r.diagnosis,
       r.description,
       w5.name_en as sex,
       r.size,
       w9.name_en as life_stage,
       w10.name_en as donated_from,
       w11.name_en as deposited_at,
       w4.name_en as gear_method,
       r.depth_start,
       r.depth_end,
       r.collector,
       r.collected_date,
       r.collected_year,
       r.collected_month,
       r.collected_day,
       r.identifier,
       r.identified_date,
       r.identified_year,
       r.identified_month,
       r.identified_day,
       r.previous_identifier,
       r.previous_identified_date,
       r.note_collector,
       w6.name_en as expedition,
       w7.name_en as preparation_type,
       r.gene_bank_number,
       r.local_name,
       r.vernacular_name,
       w15.name_en as team_exploration_code,
       w16.name_en as area_exploration,
       r.village_no,
       w13.name_en as area_direction,
       r.area,
       r.folk_wisdom,
       r.recorder,
       r.knowledge_remarks,
       r.water_temperature,
       r.transparency,
       r.water_ph,
       r.dissolve_oxygen,
       r.suspended_solid,
       r.salinity,
       r.specimen_collection,
       r.specimen_photograph,
       w18.name_en as animal_type1,
       w19.name_en as animal_type2,
       w20.name_en as animal_type3,
       w24.name_en as economic_value,
       CASE WHEN r.reproduction = 0 THEN 'ไม่ได้เลือก' WHEN r.reproduction = 1 THEN 'อาศัยเพศ' WHEN r.reproduction = 2 THEN 'ไม่อาศัยเพศ' WHEN r.reproduction = 3 THEN 'อาศัยเพศและไม่อาศัยเพศ' END AS reproduction,
       w21.name_en as plant_type,
       r.picture_name,
       r.picture_remark,
       r.created_at,
       REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.current_scientific_name, '&amp;', '&'), '&egrave;', 'è'), '&iacute;', 'í'), '&ouml;', 'ö'), '&rsquo;', '’'), '&uuml;', 'ü') , '&aring;', 'å'), '&eacute;', 'é'), '&oacute;', 'ó'), '&ecirc;', 'ê'), '&aacute;', 'á'), '&oslash;', 'ø') as current_scientific_name,
       t1.name as domain,
       t2.name as kingdom,
       t3.name as subkingdom,
       t4.name as infrakingdom,
       t5.name as phylum,
       t6.name as subphylum,
       t7.name as infraphylum,
       t8.name as superclass,
       t9.name as class,
       t10.name as subclass,
       t11.name as infraclass,
       t12.name as superorder,
       t13.name as order_o,
       t14.name as suborder,
       t15.name as infraorder,
       t16.name as superfamily,
       t17.name as family,
       t18.name as subfamily,
       t19.name as genus,
       t20.name as subgenus,
       t21.name as species,
       t22.name as subspecies,
       w1.name_en as identification_qualifier,
       c.common_name,
       r.variety_name,
       REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.previous_scientific_name, '&amp;', '&'), '&egrave;', 'è'), '&iacute;', 'í'), '&ouml;', 'ö'), '&rsquo;', '’'), '&uuml;', 'ü') , '&aring;', 'å'), '&eacute;', 'é'), '&oacute;', 'ó'), '&ecirc;', 'ê'), '&aacute;', 'á'), '&oslash;', 'ø') as previous_scientific_name,
       w26.name_en as invasive_species,
       w27.name_en as living,
       w22.name_en as protection_thai_law,
       w28.name_en as thai_red_list,
       w12.name_en as protection_iucn_2019,
       w23.name_en as protection_cites,
       pc.path_pic,
       pc.caption,
       pc.photographer,
       pc.selected_picture
       FROM `record` r 
       Left join `classification` c on r.`classification_id` = c.`id`
       Left join `taxonomy` t1 on c.`domain` = t1.`id`
       Left join `taxonomy` t2 on c.`Kingdom` = t2.`id`
       Left join `taxonomy` t3 on c.`subkingdom` = t3.`id`
       Left join `taxonomy` t4 on c.`infrakingdom` = t4.`id`
       Left join `taxonomy` t5 on c.`phylum` = t5.`id`
       Left join `taxonomy` t6 on c.`subphylum` = t6.`id`
       Left join `taxonomy` t7 on c.`infraphylum` = t7.`id`
       Left join `taxonomy` t8 on c.superclass = t8.`id`
       Left join `taxonomy` t9 on c.class = t9.`id`
       Left join `taxonomy` t10 on c.subclass = t10.`id`
       Left join `taxonomy` t11 on c.infraclass = t11.`id`
       Left join `taxonomy` t12 on c.superorder = t12.`id`
       Left join `taxonomy` t13 on c.order_o = t13.`id`
       Left join `taxonomy` t14 on c.suborder = t14.`id`
       Left join `taxonomy` t15 on c.infraorder = t15.`id`
       Left join `taxonomy` t16 on c.superfamily = t16.`id`
       Left join `taxonomy` t17 on c.family = t17.`id`
       Left join `taxonomy` t18 on c.subfamily = t18.`id`
       Left join `taxonomy` t19 on c.genus = t19.`id`
       Left join `taxonomy` t20 on c.subgenus = t20.`id`
       Left join `taxonomy` t21 on c.species = t21.`id`
       Left join `taxonomy` t22 on c.subspecies = t22.`id`
       Left join `county` co on  r.county = co.id
       Left join `country` cr on  r.country = cr.id
       Left join `district` d on r.district = d.id
       Left join `marinecenter` m on r.marinecenter_id = m.id
       Left join `province` p  on r.province = p.id
       Left join `collection` cc  on r.collection_code = cc.id
       Left join `reference` re on r.reference = re.id
       Left join `wording` w1 on c.identification_qualifier = w1.id
       Left join `wording` w3 on r.ocean_sea_lake = w3.id
       Left join `wording` w4 on r.depth_start = w4.id
       Left join `wording` w5 on r.sex = w5.id
       Left join `wording` w6 on r.expedition = w6.id
       Left join `wording` w7 on r.preparation_type = w7.id
       Left join `wording` w8 on r.habitat = w8.id
       Left join `wording` w9 on r.life_stage = w9.id
       Left join `wording` w10 on r.donated_from = w10.id
       Left join `wording` w11 on r.deposited_at = w11.id
       Left join `wording` w12 on c.protection_iucn_2019 = w12.id
       Left join `wording` w13 on r.area_direction = w13.id
       Left join `wording` w15 on r.team_exploration_code = w15.id
       Left join `wording` w16 on r.area_exploration = w16.id
       Left join `wording` w18 on r.animal_type1 = w18.id
       Left join `wording` w19 on r.animal_type2 = w19.id
       Left join `wording` w20 on r.animal_type3 = w20.id
       Left join `wording` w21 on r.plant_type = w21.id
       Left join `wording` w22 on c.protection_thai_law = w22.id
       Left join `wording` w23 on c.protection_cites = w23.id
       Left join `wording` w24 on r.economic_value = w24.id
       Left join `wording` w25 on r.sediment_type = w25.id
       Left join `wording` w26 on c.invasive_species = w26.id
       Left join `wording` w27 on c.living = w27.id
       Left join `wording` w28 on c.thai_red_list = w28.id
       Left join `picture` pc on r.unique_record = pc.unique_record
       where r.language_id = 1 and r.approve_status = 1 and r.status = 2 $conn
       order by r.id desc";

        //echo $sql;
        $data = DB::select($sql);
        
        Excel::create($name_file, function ($excel) use($data) {
            $excel->sheet('Record Data', function ($sheet) use($data) {
                //header
                $sheet->row(1, array(
                    // 'related_catalog_item',
                    // 'related_reference_item',
                    // 'phylum',
                    // 'subphylum',
                    // 'class',
                    // 'order_o',
                    // 'suborder',
                    // 'infraorder',
                    // 'family',
                    // 'current_scientific_name',
                    // 'previous_scientific_name',
                    // 'type_status_en',
                    // 'identifier',
                    // 'previous_identifier',
                    // 'ocean_sea_lake_en',
                    // 'country_en',
                    // 'province_en',
                    // 'expendition_en',
                    // 'locality',
                    // 'individual_count',
                    // 'depth_start',
                    // 'depth_end',
                    // 'latitude',
                    // 'longitude'
                    'Date',
                    'MarineCenter',
                    'Source',
                    'CollectionCode',
                    'CatalogNumber',
                    'RelatedCatalogItem',
                    'Reference',
                    'Page',
                    'NoSpecies',
                    'NoLocality',
                    'RelatedReferenceItem',
                    'DonatedFrom',
                    'DepositedAt',
                    'CurrentScientificName',
                    'Domain',
                    'Kingdom',
                    'Subkingdom',
                    'Infrakingdom',
                    'Phylum',
                    'Subphylum',
                    'Infraphylum',
                    'SuperClass',
                    'Class',
                    'Subclass',
                    'Infraclass',
                    'Superorder',
                    'Order_o',
                    'Suborder',
                    'Infraorder',
                    'Superfamily',
                    'Family',
                    'Subfamily',
                    'Genus',
                    'Subgenus',
                    'Species',
                    'Subspecies',
                    'IdentificationQualifier',
                    'CommonName',
                    'Variety Name',
                    'PreviousScientificName',
                    'TypeStatus',
                    'Diagnosis',
                    'Description',
                    'IndividualCount',
                    'Sex',
                    'Size',
                    'LifeStage',
                    'OceanSeaLake',
                    'Islands/Island',
                    'Country',
                    'Province',
                    'District',
                    'County',
                    'Locality',
                    'VerbatimLatitude',
                    'Latitude',
                    'StartLatitude',
                    'EndLatitude',
                    'VerbatimLongitude',
                    'Longitude',
                    'StartLongitude',
                    'EndLongitude',
                    'Habitat',
                    'Gear_Method',
                    'Depth',
                    'Depth_End',
                    'Sediment_Type',
                    'Collector',
                    'CollectedDate',
                    'YearCollected',
                    'MonthCollected',
                    'DayCollected',
                    'CurrentIdentifier',
                    'CurrentIdentifiedDate',
                    'YearIdentified',
                    'MonthIdentified',
                    'DayIdentified',
                    'PreviousIdentifier',
                    'PreviousIdentifiedDate',
                    'Notes',
                    'PreparationType',
                    'Expedition',
                    'GeneBankNumber',
                    'ImageURL',
                    'LocalName',
                    'VernacularName',
                    'TeamExplorationCode',
                    'AreaExploration',
                    'VillageNumber',
                    'AreaDirection',
                    'Area',
                    'FolkWisdom',
                    'Recorder',
                    'knowledgeRemarks',
                    'WaterTemperature',
                    'Transparency',
                    'WaterpH',
                    'DissolvedOxygen',
                    'SuspendedSolid',
                    'Salinity',
                    'SpecimenCollection',
                    'SpecimenPhotograph',
                    'EconomicValue',
                    'Invasive species',
                    'Living',
                    'PlantType',
                    'AnimalType1',
                    'AnimalType2',
                    'AnimalType3',
                    'ProtectionThaiLaw',
                    'ProtectionThaiRedList',
                    'ProtectionIUCN2019',
                    'ProtectionCITES',
                    'Reproduction',
                    'PictureName',
                    'Caption',
                    'selected_picture',
                    'Photographer',
                    'PictureRemarks'
                   )); 
                   $row_n = 2;
                   foreach ($data as $info) {
                       $sheet->row($row_n, array(
                        // ($info->related_catalog_item)?$info->related_catalog_item:"",
                        // ($info->related_reference_item)?$info->related_reference_item:"",
                        // ($info->phylum)?$info->phylum:"",
                        // ($info->subphylum)?$info->subphylum:"",
                        // ($info->class)?$info->class:"",
                        // ($info->order_o)?$info->order_o:"",
                        // ($info->suborder)?$info->suborder:"",
                        // ($info->infraorder)?$info->infraorder:"",
                        // ($info->family)?$info->family:"",
                        // ($info->current_scientific_name)?$info->current_scientific_name:"",
                        // ($info->previous_scientific_name)?$info->previous_scientific_name:"",
                        // ($info->type_status_en)?$info->type_status_en:"",
                        // ($info->identifier)?$info->identifier:"",
                        // ($info->previous_identifier)?$info->previous_identifier:"",
                        // ($info->ocean_sea_lake_en)?$info->ocean_sea_lake_en:"",
                        // ($info->country_en)?$info->country_en:"",
                        // ($info->province_en)?$info->province_en:"",
                        // ($info->expendition_en)?$info->expendition_en:"",
                        // ($info->locality)?$info->locality:"",
                        // ($info->individual_count)?$info->individual_count:"",
                        // ($info->depth_start)?$info->depth_start:"",
                        // ($info->depth_end)?$info->depth_end:"",
                        // ($info->latitude)?$info->latitude:"",
                        // ($info->longitude)?$info->longitude:""
                        ($info->created_at)?$info->created_at:"",
                        ($info->marinecenter_code)?$info->marinecenter_code:"",
                        ($info->source)?$info->source:"",
                        ($info->col_code)?$info->col_code:"",
                        ($info->catalog_number)?$info->catalog_number:"",
                        ($info->related_catalog_item)?$info->related_catalog_item:"",
                        ($info->reference)?$info->reference:"",
                        ($info->page)?$info->page:"",
                        ($info->no_species)?$info->no_species:"",
                        ($info->no_locality)?$info->no_locality:"",
                        ($info->related_reference_item)?$info->related_reference_item:"",
                        ($info->donated_from)?$info->donated_from:"",
                        ($info->deposited_at)?$info->deposited_at:"",
                        ($info->current_scientific_name)?$info->current_scientific_name:"",
                        ($info->domain)?$info->domain:"",
                        ($info->kingdom)?$info->kingdom:"",
                        ($info->subkingdom)?$info->subkingdom:"",
                        ($info->infrakingdom)?$info->infrakingdom:"",
                        ($info->phylum)?$info->phylum:"",
                        ($info->subphylum)?$info->subphylum:"",
                        ($info->infraphylum)?$info->infraphylum:"",
                        ($info->superclass)?$info->superclass:"",
                        ($info->class)?$info->class:"",
                        ($info->subclass)?$info->subclass:"",
                        ($info->infraclass)?$info->infraclass:"",
                        ($info->superorder)?$info->superorder:"",
                        ($info->order_o)?$info->order_o:"",
                        ($info->suborder)?$info->suborder:"",
                        ($info->infraorder)?$info->infraorder:"",
                        ($info->superfamily)?$info->superfamily:"",
                        ($info->family)?$info->family:"",
                        ($info->subfamily)?$info->subfamily:"",
                        ($info->genus)?$info->genus:"",
                        ($info->subgenus)?$info->subgenus:"",
                        ($info->species)?$info->species:"",
                        ($info->subspecies)?$info->subspecies:"",
                        ($info->identification_qualifier)?$info->identification_qualifier:"",
                        ($info->common_name)?$info->common_name:"",
                        ($info->variety_name)?$info->variety_name:"",
                        ($info->previous_scientific_name)?$info->previous_scientific_name:"",
                        ($info->type_status)?$info->type_status:"",
                        ($info->diagnosis)?$info->diagnosis:"",
                        ($info->description)?$info->description:"",
                        ($info->individual_count)?$info->individual_count:"",
                        ($info->sex)?$info->sex:"",
                        ($info->size)?$info->size:"",
                        ($info->life_stage)?$info->life_stage:"",
                        ($info->ocean_sea_lake)?$info->ocean_sea_lake:"",
                        ($info->islands_island)?$info->islands_island:"",
                        ($info->country)?$info->country:"",
                        ($info->province)?$info->province:"",
                        ($info->district)?$info->district:"",
                        ($info->county)?$info->county:"",
                        ($info->locality)?$info->locality:"",
                        ($info->verbatim_latitude)?$info->verbatim_latitude:"",
                        ($info->latitude)?$info->latitude:"",
                        ($info->start_latitude)?$info->start_latitude:"",
                        ($info->end_latitude)?$info->end_latitude:"",
                        ($info->verbatim_longitude)?$info->verbatim_longitude:"",
                        ($info->longitude)?$info->longitude:"",
                        ($info->start_longitude)?$info->start_longitude:"",
                        ($info->end_longitude)?$info->end_longitude:"",
                        ($info->habitat)?$info->habitat:"",
                        ($info->gear_method)?$info->gear_method:"",
                        ($info->depth_start)?$info->depth_start:"",
                        ($info->depth_end)?$info->depth_end:"",
                        ($info->sediment_type)?$info->sediment_type:"",
                        ($info->collector)?$info->collector:"",
                        ($info->collected_date)?$info->collected_date:"",
                        ($info->collected_year)?$info->collected_year:"",
                        ($info->collected_month)?$info->collected_month:"",
                        ($info->collected_day)?$info->collected_day:"",
                        ($info->identifier)?$info->identifier:"",
                        ($info->identified_date)?$info->identified_date:"",
                        ($info->identified_year)?$info->identified_year:"",
                        ($info->identified_month)?$info->identified_month:"",
                        ($info->identified_day)?$info->identified_day:"",
                        ($info->previous_identifier)?$info->previous_identifier:"",
                        ($info->previous_identified_date)?$info->previous_identified_date:"",
                        ($info->note_collector)?$info->note_collector:"",
                        ($info->preparation_type)?$info->preparation_type:"",
                        ($info->expedition)?$info->expedition:"",
                        ($info->gene_bank_number)?$info->gene_bank_number:"",
                        ($info->path_pic)?$info->path_pic:"",
                        ($info->local_name)?$info->local_name:"",
                        ($info->vernacular_name)?$info->vernacular_name:"",
                        ($info->team_exploration_code)?$info->team_exploration_code:"",
                        ($info->area_exploration)?$info->area_exploration:"",
                        ($info->village_no)?$info->village_no:"",
                        ($info->area_direction)?$info->area_direction:"",
                        ($info->area)?$info->area:"",
                        ($info->folk_wisdom)?$info->folk_wisdom:"",
                        ($info->recorder)?$info->recorder:"",
                        ($info->knowledge_remarks)?$info->knowledge_remarks:"",
                        ($info->water_temperature)?$info->water_temperature:"",
                        ($info->transparency)?$info->transparency:"",
                        ($info->water_ph)?$info->water_ph:"",
                        ($info->dissolve_oxygen)?$info->dissolve_oxygen:"",
                        ($info->suspended_solid)?$info->suspended_solid:"",
                        ($info->salinity)?$info->salinity:"",
                        ($info->specimen_collection)?$info->specimen_collection:"",
                        ($info->specimen_photograph)?$info->specimen_photograph:"",
                        ($info->economic_value)?$info->economic_value:"",
                        ($info->invasive_species)?$info->invasive_species:"",
                        ($info->living)?$info->living:"",
                        ($info->plant_type)?$info->plant_type:"",
                        ($info->animal_type1)?$info->animal_type1:"",
                        ($info->animal_type2)?$info->animal_type2:"",
                        ($info->animal_type3)?$info->animal_type3:"",
                        ($info->protection_thai_law)?$info->protection_thai_law:"",
                        ($info->thai_red_list)?$info->thai_red_list:"",
                        ($info->protection_iucn_2019)?$info->protection_iucn_2019:"",
                        ($info->protection_cites)?$info->protection_cites:"",
                        ($info->reproduction)?$info->reproduction:"",
                        ($info->picture_name)?$info->picture_name:"",
                        ($info->caption)?$info->caption:"",
                        ($info->selected_picture)?$info->selected_picture:"",
                        ($info->photographer)?$info->photographer:"",
                        ($info->picture_remark)?$info->picture_remark:""
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

    //Nuttawoot
	//Created : 4-5-66
    # Download Admin Report
    public function downloadAdminReport2(Request $input) {

        $conn = "";
        if ($input->marine_center != "ALL"){
            $conn = " and r.marinecenter_id = ".$input->marine_center;
        }

        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");
        $name_file = 'Admin_Report_' . $date_export_file_name;

        $sql = "SELECT

        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.current_scientific_name, '&amp;', '&'), '&egrave;', 'è'), '&iacute;', 'í'), '&ouml;', 'ö'), '&rsquo;', '’'), '&uuml;', 'ü') , '&aring;', 'å'), '&eacute;', 'é'), '&oacute;', 'ó'), '&ecirc;', 'ê'), '&aacute;', 'á'), '&oslash;', 'ø') as current_scientific_name,
        r.source,
        r.marinecenter_id,
        r.collection_code,
        r.catalog_number,
        r.variety_name,
        r.donated_from,
        r.deposited_at,
        r.type_status,
        r.individual_count,
        r.sex,
        r.size,
        r.life_stage,
        r.ocean_sea_lake,
        r.islands_island,
        r.country,
        r.locality,
        r.verbatim_latitude,
        r.verbatim_longitude,
        r.latitude,
        r.longitude,
        r.start_latitude,
        r.end_latitude,
        r.start_longitude,
        r.end_longitude,
        r.habitat,
        r.sediment_type,
        r.depth_start,
        r.depth_end,
        r.collector,
        r.collected_date,
        r.identifier,
        r.identified_date,
        r.previous_identifier,
        r.previous_identified_date,
        r.gear_method,
        r.preparation_type,
        r.expedition,
        r.gene_bank_number,
        r.diagnosis,
        r.description,
        r.note_collector
/*
        r.related_catalog_item,
        r.related_reference_item,
        t5.name AS phylum,
        t6.name AS subphylum,
        t9.name AS class,
        t13.name AS order_o,
        t14.name AS suborder,
        t15.name AS infraorder,
        t17.name AS family,
        */
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
        
        

       
       /*REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(c.previous_scientific_name, '&amp;', '&'), '&egrave;', 'è'), '&iacute;', 'í'), '&ouml;', 'ö'), '&rsquo;', '’'), '&uuml;', 'ü') , '&aring;', 'å'), '&eacute;', 'é'), '&oacute;', 'ó'), '&ecirc;', 'ê'), '&aacute;', 'á'), '&oslash;', 'ø') as previous_scientific_name,*/
       
       
       /*
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
        r.longitude*/
         
       FROM record as r
       
       LEFT JOIN classification as c on r.classification_id = c.id
       /*
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
       LEFT JOIN wording AS w3 ON r.expedition = w3.id*/
       
       WHERE r.language_id = 1 AND r.status = 2  AND r.approve_status = 1 $conn
       ORDER BY r.related_catalog_item, r.related_reference_item limit 0,10";

        //echo $sql;
        $data = DB::select($sql);
        
        Excel::create($name_file, function ($excel) use($data) {
            $excel->sheet('Record Data', function ($sheet) use($data) {
                //header
                $sheet->row(1, array(
                    'Current Scientific Name',
                    'Source',
                    'Marine Center',
                    'Collection Code',
                    'Catalog Number',
                    'Variety Name',
                    'Donated From',
                    'Deposited At',
                    'Type Status',
                    'Individual Count',
                    'Sex',
                    'Size',
                    'Life Stage',
                    'Ocean / Sea / Lake',
                    'Islands / Island',
                    'Country',
                    'Locality',
                    'Verbatim Latitude',
                    'Verbatim Longitude',
                    'Latitude',
                    'Longitude',
                    'Start Latitude',
                    'End Latitude',
                    'Start Longitude',
                    'End Longitude',
                    'Habitat',
                    'Sediment Type',
                    'Depth Start',
                    'Depth End',
                    'Collector',
                    'Collected Date',
                    'Current Identifier',
                    'Current Idenified Date',
                    'Previous Identifier',
                    'Previous Idenified Date',
                    'Gear Method',
                    'Preparation Type',
                    'Expedition',
                    'Gene Bank Number',
                    'Diagnosis',
                    'Description',
                    'Notes'
                   )); 
                   $row_n = 2;
                   foreach ($data as $info) {
                       $sheet->row($row_n, array(
                        ($info->current_scientific_name)?$info->current_scientific_name:"",
                        ($info->source)?$info->source:"",
                        ($info->marinecenter_id)?$info->marinecenter_id:"",
                        ($info->collection_code)?$info->collection_code:"",
                        ($info->catalog_number)?$info->catalog_number:"",
                        ($info->variety_name)?$info->variety_name:"",
                        ($info->donated_from)?$info->donated_from:"",
                        ($info->deposited_at)?$info->deposited_at:"",
                        ($info->type_status)?$info->type_status:"",
                        ($info->individual_count)?$info->individual_count:"",
                        ($info->sex)?$info->sex:"",
                        ($info->size)?$info->size:"",
                        ($info->life_stage)?$info->life_stage:"",
                        ($info->ocean_sea_lake)?$info->ocean_sea_lake:"",
                        ($info->islands_island)?$info->islands_island:"",
                        ($info->country)?$info->country:"",
                        ($info->locality)?$info->locality:"",
                        ($info->verbatim_latitude)?$info->verbatim_latitude:"",
                        ($info->verbatim_longitude)?$info->verbatim_longitude:"",
                        ($info->latitude)?$info->latitude:"",
                        ($info->longitude)?$info->longitude:"",
                        ($info->start_latitude)?$info->start_latitude:"",
                        ($info->end_latitude)?$info->end_latitude:"",
                        ($info->start_longitude)?$info->start_longitude:"",
                        ($info->end_longitude)?$info->end_longitude:"",
                        ($info->habitat)?$info->habitat:"",
                        ($info->sediment_type)?$info->sediment_type:"",
                        ($info->depth_start)?$info->depth_start:"",
                        ($info->depth_end)?$info->depth_end:"",
                        ($info->collector)?$info->collector:"",
                        ($info->collected_date)?$info->collected_date:"",
                        ($info->identifier)?$info->identifier:"",
                        ($info->identified_date)?$info->identified_date:"",
                        ($info->previous_identifier)?$info->previous_identifier:"",
                        ($info->previous_identified_date)?$info->previous_identified_date:"",
                        ($info->gear_method)?$info->gear_method:"",
                        ($info->preparation_type)?$info->preparation_type:"",
                        ($info->expedition)?$info->expedition:"",
                        ($info->gene_bank_number)?$info->gene_bank_number:"",
                        ($info->diagnosis)?$info->diagnosis:"",
                        ($info->description)?$info->description:"",
                        ($info->note_collector)?$info->note_collector:""
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
