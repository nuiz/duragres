<?php
namespace Main\Controller;

class LogoutController extends BaseController {
	public function index(){
		unset($_SESSION['userlogin']);
		$this->slim->redirect($this->slim->request()->getRootUri().'/');
	}
}
