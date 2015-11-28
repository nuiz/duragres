<?php
namespace Main\Auth;

use Slim\Slim;
use RedBeanPHP\R;

class Auth {
	private $error = false, $userlogin = null;
	public function __construct(){
		$this->makesureSessionStart();
	}
	public function getUserSession(){
		if(empty($_SESSION['userlogin'])){
			return false;
		}
		if(is_null($this->userlogin)){
			$this->userlogin = unserialize($_SESSION['userlogin']);
		}
		return $this->userlogin;
	}
	public function auth($username, $password){
		if($username != "admin") {
			$this->error = "wrong username";
			unset($_SESSION['userlogin']);
			return false;
		}
		if($password != "111111") {
			$this->error = "wrong password";
			unset($_SESSION['userlogin']);
			return false;
		}
		$this->userlogin = ['name'=> 'admin'];
		$_SESSION['userlogin'] = serialize($this->userlogin);
		return $this->userlogin;
	}
	public function makesureSessionStart(){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
	}
	public function getError(){
		return $this->error;
	}
}
