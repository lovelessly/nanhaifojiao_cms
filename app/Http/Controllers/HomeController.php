<?php 
namespace App\Http\Controllers;

use App\Db;
use Session;
use App\Models\User;
use App\Models\Jsonp;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
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
		return view('home');
	}

	public function getTest(){
		$UserModel = new User();
		$ret = $UserModel->login();
		//var_dump($ret);
		$tmp = Session::get('isAdmin', 0);
		var_dump($tmp);
	}

	public function getLogin(){
		$UserModel = new User();
		$Jsonp = new Jsonp();
		$ret = $UserModel->login();
		//var_dump($ret);
		//$tmp = Session::get('isAdmin', 0);
		//var_dump($tmp);
		//$data = Session::all();
		//var_dump($data);

		$a = json_encode($data);
		echo $Jsonp->toJsonp($a);

	}

}
