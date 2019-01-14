<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function getStatNumberPicturePerCenter(){
        $sql = 'SELECT r.marinecenter_id , m.marinecenter_code, COUNT(DISTINCT r.id) AS recordHavePicture,
                COUNT(r.id) AS NoPicture
                FROM picture p, record r, marinecenter m
                WHERE p.unique_record = r.unique_record
                AND m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 1
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id , m.marinecenter_code,count(DISTINCT r.id) AS recordHavePicture,
                COUNT(r.id) AS NoPicture
                FROM picture p, record r, marinecenter m
                WHERE p.unique_record = r.unique_record
                AND m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 2
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id , m.marinecenter_code,count(DISTINCT r.id) AS recordHavePicture,
                COUNT(r.id) AS NoPicture
                FROM picture p, record r, marinecenter m
                WHERE p.unique_record = r.unique_record
                AND m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 3
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id , m.marinecenter_code,count(DISTINCT r.id) AS recordHavePicture,
                COUNT(r.id) AS NoPicture
                FROM picture p, record r, marinecenter m
                WHERE p.unique_record = r.unique_record
                AND m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 4
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id , m.marinecenter_code,count(DISTINCT r.id) AS recordHavePicture,
                COUNT(r.id) AS NoPicture
                FROM picture p, record r, marinecenter m
                WHERE p.unique_record = r.unique_record
                AND m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 5
                AND r.status = 2';
            $results    =   DB::select($sql);

            foreach ($results as $value) {
                echo "ชื่อย่อ ศูนย์ : ".$value->marinecenter_code."<br>";
                echo "จำนวน Record ที่มีรูปประกอบ : ".number_format($value->recordHavePicture)."<br>";
                echo "จำนวนรูปประกอบทั้งหมดของ ศูนย์ : ".number_format($value->NoPicture)."<br>";
                echo "===============================================<br>";
            }
    }

    public function getStatNumberRecordPerCenter(){
        $sql = 'SELECT r.marinecenter_id, m.marinecenter_code, COUNT( r.id ) AS NumberRecord
                FROM record r, marinecenter m
                WHERE m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 1
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id, m.marinecenter_code, COUNT( r.id ) AS NumberRecord
                FROM record r, marinecenter m
                WHERE m.id = r.marinecenter_id
                AND r.language_id =1
                AND r.marinecenter_id =2
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id, m.marinecenter_code, COUNT( r.id ) AS NumberRecord
                FROM record r, marinecenter m
                WHERE m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 3
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id, m.marinecenter_code, COUNT( r.id ) AS NumberRecord
                FROM record r, marinecenter m
                WHERE m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 4
                AND r.status = 2

                UNION
                SELECT r.marinecenter_id, m.marinecenter_code, COUNT( r.id ) AS NumberRecord
                FROM record r, marinecenter m
                WHERE m.id = r.marinecenter_id
                AND r.language_id = 1
                AND r.marinecenter_id = 5
                AND r.status = 2';

        $results    =   DB::select($sql);
        foreach ($results as $value) {
            echo "ชื่อย่อ ศูนย์ : ".$value->marinecenter_code."<br>";
            echo "จำนวน Record ทั้งหมดของศูนย์ : ".number_format($value->NumberRecord)."<br>";
            echo "===============================================<br>";
        }
    }

    public function getStatClassification(){
        $sql        = 'SELECT COUNT(id) AS CountClassification FROM classification';
        $results    =   DB::select($sql);
        echo "จำนวน Classification ทั้งหมดของระบบ : ".number_format($results[0]->CountClassification);
    }

    public function getStatRecord(){
        $sql        = 'SELECT COUNT(id) AS CountRecord FROM record WHERE source IN (1,2) AND language_id = 1 AND status = 2';
        $results    =   DB::select($sql);

        $sql_speciement         = 'SELECT COUNT(*) AS CountRecord_speciement FROM record WHERE source = 1 AND language_id = 1 AND status = 2';
        $results_speciement     =   DB::select($sql_speciement);

        $sql_referrence         = 'SELECT COUNT(*) AS CountRecord_referrence FROM record WHERE source = 2 AND language_id = 1 AND status = 2';
        $results_referrence     =   DB::select($sql_referrence);

        echo "จำนวน Record ทั้งหมดของระบบ : ".number_format($results[0]->CountRecord)."<br>";
        echo "จำนวน Record ประเภท ตัวอย่างที่จับได้ ทั้งหมดของระบบ : ".number_format($results_speciement[0]->CountRecord_speciement)."<br>";
        echo "จำนวน Record ประเภท ตัวอย่างอ้างอิง ทั้งหมดของระบบ : ".number_format($results_referrence[0]->CountRecord_referrence);
    }
}
