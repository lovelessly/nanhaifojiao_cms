<?php 
namespace App\Http\Controllers;

use App\Db;
use Session;
use App\Models\User;
use App\Models\Jsonp;
use App\Models\Materials;
use App\Models\Menu;
use Request;
use View;

class AdminController extends Controller {

	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$view = view('admin.index');
		$view->with('username', Session::get('User_Name'));
		return $view;
		//return view('loginindex');
	}

	//控制后台
	public function getConsole(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();
		$data = $MaterialsModel->getEachTypeCount();
		
		$showcount = 5;

		$newslist = $MaterialsModel->getByContentType(3, 1, $showcount);
		$newslist = $newslist['data'];
		$imagelist = $MaterialsModel->getByContentType(1, 1, $showcount);
		$imagelist = $imagelist['data'];

		$view = view('admin.console');
		$view->with('data', $data);
		$view->with('username', Session::get('User_Name'));
		$view->with('neweditlist', $newslist);
		$view->with('imagelist', $imagelist);
		return $view;
	}
/*
	public function getMenu(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$view = view('admin.menu');
		$view->with('username', Session::get('User_Name'));
		return $view;
	}
*/

	//图片列表
	public function getImage(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$Page = Request::input('Page', 1);
		$MenuModel = new Menu();
		$MaterialsModel = new Materials();

		$menulist = $MenuModel->getByIsParents(1);
		$menulist_sub = $MenuModel->getByParentsID(1);
		$imageall = $MaterialsModel->getByContentType(1, $Page, 10);

		if($Page > $imageall['totalpage'] && $imageall['totalpage'] !=0){
			return redirect('admin/image?Page=1');
		}

		$view = view('admin.image');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		$view->with('imagelist', $imageall['data']);
		$view->with('totalpage', $imageall['totalpage']);
		$view->with('currentpage', $Page);

		return $view;
	}

	//图片预览
	public function getImagepreview(){

		$ContentID = Request::input('ContentID', 0);

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth or $ContentID == 0){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();

		$imagedata = $MaterialsModel->getByContentID($ContentID);

		//echo json_encode($imagedata);die;
		$view = view('admin.materialpreview');
		$view->with('username', Session::get('User_Name'));
		$view->with('materialsdata', $imagedata['data'][0]);

		return $view;
	}

	//新闻管理
	public function getNews(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$Page = Request::input('Page', 1);
		$MenuModel = new Menu();
		$MaterialsModel = new Materials();

		$menulist = $MenuModel->getByIsParents(1);
		$menulist_sub = $MenuModel->getByParentsID(1);
		$newsall = $MaterialsModel->getByContentType(3, $Page, 10);

		if($Page > $newsall['totalpage'] && $newsall['totalpage'] !=0){
			return redirect('admin/news?Page=1');
		}

		$view = view('admin.news');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		$view->with('newslist', $newsall['data']);
		$view->with('totalpage', $newsall['totalpage']);
		$view->with('currentpage', $Page);

		return $view;
	}

	//活动管理
	public function getActivity(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$Page = Request::input('Page', 1);
		$MenuModel = new Menu();
		$MaterialsModel = new Materials();

		$menulist = $MenuModel->getByIsParents(1);
		$menulist_sub = $MenuModel->getByParentsID(1);
		$activityall = $MaterialsModel->getByContentType(4, $Page, 10);


		if($Page > $activityall['totalpage'] && $activityall['totalpage'] !=0){
			return redirect('admin/activity?Page=1');
		}

		$view = view('admin.activity');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		$view->with('activitylist', $activityall['data']);
		$view->with('totalpage', $activityall['totalpage']);
		$view->with('currentpage', $Page);

		return $view;
	}

	//视频列表
	public function getVideo(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$Page = Request::input('Page', 1);
		$MenuModel = new Menu();
		$MaterialsModel = new Materials();

		$menulist = $MenuModel->getByIsParents(1);
		$menulist_sub = $MenuModel->getByParentsID(1);
		$videoall = $MaterialsModel->getByContentType(2, $Page, 10);

		if($Page > $videoall['totalpage'] && $videoall['totalpage'] !=0){
			return redirect('admin/video?Page=1');
		}

		$view = view('admin.video');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		$view->with('imagelist', $videoall['data']);
		$view->with('totalpage', $videoall['totalpage']);
		$view->with('currentpage', $Page);

		return $view;	
	}

	//视频预览
	public function getVideopreview(){

		$ContentID = Request::input('ContentID', 0);

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth or $ContentID == 0){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();

		$imagedata = $MaterialsModel->getByContentID($ContentID);

		//echo json_encode($imagedata);die;
		$view = view('admin.materialpreview');
		$view->with('username', Session::get('User_Name'));
		$view->with('materialsdata', $imagedata['data'][0]);

		return $view;
	}

	//新闻新建编辑
	public function getEditnews(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();
		$MenuModel = new Menu();

		$menulist = $MenuModel->getByIsParents(1);
		$menulist_sub = $MenuModel->getByParentsID(1);

		$view = view('admin.editnews');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		
		return $view;
	}

	//新闻新建编辑
	public function getEditactivity(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();
		$MenuModel = new Menu();

		$menulist = $MenuModel->getByIsParents(1);
		$menulist_sub = $MenuModel->getByParentsID(1);

		$view = view('admin.editactivity');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		
		return $view;
	}

	//图片、视频编辑
	public function getMediadetail(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}
		
		$ContentID = Request::input('Content_ID', 0);
		$MaterialsModel = new Materials();
		$MenuModel = new Menu();

		$menulist = $MenuModel->getByIsParents(1);
		$MaterialsDetail = $MaterialsModel->getByContentID($ContentID);
		
		$ParentsID = intval($MaterialsDetail['data'][0]['FirstLevel']);
		if(0 === $ParentsID){
			$ParentsID = 1;
		}

		$menulist_sub = $MenuModel->getByParentsID($ParentsID);
		if(count($menulist_sub) === 0){
			$menulist_sub = array();
			array_push($menulist_sub, array('Menu_ID' => 0, 'Menu_Name' => '无需设置二级菜单'));
		}

		$view = view('admin.mediadetail');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);

		$view->with('materialsdata', $MaterialsDetail['data'][0]);
		return $view;
		//return redirect('admin/image');
	}

	//新闻编辑
	public function getNewsdetail(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$ContentID = Request::input('Content_ID', 0);

		$MaterialsModel = new Materials();
		$MenuModel = new Menu();

		$menulist = $MenuModel->getByIsParents(1);

		$MaterialsDetail = $MaterialsModel->getByContentID($ContentID);
		$ParentsID = intval($MaterialsDetail['data'][0]['FirstLevel']);
		if(0 === $ParentsID){
			$ParentsID = 1;
		}

		$menulist_sub = $MenuModel->getByParentsID($ParentsID);
		if(count($menulist_sub) === 0){
			$menulist_sub = array();
			array_push($menulist_sub, array('Menu_ID' => 0, 'Menu_Name' => '无需设置二级菜单'));
		}

		$view = view('admin.newsdetail');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		$view->with('materialsdata', $MaterialsDetail['data'][0]);
		
		return $view;
	}

	//活动信息编辑
	public function getActivitydetail(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$ContentID = Request::input('Content_ID', 0);

		$MaterialsModel = new Materials();
		$MenuModel = new Menu();

		$menulist = $MenuModel->getByIsParents(1);

		$MaterialsDetail = $MaterialsModel->getByContentID($ContentID);
		$ParentsID = intval($MaterialsDetail['data'][0]['FirstLevel']);
		if(0 === $ParentsID){
			$ParentsID = 1;
		}

		$menulist_sub = $MenuModel->getByParentsID($ParentsID);
		if(count($menulist_sub) === 0){
			$menulist_sub = array();
			array_push($menulist_sub, array('Menu_ID' => 0, 'Menu_Name' => '无需设置二级菜单'));
		}

		$view = view('admin.activitydetail');
		$view->with('username', Session::get('User_Name'));
		$view->with('menulist', $menulist);
		$view->with('submenulist', $menulist_sub);
		$view->with('materialsdata', $MaterialsDetail['data'][0]);
		
		return $view;
	}

	//新闻预览
	public function getNewspreview(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$ContentID = Request::input('Content_ID', 0);

		$MaterialsModel = new Materials();

		$MaterialsDetail = $MaterialsModel->getByContentID($ContentID);

		$view = view('admin.newspreview');
		$view->with('username', Session::get('User_Name'));
		$view->with('materialsdata', $MaterialsDetail['data'][0]);
		return $view;
	}

	//活动预览
	public function getActivitypreview(){

		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$ContentID = Request::input('Content_ID', 0);

		$MaterialsModel = new Materials();

		$MaterialsDetail = $MaterialsModel->getByContentID($ContentID);

		$view = view('admin.activitypreview');
		$view->with('username', Session::get('User_Name'));
		$view->with('materialsdata', $MaterialsDetail['data'][0]);
		return $view;
	}

	public function getLogout(){
		$UserModel = new User();
		$Jsonp = new Jsonp();
		$ret = $UserModel->logout();
		if($ret){
			return redirect('admin/index');
		}else{
			Session::flush();
			return redirect('admin/index');
		}
	}

	public function getLogin(){

		if(true == Session::get('isLogin')){
			return redirect('admin/console');
		}

		$tk = Session::get('tk');
		if(empty($tk)){
			Session::put('tk', sha1(time()));
		}
		
		$view = view('admin.login');
		return $view;
	}

	public function getAccount(){
		//权限控制
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$Page = Request::input('Page', 1);

		$UserModel = new User();
		$users = $UserModel->getUserByIsAdmin(0, $Page, 10);

		if($Page > $users['totalpage'] && $users['totalpage'] !=0){
			return redirect('admin/account?Page=1');
		}

		$view = view('admin.account');
		$view->with('username', Session::get('User_Name'));
		$view->with('userlist', $users['data']);
		$view->with('totalpage', $users['totalpage']);
		$view->with('currentpage', $Page);

		return $view;
	}
}
