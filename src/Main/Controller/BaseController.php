<?php

namespace Main\Controller;

abstract class BaseController {
	public function __construct(){
		global $slim;
		$this->slim = $slim;
	}
}