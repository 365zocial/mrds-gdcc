<?php

use Illuminate\Database\Seeder;

class ViewRecordCOTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('Drop View IF EXISTS transactions');

        $sql_view = '
            CREATE VIEW record_cot AS
            SELECT
                r.unique_record,
                institution.institution_th,
                marinecenter.marinecenter_th,
                r.related_catalog_item,
                r.related_reference_item,
                c.current_scientific_name,
                t5.name AS phylum,
                t6.name AS subphylum,
                t9.name AS class,
                t13.name AS order_o,
                t17.name AS family,
                t19.name AS genus,
                c.common_name,
                w_type_status.name_en AS type_status,
                w_ocean_sea_lake.name_th AS ocean_sea_lake,
                province.province_th AS province,
                country.country_th AS country,
                w_habitat.name_th AS habitat,
                r.collector,
                r.collected_date,
                w_living.name_th AS living,
                w_protection_thai_law.name_th AS protection_thai_law,
                w_thai_red_list.name_th AS protection_thai_red_list,
                w_protection_iucn_2019.name_th AS protection_iucn_2019,
                w_protection_cites.name_th AS protection_cites,
                w_economic_value.name_th AS economic_value,
                w_area_exploration.name_th AS area_exploration,
                w_expedition.name_th AS expedition,
                r.islands_island,
                r.gene_bank_number,
                r.local_name,
                r.folk_wisdom,
                r.recorder,
                r.knowledge_remarks,
                r.individual_count,
                r.locality,
                r.depth_start,
                r.depth_end,
                r.village_no
            FROM record as r
            LEFT JOIN classification as c on r.classification_id = c.id
            LEFT JOIN marinecenter as marinecenter on r.marinecenter_id = marinecenter.id
            LEFT JOIN institution as institution on marinecenter.institution_id = institution.id
            LEFT JOIN taxonomy AS t1 ON c.domain = t1.id
            LEFT JOIN taxonomy AS t2 ON c.kingdom = t2.id
            LEFT JOIN taxonomy AS t3 ON c.subkingdom = t3.id
            LEFT JOIN taxonomy AS t4 ON c.infrakingdom = t4.id
            LEFT JOIN taxonomy AS t5 ON c.phylum = t5.id
            LEFT JOIN taxonomy AS t6 ON c.subphylum = t6.id
            LEFT JOIN taxonomy AS t9 ON c.class = t9.id
            LEFT JOIN taxonomy AS t13 ON c.order_o = t13.id
            LEFT JOIN taxonomy AS t17 ON c.family = t17.id
            LEFT JOIN taxonomy AS t19 ON c.genus = t19.id
            LEFT JOIN taxonomy AS t20 ON c.subgenus = t20.id
            LEFT JOIN taxonomy AS t21 ON c.species = t21.id
            LEFT JOIN taxonomy AS t22 ON c.subspecies = t22.id
            LEFT JOIN wording AS w_type_status ON r.type_status = w_type_status.id
            LEFT JOIN wording AS w_ocean_sea_lake ON r.ocean_sea_lake = w_ocean_sea_lake.id
            LEFT JOIN province AS province ON r.province = province.id
            LEFT JOIN country AS country ON r.country = country.id
            LEFT JOIN wording AS w_habitat ON r.habitat = w_habitat.id
            LEFT JOIN wording as w_living ON c.living = w_living.id
            LEFT JOIN wording AS w_protection_thai_law ON c.protection_thai_law = w_protection_thai_law.id
            LEFT JOIN wording AS w_thai_red_list ON c.thai_red_list = w_thai_red_list.id
            LEFT JOIN wording AS w_protection_iucn_2019 ON c.protection_iucn_2019 = w_protection_iucn_2019.id
            LEFT JOIN wording AS w_protection_cites ON c.protection_cites = w_protection_cites.id
            LEFT JOIN wording AS w_area_exploration ON r.area_exploration = w_area_exploration.id
            LEFT JOIN wording AS w_economic_value ON r.economic_value = w_economic_value.id
            LEFT JOIN wording AS w_expedition ON r.expedition = w_expedition.id
            WHERE r.language_id = 1 AND r.status = 2  AND r.approve_status = 1
        ';

        // php artisan db:seed --class=ViewRecordCOTSeeder

        DB::statement($sql_view);
    }
}
