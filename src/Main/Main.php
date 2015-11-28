<?php

namespace Main;

use Slim\Slim;
use Main\Middleware\AuthMiddleware;
use RedBeanPHP\R;

class Main {
	private $slim, $route;
	public function run(){
		global $slim;

		$view = new \Slim\Views\Smarty();
		$view->parserExtensions = [
		    'vendor/slim/views/SmartyPlugins'
		];

		$this->slim = $slim = new Slim([
			'view' => $view,
			'templates.path'=> 'views'
			]);
		$this->slim->setName('um');
		R::setup('mysql:host=localhost;dbname=um', 'root', '');

		// add middleware
		$this->addMiddleware(new AuthMiddleware());

		$this->route = new Route($this->slim);
		$this->route->run();
		$this->slim->run();
	}

	public function addMiddleware(){
		$this->slim->add(new AuthMiddleware());
	}
}
