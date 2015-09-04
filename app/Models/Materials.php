<?php

namespace App\Models;

use DB;
use Session;
use App\Models\Menu;
use Config;

date_default_timezone_set('PRC'); 

Class Materials {

	public function __construct(){

		//需要配置主域
		$this->domain = Config::get('app.domain');

		//菜单对应关系map
		$MenuModel = new Menu();
		$tmp_1 = $MenuModel->getByIsParents(1);
		$tmp_2 = $MenuModel->getByIsParents(0);
		$tmp = array();
		foreach($tmp_1 as $menu){
			$tmp[$menu['Menu_ID']] = $menu['Menu_Name'];
		}
		foreach($tmp_2 as $menu){
			$tmp[$menu['Menu_ID']] = $menu['Menu_Name'];
		}
		$tmp[0] = '未配置菜单';
		$this->menu_map = $tmp;
		unset($tmp);
		unset($tmp_1);
		unset($tmp_2);

	}

	//首页展现数据
	public function getEachTypeCount(){
		$imagecount = intval(DB::table('materials')->where('Content_type', '=', 1)->count());
		$videocount = intval(DB::table('materials')->where('Content_type', '=', 2)->count());
		$newscount = intval(DB::table('materials')->where('Content_type', '=', 3)->count());
		$accountcount = intval(DB::table('user')->where('isAdmin', '=', 0)->count());
		$ret = array('AllImageCount'=>$imagecount, 'AllVideoCount' => $videocount, 'AllNewsCount'=>$newscount, 'AllUserCount'=>$accountcount);
		return $ret;
	}
	//返回所有素材--debug用
	public function getAll(){
		$ret = array();
		$materials = DB::table('materials')->get();
		foreach($materials as $obj){
			array_push($ret, (array)$obj);
		}
		return $ret;
	}

	//根据内容类型获取
	public function getByContentType($ContentType, $page = 1, $length = 20){
		$ret = array();
		$count = DB::table('materials')->where('Content_type', '=', $ContentType)->count();
		$materials = DB::table('materials')->where('Content_type', '=', $ContentType)->orderBy('Create_Time', 'desc')->skip(($page-1)*$length)->take($length)->get();
		foreach($materials as $obj){
			$tmp = (array)$obj;
			$tmp['FirstLevelName'] = $this->menu_map[$tmp['FirstLevel']];
			$tmp['SecondLevelName'] = $this->menu_map[$tmp['SecondLevel']];
			array_push($ret, $tmp);
		}
		$totalpage = ceil($count/$length);
		$ret = array('currentpage'=>$page, 'elements_per_page' => $length, 'totalpage'=>$totalpage, 'data'=>$ret);
		return $ret;
	}

	//根据ContentID获取单条信息
	public function getByContentID($ContentID){
		$ret = array();
		$materials = DB::table('materials')->where('Content_ID', '=', $ContentID)->get();
		foreach($materials as $obj){
			$tmp = (array)$obj;
			$tmp['FirstLevelName'] = $this->menu_map[$tmp['FirstLevel']];
			$tmp['SecondLevelName'] = $this->menu_map[$tmp['SecondLevel']];
			array_push($ret, $tmp);
			unset($tmp);
		}
		$ret = array('currentpage'=> 1, 'elements_per_page' => 1, 'totalpage'=> 1, 'data'=>$ret);
		return $ret;
	}

	//根据所属一级菜单ID获取
	public function getByFirstLevelID($MenuID, $page = 1, $length = 20){
		$ret = array();
		$count = DB::table('materials')->where('FirstLevel', '=', $MenuID)->count();
		$materials = DB::table('materials')->where('FirstLevel', '=', $MenuID)->orderBy('Create_Time', 'desc')->skip(($page-1)*$length)->take($length)->get();
		foreach($materials as $obj){
			array_push($ret, (array)$obj);
		}
		$totalpage = ceil($count/$length);
		$ret = array('currentpage'=>$page, 'elements_per_page' => $length, 'totalpage'=>$totalpage, 'data'=>$ret);
		return $ret;
	}

	//根据所属二级菜单ID获取
	public function getBySecondLevelID($MenuID, $page = 1, $length = 20){
		$ret = array();
		$count = DB::table('materials')->where('SecondLevel', '=', $MenuID)->count();
		$materials = DB::table('materials')->where('SecondLevel', '=', $MenuID)->orderBy('Create_Time', 'desc')->skip(($page-1)*$length)->take($length)->get();
		foreach($materials as $obj){
			array_push($ret, (array)$obj);
		}
		$totalpage = ceil($count/$length);
		$ret = array('currentpage'=>$page, 'elements_per_page' => $length, 'totalpage'=>$totalpage, 'data'=>$ret);
		return $ret;
	}

	//添加一条新的素材
	public function insertNewMaterials($Content, $Url, $Title, $Type, $FirstLevel, $SecondLevel){
		$create_time = strftime("%Y-%m-%d %H:%M:%S", time());
		$data_array = array(
			'Content' => $Content,
			'Materials_Url' => $this->domain . $Url,
			'Title' => $Title,
			'Content_type' => $Type,
			'Poster' => Session::get('User_Name', 'Somebody'),
			'FirstLevel' => $FirstLevel,
			'SecondLevel' => $SecondLevel,
			'Create_Time' => $create_time,
			'Update_Time' => $create_time,
			);
		$ret = DB::table('materials')->insert($data_array);
		return $ret;
	}

	//删除一条记录
	public function deleteMaterials($ContentID){
		$ContentID = intval($ContentID);
		$ret = DB::table('materials')->where('Content_ID', '=', $ContentID)->delete();
		return $ret;
	}

	//修改一条记录
	public function updateMaterials($Content_ID, $Content, $Url, $Title, $Type, $FirstLevel, $SecondLevel){
		$ContentID = intval($Content_ID);
		$Update_Time = strftime("%Y-%m-%d %H:%M:%S", time());
		$data_array = array(
			'Content' => $Content,
			'Materials_Url' => $this->domain . $Url,
			'Title' => $Title,
			'Content_type' => $Type,
			'Poster' => Session::get('User_Name', 'Somebody'),
			'FirstLevel' => $FirstLevel,
			'SecondLevel' => $SecondLevel,
			'Update_Time' => $Update_Time,
		);
		if(false === $Url){
			unset($data_array['Materials_Url']);
		};
		if(-1 === $Type){
			unset($data_array['Content_type']);
		}
		$ret = DB::table('materials')->where('Content_ID', '=', $ContentID)->update($data_array);
		return $ret;
	}

	//添加一条新的新闻
	public function insertNews($Content, $Title, $FirstLevel, $SecondLevel){
		$create_time = strftime("%Y-%m-%d %H:%M:%S", time());
		$data_array = array(
			'Content' => $Content,
			'Materials_Url' => '',
			'Title' => $Title,
			'Content_type' => 3,
			'Poster' => Session::get('User_Name', 'Somebody'),
			'FirstLevel' => $FirstLevel,
			'SecondLevel' => $SecondLevel,
			'Create_Time' => $create_time,
			'Update_Time' => $create_time,
			);
		$ret = DB::table('materials')->insert($data_array);
		return $ret;
	}

}

?>
