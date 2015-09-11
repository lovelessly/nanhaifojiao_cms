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

class ApiController extends Controller {

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
		$data = array(1,2,3,4);
		$view = view('loginindex');
		$view->with('username', Session::get('User_Name'));
		view()->share('data', $data);	
		return $view;
		//return view('loginindex');
	}

	//获取一级菜单接口
	public function getMenu(){
		$MenuModel = new Menu();
		$ret = $MenuModel->getByIsParents(1);
		$Jsonp = new Jsonp();
		$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret));
		echo $Jsonp->toJsonp($a);
	}

	//更新指定MenuID的菜单信息
	public function getUpdatemenubymenuid(){
		
		//检查是否有后台权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}
		
		//菜单表操作
		$MenuModel = new Menu();
		$MenuName = Request::input('MenuName', false);
		$MenuDesc = Request::input('MenuDesc', false);
		$MenuID =  Request::input('MenuID', 0);
		if(!$MenuName && !$MenuDesc){
			$res = false;
		}else{
			$res = $MenuModel->updateByMenuID($MenuID, $MenuName, $MenuDesc);
		}

		$Jsonp = new Jsonp();
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful Update!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Update Faild', 'data' => array(), 'Msg' => ''));
			echo $Jsonp->toJsonp($a);
		}

	}

	//获取子菜单接口
	public function getSubmenu(){
		$MenuModel = new Menu();
		$ParentsID = Request::input('ParentsID');
		$ret = $MenuModel->getByParentsID($ParentsID);
		$Jsonp = new Jsonp();
		$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret));	
		echo $Jsonp->toJsonp($a);
	}

	public function getTest(){
		$MaterialsModel = new Materials();
		$ret = $MaterialsModel->getByContentType(2);
		echo json_encode($ret);
	}

	//获取所有素材
	public function getMaterials(){
		$MaterialsModel = new Materials();
		$ret = $MaterialsModel->getAll();
		$Jsonp = new Jsonp();
		$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret));
		echo $Jsonp->toJsonp($a);
	}

	//获取素材内容接口，根据类型
	public function getMaterialsbytype(){
		$MaterialsType = Request::input('MaterialsType', 0);
		$MaterialsModel = new Materials();
		$ret = $MaterialsModel->getByContentType($MaterialsType);
		$Jsonp = new Jsonp();
		$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret));
		echo $Jsonp->toJsonp($a);
	}

	//获取素材内容接口，一级菜单ID
	public function getMaterialsbyfirstlevel(){
		$MenuID = Request::input('MenuID', 0);
		$MaterialsModel = new Materials();
		$ret = $MaterialsModel->getByFirstLevelID($MenuID);
		$Jsonp = new Jsonp();
		$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret));
		echo $Jsonp->toJsonp($a);
	}

	//获取素材内容接口，二级菜单ID
	public function getMaterialsbysecondlevel(){
		$MenuID = Request::input('MenuID', 0);
		$MaterialsModel = new Materials();
		$ret = $MaterialsModel->getBySecondLevelID($MenuID);
		$Jsonp = new Jsonp();
		$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret));
		echo $Jsonp->toJsonp($a);
	}

	//获取所有用户数据
	public function getUsers(){
		$UserModel = new User();
		$Jsonp = new Jsonp();
		$ret = $UserModel->getUserByIsAdmin(0);
		if($ret){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $ret, 'Msg' => 'Successful Get!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Get Faild', 'data' => array()));
			echo $Jsonp->toJsonp($a);
		}
	}

	//登出接口
	public function getLogout(){
		$UserModel = new User();
		$Jsonp = new Jsonp();
		$ret = $UserModel->logout();
		if($ret){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful Logout!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Logout Faild', 'data' => array()));
			echo $Jsonp->toJsonp($a);
		}
	}

	//登录接口
	public function getLogin(){

		$username = Request::input('username');
		$password = Request::input('password');
		$debug = Request::input('debug', 0);

		$UserModel = new User();
		$Jsonp = new Jsonp();

		//暂时Mock，拼接后的加密验证串需要前端直接传给后端，不需要后端处理
		$tk = Session::get('tk');
		if(empty($tk)){
			Session::put('tk', sha1(time()));
		}
		$SessionToken = Session::get('tk');
		$password = sha1(sha1($password) . $SessionToken);
		//End of Mock
		
		$ret = $UserModel->login($username, $password, $SessionToken);

		if($ret){	
			$data = Session::all();
			unset($data['tk']);
			//debug 开关
			if(0 == $debug){
				$data = array();
			}
			//array to Json(Jsonp)
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $data));
			echo $Jsonp->toJsonp($a);
		}else{
			//array to Json(Jsonp)
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Login Faild', 'data' => ''));
			echo $Jsonp->toJsonp($a);
		}

	}

	public function postLogin(){

		$username = Request::input('username');
		$password = Request::input('password');
		$debug = Request::input('debug', 0);

		$UserModel = new User();
		$Jsonp = new Jsonp();

		$SessionToken = Session::get('tk');
		
		$ret = $UserModel->login($username, $password, $SessionToken);

		if($ret){	
			$data = Session::all();
			unset($data['tk']);
			//debug 开关
			if(0 == $debug){
				$data = array();
			}
			//array to Json(Jsonp)
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $data));
			echo $Jsonp->toJsonp($a);
		}else{
			//array to Json(Jsonp)
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Login Faild', 'data' => ''));
			echo $Jsonp->toJsonp($a);
		}

	}

	//新增素材接口
	public function getNewmaterials(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();
		$Content = "'''''''#$%^&*()<><><><><><>_";
		$Url = 'url';
		$Title = 'title';
		$Type = '3';
		$FirstLevel = '1';
		$SecondLevel = '0';
		$res = $MaterialsModel->insertNewMaterials($Content, $Url, $Title, $Type, $FirstLevel, $SecondLevel);
		$Jsonp = new Jsonp();
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful Insert!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Insert Faild', 'data' => array(), 'Msg' => ''));
			echo $Jsonp->toJsonp($a);
		}

	}

	//删除一条素材
	public function getDelmaterials(){
		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();
		$ContentID = Request::input('Content_ID');
		$res = $MaterialsModel->deleteMaterials($ContentID);
		$Jsonp = new Jsonp();
		if(!Request::ajax()){
			return redirect()->back();
			//return redirect('admin/image');
		}
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful delete!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Delete Faild', 'data' => array(), 'Msg' => ''));
			echo  $Jsonp->toJsonp($a);
		}
	}

	//添加一条新闻
	public function postNewsinsert(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();

		$Content = Request::input('Content');
		$Title = Request::input('Title');
		$FirstLevel = Request::input('FirstLevel');
		$SecondLevel = Request::input('SecondLevel');

		$res = $MaterialsModel->insertNews($Content, $Title, $FirstLevel, $SecondLevel);

		$Jsonp = new Jsonp();
		
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful Insert!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Insert Faild', 'data' => array(), 'Msg' => ''));
			echo  $Jsonp->toJsonp($a);
		}
	}

	//修改一条新闻
	public function postNewsupdate(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();

		$ContentID = Request::input('ContentID');
		$Content = Request::input('Content');
		$Title = Request::input('Title');
		$FirstLevel = Request::input('FirstLevel');
		$SecondLevel = Request::input('SecondLevel');

		$res = $MaterialsModel->updateMaterials($ContentID, $Content, '', $Title, 3, $FirstLevel, $SecondLevel);

		$Jsonp = new Jsonp();
		
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful update!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Update Faild', 'data' => array(), 'Msg' => ''));
			echo  $Jsonp->toJsonp($a);
		}
	}

	//添加一条活动
	public function postActivityinsert(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();

		$Content = Request::input('Content');
		$Title = Request::input('Title');
		$FirstLevel = Request::input('FirstLevel');
		$SecondLevel = Request::input('SecondLevel');

		$res = $MaterialsModel->insertActivity($Content, $Title, $FirstLevel, $SecondLevel);

		$Jsonp = new Jsonp();
		
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful Insert!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Insert Faild', 'data' => array(), 'Msg' => ''));
			echo  $Jsonp->toJsonp($a);
		}
	}

	//修改一条活动
	public function postActivityupdate(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$MaterialsModel = new Materials();

		$ContentID = Request::input('ContentID');
		$Content = Request::input('Content');
		$Title = Request::input('Title');
		$FirstLevel = Request::input('FirstLevel');
		$SecondLevel = Request::input('SecondLevel');

		$res = $MaterialsModel->updateMaterials($ContentID, $Content, '', $Title, 4, $FirstLevel, $SecondLevel);

		$Jsonp = new Jsonp();
		
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful update!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Update Faild', 'data' => array(), 'Msg' => ''));
			echo  $Jsonp->toJsonp($a);
		}
	}

	//删除一个用户
	public function getDeluser(){
		//检查是否登录，是否有权限
		$UserModel = new User();
		$auth = $UserModel->checkAdmin();
		if(!$auth){
			return redirect('admin/index');
		}

		$UserID = Request::input('User_ID');
		$res = $UserModel->deleteUser($UserID);
		$Jsonp = new Jsonp();
		if(!Request::ajax()){
			return redirect()->back();
		}
		if($res){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Successful delete!!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Delete Faild', 'data' => array(), 'Msg' => ''));
			echo  $Jsonp->toJsonp($a);
		}
	}


}
