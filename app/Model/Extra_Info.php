<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Model\System_Log;

class Extra_Info extends Model
{
    protected $table = 'extra_info';

    public static function addExtraInfo( $data, $unique_record ) {
        $info = new Extra_Info;
        $info->unique_record = $unique_record;

        for ( $i = 0; $i<20; $i++ ) {
            if ( $data[$i] == null && $data[$i] =='' && $data[$i] == ' ' ) {
                $info->{'extra'.($i+1)} = null;
            } else {
                $info->{'extra'.($i+1)} = $data[$i];
            }
            $info->{'extra_field_id'.($i+1)} = $i+1;
        }
        $info->created_by = Auth::user()->id;
        $info->updated_by = Auth::user()->id;
        $info->save();
    }

    public static function getExtraInfo( $unique_record ) {
        return Extra_Info::where('unique_record', $unique_record)->first();
    }

    public static function updateExtraInfo( $data, $unique_record ) {
        // for ( $i = 0; $i<20; $i++ ) {
        //     if ( $data[$i] == null && $data[$i] =='' && $data[$i] == ' ' ) {
        //         $data[$i] = null;
        //     }
        // }

        $info_old = Extra_Info::getExtraInfo( $unique_record );
        $id = $info_old->id;

        $info = Extra_Info::find( $id );
        // $info->extra1 = $data[0];
        // $info->extra2 = $data[1];
        // $info->extra3 = $data[2];
        // $info->extra4 = $data[3];
        // $info->extra5 = $data[4];
        // $info->extra6 = $data[5];
        // $info->extra7 = $data[6];
        // $info->extra8 = $data[7];
        // $info->extra9 = $data[8];
        // $info->extra10 = $data[9];
        // $info->extra11 = $data[10];
        // $info->extra12 = $data[11];
        // $info->extra13 = $data[12];
        // $info->extra14 = $data[13];
        // $info->extra15 = $data[14];
        // $info->extra16 = $data[15];
        // $info->extra17 = $data[16];
        // $info->extra18 = $data[17];
        // $info->extra19 = $data[18];
        // $info->extra20 = $data[19];
        for ( $i = 0; $i<20; $i++ ) {
            if ( $data[$i] == null && $data[$i] =='' && $data[$i] == ' ' ) {
                $info->{'extra'.($i+1)} = null;
            } else {
                $info->{'extra'.($i+1)} = $data[$i];
            }
        }
        $info->updated_by = Auth::user()->id;
        $info->save();

        // Log
        $info_new = Extra_Info::getExtraInfo( $unique_record );
        System_Log::Loging(
            'extra_info', // table_name
            $id, // row_id
            AllMean::defineEdit(),  // action
            $info_old->toArray(), // old_data
            $info_new->toArray()// new_data
        );
    }

}
