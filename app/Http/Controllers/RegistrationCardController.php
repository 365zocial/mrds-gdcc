<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Model\Record;
use App\Model\Marinecenter;
use App\Model\Taxonomy;
use App\Model\Wording;
use App\Model\Province;
use App\Model\Country;

use PDF;
use DB;

class RegistrationCardController extends Controller
{
    public function viewRegisterCard($id)
    {
        $record = Record::join('classification', 'record.classification_id', '=', 'classification.id')->where('record.id', base64_decode(base64_decode(base64_decode($id))))->where('record.status', 2)->first();

        $relatedCatalogItem = $record->related_catalog_item;
        $phylum = Taxonomy::find($record->phylum)->name;
        $class = Taxonomy::find($record->class)->name;
        $order = Taxonomy::find($record->order_o)->name;
        $family = Taxonomy::find($record->family)->name;
        $institution = DB::table('institution')->where('status', 2)->first()->department_code.' : '.Marinecenter::find($record->marinecenter_id)->marinecenter_code;
        $marineCenterCode = Marinecenter::find($record->marinecenter_id)->marinecenter;
        $previousScientificName = ' - ';
        if ( !empty($record->previous_scientific_name_format) ) $previousScientificName = $record->previous_scientific_name_format;
        $species = $record->current_scientific_name_format;
        $type = ' - ';
        if ( !empty($record->type_status) ) { if ( $record->type_status !== 0 ) $type = Wording::find($record->type_status)->name_en; }
        $individualCount = ' - ';
        if ( !empty($record->individual_count) ) $individualCount = $record->individual_count;
        $habitat = ' - ';
        if ( !empty($record->habitat) ) { if ( $record->habitat !== 0 ) $habitat = Wording::find($record->habitat)->name_en; }
        if ( !empty($record->start_depth) ) $depth = $record->start_depth;
        if ( !empty($record->start_depth) && !empty($record->end_depth) ) $depth .= ' - '; else $depth = ' - ';
        if ( !empty($record->end_depth) ) $depth .= $record->end_depth;
        if ( !empty($record->locality) ) $locality = $record->locality; else $locality = ' - ';
        if ( !empty($record->province) ) $province = Province::find($record->province)->province_en; else $province = ' - ';
        if ( !empty($record->country) ) $country = Country::find($record->country)->country_en; else $country = ' - ';

        $collector = ' - ';
        if ( !empty($record->collector) ) $collector = $record->collector;
        $collectedDate = ' - ';
        if ( !empty($record->collected_date) && $record->collected_date !== '0000-00-00' ) $collectedDate = date('d/m/Y', strtotime($record->collected_date));
        $donatedFrom = ' - ';
        if ( !empty($record->donated_from) ) $donatedFrom = Wording::find($record->donated_from)->name_en;
        $identifier = ' - ';
        if ( !empty($record->identifier) ) $identifier = $record->identifier;
        $identifiedDate = ' - ';
        if ( !empty($record->identified_date) && $record->identified_date !== '0000-00-00' ) $identifiedDate = date('d/m/Y', strtotime($record->identified_date));
        $depositedAt = ' - ';
        if ( !empty($record->deposited_at) ) $depositedAt = Wording::find($record->deposited_at)->name_en;
        $noteCollector = ' - ';
        if ( !empty($record->note_collector) ) $noteCollector = $record->note_collector;

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
                            line-height: 5px;
                            font-size: 13px;
                        }
                        div.cut {
                            /* border: 1px dashed #000; */
                            width: 743px;
                            height: 475px;
                            margin-top: 0px;
                            margin-left: -20px;
                            padding-top: 5px;
                        }
                        div.cut.line-cut {
                            position: absolute;
                            top: 0;
                            left: 0;
                            border: 1px dashed #000;
                        }
                        p.header , p.sub-header {
                            text-align: center;
                        }
                        p.header {
                            font-size: 25px;
                            font-weight: 900;
                            margin-top: 25px;
                            margin-bottom: -15px;
                        }
                        p.sub-header {
                            font-size: 20px;
                            margin-bottom: 20px;
                        }
                        table.main-data > tr > td {
                            vertical-align: top;
                            padding: 0px;
                        }
                        p.label {
                            font-weight: 900;
                            margin-top: 10px;
                            margin-bottom: 10px;
                        }
                        p.label > span.data {
                            font-weight: 500;
                            line-height: 6px;
                            margin-right: 10px;
                            margin-left: 5px;
                        }
                        tr.line-top > td {
                            border-top: 1px solid #000;
                        }
                        tr.line-bottom > td {
                            border-bottom: 1px solid #000;
                        }
                        td.column-center {
                            border-right: 1px solid #000;
                            border-left: 1px solid #000;
                            padding-left: 10px;
                        }
                    </style>
                    </head><body>';
        $html .= '<div class="cut">';
        $html .= '<p class="label" style="position:absolute; top: 8px; right:0px;">ID <span class="data">...'.$relatedCatalogItem.'...</span></p>';
        $html .= '<p class="header">REGISTRATION CARD</p>';
        $html .= '<p class="sub-header">FOR REFERENCE COLLECTION</p>';
        $html .= '<table class="main-data" border="0" padding="0" cellspacing="0" width="92%" align="center" style="margin-top: -10px;">';
        $html .= '<tr class="line-top line-bottom">
                    <td width="26%" valign="top">
                        <p class="label">Phylum <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$phylum.'</span>&nbsp;</p>
                    </td>
                    <td width="37%" valign="top" class="column-center">
                        <p class="label">Institution <span class="data">'.$institution.'</span></p>
                        <p class="label">Marinecenter <span class="data">'.$marineCenterCode.'</span></p>
                    </td>
                    <td width="37%" valign="top" style="padding-left: 10px;">
                        <p class="label">Previous Scientific Name <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$previousScientificName.'</span>&nbsp;</p>
                    </td>
                </tr>';
        $html .= '<tr class="line-bottom">
                    <td width="26%" valign="top">
                        <p class="label">Class <span class="data">'.$class.'</span></p>
                    </td>
                    <td width="40%" valign="top" class="column-center">
                        <p class="label">Order <span class="data">'.$order.'</span></p>
                    </td>
                    <td width="34%" valign="top" style="padding-left: 10px;">
                        <p class="label">Family <span class="data">'.$family.'</span></p>
                    </td>
                </tr>';
        $html .= '<tr class="line-bottom">
                    <td valign="top" colspan="3">
                        <p class="label">Species <span class="data">'.$species.'</span></p>
                    </td>
                </tr>';
        $html .= '</table>';
        $html .= '<table class="main-data" border="0" padding="0" cellspacing="0" width="92%" align="center">';
        $html .= '<tr class="line-bottom">
                    <td width="33%" valign="top">
                        <p class="label">Type <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$type.'</span>&nbsp;</p>
                    </td>
                    <td width="33%" valign="top" class="column-center">
                        <p class="label">No. of Spec. <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$individualCount.'</span>&nbsp;</p>
                    </td>
                    <td width="34%" valign="top" style="padding-left: 10px;">
                        <p class="label">Habitat <span class="data">'.$habitat.'</span></p>
                        <p class="label">Depth <span class="data">'.$depth.'</span></p>
                    </td>
                </tr>';
        $html .= '<tr class="line-bottom">
                    <td valign="top" colspan="3">
                        <p class="label">Locality <span class="data" style="line-height: 9px;">'.$locality.'</span> Province <span class="data">'.$province.'</span> Country <span class="data">'.$country.'</span></p>
                    </td>
                </tr>';
        $html .= '<tr class="line-bottom">
                    <td width="33%" valign="top">
                        <p class="label">Collector <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$collector.'</span>&nbsp;</p>
                    </td>
                    <td width="33%" valign="top" class="column-center">
                        <p class="label">Date <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$collectedDate.'</span>&nbsp;</p>
                    </td>
                    <td width="34%" valign="top" style="padding-left: 10px;">
                        <p class="label">Donated from <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$donatedFrom.'</span>&nbsp;</p>
                    </td>
                </tr>';
        $html .= '<tr class="line-bottom">
                    <td width="33%" valign="top">
                        <p class="label">Identifier <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$identifier.'</span>&nbsp;</p>
                    </td>
                    <td width="33%" valign="top" class="column-center">
                        <p class="label">Date <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$identifiedDate.'</span>&nbsp;</p>
                    </td>
                    <td width="34%" valign="top" style="padding-left: 10px;">
                        <p class="label">Deposite At <span class="data">&nbsp;</span></p>
                        <p class="label"><span class="data" style="margin-left: 0px;">'.$depositedAt.'</span>&nbsp;</p>
                    </td>
                </tr>';
        $html .= '<tr>
                    <td valign="top" colspan="3">
                        <p class="label">Notes <span class="data" style="line-height: 9px;">'.$noteCollector.'</span></p>
                    </td>
                </tr>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '<div class="cut line-cut"></div>';
        $html .= '</body></html>';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'portrait');
        $pdf->loadHTML($html, 'UTF-8');
        return $pdf->stream();
    }
}
