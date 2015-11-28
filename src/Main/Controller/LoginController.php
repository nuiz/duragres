<?php
namespace Main\Controller;

use Main\Form\LoginForm;

class LoginController extends BaseController {
	public function index(){
		$this->slim->render("login.php");
	}

	public function post(){
		$attr = $this->slim->request->post();
		$loginForm = new LoginForm($attr);
		if($loginForm->validate()){
			$user = $loginForm->getUser();
			$this->slim->redirect($this->slim->request()->getRootUri().'/news');
		}
		else {
			$this->slim->render("login.php", ['loginForm'=> $loginForm]);
		}
	}
}
