<?php
namespace Main\Controller;

use RedBeanPHP\R;
use Main\Form\ECatalogForm;

class ECatalogController extends BaseController
{
	public function index()
	{
		$perPage = 10;

		$page = @$_GET['page']? $_GET['page']: 1;
		$start = ($page-1) * $perPage;
		$items = R::find('ecatalog', 'LIMIT ?,?', [$start, $perPage]);
		$count = R::count('ecatalog');
		$maxPage = floor($count/$perPage) + ($count%$perPage == 0 ? 0: 1);

		$itemsExport = R::exportAll($items);
		$this->builds($itemsExport);

		$this->slim->render("ecatalog/list.php", ['items'=> $itemsExport, 'page'=> $page, 'maxPage'=> $maxPage]);
	}

	public function add()
	{
		$this->slim->render("ecatalog/add.php", ['form'=> new ECatalogForm()]);
	}

	public function post_add()
	{
		$attr = $this->slim->request->post();
		$attr['pdf'] = $_FILES['pdf'];

		$form = new ECatalogForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/ecatalog');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("ecatalog/add.php", ['form'=> $form]);
		}
	}

	public function edit($id)
	{
		$item = R::findOne('ecatalog', 'id=?', [$id]);
		$this->slim->render("ecatalog/add.php", ['form'=> new ECatalogForm($item->export())]);
	}

	public function post_edit($id){
		$attr = $this->slim->request->post();
		$attr['pdf'] = $_FILES['pdf'];

		$attr['id'] = $id;
		$form = new ECatalogForm($attr);
		if($form->validate()){
			$form->save();
			$this->slim->redirect($this->slim->request()->getRootUri().'/ecatalog');
		}
		else {
			echo $this->goBack(); exit();
			// $this->slim->render("ecatalog/add.php", ['form'=> $form]);
		}
	}

	public function delete($id)
	{
		$item = R::findOne('ecatalog', 'id=?', [$id]);
		R::trash($item);
		@unlink('upload/'.$item['pdf_path']);
		@unlink('upload/'.$item['cover_path']);
		$this->slim->redirect($this->slim->request()->getRootUri().'/ecatalog');
	}

	public function build(&$item)
	{
		$item['pdf_url'] = $this->getBaseUrl().'/upload/'.$item['pdf_path'];
		$item['cover_url'] = $this->getBaseUrl().'/upload/'.$item['cover_path'];
	}

	public function builds(&$items)
	{
		foreach($items as &$item) {
			$this->build($item);
		}
	}

	public function getBaseUrl()
	{
		$req = $this->slim->request;
		return $req->getUrl()."".$req->getRootUri();
	}

	public function goBack()
	{
		return <<<HTML
<script type="text/javascript">history.go(-1);</script>
HTML;
	}
}
