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
        if ( count($inputs) > 0 ) {
            $recordNotFound = ''; $records = '';
            $records = [];
            foreach ($inputs as $key => $input) {
                $record = Record::join('classification', 'record.classification_id', '=', 'classification.id')->where('related_catalog_item', $input)->where('language_id', 1)->where('record.status', 2)->first();
                if ( empty($record) ) {
                    if ( $recordNotFound !== '' ) $recordNotFound .= ', ';
                    $recordNotFound .= $input;
                } else $records[] = $record;
            }
            if ( $recordNotFound !== '' ) {
                Session::put('export_failure', 'Your record ID ('.$recordNotFound.') is not found.');
                return redirect('staff/export_label/form');
            }

            $html = '<!DOCTYPE html><html><head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title></title>
                        <style>
                            @font-face {
                                font-family: THSarabun;
                                src: 	url('.public_path().'/assets/fonts/THSarabunNew/THSarabunNew.ttf) ,
                                        url('.public_path().'/assets/fonts/THSarabunNew/THSarabunNewBold.ttf) ,
                                        url('.public_path().'/assets/fonts/THSarabunNew/THSarabunNewBoldItalic.ttf) ,
                                        url('.public_path().'/assets/fonts/THSarabunNew/THSarabunNewItalic.ttf);
                            }
                            @font-face {
                                font-family: Boon;
                                src: 	url('.public_path().'/assets/fonts/ttf/Boon-300.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-300i.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-400.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-400i.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-500.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-500i.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-600.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-600i.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-700.ttf) ,
                                        url('.public_path().'/assets/fonts/ttf/Boon-700i.ttf);
                            }
                            body {
                                font-family: Boon, serif; /* "Helvetica" , THSarabun */
                            }
                            span.label {
                                font-weight: 700;
                                font-family: Boon;
                            }
                            td.label {
                                padding-top: 7px;
                            }
                        </style>
                        </head><body>';
            $html .= '<table class="export_label" style="width: 100%; border-collapse: collapse; border: 1px solid #000;">';

            foreach ($records as $key => $get) {
                $province = \App\Model\Province::find($get->province);
                $collectorDate = '-'; $identifiedDate = '-';
                if ( !empty($province) ) $province = $province->province_en; else $province = '-';
                if ( !empty($get->family) ) $family = Taxonomy::find($get->family)->name; else $family = ' - ';
                if ( $get->collected_date !== '0000-00-00' && !empty($get->collected_date) ) $collectorDate = date('d/m/Y', strtotime($get->collected_date));
                if ( $get->identified_date !== '0000-00-00' && !empty($get->identified_date) ) $identifiedDate = date('d/m/Y', strtotime($get->identified_date));
                if ( $key%2 === 0 ) $html .= '<tr style="border: 1px solid #000;">';
                if ( !empty($get->locality) ) {
                    $locality = $get->locality;
                    if ( strlen($locality) > 25 ) $locality = substr($locality, 0, 25).'...';
                } else $locality = '-';
                $html .= '<td valign="top" style="width: 50%; border: 1px solid #000;">
                            <p class="marinecenter" style="font-size: 12px; font-weight: 900; text-align: center; text-transform: uppercase; margin-top: 5px; margin-bottom: 0px;">Department of Marine and Coastal Resources</p>'.
                            '<table style="width: 100%; border-width: 0px; font-size: 9px;">
                                <tr>
                                    <td class="label" valign="top" style="width:15%;"><span class="label">ID</span></td>
                                    <td valign="top" colspan="3">'.$get->related_catalog_item.'</td>
                                </tr>
                                <tr>
                                    <td class="label" valign="top"><span class="label">Family</span></td>
                                    <td colspan="3">'.$family.'</td>
                                </tr>
                                <tr>
                                    <td class="label" valign="top"><span class="label">Species</span></td>
                                    <td colspan="3" valign="top" height="30px" style="line-height: 9px;">'.$get->current_scientific_name_format.'</td>
                                </tr>
                                <tr>
                                    <td class="label" valign="top"><span class="label">Locality<br><br>Province<br><br>Identifier</span></td>
                                    <td valign="top" width="55%" height="30px" style="line-height: 11.7px;">'.$locality.'<br>'.$province.'<br>'.$get->identifier.'</td>
                                    <td class="label" valign="top" width="10%"><span class="label">Date<br><br>&nbsp;<br><br>Date</span></td>
                                    <td valign="top" width="20%" style="line-height: 11.7px;">'.$collectorDate.'<br>&nbsp;<br>'.$identifiedDate.'</td>
                                </tr>
                            </table>'.
                        '</td>';
                        // <tr>
                        //     <td class="label" valign="top"><span class="label">Identifier</span></td>
                        //     <td valign="top">'.$get->identifier.'</td>
                        //     <td class="label" valign="top"><span class="label">Date</span></td>
                        //     <td valign="top">'.$identifiedDate.'</td>
                        // </tr>
                if ( ($key+1)%2 === 0 ) $html .= '</tr>';
            }
            if ( $key%2 === 0 ) $html .= '<td></td></tr>';

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
