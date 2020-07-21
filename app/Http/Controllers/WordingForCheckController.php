<?php



namespace App\Http\Controllers;

use App\Model\Record;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;
use App\Model\RecordSex;

use Illuminate\Http\Request;

class WordingForCheckController extends Controller
{
    /*
    *
    *   Function นี้จัดทำขึ้นมาเพื่อใช้ตรวจสอบคำของ ประเทศ, จังหวัด, อำเภอ และตำบล
    *   หากมีคำไหนที่ไม่ได้ใช้ ให้ทำการ disable คำนั้น
    *
    */
    public function disableWording()
    {
        $start_id = 7001;  // ค่าของ id เริ่มต้นที่ต้องการค้นหา
        $end_id = 7377;    // ค่าของ id สุดท้ายที่จะทำการค้นหา (ระบบจะค้นหาเป็นช่วงของ start_id จนถึง end_id)
        // ให้ทำทีละ 200 คำ โดยอย่าลืมแก้ code 4 จุด ว่าจะแก้อะไร

        $for_disable = 1; // 0 คือ ไม่ทำงาน, 1 คือ ทำการแก้ไขข้อมูล
        for( $i = $start_id; $i <= $end_id; $i++) {

            // *** แก้จุดที่ 1
            // $result = Record::where('country', $i)->first();
            // $result = Record::where('province', $i)->first();
            // $result = Record::where('district', $i)->first();
            $result = Record::where('county', $i)->first();

            if( $result ) {
                // ถ้ามีคำนี้ ไม่ต้องทำอะไร

                // *** แก้จุดที่ 2
                // echo $i."-".Country::select('country_en')->where('id', $i)->first();
                // echo $i."-".Province::select('province_en')->where('id', $i)->first();
                // echo $i."-".District::select('district_en')->where('id', $i)->first();
                echo $i."-".County::select('county_en')->where('id', $i)->first();

                echo "<br>";
            } else {
                // ถ้าคำนี้ไม่เคยใช้ ให้ทำการ disable คำ

                // *** แก้จุดที่ 3
                // echo "*** ".$i." - ".Country::select('country_en')->where('id', $i)->first();
                // echo "*** ".$i." - ".Province::select('province_en')->where('id', $i)->first();
                // echo "*** ".$i." - ".District::select('district_en')->where('id', $i)->first();
                echo "*** ".$i." - ".County::select('county_en')->where('id', $i)->first();

                if( $for_disable == 1 ) {

                    // *** แก้จุดที่ 4
                    // $data = Country::find( $i );
                    // $data = Province::find( $i );
                    // $data = District::find( $i );
                    $data = County::find( $i );
                    $data->status = 1;  // disable
                    $data->save();

                    echo "- Disable complete";
                }
                echo "<br>";
            }
        }
        echo "<br><br>'disableWording' is Complete id:".$start_id." - ".$end_id;
    }

    /*
    *
    *   Function นี้จัดทำขึ้นมาเพื่อใช้ย้ายคำของ Sex Field
    *   จากประเภท downdrop เป็น checkbox
    *
    */
    public function changeTypeSexField()
    {
        $start_id = 1;  // ค่าของ id เริ่มต้นที่ต้องการค้นหา
        $end_id = 10000;    // ค่าของ id สุดท้ายที่จะทำการค้นหา (ระบบจะค้นหาเป็นช่วงของ start_id จนถึง end_id)

        $old_word_id = 8;
        $new_word_id = 1;
        /*
                            old             new
        Male =              8               1
        Female =            9               2
        Hermaphrodite =     10              3
        Indeterminate =     11              4
        Unknown =           12              5
        Transitional =      13              6
        Imposex =           14              7
        */
        $for_disable = 0; // 0 คือ ไม่ทำงาน, 1 คือ ทำการแก้ไขข้อมูล
        for( $i = $start_id; $i <= $end_id; $i++) {
            $result = Record::where('id', $i)->where('sex', $old_word_id)->first();

            if( $result ) {
                // ถ้ามีข้อมูล ให้ทำการสร้าง data ใน table ใหม่
                echo "***".$result->id." - ".$result->related_catalog_item;

                if( $for_disable == 1 ) {
                    // รอ DB
                    $data = new RecordSex;
                    $data->record_unique_id = $result->unique_record;
                    $data->sex_id = $new_word_id;
                    $sdata->save();
                    echo " - save complete";
                }
                echo "<br>";
            } else {
                // ถ้าไม่เจอ ไม่ต้องทำอะไร
                echo $i;

                echo "<br>";
            }
        }
        echo "<br><br>'changeTypeSexField' is Complete id:".$start_id." - ".$end_id;
        echo "<br>";
        echo "Old Word ID = ".$old_word_id." /// New Word ID = ".$new_word_id;
    }

}
