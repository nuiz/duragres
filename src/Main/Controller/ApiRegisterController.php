<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\RegisterForm;

class ApiRegisterController extends BaseController {
	public function index()
	{
		$attr = $this->slim->request->post();
		$form = new RegisterForm($attr);

		if($form->validate()){
			$account = $form->save();
			$response = $account->getProperties();
		}
		else {
			$response = ['error'=> $form->error];
		}

		header('Content-Type: application/json');
		echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function login()
	{
		$attr = $this->slim->request->post();

		if(empty($attr['email'])) {
			//$this->response(['error'=> 'REQUIRE_EMAIL']);
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'REQUIRE_EMAIL'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		$account = R::findOne('account', 'email=?', [$attr['email']]);
		if(empty($account)) {
			//$this->response(['error'=> 'NOT_FOUND_EMAIL']);
			header('Content-Type: application/json');
			echo json_encode(['error'=> 'REQUIRE_EMAIL'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			exit();
		}

		header('Content-Type: application/json');
		echo json_encode($account->getProperties(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}

	public function response($response)
	{
		header('Content-Type: application/json');
		echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		exit();
	}
}
