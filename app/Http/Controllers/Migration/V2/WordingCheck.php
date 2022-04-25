<?php
namespace App\Http\Controllers\Migration\V2;

use App\Model\RecordSex;
use App\Model\Wording_type;
use App\Model\Wording;

trait WordingCheck {
    protected function wordingIdentificationQualifier($wording_en) {
        //ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $wording = Wording::where('wording_type_id', 1)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 1;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_en;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingTypeStatus($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 2)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 2;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingOceanSeaLake($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 3)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 3;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingGearMethod($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 4)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 4;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingSex($wording_en, $unique_record) {
        if( $wording_en !== "" ){
            $sex_wording = array("Male", "Female", "Hermaphrodite", "Indeterminate", "Unknown", "Transitional", "Imposex");

            // ตัดคำ
            $arr_wording = explode(",", $wording_en);

            if (count((array) $arr_wording) > 0) {
                foreach ($arr_wording as $word) {
                    // นำคำไปเทียบใน array
                    $result_array = array_search($word, $sex_wording);
                    // ถ้าเทียบแล้วมีก็ save ถ้าไม่มีก็ไม่ save
                    if( $result_array != FALSE ) {
                        $recordSex = new RecordSex();
                        $recordSex->record_unique_id = $unique_record;
                        $recordSex->sex_id = $result_array + 1;
                        $recordSex->save();
                    }
                }
            }
        }
    }

    protected function wordingExpedition($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 6)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 6;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingPreparationType($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 7)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 7;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingHabitat($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 8)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 8;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingLifeStage($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 9)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 9;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingDonatedFrom($wording_en) {
        // ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $wording = Wording::where('wording_type_id', 10)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 10;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_en;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingDepositedAt($wording_en) {
        //ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $wording = Wording::where('wording_type_id', 11)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 11;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_en;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingProtectionIUCN($wording_en) {
        // ตรวจ EN ไม่เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $wording = Wording::where('wording_type_id', 12)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                return null;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingAreaDirection($wording_en, $wording_th) {
        //ตรวจ TH เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $wording = Wording::where('wording_type_id', 13)
                        ->where('name_th', $wording_th)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 13;
                $_wording->name_en = $wording_en;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingUtilization() {
        //
        // 14
    }

    protected function wordingTeamExplorationCode() {
        //
        // 15
    }

    protected function wordingAreaExploration() {
        //
        // 16
    }

    protected function wordingRecorder() {
        //
        // 17
    }

    protected function wordingAnimalType1($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $wording = Wording::where('wording_type_id', 18)
                        ->where('name_th', $wording_th)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 18;
                $_wording->name_en = $wording_th;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingAnimalType2($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $wording = Wording::where('wording_type_id', 19)
                        ->where('name_th', $wording_th)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 19;
                $_wording->name_en = $wording_th;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingAnimalType3($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $wording = Wording::where('wording_type_id', 20)
                        ->where('name_th', $wording_th)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 20;
                $_wording->name_en = $wording_th;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingPlantType($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $wording = Wording::where('wording_type_id', 21)
                        ->where('name_th', $wording_th)
                        ->first();

            if(is_null($wording)) {
                $_wording = new Wording;
                $_wording->wording_type_id = 21;
                $_wording->name_en = $wording_th;
                $_wording->name_th = $wording_th;
                $_wording->status = 2;
                $_wording->created_by = \Auth::user()->id;
                $_wording->updated_by = \Auth::user()->id;
                $_wording->save();
                return $_wording->id;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingProtectionThaiLaw($wording_en) {
        // ตรวจ EN ไม่เพิ่มคำ
        if($wording_en !== ""){
            $wording = Wording::where('wording_type_id', 22)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                return null;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingProtecitonCITES($wording_en) {
        // ตรวจ EN ไม่เพิ่มคำ
        if($wording_en !== ""){
            $wording = Wording::where('wording_type_id', 23)
                        ->where('name_en', $wording_en)
                        ->first();

            if(is_null($wording)) {
                return null;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingEconomicValue($wording_th) {
        // ตรวจแค่ภาษาไทย ไม่เพิ่มคำ
        // record ภาษาไทย ไม่เพิ่มคำ

        //ตรวจ TH ไม่เพิ่มคำ
        if($wording_th !== ""){
            $wording = Wording::where('wording_type_id', 24)
                        ->where('name_th', $wording_th)
                        ->first();

            if(is_null($wording)) {
                return null;
            }else {
                return $wording->id;
            }
        }
    }

    protected function wordingSedimentType() {
        //
    }

    protected function wordingInvasiveSpecies() {
        //
    }

    protected function wordingLiving() {
        //
    }

}
