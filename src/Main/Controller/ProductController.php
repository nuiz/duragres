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

		$where = [];
		$where[] = 1;
		$queryParam = [];
		if(!empty($_GET['type'])) {
			$where[] = "type = ?";
			$queryParam[] = $_GET['type'];
		}
		if(!empty($_GET['size'])) {
			$where[] = "size = ?";
			$queryParam[] = $_GET['size'];
		}
		if(!empty($_GET['style'])) {
			$where[] = "style = ?";
			$queryParam[] = $_GET['style'];
		}
		if(!empty($_GET['company'])) {
			$where[] = "company = ?";
			$queryParam[] = $_GET['company'];
		}

		$where = implode(" AND ", $where);
		$queryParam[] = $start;
		$queryParam[] = $perPage;
		$items = R::getAll('SELECT * FROM product WHERE '.$where.' ORDER BY is_hot DESC, is_new DESC, created_at DESC LIMIT ?,?', $queryParam);
		$count = R::count('product', $where, array_slice($queryParam, 0, -2));
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		$form = [];
		$form["type"] = @$_GET["type"]?: "";
		$form["size"] = @$_GET["size"]?: "";
		$form["style"] = @$_GET["style"]?: "";
		$form["company"] = @$_GET["company"]?: "";

		$this->slim->render("product/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage, 'form'=> $form]);
	}

	public function add()
	{
		$this->slim->render("product/add.php", ['form'=> new ProductForm()]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();
		$attr['picture'] = new \upload($_FILES['picture']);
		$attr['icon_1'] = new \upload($_FILES['icon_1']);
		$attr['icon_2'] = new \upload($_FILES['icon_2']);
		$attr['icon_3'] = new \upload($_FILES['icon_3']);
		$attr['icon_4'] = new \upload($_FILES['icon_4']);
		// $attr['thumb'] = new \upload($_FILES['thumb']);

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
		$attr['icon_1'] = new \upload($_FILES['icon_1']);
		$attr['icon_2'] = new \upload($_FILES['icon_2']);
		$attr['icon_3'] = new \upload($_FILES['icon_3']);
		$attr['icon_4'] = new \upload($_FILES['icon_4']);
		// $attr['thumb'] = new \upload($_FILES['thumb']);

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
		R::exec('DELETE FROM account_product WHERE product_id = ?', [$id]);
		@unlink('upload/'.$item['picture']);
		// @unlink('upload/'.$item['thumb']);
		$this->slim->redirect($this->slim->request()->getRootUri().'/product');
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
