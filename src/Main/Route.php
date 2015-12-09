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

		$this->slim->get('/api/news', 'Main\Controller\ApiNewsController:index');
		$this->slim->get('/api/news/:id', 'Main\Controller\ApiNewsController:get');

		$this->slim->get('/product', 'Main\Controller\ProductController:index');
		$this->slim->get('/product/add', 'Main\Controller\ProductController:add');
		$this->slim->post('/product/add', 'Main\Controller\ProductController:post_add');
		$this->slim->get('/product/edit/:id', 'Main\Controller\ProductController:edit');
		$this->slim->post('/product/edit/:id', 'Main\Controller\ProductController:post_edit');
		$this->slim->get('/product/delete/:id', 'Main\Controller\ProductController:delete');

		$this->slim->get('/api/product', 'Main\Controller\ApiProductController:index');
		$this->slim->get('/api/product/:id', 'Main\Controller\ApiProductController:get');

		// api
		$this->slim->post('/api/register', 'Main\Controller\ApiRegisterController:index');
		$this->slim->post('/api/login', 'Main\Controller\ApiRegisterController:login');

		$this->slim->get('/api/account/delete/:token', 'Main\Controller\ApiAccountController:delete');
		$this->slim->post('/api/account/delete/:token', 'Main\Controller\ApiAccountController:delete');
	}
}
