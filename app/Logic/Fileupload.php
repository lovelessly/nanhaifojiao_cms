<?php

namespace App\Logic;
use Session;
use Request;

Class Fileupload {

	public function __construct(){
		$this->time = strftime("%Y%m%d", time());
		$this->imagedir = dirname(__FILE__) . '/../../public/Upload/' . $this->time . '/Media';
	}

	public function FileStorage($file){

		if(empty($file) || !$file->isValid()){
			return false;
		}

		$mimetype = $file->getClientMimeType();
		$maxsize = $file->getMaxFilesize();
		$imagename = time() . '.' . $file->guessClientExtension();

		$file->move($this->imagedir, $imagename);

		$filepath = '/Upload/' . $this->time . '/Media/' . $imagename;
		$ret_data = array();
		$ret_data['filepath'] = $filepath;
		$ret_data['filetype'] = $mimetype;
		$ret_data['size'] = $maxsize;
		return $ret_data;
	}
}

?>
