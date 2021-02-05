<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Record;
use App\Model\Marinecenter;
use App\Model\Wording;
use App\Model\Taxonomy;

use PDF;

use Session;

class ExportLabelController extends Controller
{
    public function form()
    {
        return view('staff.export_label.form');
    }

    public function export(Request $requests)
    {
        $inputs = $requests->all();
        unset($inputs['_token']);
        $inputs = array_filter($inputs['record_id']);
        if (count($inputs) > 0) {
            $recordNotFound = '';
            $records = '';
            $records = [];
            foreach ($inputs as $key => $input) {
                $record = Record::join('classification', 'record.classification_id', '=', 'classification.id')->where('related_catalog_item', $input)->where('language_id', 1)->where('record.status', 2)->first();
                if (empty($record)) {
                    if ($recordNotFound !== '') $recordNotFound .= ', ';
                    $recordNotFound .= $input;
                } else $records[] = $record;
            }
            if ($recordNotFound !== '') {
                Session::put('export_failure', 'Your record ID (' . $recordNotFound . ') is not found.');
                return redirect('staff/export_label/form');
            }

            $html = '<!DOCTYPE html><html><head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title></title>
                        <style>
                            @font-face {
                                font-family: THSarabun;
                                src: 	url(' . public_path() . '/assets/fonts/THSarabunNew/THSarabunNew.ttf) ,
                                        url(' . public_path() . '/assets/fonts/THSarabunNew/THSarabunNewBold.ttf) ,
                                        url(' . public_path() . '/assets/fonts/THSarabunNew/THSarabunNewBoldItalic.ttf) ,
                                        url(' . public_path() . '/assets/fonts/THSarabunNew/THSarabunNewItalic.ttf);
                            }
                            @font-face {
                                font-family: Boon;
                                src: 	url(' . public_path() . '/assets/fonts/ttf/Boon-300.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-300i.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-400.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-400i.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-500.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-500i.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-600.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-600i.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-700.ttf) ,
                                        url(' . public_path() . '/assets/fonts/ttf/Boon-700i.ttf);
                            }
                            body {
                                font-family: sans-serif; /* "Helvetica" , THSarabun */
                            }
                            span.label {
                                font-family: serif;
                                font-weight: bolder;
                                display: inline-block;
                                padding-left: 10px;
                            }
                            table { 
                                border-spacing: 0px;
                            }
                            td { 
                                border-spacing: 0px;
                                padding: 0px 3px;
                                margin: 0px;
                                vertical-align: top;
                                font-weight: normal;
                                font-size: 14px;
                                line-height: 25px;
                            }
                           

                            
                        </style>
                        </head><body>';
            $html .= '<table class="export_label" style="width: 100%; border-collapse: collapse; border: 1px solid #000;">';

            foreach ($records as $key => $get) {
                $province = \App\Model\Province::find($get->province);
                $collectorDate = '-';
                $identifiedDate = '-';
                if (!empty($province)) $province = $province->province_en;
                else $province = '-';
                if (!empty($get->family)) $family = Taxonomy::find($get->family)->name;
                else $family = ' - ';
                if ($get->collected_date !== '0000-00-00' && !empty($get->collected_date)) $collectorDate = date('d/m/Y', strtotime($get->collected_date));
                if ($get->identified_date !== '0000-00-00' && !empty($get->identified_date)) $identifiedDate = date('d/m/Y', strtotime($get->identified_date));
                if ($key % 2 === 0) $html .= '<tr style="border: 1px solid #000;">';
                if (!empty($get->locality)) {
                    $locality = $get->locality;
                    if (strlen($locality) > 22) $locality = substr($locality, 0, 22) . '...';
                } else $locality = '-';
                $html .= '<td style="width: 50%; border: 1px solid #000;">';
                $html .= '<p class="marinecenter" style="font-size: 18px; font-weight: 900; text-align: center; text-transform: uppercase; margin-top: 5px; margin-bottom: 0px;">Department of Marine and Coastal Resources</p>';
                $html .= '<table class="export_data" style="width: 100%; border-width: 1px; >
                                
                                <tr>
                                <td colspan="4">
                                <table width="100%">
                                <tr>
                                    <td style="width:15%;"><span class="label">ID</span></td>
                                    <td colspan="3" style="padding:0;">' . $get->related_catalog_item . '</td>
                                </tr>
                                <tr>
                                    <td ><span class="label">Family</span></td>
                                    <td colspan="3" >' . $family . '</td>
                                </tr>
                                <tr>
                                    <td ><span class="label">Species</span></td>
                                    <td colspan="3" style="height: 50px" >' . $get->current_scientific_name_format . '</td>
                                </tr>
                                <tr>
                                    <td><span class="label">Locality</span></td>
                                    <td colspan="3">' . $locality . '</td>
                                    
                                </tr>
                                <tr>
                                    <td><span class="label">Province</span></td>
                                    <td >' . $province . '</td>
                                    <td width="10%"><span class="label">Date</span></td>
                                    <td width="25%" >' . $collectorDate . '</td>
                                    
                                </tr>
                                <tr>
                                    <td ><span class="label">Identifier</span></td>
                                    <td >' . $collectorDate . '</td>
                                    <td width="10%"><span class="label">Date</span></td>
                                    <td width="25%">' . $identifiedDate . '</td>
                                </tr>
                                <tr><td style="line-height: 7px;">&nbsp;</td></tr>
                                </table>
                                </td>
                                </tr>
                            </table>' .
                    '</td>';
                // <tr>
                //     <td clas <span class="label">Identifier</span></td>
                //     <td>'.$get->identifier.'</td>
                //     <td clas <span class="label">Date</span></td>
                //     <td>'.$identifiedDate.'</td>
                // </tr>
                if (($key + 1) % 2 === 0) $html .= '</tr>';
            }
            if ($key % 2 === 0) $html .= '<td></td></tr>';

            $html .= '</table>';
            $html .= '</body></html>';

            $pdf = \App::make('dompdf.wrapper');
            $pdf->setPaper('a4', 'portrait');
            $pdf->loadHTML($html, 'UTF-8');
            return $pdf->stream();
        } else {
            Session::put('export_failure', 'Empty Data.');
            return redirect('staff/export_label/form');
        }
    }
}
