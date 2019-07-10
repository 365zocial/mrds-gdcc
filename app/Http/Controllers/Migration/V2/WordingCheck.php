<?php
namespace App\Http\Controllers\Migration\V2;

use App\Model\Wording_type;
use App\Model\Wording;

trait WordingCheck {
    protected function wordingIdentificationQualifier($wording_en) {
        //ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $name_en = $wording_en;
            $name_th = $wording_en;
            $wording = Wording::firstOrCreate(['wording_type_id' => 1, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingTypeStatus($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 2, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingOceanSeaLake($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 3, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingGearMethod($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 4, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingSex($wording_en) {
        //ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $name_en = $wording_en;
            $name_th = $wording_en;
            $wording = Wording::firstOrCreate(['wording_type_id' => 5, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingExpedition($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 6, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingPreparationType($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 7, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingHabitat($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 8, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingLifeStage($wording_en, $wording_th) {
        //ตรวจ EN เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 9, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingDonatedFrom($wording_en) {
        // ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $name_en = $wording_en;
            $name_th = $wording_en;
            $wording = Wording::firstOrCreate(['wording_type_id' => 10, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingDepositedAt($wording_en) {
        //ตรวจ EN เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $name_en = $wording_en;
            $name_th = $wording_en;
            $wording = Wording::firstOrCreate(['wording_type_id' => 11, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingProtectionIUCN($wording_en) {
        // ตรวจ EN ไม่เพิ่มคำ
        // 1 ภาษา
        if($wording_en !== ""){
            $wording = Wording::where('name_en', $wording_en)->where('wording_type_id', 12)->first();
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingAreaDirection($wording_en, $wording_th) {
        //ตรวจ TH เพิ่มคำ
        // 2 ภาษา
        if($wording_en !== "" && $wording_th !== ""){
            $name_en = $wording_en;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 13, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
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
            $name_en = $wording_th;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 18, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingAnimalType2($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $name_en = $wording_th;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 18, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingAnimalType3($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $name_en = $wording_th;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 18, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingPlantType($wording_th) {
        //ตรวจ TH เพิ่มคำ
        //1 ภาษา
        if($wording_th !== ""){
            $name_en = $wording_th;
            $name_th = $wording_th;
            $wording = Wording::firstOrCreate(['wording_type_id' => 18, 'name_en' => $name_en, 'name_th' => $name_th], ['wording_type_id' => 1, 'name_en' => $name_en]);
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingProtectionThaiLaw($wording_en) {
        // ตรวจ EN ไม่เพิ่มคำ
        if($wording_en !== ""){
            $wording = Wording::where('name_en', $wording_en)->where('wording_type_id', 22)->first();
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingProtecitonCITES($wording_en) {
        // ตรวจ EN ไม่เพิ่มคำ
        if($wording_en !== ""){
            $wording = Wording::where('name_en', $wording_en)->where('wording_type_id', 23)->first();
            return !is_null($wording) ? $wording->id : null;
        }
    }

    protected function wordingEconomicValue($wording_th) {
        // ตรวจแค่ภาษาไทย ไม่เพิ่มคำ
        // record ภาษาไทย ไม่เพิ่มคำ

        //ตรวจ TH ไม่เพิ่มคำ
        if($wording_th !== ""){
            $wording = Wording::where('name_th', $wording_th)->where('wording_type_id', 24)->first();
            return !is_null($wording) ? $wording->id : null;
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