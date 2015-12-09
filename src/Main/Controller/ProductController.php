<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\ProductForm;

class ProductController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('product', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('product');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
		$this->slim->render("product/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add()
	{
		$this->slim->render("product/add.php", ['form'=> new ProductForm()]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();
		$attr['picture'] = new \upload($_FILES['picture']);
		$attr['thumb'] = new \upload($_FILES['thumb']);

		$form = new ProductForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/product');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("news/add.php", ['form'=> $form]);
		}
	}

	public function edit($id)
	{
		$item = R::findOne('product', 'id=?', [$id]);
		$this->slim->render("product/add.php", ['form'=> new ProductForm($item->export())]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();
		$attr['picture'] = new \upload($_FILES['picture']);
		$attr['thumb'] = new \upload($_FILES['thumb']);

		$attr['id'] = $id;
		$form = new ProductForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/product');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("news/add.php", ['form'=> $form]);
		}
	}

	public function delete($id)
	{
		$item = R::findOne('product', 'id=?', [$id]);
		R::trash($item);
		@unlink('upload/'.$item['picture']);
		@unlink('upload/'.$item['thumb']);
		$this->slim->redirect($this->slim->request()->getRootUri().'/product');
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
