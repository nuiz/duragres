<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\NewsForm;

class NewsController extends BaseController {
	public function index(){
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('news', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('news');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
		$this->slim->render("news/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add(){
		$this->slim->render("news/add.php", ['form'=> new newsForm()]);
	}

	public function post_add(){
		$attr = $this->slim->request->post();
		$form = new newsForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/news');
		}
		else {
			$this->slim->render("news/add.php", ['form'=> $form]);
		}
	}

	public function edit($id){
		$item = R::findOne('news', 'id=?', [$id]);
		$this->slim->render("news/add.php", ['form'=> new newsForm($item->export())]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();
		$attr['id'] = $id;
		$form = new newsForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/news');
		}
		else {
			$this->slim->render("news/add.php", ['form'=> $form]);
		}
	}

	public function delete($id){
		$item = R::findOne('news', 'id=?', [$id]);
		R::trash($item);
		$this->slim->redirect($this->slim->request()->getRootUri().'/news');
	}
}
