<?php

namespace Main;
use Slim\Slim;
use Main\Controller\TestController;

class Route {
	private $slim;
	public function __construct(Slim $slim){
		$this->slim = $slim;
	}
	public function run(){
		$this->slim->get('/', 'Main\Controller\IndexController:index');

		$this->slim->get('/login', 'Main\Controller\LoginController:index')->name('login');
		$this->slim->post('/login', 'Main\Controller\LoginController:post')->name('post_login');
		$this->slim->get('/logout', 'Main\Controller\LogoutController:index');

		$this->slim->get('/news', 'Main\Controller\NewsController:index');
		$this->slim->get('/news/add', 'Main\Controller\NewsController:add');
		$this->slim->post('/news/add', 'Main\Controller\NewsController:post_add');
		$this->slim->get('/news/edit/:id', 'Main\Controller\NewsController:edit');
		$this->slim->post('/news/edit/:id', 'Main\Controller\NewsController:post_edit');
		$this->slim->get('/news/delete/:id', 'Main\Controller\NewsController:delete');
	}
}
