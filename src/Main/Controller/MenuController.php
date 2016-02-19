<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\MenuForm;

class MenuController extends BaseController {
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('menu', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('menu');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);
		$this->slim->render("menu/list.php", ['items'=> $items, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function edit($id)
	{
		$item = R::findOne('menu', 'id=?', [$id]);
		$this->slim->render("menu/add.php", ['form'=> new MenuForm($item->export())]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();
		$attr['picture'] = new \upload($_FILES['picture']);

		$attr['id'] = $id;
		$form = new MenuForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/menu');
		}
		else {
			echo $this->goBack(); exit();
		}
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
