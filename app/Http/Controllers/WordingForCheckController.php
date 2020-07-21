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
        $word_id = 1;   // 1=Male, 2=Female, 3=Hermaphrodite, 4=Indeterminate, 5=Unknown, 6=Transitional, 7=Imposex

        $for_disable = 1; // 0 คือ ไม่ทำงาน, 1 คือ ทำการแก้ไขข้อมูล
        for( $i = $start_id; $i <= $end_id; $i++) {
            $result = Record::where('id', $i)->where('sex', $word_id)->first();

            if( $result ) {
                // ถ้ามีข้อมูล ให้ทำการสร้าง data ใน table ใหม่
                echo "***".$i.

                if( $for_disable == 1 ) {
                    // รอ DB
                    $data = new RecordSex;
                    $data->name = $result->unique_record;
                    $data->sex_id = $result->sex;
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
        echo "Word ID = ".$word_id;
    }

}
