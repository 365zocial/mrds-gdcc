<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Request;

use Auth;
use Session;

use App\Model\Record;
use App\Model\Taxonomy;
use App\Model\Classification;
use App\Model\Header_Taxonomy;
use App\Model\Wording;
use App\Model\Country;
use App\Model\Province;
use App\Model\District;
use App\Model\County;

class SearchReportController extends Controller
{

    public function dashboard()
    {
    	return view('staff.search_report.dashboard');
    }

    public function taxonomy()
    {
        $data['year'] = null;
    	return view('staff.search_report.taxonomy', $data);
    }

    public function searchTaxonomy(Request $requests)
    {
        $records = Record::select('id');

        $year = $requests->year;
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $data[] = ['Move', 'Density'];

        // check role
        if ( Auth::user()->role_id == 3 ) { //manager
            // get marine center
            $marinecenter_id = Auth::user()->marinecenter_id;
            foreach ($months as $i => $month) {
                $monthID = $i+1;
                if(strlen($monthID)===1) $monthID = '0'.$monthID;
                $data[] = [$month, count(Record::where('collected_year', $year)->where('collected_month', $monthID)->where('record.marinecenter_id', $marinecenter_id)->where('approve_status', 1)->where('status', 2)->groupBy('unique_record')->get())];
            }
        } else {    //admin and board
            foreach ($months as $i => $month) {
                $monthID = $i+1;
                if(strlen($monthID)===1) $monthID = '0'.$monthID;
                $data[] = [$month, count(Record::where('collected_year', $year)->where('collected_month', $monthID)->where('approve_status', 1)->where('status', 2)->groupBy('unique_record')->get())];
            }
        }

        return view('staff.search_report.taxonomy', compact('data', 'year'));
    }

    public function biogeography()
    {
        $taxonomy = null;
        $taxonomy['header_taxonomys'] = Header_Taxonomy::getHeaderTaxonomyListOrderByLevel();

        $taxonomy['domains'] = Taxonomy::getDomain();

        $taxonomy['kingdoms'] = Taxonomy::getKingdom();
        $taxonomy['subkingdoms'] = Taxonomy::getSubkingdom();
        $taxonomy['infrakingdoms'] = Taxonomy::getInfrakingdom();

        $taxonomy['phylums'] = Taxonomy::getPhylum();
        $taxonomy['subphylums'] = Taxonomy::getSubphylum();
        $taxonomy['infraphylums'] = Taxonomy::getInfraphylum();

        $taxonomy['superclasses'] = Taxonomy::getSuperclass();
        $taxonomy['classes'] = Taxonomy::getClass();
        $taxonomy['subclasses'] = Taxonomy::getSubclass();
        $taxonomy['infraclasses'] = Taxonomy::getInfraclass();

        $taxonomy['superorders'] = Taxonomy::getSuperorder();
        $taxonomy['orders'] = Taxonomy::getOrder();
        $taxonomy['suborders'] = Taxonomy::getSuborder();
        $taxonomy['infraorders'] = Taxonomy::getInfraorder();

        $taxonomy['superfamilys'] = Taxonomy::getSuperfamily();
        $taxonomy['familys'] = Taxonomy::getFamily();
        $taxonomy['subfamilys'] = Taxonomy::getSubfamily();

        $taxonomy['genuses'] = Taxonomy::getGenus();
        $taxonomy['subgenuses'] = Taxonomy::getSubgenus();

        $taxonomy['specieses'] = Taxonomy::getSpecies();
        // $taxonomy['species'] = Classification::getClassificationListEnableSearchReport();
        $taxonomy['subspecieses'] = Taxonomy::getSubspecies();

        // return view('staff.search_report.biogeography_v2', compact('taxonomy'));
    	return view('staff.search_report.biogeography', $taxonomy);
    }

    public function searchBiogeography(Request $requests)
    {

        $result = null;
        $taxonomyFilter = null;

        $input = $requests->all();
        unset($input['_token']);
        $input = array_filter($input);

        $header_taxa_id = $input['header_taxonomy_id'];
        unset($input['header_taxonomy_id']);

        $reinput = $this->reinputForView($input);
        $reinputJson = json_encode($this->reinputForReport($input));

        $header_taxa_name = Header_Taxonomy::find($header_taxa_id);
        $key = strtolower($header_taxa_name->name);

        // dd($input[$key.'_id']);
        $taxonomyFilter[$key] = $input[$key];

        // foreach ($input as $key => $get) {
        //     $taxonomyFilter[$key] = $get;
        // }

        // get role
        $user_role = Auth::user()->role_id;
        // get marine center
        $marinecenter_id = Auth::user()->marinecenter_id;

        // get ocean_sea_lake
        $result['ocean_sea_lake']['name']   = 'Ocean Sea';
        if ( Auth::user()->role_id == 3 ) { //manager
            $result['ocean_sea_lake']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('name_en as name', 'name_th')
                ->where('record.marinecenter_id', $marinecenter_id)
                ->join('wording', 'record.ocean_sea_lake', '=', 'wording.id')
                ->groupBy('ocean_sea_lake')
                ->orderBy('name_en')
                ->get();
        } else {    //admin and board
            $result['ocean_sea_lake']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('name_en as name', 'name_th')
                ->join('wording', 'record.ocean_sea_lake', '=', 'wording.id')
                ->groupBy('ocean_sea_lake')
                ->orderBy('name_en')
                ->get();
        }

        // get country
        $result['country']['name']   = 'Country';
        if ( Auth::user()->role_id == 3 ) { //manager
            $result['country']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('country_en as name', 'country_th as name_th')
                ->where('record.marinecenter_id', $marinecenter_id)
                ->join('country', 'record.country', '=', 'country.id')
                ->groupBy('country')
                ->orderBy('country_en')
                ->get();
        } else {    //admin and board
            $result['country']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('country_en as name', 'country_th as name_th')
                ->join('country', 'record.country', '=', 'country.id')
                ->groupBy('country')
                ->orderBy('country_en')
                ->get();
        }

        // get province
        $result['province']['name']   = 'Province';
        if ( Auth::user()->role_id == 3 ) { //manager
            $result['province']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('province_en as name', 'province_th as name_th')
                ->where('record.marinecenter_id', $marinecenter_id)
                ->join('province', 'record.province', '=', 'province.id')
                ->groupBy('province')
                ->orderBy('province_en')
                ->get();
        } else {    //admin and board
            $result['province']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('province_en as name', 'province_th as name_th')
                ->join('province', 'record.province', '=', 'province.id')
                ->groupBy('province')
                ->orderBy('province_en')
                ->get();
        }

        // get district
        $result['district']['name']   = 'District';
        if ( Auth::user()->role_id == 3 ) { //manager
            $result['district']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('district_en as name', 'district_th as name_th')
                ->where('record.marinecenter_id', $marinecenter_id)
                ->join('district', 'record.district', '=', 'district.id')
                ->groupBy('district')
                ->orderBy('district_en')
                ->get();
        } else {    //admin and board
            $result['district']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('district_en as name', 'district_th as name_th')
                ->join('district', 'record.district', '=', 'district.id')
                ->groupBy('district')
                ->orderBy('district_en')
                ->get();
        }

        // get county
        $result['county']['name']   = 'County';
        if ( Auth::user()->role_id == 3 ) { //manager
            $result['county']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('county_en as name', 'county_th as name_th')
                ->where('record.marinecenter_id', $marinecenter_id)
                ->join('county', 'record.county', '=', 'county.id')
                ->groupBy('county')
                ->orderBy('county_en')
                ->get();
        } else {    //admin and board
            $result['county']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('county_en as name', 'county_th as name_th')
                ->join('county', 'record.county', '=', 'county.id')
                ->groupBy('county')
                ->orderBy('county_en')
                ->get();
        }

        // get locality
        $result['locality']['name']   = 'Locality';
        if ( Auth::user()->role_id == 3 ) { //manager
            $result['locality']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->select('locality as name')
                ->where('language_id', 1)
                ->where('record.marinecenter_id', $marinecenter_id)
                ->whereNotIn('locality', [' ',''])
                ->groupBy('locality')
                ->orderBy('locality')
                ->get();
        } else {    //admin and board
            $result['locality']['list']   = $this->biogeographyFilter($taxonomyFilter)
                ->leftJoin('record as record2', 'record.unique_record', '=', 'record2.unique_record')
                ->select('record.locality as name', 'record2.locality as name_th')
                ->where('record.language_id', 1)
                ->where('record2.language_id', 2)
                ->whereNotIn('record.locality', [' ',''])
                ->groupBy('record.locality')
                ->orderBy('record.locality')
                ->get();
        }

        // count record
        $result['ocean_sea_lake']['count']  = count($result['ocean_sea_lake']['list']);
        $result['country']['count']  = count($result['country']['list']);
        $result['province']['count']  = count($result['province']['list']);
        $result['district']['count']  = count($result['district']['list']);
        $result['county']['count']  = count($result['county']['list']);
        $result['locality']['count']  = count($result['locality']['list']);
        Session::put('search_biogeography', json_encode($input) );

        return view('staff.search_report.show_biogeography', compact('result', 'search', 'reinput', 'reinputJson'));

    }

    public function biogeographyFilter($taxonomyFilter)
    {
        if($taxonomyFilter === null)
            return Classification::join('record', 'classification.id', '=', 'record.classification_id')->where('record.approve_status', 1)->where('record.status', 2);
        else
            return Classification::join('record', 'classification.id', '=', 'record.classification_id')->where('record.approve_status', 1)->where('record.status', 2)->where($taxonomyFilter);
    }

    public function diversity()
    {
        $taxonomy = null;
        $taxonomy['header_taxonomys'] = Header_Taxonomy::getHeaderTaxonomyListOrderByLevel();

        $taxonomy['domains'] = Taxonomy::getDomain();

        $taxonomy['kingdoms'] = Taxonomy::getKingdom();
        $taxonomy['subkingdoms'] = Taxonomy::getSubkingdom();
        $taxonomy['infrakingdoms'] = Taxonomy::getInfrakingdom();

        $taxonomy['phylums'] = Taxonomy::getPhylum();
        $taxonomy['subphylums'] = Taxonomy::getSubphylum();
        $taxonomy['infraphylums'] = Taxonomy::getInfraphylum();

        $taxonomy['superclasses'] = Taxonomy::getSuperclass();
        $taxonomy['classes'] = Taxonomy::getClass();
        $taxonomy['subclasses'] = Taxonomy::getSubclass();
        $taxonomy['infraclasses'] = Taxonomy::getInfraclass();

        $taxonomy['superorders'] = Taxonomy::getSuperorder();
        $taxonomy['orders'] = Taxonomy::getOrder();
        $taxonomy['suborders'] = Taxonomy::getSuborder();
        $taxonomy['infraorders'] = Taxonomy::getInfraorder();

        $taxonomy['superfamilys'] = Taxonomy::getSuperfamily();
        $taxonomy['familys'] = Taxonomy::getFamily();
        $taxonomy['subfamilys'] = Taxonomy::getSubfamily();

        $taxonomy['genuses'] = Taxonomy::getGenus();
        $taxonomy['subgenuses'] = Taxonomy::getSubgenus();

        $taxonomy['specieses'] = Taxonomy::getSpecies();
        // $taxonomy['species'] = Classification::getClassificationListEnableSearchReport();
        $taxonomy['subspecieses'] = Taxonomy::getSubspecies();

        $taxonomy['ocean_sea_lake'] = Wording::getWordingByWordingType(3);
        $taxonomy['country'] = Country::getCountryList();
        $taxonomy['province'] = Province::getProvinceList();

        $taxonomy['district'] = District::getDistrictList();
        $taxonomy['county'] = County::getCountyList();

    	return view('staff.search_report.diversity', $taxonomy);
    }



    public function searchDiversity(Request $requests)
    {
        $result = null;
        $filter = null;

        $input = $requests->all();
        $locality = $requests->locality;
        unset($input['_token']);

        $input = array_filter($input);

        $header_taxa_id = $input['header_taxonomy_id'];
        unset($input['header_taxonomy_id']);
        unset($input['locality_type']);

        $reinput = $this->reinputForView($input);
        $reinputJson = json_encode($this->reinputForReport($input));

        $header_taxa_name = Header_Taxonomy::find($header_taxa_id);
        $key = strtolower($header_taxa_name->name);

        foreach ($input as $key => $get) {
            if($key == "order") $key = "order_o";
            if($key!=='locality') $filter[$key] = $get;
        }

        // get role
        $user_role = Auth::user()->role_id;
        // get marine center
        $marinecenter_id = Auth::user()->marinecenter_id;

        if ( Auth::user()->role_id == 3 ) { //manager
            $result['phylum']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.phylum', '=', 'taxonomy.id')
                                                    ->groupBy('phylum')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['class']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.class', '=', 'taxonomy.id')
                                                    ->groupBy('class')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['order']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.order_o', '=', 'taxonomy.id')
                                                    ->groupBy('order_o')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['family']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.family', '=', 'taxonomy.id')
                                                    ->groupBy('family')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['species']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.species', '=', 'taxonomy.id')
                                                    ->groupBy('species')
                                                    ->orderBy('classification.current_scientific_name')
                                                    ->get();
        } else {    //admin and board
            $result['phylum']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.phylum', '=', 'taxonomy.id')
                                                    ->groupBy('phylum')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['class']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.class', '=', 'taxonomy.id')
                                                    ->groupBy('class')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['order']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.order_o', '=', 'taxonomy.id')
                                                    ->groupBy('order_o')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['family']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.family', '=', 'taxonomy.id')
                                                    ->groupBy('family')
                                                    ->orderBy('taxonomy.name')
                                                    ->get();
            $result['species']['list']   = $this->diversityFilter($filter, $locality)
                                                    ->select('current_scientific_name as name')
                                                    ->where('record.marinecenter_id', $marinecenter_id)
                                                    ->join('taxonomy', 'classification.species', '=', 'taxonomy.id')
                                                    ->groupBy('species')
                                                    ->orderBy('classification.current_scientific_name')
                                                    ->get();
        }

        // count record
        $result['phylum']['count']  = count($result['phylum']['list']);
        $result['class']['count']  = count($result['class']['list']);
        $result['order']['count']  = count($result['order']['list']);
        $result['family']['count']  = count($result['family']['list']);
        $result['species']['count']  = count($result['species']['list']);
        Session::put('search_diversity', json_encode($input) );

        return view('staff.search_report.show_diversity', compact('result', 'reinput', 'reinputJson'));
    }

    public function diversityFilter($filter, $locality)
    {
        $classification = Classification::join('record', 'classification.id', '=', 'record.classification_id')->where('language_id', 1);
        if($filter !== null)
            $classification = $classification->where($filter);

        if($locality === null)
            return $classification;
        else
            return $classification->where('locality', 'LIKE', '%'.$locality.'%');
    }

    public function getCountryToCounty($method, $id)
    {
        $get = null;
        if ( $method === '1' ) { // Country Selected
            $get = Province::getProvinceEnableInCountry($id);
        } elseif ( $method === '2' ) { // Privince Selected
            $get = District::getDistrictEnableInProvince($id);
        } elseif ( $method === '3' ) { // District Selected
            $get = County::getCountyEnableInDistrict($id);
        }

        return $get;
    }

    public function countByPlace()
    {
        $dropdown['ocean_sea_lake'] = Wording::getWordingByWordingType(3);
        $dropdown['country']        = Country::getCountryList();
        $dropdown['province']       = Province::getProvinceList();
        $dropdown['district']       = District::getDistrictList();
        $dropdown['county']         = County::getCountyList();

    	return view('staff.search_report.count_by_place', compact('dropdown'));
    }

    public function searchCountByPlace($type, $id)
    {
        $result = null;
        $result = $this->biogeographyFilter(null)->where('approve_status', 1)->where('record.status', 2)->groupBy('unique_record');

        // get role
        $user_role = Auth::user()->role_id;
        // get marine center
        $marinecenter_id = Auth::user()->marinecenter_id;

        if( $type === 'locality' ) {
            if( $id !== '0' ) { $result = $result->where($type, 'LIKE', '%'.$id.'%'); }
        } else {
            if( $id !== '0' ) { $result = $result->where($type, $id); }
        }

        if ( Auth::user()->role_id == 3 ) { //manager
            $result = $result->where('record.marinecenter_id', $marinecenter_id)->get();
        } else {    //admin and board
            $result = $result->get();
        }

        $result = count($result);

        return $result;
    }

    public function reinputForView($input)
    {
        $reinput = null;
        foreach ($input as $key => $get) {
            $key = str_replace('order_o', 'Order', $key);
            $newKey = str_replace(' ', '/', ucwords(str_replace('_', ' ', $key)));
            $reinput[] = array($newKey=>$this->getData($newKey, $get));
        }
        return $reinput;
    }

    public function reinputForReport($input)
    {
        $reinput = null;
        foreach ($input as $key => $get) {
            $key = str_replace('order_o', 'Order', $key);
            $newKey = str_replace(' ', '/', ucwords(str_replace('_', ' ', $key)));
            $reinput[] = $newKey.' : '.$this->getData($newKey, $get);
        }
        return $reinput;
    }

    public function getData($attribute, $id)
    {
        $taxonomyHeader = array(
                    'Domain',
                    'Kingdom', 'Subkingdom', 'Infrakingdom',
                    'Phylum', 'Subphylum', 'Infraphylum',
                    'Superclass', 'Class', 'Subclass', 'Infraclass',
                    'Superorder', 'Order', 'Suborder', 'Infraorder',
                    'Superfamily', 'Family', 'Subfamily',
                    'Genus', 'Species', 'Subgenus', 'Subspecies'
                );
        if ( in_array($attribute, $taxonomyHeader) ) {

            if( in_array($attribute, ['Subgenus', 'Subspecies']) ){
                return strtolower(Taxonomy::find($id)->name);
            }

            if( in_array($attribute, ['Genus', 'Species', 'Subgenus', 'Subspecies']) ){
                return "<i>".Taxonomy::find($id)->name."</i>";
            }

            return Taxonomy::find($id)->name;
        // } else if ( $attribute === 'Species' ) {
        //     return Classification::find($id)->current_scientific_name;
        } else if ( $attribute === 'Ocean/Sea/Lake' ) {
            return Wording::find($id)->name_en;
        } else if ( $attribute === 'Country' ) {
            return Country::find($id)->country_en;
        } else if ( $attribute === 'Province' ) {
            return Province::find($id)->province_en;
        } else if ( $attribute === 'District' ) {
            return District::find($id)->district_en;
        } else if ( $attribute === 'County' ) {
            return County::find($id)->county_en;
        } else if ( $attribute === 'Locality' ) {
            return $id;
        }
    }

}
