<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record', function (Blueprint $table) {
            $table->increments('id')->comment('ID ของ Record');
            $table->integer('unique_record')->comment('ใช้สร้างความแตกต่างในแต่ละ record เพื่อที่จะสามารถดึง record ตอน search ได้');
            $table->integer('classification_id')->comment('ID ของ Classification, FK: classification table');
            $table->integer('language_id')->comment('ID ของภาษาที่ใช้อ้างอิงภาษาของ Record นั้น ๆ, FK: language table');
            $table->integer('marinecenter_id')->comment('เพื่อนำ marinecenter_code มาแสดง, FK: marinecenter table');
            $table->integer('collection_code')->comment('สัญลักษณ์ หรือ ตัวอักษรย่อ ที่แสดงถึง taxonomy, FK: collection table');
            $table->integer('catalog_number')->nullable()->comment('หมายเลขไว้อ้างอิงกับ Record (Specimens) โดยนับแต่ละ Marine Center // ไม่ว่างเมื่อเก็บเป็นตัวอย่างที่จับต้องได้');
            $table->string('related_catalog_item', 255)->nullable()->comment('Marinecenter_code+ source + collection_code + catalog_number // ไม่ว่างเมื่อเก็บเป็นตัวอย่างที่จับต้องได้');
            $table->tinyInteger('source')->comment('เลือกว่าเป็นตัวอย่างหรือเอกสาร // 1 = specimen, 2 = reference');
            $table->integer('reference')->nullable()->comment('เอกสารที่ต้องการอ้างอิง, FK:  reference table // ไม่ว่างเมื่อเก็บเป็นเอกสาร');
            $table->integer('page')->nullable()->comment('หน้าเอกสารที่เริ่มต้น ใช้เป็นคีย์ในการค้นหา // ไม่ว่างเมื่อเก็บเป็นเอกสาร');
            $table->integer('no_species')->comment('หมายเลขไว้อ้างอิงกับ Record (Publication) ซึ่งเป็นลำดับที่ของสิ่งมีชีวิตในหน้านั้น // ไม่ว่างเมื่อเก็บเป็นเอกสาร');
            $table->integer('no_locality')->nullable()->comment('หมายเลขไว้อ้างอิงกับ Record (Publication) ซึ่งเป็นลำดับที่ค้นพบสิ่งมีชีวิตของสิ่งมีชีวิตในหน้านั้นที่ต่างกัน // ไม่ว่างเมื่อเก็บเป็นเอกสาร');
            $table->text('related_reference_item')->nullable()->comment('Marinecenter_code + source + collection_code + reference + page + no_species + no_locality // ไม่ว่างเมื่อเก็บเป็นเอกสาร'); // marince_code + collection_code + reference + page + no_species + no_locality
            $table->string('individual_count', 255)->nullable()->comment('จำนวน Record ที่เก็บมา');
            $table->string('latitude', 255)->nullable()->comment('ค่า latitude เป็น decimal degrees');
            $table->string('verbatim_latitude', 255)->nullable()->comment('ค่า latitude แสดงค่าพิกัดภูมิศาสตร์ในหน่วยแบบที่เรียกว่า องศา ลิปดา ฟิลิปดา // DMS : Degrees Minutes Seconds');
            $table->string('start_latitude', 255)->nullable()->comment('ค่าเริ่มต้นของ latitude เป็น decimal degrees');
            $table->string('end_latitude', 255)->nullable()->comment('ค่าสิ้นสุดของ latitude เป็น decimal degrees');
            $table->string('longitude', 255)->nullable()->comment('ค่า longitude เป็น decimal degrees');
            $table->string('verbatim_longitude', 255)->nullable()->comment('ค่า longitude แสดงค่าพิกัดภูมิศาสตร์ในหน่วยแบบที่เรียกว่า องศา ลิปดา ฟิลิปดา // DMS : Degrees Minutes Seconds');
            $table->string('start_longitude', 255)->nullable()->comment('ค่าเริ่มต้นของ longitude เป็น decimal degrees');
            $table->string('end_longitude', 255)->nullable()->comment('ค่าสิ้นสุดของ longitude เป็น decimal degrees');
            $table->integer('country')->comment('ประเทศ, FK: country table');
            $table->integer('province')->nullable()->comment('จังหวัด, FK: province table');
            $table->integer('district')->nullable()->comment('เขต/อำเภอ, FK: district table');
            $table->integer('county')->nullable()->comment('ตำบล, FK: county table');
            $table->text('locality')->nullable()->comment('ลักษณะของสถานที่ที่เก็บ Record มาได้');
            $table->integer('ocean_sea_lake')->nullable()->comment('มหาสมุทร/ทะเล/ทะเลสาบ, FK: wording table');
            $table->text('islands_island')->nullable()->comment('หมู่เกาะ, เกาะ');
            $table->integer('habitat')->nullable()->comment('ลักษณะของสถานที่ที่ Record อาศัย เช่น หาดหิน, หาดทราย, หาดโคลน, ป่าชายเลน, แนวหญ้าทะเล, แนวปะการัง, ปากแม่น้ำ, พื้นทะเล, น้ำทะเล และ ทะเลลึก, FK: wording table');
            $table->integer('sediment_type')->nullable()->comment('ประเภทของดินตะกอน, FK: wording table');
            $table->integer('type_status')->nullable()->comment('ประเภทของตัวอย่างต้นแบบชนิดใหม่ของโลก, FK: wording table // 1 = Holotype, 2 = Paratype, 3 = Neotype, 4 = Allotype');
            $table->integer('sex')->nullable()->comment('เพศของ Record ที่เก็บมา, FK: wording table // 1 = Male, 2 = Female, 3 = Hermaphrodite, 4 = Indeterminate, 5 = Unknown, 6 = Transitional, 7 = Imposex');
            $table->string('size', 255)->nullable()->comment('ขนาดของ Record ทีเก็บมา');
            $table->integer('life_stage')->nullable()->comment('ช่วงชีวิต (Life Cycle) ของ Record ที่เก็บมา, FK: wording table // 1 = Juvenile, 2 = Adult');
            $table->integer('donated_from')->nullable()->comment('หน่วยงานที่บริจาค Record นั้นๆ, FK: wording table');
            $table->integer('deposited_at')->nullable()->comment('หน่วยงานที่รับ Record นั้นๆ, FK: wording table');
            $table->integer('gear_method')->nullable()->comment('ใช้วิธีอะไรในการเก็บมา, FK: wording table');
            $table->string('depth_start', 255)->nullable()->comment('ความลึกเริ่มต้นที่พบเจอ Record');
            $table->string('depth_end', 255)->nullable()->comment('ความลึกสุดท้ายที่พบเจอ');
            $table->string('collector', 255)->nullable()->comment('ใครเป็นผู้รวบรวม');
            $table->date('collected_date')->nullable()->comment('วัน/เดือน/ปี ที่รวบรวม');
            $table->string('collected_year', 4)->nullable()->comment('ปีที่รวบรวม');
            $table->string('collected_month', 2)->nullable()->comment('เดือนที่รวบรวม');
            $table->string('collected_day', 2)->nullable()->comment('วันที่รวบรวม');
            $table->string('identifier', 255)->nullable()->comment('ใครเป็นผู้ระบุ');
            $table->date('identified_date')->nullable()->comment('วัน/เดือน/ปี ที่ระบุ');
            $table->string('identified_year', 4)->nullable()->comment('ปีที่ระบุ');
            $table->string('identified_month', 2)->nullable()->comment('เดือนที่ระบุ');
            $table->string('identified_day', 2)->nullable()->comment('วันที่ระบุ');
            $table->string('previous_identifier', 255)->nullable()->comment('ผู้ระบุก่อนหน้านี้');
            $table->date('previous_identified_date')->nullable()->comment('วัน/เดือน/ปี ที่ระบุก่อนหน้านี้');
            $table->text('note_collector')->nullable()->comment('คำอธิบายจาก ผู้รวบรวม');
            $table->integer('expedition')->nullable()->comment('โครงการที่ออกไปสำรวจ, FK: wording table');
            $table->integer('preparation_type')->nullable()->comment('วิธีการเก็บ Record, FK: wording table');
            $table->string('gene_bank_number', 255)->nullable()->comment('หมายเลขทะเบียนใน Gene Bank');
            $table->text('local_name')->nullable()->comment('ชื่อพื้นเมือง Local');
            $table->text('vernacular_name')->nullable()->comment('ชื่อท้องถิ่น (ชื่อพื้นบ้าน)');
            // $table->text('common_name')->nullable()->comment('ชื่อสามัญ // (ไม่ได้ใช้งานในระบบแล้ว)');
            $table->text('variety_name')->nullable()->comment('Variety Name');
            $table->text('diagnosis')->nullable()->comment('คุณลักษณะเด่น');
            $table->text('description')->nullable()->comment('คุณลักษณะอื่นๆ');
            $table->integer('team_exploration_code')->nullable()->comment('รหัสทีมสำรวจ, FK: wording table // Form Thai ห้ามว่าง, ชื่อย่อศูนย์-ปีงบประมาณที่สำรวจ');
            $table->integer('area_exploration')->nullable()->comment('พื้นที่สำรวจ ชื่อ อบต./เทศบาล');  // not null
            $table->integer('village_no')->nullable()->comment('เลขที่หมู่บ้าน หมู่ 1,2,3');
            $table->integer('area_direction')->nullable()->comment('บอกทิศ, FK: wording table // 1 = N, 2 = NE, 3 = NW, 4 = E, 5 = S, 6 = SE, 7 = SW, 8 = W');
            $table->text('area')->nullable()->comment('ของสถานที่ (ภูเขา/แม่น้ำ/โบราณสถาน ฯลฯ)');
            $table->text('folk_wisdom')->nullable()->comment('ภูมิปัญญาชาวบ้าน');
            $table->string('recorder', 255)->nullable()->comment('ผู้ให้ข้อมูลเกี่ยวกับภูมิปัญญาชาวบ้าน // Form ภาษาไทย');
            $table->text('knowledge_remarks')->nullable()->comment('รายละเอียดของภูมิปัญญา');
            // $table->string('soil_temperature', 255)->nullable()->comment('อุณหภูมิดิน หน่วยองศาเซลเซียส // (ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->text('soil_character')->nullable()->comment('ลักษณะของดิน // (ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->string('soil_ph', 255)->nullable()->comment('ความเป็น กรดด่าง ของดิน // (ไม่ได้ใช้งานในระบบแล้ว)');
            $table->string('water_temperature', 255)->nullable()->comment('อุณหภูมิน้ำ หน่วยองศาเซลเซียส');
            $table->string('transparency', 255)->nullable()->comment('ความโปรงแสงของน้ำ');
            $table->string('water_ph', 255)->nullable()->comment('ความเป็น กรดด่าง ของน้ำ');
            $table->string('dissolve_oxygen', 255)->nullable()->comment('ปริมาณ ออกซิเจนละลายน้ำ');
            $table->string('suspended_solid', 255)->nullable()->comment('ปริมาณของแข็งแขวนลอย');
            $table->string('salinity', 255)->nullable()->comment('ค่าความเค็ม');
            $table->tinyInteger('specimen_collection')->nullable()->comment('เก็บตัวอย่างที่แตะต้องได้ เป็น checkbox // 0 = ไม่ใช่, 1 = ใช่');
            $table->tinyInteger('specimen_photograph')->nullable()->comment('เก็บตัวอย่างเป็นเอกสาร เป็น checkbox // 0 = ไม่ใช่, 1 = ใช่');
            // $table->integer('sighting_no')->nullable()->comment('จำนวนที่พบเห็น (ไม่ได้เก็บตัวอย่าง) // (ไม่ได้ใช้งานในระบบแล้ว)');
            $table->text('exploration_remark')->nullable()->comment('หมายเหตุของข้อมูลการสำรวจ');
            // $table->time('sighting_time')->comment('เวลาที่พบ // (ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->text('food')->nullable()->comment('อาหาร // (ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->tinyInteger('water_place')->nullable()->comment('(ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->tinyInteger('tree_place')->nullable()->comment('(ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->tinyInteger('soil_earth_place')->nullable()->comment('(ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->tinyInteger('ground_earth_place')->nullable()->comment('(ไม่ได้ใช้งานในระบบแล้ว)');
            // $table->tinyInteger('coast_place')->nullable()->comment('(ไม่ได้ใช้งานในระบบแล้ว)');
            $table->tinyInteger('solo_living')->nullable()->comment('อยู่ตัวเดียว // 0 = ไม่ใช่, 1 = ใช่');
            $table->tinyInteger('group_living')->nullable()->comment('อยู่เป็นกลุ่ม // 0 = ไม่ใช่, 1 = ใช่');
            $table->tinyInteger('animal_type1')->nullable()->comment('บอกว่าเป็นสัตรว์บกหรือสัตว์น้ำ, FK: wording table');
            $table->tinyInteger('animal_type2')->nullable()->comment('บอกประเภทจากกระดูกสันหลัง, FK: wording table');
            $table->tinyInteger('animal_type3')->nullable()->comment('สัตว์ปีก/สัตว์เลื้อยคลาน/สัตว์สะเทิ้นน้ำสะเทิ้นบก/สัตว์เลี้ยงลูกด้วยนม/สัตว์ทะเล, FK: wording table');
            $table->integer('economic_value')->nullable()->comment('คุณค่าทางเศรษฐกิจ, FK: wording table // มี, ไม่มี,ไม่แน่ใจ');
            // $table->integer('protection_type')->nullable()->comment('บอกการคุ้มครอง, FK: wording table // (ไม่ได้ใช้งานในระบบแล้ว)');
            $table->string('reproduction', 10)->nullable()->comment('แบบอาศัยเพศ, แบบไม่อาศัยเพศ // 0 = ไม่ได้เลือก, 1 = อาศัยเพศ, 2 = ไม่อาศัยเพศ, 3 = อาศัยเพศและไม่อาศัยเพศ');
            $table->tinyInteger('plant_type')->comment('ประเภทของพืช, FK: wording table // 0 = ไม่ได้เลือก, 1 = สาหร่าย, 2 = หญ้าทะเล');
            $table->text('picture_name')->nullable()->comment('แผ่น cd อ้างอิง');
            $table->text('picture_remark')->nullable()->comment('หมายเหตุรูปภาพ');
            $table->boolean('migration_data')->default(false)->comment('เป็นตัวบอกว่า Record เป็นข้อมูลใหม่ที่กรอกผ่านเว็บ หรือเป็นข้อมูลที่เกิดจาก migrate // 1 = migrate 0 = ข้อมูลใหม่');
            $table->date('migration_old_created_date')->nullable()->comment('วัน/เดือน/ปี ที่สร้างหรือแก้ไขข้อมูลล่าสุดในระบบเก่า (สำหรับข้อมูลที่เกิดจากการ migrate หลังวันที่ 5 Aug 2019)');
            $table->boolean('approve_status')->default(false)->comment('บอกสถานะว่าผ่านการ approve มาหรือยัง // 1 = approve แล้ว, 0 = ยังไม่ approve');
            $table->string('approve_by', 255)->nullable()->comment('เก็บ User ที่ approve, FK: users table');
            $table->tinyInteger('status')->comment('สถานะที่ต้องการจะให้ปรากฏในระบบหรือไม่ // 2 = Enable, 1 = Disable');
            $table->integer('created_by')->unsigned()->comment('ใครเป็นผู้บันทึก, FK: users table');
            $table->integer('updated_by')->unsigned()->comment('ใครเป็นผู้แก้ไข, FK: users table');
            $table->timestamps();   // updated_at เวลาอาจจะต่ำกว่า created_at เพราะมีการอ้างอิงจาก migration_old_created_date
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('record');
    }
}
