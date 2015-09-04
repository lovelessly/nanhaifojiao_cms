<?php 
namespace App\Http\Controllers;

use App\Db;
use Session;
use App\Models\User;
use App\Models\Jsonp;
use App\Models\Materials;
use App\Logic\Fileupload;
use Request;

class FileController extends Controller {

	public function __construct()
	{
		$this->imagedir = dirname(__FILE__) . '/../../../public/Upload/image';
	}

	public function postMediaupload(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$UserModel->checkAdmin();

		$file = Request::file('file');

		//需要post 描述，标题，所属一级菜单，所属二级菜单，四个参数，均有默认值
		$Content = urldecode(Request::input('Content', '默认内容'));
		$Title = urldecode(Request::input('Title', '默认标题'));
		$FirstLevel = Request::input('FirstLevel', 0);
		$SecondLevel = Request::input('SecondLevel', 0);

		$Uploader = new Fileupload();
		$Materials = new Materials();
		$Jsonp = new Jsonp();

		$Poster = Session::get('User_Name');

		//返回路径名称，如果出错，返回false
		$filestatus = $Uploader->FileStorage($file);
		if(!$filestatus){
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Upload Faild', 'data' => array(), 'Msg' => ''));
			echo $Jsonp->toJsonp($a);
			die;
		}

		$Url = $filestatus['filepath'];
		//默认类型为0，依据上传文件类型自动判定所属type
		$Type = 0;
		if(0 === strpos($filestatus['filetype'], 'image')){
			$Type = 1;
		}else if(0 === strpos($filestatus['filetype'], 'video') or 0 === strpos($filestatus['filetype'], 'audio')){
			$Type = 2;
		}
		$ret = $Materials->insertNewMaterials($Content, $Url, $Title, $Type, $FirstLevel, $SecondLevel);
		if($ret){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => $filestatus, 'Msg' => 'Uploaded!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Upload Faild', 'data' => array(), 'Msg' => ''));
			echo $Jsonp->toJsonp($a);
		}
	}

	public function postMediaupdate(){

		//检查是否登录，是否有权限
		$UserModel = new User();
		$UserModel->checkAdmin();

		$file = Request::file('file');

		//需要post 素材ID， 描述，标题，所属一级菜单，所属二级菜单，四个参数，均有默认值
		$Content_ID = urldecode(Request::input('ContentID', '默认内容'));
		$Content = urldecode(Request::input('Content', '默认内容'));
		$Title = urldecode(Request::input('Title', '默认标题'));
		$FirstLevel = Request::input('FirstLevel', 0);
		$SecondLevel = Request::input('SecondLevel', 0);

		$Uploader = new Fileupload();
		$Materials = new Materials();
		$Jsonp = new Jsonp();

		$Poster = Session::get('User_Name');

		//返回路径名称，如果出错，返回false
		$sig = 0;
		if(!Request::hasFile('file') || !Request::file('file')->isValid()){
			$sig = 1;
		}else{
			$filestatus = $Uploader->FileStorage($file);
			if(!$filestatus){
				$a = json_encode(array('status' => -1, 'errorMsg' => 'Update Faild', 'data' => array(), 'Msg' => ''));
				echo $Jsonp->toJsonp($a);
				die;
			}
		}
		if(0 == $sig){
			$Url = $filestatus['filepath'];
			//默认类型为0，依据上传文件类型自动判定所属type
			$Type = 0;
			if(0 === strpos($filestatus['filetype'], 'image')){
				$Type = 1;
			}else if(0 === strpos($filestatus['filetype'], 'video') or 0 === strpos($filestatus['filetype'], 'audio')){
				$Type = 2;
			}
			$ret = $Materials->updateMaterials($Content_ID, $Content, $Url, $Title, $Type, $FirstLevel, $SecondLevel);
		}else{
			$Url = false;
			$Type = -1;
			$ret = $Materials->updateMaterials($Content_ID, $Content, $Url, $Title, $Type, $FirstLevel, $SecondLevel);
		}

		if($ret){
			$a = json_encode(array('status' => 0, 'errorMsg' => '', 'data' => array(), 'Msg' => 'Updated!'));
			echo $Jsonp->toJsonp($a);
		}else{
			$a = json_encode(array('status' => -1, 'errorMsg' => 'Update Faild', 'data' => array(), 'Msg' => ''));
			echo $Jsonp->toJsonp($a);
		}
	}


}
