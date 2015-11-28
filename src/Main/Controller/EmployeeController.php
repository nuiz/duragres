<?php

namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\EmployeeForm;
use Main\Form\EmployeeSearchForm;
use Main\Auth\Auth;

class EmployeeController extends BaseController {

	public function index()
	{
		$perPage = 10;

		$searchForm = new EmployeeSearchForm($_GET);
		$searchForm->search();

		$items = $searchForm->getItems();
		$page = $searchForm->getPage();
		$maxPage = $searchForm->getMaxPage();

		$this->slim->render("employee/list.php", ['items'=> $items, 'searchForm'=> $searchForm, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add()
	{
		$this->slim->render("employee/add.php", ['form'=> new EmployeeForm()]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();
		$form = new EmployeeForm($attr);
		$auth = new Auth();
		$userlogin = $auth->getUserSession();
		if($form->validate()) {
			$form->save($userlogin->id);
			$this->slim->redirect($this->slim->request()->getRootUri().'/employee');
		}
		else {
			$this->slim->render("employee/add.php", ['form'=> $form]);
		}
	}

	public function edit($id){
		$item = R::findOne('employee', 'id=?', [$id]);
		$this->slim->render("employee/add.php", ['form'=> new EmployeeForm($item->export())]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();
		$attr['id'] = $id;
		$auth = new Auth();
		$form = new EmployeeForm($attr);
		$userlogin = $auth->getUserSession();
		if($form->validate()){
			$form->save($userlogin->id);
			$this->slim->redirect($this->slim->request()->getRootUri().'/employee');
		}
		else {
			$this->slim->render("employee/add.php", ['form'=> $form]);
		}
	}

	public function delete($id){
		$item = R::findOne('employee', 'id=?', [$id]);
		R::trash($item);
		$this->slim->redirect($this->slim->request()->getRootUri().'/employee');
	}
}
