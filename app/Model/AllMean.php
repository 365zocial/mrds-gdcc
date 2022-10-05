<?php

namespace App\Model;

class AllMean
{
    public $alltableForSystemlog = ['classification',
                                    'collection',
                                    'country',
                                    'county',
                                    'district',
                                    'group_permission',
                                    // 'header_taxonomy',
                                    // 'institution',
                                    // 'language',
                                    'mailbox',
                                    // 'marinecenter',
                                    'picture',
                                    'province',
                                    'record',
                                    'record_loan',
                                    'record_loan_post',
                                    'reference',
                                    // 'role',
                                    'taxonomy',
                                    'users',
                                    'wording',
                                    'wording_type'];

    public static function defineAdd(){
        return 1;
    }

    public static function defineEdit(){
        return 2;
    }

    public static function defineDelete(){
        return 3;
    }

    //=============== Alert =================
    public static function defineAddAlertSuccess(){
        return 0;
    }

    public static function defineAddAlertFail(){
        return 1;
    }

    public static function defineEditAlertSuccess(){
        return 2;
    }

    public static function defineEditAlertFail(){
        return 3;
    }

    public static function defineDeleteAlertSuccess(){
        return 4;
    }

    public static function defineDeleteAlertFail(){
        return 5;
    }
    //============================================

    public static function ConvertStatusName($int_status){
        if($int_status == 2) return "Enable";
        elseif($int_status == 1) return "Disable";
        else return "Error!";
    }

    public static function ConvertSwitchStatus($status){
        $send = 0;
        if($status == "on") $send = 2;
        if(is_null($status)) $send = 1;
        return $send;
    }

    public static function ConvertStatusBoolean($status){
        $send = 0;
        if($status == "on") $send = 1;
        if(is_null($status)) $send = 0;
        return $send;
    }

    public static function ReplaceNullWithDash($obj, $attr = ""){
        $str = "";

        if( !is_null($obj) && $obj != "0" ){
            if($attr != ""){
                $str = $obj->$attr;
            }else{
                $str = $obj;
            }

            if($str == ""){
                $str = "-";
            }
        }elseif(!is_null($obj) && $obj == "0"){
            $str = "-";
        }elseif( is_null($obj) ){
            $str = "-";
        }

        return $str;
    }

    public static function ReplaceNullWithDefaultDate($attr = "") {
        $str = "";

        if(is_null($attr) || $attr == "0" || $attr == "0000-00-00"){
            $str = "-";
        }
        else{
            $str = date('d-m-Y', strtotime($attr));
        }

        return $str;
    }

    // สำหรับ Form Edit ข้อมูล เพื่อป้องกัน bug ตอนเซฟแล้วได้เครื่องหมาย "-"
    public static function ReplaceNullWithDefaultDateOnForm($attr = "") {
        $str = "";

        if(is_null($attr) || $attr == "0" || $attr == "0000-00-00"){
            $str = null;
        }
        else{
            $str = date('d-m-Y', strtotime($attr));
        }

        return $str;
    }

    public static function ReplaceNullWithDefaultTime($attr = "") {
        $str = "";

        if(is_null($attr) || $attr == "0" || $attr == "00:00:00"){
            $str = "00:00:00";
        }
        else{
            $str = date('H:i:s', strtotime($attr));
        }

        return $str;
    }

    public static function ReplaceNullWithDefaultTime2($attr = "") {
        $str = "";

        if(is_null($attr) || $attr == "0" || $attr == "00:00"){
            $str = "00:00";
        }
        else{
            $str = date('H:i', strtotime($attr));
        }

        return $str;
    }

    public static function checkNullOrZeroReturnTaxonomy($id){
        if(!is_null($id) && $id != 0){
            return Taxonomy::getTaxonomyWording($id)->name;
        }else{
            return "-";
        }
    }

    public static function dmstodecimal($d,$m,$s,$direction){
        $decimal = $d+($m/60)+($s/3600);
        if ( !empty($direction) && ($direction == "S" || $direction == "W") ) {
            $decimal = $decimal*(-1);
        }
        return sprintf("%.6f",$decimal);
    }

    public static function checkAndCutForNoneBackSpace( $word ) {
        return str_replace("&nbsp;"," ", $word);
    }

}
