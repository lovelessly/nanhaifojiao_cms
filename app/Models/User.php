<?php

namespace App\Models;

use DB;
use Session;
use App\Models\Jsonp;
use Request;

date_default_timezone_set('PRC'); 

Class User {

	//检查是否有后台管理权限
	public function checkAdmin(){
		//如果没有管理员权限，禁止对后台进行任何操作
		if(1 != Session::get('isAdmin') && Request::ajax()){
			$Jsonp = new Jsonp();
			$a = json_encode(array('status' => -1, 'errorMsg' => 'You have no Auth', 'data' => array(), 'Msg' => ''));
			echo $Jsonp->toJsonp($a);
			die;
		}elseif(1 != Session::get('isAdmin') && !Request::ajax()){
			return false;
		}else{
			return true;
		}
	}

	//登出接口
	public function logout(){
		Session::flush();
		if(Session::get('isLogin')){
			return false;
		}else{
			return true;
		}
	}

	//登录接口
	public function login($username, $password, $SessionToken){
		//Session::flush();
		//登陆前清理session中的垃圾数据
		//登录成功后数据存在Session中
		$tk = Session::get('tk');
		if(!empty($tk)){
			$tmp = Session::get('tk');
			Session::flush();
			Session::put('tk', $tmp);
			unset($tmp);
		}else{
			Session::flush();
		}
		$users = DB::table('user')->where('User_ID', '>', 0)->where('User_Name', '=', $username)->take(1)->get();
		//如果存在该用户
		if($users){
			$password_sha1 = $users[0]->password_sha1;
			$verify_password = sha1($password_sha1 . Session::get('tk'));
			//密码校验
			if($password == $verify_password){
				Session::put('User_Name', $users[0]->User_Name);
				Session::put('isAdmin', $users[0]->isAdmin);
				Session::put('User_ID', $users[0]->User_ID);
				Session::put('isLogin', true);
				Session::put('LoginTime', strftime("%Y-%m-%d %H:%M:%S", time()));
				return true;
			}else{
				return false;
			}
		//如果不存在该帐户
		}else{
			return false;
		}
	}

	public function getUserByIsAdmin($isAdmin, $page = 1, $length = 20){
		$count = DB::table('user')->where('isAdmin', '=', $isAdmin)->count();
		$users = DB::table('user')->where('isAdmin', '=', $isAdmin)->orderBy('User_ID')->skip(($page-1)*$length)->take($length)->get();
		$ret = array();
		foreach($users as $obj){
			array_push($ret, (array)$obj);
		}
		$totalpage = ceil($count/$length);
		$ret = array('currentpage'=>$page, 'elements_per_page' => $length, 'totalpage'=>$totalpage, 'data'=>$ret);
		return $ret;
	}

	public function deleteUser($User_ID) {
		$User_ID = intval($User_ID);
		$ret = DB::table('user')->where('User_ID', '=', $User_ID)->delete();
		return $ret;
	}

}

?>
