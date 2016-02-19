<?php

namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\EmployerForm;
use Main\Form\EmployerSearchForm;
use Main\Form\EmployerHistoryForm;
use Main\Auth\Auth;

class EmployerController extends BaseController {

	public function index()
	{
		$perPage = 10;

		$searchForm = new EmployerSearchForm($_GET);
		$searchForm->search();

		$items = $searchForm->getItems();
		$page = $searchForm->getPage();
		$maxPage = $searchForm->getMaxPage();

		$this->slim->render("employer/list.php", ['items'=> $items, 'searchForm'=> $searchForm, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add()
	{
		$this->slim->render("employer/add.php", ['form'=> new EmployerForm()]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();
		$form = new EmployerForm($attr);
		$auth = new Auth();
		$userlogin = $auth->getUserSession();
		if($form->validate()) {
			$form->save($userlogin->id);
			$this->slim->redirect($this->slim->request()->getRootUri().'/employer');
		}
		else {
			$this->slim->render("employer/add.php", ['form'=> $form]);
		}
	}

	public function edit($id)
	{
		$item = R::findOne('employer', 'id=?', [$id]);
		$this->slim->render("employer/add.php", ['form'=> new EmployerForm($item->export())]);
	}

	public function post_edit($id)
	{
		$attr = $this->slim->request->post();
		$attr['id'] = $id;
		$auth = new Auth();
		$form = new EmployerForm($attr);
		$userlogin = $auth->getUserSession();
		if($form->validate()) {
			$form->save($userlogin->id);
			$this->slim->redirect($this->slim->request()->getRootUri().'/employer');
		}
		else {
			$this->slim->render("employer/add.php", ['form'=> $form]);
		}
	}

	public function delete($id)
	{
		$item = R::findOne('employer', 'id=?', [$id]);
		R::trash($item);
		$this->slim->redirect($this->slim->request()->getRootUri().'/employer');
	}

	public function get($id)
	{
		$item = R::findOne('employer', 'id=?', [$id]);
		$item->histories = R::find('employer_history', 'employer_id=?', [$id]);
		$this->slim->render("employer/get.php", ["item"=> $item]);
	}

	// history

	public function add_history($employerId)
	{
		$this->slim->render("employer/history/add.php", ['form'=> new EmployerHistoryForm()]);
	}

	public function post_add_history($employerId)
	{
		$attr = $this->slim->request->post();
		$form = new EmployerHistoryForm($attr);
		if($form->validate()) {
			$form->save($employerId);
			$this->slim->redirect($this->slim->request()->getRootUri().'/employer/'.$employerId);
		}
		else {
			$this->slim->render("employer/history/add.php", ['form'=> $form]);
		}
	}
}
