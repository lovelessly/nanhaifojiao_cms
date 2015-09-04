<?php
namespace App\Models;
use Session;
use Request;

Class Jsonp {
	public function toJsonp($input_json){
		$callback = Request::input('callback');
		if(!empty($callback)){
			echo $callback . '(' . $input_json . ')';
		}else{
			echo $input_json;
		}
	}
}

?>
