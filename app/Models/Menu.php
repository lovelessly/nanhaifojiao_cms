<?php

namespace App\Models;

use DB;
use Session;

date_default_timezone_set('PRC'); 

Class Menu {

	public function updateByMenuID($MenuID, $MenuName, $MenuDesc){
		$ret = false;
		$menu = DB::table('menu')->where('Menu_ID', '=', $MenuID)->update(array('Menu_Name' => $MenuName, 'Menu_desc' => $MenuDesc));
		if($menu){
			$ret = true;
		}
		return $ret;	
	}

	public function getByIsParents($isParents){
		$ret = array();
		$menu = DB::table('menu')->where('isParents', '=', $isParents)->get();
		foreach($menu as $obj){
			array_push($ret, (array)$obj);
		}
		return $ret;
	}

	public function getByParentsID($ParentsID){
		$ret = array();
		$menu = DB::table('menu')->where('Parents_ID', '=', $ParentsID)->get();
		foreach($menu as $obj){
			array_push($ret, (array)$obj);
		}
		return $ret;
	}

}

?>
