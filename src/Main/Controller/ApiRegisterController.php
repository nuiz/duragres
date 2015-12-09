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
		echo json_encode($response, JSON_UNESCAPED_SLASHES);
		exit();
	}

	public function login()
	{
		$attr = $this->slim->request->post();

		if(empty($attr['email'])) {
			$this->response(['error'=> 'REQUIRE_EMAIL']);
			return;
		}

		$account = R::findOne('account', 'email=?', [$attr['email']]);
		if(empty($account)) {
			$this->response(['error'=> 'NOT_FOUND_EMAIL']);
			return;
		}

		header('Content-Type: application/json');
		echo json_encode($account->getProperties(), JSON_UNESCAPED_SLASHES);
		exit();
	}

	public function response($response)
	{
		header('Content-Type: application/json');
		echo json_encode($response, JSON_UNESCAPED_SLASHES);
		exit();
	}
}
