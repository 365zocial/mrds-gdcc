<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\Wording;
use Illuminate\Http\Request;
use App\Model\Taxonomy;

class SearchReportTaxaController extends Controller
{
    public $type_taxa;
    public $type_diversity;
    // public $sql_master = "select c.id, c.current_scientific_name,
    //         r.locality as locality,
    //         w1.name_en as habitat,
    //         w2.name_en as ocean_sea_lake,
    //         cr.country_en as country,
    //         pr.province_en as province,
    //         dt.district_en as district,
    //         cy.county_en as county,
    //         t1.name as phylum,
    //         t2.name as class,
    //         t3.name as order_o,
    //         t4.name as family,
    //         concat(t5.name," ",t6.name) as species
    //         from classification c
    //         left join record r on r.classification_id = c.id
    //         left join country cr on r.country = cr.id
    //         left join province pr on r.province = pr.id
    //         left join district dt on r.district = dt.id
    //         left join county cy on r.county = cy.id
    //         left join wording w1 on w1.id = r.habitat
    //         left join wording w2 on w2.id = r.ocean_sea_lake
    //         left join taxonomy t1 on t1.id = c.phylum
    //         left join taxonomy t2 on t2.id = c.class
    //         left join taxonomy t3 on t3.id = c.order_o
    //         left join taxonomy t4 on t4.id = c.family
    //         left join taxonomy t5 on t5.id = c.genus
    //         left join taxonomy t6 on t6.id = c.species
    //         where r.language_id = 1
    //         order by phylum,class,order_o,family,species asc";

    public $sql_part1 = "select c.id, c.current_scientific_name,
            r.locality as locality,
            w1.name_en as habitat,
            w2.name_en as ocean_sea_lake,
            cr.country_en as country,
            pr.province_en as province,
            dt.district_en as district,
            cy.county_en as county,";

    public $sql_part2 = " from classification c
            left join record r on r.classification_id = c.id
            left join country cr on r.country = cr.id
            left join province pr on r.province = pr.id
            left join district dt on r.district = dt.id
            left join county cy on r.county = cy.id
            left join wording w1 on w1.id = r.habitat
            left join wording w2 on w2.id = r.ocean_sea_lake";

    // public $sql_for_search_bio = [
    //         ["t1.name as phylum,
    //         t2.name as class,
    //         t3.name as order_o,
    //         t4.name as family,
    //         concat(t5.name,' ',t6.name) as species",
    //         " left join taxonomy t1 on t1.id = c.phylum
    //         left join taxonomy t2 on t2.id = c.class
    //         left join taxonomy t3 on t3.id = c.order_o
    //         left join taxonomy t4 on t4.id = c.family
    //         left join taxonomy t5 on t5.id = c.genus
    //         left join taxonomy t6 on t6.id = c.species
    //         where r.language_id = 1
    //         and c.phylum = ?
    //         order by phylum,class,order_o,family,species asc"],
    //
    //         ["t2.name as class,
    //         t3.name as order_o,
    //         t4.name as family,
    //         concat(t5.name,' ',t6.name) as species",
    //         " left join taxonomy t2 on t2.id = c.class
    //         left join taxonomy t3 on t3.id = c.order_o
    //         left join taxonomy t4 on t4.id = c.family
    //         left join taxonomy t5 on t5.id = c.genus
    //         left join taxonomy t6 on t6.id = c.species
    //         where r.language_id = 1
    //         and c.class = ?
    //         order by class,order_o,family,species asc"],
    //
    //         ["t3.name as order_o,
    //         t4.name as family,
    //         concat(t5.name,' ',t6.name) as species",
    //         " left join taxonomy t3 on t3.id = c.order_o
    //         left join taxonomy t4 on t4.id = c.family
    //         left join taxonomy t5 on t5.id = c.genus
    //         left join taxonomy t6 on t6.id = c.species
    //         where r.language_id = 1
    //         and c.order_o = ?
    //         order by order_o,family,species asc"],
    //
    //         ["t4.name as family,
    //         concat(t5.name,' ',t6.name) as species",
    //         " left join taxonomy t4 on t4.id = c.family
    //         left join taxonomy t5 on t5.id = c.genus
    //         left join taxonomy t6 on t6.id = c.species
    //         where r.language_id = 1
    //         and family = ?
    //         order by family,species asc"],
    //
    //         ["concat(t5.name,' ',t6.name) as species",
    //         " left join taxonomy t5 on t5.id = c.genus
    //         left join taxonomy t6 on t6.id = c.species
    //         where r.language_id = 1
    //         and c.species = ?
    //         order by species asc"]
    //
    //     ];

    public $sql_for_search = [
            ["t1.name as phylum,
            t2.name as class,
            t3.name as order_o,
            t4.name as family,
            concat(t5.name,' ',t6.name) as species",
            " left join taxonomy t1 on t1.id = c.phylum
            left join taxonomy t2 on t2.id = c.class
            left join taxonomy t3 on t3.id = c.order_o
            left join taxonomy t4 on t4.id = c.family
            left join taxonomy t5 on t5.id = c.genus
            left join taxonomy t6 on t6.id = c.species
            where r.language_id = 1",
            " and c.phylum = ?",
            " order by phylum,class,order_o,family,species asc"], //phylum

            ["t2.name as class,
            t3.name as order_o,
            t4.name as family,
            concat(t5.name,' ',t6.name) as species",
            " left join taxonomy t2 on t2.id = c.class
            left join taxonomy t3 on t3.id = c.order_o
            left join taxonomy t4 on t4.id = c.family
            left join taxonomy t5 on t5.id = c.genus
            left join taxonomy t6 on t6.id = c.species
            where r.language_id = 1",
            " and c.class = ?",
            " order by class,order_o,family,species asc"], // class

            ["t3.name as order_o,
            t4.name as family,
            concat(t5.name,' ',t6.name) as species",
            " left join taxonomy t3 on t3.id = c.order_o
            left join taxonomy t4 on t4.id = c.family
            left join taxonomy t5 on t5.id = c.genus
            left join taxonomy t6 on t6.id = c.species
            where r.language_id = 1",
            " and c.order_o = ?",
            " order by order_o,family,species asc"], // order

            ["t4.name as family,
            concat(t5.name,' ',t6.name) as species",
            " left join taxonomy t4 on t4.id = c.family
            left join taxonomy t5 on t5.id = c.genus
            left join taxonomy t6 on t6.id = c.species
            where r.language_id = 1",
            " and c.family = ?",
            " order by family,species asc"], // family

            ["concat(t5.name,' ',t6.name) as species",
            " left join taxonomy t5 on t5.id = c.genus
            left join taxonomy t6 on t6.id = c.species
            where r.language_id = 1",
            " and c.species = ?",
            " order by species asc"] // species

        ];

    public $header_taxa_name = "";
    public $phylum_name = "";
    public $class_name = "";
    public $order_o_name = "";
    public $family_name = "";
    public $species_name = "";
    public $other_taxa_name = "";

    public $phylum_id = "";
    public $class_id = "";
    public $order_o_id = "";
    public $family_id = "";
    public $species_id = "";
    public $other_taxa_id = "";
    public $locality = "";

    public $array_header_taxa = ['phylum','class','order','family','species'];
    public $array_header_taxa_full = ['domain','kingdom','subkingdom','infrakingdom','phylum','subphylum','infraphylum','superclass','class','subclass','infraclass','superorder','order','suborder','infraorder','superfamily','family','subfamily','genus','subgenus','species','subspecies'];


    public function __construct(){
        $this->type_taxa = json_decode(Session::get('search_biogeography'));
        $this->type_diversity = json_decode(Session::get('search_diversity'));
    }

    public function taxa_name_id($type_taxa){

        if( !is_null($type_taxa) ){
            foreach ( $type_taxa as $key => $value) {
                $tmp_taxa_name = Taxonomy::find($value);
                if( strtolower($key) == "phylum" ){
                    $this->phylum_id = $value;
                    $this->phylum_name = $tmp_taxa_name->name;
                }

                if( strtolower($key) == "class" ){
                    $this->class_id = $value;
                    $this->class_name = $tmp_taxa_name->name;
                }

                if( strtolower($key) == "order" ){
                    $this->order_o_id = $value;
                    $this->order_o_name = $tmp_taxa_name->name;
                }

                if( strtolower($key) == "family" ){
                    $this->family_id = $value;
                    $this->family_name = $tmp_taxa_name->name;
                }

                if( strtolower($key) == "species" ){
                    $this->species_id = $value;
                    $this->species_name = $tmp_taxa_name->name;
                }
            }
        }

    }

    public function reportBio_Five_Btn($type){
        $this->taxa_name_id($this->type_taxa);
        $sql_taxa = "";

        if($type !== ""){
            if( strtolower($type) == $this->array_header_taxa[0] ){ // phylum
                $no_of_array_sql = 0;
                $data['name_taxa_select'] = $this->phylum_name;
                // $sql_taxa = "and c.phylum = ? ";
                $id_taxa = $this->phylum_id;
            }
            if( strtolower($type) == $this->array_header_taxa[1] ){ // class
                $no_of_array_sql = 1;
                $data['name_taxa_select'] = $this->class_name;
                // $sql_taxa = "and c.class = ? ";
                $id_taxa = $this->class_id;
            }
            if( strtolower($type) == $this->array_header_taxa[2] ){ // order_o
                $no_of_array_sql = 2;
                $data['name_taxa_select'] = $this->order_o_name;
                // $sql_taxa = "and c.order_o = ? ";
                $type = "order_o";
                $id_taxa = $this->order_o_id;
            }
            if( strtolower($type) == $this->array_header_taxa[3] ){ // family
                $no_of_array_sql = 3;
                $data['name_taxa_select'] = $this->family_name;
                // $sql_taxa = "and c.family = ? ";
                $id_taxa = $this->family_id;
            }
            if( strtolower($type) == $this->array_header_taxa[4] ){ // species
                $no_of_array_sql = 4;
                $data['name_taxa_select'] = $this->species_name;
                $id_taxa = $this->species_id;
            }
            $sql_taxa = "and c.".$type." = ? ";
        }

        $data['taxa_select'] = ucfirst($type);
        $data['column_taxa_excel'] = $no_of_array_sql;

        $sql = $this->sql_part1;
        $sql .= $this->sql_for_search[$no_of_array_sql][0];
        $sql .= $this->sql_part2;
        $sql .= $this->sql_for_search[$no_of_array_sql][1];
        $sql .= $this->sql_for_search[$no_of_array_sql][2];
        $sql .= $this->sql_for_search[$no_of_array_sql][3];

        $data['results'] = DB::select($sql,[$id_taxa]);
        $data['header_excel'] = "Search_Biogeography";

        return view('staff.search_report.report_bio', $data);
    }

    public function getTaxa_Diverity(){
        foreach ($this->type_diversity as $key => $value) {
            if( in_array($key, $this->array_header_taxa) ){

                $this->header_taxa_name = $key;
                $this->taxa_name_id([$key => $value]);

            }elseif( in_array($key, $this->array_header_taxa_full) ){

                $this->header_taxa_name = $key;
                $this->other_taxa_id = $value;
                $this->other_taxa_name = Taxonomy::find($value)->name;

            }else{
                $this->locality = [$key => $value];
            }
        }
    }

    public function reportDiver_Long_List(){
        $sql_locality = "";
        $sql_taxa = "";
        $fullname_locality = "";
        $no_of_array_sql = 0;

        $this->getTaxa_Diverity();
        $type = $this->header_taxa_name;

        if($type !== ""){
            if( strtolower($type) == $this->array_header_taxa[0] ){ // phylum
                $no_of_array_sql = 0;
                $data['name_taxa_select'] = $this->phylum_name;
                $id_taxa = $this->phylum_id;

            }elseif( strtolower($type) == $this->array_header_taxa[1] ){ // class
                $no_of_array_sql = 1;
                $data['name_taxa_select'] = $this->class_name;
                $id_taxa = $this->class_id;
            }elseif( strtolower($type) == $this->array_header_taxa[2] ){ // order_o
                $no_of_array_sql = 2;
                $data['name_taxa_select'] = $this->order_o_name;
                $id_taxa = $this->order_o_id;
                $type = "order_o";

            }elseif( strtolower($type) == $this->array_header_taxa[3] ){ // family
                $no_of_array_sql = 3;
                $data['name_taxa_select'] = $this->family_name;
                $id_taxa = $this->family_id;

            }elseif( strtolower($type) == $this->array_header_taxa[4] ){ // species
                $no_of_array_sql = 4;
                $data['name_taxa_select'] = $this->species_name;
                $id_taxa = $this->species_id;

            }else{
                $data['name_taxa_select'] = $this->other_taxa_name;
                $id_taxa = $this->other_taxa_id;
            }
            $sql_taxa = " and c.".$type." = '".$id_taxa."'";
        }else{
            $data['name_taxa_select'] = "";
        }

        if( $this->locality !== "" ){
            $locality_type = array_keys($this->locality)[0];
            if($locality_type == "ocean_sea_lake"){
                $sql_locality = " and r.ocean_sea_lake = '".array_values($this->locality)[0]."'";
                $fullname_locality = Wording::find(array_values($this->locality)[0])->name_en;
            }
            if($locality_type == "country"){
                $sql_locality = " and r.country = '".array_values($this->locality)[0]."'";
                $fullname_locality = Country::find(array_values($this->locality)[0])->country_en;

            }
            if($locality_type == "province"){
                $sql_locality = " and r.province = '".array_values($this->locality)[0]."'";
                $fullname_locality = Province::find(array_values($this->locality)[0])->province_en;

            }
            if($locality_type == "district"){
                $sql_locality = " and r.district = '".array_values($this->locality)[0]."'";
                $fullname_locality = District::find(array_values($this->locality)[0])->district_en;

            }
            if($locality_type == "county"){
                $sql_locality = " and r.county = '".array_values($this->locality)[0]."' ";
                $fullname_locality = County::find(array_values($this->locality)[0])->countr_en;

            }
            if($locality_type == "locality"){
                $sql_locality = " and r.locality like '%".array_values($this->locality)[0]."%' ";
                $fullname_locality = array_values($this->locality)[0];

            }
            $data['locality_select'] = [$locality_type, $fullname_locality];
        }else{
            $data['locality_select'] = null;
        }

        if($type == "order_o") $type = "order";
        $data['taxa_select'] = ucfirst($type);

        $data['column_taxa_excel'] = $no_of_array_sql;

        $sql = $this->sql_part1;
        $sql .= $this->sql_for_search[0][0];
        $sql .= $this->sql_part2;
        $sql .= $this->sql_for_search[0][1];
        $sql .= $sql_taxa;
        $sql .= $sql_locality;
        $sql .= " group by c.current_scientific_name";
        $sql .= $this->sql_for_search[0][3];

        $data['results'] = DB::select($sql);
        $data['header_excel'] = "Search_Diverity";

        return view('staff.search_report.report_diversity', $data);
    }


}
