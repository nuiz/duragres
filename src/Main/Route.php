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

		$this->slim->get('/product', 'Main\Controller\ProductController:index');
		$this->slim->get('/product/add', 'Main\Controller\ProductController:add');
		$this->slim->post('/product/add', 'Main\Controller\ProductController:post_add');
		$this->slim->get('/product/edit/:id', 'Main\Controller\ProductController:edit');
		$this->slim->post('/product/edit/:id', 'Main\Controller\ProductController:post_edit');
		$this->slim->get('/product/delete/:id', 'Main\Controller\ProductController:delete');

		$this->slim->get('/contactdealer', 'Main\Controller\ContactdealerController:index');
		$this->slim->get('/contactdealer/add', 'Main\Controller\ContactdealerController:add');
		$this->slim->post('/contactdealer/add', 'Main\Controller\ContactdealerController:post_add');
		$this->slim->get('/contactdealer/edit/:id', 'Main\Controller\ContactdealerController:edit');
		$this->slim->post('/contactdealer/edit/:id', 'Main\Controller\ContactdealerController:post_edit');
		$this->slim->get('/contactdealer/delete/:id', 'Main\Controller\ContactdealerController:delete');

		$this->slim->get('/ecatalog', 'Main\Controller\ECatalogController:index');
		$this->slim->get('/ecatalog/add', 'Main\Controller\ECatalogController:add');
		$this->slim->post('/ecatalog/add', 'Main\Controller\ECatalogController:post_add');
		$this->slim->get('/ecatalog/edit/:id', 'Main\Controller\ECatalogController:edit');
		$this->slim->post('/ecatalog/edit/:id', 'Main\Controller\ECatalogController:post_edit');
		$this->slim->get('/ecatalog/delete/:id', 'Main\Controller\ECatalogController:delete');

		$this->slim->get('/room', 'Main\Controller\RoomController:index');
		$this->slim->get('/room/add', 'Main\Controller\RoomController:add');
		$this->slim->post('/room/add', 'Main\Controller\RoomController:post_add');
		$this->slim->get('/room/edit/:id', 'Main\Controller\RoomController:edit');
		$this->slim->post('/room/edit/:id', 'Main\Controller\RoomController:post_edit');
		$this->slim->get('/room/delete/:id', 'Main\Controller\RoomController:delete');

		$this->slim->get('/room/:room_id/pattern', 'Main\Controller\RoomPatternController:index');
		$this->slim->get('/room/:room_id/pattern/add', 'Main\Controller\RoomPatternController:add');
		$this->slim->post('/room/:room_id/pattern/add', 'Main\Controller\RoomPatternController:post_add');
		$this->slim->get('/room/:room_id/pattern/edit/:id', 'Main\Controller\RoomPatternController:edit');
		$this->slim->post('/room/:room_id/pattern/edit/:id', 'Main\Controller\RoomPatternController:post_edit');
		$this->slim->get('/room/:room_id/pattern/delete/:id', 'Main\Controller\RoomPatternController:delete');

		$this->slim->get('/menu', 'Main\Controller\MenuController:index');
		$this->slim->get('/menu/edit/:id', 'Main\Controller\MenuController:edit');
		$this->slim->post('/menu/edit/:id', 'Main\Controller\MenuController:post_edit');

		$this->slim->get('/stat', 'Main\Controller\StatController:index');

		// api
		$this->slim->get('/api/news', 'Main\Controller\ApiNewsController:index');
		$this->slim->get('/api/news/:id', 'Main\Controller\ApiNewsController:get');

		$this->slim->get('/api/product', 'Main\Controller\ApiProductController:index');
		$this->slim->get('/api/product/:id', 'Main\Controller\ApiProductController:get');
		$this->slim->get('/api/product/addview/:id', 'Main\Controller\ApiProductController:addView');

		$this->slim->get('/api/contactdealer', 'Main\Controller\ApiContactdealerController:index');
		$this->slim->get('/api/contactdealer/:id', 'Main\Controller\ApiContactdealerController:get');

		$this->slim->get('/api/ecatalog', 'Main\Controller\ApiECatalogController:index');
		$this->slim->get('/api/ecatalog/:id', 'Main\Controller\ApiECatalogController:get');

		$this->slim->get('/api/menu', 'Main\Controller\ApiMenuController:index');
		$this->slim->get('/api/menu/:id', 'Main\Controller\ApiMenuController:get');

		$this->slim->post('/api/register', 'Main\Controller\ApiRegisterController:index');
		$this->slim->post('/api/login', 'Main\Controller\ApiRegisterController:login');

		$this->slim->get('/api/account/delete', 'Main\Controller\ApiAccountController:delete');
		$this->slim->post('/api/account/delete', 'Main\Controller\ApiAccountController:delete');

		$this->slim->get('/api/account/product', 'Main\Controller\ApiAccountController:product');
		$this->slim->post('/api/account/product/add', 'Main\Controller\ApiAccountController:addProduct');
		$this->slim->get('/api/account/product/delete/:product_id', 'Main\Controller\ApiAccountController:deleteProduct');

		$this->slim->get('/api/room', 'Main\Controller\ApiRoomController:index');
		$this->slim->get('/api/room/:id', 'Main\Controller\ApiRoomController:get');

		$this->slim->get('/api/pattern', 'Main\Controller\ApiPatternController:index');
		$this->slim->get('/api/pattern/:id', 'Main\Controller\ApiPatternController:get');
	}
}
