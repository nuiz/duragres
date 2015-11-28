<?php
namespace Main\Middleware;

use Slim\Middleware;
use Main\Auth\Auth;

class AuthMiddleware extends Middleware {
	private $auth;
	public function call(){
		$this->app->hook('slim.before.dispatch', [$this, 'onBeforeDispatch']);
		$this->next->call();
	}

	public function onBeforeDispatch(){
		$uri = $this->app->request()->getPathInfo();
		$currentRoute = $this->app->router()->getCurrentRoute();
		if(in_array($currentRoute->getName(), ['login', 'post_login'])) {
			return;
		}

		$user = $this->getAuth()->getUserSession();
		if(!$user) {
			$this->app->redirect($this->app->urlFor('login'));
		}

		$this->app->view()->getInstance()->assign('userlogin', $user);
	}

	public function getAuth(){
		if(is_null($this->auth)){
			$this->auth = new Auth();
		}
		return $this->auth;
	}
}
