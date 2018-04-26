<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\AllMean;
use DB;
use Auth;
use Config;

class SystemLogController extends Controller
{
    public function searchView(){
        $obj = new AllMean;
        $data['list_tables'] = $obj->alltableForSystemlog;
        return view('staff.system_log.search', $data);
    }

    public function getSystemLog(Request $input){
        $start_dates    = explode("-",$input->start_date);
        $end_dates      = explode("-",$input->end_date);

        $start_date     = $start_dates[2]."-".$start_dates[1]."-".$start_dates[0]." 00:00:00";
        $end_date       = $end_dates[2]."-".$end_dates[1]."-".$end_dates[0]." 23:59:59";

        if($input->table_name == "export_log"){
            $result = DB::select("select ep.note, u.name as username, u.email, ep.updated_at as export_at from export_log ep, users u where ep.updated_by = u.id and ep.updated_at between ? and ?", [$start_date, $end_date]);
        }elseif($input->table_name == "login_log"){
            $result = DB::select("select u.name as username, u.email, ll.updated_at as login_at from login_log ll, users u where ll.user_id = u.id and ll.updated_at between ? and ?", [$start_date, $end_date]);
        }

        $myfile = fopen( Config::get('path.export_systemlog_file_path')."/log.txt", "w") or die("Unable to open file!");
        $title = "Export By: ".Auth::user()->name."\r\n"."Export Date: ".date('d-m-Y H:i:s')."\r\n";
        $line = "##########################################\r\n\r\n";

        $txt = json_encode($result, JSON_PRETTY_PRINT);

        if(sizeof($result) !== 0){
            fwrite($myfile, $title);
            fwrite($myfile, $line);
            fwrite($myfile, $txt);
        }
        fclose($myfile);

        return redirect('staff/systemlog/getLog');
    }
}
