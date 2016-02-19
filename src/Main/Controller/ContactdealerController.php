<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\ContactdealerForm;

class ContactdealerController extends BaseController
{
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('contactdealer', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('contactdealer');
		foreach($items as &$item) {
			$item->ownProvince = R::getRow('SELECT * FROM provinces WHERE province_id=?', [$item->province_id]);
			$item->ownGeography = R::getRow('SELECT * FROM geography WHERE geo_id=?', [$item->geo_id]);
			// var_dump($item); exit();
		}
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
		$this->slim->render("contactdealer/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add()
	{
		$provinces = R::getAll('SELECT * FROM provinces');
		$this->slim->render("contactdealer/add.php", ['form'=> new ContactdealerForm(), 'provinces'=> $provinces]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();

		$form = new ContactdealerForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/contactdealer');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("news/add.php", ['form'=> $form]);
		}
	}

	public function edit($id)
	{
		$item = R::findOne('contactdealer', 'id=?', [$id]);
		$provinces = R::getAll('SELECT * FROM provinces');
		$this->slim->render("contactdealer/add.php", ['form'=> new ContactdealerForm($item->export()), 'provinces'=> $provinces]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();

		$attr['id'] = $id;
		$form = new ContactdealerForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/contactdealer');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("news/add.php", ['form'=> $form]);
		}
	}

	public function delete($id)
	{
		$item = R::findOne('contactdealer', 'id=?', [$id]);
		R::trash($item);
		$this->slim->redirect($this->slim->request()->getRootUri().'/contactdealer');
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
