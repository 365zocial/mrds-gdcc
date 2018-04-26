<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;

use App\Model\AllMean;
use App\Model\CatchException;

class System_Log extends Model
{
    protected $table = 'system_log';

    public static function setOldData($data){
        System_Log::destroyOldData();
        Session::put('oldData', $data);
    }

    public static function getOldData(){
        return Session::get('oldData');
    }

    public static function destroyOldData(){
        Session::forget('oldData');
    }

    public static function setNewData($data){
        Session::put('newData', $data);
    }

    public static function getNewData(){
        return Session::get('newData');
    }

    public static function destroyNewData(){
        Session::forget('newData');
    }

    public static function setTableName($table){
        Session::put('table', $table);
    }

    public static function getTableName(){
        return Session::get('table');
    }

    public static function destroyTableName(){
        Session::forget('table');
    }

    // public static function setActivity($action){
    //     Session::put('activity',$action);
    // }
    //
    // public static function getActivity(){
    //     return Session::get('activity');
    // }
    //
    // public static function destroyActivity(){
    //     Session::forget('activity');
    // }

    // 1 as Add
    // 2 is Edit (เดิม 2 = แก้ไข)
    // 3 is Enable (เดิม 3 = เพิ่ม)
    // 4 is Disable (เดิม 4 = ยกเลิก)
    // 5 is Loan
    // 6 is Cancel Loan

    public static function removeUpdate_Create_at($arr){
        // dd($arr);
        if(is_array($arr) && array_key_exists('updated_at',$arr)){
            unset($arr['updated_at']);
        }
        if(is_array($arr) && array_key_exists('created_at',$arr)){
            unset($arr['created_at']);
        }
        return $arr;
    }

    public static function array_get_diff($arr_old, $arr_new){

        if(sizeof($arr_old) != (sizeof($arr_new))){
            echo "not equal size array";
            exit;
        }

        ksort($arr_old);
        ksort($arr_new);

        $arr_data_diff      =   [];
        foreach ($arr_old as $key => $value) {
            if($value != $arr_new[$key]){
                $arr_data_diff[$key]    =   $arr_new[$key];
            }
        }
        return $arr_data_diff;

    }

    public static function Loging($table, $row_id = "", $activity, $oldData = "", $newData = ""){

        if($activity == AllMean::defineAdd()){
            System_Log::Log_Add($table, $row_id, $newData);
        }

        elseif($activity == AllMean::defineEdit()){
            System_Log::Log_Edit($table, $row_id, $oldData, $newData);
            System_Log::destroyOldData();
        }
        elseif($activity == AllMean::defineDelete()){
            System_Log::Log_Delete($table, $row_id);
        }

    }

    public static function Log_Add($table, $row_id,$arr_new){

        $arr_new            =   System_Log::removeUpdate_Create_at($arr_new);

        $data = ['table_name' => $table,
                'row_id' => $row_id,
                'column_name' => 'id',
                'action' => AllMean::defineAdd(),
                'old_data_diff' => '-',
                'new_data_diff' => '-',
                'size_diff' => 1];

        return System_Log::insertData_System_log_from_Add_or_Delete($data);

    }

    public static function Log_Edit($table, $row_id, $arr_old,$arr_new){

        $arr_new            =   System_Log::removeUpdate_Create_at($arr_new);
        $arr_old            =   System_Log::removeUpdate_Create_at($arr_old);
        $new_data_diff      =   System_Log::array_get_diff($arr_old, $arr_new);

        $key_diff           =   array_keys($new_data_diff);
        $size_result        =   sizeof($new_data_diff);
        $old_data_diff      =   [];

        foreach($key_diff as $key){

            $old_data_diff[$key] =   $arr_old[$key];
        }


        $data = ['table_name' => $table,
                'row_id' => $row_id,
                'column_name' => $key_diff,
                'action' => AllMean::defineEdit(),
                'old_data_diff' => $old_data_diff,
                'new_data_diff' => $new_data_diff,
                'size_diff' => $size_result];

        return System_Log::insertData_System_log_from_Edit($data);
    }

    public static function Log_Delete($table, $row_id){

        $data = ['table_name' => $table,
                'row_id' => $row_id,
                'column_name' => 'id',
                'action' => AllMean::defineDelete(),
                'old_data_diff' => '-',
                'new_data_diff' => '-',
                'size_diff' => 1];

        return System_Log::insertData_System_log_from_Add_or_Delete($data);

    }

    public static function insertData_System_log_from_Add_or_Delete($data){

        if($data['size_diff'] == 1){
            $db                 =   new System_Log;
            $db->table_name     =   $data['table_name'];
            $db->column_name    =   $data['column_name'];
            $db->row_id         =   $data['row_id'];
            $db->action         =   $data['action'];
            $db->old_value      =   $data['old_data_diff'];
            $db->new_value      =   $data['new_data_diff'];
            $db->created_by     =   Auth::user()->id;

            $db->save();
        }
    }

    public static function insertData_System_log_from_Edit($data){

        foreach ($data['column_name'] as $column_name) {
            $db                 =   new System_Log;

            $db->table_name     =   $data['table_name'];
            $db->column_name    =   $column_name;
            $db->row_id         =   $data['row_id'];
            $db->action         =   $data['action'];
            $db->old_value      =   $data['old_data_diff'][ $column_name ];
            $db->new_value      =   $data['new_data_diff'][ $column_name ];
            $db->created_by     =   Auth::user()->id;

            $db->save();

        }
    }



}
