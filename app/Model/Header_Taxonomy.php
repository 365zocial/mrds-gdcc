<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Header_Taxonomy extends Model
{
    protected $table = 'header_taxonomy';

    public static function HeaderTaxonomyList() {
    	return Header_Taxonomy::get();
    }

    public static function getHeaderTaxonomy($id) {
    	$word = Header_Taxonomy::where('id', $id)->first();
    	return $word->name;
    }

    public static function getHeaderTaxonomyListOrderByLevel() {
    	return Header_Taxonomy::orderBy('level', 'asc')->get();
    }

}
