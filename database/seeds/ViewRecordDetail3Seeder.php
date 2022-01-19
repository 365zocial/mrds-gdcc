<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/*
*
* สร้างเพื่อให้พี่แก้วใช้ข้อมูล 19 Jan 2022
* เพื่อแสดงว่า record มีภาพอะไรบ้าง
*
*/

class ViewRecordDetail3Seeder extends Seeder
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
            CREATE VIEW record_detail3 AS
            SELECT
                r.unique_record,
                institution.institution_th,
                marinecenter.marinecenter_th,
                r.related_catalog_item,
                r.related_reference_item,
                c.current_scientific_name,
                t5.name AS phylum,
                t6.name AS subphylum,
                t7.name AS infraphylum,
                t8.name AS superclass,
                t9.name AS class,
                t10.name AS subclass,
                t11.name AS infraclass,
                t12.name AS superorder,
                t13.name AS order_o,
                t14.name AS suborder,
                t15.name AS infraorder,
                t16.name AS superfamily,
                t17.name AS family,
                t18.name AS subfamily,
                t19.name AS genus,
                CONCAT("http://mrds.dmcr.go.th/uploads/images/", p.path_pic) as path_pic
            FROM picture as p
            LEFT JOIN record as r on p.unique_record = r.unique_record
            LEFT JOIN classification as c on r.classification_id = c.id
            LEFT JOIN marinecenter as marinecenter on r.marinecenter_id = marinecenter.id
            LEFT JOIN institution as institution on marinecenter.institution_id = institution.id
            LEFT JOIN taxonomy AS t1 ON c.domain = t1.id
            LEFT JOIN taxonomy AS t2 ON c.kingdom = t2.id
            LEFT JOIN taxonomy AS t3 ON c.subkingdom = t3.id
            LEFT JOIN taxonomy AS t4 ON c.infrakingdom = t4.id
            LEFT JOIN taxonomy AS t5 ON c.phylum = t5.id
            LEFT JOIN taxonomy AS t6 ON c.subphylum = t6.id
            LEFT JOIN taxonomy AS t7 ON c.infraphylum = t7.id
            LEFT JOIN taxonomy AS t8 ON c.superclass = t8.id
            LEFT JOIN taxonomy AS t9 ON c.class = t9.id
            LEFT JOIN taxonomy AS t10 ON c.subclass = t10.id
            LEFT JOIN taxonomy AS t11 ON c.infraclass = t11.id
            LEFT JOIN taxonomy AS t12 ON c.superorder = t12.id
            LEFT JOIN taxonomy AS t13 ON c.order_o = t13.id
            LEFT JOIN taxonomy AS t14 ON c.suborder = t14.id
            LEFT JOIN taxonomy AS t15 ON c.infraorder = t15.id
            LEFT JOIN taxonomy AS t16 ON c.superfamily = t16.id
            LEFT JOIN taxonomy AS t17 ON c.family = t17.id
            LEFT JOIN taxonomy AS t18 ON c.subfamily = t18.id
            LEFT JOIN taxonomy AS t19 ON c.genus = t19.id
            LEFT JOIN taxonomy AS t20 ON c.subgenus = t20.id
            LEFT JOIN taxonomy AS t21 ON c.species = t21.id
            LEFT JOIN taxonomy AS t22 ON c.subspecies = t22.id
            WHERE r.language_id = 1 AND r.status = 2  AND r.approve_status = 1
        ';

        // ใช้คำสั่ง php artisan db:seed --class=ViewRecordDetail3Seeder
        // หรือ copy sql ไปใช้ตรงๆ (ใช้วิธีนี้)

        DB::statement($sql_view);
    }
}
