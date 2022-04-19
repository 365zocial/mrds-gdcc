<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/*
*
* สร้างเพื่อให้พี่แก้วใช้ข้อมูล 19 Jan 2022
* เพื่อแสดงว่า record มีี utilization อะไรบ้าง
* มีต้นแบบมาจาก record_cot
*
*/

class ViewRecordDetail4Seeder extends Seeder
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
            CREATE VIEW record_detail4 AS
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
                util.utilization_id,
                IF(util.utilization_id=1,"ความเพลิดเพลิน",
                    IF(util.utilization_id=2,"การค้า",
                        IF(util.utilization_id=3,"ใช้แรงงาน",
                            IF(util.utilization_id=4,"อาหาร",
                                IF(util.utilization_id=5,"ยา",
                                    IF(util.utilization_id=6,"ศึกษาวิจัย",
                                        IF(util.utilization_id=7,"เครื่องนุ่งห่ม",
                                            IF(util.utilization_id=8,"สวยงาม",""
                )))))))) AS utilization_detail
            FROM record_utilizations as util
            LEFT JOIN record as r on util.record_unique_id = r.unique_record
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
            WHERE r.language_id = 1 AND r.status = 2  AND r.approve_status = 1
        ';

        // ใช้คำสั่ง php artisan db:seed --class=ViewRecordDetail4Seeder
        // หรือ copy sql ไปใช้ตรงๆ (ใช้วิธีนี้)

        // SELECT record_unique_id, COUNT(record_unique_id) AS unique_record1
        // FROM record_utilizations
        // GROUP BY record_unique_id
        // HAVING (COUNT(record_unique_id) > 1)

        DB::statement($sql_view);
    }
}
