<?php

class Zhangv {
	
	public function r(){
		Session::put('a', 'b');
		echo 1;die;
	}

}
