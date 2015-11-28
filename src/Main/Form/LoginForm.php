<?php
namespace Main\Form;

use Main\Auth\Auth;

class LoginForm extends Form {
	private $user;
	public function validate(){
		$attr = $this->attr;

		if(empty($attr['username'])){
			$this->pushError("กรุณาใส่ username");
			return false;
		}
		if(empty($attr['password'])){
			$this->pushError("กรุณาใส่ password");
			return false;
		}

		$auth = new Auth();
		$user = $auth->auth($attr['username'], $attr['password']);
		
		if(!$user){
			$this->pushError($auth->getError());
			return false;
		}
		$this->user = $user;
		return true;
	}

	public function getUser(){
		return $this->user;
	}
}