<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;
use Auth;
use DB;
use Response;
use Session;
use Config;
use File;
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
use Ifsnop\Mysqldump as IMysqldump;

use App\Http\Controllers\SearchTypeAController;
use App\Http\Controllers\SearchTypeBController;
use App\Http\Controllers\SearchTypeCController;

class ExportRecordController extends Controller
{

    //Sorawit
    //Created : 22-6-59
    //Modified : -
    # form search record for export excel (PGCP)
    public function exportRecord()
    {
        return view('staff.export_record.export_record');
    }

    public function deleteFileForExcelRecord(Request $input)
    {
        // get path file
        File::delete('export_result_record/' . $input->name_file);
    }

    //Sorawit
    //Created : 2-7-59
    //Modified : -
    # export result search by csv (PGCP)
    public function doExportRecord(Request $input)
    {
        // get data
        $table_name = $input->db_table;
        $start_date = date('Y-m-d', strtotime($input->start_date));
        $end_date = date('Y-m-d', strtotime($input->end_date));

        // set end time
        $end_time = date_create('23:59:59');
        $end_time = date_format($end_time, 'H:i:s');
        $end_date = date('Y-m-d H:i:s', strtotime($end_date . ' ' . $end_time));

        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set name file
        $name_file = 'table_' . $table_name . '_' . $date_export_file_name . '.csv';

        // query db
        $public_path = public_path('export_record_pgcp') . '/' . $name_file;
        $remark1 = '"';
        $remark2 = ',';
        $remark3 = '\n';
        $result = DB::statement("SELECT * FROM " . $table_name . " WHERE created_at BETWEEN '" . $start_date . "' AND '" . $end_date . "' INTO OUTFILE '" . $public_path . "' CHARACTER SET utf8 FIELDS TERMINATED BY '" . $remark2 . "' ENCLOSED BY '" . $remark1 . "' LINES TERMINATED BY '" . $remark3 . "'");

        // download file
        //$file = url('export_record_pgcp').'/'.$name_file;

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        return redirect('export_record_pgcp/' . $name_file);

        // header("Content-Description: File Transfer");
        // header('Content-Encoding: UTF-8');
        // header('Content-type: text/csv; charset=UTF-8'); //header("Content-Type: application/octet-stream");
        // header('Content-Transfer-Encoding: binary');
        // header("Content-Disposition: attachment; filename=\"$name_file\"");

        // delete file
        // File::delete('export_record_pgcp/'.$name_file);
        // $files = glob( base_path().Config::get('path.export_pgcp_file_path').'export_record_pgcp/*' );
        // $file_not_delete = base_path().Config::get('path.export_pgcp_file_path').'export_record_pgcp/README.txt';
        // foreach( $files as $file ){
        //     if ( is_file( $file ) ) {
        //         if ( $file == $file_not_delete ) {
        //             // not delete file for reserve folder.
        //         } else {
        //             unlink( $file );
        //         }
        //     }
        // }
    }

    //Sorawit
    //Created : 7-9-59
    //Modified : -
    # form export by sql
    public function exportRecordSQL()
    {
        return view('staff.export_record.export_record_sql');
    }

    //Sorawit
    //Created : 7-9-59
    //Modified : -
    # form export by sql
    public function doExportRecordSQL()
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set name file
        $name_file = 'sql_' . $date_export_file_name . '.sql';

        // query db
        // echo "mysqldump --user=".env('DB_USERNAME', 'root')." --password=".env('DB_PASSWORD', 'toor')." --host=".env('DB_HOST', 'localhost')." ".env('DB_DATABASE', 'mbds')." > export_record_pgcp/".$name_file;
        // exec("mysqldump --user=".env('DB_USERNAME', 'root')." --password=".env('DB_PASSWORD', 'toor')." --host=".env('DB_HOST', 'localhost')." ".env('DB_DATABASE', 'mbds')." > export_record_pgcp/".$name_file);

        try {
            $dump = new IMysqldump\Mysqldump('mysql:host=' . env('DB_HOST', 'localhost') . ';dbname=' . env('DB_DATABASE', 'mbds'), env('DB_USERNAME', 'root'), env('DB_PASSWORD', 'toor'));
            $dump->start("export_record_pgcp/" . $name_file);
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        return redirect('export_record_pgcp/' . $name_file);
    }

    //Sorawit
    //Created : 7-7-59
    //Modified : -
    # Search By Date for export excel
    public static function exportSearchByDate($source, $start_date, $end_date, $date_type)
    {
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        // set end time
        $end_time = date_create('23:59:59');
        $end_time = date_format($end_time, 'H:i:s');
        $end_date = date('Y-m-d H:i:s', strtotime($end_date . ' ' . $end_time));

        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set source
        if ($source == 1) $source_name = 'Specimen';
        else $source_name = 'Publication';

        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_Date' . '_' . $source_name . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($source, $start_date, $end_date, $date_type, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($source, $start_date, $end_date, $date_type, $date_export) {

                //--- Set Parameter ---
                $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';
                $start_date_header = date('d-m-Y', strtotime($start_date));
                $end_date_header = date('d-m-Y', strtotime($end_date));

                $from_date_format = date('Y-m-d', strtotime($start_date));
                $to_date_format = date('Y-m-d', strtotime($end_date));

                // set $source
                if ($source == 1) $source_name = 'Specimen';
                else $source_name = 'Publication';

                // check condition
                if ($date_type == 1) { // Collected Date
                    $date_type_name = 'record.collected_date';
                    $date_type_column = 'Collected Date';    //make header
                } else { // Identified Date
                    $date_type_name = 'record.identified_date';
                    $date_type_column = 'Identified Date';   //make header
                }

                if ($start_date != null && $end_date != null) {
                    // query db
                    $db = new Record;
                    $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
                    if ($date_type == 1) {  // collected_date
                        $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->whereBetween($date_type_name, [$from_date_format, $end_date])->orderBy('collected_date', 'desc');
                        $results = $db->select([
                            'c.current_scientific_name',
                            'record.related_catalog_item',
                            'record.related_reference_item',
                            'record.collected_date as date'
                        ])->get();
                    } else {  // identified_date
                        $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->whereBetween($date_type_name, [$from_date_format, $end_date])->orderBy('identified_date', 'desc');
                        $results = $db->select([
                            'c.current_scientific_name',
                            'record.related_catalog_item',
                            'record.related_reference_item',
                            'record.identified_date as date'
                        ])->get();
                    }

                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:D2');
                    $sheet->mergeCells('A3:D3');
                    $sheet->mergeCells('A4:D4');
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('A6:D6');
                    $sheet->mergeCells('A7:D7');
                    $sheet->mergeCells('A8:D8');
                    $sheet->mergeCells('A9:D9');
                    $sheet->mergeCells('A10:D10');
                    $sheet->mergeCells('A11:D11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(13, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:D2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:D6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A13:D13', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:D2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:D6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A13:D13', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A13:D13', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: Search By Date'));
                    $sheet->row(8, array('Source: ' . $source_name));
                    $sheet->row(9, array('Date Type: ' . $date_type_column));
                    $sheet->row(10, array('Data Start Date: ' . $start_date_header));
                    $sheet->row(11, array('Data End Date: ' . $end_date_header));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $sheet->row(13, array(
                        'No.', 'IDCatalog / IDRef', 'Scientific Name', 'Date'
                    ));
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 14;   // start line
                    $count_line = 1;   // count line for No.
                    if ($source == 1) {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name), date('d-m-Y', strtotime($data->date))
                            ));
                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                            //--- -------------------- ---
                            $row_number++;
                            $count_line++;
                        }
                    } else {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name), date('d-m-Y', strtotime($data->date))
                            ));
                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                            //--- -------------------- ---
                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---

                } else {
                    $results = null;
                }

                //--- ------------- ---

            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }


    //Sorawit
    //Created : 8-7-59
    //Modified : -
    # Search By ID for export excel
    public static function exportSearchByID($source, $related_id)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set source
        if ($source == 1) $source_name = 'Specimen';
        else $source_name = 'Publication';

        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_ID' . '_' . $source_name . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($source, $related_id, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($source, $related_id, $date_export) {

                //--- Set Parameter ---
                $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                // set $source
                if ($source == 1) $source_name = 'Specimen';
                else $source_name = 'Publication';

                // check condition
                if ($source == 1) { // 1 is specimens
                    $related_name = 'record.related_catalog_item';
                } else {  // 2 is publication
                    $related_name = 'record.related_reference_item';
                }

                // query db
                $db = new Record;
                $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
                $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->where($related_name, 'like', '%' . $related_id . '%');
                if ($related_id != null) {
                    $results = $db->select([
                        'c.current_scientific_name',
                        'record.id',
                        'record.related_catalog_item',
                        'record.related_reference_item'
                    ])->get();

                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:C2');
                    $sheet->mergeCells('A3:C3');
                    $sheet->mergeCells('A4:C4');
                    $sheet->mergeCells('A5:C5');
                    $sheet->mergeCells('A6:C6');
                    $sheet->mergeCells('A7:C7');
                    $sheet->mergeCells('A8:C8');
                    $sheet->mergeCells('A9:C9');
                    $sheet->mergeCells('A10:C10');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(11, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(11, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:C2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:C6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A11:C11', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:C2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:C6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A11:C11', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A11:C11', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: Search By ID'));
                    $sheet->row(8, array('Source: ' . $source_name));
                    $sheet->row(9, array('Search ID: ' . $related_id));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $sheet->row(11, array(
                        'No.', 'IDCatalog / IDRef', 'Scientific Name'
                    ));
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 12;   // start line
                    $count_line = 1;   // count line for No.
                    if ($source == 1) {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name)
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':C' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    } else {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name)
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':C' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---
                } else {
                    $results = null;
                }
                //--- ------------- ---

            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //Sorawit
    //Created : 8-7-59
    //Modified : -
    # Search By Name for export excel
    public static function exportSearchByName($source, $name_type, $name_people)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set source
        if ($source == 1) $source_name = 'Specimen';
        else $source_name = 'Publication';

        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_Name' . '_' . $source_name . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($source, $name_type, $name_people, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($source, $name_type, $name_people, $date_export) {

                //--- Set Parameter ---
                $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                // set $source
                if ($source == 1) $source_name = 'Specimen';
                else $source_name = 'Publication';

                // check condition
                if ($name_type == 1) { // 1 is Collector
                    $name_type_format = 'record.collector';
                    $name_type_column = 'Collector';    //make header
                } else { // 2 is Identifier
                    $name_type_format = 'record.identifier';
                    $name_type_column = 'Identifier';    //make header
                }

                // query db
                $db = new Record;
                $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
                if ($name_people != null && $name_people != ' ') {
                    if ($name_type == 1) {
                        $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->where($name_type_format, 'like', '%' . $name_people . '%')->orderBy('collector', 'asc');
                        $results = $db->select([
                            'c.current_scientific_name',
                            'record.collector as name',
                            'record.id',
                            'record.related_catalog_item',
                            'record.related_reference_item'
                        ])->get();
                    } else {
                        $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->where($name_type_format, 'like', '%' . $name_people . '%')->orderBy('identifier', 'asc');
                        $results = $db->select([
                            'c.current_scientific_name',
                            'record.identifier as name',
                            'record.id',
                            'record.related_catalog_item',
                            'record.related_reference_item'
                        ])->get();
                    }

                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:D2');
                    $sheet->mergeCells('A3:D3');
                    $sheet->mergeCells('A4:D4');
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('A6:D6');
                    $sheet->mergeCells('A7:D7');
                    $sheet->mergeCells('A8:D8');
                    $sheet->mergeCells('A9:D9');
                    $sheet->mergeCells('A10:D10');
                    $sheet->mergeCells('A11:D11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(12, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:D2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:D6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:D12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:D2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:D6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A12:D12', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A12:D12', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: Search By Name'));
                    $sheet->row(8, array('Source: ' . $source_name));
                    $sheet->row(9, array('Name Type: ' . $name_type_column));
                    $sheet->row(10, array('Search Name: ' . $name_people));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $sheet->row(12, array(
                        'No.', 'IDCatalog / IDRef', 'Scientific Name', 'Name'
                    ));
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 13;   // start line
                    $count_line = 1;   // count line for No.
                    if ($source == 1) {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name), $data->name
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    } else {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name), $data->name
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---
                } else {
                    $results = null;
                }
                //--- ------------- ---

            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //Chaloemphon
    //Created : 11-6-61
    //Modified : -
    # Search By Name Record for export excel
    public static function exportSearchByNameRecord(Request $input)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");


        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_Name_Record' . '_' . $input->name_record_type . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($input, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($input, $date_export) {

                //--- Set Parameter ---
                if (Auth::check()) {
                    $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';
                } else {
                    $user_name = "Unknown";
                }

                $name_type_column = ucfirst($input->name_type);
                $name_record_type_column = ucfirst($input->name_record_type);
                $search = "";
                $search_record = "";


                $db = new Record;
                $db = $db->leftjoin('classification', 'record.classification_id', 'classification.id');
                $db = $db->leftjoin('picture as pic', 'record.unique_record', '=', 'pic.unique_record');

                // get DB
                if ($input->name_record_type == 'local_name') {
                    if (!empty($input->local_name)) {
                        $db = $db->where('record.local_name', 'like', '%' . $input->local_name . '%');
                        $search_record = $input->local_name;
                    }
                } else if ($input->name_record_type == 'vernacular_name') {
                    if (!empty($input->vernacular_name)) {
                        $db = $db->where('record.vernacular_name', 'like', '%' . $input->vernacular_name . '%');
                        $search_record = $input->vernacular_name;
                    }
                } else if ($input->name_record_type == 'common_name') {
                    if (!empty($input->common_name)) {
                        $db = $db->where('classification.common_name', 'like', '%' . $input->common_name . '%');
                        $search_record = $input->common_name;
                    }
                }

                if ($input->name_type == 'collector') {
                    if (!empty($input->collector)) {
                        $db = $db->where('record.collector', 'like', '%' . $input->collector . '%');
                        $search = $input->collector;
                    }
                } else if ($input->name_type == 'identifier') {
                    if (!empty($input->identifier)) {
                        $db = $db->where('record.identifier', 'like', '%' . $input->identifier . '%');
                        $search = $input->identifier;
                    }
                }

                $results =  $db->select([
                    'record.id as record_id',
                    'record.related_catalog_item',
                    'record.related_reference_item',
                    'classification.current_scientific_name_format',
                    'classification.current_scientific_name',
                    'record.local_name',
                    'record.vernacular_name',
                    'classification.common_name',
                    'pic.unique_record',
                    'pic.path_pic'
                ])->get();

                //--- Set Layout and Style ---
                $sheet->mergeCells('A2:D2');
                $sheet->mergeCells('A3:D3');
                $sheet->mergeCells('A4:D4');
                $sheet->mergeCells('A5:D5');
                $sheet->mergeCells('A6:D6');
                $sheet->mergeCells('A7:D7');
                $sheet->mergeCells('A8:D8');
                $sheet->mergeCells('A9:D9');
                $sheet->mergeCells('A10:D10');
                $sheet->mergeCells('A11:D11');

                $sheet->setHeight(2, 30);
                $sheet->setHeight(6, 30);
                $sheet->setHeight(12, 30);

                $sheet->row(2, function ($row) {
                    $row->setBackground('#FE9529');
                });
                $sheet->row(6, function ($row) {
                    $row->setBackground('#FE9529');
                });
                $sheet->row(12, function ($row) {
                    $row->setBackground('#FE9529');
                });

                $sheet->cell('A2:D2', function ($cells) {
                    $cells->setFontSize(20);
                });
                $sheet->cell('A6:D6', function ($cells) {
                    $cells->setFontSize(20);
                });
                $sheet->cell('A12:D12', function ($cells) {
                    $cells->setFontSize(16);
                });

                $sheet->cells('A2:D2', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A6:D6', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A12:D12', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('middle');
                });

                $sheet->setBorder('A12:D12', 'thin');
                //--- -------------------- ---

                //--- Header Part ---
                $sheet->row(2, array('Export Information'));
                $sheet->row(3, array('Export By: ' . $user_name));
                $sheet->row(4, array('Date Export: ' . $date_export));
                $sheet->row(6, array('Data Information'));
                $sheet->row(7, array('Search Type: Search By Name'));
                $sheet->row(9, array('Name Record Type: ' . $name_record_type_column));
                $sheet->row(10, array('Search Name Record: ' . $search_record));
                $sheet->row(11, array('Name Type: ' . $name_type_column));
                $sheet->row(12, array('Search Name: ' . $search));
                //--- ----------- ---

                //--- Header Table Part ---
                $sheet->row(14, array(
                    'No.', 'IDCatalog / IDRef', 'Scientific Name', 'Local Name', 'Vernacular Name', 'Common Name'
                ));
                //--- ----------------- ---

                //--- Content Part ---
                // display data
                $row_number = 15;   // start line
                $count_line = 1;   // count line for No.
                foreach ($results as $data) {
                    if ($data->source == 1) {
                        $sheet->row($row_number, array(
                            $count_line,
                            $data->related_catalog_item,
                            html_entity_decode($data->current_scientific_name),
                            $data->local_name,
                            $data->vernacular_name,
                            $data->common_name
                        ));
                    } else {
                        $sheet->row($row_number, array(
                            $count_line,
                            $data->related_reference_item,
                            html_entity_decode($data->current_scientific_name),
                            $data->local_name,
                            $data->vernacular_name,
                            $data->common_name
                        ));
                    }

                    //--- Set Layout and Style ---
                    $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                    //--- -------------------- ---

                    $row_number++;
                    $count_line++;
                }
            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //Sorawit
    //Created : 11-7-59
    //Modified : -
    # Search By Locality for export excel
    public static function exportSearchByLocality($source, $locality_type, $locality_value)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set source
        if ($source == 1) $source_name = 'Specimen';
        else $source_name = 'Publication';

        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_Locality' . '_' . $source_name . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($source, $locality_type, $locality_value, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($source, $locality_type, $locality_value, $date_export) {

                //--- Set Parameter ---
                $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                // set $source
                if ($source == 1) $source_name = 'Specimen';
                else $source_name = 'Publication';

                // query db
                $db = new Record;
                $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
                $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1)->orderBy('record.id', 'asc');

                // check condition
                if ($locality_type == 1) {    // ocean_sea_lake
                    $db = $db->where('record.ocean_sea_lake', $locality_value);
                    $wording = Wording::getWording($locality_value);
                    $content_header = 'Ocean/Sea/Lake';
                    $content_result = $wording->name_en . '/' . $wording->name_th;
                } elseif ($locality_type == 2) {  // country
                    $db = $db->where('record.country', $locality_value);
                    $wording = Country::getCountryWording($locality_value);
                    $content_header = 'Country';
                    $content_result = $wording->country_en . '/' . $wording->country_th;
                } elseif ($locality_type == 3) {  // province
                    $db = $db->where('record.province', $locality_value);
                    $wording = Province::getProvinceWording($locality_value);
                    $content_header = 'Province';
                    $content_result = $wording->province_en . '/' . $wording->province_th;
                } elseif ($locality_type == 4) {  // district
                    $db = $db->where('record.district', $locality_value);
                    $wording = District::getDistrictWording($locality_value);
                    $content_header = 'District';
                    $content_result = $wording->district_en . '/' . $wording->district_th;
                } elseif ($locality_type == 5) {  // county
                    $db = $db->where('record.county', $locality_value);
                    $wording = County::getCountyWording($locality_value);
                    $content_header = 'County';
                    $content_result = $wording->county_en . '/' . $wording->county_th;
                } else {    // locality
                    $db = $db->where('record.locality', 'like', '%' . $locality_value . '%');
                    $content_header = 'Locality';
                    $content_result = $locality_value;
                }

                if (!empty($locality_value) && $locality_value != ' ') {
                    $results = $db->select([
                        'c.current_scientific_name',
                        'record.id',
                        'record.related_catalog_item',
                        'record.related_reference_item',
                        'record.locality'
                    ])->get();

                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:D2');
                    $sheet->mergeCells('A3:D3');
                    $sheet->mergeCells('A4:D4');
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('A6:D6');
                    $sheet->mergeCells('A7:D7');
                    $sheet->mergeCells('A8:D8');
                    $sheet->mergeCells('A9:D9');
                    $sheet->mergeCells('A10:D10');
                    $sheet->mergeCells('A11:D11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(12, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:D2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:D6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:D12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:D2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:D6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A12:D12', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A12:D12', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: Search By Locality'));
                    $sheet->row(8, array('Source: ' . $source_name));
                    $sheet->row(9, array('Data Type: ' . $content_header));
                    $sheet->row(10, array('Search By: ' . $content_result));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $sheet->row(12, array(
                        'No.', 'IDCatalog / IDRef', 'Scientific Name', 'Information'
                    ));
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 13;   // start line
                    $count_line = 1;   // count line for No.
                    if ($source == 1) {
                        if ($locality_type > 0 && $locality_type < 6) {
                            foreach ($results as $data) {
                                $sheet->row($row_number, array(
                                    $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name), $content_result
                                ));

                                //--- Set Layout and Style ---
                                $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                                //--- -------------------- ---

                                $row_number++;
                                $count_line++;
                            }
                        } else {
                            foreach ($results as $data) {
                                $sheet->row($row_number, array(
                                    $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name), $data->locality
                                ));

                                //--- Set Layout and Style ---
                                $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                                //--- -------------------- ---

                                $row_number++;
                                $count_line++;
                            }
                        }
                    } else {
                        if ($locality_type > 0 && $locality_type < 6) {
                            foreach ($results as $data) {
                                $sheet->row($row_number, array(
                                    $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name), $content_result
                                ));

                                //--- Set Layout and Style ---
                                $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                                //--- -------------------- ---

                                $row_number++;
                                $count_line++;
                            }
                        } else {
                            foreach ($results as $data) {
                                $sheet->row($row_number, array(
                                    $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name), $data->locality
                                ));

                                //--- Set Layout and Style ---
                                $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                                //--- -------------------- ---

                                $row_number++;
                                $count_line++;
                            }
                        }
                    }
                    //--- ------------ ---
                } else {
                    $results = null;
                }
                //--- ------------- ---

            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //Sorawit
    //Created : 11-7-59
    //Modified : -
    # Search By Taxonomy for export excel
    public static function exportSearchByTaxanomy($source, $header_taxonomy_id, $taxonomy_id)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set source
        if ($source == 1) $source_name = 'Specimen';
        else $source_name = 'Publication';

        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_Taxonomy' . '_' . $source_name . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($source, $header_taxonomy_id, $taxonomy_id, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($source, $header_taxonomy_id, $taxonomy_id, $date_export) {

                //--- Set Parameter ---
                $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                // set $source
                if ($source == 1) $source_name = 'Specimen';
                else $source_name = 'Publication';

                // query db
                // get header taxonomy
                $header_taxonomy = Header_Taxonomy::getHeaderTaxonomy($header_taxonomy_id);
                // convert small word
                $header_taxonomy = strtolower($header_taxonomy);
                // change order to order_o for column search
                if ($header_taxonomy == 'order') $header_taxonomy = 'order_o';

                // query db
                $db = new Classification;
                $db = $db->leftjoin('record as r', 'classification.id', '=', 'r.classification_id');
                $db = $db->where('r.language_id', 1)->where('r.status', 2)->where('r.approve_status', 1)->where('r.source', $source)->orderBy('r.id', 'asc');
                if ($taxonomy_id != 0) {
                    $db = $db->where('classification.' . $header_taxonomy, $taxonomy_id);
                    $results = $db->select(
                        'classification.current_scientific_name',
                        'r.id',
                        'r.related_catalog_item',
                        'r.related_reference_item'
                    )->get();
                    $taxonomy = Taxonomy::getTaxonomyWording($taxonomy_id)->name;

                    // get header taxonomy for display
                    $header_taxonomy = Header_Taxonomy::getHeaderTaxonomy($header_taxonomy_id);

                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:D2');
                    $sheet->mergeCells('A3:D3');
                    $sheet->mergeCells('A4:D4');
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('A6:D6');
                    $sheet->mergeCells('A7:D7');
                    $sheet->mergeCells('A8:D8');
                    $sheet->mergeCells('A9:D9');
                    $sheet->mergeCells('A10:D10');
                    $sheet->mergeCells('A11:D11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(12, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:D2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:D6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:D12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:D2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:D6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A12:D12', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A12:D12', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: Search By Taxonomy'));
                    $sheet->row(8, array('Source: ' . $source_name));
                    $sheet->row(9, array('Taxonomy Type: ' . $header_taxonomy));
                    $sheet->row(10, array('Taxonomy Name: ' . $taxonomy));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $sheet->row(12, array(
                        'No.', 'IDCatalog / IDRef', 'Scientific Name', 'Taxonomy'
                    ));
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 13;   // start line
                    $count_line = 1;   // count line for No.
                    if ($source == 1) {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name), $header_taxonomy . '-' . $taxonomy
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    } else {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name), $header_taxonomy . '-' . $taxonomy
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':D' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---
                } else {
                    $results = null;
                    $taxonomy = '-';
                }
                //--- ------------- ---

            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //Sorawit
    //Created : 25-7-59
    //Modified : -
    # Search By Keyword for export excel
    public static function exportSearchByKeyword($source, $keyword1, $keyword2, $keyword3)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        // set source
        if ($source == 1) $source_name = 'Specimen';
        else $source_name = 'Publication';

        //---- make file excel ----
        $name_file = 'Excel_Record_Search_By_Keyword' . '_' . $source_name . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($source, $keyword1, $keyword2, $keyword3, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($source, $keyword1, $keyword2, $keyword3, $date_export) {

                //--- Set Parameter ---
                $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                // set $source
                if ($source == 1) $source_name = 'Specimen';
                else $source_name = 'Publication';

                // query db
                if ($keyword1 != null || $keyword2 != null || $keyword3 != null) {
                    $db = new Record;
                    $db = $db->leftjoin('classification as c', 'record.classification_id', '=', 'c.id');
                    $db = $db->where('record.status', 2)->where('record.approve_status', 1)->where('record.source', $source)->orderBy('record.id', 'asc')->groupBy('unique_record');

                    if ($keyword1 !== "") {
                        $db = $db->where('record.note_collector', 'LIKE', "%$keyword1%");
                        $db = $db->orWhere('record.description', 'LIKE', "%$keyword1%");
                    }

                    if ($keyword2 !== "") {
                        $db = $db->where('record.note_collector', 'LIKE', "%$keyword2%");
                        $db = $db->orWhere('record.description', 'LIKE', "%$keyword2%");
                    }

                    if ($keyword3 !== "") {
                        $db = $db->where('record.note_collector', 'LIKE', "%$keyword3%");
                        $db = $db->orWhere('record.description', 'LIKE', "%$keyword3%");
                    }

                    $results = $db->select(
                        'c.current_scientific_name_format',
                        'c.current_scientific_name',
                        'record.id',
                        'record.related_catalog_item',
                        'record.related_reference_item'
                    )->get();

                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:C2');
                    $sheet->mergeCells('A3:C3');
                    $sheet->mergeCells('A4:C4');
                    $sheet->mergeCells('A5:C5');
                    $sheet->mergeCells('A6:C6');
                    $sheet->mergeCells('A7:C7');
                    $sheet->mergeCells('A8:C8');
                    $sheet->mergeCells('A9:C9');
                    $sheet->mergeCells('A10:C10');
                    $sheet->mergeCells('A11:C11');
                    $sheet->mergeCells('A12:C12');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(13, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(13, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:C2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:C6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:C12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:C2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:C6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A13:C13', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A13:C13', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: Search By Keyword'));
                    $sheet->row(8, array('Source: ' . $source_name));
                    $sheet->row(9, array('Keyword1: ' . $keyword1));
                    $sheet->row(10, array('Keyword2: ' . $keyword2));
                    $sheet->row(11, array('Keyword3: ' . $keyword3));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $sheet->row(13, array(
                        'No.', 'IDCatalog / IDRef', 'Scientific Name'
                    ));
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 14;   // start line
                    $count_line = 1;   // count line for No.
                    if ($source == 1) {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_catalog_item, html_entity_decode($data->current_scientific_name)
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':C' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    } else {
                        foreach ($results as $data) {
                            $sheet->row($row_number, array(
                                $count_line, $data->related_reference_item, html_entity_decode($data->current_scientific_name)
                            ));

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':C' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---

                } else {
                    $results = null;
                }
                //--- ------------- ---

            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //Sorawit
    //Created : 13-7-59
    //Modified : 22-8-59(Sorawit)
    # Search Type A (and Distribution Search in type B) for export excel
    public static function exportSearchTypeA(Request $input)
    {
        $way = $input->way;

        // get session and decode json
        if (Session::has('search_result_a')) {
            $session_results = Session::get('search_result_a');
            $results = json_decode($session_results);
        } else {
            $results = null;
        }

        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        //---- make file excel ----
        $name_file = 'Excel_Record_' . $way . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($results, $way, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($results, $way, $date_export) {

                //--- Set Parameter ---
                if (Auth::check()) {
                    $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                    //--- Get Permission Group ---
                    $role_id = Auth::user()->role_id;
                    if ($role_id == 2) {  // administrator
                        $group_permission_a = 2;
                        $group_permission_b = 2;
                    } elseif ($role_id == 6) {   // pgcp
                        $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_pgcp;
                        $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_pgcp;
                    } elseif ($role_id == 3) {   // manager
                        $group_permission_a   = Group_Permission::getGroup_PermissionById(1)[0]->status_manager;
                        $group_permission_b   = Group_Permission::getGroup_PermissionById(2)[0]->status_manager;
                    } elseif ($role_id == 4) {   // board
                        $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_board;
                        $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_board;
                    } else {    // user
                        $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_user;
                        $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_user;
                    }
                    //--- --- ---------- ----- ---
                } else {
                    $user_name = "Unknown";
                    $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_user;
                    $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_user;
                }
                //--- ------------- ---

                # For Diversity Search
                if ($way == 'Diversity_Search') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:K2');
                    $sheet->mergeCells('A3:K3');
                    $sheet->mergeCells('A4:K4');
                    $sheet->mergeCells('A5:K5');
                    $sheet->mergeCells('A6:K6');
                    $sheet->mergeCells('A7:K7');
                    $sheet->mergeCells('A8:K8');
                    $sheet->mergeCells('A9:K9');
                    $sheet->mergeCells('A10:K10');
                    $sheet->mergeCells('A11:K11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(12, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:K2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:K6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:K12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:K2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:K6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A12:K12', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A12:K12', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    if ($group_permission_a == 2 && $group_permission_b == 2) {
                        $arr_header = ['No.', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Ocean/Sea/Lake', 'Country', 'Province', 'Expendition'];
                    } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                        $arr_header = ['No.', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Expendition'];
                    } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                        $arr_header = ['No.', 'Current Name', 'Ocean/Sea/Lake', 'Country', 'Province', 'Expendition'];
                    } else {
                        $arr_header = ['No.', 'Current Name', 'Expendition'];
                    }
                    $sheet->row(12, $arr_header);
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 13;   // start line
                    $count_line = 1;   // count line for No.
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {
                            // check expedition_en
                            if ($data->expedition_en == null && $data->expedition_th == null) {
                                $expedition = '';
                            } else {
                                $expedition = $data->expedition_en . '/' . $data->expedition_th;
                            }

                            // make array content
                            $arr_content = array();
                            if ($group_permission_a == 2 && $group_permission_b == 2) {
                                $arr_content = [
                                    $count_line, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->ocean_sea_lake_en . '/' . $data->ocean_sea_lake_th, $data->country_en . '/' . $data->country_th, $data->province_en . '/' . $data->province_th,
                                    $expedition
                                ];
                            } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                                $arr_content = [
                                    $count_line, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $expedition
                                ];
                            } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                                $arr_content = [
                                    $count_line, html_entity_decode($data->current_scientific_name), $data->ocean_sea_lake_en . '/' . $data->ocean_sea_lake_th, $data->country_en . '/' . $data->country_th, $data->province_en . '/' . $data->province_th, $expedition
                                ];
                            } else {
                                $arr_content = [
                                    $count_line, html_entity_decode($data->current_scientific_name), $expedition
                                ];
                            }

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':K' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---
                }

                # Recent Record
                elseif ($way == 'Recent_Record') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:M2');
                    $sheet->mergeCells('A3:M3');
                    $sheet->mergeCells('A4:M4');
                    $sheet->mergeCells('A5:M5');
                    $sheet->mergeCells('A6:M6');
                    $sheet->mergeCells('A7:M7');
                    $sheet->mergeCells('A8:M8');
                    $sheet->mergeCells('A9:M9');
                    $sheet->mergeCells('A10:M10');
                    $sheet->mergeCells('A11:M11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(12, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:M2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:M6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:M12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:M2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:M6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A12:M12', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A12:M12', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    if ($group_permission_a == 2 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Province', 'Picture'];
                    } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Picture'];
                    } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Province', 'Picture'];
                    } else {
                        $arr_header = ['ID', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Picture'];
                    }
                    $sheet->row(12, $arr_header);
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 13;   // start line
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {

                            // make array content and check permission
                            $arr_content = array();
                            if ($group_permission_a == 2 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                    $data->province_en . '/' . $data->province_th
                                ];
                            } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                ];
                            } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                    $data->province_en . '/' . $data->province_th
                                ];
                            } else {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier
                                ];
                            }

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':M' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                        }
                    }
                    //--- ------------ ---
                }

                # Distribution Search
                elseif ($way == 'Distribution_Search') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:M2');
                    $sheet->mergeCells('A3:M3');
                    $sheet->mergeCells('A4:M4');
                    $sheet->mergeCells('A5:M5');
                    $sheet->mergeCells('A6:M6');
                    $sheet->mergeCells('A7:M7');
                    $sheet->mergeCells('A8:M8');
                    $sheet->mergeCells('A9:M9');
                    $sheet->mergeCells('A10:M10');
                    $sheet->mergeCells('A11:M11');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(12, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(12, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:M2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:M6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A12:M12', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:M2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:M6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A12:M12', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A12:M12', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    if ($group_permission_a == 2 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Previous Name', 'Type', 'Habitat', 'Current Indentifier', 'Locality'];
                    } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Previous Name', 'Type', 'Habitat', 'Current Indentifier'];
                    } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Current Name', 'Previous Name', 'Type', 'Habitat', 'Current Indentifier', 'Locality'];
                    } else {
                        $arr_header = ['ID', 'Current Name', 'Previous Name', 'Type', 'Habitat', 'Current Indentifier'];
                    }
                    $sheet->row(12, $arr_header);
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 13;   // start line
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {

                            // make array content and check permission
                            $arr_content = array();
                            if ($group_permission_a == 2 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->habitat_en, $data->identifier,
                                    $data->locality
                                ];
                            } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->habitat_en, $data->identifier,
                                ];
                            } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->habitat_en, $data->identifier,
                                    $data->locality
                                ];
                            } else {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->habitat_en, $data->identifier
                                ];
                            }

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':M' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                        }
                    }
                    //--- ------------ ---
                }
            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }


    //supakorn
    //Created : 15-7-63
    # Distribution Search in type A 
    # also use in Diversity + Recent record
    public static function exportTypeADistributionSearch(Request $input)
    {
        $way = $input->way;
        $results = (object) SearchTypeAController::dataDistribution($input);

        //supakorn 
        //diversity must show only current name in change request#4 No11
        //export data require array
        if ($way == 'Diversity_Search') {
            $results->result_searchs = $results->result_searchs->groupBy('classification.current_scientific_name')->get();
        } else {
            $results->result_searchs = $results->result_searchs->get();
        }
        ExportRecordController::printExcelRecord($results, $way);
    }

    //supakorn
    //Created : 15-7-63
    # Distribution Search in type B
    # also use in Diversity + Recent record
    public static function exportTypeBDistributionSearch(Request $input)
    {
        $way = $input->way;
        $results = (object) SearchTypeBController::dataDistribution($input);

        //supakorn 
        //diversity must show only current name in change request#4 No11
        //export data require array
        if ($way == 'Diversity_Search') {
            $results->result_searchs = $results->result_searchs->groupBy('classification.current_scientific_name')->get();
        } else {
            $results->result_searchs = $results->result_searchs->get();
        }
        ExportRecordController::printExcelRecord($results, $way);
    }


    //supakorn
    //Created : 15-7-63
    # Distribution Search in type C 
    # also use in Diversity + Recent record
    public static function exportDistributionSearch(Request $input)
    {
        $way = $input->way;
        $results = (object) SearchTypeCController::dataDistribution($input);
        //export data require array

        //supakorn 
        //diversity must show only current name in change request#4 No11
        if ($way == 'Diversity_Search') {
            $results->result_searchs = $results->result_searchs->groupBy('classification.current_scientific_name')->get();
        } else {
            $results->result_searchs = $results->result_searchs->get();
        }

        ExportRecordController::printExcelRecord($results, $way);
    }

    //supakorn
    //Created : 15-7-63
    # printing method copy from exportSearchTypeA because session full problem
    ## use in search Distribution +  Diversity + Recent record
    public static function printExcelRecord($results, $way)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        //---- make file excel ----
        $name_file = 'Excel_Record_' . $way . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($results, $way, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($results, $way, $date_export) {

                $lang = Session::get('language');   // เช็คภาษาสำหรับ distribution

                //--- Set Parameter ---
                if (Auth::check()) {
                    $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';

                    //--- Get Permission Group ---
                    $role_id = Auth::user()->role_id;
                    if ($role_id == 2) {  // administrator
                        $group_permission_a = 2;
                        $group_permission_b = 2;
                    } elseif ($role_id == 6) {   // pgcp
                        $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_pgcp;
                        $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_pgcp;
                    } elseif ($role_id == 3) {   // manager
                        $group_permission_a   = Group_Permission::getGroup_PermissionById(1)[0]->status_manager;
                        $group_permission_b   = Group_Permission::getGroup_PermissionById(2)[0]->status_manager;
                    } elseif ($role_id == 4) {   // board
                        $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_board;
                        $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_board;
                    } else {    // user
                        $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_user;
                        $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_user;
                    }
                    //--- --- ---------- ----- ---
                } else {
                    $user_name = "Unknown";
                    $group_permission_a = Group_Permission::getGroup_PermissionById(1)[0]->status_user;
                    $group_permission_b = Group_Permission::getGroup_PermissionById(2)[0]->status_user;
                }
                //--- ------------- ---

                # For Diversity Search
                if ($way == 'Diversity_Search') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:K2');
                    $sheet->mergeCells('A3:K3');
                    $sheet->mergeCells('A4:K4');
                    $sheet->mergeCells('A5:K5');
                    $sheet->mergeCells('A6:K6');
                    $sheet->mergeCells('A7:K7');
                    $sheet->mergeCells('A8:K8');
                    $sheet->mergeCells('A9:K9');
                    $sheet->mergeCells('A10:K10');
                    $sheet->mergeCells('A11:K11');
                    $sheet->mergeCells('A12:K12');
                    $sheet->mergeCells('A13:K13');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(14, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(14, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:K2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:K6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A14:K14', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:K2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:K6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A14:K14', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A14:K14', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                        $results->marinecentertext = '-';
                        $results->typestatustext = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    $sheet->row(11, array('Marine Center: ' . $results->marinecentertext));
                    $sheet->row(12, array('Type Status: ' . $results->typestatustext));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    if ($group_permission_a == 2 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class', 'Order', 'Suborder', 'Infraorder', 'Super Family', 'Family', 'Current Name'];
                    } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class', 'Order', 'Suborder', 'Infraorder', 'Super Family', 'Family', 'Current Name'];
                    } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Current Name'];
                    } else {
                        $arr_header = ['ID', 'Current Name'];
                    }
                    $sheet->row(14, $arr_header);
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 15;   // start line
                    $count_line = 1;   // count line for No.
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {
                            // check expedition_en
                            if ($data->expedition_en == null && $data->expedition_th == null) {
                                $expedition = '';
                            } else {
                                $expedition = $data->expedition_en . '/' . $data->expedition_th;
                            }

                            // make array content
                            $arr_content = array();
                            if ($group_permission_a == 2 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->superfamily, $data->family,
                                    html_entity_decode($data->current_scientific_name)
                                ];
                            } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->superfamily, $data->family,
                                    html_entity_decode($data->current_scientific_name)
                                ];
                            } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, html_entity_decode($data->current_scientific_name)
                                ];
                            } else {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, html_entity_decode($data->current_scientific_name)
                                ];
                            }

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':K' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---
                }

                # Recent Record
                elseif ($way == 'Recent_Record') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:R2');
                    $sheet->mergeCells('A3:R3');
                    $sheet->mergeCells('A4:R4');
                    $sheet->mergeCells('A5:R5');
                    $sheet->mergeCells('A6:R6');
                    $sheet->mergeCells('A7:R7');
                    $sheet->mergeCells('A8:R8');
                    $sheet->mergeCells('A9:R9');
                    $sheet->mergeCells('A10:R10');
                    $sheet->mergeCells('A11:R11');
                    $sheet->mergeCells('A12:R12');
                    $sheet->mergeCells('A13:R13');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(14, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(14, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:R2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:R6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A14:R14', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:R2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:R6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A14:R14', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A14:R14', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                        $results->marinecentertext = '-';
                        $results->typestatustext = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    $sheet->row(11, array('Marine Center: ' . $results->marinecentertext));
                    $sheet->row(12, array('Type Status: ' . $results->typestatustext));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    if ($group_permission_a == 2 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Previous Indentifier', 'Ocean/Sea/Lake', 'Country', 'Province', 'Expendition', 'Picture'];
                    } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                        $arr_header = ['ID', 'Phylum', 'Subphylum', 'Class (Clade)', 'Order (Clade)', 'Suborder (Clade)', 'Infraorder (Clade)', 'Family (Clade)', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Previous Indentifier', 'Ocean/Sea/Lake', 'Country', 'Province', 'Expendition', 'Picture'];
                    } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                        $arr_header = ['ID', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Previous Indentifier', 'Ocean/Sea/Lake', 'Country', 'Province', 'Expendition', 'Picture'];
                    } else {
                        $arr_header = ['ID', 'Current Name', 'Previous Name', 'Type', 'Current Indentifier', 'Previous Indentifier', 'Ocean/Sea/Lake', 'Country', 'Province', 'Expendition', 'Picture'];
                    }
                    $sheet->row(14, $arr_header);
                    //--- ----------------- ---
                    
                    //--- Content Part ---
                    // display data
                    $row_number = 15;   // start line
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {

                            // make array content and check permission
                            $arr_content = array();
                            if ($group_permission_a == 2 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                    $data->previous_identifier,
                                    $data->ocean_sea_lake,
                                    $data->country_en . '/' . $data->country_th,
                                    $data->province_en . '/' . $data->province_th,
                                    $data->expedition,
                                    $data->path_pic
                                ];
                            } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item, $data->phylum, $data->subphylum, $data->class,
                                    $data->order_o, $data->suborder, $data->infraorder, $data->family,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                    $data->previous_identifier,
                                    $data->ocean_sea_lake,
                                    $data->country_en . '/' . $data->country_th,
                                    $data->province_en . '/' . $data->province_th,
                                    $data->expedition,
                                    $data->path_pic,
                                    $data->path_pic
                                ];
                            } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                    $data->previous_identifier,
                                    $data->ocean_sea_lake,
                                    $data->country_en . '/' . $data->country_th,
                                    $data->province_en . '/' . $data->province_th,
                                    $data->expedition,
                                    $data->path_pic
                                ];
                            } else {
                                $arr_content = [
                                    $data->related_catalog_item . '' . $data->related_reference_item,
                                    html_entity_decode($data->current_scientific_name), $data->previous_scientific_name, $data->type_status_en, $data->identifier,
                                    $data->previous_identifier,
                                    $data->ocean_sea_lake,
                                    $data->country_en . '/' . $data->country_th,
                                    $data->province_en . '/' . $data->province_th,
                                    $data->expedition,
                                    $data->path_pic
                                ];
                            }

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':R' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                        }
                    }
                    //--- ------------ ---
                }

                # Distribution Search
                elseif ($way == 'Distribution_Search') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:G2');
                    $sheet->mergeCells('A3:G3');
                    $sheet->mergeCells('A4:G4');
                    $sheet->mergeCells('A5:G5');
                    $sheet->mergeCells('A6:G6');
                    $sheet->mergeCells('A7:G7');
                    $sheet->mergeCells('A8:G8');
                    $sheet->mergeCells('A9:G9');
                    $sheet->mergeCells('A10:G10');
                    $sheet->mergeCells('A11:G11');
                    $sheet->mergeCells('A12:G12');
                    $sheet->mergeCells('A13:G13');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(14, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(14, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:G2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:G6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A14:G14', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:G2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:G6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A14:G14', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A14:G14', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                        $results->marinecentertext = '-';
                        $results->typestatustext = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    $sheet->row(11, array('Marine Center: ' . $results->marinecentertext));
                    $sheet->row(12, array('Type Status: ' . $results->typestatustext));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    if ($group_permission_a == 2 && $group_permission_b == 2) {
                        $arr_header = ['IDCatalog/IDRef', 'Family', 'Genus', 'Current Name', 'Ocean/Sea/Lake', 'Country', 'Province'];
                    } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                        $arr_header = ['IDCatalog/IDRef', 'Family', 'Genus', 'Current Name', 'Ocean/Sea/Lake', 'Country', 'Province'];
                    } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                        $arr_header = ['IDCatalog/IDRef', 'Current Name', 'Ocean/Sea/Lake', 'Country', 'Province'];
                    } else {
                        $arr_header = ['IDCatalog/IDRef', 'Current Name', 'Ocean/Sea/Lake', 'Country', 'Province'];
                    }

                    $sheet->row(14, $arr_header);
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 15;   // start line
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {

                            // make array content and check permission
                            $arr_content = array();
                            if ($group_permission_a == 2 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, $data->family, $data->genus, html_entity_decode($data->current_scientific_name), ($lang==2 ? $data->ocean_sea_lake_th : $data->ocean_sea_lake_en), ($lang==2 ? $data->country_th : $data->country_en), ($lang==2 ? $data->province_th  : $data->province_en)
                                ];
                            } elseif ($group_permission_a == 2 && $group_permission_b == 1) {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, $data->family, $data->genus, html_entity_decode($data->current_scientific_name), ($lang==2 ? $data->ocean_sea_lake_th : $data->ocean_sea_lake_en), ($lang==2 ? $data->country_th : $data->country_en), ($lang==2 ? $data->province_th  : $data->province_en)
                                ];
                            } elseif ($group_permission_a == 1 && $group_permission_b == 2) {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, html_entity_decode($data->current_scientific_name), ($lang==2 ? $data->ocean_sea_lake_th : $data->ocean_sea_lake_en), ($lang==2 ? $data->country_th : $data->country_en), ($lang==2 ? $data->province_th  : $data->province_en)
                                ];
                            } else {
                                $arr_content = [
                                    $data->related_catalog_item . $data->related_reference_item, html_entity_decode($data->current_scientific_name), ($lang==2 ? $data->ocean_sea_lake_th : $data->ocean_sea_lake_en), ($lang==2 ? $data->country_th : $data->country_en), ($lang==2 ? $data->province_th  : $data->province_en)
                                ];
                            }

                            dd($arr_content);

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':G' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                        }
                    }
                    //--- ------------ ---
                }
            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    //sorawit
    //Created : 31-3-65
    # Utilization Search in type C 
    public static function exportUtilizationSearch(Request $input)
    {
        $way = $input->way; // เผื่อไว้กรณีมีผลการค้นหาที่ รายการสามารถซ้ำได้ และจะต้องใช้เป็นส่วนหนึ่งของชื่อไฟล์ด้วย
        $results = (object) SearchTypeCController::dataUtilization($input);
        $results->result_searchs = $results->result_searchs->get();

        ExportRecordController::printUtilizationExcelRecord($results, $way);
    }

    //sorawit
    //Created : 31-3-65
    # use in search Utilization Search
    public static function printUtilizationExcelRecord($results, $way)
    {
        // created export date
        $date = date_create();
        $date_export = date_format($date, "d-m-Y H:i:s");
        $date_export_file_name = date_format($date, "Y-m-d_H-i-s");

        //---- make file excel ----
        $name_file = 'Excel_Record_' . $way . '_' . $date_export_file_name;
        Excel::create($name_file, function ($excel) use ($results, $way, $date_export) {
            $excel->sheet('Record Data', function ($sheet) use ($results, $way, $date_export) {

                //--- Set Parameter ---
                if (Auth::check()) {
                    $user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name . ' (' . Auth::user()->telephone . ') (' . Auth::user()->email . ')';
                } else {
                    $user_name = "Unknown";
                }
                //--- ------------- ---

                # For Utilization Search
                if ($way == 'Utilization_Search') {
                    //--- Set Layout and Style ---
                    $sheet->mergeCells('A2:P2');
                    $sheet->mergeCells('A3:P3');
                    $sheet->mergeCells('A4:P4');
                    $sheet->mergeCells('A5:P5');
                    $sheet->mergeCells('A6:P6');
                    $sheet->mergeCells('A7:P7');
                    $sheet->mergeCells('A8:P8');
                    $sheet->mergeCells('A9:P9');
                    $sheet->mergeCells('A10:P10');
                    $sheet->mergeCells('A11:P11');
                    $sheet->mergeCells('A12:P12');

                    $sheet->setHeight(2, 30);
                    $sheet->setHeight(6, 30);
                    $sheet->setHeight(14, 30);

                    $sheet->row(2, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(6, function ($row) {
                        $row->setBackground('#FE9529');
                    });
                    $sheet->row(14, function ($row) {
                        $row->setBackground('#FE9529');
                    });

                    $sheet->cell('A2:P2', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A6:P6', function ($cells) {
                        $cells->setFontSize(20);
                    });
                    $sheet->cell('A14:P14', function ($cells) {
                        $cells->setFontSize(16);
                    });

                    $sheet->cells('A2:P2', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A6:P6', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->cells('A14:P14', function ($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                        $cells->setValignment('middle');
                    });

                    $sheet->setBorder('A14:P14', 'thin');
                    //--- -------------------- ---

                    //--- Header Part ---
                    if ($results == null) {
                        $results->taxa = '-';
                        $$results->locality = '-';
                        $results->expedition = '-';
                        $results->marinecentertext = '-';
                        $results->typestatustext = '-';
                    }
                    $sheet->row(2, array('Export Information'));
                    $sheet->row(3, array('Export By: ' . $user_name));
                    $sheet->row(4, array('Date Export: ' . $date_export));
                    $sheet->row(6, array('Data Information'));
                    $sheet->row(7, array('Search Type: ' . $way));
                    $sheet->row(8, array('Taxonomy: ' . $results->taxa));
                    $sheet->row(9, array('Locality: ' . $results->locality));
                    $sheet->row(10, array('Expedition: ' . $results->expedition));
                    $sheet->row(11, array('Marine Center: ' . $results->marinecentertext));
                    $sheet->row(12, array('Type Status: ' . $results->typestatustext));
                    //--- ----------- ---

                    //--- Header Table Part ---
                    $arr_header = array();
                    $arr_header = ['No.', 'ID', 'Marine Center', 'Current Name', 'Common Name', 'Local Name', 'Utilization', 'Folk Wisdom', 'Recorder', 'Knowledge Remarks', 'Economic Value', 'Living', 'Protection Thai Law', 'Protection Thai RedList', 'Protection IUCN 2019', 'Protection CITES'];
                    $sheet->row(14, $arr_header);
                    //--- ----------------- ---

                    //--- Content Part ---
                    // display data
                    $row_number = 15;   // start line
                    $count_line = 1;   // count line for No.
                    if ($results != null) {
                        foreach ($results->result_searchs as $data) {
                            // make array content
                            $arr_content = array();
                            $arr_content = [
                                $count_line,
                                $data->related_catalog_item . $data->related_reference_item,
                                $data->marinecenter_th,
                                html_entity_decode($data->current_scientific_name),
                                $data->common_name,
                                $data->local_name,
                                $data->utilization,
                                $data->folk_wisdom,
                                $data->recorder,
                                $data->knowledge_remarks,
                                $data->economic_value_th,
                                $data->living_th,
                                $data->protection_thai_law_th,
                                $data->thai_red_list_th,
                                $data->protection_iucn_2019_th,
                                $data->protection_cites_th
                            ];

                            // write in file
                            $sheet->row($row_number, $arr_content);

                            //--- Set Layout and Style ---
                            $sheet->setBorder('A' . $row_number . ':P' . $row_number, 'thin');
                            //--- -------------------- ---

                            $row_number++;
                            $count_line++;
                        }
                    }
                    //--- ------------ ---
                }
            });
        })->store('csv', Config::get('path.export_record_file_path'));

        // save export log : 0 is excel, 1 is pdf, 2 is api
        ExportLog::saveExportLog(0, $name_file);

        // sent name_file for download
        echo $name_file . '.csv';
    }

    // ห้ามลบ

    // //Sorawit
    // //Created : 22-6-59
    // //Modified : -
    // # export result search by excel
    // public function doExportRecord( Request $input ) {
    //     $language = $input->language;
    //     $start_date = date('Y-m-d', strtotime( $input->start_date ) );
    //     $end_date = date('Y-m-d', strtotime( $input->end_date ) );
    //
    //     // set end time
    //     $end_time = date_create('23:59:59');
    //     $end_time = date_format( $end_time, 'H:i:s' );
    //     $end_date = date('Y-m-d H:i:s', strtotime( $end_date.' '.$end_time ));
    //
    //     // created export date
    //     $date = date_create();
    // 	$date_export = date_format( $date, "d-m-Y H:i:s" );
    //     $date_export_file_name = date_format( $date, "Y-m-d_H-i-s" );
    //
    //     // set language
    //     if ( $language == 1 ) $language_name = 'en';
    //     else $language_name = 'th';
    //
    //     // save export log : 0 is excel, 1 is pdf, 2 is api
    //     $end_date_log = date('Y-m-d', strtotime( $end_date ) );
    //     $note = 'PGCP_excel_'.$language_name.'_'.$start_date.'_'.$end_date_log;
    //     ExportLog::saveExportLog( 0, $note );
    //
    //     //---- make file excel ----
    //     Excel::create( 'record'.'_'.$language_name.'_'.$date_export_file_name, function( $excel ) use ( $language, $start_date, $end_date, $date_export ) {
    //         $excel->sheet( 'Record Data', function( $sheet ) use ( $language, $start_date, $end_date, $date_export ) {
    //
    //             //--- Set Parameter ---
    //                 $user_name = Auth::user()->first_name.' '.Auth::user()->last_name.' ('.Auth::user()->telephone.') ('.Auth::user()->email.')';
    //                 $start_date_header = date('d-m-Y', strtotime( $start_date ) );
    //                 $end_date_header = date('d-m-Y', strtotime( $end_date ) );
    //
    //                 // set language
    //                 if( $language == 1 ) $language_name = 'English';
    //                 else $language_name = 'Thai';
    //             //--- ------------- ---
    //
    //             # ----------------
    //             # english language
    //             # ----------------
    //
    //             if ( $language == 1 ) {
    //
    //                 //--- Set Layout and Style ---
    //                     $sheet->mergeCells( 'A2:CR2' );
    // 				    $sheet->mergeCells( 'A3:CR3' );
    //                     $sheet->mergeCells( 'A4:CR4' );
    //                     $sheet->mergeCells( 'A5:CR5' );
    //                     $sheet->mergeCells( 'A6:CR6' );
    //                     $sheet->mergeCells( 'A7:CR7' );
    // 				    $sheet->mergeCells( 'A8:CR8' );
    //                     $sheet->mergeCells( 'A9:CR9' );
    //
    //                     $sheet->setHeight( 2, 30 );
    //                     $sheet->setHeight( 6, 30 );
    //                     $sheet->setHeight( 11, 30 );
    //
    //                     $sheet->row( 2, function( $row ) {
    //                         $row->setBackground( '#FE9529' );
    //                     });
    //                     $sheet->row( 6, function( $row ) {
    //                         $row->setBackground('#FE9529');
    //                     });
    //                     $sheet->row( 11, function( $row ) {
    //                         $row->setBackground( '#FE9529' );
    //                     });
    //
    //                     $sheet->cell( 'A2:CR2', function( $cells ) {
    //                         $cells->setFontSize( 20 );
    //                     });
    //                     $sheet->cell( 'A6:CR6', function( $cells ) {
    //                         $cells->setFontSize( 20 );
    //                     });
    //                     $sheet->cell( 'A11:CR11', function( $cells ) {
    //                         $cells->setFontSize( 16 );
    //                     });
    //
    //                     $sheet->cells( 'A2:CR2', function( $cells ) {
    //                         $cells->setFontWeight( 'bold' );
    //                     });
    //                     $sheet->cells( 'A6:CR6', function( $cells ) {
    //                         $cells->setFontWeight( 'bold' );
    //                     });
    //                     $sheet->cells( 'A11:CR11', function( $cells ) {
    //                         $cells->setFontWeight( 'bold' );
    //                         $cells->setAlignment( 'center' );
    //                         $cells->setValignment( 'middle' );
    //                     });
    //
    //                     $sheet->setBorder( 'A11:CR11', 'thin' );
    //                 //--- -------------------- ---
    //
    //                 //--- Header Part ---
    //                     $sheet->row( 2, array( 'Export Information' ) );
    //                     $sheet->row( 3, array( 'Export By: '.$user_name ) );
    //                     $sheet->row( 4, array( 'Date Export: '.$date_export ) );
    //                     $sheet->row( 6, array( 'Data Information' ) );
    //                     $sheet->row( 7, array( 'Data Start Date: '.$start_date_header ) );
    //                     $sheet->row( 8, array( 'Data End Date: '.$end_date_header ) );
    //                     $sheet->row( 9, array( 'Language: '.$language_name ) );
    //                 //--- ----------- ---
    //
    //                 //--- Header Table Part ---
    //                     $sheet->row(11, array(
    //     					'Created Date', 'Update Date', 'Department: Institution', 'MarineCenter', 'MarineCenterCode',
    //                         'Source', 'Collection', 'CollectionCode', 'CatalogNumber', 'IDCatalog',
    //                         'Reference', 'Reference Code', 'Page', 'NoSpecies', 'NoLocality',
    //                         'IDRef', 'DonatedFrom','DepositedAt', 'CurrentScientificName', 'CurrentScientificNameFormat',
    //                         'ScientificNameAuthor', 'PublishedYear' ,'Domain', 'Kingdom', 'Subkingdom',
    //                         'Infrakingdom', 'Phylum', 'Subphylum', 'Infraphylum', 'Superclass',
    //                         'Class (Clade)', 'Subclass (Clade)', 'Infraclass (Clade)', 'Superorder (Clade)', 'Order (Clade)',
    //                         'Suborder (Clade)','Infraorder (Clade)', 'Superfamily (Clade)', 'Family (Clade)', 'Subfamily (Clade)',
    //                         'Genus', 'Subgenus', 'Species', 'Subspecies', 'IdentificationQualifier',
    //                         'Variety Name', 'PreviousScientificName', 'PreviousScientificNameFormat', 'TypeStatus', 'Diagnosis',
    //                         'Description','IndividualCount', 'Sex', 'Size', 'LifeStage',
    //                         'Ocean/Sea/Lake', 'Country', 'Province', 'District', 'County',
    //                         'Locality', 'VerbatimLatitude', 'Latitude', 'StartLatitude', 'EndLatitude',
    //                         'VerbatimLongitude', 'Longitude', 'StartLongitude', 'EndLongitude', 'Habitat',
    //                         'Gear_Method', 'Depth (Depth_Start)', 'Depth_End', 'Collector', 'CollectedDate',
    //                         'YearCollected', 'MonthCollected', 'DayCollected', 'CurrentIdentifier', 'CurrentIdentifiedDate',
    //                         'YearIdentified', 'MonthIdentified', 'DayIdentified', 'PreviousIdentifier', 'PreviousIdentifiedDate',
    //                         'Notes', 'PreparationType', 'Expedition', 'GeneBankNumber', 'ImageURL1',
    //                         'ImageURL2', 'ImageURL3', 'ImageURL4', 'ImageURL5', 'ImageURL6'
    //     				));
    //                 //--- ----------------- ---
    //
    //                 //--- Content Part ---
    //                     // get data
    //                         $db = new Record;
    //                         $db = $db->where('record.language_id', 1)->where('record.status', 2)->where('record.approve_status', 1);
    //                         $db = $db->whereBetween('record.created_at', [$start_date, $end_date]);
    //                         $db = $db->leftjoin('classification as c','record.classification_id', '=', 'c.id');
    //                         $db = $db->leftjoin('taxonomy as t1', 'c.domain' ,'=', 't1.id');
    //                         $db = $db->leftjoin('taxonomy as t2', 'c.kingdom' ,'=', 't2.id');
    //                         $db = $db->leftjoin('taxonomy as t3', 'c.subkingdom' ,'=', 't3.id');
    //                         $db = $db->leftjoin('taxonomy as t4', 'c.infrakingdom' ,'=', 't4.id');
    //                         $db = $db->leftjoin('taxonomy as t5', 'c.phylum' ,'=', 't5.id');
    //                         $db = $db->leftjoin('taxonomy as t6', 'c.subphylum' ,'=', 't6.id');
    //                         $db = $db->leftjoin('taxonomy as t7', 'c.infraphylum' ,'=', 't7.id');
    //                         $db = $db->leftjoin('taxonomy as t8', 'c.superclass' ,'=', 't8.id');
    //                         $db = $db->leftjoin('taxonomy as t9', 'c.class' ,'=', 't9.id');
    //                         $db = $db->leftjoin('taxonomy as t10', 'c.subclass' ,'=', 't10.id');
    //                         $db = $db->leftjoin('taxonomy as t11', 'c.infraclass' ,'=', 't11.id');
    //                         $db = $db->leftjoin('taxonomy as t12', 'c.superorder' ,'=', 't12.id');
    //                         $db = $db->leftjoin('taxonomy as t13', 'c.order_o' ,'=', 't13.id');
    //                         $db = $db->leftjoin('taxonomy as t14', 'c.suborder' ,'=', 't14.id');
    //                         $db = $db->leftjoin('taxonomy as t15', 'c.infraorder' ,'=', 't15.id');
    //                         $db = $db->leftjoin('taxonomy as t16', 'c.superfamily' ,'=', 't16.id');
    //                         $db = $db->leftjoin('taxonomy as t17', 'c.family' ,'=', 't17.id');
    //                         $db = $db->leftjoin('taxonomy as t18', 'c.subfamily' ,'=', 't18.id');
    //                         $db = $db->leftjoin('taxonomy as t19', 'c.genus' ,'=', 't19.id');
    //                         $db = $db->leftjoin('taxonomy as t20', 'c.subgenus' ,'=', 't20.id');
    //                         $db = $db->leftjoin('taxonomy as t21', 'c.species' ,'=', 't21.id');
    //                         $db = $db->leftjoin('taxonomy as t22', 'c.subspecies' ,'=', 't22.id');
    //                         $db = $db->leftjoin('marinecenter as marinecenter', 'record.marinecenter_id' ,'=', 'marinecenter.id');
    //                         $db = $db->leftjoin('institution as institution', 'marinecenter.institution_id' ,'=', 'marinecenter.id');
    //                         $db = $db->leftjoin('collection as collection', 'record.collection_code' ,'=', 'collection.id');
    //                         $db = $db->leftjoin('reference as ref', 'record.reference' ,'=', 'ref.id');
    //                         $db = $db->leftjoin('wording as w_donated_from', 'record.donated_from' ,'=', 'w_donated_from.id');
    //                         $db = $db->leftjoin('wording as w_deposited_at', 'record.deposited_at' ,'=', 'w_deposited_at.id');
    //                         $db = $db->leftjoin('wording as w_iq', 'c.identification_qualifier' ,'=', 'w_iq.id');
    //                         $db = $db->leftjoin('wording as w_type_status', 'record.type_status' ,'=', 'w_type_status.id');
    //                         $db = $db->leftjoin('wording as w_sex', 'record.sex' ,'=', 'w_sex.id');
    //                         $db = $db->leftjoin('wording as w_life_stage', 'record.life_stage' ,'=', 'w_life_stage.id');
    //                         $db = $db->leftjoin('wording as w_ocean', 'record.ocean_sea_lake' ,'=', 'w_ocean.id');
    //                         $db = $db->leftjoin('country as country', 'record.country' ,'=', 'country.id');
    //                         $db = $db->leftjoin('province as province', 'record.province' ,'=', 'province.id');
    //                         $db = $db->leftjoin('district as district', 'record.district' ,'=', 'district.id');
    //                         $db = $db->leftjoin('county as county', 'record.county' ,'=', 'county.id');
    //                         $db = $db->leftjoin('wording as w_habitat', 'record.habitat' ,'=', 'w_habitat.id');
    //                         $db = $db->leftjoin('wording as w_gear_method', 'record.gear_method' ,'=', 'w_gear_method.id');
    //                         $db = $db->leftjoin('wording as w_preparation_type', 'record.preparation_type' ,'=', 'w_preparation_type.id');
    //                         $db = $db->leftjoin('wording as w_expedition', 'record.expedition' ,'=', 'w_expedition.id');
    //                         $db = $db->leftjoin('view_picture as pic', 'record.unique_record' ,'=', 'pic.unique_record');
    //
    //                         $results = $db->select([
    //                             'record.id',
    //                             'record.created_at',
    //                             'record.updated_at',
    //                             'institution.department',
    //                             'institution.institution',
    //                             'marinecenter.marinecenter',
    //                             'marinecenter.marinecenter_code',
    //                             'record.source',
    //                             'collection.name_en as collection',
    //                             'collection.col_code as collection_code ',
    //                             'record.catalog_number',
    //                             'record.related_catalog_item',
    //                             'ref.name_en as ref',
    //                             'ref.ref_code',
    //                             'record.page',
    //                             'record.no_species',
    //                             'record.no_locality',
    //                             'record.related_reference_item',
    //                             'w_donated_from.name_en as donated_from',
    //                             'w_deposited_at.name_en as deposited_at',
    //                             'c.current_scientific_name',
    //                             'c.current_scientific_name_format',
    //                             't1.name as domain',
    //                             't2.name as kingdom',
    //                             't3.name as subkingdom',
    //                             't4.name as infrakingdom',
    //                             't5.name as phylum',
    //                             't6.name as subphylum',
    //                             't7.name as infraphylum',
    //                             't8.name as superclass',
    //                             't9.name as class',
    //                             't10.name as subclass',
    //                             't11.name as infraclass',
    //                             't12.name as superorder',
    //                             't13.name as order',
    //                             't14.name as suborder',
    //                             't15.name as infraorder',
    //                             't16.name as superfamily',
    //                             't17.name as family',
    //                             't18.name as subfamily',
    //                             't19.name as genus',
    //                             't20.name as subgenus',
    //                             't21.name as species',
    //                             't22.name as subspecies',
    //                             'w_iq.name_en as identification_qualifier',
    //                             'record.variety_name',
    //                             'c.previous_scientific_name',
    //                             'c.previous_scientific_name_format',
    //                             'w_type_status.name_en as type_status',
    //                             'record.diagnosis',
    //                             'record.description',
    //                             'record.individual_count',
    //                             'w_sex.name_en as sex',
    //                             'record.size',
    //                             'w_life_stage.name_en as life_stage',
    //                             'w_ocean.name_en as ocean_sea_lake',
    //                             'country.country_en',
    //                             'province.province_en',
    //                             'district.district_en',
    //                             'county.county_en',
    //                             'record.locality',
    //                             'record.verbatim_latitude',
    //                             'record.latitude',
    //                             'record.start_latitude',
    //                             'record.end_latitude',
    //                             'record.verbatim_longitude',
    //                             'record.longitude',
    //                             'record.start_longitude',
    //                             'record.end_longitude',
    //                             'w_habitat.name_en as habitat',
    //                             'w_gear_method.name_en as gear_method',
    //                             'record.depth_start',
    //                             'record.depth_end',
    //                             'record.collector',
    //                             'record.collected_date',
    //                             'record.collected_year',
    //                             'record.collected_month',
    //                             'record.collected_day',
    //                             'record.identifier',
    //                             'record.identified_date',
    //                             'record.identified_year',
    //                             'record.identified_month',
    //                             'record.identified_day',
    //                             'record.previous_identifier',
    //                             'record.previous_identified_date',
    //                             'record.note_collector',
    //                             'w_preparation_type.name_en as preparation_type',
    //                             'w_expedition.name_en as expedition',
    //                             'record.gene_bank_number',
    //                             'pic.path_pic1',
    //                             'pic.path_pic2',
    //                             'pic.path_pic3',
    //                             'pic.path_pic4',
    //                             'pic.path_pic5',
    //                             'pic.path_pic6'
    //                         ])->get();
    //                     // --------
    //
    //                     // display data
    //                         $row_number = 12;   // start line
    //                         foreach ( $results as $data ) {
    //                             // check source
    //                             if ( $data->source == 1 ) $data->source == 'Specimens'; else $data->source = 'Publication';
    //
    //                             // check page
    //                             if ( $data->page == 0 ) $data->page = '';
    //                             // check no_species
    //                             if ( $data->no_species == 0 ) $data->no_species = '';
    //                             // check no_locality
    //                             if ( $data->no_locality == 0 ) $data->no_locality = '';
    //
    //                             // check individual_count
    //                             if ( $data->individual_count == 0 ) $data->individual_count = '';
    //
    //                             //check picture
    //                             if ( $data->path_pic1 != null ) $data->path_pic1 = url('uploads/images').'/'.$data->path_pic1;
    //                             if ( $data->path_pic2 != null ) $data->path_pic2 = url('uploads/images').'/'.$data->path_pic2;
    //                             if ( $data->path_pic3 != null ) $data->path_pic3 = url('uploads/images').'/'.$data->path_pic3;
    //                             if ( $data->path_pic4 != null ) $data->path_pic4 = url('uploads/images').'/'.$data->path_pic4;
    //                             if ( $data->path_pic5 != null ) $data->path_pic5 = url('uploads/images').'/'.$data->path_pic5;
    //                             if ( $data->path_pic6 != null ) $data->path_pic6 = url('uploads/images').'/'.$data->path_pic6;
    //
    //                             $sheet->row( $row_number, array(
    //             				    $data->created_at, $data->updated_at, $data->department.' : '.$data->institution, $data->marinecenter, $data->marinecenter_code,
    //                                 $data->source, $data->collection, $data->collection_code, $data->catalog_number, $data->related_catalog_item,
    //                                 $data->ref, $data->ref_code, $data->page, $data->no_species, $data->no_locality,
    //                                 $data->related_reference_item, $data->donated_from, $data->deposited_at, $data->current_scientific_name, $data->current_scientific_name_format,
    //                                 $data->domain, $data->kingdom, $data->subkingdom,
    //                                 $data->infrakingdom, $data->phylum, $data->subphylum, $data->infraphylum, $data->superclass,
    //                                 $data->class, $data->subclass, $data->infraclass, $data->superorder, $data->order,
    //                                 $data->suborder, $data->infraorder, $data->superfamily, $data->family, $data->subfamily,
    //                                 $data->genus, $data->subgenus, $data->species, $data->subspecies, $data->identification_qualifier,
    //                                 $data->variety_name, $data->previous_scientific_name, $data->previous_scientific_name_format, $data->type_status, $data->diagnosis,
    //                                 $data->description, $data->individual_count, $data->sex, $data->size, $data->life_stage,
    //                                 $data->ocean_sea_lake, $data->country_en, $data->province_en, $data->district_en, $data->county_en,
    //                                 $data->locality, $data->verbatim_latitude, $data->latitude, $data->start_latitude, $data->end_latitude,
    //                                 $data->verbatim_longitude, $data->longitude, $data->start_longitude, $data->end_longitude, $data->habitat,
    //                                 $data->gear_method, $data->depth_start, $data->depth_end, $data->collector, $data->collected_date,
    //                                 $data->collected_year, $data->collected_month, $data->collected_day, $data->identifier, $data->identified_date,
    //                                 $data->identified_year, $data->identified_month, $data->identified_day, $data->previous_identifier, $data->previous_identified_date,
    //                                 $data->note_collector, $data->preparation_type, $data->expedition, $data->gene_bank_number, $data->path_pic1,
    //                                 $data->path_pic2, $data->path_pic3, $data->path_pic4, $data->path_pic5, $data->path_pic6
    //             				));
    //
    //                             //--- Set Layout and Style ---
    //                                 $sheet->setBorder('A'.$row_number.':CQ'.$row_number, 'thin');
    //                             //--- -------------------- ---
    //
    //                             $row_number++;
    //                         }
    //                 // ---------
    //             //--- ------------ ---
    //             } else {
    //
    //                 # -------------
    //                 # thai language
    //                 # -------------
    //
    //                 //--- Set Layout and Style ---
    //                     $sheet->mergeCells( 'A2:EN2' );
    // 				    $sheet->mergeCells( 'A3:EN3' );
    //                     $sheet->mergeCells( 'A4:EN4' );
    //                     $sheet->mergeCells( 'A5:EN5' );
    //                     $sheet->mergeCells( 'A6:EN6' );
    //                     $sheet->mergeCells( 'A7:EN7' );
    // 				    $sheet->mergeCells( 'A8:EN8' );
    //                     $sheet->mergeCells( 'A9:EN9' );
    //
    //                     $sheet->setHeight( 2, 30 );
    //                     $sheet->setHeight( 6, 30 );
    //                     $sheet->setHeight( 11, 30 );
    //
    //                     $sheet->row( 2, function( $row ) {
    //                         $row->setBackground( '#FE9529' );
    //                     });
    //                     $sheet->row( 6, function( $row ) {
    //                         $row->setBackground('#FE9529');
    //                     });
    //                     $sheet->row( 11, function( $row ) {
    //                         $row->setBackground( '#FE9529' );
    //                     });
    //
    //                     $sheet->cell( 'A2:EN2', function( $cells ) {
    //                         $cells->setFontSize( 20 );
    //                     });
    //                     $sheet->cell( 'A6:EN6', function( $cells ) {
    //                         $cells->setFontSize( 20 );
    //                     });
    //                     $sheet->cell( 'A11:EN11', function( $cells ) {
    //                         $cells->setFontSize( 16 );
    //                     });
    //
    //                     $sheet->cells( 'A2:EN2', function( $cells ) {
    //                         $cells->setFontWeight( 'bold' );
    //                     });
    //                     $sheet->cells( 'A6:EN6', function( $cells ) {
    //                         $cells->setFontWeight( 'bold' );
    //                     });
    //                     $sheet->cells( 'A11:EN11', function( $cells ) {
    //                         $cells->setFontWeight( 'bold' );
    //                         $cells->setAlignment( 'center' );
    //                         $cells->setValignment( 'middle' );
    //                     });
    //
    //                     $sheet->setBorder( 'A11:EN11', 'thin' );
    //                 //--- -------------------- ---
    //
    //                 //--- Header Part ---
    //                     $sheet->row( 2, array( 'Export Information' ) );
    //                     $sheet->row( 3, array( 'Export By: '.$user_name ) );
    //                     $sheet->row( 4, array( 'Date Export: '.$date_export ) );
    //                     $sheet->row( 6, array( 'Data Information' ) );
    //                     $sheet->row( 7, array( 'Data Start Date: '.$start_date_header ) );
    //                     $sheet->row( 8, array( 'Data End Date: '.$end_date_header ) );
    //                     $sheet->row( 9, array( 'Language: '.$language_name ) );
    //                 //--- ----------- ---
    //
    //                 //--- Header Table Part ---
    //                     $sheet->row(11, array(
    //     					'วันที่บันทึก', 'วันที่แก้ไข', 'หน่วยงาน: สถาบันที่สำรวจ', 'ศูนย์วิจัย', 'รหัสศูนย์วิจัย',
    //                         'Source', 'กลุ่มสิ่งมีชีวิต', 'รหัสของกลุ่มสิ่งมีชีวิต', 'CatalogNumber', 'รหัสชุดตัวอย่างที่สำรวจ',
    //                         'เอกสารอ้างอิง', 'รหัสเอกสารอ้างอิง', 'หน้า', 'ลำดับที่ของตัวอย่าง', 'ลำดับที่ของสถานที่',
    //                         'รหัสเอกสารที่สำรวจ', 'DonatedFrom','DepositedAt', 'ชื่อวิทยาศาสตร์', 'รูปแบบของชื่อวิทยาศาสตร',
    //                         'นักวิทยาศาสตร์', 'ปีที่ตีพิมพ์ พ.ศ.' ,'Domain', 'Kingdom', 'Subkingdom',
    //                         'Infrakingdom', 'Phylum', 'Subphylum', 'Infraphylum', 'Superclass',
    //                         'Class (Clade)', 'Subclass (Clade)', 'Infraclass (Clade)', 'Superorder (Clade)', 'Order (Clade)',
    //                         'Suborder (Clade)','Infraorder (Clade)', 'Superfamily (Clade)', 'Family (Clade)', 'Subfamily (Clade)',
    //                         'Genus', 'Subgenus', 'Species', 'Subspecies', 'IdentificationQualifier',
    //                         'Variety Name', 'ชื่อวิทยาศาสตร์ก่อนหน้านี้', 'รูปแบบของชื่อวิทยาศาสตร์ก่อนหน้านี้', 'TypeStatus', 'ลักษณะเด่น',
    //                         'คุณลักษณะอื่นๆ','จำนวนที่เก็บ', 'เพศ', 'ขนาด', 'ระยะการเจริญเติบโตที่พบ',
    //                         'มหาสมุทร/ทะเล/ทะเลสาบ', 'ประเทศ', 'จังหวัด', 'อำเภอ', 'ตำบล',
    //                         'Locality', 'VerbatimLatitude', 'Latitude', 'StartLatitude', 'EndLatitude',
    //                         'VerbatimLongitude', 'Longitude', 'StartLongitude', 'EndLongitude', 'ระบบนิเวศที่อาศัย',
    //                         'เครื่องมือ/วิธีการ', 'ความลึกเริ่มต้น', 'ความลึกสิ้นสุด', 'ผู้เก็บตัวอย่าง', 'Date ที่เก็บตัวอย่าง',
    //                         'ปีที', 'เดือนที่เก็บตัวอย่าง', 'เก็บตัวอย่าง', 'ผู้จำแนกชนิด', 'Date ที่จำแนกชนิดุ',
    //                         'ปีที่จำแนกชนิดุ', 'เดือนที่จำแนกชนิดุ', 'วันที่จำแนกชนิด', 'ผู้จำแนกชนิดก่อนหน้านี้', 'Date ที่จำแนกชนิดก่อนหน้านี้',
    //                         'วิธีเก็บรักษา', 'โครงการสำรวจหรือวิจัย', 'GeneBankNumber','ชื่อพื้นเมือง', 'ชื่อท้องถิ่น (ชื่อพื้นบ้าน)',
    //                         'ชื่อสามัญ', 'รหัสทีมสำรวจ (ชื่อย่อศูนย์-ปีงบประมาณที่สำรวจ)', 'พื้นที่สำรวจ', 'หมู่บ้าน', 'สถานที่พบอยู่ทางทิศ',
    //                         'ของสถานที่', 'การใช้ประโยชน์', 'ภูมิปัญญาชาวบ้าน', 'ผู้ให้ข้อมูล', 'รายละเอียดของภูมิปัญญา',
    //                         'อุณหภูมิดิน', 'ลักษณะของดิน', 'ความเป็นกรด-ด่าง ดิน', 'อุณหภูมิ น้ำ', 'ความโปร่งแสงของน้ำ',
    //                         'ความเป็นกรด-ด่าง น้ำ', 'ปริมาณออกซิเจนละลายน้ำ', 'ปริมาณของแข็งแขวนลอย', 'ค่าความเค็ม', 'การเก็บตัวอย่าง',
    //                         'การบันทึกภาพ', 'จำนวนที่พบเห็น (ไม่ได้เก็บตัวอย่าง)', 'หมายเหตุของข้อมูลการสำรวจ', 'เวลาที่พบ', 'อาหารที่พืชหรือสัตว์กิน',
    //                         'ถิ่นอาศัยที่พบ', 'การดำรงชีวิต', 'ประเภทของพืช', 'ประเภทของสัตว์ 1', 'ประเภทของสัตว์ 2',
    //                         'ประเภทของสัตว์ 3', 'การคุ้มครองสัตว์', 'การสืบพันธุ์', 'CD อ้างอิง', 'หมายเหตุของข้อมูลรูปภาพ',
    //                         'เลือกภาพนี้เพื่อแสดง', 'ภาพที่ 1', 'ผู้ถ่ายภาพที่1', 'คำบรรยายใต้ภาพที่1', 'ภาพที่ 2',
    //                         'ผู้ถ่ายภาพที่2', 'คำบรรยายใต้ภาพที่2', 'ภาพที่ 3', 'ผู้ถ่ายภาพที่3', 'คำบรรยายใต้ภาพที่3',
    //                         'ภาพที่ 4', 'ผู้ถ่ายภาพที่4', 'คำบรรยายใต้ภาพที่4', 'ภาพที่ 5', 'ผู้ถ่ายภาพที่5',
    //                         'คำบรรยายใต้ภาพที่5', 'ภาพที่ 6', 'ผู้ถ่ายภาพที่6', 'คำบรรยายใต้ภาพที่6'
    //     				));
    //                 //--- ----------------- ---
    //
    //                 //--- Content Part ---
    //                     // get data
    //                         $db = new Record;
    //                         $db = $db->where('record.language_id', 2)->where('record.status', 2)->where('record.approve_status', 1);
    //                         $db = $db->whereBetween('record.created_at', [$start_date, $end_date]);
    //                         $db = $db->leftjoin('classification as c','record.classification_id', '=', 'c.id');
    //                         $db = $db->leftjoin('taxonomy as t1', 'c.domain' ,'=', 't1.id');
    //                         $db = $db->leftjoin('taxonomy as t2', 'c.kingdom' ,'=', 't2.id');
    //                         $db = $db->leftjoin('taxonomy as t3', 'c.subkingdom' ,'=', 't3.id');
    //                         $db = $db->leftjoin('taxonomy as t4', 'c.infrakingdom' ,'=', 't4.id');
    //                         $db = $db->leftjoin('taxonomy as t5', 'c.phylum' ,'=', 't5.id');
    //                         $db = $db->leftjoin('taxonomy as t6', 'c.subphylum' ,'=', 't6.id');
    //                         $db = $db->leftjoin('taxonomy as t7', 'c.infraphylum' ,'=', 't7.id');
    //                         $db = $db->leftjoin('taxonomy as t8', 'c.superclass' ,'=', 't8.id');
    //                         $db = $db->leftjoin('taxonomy as t9', 'c.class' ,'=', 't9.id');
    //                         $db = $db->leftjoin('taxonomy as t10', 'c.subclass' ,'=', 't10.id');
    //                         $db = $db->leftjoin('taxonomy as t11', 'c.infraclass' ,'=', 't11.id');
    //                         $db = $db->leftjoin('taxonomy as t12', 'c.superorder' ,'=', 't12.id');
    //                         $db = $db->leftjoin('taxonomy as t13', 'c.order_o' ,'=', 't13.id');
    //                         $db = $db->leftjoin('taxonomy as t14', 'c.suborder' ,'=', 't14.id');
    //                         $db = $db->leftjoin('taxonomy as t15', 'c.infraorder' ,'=', 't15.id');
    //                         $db = $db->leftjoin('taxonomy as t16', 'c.superfamily' ,'=', 't16.id');
    //                         $db = $db->leftjoin('taxonomy as t17', 'c.family' ,'=', 't17.id');
    //                         $db = $db->leftjoin('taxonomy as t18', 'c.subfamily' ,'=', 't18.id');
    //                         $db = $db->leftjoin('taxonomy as t19', 'c.genus' ,'=', 't19.id');
    //                         $db = $db->leftjoin('taxonomy as t20', 'c.subgenus' ,'=', 't20.id');
    //                         $db = $db->leftjoin('taxonomy as t21', 'c.species' ,'=', 't21.id');
    //                         $db = $db->leftjoin('taxonomy as t22', 'c.subspecies' ,'=', 't22.id');
    //                         $db = $db->leftjoin('marinecenter as marinecenter', 'record.marinecenter_id' ,'=', 'marinecenter.id');
    //                         $db = $db->leftjoin('institution as institution', 'marinecenter.institution_id' ,'=', 'marinecenter.id');
    //                         $db = $db->leftjoin('collection as collection', 'record.collection_code' ,'=', 'collection.id');
    //                         $db = $db->leftjoin('reference as ref', 'record.reference' ,'=', 'ref.id');
    //                         $db = $db->leftjoin('wording as w_donated_from', 'record.donated_from' ,'=', 'w_donated_from.id');
    //                         $db = $db->leftjoin('wording as w_deposited_at', 'record.deposited_at' ,'=', 'w_deposited_at.id');
    //                         $db = $db->leftjoin('wording as w_iq', 'c.identification_qualifier' ,'=', 'w_iq.id');
    //                         $db = $db->leftjoin('wording as w_type_status', 'record.type_status' ,'=', 'w_type_status.id');
    //                         $db = $db->leftjoin('wording as w_sex', 'record.sex' ,'=', 'w_sex.id');
    //                         $db = $db->leftjoin('wording as w_life_stage', 'record.life_stage' ,'=', 'w_life_stage.id');
    //                         $db = $db->leftjoin('wording as w_ocean', 'record.ocean_sea_lake' ,'=', 'w_ocean.id');
    //                         $db = $db->leftjoin('country as country', 'record.country' ,'=', 'country.id');
    //                         $db = $db->leftjoin('province as province', 'record.province' ,'=', 'province.id');
    //                         $db = $db->leftjoin('district as district', 'record.district' ,'=', 'district.id');
    //                         $db = $db->leftjoin('county as county', 'record.county' ,'=', 'county.id');
    //                         $db = $db->leftjoin('wording as w_habitat', 'record.habitat' ,'=', 'w_habitat.id');
    //                         $db = $db->leftjoin('wording as w_gear_method', 'record.gear_method' ,'=', 'w_gear_method.id');
    //                         $db = $db->leftjoin('wording as w_preparation_type', 'record.preparation_type' ,'=', 'w_preparation_type.id');
    //                         $db = $db->leftjoin('wording as w_expedition', 'record.expedition' ,'=', 'w_expedition.id');
    //                         $db = $db->leftjoin('wording as w_team_exploration_code', 'record.team_exploration_code' ,'=', 'w_team_exploration_code.id');
    //                         $db = $db->leftjoin('wording as w_area_exploration', 'record.area_exploration' ,'=', 'w_area_exploration.id');
    //                         $db = $db->leftjoin('wording as w_area_direction', 'record.area_direction' ,'=', 'w_area_direction.id');
    //                         $db = $db->leftjoin('wording as w_utilization', 'record.utilization' ,'=', 'w_utilization.id');
    //                         $db = $db->leftjoin('wording as w_recorder', 'record.recorder' ,'=', 'w_recorder.id');
    //                         $db = $db->leftjoin('wording as w_plant_type', 'record.plant_type' ,'=', 'w_plant_type.id');
    //                         $db = $db->leftjoin('wording as w_animal_type1', 'record.animal_type1' ,'=', 'w_animal_type1.id');
    //                         $db = $db->leftjoin('wording as w_animal_type2', 'record.animal_type2' ,'=', 'w_animal_type2.id');
    //                         $db = $db->leftjoin('wording as w_animal_type3', 'record.animal_type3' ,'=', 'w_animal_type3.id');
    //                         $db = $db->leftjoin('wording as w_protection_type', 'record.protection_type' ,'=', 'w_protection_type.id');
    //                         $db = $db->leftjoin('view_picture as pic', 'record.unique_record' ,'=', 'pic.unique_record');
    //
    //                         $results = $db->select([
    //                             'record.id',
    //                             'record.created_at',
    //                             'record.updated_at',
    //                             'institution.department',
    //                             'institution.institution',
    //                             'marinecenter.marinecenter',
    //                             'marinecenter.marinecenter_code',
    //                             'record.source',
    //                             'collection.name_th as collection',
    //                             'collection.col_code as collection_code ',
    //                             'record.catalog_number',
    //                             'record.related_catalog_item',
    //                             'ref.name_th as ref',
    //                             'ref.ref_code',
    //                             'record.page',
    //                             'record.no_species',
    //                             'record.no_locality',
    //                             'record.related_reference_item',
    //                             'w_donated_from.name_th as donated_from',
    //                             'w_deposited_at.name_th as deposited_at',
    //                             'c.current_scientific_name',
    //                             'c.current_scientific_name_format',
    //                             't1.name as domain',
    //                             't2.name as kingdom',
    //                             't3.name as subkingdom',
    //                             't4.name as infrakingdom',
    //                             't5.name as phylum',
    //                             't6.name as subphylum',
    //                             't7.name as infraphylum',
    //                             't8.name as superclass',
    //                             't9.name as class',
    //                             't10.name as subclass',
    //                             't11.name as infraclass',
    //                             't12.name as superorder',
    //                             't13.name as order',
    //                             't14.name as suborder',
    //                             't15.name as infraorder',
    //                             't16.name as superfamily',
    //                             't17.name as family',
    //                             't18.name as subfamily',
    //                             't19.name as genus',
    //                             't20.name as subgenus',
    //                             't21.name as species',
    //                             't22.name as subspecies',
    //                             'w_iq.name_th as identification_qualifier',
    //                             'record.variety_name',
    //                             'c.previous_scientific_name',
    //                             'c.previous_scientific_name_format',
    //                             'w_type_status.name_th as type_status',
    //                             'record.diagnosis',
    //                             'record.description',
    //                             'record.individual_count',
    //                             'w_sex.name_th as sex',
    //                             'record.size',
    //                             'w_life_stage.name_th as life_stage',
    //                             'w_ocean.name_th as ocean_sea_lake',
    //                             'country.country_th',
    //                             'province.province_th',
    //                             'district.district_th',
    //                             'county.county_th',
    //                             'record.locality',
    //                             'record.verbatim_latitude',
    //                             'record.latitude',
    //                             'record.start_latitude',
    //                             'record.end_latitude',
    //                             'record.verbatim_longitude',
    //                             'record.longitude',
    //                             'record.start_longitude',
    //                             'record.end_longitude',
    //                             'w_habitat.name_th as habitat',
    //                             'w_gear_method.name_th as gear_method',
    //                             'record.depth_start',
    //                             'record.depth_end',
    //                             'record.collector',
    //                             'record.collected_date',
    //                             'record.collected_year',
    //                             'record.collected_month',
    //                             'record.collected_day',
    //                             'record.identifier',
    //                             'record.identified_date',
    //                             'record.identified_year',
    //                             'record.identified_month',
    //                             'record.identified_day',
    //                             'record.previous_identifier',
    //                             'record.previous_identified_date',
    //                             'w_preparation_type.name_th as preparation_type',
    //                             'w_expedition.name_th as expedition',
    //                             'record.gene_bank_number',
    //                             'record.local_name',
    //                             'record.vernacular_name',
    //                             'record.common_name',
    //                             'w_team_exploration_code.name_th as team_exploration_code',
    //                             'w_area_exploration.name_th as area_exploration',
    //                             'record.village_no',
    //                             'w_area_direction.name_th as area_direction',
    //                             'record.area',
    //                             'w_utilization.name_th as utilization',
    //                             'record.folk_wisdom',
    //                             'w_recorder.name_th as recorder',
    //                             'record.knowledge_remarks',
    //                             'record.soil_temperature',
    //                             'record.soil_character',
    //                             'record.soil_ph',
    //                             'record.water_temperature',
    //                             'record.transparency',
    //                             'record.water_ph',
    //                             'record.dissolve_oxygen',
    //                             'record.suspended_solid',
    //                             'record.salinity',
    //                             'record.specimen_collection',
    //                             'record.specimen_photograph',
    //                             'record.sighting_no',
    //                             'record.exploration_remark',
    //                             'record.sighting_time',
    //                             'record.food',
    //                             'record.water_place',
    //                             'record.tree_place',
    //                             'record.soil_earth_place',
    //                             'record.ground_earth_place',
    //                             'record.coast_place',
    //                             'record.solo_living',
    //                             'record.group_living',
    //                             'w_plant_type.name_th as plant_type',
    //                             'w_animal_type1.name_th as animal_type1',
    //                             'w_animal_type2.name_th as animal_type2',
    //                             'w_animal_type3.name_th as animal_type3',
    //                             'w_protection_type.name_th as protection_type',
    //                             'record.reproduction',
    //                             'record.picture_name',
    //                             'record.picture_remark',
    //                             'pic.path_pic1',
    //                             'pic.caption1',
    //                             'pic.photographer1',
    //                             'pic.path_pic2',
    //                             'pic.caption2',
    //                             'pic.photographer2',
    //                             'pic.path_pic3',
    //                             'pic.caption3',
    //                             'pic.photographer3',
    //                             'pic.path_pic4',
    //                             'pic.caption4',
    //                             'pic.photographer4',
    //                             'pic.path_pic5',
    //                             'pic.caption5',
    //                             'pic.photographer5',
    //                             'pic.path_pic6',
    //                             'pic.caption6',
    //                             'pic.photographer6'
    //                         ])->get();
    //                     // --------
    //
    //                     // display data
    //                         $row_number = 12;   // start line
    //                         foreach ( $results as $data ) {
    //                             // check source
    //                             if ( $data->source == 1 ) $data->source == 'Specimens'; else $data->source = 'Publication';
    //
    //                             // check page
    //                             if ( $data->page == 0 ) $data->page = '';
    //                             // check no_species
    //                             if ( $data->no_species == 0 ) $data->no_species = '';
    //                             // check no_locality
    //                             if ( $data->no_locality == 0 ) $data->no_locality = '';
    //
    //                             // check place
    //                             $data->place = null;
    //                             $place = array();
    //                             if ( $data->water_place == 1 ) {
    //                                 array_push( $place, 'แหล่งน้ำ' );
    //                             }
    //                             if ( $data->tree_place == 1 ) {
    //                                 array_push( $place, 'บนต้นไม้' );
    //                             }
    //                             if ( $data->soil_earth_place == 1 ) {
    //                                 array_push( $place, 'หน้าดิน' );
    //                             }
    //                             if ( $data->ground_earth_place == 1 ) {
    //                                 array_push( $place, 'บนดิน' );
    //                             }
    //                             if ( $data->coast_place == 1 ) {
    //                                 array_push( $place, 'ชายฝั่งและทะเล' );
    //                             }
    //                             foreach ( $place as $p ) {
    //                                 $data->place .= ', '. $p;
    //                             }
    //                             if ( !is_null( $data->place ) ) {
    //                                 $data->place = substr( $data->place, 2 );
    //                             }
    //
    //                             // check village_no
    //                             if ( $data->village_no == 0 ) $data->village_no = '';
    //
    //                             // check individual_count
    //                             if ( $data->individual_count == 0 ) $data->individual_count = '';
    //
    //                             // check specimen_collection
    //                             if ( $data->specimen_collection == 1 ) $data->specimen_collection = 'ใช่';
    //                             else $data->specimen_collection = '';
    //                             // check specimen_photograph
    //                             if ( $data->specimen_photograph == 1 ) $data->specimen_photograph = 'ใช่';
    //                             else $data->specimen_photograph = '';
    //
    //                             // check reproduction
    //                             if ( $data->reproduction == 1 ) {
    //                                 $data->reproduction = 'อาศัยเพศ';
    //                             } elseif ( $data->reproduction == 2 ) {
    //                                 $data->reproduction = 'ไม่อาศัยเพศ';
    //                             } elseif ( $data->reproduction == '3' ) {
    //                                 $data->reproduction = 'อาศัยเพศและไม่อาศัยเพศ';
    //                             } else {
    //                                 $data->reproduction = '';
    //                             }
    //
    //                             //check picture
    //                             if ( $data->path_pic1 != null ) $data->path_pic1 = url('uploads/images').'/'.$data->path_pic1;
    //                             if ( $data->path_pic2 != null ) $data->path_pic2 = url('uploads/images').'/'.$data->path_pic2;
    //                             if ( $data->path_pic3 != null ) $data->path_pic3 = url('uploads/images').'/'.$data->path_pic3;
    //                             if ( $data->path_pic4 != null ) $data->path_pic4 = url('uploads/images').'/'.$data->path_pic4;
    //                             if ( $data->path_pic5 != null ) $data->path_pic5 = url('uploads/images').'/'.$data->path_pic5;
    //                             if ( $data->path_pic6 != null ) $data->path_pic6 = url('uploads/images').'/'.$data->path_pic6;
    //
    //                             $sheet->row( $row_number, array(
    //             				    $data->created_at, $data->updated_at, $data->department.' : '.$data->institution, $data->marinecenter, $data->marinecenter_code,
    //                                 $data->source, $data->collection, $data->collection_code, $data->catalog_number, $data->related_catalog_item,
    //                                 $data->ref, $data->ref_code, $data->page, $data->no_species, $data->no_locality,
    //                                 $data->related_reference_item, $data->donated_from, $data->deposited_at, $data->current_scientific_name, $data->current_scientific_name_format,
    //                                 $data->domain, $data->kingdom, $data->subkingdom,
    //                                 $data->infrakingdom, $data->phylum, $data->subphylum, $data->infraphylum, $data->superclass,
    //                                 $data->class, $data->subclass, $data->infraclass, $data->superorder, $data->order,
    //                                 $data->suborder, $data->infraorder, $data->superfamily, $data->family, $data->subfamily,
    //                                 $data->genus, $data->subgenus, $data->species, $data->subspecies, $data->identification_qualifier,
    //                                 $data->variety_name, $data->previous_scientific_name, $data->previous_scientific_name_format, $data->type_status, $data->diagnosis,
    //                                 $data->description, $data->individual_count, $data->sex, $data->size, $data->life_stage,
    //                                 $data->ocean_sea_lake, $data->country_th, $data->province_th, $data->district_th, $data->county_th,
    //                                 $data->locality, $data->verbatim_latitude, $data->latitude, $data->start_latitude, $data->end_latitude,
    //                                 $data->verbatim_longitude, $data->longitude, $data->start_longitude, $data->end_longitude, $data->habitat,
    //                                 $data->gear_method, $data->depth_start, $data->depth_end, $data->collector, $data->collected_date,
    //                                 $data->collected_year, $data->collected_month, $data->collected_day, $data->identifier, $data->identified_date,
    //                                 $data->identified_year, $data->identified_month, $data->identified_day, $data->previous_identifier, $data->previous_identified_date,
    //                                 $data->preparation_type, $data->expedition, $data->gene_bank_number, $data->local_name, $data->vernacular_name,
    //                                 $data->common_name, $data->team_exploration_code, $data->area_exploration, $data->village_no, $data->area_direction,
    //                                 $data->area, $data->utilization, $data->folk_wisdom, $data->recorder, $data->knowledge_remarks,
    //                                 $data->soil_temperature, $data->soil_character, $data->soil_ph, $data->water_temperature, $data->transparency,
    //                                 $data->water_ph, $data->dissolve_oxygen, $data->suspended_solid, $data->salinity, $data->specimen_collection,
    //                                 $data->specimen_photograph, '', $data->exploration_remark, '', $data->food,
    //                                 $data->place, '', $data->plant_type, $data->animal_type1, $data->animal_type2,
    //                                 $data->animal_type3, $data->protection_type, $data->reproduction, $data->picture_name, $data->picture_remark,
    //                                 '', $data->path_pic1, $data->caption1, $data->photographer1, $data->path_pic2,
    //                                 $data->caption2, $data->photographer2, $data->path_pic3, $data->caption3, $data->photographer3,
    //                                 $data->path_pic4, $data->caption4, $data->photographer4, $data->path_pic5, $data->caption5,
    //                                 $data->photographer5, $data->path_pic6, $data->caption6, $data->photographer6
    //             				));
    //
    //                             //--- Set Layout and Style ---
    //                                 $sheet->setBorder('A'.$row_number.':EN'.$row_number, 'thin');
    //                             //--- -------------------- ---
    //
    //                             $row_number++;
    //                         }
    //                     // ---------
    //                 //--- ------------ ---
    //             }
    //         });
    //
    //
    //     })->export( 'xlsx' );
    //
    //     //---- --------------- ----
    // }
}
